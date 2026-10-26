<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class SaleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        $sales = Sale::with(['user', 'items.product'])
            ->when(auth()->user()->isCustomer(), function ($query) {
                $query->where(function ($q) {
                    $q->where('user_id', auth()->id())
                      ->orWhere('customer_name', 'like', '%' . auth()->user()->name . '%')
                      ->orWhere('customer_name', 'Pelanggan Umum');
                });
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('sale_number', 'like', "%{$search}%")
                      ->orWhere('customer_name', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($fromDate, function ($query, $fromDate) {
                $query->whereDate('sold_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query, $toDate) {
                $query->whereDate('sold_at', '<=', $toDate);
            })
            ->latest('sold_at')
            ->paginate(10)
            ->withQueryString();

        return view('sales.index', compact('sales', 'search', 'status', 'fromDate', 'toDate'));
    }

    public function create(): View
    {
        $products = Product::where('stock', '>', 0)
            ->orderBy('name')
            ->get();

        return view('sales.create', compact('products'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:100'],
            'sold_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ], [
            'items.required' => 'Minimal harus menambahkan 1 item produk untuk penjualan.',
            'items.*.product_id.distinct' => 'Produk tidak boleh berulang pada satu transaksi penjualan.',
            'items.*.quantity.min' => 'Kuantitas penjualan minimal 1.',
        ]);

        $sale = DB::transaction(function () use ($validated, $request) {
            $saleNumber = $this->generateSaleNumber();

            $sale = Sale::create([
                'user_id' => Auth::id(),
                'sale_number' => $saleNumber,
                'customer_name' => $validated['customer_name'] ?: 'Pelanggan Umum',
                'total' => 0,
                'status' => 'completed',
                'sold_at' => Carbon::parse($validated['sold_at']),
                'notes' => $validated['notes'] ?? null,
            ]);

            $total = 0;

            foreach ($validated['items'] as $itemData) {
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
                $qty = (int) $itemData['quantity'];

                // Business Rule: Check stock sufficiency
                if ($qty < 1 || $product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$product->stock}, Diminta: {$qty}.",
                    ]);
                }

                // Business Rule: Price MUST be trusted from database, never from client input!
                $unitPrice = (float) $product->selling_price;
                $subtotal = $unitPrice * $qty;

                $sale->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $unitPrice,
                    'subtotal' => $subtotal,
                ]);

                // Atomically decrement stock
                $product->decrement('stock', $qty);

                $total += $subtotal;
            }

            $sale->update(['total' => $total]);

            return $sale;
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Transaksi penjualan ' . $sale->sale_number . ' berhasil diselesaikan dan stok telah dipotong.');
    }

    public function show(Sale $sale): View
    {
        $sale->load(['user', 'items.product.category']);
        return view('sales.show', compact('sale'));
    }

    public function invoice(Sale $sale): View
    {
        $sale->load(['user', 'items.product']);
        return view('sales.invoice', compact('sale'));
    }

    public function simulatePayment(Sale $sale): RedirectResponse
    {
        if ($sale->status === 'cancelled') {
            return back()->with('error', 'Pesanan yang telah dibatalkan tidak dapat diproses simulasinya.');
        }

        $sale->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'payment_ref' => $sale->payment_ref ?: ('SIM-' . strtoupper(bin2hex(random_bytes(4)))),
        ]);

        return redirect()->route('sales.invoice', $sale)
            ->with('success', 'Simulasi pembayaran berhasil! Transaksi kini berstatus Pembayaran Berhasil.');
    }

    public function cancel(Sale $sale): RedirectResponse
    {
        if ($sale->status === 'cancelled') {
            return back()->with('error', 'Transaksi penjualan ini sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($sale) {
            // Restore stock for all sold items
            foreach ($sale->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                $product->increment('stock', $item->quantity);
            }

            $sale->update(['status' => 'cancelled']);
        });

        return redirect()->route('sales.show', $sale)
            ->with('success', 'Transaksi penjualan ' . $sale->sale_number . ' berhasil dibatalkan dan seluruh stok produk telah dikembalikan.');
    }

    private function generateSaleNumber(): string
    {
        $dateStr = now()->format('Ymd');
        $prefix = "INV-{$dateStr}-";

        $last = Sale::where('sale_number', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->sale_number, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $nextNumber;
    }
}

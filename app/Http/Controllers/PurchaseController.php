<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $fromDate = $request->query('from_date');
        $toDate = $request->query('to_date');

        $purchases = Purchase::with(['supplier', 'user', 'items.product'])
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('purchase_number', 'like', "%{$search}%")
                      ->orWhereHas('supplier', function ($sq) use ($search) {
                          $sq->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($fromDate, function ($query, $fromDate) {
                $query->whereDate('purchased_at', '>=', $fromDate);
            })
            ->when($toDate, function ($query, $toDate) {
                $query->whereDate('purchased_at', '<=', $toDate);
            })
            ->latest('purchased_at')
            ->paginate(10)
            ->withQueryString();

        return view('purchases.index', compact('purchases', 'search', 'status', 'fromDate', 'toDate'));
    }

    public function create(): View
    {
        if (auth()->user()->isCustomer()) {
            abort(403, 'Akses Ditolak: Fitur pengadaan pembelian stok hanya dapat diakses oleh Staff Gudang atau Admin.');
        }

        $suppliers = Supplier::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('purchases.create', compact('suppliers', 'products'));
    }

    public function store(Request $request): RedirectResponse
    {
        if (auth()->user()->isCustomer()) {
            abort(403, 'Akses Ditolak: Fitur pengadaan pembelian stok hanya dapat diakses oleh Staff Gudang atau Admin.');
        }

        $validated = $request->validate([
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'purchased_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
        ], [
            'items.required' => 'Minimal harus menambahkan 1 item produk pembelian.',
            'items.*.product_id.distinct' => 'Produk tidak boleh berulang pada satu transaksi pembelian.',
            'items.*.quantity.min' => 'Kuantitas pembelian minimal 1.',
            'items.*.unit_cost.min' => 'Harga beli satuan tidak boleh bernilai negatif.',
        ]);

        $purchase = DB::transaction(function () use ($validated, $request) {
            $purchaseNumber = $this->generatePurchaseNumber();

            $purchase = Purchase::create([
                'supplier_id' => $validated['supplier_id'],
                'user_id' => Auth::id(),
                'purchase_number' => $purchaseNumber,
                'total' => 0,
                'status' => 'completed',
                'purchased_at' => Carbon::parse($validated['purchased_at']),
                'notes' => $validated['notes'] ?? null,
            ]);

            $total = 0;

            foreach ($validated['items'] as $itemData) {
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
                $qty = (int) $itemData['quantity'];
                $unitCost = (float) $itemData['unit_cost'];
                $subtotal = $qty * $unitCost;

                $purchase->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_cost' => $unitCost,
                    'subtotal' => $subtotal,
                ]);

                // Update product stock and update purchase price
                $product->increment('stock', $qty);
                $product->update(['purchase_price' => $unitCost]);

                $total += $subtotal;
            }

            $purchase->update(['total' => $total]);

            return $purchase;
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Transaksi pembelian ' . $purchase->purchase_number . ' berhasil disimpan dan stok produk telah ditambahkan.');
    }

    public function show(Purchase $purchase): View
    {
        $purchase->load(['supplier', 'user', 'items.product.category']);
        return view('purchases.show', compact('purchase'));
    }

    public function cancel(Purchase $purchase): RedirectResponse
    {
        if ($purchase->status === 'cancelled') {
            return back()->with('error', 'Transaksi pembelian ini sudah dalam status dibatalkan.');
        }

        DB::transaction(function () use ($purchase) {
            // First check if current stock is sufficient for cancellation
            foreach ($purchase->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                if ($product->stock < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cancel' => "Gagal membatalkan: Stok produk {$product->name} tersisa {$product->stock}, tidak cukup untuk dikurangi {$item->quantity} (sebagian stok mungkin telah terjual).",
                    ]);
                }
            }

            // Deduct stock and cancel
            foreach ($purchase->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item->product_id);
                $product->decrement('stock', $item->quantity);
            }

            $purchase->update(['status' => 'cancelled']);
        });

        return redirect()->route('purchases.show', $purchase)
            ->with('success', 'Transaksi pembelian berhasil dibatalkan dan stok produk telah disesuaikan kembali.');
    }

    private function generatePurchaseNumber(): string
    {
        $dateStr = now()->format('Ymd');
        $prefix = "PO-{$dateStr}-";

        $last = Purchase::where('purchase_number', 'like', "{$prefix}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->purchase_number, -4);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        return $prefix . $nextNumber;
    }
}

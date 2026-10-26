<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StorefrontController extends Controller
{
    /**
     * Display the aesthetic Bakery & Pastry storefront and catalog.
     */
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');

        $categories = Category::withCount('products')->orderBy('name')->get();

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->orderBy('stock', 'desc')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $featuredProducts = Product::with('category')
            ->where('stock', '>', 0)
            ->take(4)
            ->get();

        return view('storefront.index', compact('categories', 'products', 'featuredProducts', 'search', 'categoryId'));
    }

    /**
     * Customer Checkout from the Aesthetic Shopping Cart.
     * Uses atomic DB::transaction, locks product rows, calculates server total, and updates stock.
     */
    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'customer_phone' => ['nullable', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:500'],
            'payment_method' => ['nullable', 'string', 'in:qris,bank_transfer,cashier'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id', 'distinct'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ], [
            'items.required' => 'Keranjang belanja Anda masih kosong. Silakan pilih pastry lezat kami terlebih dahulu.',
            'customer_name.required' => 'Mohon cantumkan nama pemesan.',
            'items.*.quantity.min' => 'Kuantitas pastry minimal 1.',
        ]);

        $sale = DB::transaction(function () use ($validated, $request) {
            // Find or assign customer user
            $userId = Auth::id();
            if (! $userId) {
                $customerUser = User::where('role', 'customer')->first();
                $userId = $customerUser ? $customerUser->id : 1;
            }

            $saleNumber = $this->generateSaleNumber();

            $customerNote = $validated['notes'] ?? '';
            if (!empty($validated['customer_phone'])) {
                $customerNote = "No. HP/WA: {$validated['customer_phone']}. " . $customerNote;
            }

            $paymentMethod = $validated['payment_method'] ?? 'cashier';
            $simulatePayment = $request->boolean('simulate_payment', false);

            if ($simulatePayment) {
                $paymentStatus = 'paid';
                $paidAt = Carbon::now();
                $paymentRef = 'SIM-' . $saleNumber;
            } else {
                if ($paymentMethod === 'qris') {
                    $paymentStatus = config('bakery.qris.is_configured') ? 'unpaid' : 'unconfigured_qris';
                } elseif ($paymentMethod === 'bank_transfer') {
                    $paymentStatus = config('bakery.bank_transfer.is_configured') ? 'unpaid' : 'unconfigured_bank';
                } else {
                    $paymentStatus = 'unpaid';
                }
                $paidAt = null;
                $paymentRef = null;
            }

            $sale = Sale::create([
                'user_id' => $userId,
                'sale_number' => $saleNumber,
                'customer_name' => $validated['customer_name'],
                'total' => 0,
                'status' => 'completed',
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'paid_at' => $paidAt,
                'payment_ref' => $paymentRef,
                'sold_at' => Carbon::now(),
                'notes' => trim($customerNote) ?: 'Pesanan Online Toko Roti & Pastry',
            ]);

            $grandTotal = 0;

            foreach ($validated['items'] as $itemData) {
                $product = Product::lockForUpdate()->findOrFail($itemData['product_id']);
                $qty = (int) $itemData['quantity'];

                // Business Rule: Check stock sufficiency
                if ($qty < 1 || $product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'items' => "Mohon maaf, stok '{$product->name}' tidak mencukupi. Sisa stok tersedia: {$product->stock} pcs, jumlah diminta: {$qty} pcs.",
                    ]);
                }

                // Server-calculated price
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

                $grandTotal += $subtotal;
            }

            $sale->update(['total' => $grandTotal]);

            return $sale;
        });

        return redirect()->route('sales.invoice', $sale)
            ->with('success', "Pesanan #{$sale->sale_number} berhasil dibuat! Status Pembayaran: {$sale->payment_status_label}. Silakan simpan nomor pesanan dan nota Anda.");
    }

    /**
     * Customer's personal order history.
     */
    public function myOrders(): View
    {
        $user = Auth::user();

        $sales = Sale::with(['items.product'])
            ->where(function ($q) use ($user) {
                $q->where('user_id', $user->id)
                  ->orWhere('customer_name', 'like', "%{$user->name}%");
            })
            ->latest('sold_at')
            ->paginate(10);

        return view('storefront.orders', compact('sales'));
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

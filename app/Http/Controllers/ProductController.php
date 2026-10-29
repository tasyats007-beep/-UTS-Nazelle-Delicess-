<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');
        $categoryId = $request->query('category_id');
        $lowStockOnly = $request->boolean('low_stock');

        $categories = Category::orderBy('name')->get();

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($categoryId, function ($query, $categoryId) {
                $query->where('category_id', $categoryId);
            })
            ->when($lowStockOnly, function ($query) {
                $query->lowStock();
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $totalProductsCount = Product::count();
        $lowStockProductsCount = Product::lowStock()->count();
        $totalCategoriesCount = $categories->count();

        return view('products.index', compact(
            'products',
            'categories',
            'search',
            'categoryId',
            'lowStockOnly',
            'totalProductsCount',
            'lowStockProductsCount',
            'totalCategoriesCount'
        ));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['nullable', 'string', 'max:50', 'unique:products,sku'],
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Nama menu pastry/roti wajib diisi.',
            'category_id.required' => 'Silakan pilih kategori menu.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'selling_price.required' => 'Harga jual menu wajib diisi.',
            'selling_price.min' => 'Harga jual tidak boleh bernilai negatif.',
            'purchase_price.min' => 'Harga pokok/beli tidak boleh bernilai negatif.',
            'sku.unique' => 'Kode SKU ini sudah digunakan oleh menu lain. Gunakan SKU yang berbeda.',
        ]);

        // Auto-generate SKU if not provided by user
        if (empty($validated['sku'])) {
            $cat = Category::find($validated['category_id']);
            $catCode = $cat ? strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $cat->name), 0, 3)) : 'BAK';
            $validated['sku'] = "BAK-{$catCode}-" . strtoupper(bin2hex(random_bytes(2)));
        }

        // Auto-estimate purchase cost if empty (default 60% of selling price)
        if (!isset($validated['purchase_price']) || $validated['purchase_price'] === null) {
            $validated['purchase_price'] = round($validated['selling_price'] * 0.6, 2);
        }

        $validated['stock'] = $validated['stock'] ?? 0;
        $validated['minimum_stock'] = $validated['minimum_stock'] ?? 5;

        $product = Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', "Menu '{$product->name}' berhasil ditambahkan ke database dan otomatis tersedia di katalog toko!");
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'purchaseItems.purchase.supplier', 'saleItems.sale.user']);

        $recentPurchases = $product->purchaseItems()
            ->with('purchase.supplier')
            ->latest()
            ->take(5)
            ->get();

        $recentSales = $product->saleItems()
            ->with('sale.user')
            ->latest()
            ->take(5)
            ->get();

        return view('products.show', compact('product', 'recentPurchases', 'recentSales'));
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'sku' => ['nullable', 'string', 'max:50', Rule::unique('products', 'sku')->ignore($product->id)],
            'name' => ['required', 'string', 'max:150'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'purchase_price' => ['nullable', 'numeric', 'min:0'],
            'selling_price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['nullable', 'integer', 'min:0'],
        ], [
            'name.required' => 'Nama menu pastry/roti wajib diisi.',
            'category_id.required' => 'Silakan pilih kategori menu.',
            'selling_price.required' => 'Harga jual menu wajib diisi.',
            'selling_price.min' => 'Harga jual tidak boleh bernilai negatif.',
            'purchase_price.min' => 'Harga pokok/beli tidak boleh bernilai negatif.',
            'stock.required' => 'Jumlah stok menu wajib diisi.',
            'stock.min' => 'Stok tidak boleh bernilai negatif.',
            'sku.unique' => 'Kode SKU ini sudah digunakan oleh menu lain.',
        ]);

        if (empty($validated['sku'])) {
            $validated['sku'] = $product->sku;
        }

        if (!isset($validated['purchase_price']) || $validated['purchase_price'] === null) {
            $validated['purchase_price'] = $product->purchase_price ?: round($validated['selling_price'] * 0.6, 2);
        }

        $validated['minimum_stock'] = $validated['minimum_stock'] ?? $product->minimum_stock ?? 5;

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', "Menu '{$product->name}' berhasil diperbarui! Perubahan harga dan informasi langsung terlihat di katalog pelanggan.");
    }

    public function destroy(Product $product): RedirectResponse
    {
        if ($product->saleItems()->exists() || $product->purchaseItems()->exists()) {
            return back()->with('error', "Menu '{$product->name}' tidak dapat dihapus karena sudah memiliki riwayat transaksi (untuk menjaga integritas pembukuan toko). Anda dapat mengubah stoknya menjadi 0 agar tidak dapat dipesan.");
        }

        $productName = $product->name;
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Menu '{$productName}' berhasil dihapus dari database dan tidak lagi muncul di katalog toko.");
    }
}

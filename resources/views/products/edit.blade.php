@extends('layouts.app')

@section('title', 'Edit Produk - ' . $product->name)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-bakery-100 flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                    <i class="fa-solid fa-pen-to-square"></i>
                    <span>Ubah Data Pastry</span>
                </div>
                <h1 class="text-2xl font-serif font-bold text-bakery-950">
                    Edit: {{ $product->name }}
                </h1>
                <p class="text-xs text-stone-500 mt-1">Perbarui detail resep, harga jual, harga pokok bahan, atau kuantitas etalase.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-stone-500 hover:text-stone-800">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('products.update', $product) }}" method="POST" class="p-6 sm:p-8 space-y-5">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- SKU -->
                <div>
                    <label for="sku" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Kode SKU <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs font-mono bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('sku') border-rose-500 @enderror">
                    @error('sku')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Kategori Pastry <span class="text-rose-500">*</span>
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('category_id') border-rose-500 @enderror">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Nama Varian Pastry / Roti <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                    class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Deskripsi Aroma & Cita Rasa (Opsional)
                </label>
                <textarea name="description" id="description" rows="2"
                    class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Image URL -->
            <div>
                <label for="image_url" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    URL Foto Pastry Estetik (Opsional)
                </label>
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url) }}"
                    placeholder="https://images.unsplash.com/..."
                    class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Pricing -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="purchase_price" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Harga Pokok Bahan / Beli (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" step="any" min="0" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('purchase_price') border-rose-500 @enderror">
                    @error('purchase_price')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="selling_price" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Harga Jual Menu (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" step="any" min="0" name="selling_price" id="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('selling_price') border-rose-500 @enderror">
                    @error('selling_price')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Stock & Minimum Stock -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Stok di Etalase (Pcs) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('stock') border-rose-500 @enderror">
                    @error('stock')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="minimum_stock" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Batas Minimum Stok (Pcs) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" min="0" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('minimum_stock') border-rose-500 @enderror">
                    @error('minimum_stock')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-bakery-100">
                <a href="{{ route('products.index') }}" class="px-4 py-2 border border-bakery-200 rounded-xl text-xs font-semibold text-stone-600 hover:bg-bakery-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-sm transition">
                    <i class="fa-solid fa-save mr-1.5"></i> Perbarui Pastry
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

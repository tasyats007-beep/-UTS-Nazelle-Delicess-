@extends('layouts.app')

@section('title', 'Edit Menu: ' . $product->name . ' - Nazelle Délices')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <!-- Header -->
        <div class="p-6 sm:p-8 border-b border-bakery-100 flex items-center justify-between">
            <div>
                <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-amber-700 mb-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                        <i class="fa-solid fa-crown mr-1 text-amber-600"></i> Khusus Owner / Admin
                    </span>
                    <span>&bull;</span>
                    <span class="text-stone-500 font-semibold">Ubah Data Menu</span>
                </div>
                <h1 class="text-2xl font-serif font-bold text-bakery-950">
                    Edit: {{ $product->name }}
                </h1>
                <p class="text-xs text-stone-500 mt-1">Perbarui harga jual, stok etalase, foto, atau informasi menu. Perubahan akan seketika tampil di katalog pelanggan.</p>
            </div>
            <a href="{{ route('products.index') }}" class="text-xs font-semibold text-stone-500 hover:text-stone-800 transition flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Kembali ke Menu</span>
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('products.update', $product) }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- 1. Nama Menu & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Nama Menu Pastry / Roti <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('name') border-rose-500 @enderror">
                    @error('name')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Kategori Menu <span class="text-rose-500">*</span>
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

            <!-- 2. Harga Jual & Stok -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="selling_price" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Harga Jual Menu (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-xs text-stone-400 font-bold">Rp</span>
                        <input type="number" step="any" min="0" name="selling_price" id="selling_price" value="{{ old('selling_price', $product->selling_price) }}" required
                            class="w-full pl-10 pr-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs font-serif font-bold text-bakery-950 bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('selling_price') border-rose-500 @enderror">
                    </div>
                    <p class="text-[10px] text-stone-400 mt-1">Harga yang dibayar pembeli di katalog & kasir.</p>
                    @error('selling_price')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stock" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Jumlah Stok Etalase (Pcs) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" min="0" name="stock" id="stock" value="{{ old('stock', $product->stock) }}" required
                        class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none @error('stock') border-rose-500 @enderror">
                    <p class="text-[10px] text-stone-400 mt-1">Ubah ke 0 jika roti sedang habis tidak dipanggang.</p>
                    @error('stock')
                        <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- 3. Deskripsi -->
            <div>
                <label for="description" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Deskripsi Aroma, Rasa, & Karakteristik (Opsional)
                </label>
                <textarea name="description" id="description" rows="2"
                    class="w-full px-3.5 py-2.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- 4. Foto Produk & Live Preview -->
            <div class="p-4 bg-bakery-50/70 rounded-2xl border border-bakery-200/80 space-y-3">
                <div class="flex items-center justify-between">
                    <label for="image_url" class="block text-xs font-bold uppercase tracking-wider text-stone-800">
                        Foto Menu Pastry (URL Gambar)
                    </label>
                    <span class="text-[10px] text-amber-700 font-semibold">URL Foto Aktif</span>
                </div>
                
                <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $product->image_url) }}"
                    placeholder="https://images.unsplash.com/..."
                    oninput="updateImagePreview(this.value)"
                    class="w-full px-3.5 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">

                <!-- Preset Foto Cepat -->
                <div>
                    <span class="text-[10px] font-bold text-stone-500 uppercase tracking-wider block mb-1.5">Ganti Cepat Foto Preset:</span>
                    <div class="flex flex-wrap gap-1.5 text-[11px]">
                        <button type="button" onclick="setPresetPhoto('https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=600&q=80')" 
                                class="px-2.5 py-1 bg-white hover:bg-amber-100 border border-stone-200 rounded-lg text-stone-700 transition">
                            🥐 Croissant
                        </button>
                        <button type="button" onclick="setPresetPhoto('https://images.unsplash.com/photo-1608198093002-ad4e005484ec?auto=format&fit=crop&w=600&q=80')" 
                                class="px-2.5 py-1 bg-white hover:bg-amber-100 border border-stone-200 rounded-lg text-stone-700 transition">
                            🍫 Pain au Chocolat
                        </button>
                        <button type="button" onclick="setPresetPhoto('https://images.unsplash.com/photo-1586444248902-2f64eddc13df?auto=format&fit=crop&w=600&q=80')" 
                                class="px-2.5 py-1 bg-white hover:bg-amber-100 border border-stone-200 rounded-lg text-stone-700 transition">
                            🥖 Sourdough Boule
                        </button>
                        <button type="button" onclick="setPresetPhoto('https://images.unsplash.com/photo-1519869325930-281384150729?auto=format&fit=crop&w=600&q=80')" 
                                class="px-2.5 py-1 bg-white hover:bg-amber-100 border border-stone-200 rounded-lg text-stone-700 transition">
                            🍓 Tart Buah
                        </button>
                    </div>
                </div>

                <!-- Preview Box -->
                <div id="imagePreviewContainer" class="flex items-center space-x-3 pt-2">
                    <img id="imagePreview" src="{{ $product->aesthetic_image }}" 
                         alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover border border-bakery-300 shadow-xs">
                    <div class="text-[11px] text-stone-500 font-light">
                        <strong class="text-stone-700 font-medium block">Foto Menu Saat Ini</strong>
                        Tampilan visual yang terlihat oleh pelanggan di etalase toko.
                    </div>
                </div>
            </div>

            <!-- 5. Pengaturan Lanjutan -->
            <details class="group border border-stone-200 rounded-2xl p-4 bg-stone-50/50 transition">
                <summary class="cursor-pointer text-xs font-bold uppercase tracking-wider text-stone-700 flex items-center justify-between select-none">
                    <span class="flex items-center space-x-1.5">
                        <i class="fa-solid fa-sliders text-amber-600"></i>
                        <span>Pengaturan Lanjutan (SKU, Harga Pokok HPP, Batas Stok)</span>
                    </span>
                    <i class="fa-solid fa-chevron-down text-[10px] text-stone-400 group-open:rotate-180 transition-transform"></i>
                </summary>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 mt-2 border-t border-stone-200/60">
                    <div>
                        <label for="sku" class="block text-[11px] font-bold uppercase tracking-wider text-stone-600 mb-1">
                            Kode SKU <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" required
                            class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs font-mono bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        @error('sku')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="purchase_price" class="block text-[11px] font-bold uppercase tracking-wider text-stone-600 mb-1">
                            Harga Pokok / HPP (Rp)
                        </label>
                        <input type="number" step="any" min="0" name="purchase_price" id="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                            class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                        @error('purchase_price')
                            <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="minimum_stock" class="block text-[11px] font-bold uppercase tracking-wider text-stone-600 mb-1">
                            Batas Minimum Stok
                        </label>
                        <input type="number" min="0" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}"
                            class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    </div>
                </div>
            </details>

            <!-- Buttons -->
            <div class="flex items-center justify-end space-x-3 pt-5 border-t border-bakery-100">
                <a href="{{ route('products.index') }}" 
                   class="px-5 py-2.5 border border-bakery-200 rounded-xl text-xs font-semibold text-stone-600 hover:bg-bakery-50 transition">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-[#3D2010] hover:bg-[#261309] text-white rounded-xl text-xs font-bold uppercase tracking-wider shadow-md transition hover:scale-[1.02] active:scale-[0.98] border border-amber-700/50 flex items-center space-x-1.5">
                    <i class="fa-solid fa-save text-amber-400"></i>
                    <span>Simpan Perubahan Menu</span>
                </button>
            </div>
        </form>
    </div>

</div>

<script>
function setPresetPhoto(url) {
    document.getElementById('image_url').value = url;
    updateImagePreview(url);
}

function updateImagePreview(url) {
    const preview = document.getElementById('imagePreview');
    if (url && url.trim().length > 5) {
        preview.src = url;
    } else {
        preview.src = '{{ $product->aesthetic_image }}';
    }
}
</script>
@endsection

@extends('layouts.app')

@section('title', 'Manajemen Menu Khusus Owner / Admin - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-amber-700 mb-1">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-900 border border-amber-300">
                    <i class="fa-solid fa-crown mr-1 text-amber-600"></i> Khusus Owner / Admin
                </span>
                <span>&bull;</span>
                <span class="text-stone-500 font-semibold">Pengelolaan Katalog Toko</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Manajemen Menu Bakery & Pastry
            </h1>
            <p class="text-xs text-stone-500 mt-1 max-w-2xl">
                Kelola seluruh menu roti, viennoiserie, dan kue Nazelle Délices. Seluruh menu yang Anda tambahkan, edit, atau hapus di halaman ini otomatis tersinkronisasi langsung dengan katalog pelanggan dan kasir POS.
            </p>
        </div>
        <div class="flex items-center space-x-2.5">
            <a href="{{ route('storefront.index') }}" 
               class="inline-flex items-center px-4 py-2.5 bg-bakery-100 hover:bg-bakery-200 text-bakery-900 text-xs font-bold rounded-xl transition shadow-xs">
                <i class="fa-solid fa-store mr-1.5 text-amber-700"></i> Lihat Katalog Pelanggan
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-[#3D2010] hover:bg-[#261309] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-md transition hover:scale-[1.02] active:scale-[0.98] border border-amber-700/50">
                <i class="fa-solid fa-plus mr-1.5 text-amber-400"></i> Tambah Menu Baru
            </a>
            @endif
        </div>
    </div>

    <!-- Quick Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-bakery-100 text-bakery-800 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-bread-slice"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Total Menu Terdaftar</div>
                <div class="text-2xl font-serif font-bold text-bakery-950">{{ $totalProductsCount ?? $products->total() }} <span class="text-xs font-sans font-normal text-stone-400">varian</span></div>
                <div class="text-[11px] text-stone-500">Tersedia di etalase toko & kasir</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-amber-700">Stok Kritis / Menipis</div>
                <div class="text-2xl font-serif font-bold text-amber-900">{{ $lowStockProductsCount ?? \App\Models\Product::lowStock()->count() }} <span class="text-xs font-sans font-normal text-stone-400">menu</span></div>
                <div class="text-[11px] text-amber-700">Perlu dipanggang ulang oleh baker</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Total Kategori Menu</div>
                <div class="text-2xl font-serif font-bold text-stone-900">{{ $totalCategoriesCount ?? $categories->count() }} <span class="text-xs font-sans font-normal text-stone-400">kategori</span></div>
                <div class="text-[11px] text-stone-500">Viennoiserie, Sourdough, Patisserie, dll.</div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
        <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <!-- Search Text -->
            <div class="sm:col-span-5 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama menu pastry atau SKU..."
                    class="w-full pl-9 pr-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Filter Category -->
            <div class="sm:col-span-4">
                <select name="category_id" class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <option value="">-- Semua Kategori Menu --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Low Stock Checkbox & Buttons -->
            <div class="sm:col-span-3 flex items-center justify-between sm:justify-end gap-2">
                <label class="flex items-center text-xs text-rose-700 font-semibold cursor-pointer">
                    <input type="checkbox" name="low_stock" value="1" {{ $lowStockOnly ? 'checked' : '' }}
                        class="rounded border-stone-300 text-rose-600 focus:ring-rose-500 mr-1.5" onchange="this.form.submit()">
                    Stok Kritis
                </label>

                <button type="submit" class="px-4 py-2 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                    Filter
                </button>

                @if($search || $categoryId || $lowStockOnly)
                    <a href="{{ route('products.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-bakery-100 text-xs">
                <thead class="bg-bakery-50/60 text-stone-500 font-semibold text-left">
                    <tr>
                        <th class="px-6 py-4">Foto & Varian Menu</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4 text-right">Harga Jual (Menu)</th>
                        @if(!auth()->user()->isCustomer())
                        <th class="px-6 py-4 text-right">Harga Pokok (HPP)</th>
                        @endif
                        <th class="px-6 py-4 text-center">Stok Etalase</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($products as $prod)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <!-- Foto & Varian -->
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3.5">
                                <img src="{{ $prod->aesthetic_image }}" alt="{{ $prod->name }}"
                                     class="w-14 h-14 rounded-2xl object-cover border border-bakery-200 flex-shrink-0 shadow-xs">
                                <div>
                                    <a href="{{ route('products.show', $prod) }}" class="font-serif font-bold text-sm text-bakery-950 hover:text-amber-700 transition">
                                        {{ $prod->name }}
                                    </a>
                                    <div class="font-mono text-[10px] text-stone-400 mt-0.5">SKU: {{ $prod->sku }}</div>
                                    <div class="text-[11px] text-stone-500 line-clamp-1 max-w-xs mt-0.5 font-light">
                                        {{ $prod->description ?: 'Pastry artisan Prancis buatan tangan.' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Kategori -->
                        <td class="px-6 py-4 text-stone-600 font-medium">
                            <span class="bg-bakery-50 border border-bakery-200 text-bakery-900 px-3 py-1 rounded-full text-[10px] font-bold">
                                {{ $prod->category->name }}
                            </span>
                        </td>

                        <!-- Harga Jual -->
                        <td class="px-6 py-4 text-right font-serif font-bold text-bakery-900 text-sm">
                            Rp {{ number_format($prod->selling_price, 0, ',', '.') }}
                        </td>

                        <!-- Harga Pokok -->
                        @if(!auth()->user()->isCustomer())
                        <td class="px-6 py-4 text-right text-stone-500 font-mono text-[11px]">
                            Rp {{ number_format($prod->purchase_price, 0, ',', '.') }}
                        </td>
                        @endif

                        <!-- Stok -->
                        <td class="px-6 py-4 text-center font-bold text-stone-800">
                            <span class="text-sm">{{ $prod->stock }}</span> <span class="text-[10px] text-stone-400 font-normal">pcs</span>
                            <div class="text-[9px] text-stone-400 font-normal">Min: {{ $prod->minimum_stock }}</div>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 text-center">
                            @if($prod->stock <= 0)
                                <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Habis</span>
                            @elseif($prod->isLowStock())
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase animate-pulse">Menipis</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Tersedia</span>
                            @endif
                        </td>

                        <!-- Aksi CRUD -->
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <div class="inline-flex items-center space-x-1.5">
                                <a href="{{ route('products.show', $prod) }}" 
                                   class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-stone-100 hover:bg-stone-200 text-stone-700 font-semibold text-[11px] transition" title="Lihat detail & riwayat">
                                    <i class="fa-solid fa-eye mr-1 text-stone-500"></i> Detail
                                </a>

                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('products.edit', $prod) }}" 
                                   class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-900 font-bold text-[11px] border border-amber-200 transition" title="Edit informasi menu">
                                    <i class="fa-solid fa-pen-to-square mr-1 text-amber-700"></i> Edit
                                </a>

                                <form action="{{ route('products.destroy', $prod) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu \'{{ addslashes($prod->name) }}\'? Menu yang dihapus tidak akan lagi muncul di katalog toko.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-2.5 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-800 font-bold text-[11px] border border-rose-200 transition" title="Hapus menu">
                                        <i class="fa-solid fa-trash mr-1 text-rose-600"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-14 text-center text-stone-400">
                            <div class="text-4xl mb-2">🥐</div>
                            <div class="font-serif text-base font-bold text-stone-700">Belum Ada Menu Pastry yang Cocok</div>
                            <p class="text-xs text-stone-400 mt-1">Coba ubah kata kunci pencarian atau reset filter kategori.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-bakery-100">
            {{ $products->links() }}
        </div>
    </div>

</div>
@endsection

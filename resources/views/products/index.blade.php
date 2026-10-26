@extends('layouts.app')

@section('title', 'Master Produk Pastry & Roti - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                <i class="fa-solid fa-bread-slice"></i>
                <span>Master Data Inventaris</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Katalog & Master Produk Pastry
            </h1>
            <p class="text-xs text-stone-500 mt-1">Daftar lengkap roti, viennoiserie, tart, SKU unik, harga jual, harga pokok beli, dan kuantitas stok aktual.</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('storefront.index') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-100 hover:bg-bakery-200 text-bakery-900 text-xs font-bold rounded-xl transition">
                <i class="fa-solid fa-store mr-1.5"></i> Lihat Toko Depan
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('products.create') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition">
                <i class="fa-solid fa-plus mr-1.5"></i> Tambah Pastry Baru
            </a>
            @endif
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
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari SKU atau nama varian pastry..."
                    class="w-full pl-9 pr-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Filter Category -->
            <div class="sm:col-span-4">
                <select name="category_id" class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <option value="">-- Semua Kategori Pastry --</option>
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
                    Stok Kritis Saja
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
                        <th class="px-6 py-4">Foto & Varian Pastry</th>
                        <th class="px-6 py-4">Kategori</th>
                        @if(!auth()->user()->isCustomer())
                        <th class="px-6 py-4 text-right">Harga Pokok (Beli)</th>
                        @endif
                        <th class="px-6 py-4 text-right">Harga Jual</th>
                        <th class="px-6 py-4 text-center">Stok</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($products as $prod)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $prod->aesthetic_image }}" alt="{{ $prod->name }}"
                                     class="w-12 h-12 rounded-xl object-cover border border-bakery-200 flex-shrink-0">
                                <div>
                                    <a href="{{ route('products.show', $prod) }}" class="font-serif font-bold text-sm text-bakery-950 hover:text-amber-700">
                                        {{ $prod->name }}
                                    </a>
                                    <div class="font-mono text-[10px] text-stone-400 mt-0.5">SKU: {{ $prod->sku }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-stone-600 font-medium">
                            <span class="bg-bakery-50 border border-bakery-200 text-bakery-900 px-2 py-0.5 rounded-full text-[10px]">
                                {{ $prod->category->name }}
                            </span>
                        </td>
                        @if(!auth()->user()->isCustomer())
                        <td class="px-6 py-4 text-right text-stone-500 font-mono">
                            Rp {{ number_format($prod->purchase_price, 0, ',', '.') }}
                        </td>
                        @endif
                        <td class="px-6 py-4 text-right font-serif font-bold text-bakery-900 text-sm">
                            Rp {{ number_format($prod->selling_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-stone-800">
                            {{ $prod->stock }} pcs
                            <div class="text-[9px] text-stone-400 font-normal">Min: {{ $prod->minimum_stock }}</div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($prod->stock <= 0)
                                <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Habis</span>
                            @elseif($prod->isLowStock())
                                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase animate-pulse">Menipis</span>
                            @else
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Tersedia</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                            <a href="{{ route('products.show', $prod) }}" class="text-bakery-700 hover:text-bakery-950 font-semibold" title="Lihat detail">
                                Detail
                            </a>
                            @if(auth()->user()->isAdmin())
                            <span class="text-stone-300">&bull;</span>
                            <a href="{{ route('products.edit', $prod) }}" class="text-amber-600 hover:text-amber-800 font-semibold" title="Ubah data">
                                Edit
                            </a>
                            <span class="text-stone-300">&bull;</span>
                            <form action="{{ route('products.destroy', $prod) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini? Produk yang memiliki transaksi tidak dapat dihapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-stone-400">
                            Tidak ada produk pastry yang sesuai dengan kriteria filter.
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

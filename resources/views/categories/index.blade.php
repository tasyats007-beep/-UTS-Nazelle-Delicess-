@extends('layouts.app')

@section('title', 'Kategori Roti & Pastry - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                <i class="fa-solid fa-tags"></i>
                <span>Master Klasifikasi</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Kategori Roti & Pastry
            </h1>
            <p class="text-xs text-stone-500 mt-1">Klasifikasi menu roti artisan, viennoiserie, patisserie, cake, dan minuman pendamping.</p>
        </div>
        @if(auth()->user()->isAdmin())
        <div>
            <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition">
                <i class="fa-solid fa-plus mr-1.5"></i> Tambah Kategori
            </a>
        </div>
        @endif
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau deskripsi kategori pastry..."
                    class="w-full pl-9 pr-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
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
                        <th class="px-6 py-4">Nama Kategori</th>
                        <th class="px-6 py-4">Karakteristik & Deskripsi</th>
                        <th class="px-6 py-4 text-center">Jumlah Menu</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-6 py-4 text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($categories as $cat)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <td class="px-6 py-4 font-serif font-bold text-sm text-bakery-950">
                            {{ $cat->name }}
                        </td>
                        <td class="px-6 py-4 text-stone-600 max-w-md text-xs leading-relaxed">
                            {{ $cat->description ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-bakery-100 text-bakery-900 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                {{ $cat->products_count }} varian
                            </span>
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('categories.edit', $cat) }}" class="text-amber-600 hover:text-amber-800 font-semibold">
                                Edit
                            </a>
                            <span class="text-stone-300">&bull;</span>
                            <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus kategori ini? Kategori yang memiliki produk tidak dapat dihapus.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-stone-400">
                            Belum ada kategori yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-bakery-100">
            {{ $categories->links() }}
        </div>
    </div>

</div>
@endsection

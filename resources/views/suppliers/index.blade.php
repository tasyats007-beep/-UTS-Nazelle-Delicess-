@extends('layouts.app')

@section('title', 'Pemasok Bahan Baku Pastry - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                <i class="fa-solid fa-truck-field"></i>
                <span>Mitra Pemasok Bahan Baku</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Data Supplier & Vendor Bahan
            </h1>
            <p class="text-xs text-stone-500 mt-1">Daftar mitra importir mentega Prancis, penggilingan tepung terigu gourmet, cokelat Valrhona, dan ragi alami.</p>
        </div>
        @if(auth()->user()->isAdmin())
        <div>
            <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition">
                <i class="fa-solid fa-plus mr-1.5"></i> Tambah Supplier Baru
            </a>
        </div>
        @endif
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
        <form method="GET" action="{{ route('suppliers.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama supplier, kontak telepon, atau email..."
                    class="w-full pl-9 pr-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>
            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                    Cari
                </button>
                @if($search)
                    <a href="{{ route('suppliers.index') }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
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
                        <th class="px-6 py-4">Nama Pemasok / Distributor</th>
                        <th class="px-6 py-4">Kontak Resmi</th>
                        <th class="px-6 py-4">Alamat & Keterangan</th>
                        <th class="px-6 py-4 text-center">Transaksi Restock</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-6 py-4 text-right">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($suppliers as $sup)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <td class="px-6 py-4 font-serif font-bold text-sm text-bakery-950">
                            {{ $sup->name }}
                        </td>
                        <td class="px-6 py-4 text-stone-600 space-y-1">
                            @if($sup->phone)
                                <div><i class="fa-solid fa-phone text-stone-400 mr-1.5"></i>{{ $sup->phone }}</div>
                            @endif
                            @if($sup->email)
                                <div><i class="fa-solid fa-envelope text-stone-400 mr-1.5"></i>{{ $sup->email }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-stone-600 max-w-xs text-xs leading-relaxed">
                            {{ $sup->address ?: '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-bakery-100 text-bakery-900 font-bold px-2.5 py-1 rounded-full text-[11px]">
                                {{ $sup->purchases_count }} restock
                            </span>
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('suppliers.edit', $sup) }}" class="text-amber-600 hover:text-amber-800 font-semibold">
                                Edit
                            </a>
                            <span class="text-stone-300">&bull;</span>
                            <form action="{{ route('suppliers.destroy', $sup) }}" method="POST" class="inline"
                                onsubmit="return confirm('Yakin ingin menghapus supplier ini? Supplier yang memiliki riwayat pembelian tidak dapat dihapus.')">
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
                        <td colspan="5" class="px-6 py-12 text-center text-stone-400">
                            Belum ada supplier yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-bakery-100">
            {{ $suppliers->links() }}
        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('title', 'Daftar Pembelian & Restock Bahan - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                <i class="fa-solid fa-dolly"></i>
                <span>Pengadaan Bahan Baku Toko Roti</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Riwayat Pembelian & Restock (Stock-In)
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Pencatatan pengadaan tepung, mentega Prancis, cokelat Valrhona, dan ragi. Stok bertambah otomatis setelah transaksi tersimpan.
            </p>
        </div>
        <div>
            <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition">
                <i class="fa-solid fa-plus mr-2"></i> Restock Bahan Baru
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
        <form method="GET" action="{{ route('purchases.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <!-- Search Text -->
            <div class="sm:col-span-4 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="No. Pembelian atau Nama Supplier..."
                    class="w-full pl-9 pr-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Status Filter -->
            <div class="sm:col-span-3">
                <select name="status" class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <option value="">-- Semua Status --</option>
                    <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai</option>
                    <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <!-- Date Range Filters -->
            <div class="sm:col-span-2">
                <input type="date" name="from_date" value="{{ $fromDate }}" title="Dari Tanggal"
                    class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <div class="sm:col-span-3 flex items-center gap-2">
                <input type="date" name="to_date" value="{{ $toDate }}" title="Sampai Tanggal"
                    class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">

                <button type="submit" class="px-4 py-2 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                    Filter
                </button>

                @if($search || $status || $fromDate || $toDate)
                    <a href="{{ route('purchases.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
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
                        <th class="px-6 py-4">No. PO Pembelian</th>
                        <th class="px-6 py-4">Tanggal Restock</th>
                        <th class="px-6 py-4">Supplier Pemasok</th>
                        <th class="px-6 py-4 text-center">Item</th>
                        <th class="px-6 py-4 text-right">Total Biaya Restock</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($purchases as $p)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <td class="px-6 py-4">
                            <a href="{{ route('purchases.show', $p) }}" class="font-mono font-bold text-bakery-900 hover:text-amber-700">
                                {{ $p->purchase_number }}
                            </a>
                            <div class="text-[10px] text-stone-400">Petugas: {{ $p->user->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-stone-600">
                            {{ $p->purchased_at->format('d/m/Y H:i') }} WIB
                        </td>
                        <td class="px-6 py-4 font-medium text-stone-800">
                            {{ $p->supplier->name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-bakery-100 text-bakery-800 text-[11px] font-bold px-2 py-0.5 rounded-full">
                                {{ $p->items->sum('quantity') }} unit
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-serif font-bold text-bakery-900 text-sm">
                            Rp {{ number_format($p->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($p->status === 'completed')
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Selesai</span>
                            @else
                                <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Dibatalkan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('purchases.show', $p) }}" class="text-bakery-700 hover:text-bakery-950 font-semibold">
                                Detail &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-stone-400">
                            Belum ada transaksi pembelian yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-bakery-100">
            {{ $purchases->links() }}
        </div>
    </div>

</div>
@endsection

@extends('layouts.app')

@section('title', 'Detail Pembelian - ' . $purchase->purchase_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold font-mono text-bakery-950">{{ $purchase->purchase_number }}</h1>
                @if($purchase->status === 'completed')
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Selesai</span>
                @else
                    <span class="bg-rose-100 text-rose-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Dibatalkan</span>
                @endif
            </div>
            <p class="text-xs text-stone-500 mt-1">Dicatat pada: {{ $purchase->purchased_at->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('purchases.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
                &larr; Kembali
            </a>

            @if(auth()->user()->isAdmin() && $purchase->status === 'completed')
            <form action="{{ route('purchases.cancel', $purchase) }}" method="POST" class="inline"
                onsubmit="return confirm('PERINGATAN: Membatalkan pembelian ini akan mengurangi kembali stok produk yang dibeli. Pastikan stok masih mencukupi. Lanjutkan pembatalan?')">
                @csrf
                <button type="submit" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                    <i class="fa-solid fa-ban mr-1"></i> Batalkan Restock
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Purchase Info Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <!-- Supplier Details -->
        <div class="bg-white p-6 rounded-3xl border border-bakery-200 shadow-xs space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Pemasok Bahan (Supplier)</div>
            <div class="text-lg font-serif font-bold text-bakery-950">{{ $purchase->supplier->name }}</div>
            <div class="text-xs text-stone-600 space-y-1">
                @if($purchase->supplier->phone)
                    <div><i class="fa-solid fa-phone text-stone-400 mr-1.5"></i>{{ $purchase->supplier->phone }}</div>
                @endif
                @if($purchase->supplier->email)
                    <div><i class="fa-solid fa-envelope text-stone-400 mr-1.5"></i>{{ $purchase->supplier->email }}</div>
                @endif
                @if($purchase->supplier->address)
                    <div><i class="fa-solid fa-location-dot text-stone-400 mr-1.5"></i>{{ $purchase->supplier->address }}</div>
                @endif
            </div>
        </div>

        <!-- Meta Details -->
        <div class="bg-white p-6 rounded-3xl border border-bakery-200 shadow-xs space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Informasi Pengadaan</div>
            <div class="text-xs text-stone-700 space-y-2">
                <div class="flex justify-between">
                    <span class="text-stone-500">Petugas / Baker:</span>
                    <span class="font-semibold text-stone-800">{{ $purchase->user->name }} ({{ $purchase->user->email }})</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Waktu Pembelian:</span>
                    <span class="font-semibold text-stone-800">{{ $purchase->purchased_at->format('d/m/Y H:i') }} WIB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Catatan Restock:</span>
                    <span class="font-medium text-stone-700">{{ $purchase->notes ?: '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchased Items Table -->
    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="p-6 border-b border-bakery-100 font-serif font-bold text-bakery-950 text-base flex items-center">
            <span class="mr-2">📦</span> Rincian Item Bahan Baku Yang Dibeli
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-bakery-100 text-xs">
                <thead class="bg-bakery-50/60 text-stone-500 text-left">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Nama Produk & SKU</th>
                        <th class="px-6 py-3.5 text-center">Kuantitas Masuk</th>
                        <th class="px-6 py-3.5 text-right">Harga Beli Satuan</th>
                        <th class="px-6 py-3.5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @foreach ($purchase->items as $idx => $item)
                    <tr class="hover:bg-bakery-50/40">
                        <td class="px-6 py-4 text-stone-400">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="font-serif font-bold text-sm text-bakery-950">{{ $item->product->name }}</div>
                            <div class="font-mono text-[10px] text-stone-400">{{ $item->product->sku }} &bull; {{ $item->product->category->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-stone-800">
                            {{ $item->quantity }} unit
                        </td>
                        <td class="px-6 py-4 text-right text-stone-600">
                            Rp {{ number_format($item->unit_cost, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-serif font-bold text-bakery-900 text-sm">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-bakery-50/80 font-bold border-t border-bakery-200">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right uppercase text-xs text-stone-600">Total Biaya Pembelian:</td>
                        <td class="px-6 py-4 text-right text-lg font-serif text-amber-700">
                            Rp {{ number_format($purchase->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection

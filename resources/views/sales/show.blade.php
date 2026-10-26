@extends('layouts.app')

@section('title', 'Detail Penjualan - ' . $sale->sale_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-3">
                <h1 class="text-2xl font-bold font-mono text-bakery-950">{{ $sale->sale_number }}</h1>
                @if($sale->status === 'completed')
                    <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Selesai / Lunas</span>
                @else
                    <span class="bg-rose-100 text-rose-800 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Dibatalkan</span>
                @endif
            </div>
            <p class="text-xs text-stone-500 mt-1">Waktu Penjualan: {{ $sale->sold_at->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('sales.index') }}" class="px-3.5 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
                &larr; Kembali
            </a>

            <a href="{{ route('sales.invoice', $sale) }}" target="_blank"
                class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl shadow-xs transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>Cetak Struk Nota</span>
            </a>

            @if(auth()->user()->isAdmin() && $sale->status === 'completed')
            <form action="{{ route('sales.cancel', $sale) }}" method="POST" class="inline"
                onsubmit="return confirm('PERHATIAN: Membatalkan penjualan ini akan mengembalikan seluruh stok produk yang terjual ke inventaris. Lanjutkan pembatalan?')">
                @csrf
                <button type="submit" class="px-3.5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                    <i class="fa-solid fa-ban mr-1"></i> Batalkan Penjualan
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Sale Info Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <!-- Customer Details -->
        <div class="bg-white p-6 rounded-3xl border border-bakery-200 shadow-xs space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Data Pelanggan</div>
            <div class="text-lg font-serif font-bold text-bakery-950">{{ $sale->customer_name }}</div>
            <p class="text-xs text-stone-500">Pemesanan Toko Nazelle Délices</p>
        </div>

        <!-- Meta Details -->
        <div class="bg-white p-6 rounded-3xl border border-bakery-200 shadow-xs space-y-2">
            <div class="text-[10px] font-bold uppercase tracking-wider text-stone-400">Informasi Kasir & Waktu</div>
            <div class="text-xs text-stone-700 space-y-2">
                <div class="flex justify-between">
                    <span class="text-stone-500">Petugas / Kasir:</span>
                    <span class="font-semibold text-stone-800">{{ $sale->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Waktu Transaksi:</span>
                    <span class="font-semibold text-stone-800">{{ $sale->sold_at->format('d/m/Y H:i') }} WIB</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-stone-500">Metode Pembayaran:</span>
                    <span class="font-semibold text-stone-800">{{ $sale->payment_method_label }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-stone-500">Status Pembayaran:</span>
                    @if($sale->payment_status === 'paid')
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-800">
                            <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> Pembayaran Berhasil
                        </span>
                    @else
                        <span class="font-semibold text-amber-700">{{ $sale->payment_status_label }}</span>
                    @endif
                </div>
                @if($sale->payment_ref)
                <div class="flex justify-between items-center text-[11px]">
                    <span class="text-stone-500">No. Referensi:</span>
                    <span class="font-mono font-bold text-stone-800">{{ $sale->payment_ref }}</span>
                </div>
                @endif
                @if($sale->paid_at)
                <div class="flex justify-between items-center text-[11px]">
                    <span class="text-stone-500">Waktu Bayar:</span>
                    <span class="font-semibold text-stone-800">{{ $sale->paid_at->format('d/m/Y H:i') }} WIB</span>
                </div>
                @endif
                @if($sale->payment_status !== 'paid' && $sale->status === 'completed')
                <form action="{{ route('sales.simulate-payment', $sale) }}" method="POST" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full py-1.5 px-3 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold flex items-center justify-center space-x-1.5 transition">
                        <i class="fa-solid fa-credit-card text-xs"></i>
                        <span>Simulasi Pelunasan (Penilaian Kuliah)</span>
                    </button>
                </form>
                @endif
                <div class="flex justify-between">
                    <span class="text-stone-500">Catatan Pesanan:</span>
                    <span class="font-medium text-stone-700">{{ $sale->notes ?: '-' }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Sold Items Table -->
    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="p-6 border-b border-bakery-100 font-serif font-bold text-bakery-950 text-base flex items-center">
            <span class="mr-2">🥐</span> Rincian Pastry & Roti Terjual
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-bakery-100 text-xs">
                <thead class="bg-bakery-50/60 text-stone-500 text-left">
                    <tr>
                        <th class="px-6 py-3.5">No</th>
                        <th class="px-6 py-3.5">Varian Pastry & SKU</th>
                        <th class="px-6 py-3.5 text-center">Jumlah</th>
                        <th class="px-6 py-3.5 text-right">Harga Jual</th>
                        <th class="px-6 py-3.5 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @foreach ($sale->items as $idx => $item)
                    <tr class="hover:bg-bakery-50/40">
                        <td class="px-6 py-4 text-stone-400">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="font-serif font-bold text-sm text-bakery-950">{{ $item->product->name }}</div>
                            <div class="font-mono text-[10px] text-stone-400">{{ $item->product->sku }} &bull; {{ $item->product->category->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-stone-800">
                            {{ $item->quantity }} pcs
                        </td>
                        <td class="px-6 py-4 text-right text-stone-600">
                            Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-serif font-bold text-bakery-900 text-sm">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-bakery-50/80 font-bold border-t border-bakery-200">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right uppercase text-xs text-stone-600">Total Pembayaran:</td>
                        <td class="px-6 py-4 text-right text-lg font-serif text-amber-700">
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>
@endsection

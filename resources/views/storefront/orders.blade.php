@extends('layouts.app')

@section('title', 'Pesanan Pastry Saya - Nazelle Délices')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-bakery-200">
        <div>
            <div class="inline-flex items-center space-x-2 text-xs font-semibold text-bakery-600 uppercase tracking-wider mb-1">
                <span>🧁 Customer Portal</span>
            </div>
            <h1 class="text-3xl font-serif font-bold text-bakery-950">Pesanan Pastry Saya</h1>
            <p class="text-xs text-stone-500 mt-1">
                Riwayat pesanan roti & pastry atas nama <strong>{{ auth()->user()->name }}</strong>.
            </p>
        </div>

        <a href="{{ route('storefront.index') }}"
           class="inline-flex items-center space-x-2 px-5 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white rounded-xl text-xs font-semibold shadow-sm transition">
            <i class="fa-solid fa-plus text-[10px]"></i>
            <span>Pesan Pastry Baru</span>
        </a>
    </div>

    <!-- Orders List -->
    @if($sales->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-bakery-200 space-y-4">
            <div class="text-5xl">🥐</div>
            <h3 class="text-lg font-serif font-bold text-bakery-900">Belum Ada Riwayat Pesanan</h3>
            <p class="text-xs text-stone-500 max-w-sm mx-auto">
                Anda belum melakukan pembelian pastry. Silakan jelajahi menu croissant, sourdough, dan tart lezat kami.
            </p>
            <a href="{{ route('storefront.index') }}"
               class="inline-block px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl transition">
                Mulai Belanja Pastry
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach($sales as $sale)
                <div class="bg-white rounded-2xl border border-bakery-200 shadow-xs hover:shadow-md transition p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-bakery-100">
                        <div>
                            <div class="flex items-center space-x-3 flex-wrap gap-y-1">
                                <span class="font-mono font-bold text-sm text-bakery-900">{{ $sale->sale_number }}</span>
                                <span class="bg-amber-50 text-amber-900 border border-amber-200 text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    <i class="fa-regular fa-credit-card mr-1"></i> {{ $sale->payment_method_label }}
                                </span>
                                @if($sale->payment_status === 'paid')
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider inline-flex items-center">
                                        <i class="fa-solid fa-circle-check mr-1 text-[9px] text-emerald-600"></i> Pembayaran Berhasil
                                    </span>
                                @else
                                    <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider inline-flex items-center">
                                        <i class="fa-solid fa-clock mr-1 text-[9px] text-amber-600"></i> Belum Lunas
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs text-stone-400 mt-1">
                                <i class="fa-regular fa-calendar mr-1"></i> {{ $sale->sold_at->format('d M Y, H:i') }} WIB
                                @if($sale->notes)
                                    &bull; <span class="italic text-stone-500">{{ $sale->notes }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center space-x-3">
                            <div class="text-right">
                                <div class="text-[10px] text-stone-400 uppercase">Total Pesanan</div>
                                <div class="text-base font-serif font-bold text-bakery-900">
                                    Rp {{ number_format($sale->total, 0, ',', '.') }}
                                </div>
                            </div>
                            <a href="{{ route('sales.invoice', $sale) }}"
                               class="px-4 py-2 bg-bakery-100 hover:bg-bakery-200 text-bakery-900 rounded-xl text-xs font-semibold transition flex items-center space-x-1.5">
                                <i class="fa-solid fa-receipt"></i>
                                <span>Lihat Struk</span>
                            </a>
                        </div>
                    </div>

                    <!-- Items Preview -->
                    <div class="pt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($sale->items as $item)
                            <div class="flex items-center space-x-3 p-2 rounded-xl bg-bakery-50/60 border border-bakery-100 text-xs">
                                <img src="{{ $item->product->aesthetic_image }}" alt="{{ $item->product->name }}" class="w-10 h-10 rounded-lg object-cover">
                                <div class="min-w-0 flex-1">
                                    <div class="font-serif font-bold text-stone-800 truncate">{{ $item->product->name }}</div>
                                    <div class="text-[10px] text-stone-500">
                                        {{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pt-4">
            {{ $sales->links() }}
        </div>
    @endif

</div>
@endsection

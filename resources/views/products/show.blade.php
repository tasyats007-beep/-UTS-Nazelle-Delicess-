@extends('layouts.app')

@section('title', 'Detail Pastry - ' . $product->name)

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div class="flex items-center space-x-4">
            <img src="{{ $product->aesthetic_image }}" alt="{{ $product->name }}"
                 class="w-16 h-16 rounded-2xl object-cover border border-bakery-200 shadow-xs flex-shrink-0">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="font-mono text-[10px] bg-bakery-100 text-bakery-900 font-bold px-2 py-0.5 rounded-full">{{ $product->sku }}</span>
                    <span class="text-[10px] text-amber-800 bg-amber-50 border border-amber-200 font-semibold px-2 py-0.5 rounded-full">{{ $product->category->name }}</span>
                </div>
                <h1 class="text-2xl font-serif font-bold text-bakery-950 mt-1">{{ $product->name }}</h1>
                @if($product->description)
                    <p class="text-xs text-stone-500 mt-1 max-w-xl">{{ $product->description }}</p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('products.index') }}" class="px-4 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
                &larr; Daftar Menu
            </a>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('products.edit', $product) }}" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Pastry
            </a>
            @endif
        </div>
    </div>

    <!-- Product Key Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-{{ auth()->user()->isCustomer() ? '2' : '4' }} gap-4">
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
            <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Stok di Etalase</div>
            <div class="text-2xl font-serif font-bold {{ $product->isLowStock() ? 'text-rose-600' : 'text-bakery-950' }} mt-1">
                {{ $product->stock }} <span class="text-xs font-sans font-normal text-stone-400">pcs</span>
            </div>
            <div class="text-[11px] text-stone-500 mt-1">
                Status: {{ $product->stock > 0 ? ($product->isLowStock() ? 'Stok Menipis (Segera Bake!)' : 'Tersedia Siap Jual') : 'Stok Habis' }}
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
            <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Harga Jual Menu</div>
            <div class="text-2xl font-serif font-bold text-amber-700 mt-1">
                Rp {{ number_format($product->selling_price, 0, ',', '.') }}
            </div>
            <div class="text-[10px] text-stone-400 mt-1">Harga resmi per satuan</div>
        </div>

        @if(!auth()->user()->isCustomer())
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
            <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Harga Pokok Bahan</div>
            <div class="text-2xl font-serif font-bold text-stone-800 mt-1">
                Rp {{ number_format($product->purchase_price, 0, ',', '.') }}
            </div>
            <div class="text-[10px] text-stone-400 mt-1">Perkiraan modal bahan</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
            <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Margin Keuntungan</div>
            @php
                $margin = $product->selling_price - $product->purchase_price;
                $marginPct = $product->purchase_price > 0 ? ($margin / $product->purchase_price) * 100 : 0;
            @endphp
            <div class="text-2xl font-serif font-bold text-emerald-700 mt-1">
                Rp {{ number_format($margin, 0, ',', '.') }}
            </div>
            <div class="text-[10px] text-stone-500 mt-1">Margin: {{ number_format($marginPct, 1) }}%</div>
        </div>
        @endif
    </div>

    @if(!auth()->user()->isCustomer())
    <!-- Transaction Histories for this Product -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Purchase History -->
        <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
            <div class="p-5 border-b border-bakery-100 font-serif font-bold text-bakery-950 flex items-center justify-between">
                <span><i class="fa-solid fa-dolly mr-2 text-amber-600"></i> Riwayat Restock (Stock-In)</span>
                <span class="text-xs text-stone-400 font-sans font-normal">5 Terakhir</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-bakery-100 text-xs">
                    <thead class="bg-bakery-50/50 text-stone-500 text-left">
                        <tr>
                            <th class="px-5 py-3">No. PO</th>
                            <th class="px-5 py-3">Supplier</th>
                            <th class="px-5 py-3 text-center">Qty</th>
                            <th class="px-5 py-3 text-right">Biaya Satuan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bakery-100">
                        @forelse ($recentPurchases as $pi)
                        <tr>
                            <td class="px-5 py-3 font-mono">
                                <a href="{{ route('purchases.show', $pi->purchase) }}" class="text-bakery-900 font-bold hover:underline">
                                    {{ $pi->purchase->purchase_number }}
                                </a>
                                <div class="text-[10px] text-stone-400">{{ $pi->purchase->purchased_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-5 py-3 text-stone-700 font-medium">{{ $pi->purchase->supplier->name }}</td>
                            <td class="px-5 py-3 text-center font-bold text-emerald-700">+{{ $pi->quantity }}</td>
                            <td class="px-5 py-3 text-right font-mono text-stone-600">Rp {{ number_format($pi->unit_cost, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-6 text-center text-stone-400">Belum ada riwayat restock bahan untuk varian ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sales History -->
        <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
            <div class="p-5 border-b border-bakery-100 font-serif font-bold text-bakery-950 flex items-center justify-between">
                <span><i class="fa-solid fa-cart-shopping mr-2 text-emerald-600"></i> Riwayat Penjualan (Stock-Out)</span>
                <span class="text-xs text-stone-400 font-sans font-normal">5 Terakhir</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-bakery-100 text-xs">
                    <thead class="bg-bakery-50/50 text-stone-500 text-left">
                        <tr>
                            <th class="px-5 py-3">No. Invoice</th>
                            <th class="px-5 py-3">Pelanggan</th>
                            <th class="px-5 py-3 text-center">Qty</th>
                            <th class="px-5 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bakery-100">
                        @forelse ($recentSales as $si)
                        <tr>
                            <td class="px-5 py-3 font-mono">
                                <a href="{{ route('sales.show', $si->sale) }}" class="text-bakery-900 font-bold hover:underline">
                                    {{ $si->sale->sale_number }}
                                </a>
                                <div class="text-[10px] text-stone-400">{{ $si->sale->sold_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="px-5 py-3 text-stone-700 font-medium">{{ $si->sale->customer_name }}</td>
                            <td class="px-5 py-3 text-center font-bold text-amber-700">-{{ $si->quantity }}</td>
                            <td class="px-5 py-3 text-right font-serif font-bold text-stone-800">Rp {{ number_format($si->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-6 text-center text-stone-400">Belum ada riwayat penjualan untuk varian ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    @endif

</div>
@endsection

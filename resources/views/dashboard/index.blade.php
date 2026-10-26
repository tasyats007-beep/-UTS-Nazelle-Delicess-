@extends('layouts.app')

@section('title', 'Dashboard Operasional Toko Roti & Pastry')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    @if(auth()->user()->isCustomer())
    <!-- ========================================== -->
    <!-- CUSTOMER DASHBOARD VIEW                    -->
    <!-- ========================================== -->

    <!-- Customer Welcome Hero -->
    <div class="bg-gradient-to-r from-bakery-900 via-bakery-800 to-amber-900 rounded-3xl p-8 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10 max-w-2xl">
            <span class="bg-amber-400/20 text-amber-300 text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-amber-400/30">
                <i class="fa-solid fa-cookie-bite mr-1.5"></i> Pelanggan Setia Nazelle Délices
            </span>
            <h1 class="text-3xl sm:text-4xl font-serif font-bold mt-4 tracking-wide leading-tight">
                Bonjour, {{ auth()->user()->name }}! 🥐
            </h1>
            <p class="text-bakery-200 text-xs sm:text-sm mt-2 leading-relaxed">
                Nikmati aneka viennoiserie mentega Prancis, roti sourdough fermentasi alami, dan kue tart segar. Pesan dengan mudah dan cetak nota belanja Anda kapan saja.
            </p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('storefront.index') }}" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl font-bold text-xs shadow-md transition flex items-center space-x-2">
                    <i class="fa-solid fa-store"></i>
                    <span>Buka Menu & Pesan Pastry</span>
                </a>
                <a href="{{ route('customer.orders') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-xl font-semibold text-xs border border-white/20 transition flex items-center space-x-2">
                    <i class="fa-solid fa-receipt"></i>
                    <span>Riwayat Pesanan Saya</span>
                </a>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 text-white/5 text-[200px] select-none pointer-events-none font-serif">
            🥐
        </div>
    </div>

    <!-- Customer Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-bakery-100 flex items-center justify-center text-bakery-700 text-xl flex-shrink-0">
                <i class="fa-solid fa-bread-slice"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Katalog Pastry Aktif</div>
                <div class="text-2xl font-serif font-bold text-bakery-950">{{ number_format($totalProducts) }} <span class="text-xs font-sans font-normal text-stone-400">varian</span></div>
                <div class="text-xs text-bakery-700 hover:underline">
                    <a href="{{ route('storefront.index') }}">Lihat semua menu &rarr;</a>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Total Pesanan Saya</div>
                <div class="text-2xl font-serif font-bold text-amber-700">{{ number_format($customerSalesCount) }} <span class="text-xs font-sans font-normal text-stone-400">pesanan</span></div>
                <div class="text-[11px] text-stone-400">Tercatat di sistem</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Akumulasi Belanja</div>
                <div class="text-xl font-serif font-bold text-emerald-700">Rp {{ number_format($customerSalesTotal, 0, ',', '.') }}</div>
                <div class="text-[11px] text-stone-400">Total belanja pastry</div>
            </div>
        </div>
    </div>

    <!-- Customer Recent Orders -->
    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="p-6 border-b border-bakery-100 flex items-center justify-between">
            <div>
                <h2 class="font-serif font-bold text-bakery-950 text-lg flex items-center">
                    <i class="fa-solid fa-clock-rotate-left mr-2 text-bakery-600"></i> Pesanan Pastry Terakhir Saya
                </h2>
                <p class="text-xs text-stone-400 mt-0.5">Nota dan rincian transaksi belanja pastry Anda</p>
            </div>
            <a href="{{ route('customer.orders') }}" class="text-xs font-semibold text-bakery-700 hover:text-bakery-900">
                Lihat Semua &rarr;
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-bakery-100 text-sm">
                <thead class="bg-bakery-50/50 text-stone-500 text-xs text-left">
                    <tr>
                        <th class="px-6 py-3.5">No. Nota / Invoice</th>
                        <th class="px-6 py-3.5">Waktu Pembelian</th>
                        <th class="px-6 py-3.5 text-right">Total Bayar</th>
                        <th class="px-6 py-3.5 text-center">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($customerSales as $sale)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <td class="px-6 py-4">
                            <span class="font-mono text-xs font-bold text-bakery-950">{{ $sale->sale_number }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-stone-600">
                            {{ $sale->sold_at->format('d/m/Y H:i') }} WIB
                        </td>
                        <td class="px-6 py-4 text-right font-serif font-bold text-bakery-900 text-sm">
                            Rp {{ number_format($sale->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($sale->status === 'completed')
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Lunas</span>
                            @else
                                <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Dibatalkan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('sales.invoice', $sale) }}" target="_blank"
                                class="text-xs font-semibold text-bakery-800 bg-bakery-100 hover:bg-bakery-200 px-3 py-1.5 rounded-lg transition inline-flex items-center space-x-1.5">
                                <i class="fa-solid fa-print text-[11px]"></i>
                                <span>Cetak Nota</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-stone-400 text-xs">
                            Belum ada transaksi pesanan yang tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @else
    <!-- ========================================== -->
    <!-- ADMIN & STAFF BUSINESS DASHBOARD VIEW      -->
    <!-- ========================================== -->

    <!-- Header Section with Quick Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                <i class="fa-solid fa-chart-line"></i>
                <span>Panel Manajemen Toko Roti & Pastry</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Dashboard Operasional & Inventaris
            </h1>
            <p class="text-xs sm:text-sm text-stone-500 mt-1">
                Selamat bekerja, <strong>{{ auth()->user()->name }}</strong> ({{ auth()->user()->isAdmin() ? 'Owner & Administrator' : 'Staff Kasir & Baker' }}).
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ route('sales.create') }}" class="inline-flex items-center px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition">
                <i class="fa-solid fa-cash-register mr-2"></i> Buka Kasir (POS)
            </a>
            <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition">
                <i class="fa-solid fa-dolly mr-2"></i> Restock Bahan (Beli)
            </a>
            <a href="{{ route('storefront.index') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-100 hover:bg-bakery-200 text-bakery-900 text-xs font-bold rounded-xl transition">
                <i class="fa-solid fa-store mr-1.5"></i> Toko Depan
            </a>
        </div>
    </div>

    <!-- Baker's Low Stock Alert Banner (If Any) -->
    @if($lowStockCount > 0)
    <div class="p-5 bg-gradient-to-r from-amber-500/15 via-rose-500/10 to-amber-500/10 border-l-4 border-amber-500 rounded-2xl shadow-xs flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="flex items-start space-x-3">
            <span class="text-2xl">⚠️</span>
            <div>
                <h4 class="font-serif font-bold text-stone-900 text-sm">Peringatan Pembuat Roti (Baker's Alert): {{ $lowStockCount }} Varian Pastry Menipis!</h4>
                <p class="text-xs text-stone-600 mt-0.5">
                    Beberapa varian roti atau pastry telah menyentuh batas minimum stok. Siapkan batch adonan pemanggangan berikutnya atau restock bahan baku.
                </p>
            </div>
        </div>
        <a href="{{ route('products.index', ['low_stock' => 1]) }}"
           class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold whitespace-nowrap shadow-xs transition">
            Lihat Produk Perlu Restock &rarr;
        </a>
    </div>
    @endif

    <!-- Aggregate Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- Total Products Card -->
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-bakery-100 flex items-center justify-center text-bakery-700 text-xl flex-shrink-0">
                <i class="fa-solid fa-bread-slice"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Varian Roti & Pastry</div>
                <div class="text-2xl font-serif font-bold text-bakery-950">{{ number_format($totalProducts) }} <span class="text-xs font-sans font-normal text-stone-400">menu</span></div>
                <div class="text-xs text-bakery-700 hover:underline">
                    <a href="{{ route('products.index') }}">Kelola master &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Low Stock Warning Card -->
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4 {{ $lowStockCount > 0 ? 'bg-amber-50/40' : '' }}">
            <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Stok Kritis / Menipis</div>
                <div class="text-2xl font-serif font-bold text-rose-600">{{ number_format($lowStockCount) }} <span class="text-xs font-sans font-normal text-stone-400">varian</span></div>
                <div class="text-xs text-rose-600 hover:underline">
                    <a href="{{ route('products.index', ['low_stock' => 1]) }}">Perlu dipanggang &rarr;</a>
                </div>
            </div>
        </div>

        <!-- Sales Today Card -->
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl flex-shrink-0">
                <i class="fa-solid fa-cash-register"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Penjualan Hari Ini</div>
                <div class="text-xl font-serif font-bold text-emerald-600">Rp {{ number_format($todaySalesAmount, 0, ',', '.') }}</div>
                <div class="text-[10px] text-stone-400">Bulan ini: Rp {{ number_format($monthSalesAmount, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Total Purchases (Expenses) Card -->
        <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-700 text-xl flex-shrink-0">
                <i class="fa-solid fa-dolly"></i>
            </div>
            <div>
                <div class="text-[10px] font-bold text-stone-400 uppercase tracking-wider">Pengadaan Bahan Baku</div>
                <div class="text-xl font-serif font-bold text-stone-800">Rp {{ number_format($totalPurchasesAmount, 0, ',', '.') }}</div>
                <div class="text-[10px] text-stone-400">{{ $totalPurchasesCount }} transaksi restock</div>
            </div>
        </div>

    </div>

    <!-- Dual Table Grid: Recent Sales & Low Stock List -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <!-- Recent Sales Table (8 cols) -->
        <div class="lg:col-span-8 bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
            <div class="p-6 border-b border-bakery-100 flex items-center justify-between">
                <div>
                    <h3 class="font-serif font-bold text-bakery-950 text-lg flex items-center">
                        <i class="fa-solid fa-receipt mr-2 text-amber-600"></i> Transaksi Penjualan Terakhir
                    </h3>
                    <p class="text-xs text-stone-400 mt-0.5">Penjualan kasir toko dan pemesanan online</p>
                </div>
                <a href="{{ route('sales.index') }}" class="text-xs font-semibold text-bakery-700 hover:text-bakery-900">
                    Lihat Semua &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-bakery-100 text-xs">
                    <thead class="bg-bakery-50/50 text-stone-500 text-left">
                        <tr>
                            <th class="px-5 py-3 font-semibold">No. Invoice</th>
                            <th class="px-5 py-3 font-semibold">Pelanggan</th>
                            <th class="px-5 py-3 font-semibold">Petugas/Kasir</th>
                            <th class="px-5 py-3 font-semibold text-right">Total</th>
                            <th class="px-5 py-3 font-semibold text-center">Status</th>
                            <th class="px-5 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-bakery-100">
                        @forelse($recentSales as $sale)
                        <tr class="hover:bg-bakery-50/40 transition">
                            <td class="px-5 py-3.5 font-mono font-bold text-bakery-950">{{ $sale->sale_number }}</td>
                            <td class="px-5 py-3.5 text-stone-700 font-medium">{{ $sale->customer_name }}</td>
                            <td class="px-5 py-3.5 text-stone-500">{{ $sale->user->name }}</td>
                            <td class="px-5 py-3.5 text-right font-serif font-bold text-bakery-900 text-sm">
                                Rp {{ number_format($sale->total, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @if($sale->status === 'completed')
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Lunas</span>
                                @else
                                    <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">Batal</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-right space-x-1">
                                <a href="{{ route('sales.show', $sale) }}" class="text-bakery-700 hover:text-bakery-950 font-semibold">Detail</a>
                                <span class="text-stone-300">|</span>
                                <a href="{{ route('sales.invoice', $sale) }}" target="_blank" class="text-amber-600 hover:text-amber-800 font-semibold">Struk</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-stone-400">Belum ada transaksi penjualan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Items Box (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-6 border-b border-bakery-100">
                    <h3 class="font-serif font-bold text-bakery-950 text-lg flex items-center">
                        <i class="fa-solid fa-fire-burner mr-2 text-rose-500"></i> Status Kritis Stok Pastry
                    </h3>
                    <p class="text-xs text-stone-400 mt-0.5">Produk yang stoknya di bawah batas minimum</p>
                </div>

                <div class="divide-y divide-bakery-100 p-2">
                    @forelse($lowStockProducts as $prod)
                    <div class="p-4 flex items-center space-x-3 hover:bg-bakery-50/40 rounded-2xl transition">
                        <img src="{{ $prod->aesthetic_image }}" alt="{{ $prod->name }}" class="w-12 h-12 object-cover rounded-xl border border-bakery-200">
                        <div class="flex-1 min-w-0">
                            <div class="font-serif font-bold text-xs text-bakery-950 truncate">{{ $prod->name }}</div>
                            <div class="text-[10px] text-stone-400 font-mono">{{ $prod->sku }}</div>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="text-[11px] font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-full">
                                    Stok: {{ $prod->stock }} pcs
                                </span>
                                <span class="text-[10px] text-stone-400">Min: {{ $prod->minimum_stock }} pcs</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-stone-400 text-xs">
                        <i class="fa-regular fa-circle-check text-emerald-500 text-2xl mb-2 block"></i>
                        Semua stok varian pastry dalam kondisi aman & mencukupi!
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="p-5 bg-bakery-50/50 border-t border-bakery-100">
                <a href="{{ route('purchases.create') }}" class="w-full py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white rounded-xl text-xs font-semibold flex items-center justify-center space-x-2 transition">
                    <i class="fa-solid fa-cart-flatbed"></i>
                    <span>Buat Pembelian Restock Bahan</span>
                </a>
            </div>
        </div>

    </div>

    @endif

</div>
@endsection

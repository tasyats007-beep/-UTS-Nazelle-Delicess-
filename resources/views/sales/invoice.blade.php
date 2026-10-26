<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembelian Pastry - {{ $sale->sale_number }} - Nazelle Délices</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; }
            .print-shadow-none { box-shadow: none !important; border: 1px solid #ccc !important; }
        }
    </style>
</head>
<body class="bg-[#FAF7F2] py-8 px-4 font-sans text-stone-800 antialiased">

    <div class="max-w-xl mx-auto">
        <!-- Floating Actions Bar -->
        <div class="mb-4 flex items-center justify-between no-print">
            @php
                if (auth()->check()) {
                    $backUrl = auth()->user()->isCustomer() ? route('customer.orders') : route('sales.show', $sale);
                } else {
                    $backUrl = route('storefront.index');
                }
            @endphp
            <a href="{{ $backUrl }}"
               class="text-xs font-semibold text-stone-600 hover:text-stone-900 flex items-center space-x-1.5">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Halaman Sebelumnya</span>
            </a>
            <div class="flex items-center space-x-2">
                <a href="{{ route('storefront.index') }}" class="px-3 py-1.5 bg-white border border-stone-200 text-stone-700 hover:bg-stone-50 text-xs font-semibold rounded-lg shadow-xs transition">
                    <i class="fa-solid fa-store mr-1"></i> Menu Toko
                </a>
                <button onclick="window.print()" class="px-4 py-1.5 bg-[#3D2010] hover:bg-[#261309] text-white text-xs font-semibold rounded-lg shadow transition flex items-center space-x-1.5">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Nota</span>
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3.5 bg-emerald-50 border border-emerald-300 rounded-2xl text-xs text-emerald-900 flex items-center space-x-2.5 no-print shadow-xs">
                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Receipt Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-amber-900/10 p-8 print-shadow-none relative overflow-hidden">
            
            <!-- Top French Bakery Header -->
            <div class="text-center pb-6 border-b border-dashed border-stone-200">
                <div class="text-3xl mb-1">🥐</div>
                <h1 class="text-2xl font-serif font-bold text-stone-900 tracking-wide">Nazelle Délices</h1>
                <p class="text-[10px] tracking-[0.25em] uppercase font-bold text-amber-700">Pâtisserie & Boulangerie Artisanale</p>
                <p class="text-xs text-stone-500 mt-1.5">Jl. Patisserie No. 42, Senopati, Jakarta Selatan</p>
                <p class="text-xs text-stone-400">Telp: (021) 7890-1234 &bull; IG: @nazelle.delices</p>
            </div>

            <!-- Receipt Meta Info -->
            <div class="grid grid-cols-2 gap-4 py-5 border-b border-dashed border-stone-200 text-xs">
                <div class="space-y-1">
                    <div>
                        <span class="text-stone-400 text-[10px] uppercase font-bold">No. Pesanan:</span>
                        <div class="font-mono font-bold text-amber-800 text-sm">{{ $sale->sale_number }}</div>
                    </div>
                    <div>
                        <span class="text-stone-400 text-[10px] uppercase font-bold">Nama Pemesan:</span>
                        <div class="font-bold text-stone-800">{{ $sale->customer_name }}</div>
                    </div>
                    <div>
                        <span class="text-stone-400 text-[10px] uppercase font-bold">Metode Pembayaran:</span>
                        <div class="font-semibold text-stone-700">{{ $sale->payment_method_label }}</div>
                    </div>
                </div>

                <div class="space-y-1 text-right">
                    <div>
                        <span class="text-stone-400 text-[10px] uppercase font-bold">Waktu Pesanan:</span>
                        <div class="text-stone-700">{{ $sale->sold_at->format('d/m/Y H:i') }} WIB</div>
                    </div>
                    <div>
                        <span class="text-stone-400 text-[10px] uppercase font-bold">Status Pembayaran:</span>
                        <div>
                            @if($sale->payment_status === 'paid')
                                <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase tracking-wider inline-flex items-center">
                                    <i class="fa-solid fa-circle-check mr-1 text-[9px] text-emerald-600"></i> Pembayaran Berhasil
                                </span>
                            @else
                                <span class="bg-amber-100 text-amber-900 text-[10px] font-bold px-2.5 py-0.5 rounded-full tracking-wider inline-flex items-center">
                                    <i class="fa-solid fa-clock mr-1 text-[9px] text-amber-600"></i> Belum Lunas (Bayar di Kasir)
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        @if($sale->status === 'completed')
                            <span class="text-[10px] text-emerald-700 font-semibold"><i class="fa-solid fa-check mr-1"></i> Pesanan Diterima</span>
                        @else
                            <span class="bg-rose-100 text-rose-800 text-[9px] font-bold px-2 py-0.5 rounded-full uppercase">Dibatalkan</span>
                        @endif
                    </div>
                </div>
            </div>

            @if($sale->payment_status === 'paid')
                <!-- Bukti Pembayaran Terverifikasi -->
                <div class="my-5 p-4 rounded-2xl bg-gradient-to-br from-emerald-50/90 to-amber-50/40 border border-emerald-200/90 shadow-xs">
                    <div class="flex items-center justify-between pb-3 border-b border-emerald-200/60 mb-3">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs shadow-xs">
                                <i class="fa-solid fa-check"></i>
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-emerald-950 font-serif text-sm">Bukti Pembayaran Terverifikasi</h3>
                                <p class="text-[10px] text-emerald-700">Transaksi lunas &amp; terekam di sistem Nazelle Délices</p>
                            </div>
                        </div>
                        <!-- Label kecil Simulasi Pembayaran untuk keperluan penilaian kuliah -->
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-semibold bg-amber-100/90 text-amber-900 border border-amber-300 shadow-xs">
                            <i class="fa-solid fa-graduation-cap mr-1 text-[10px] text-amber-700"></i> Simulasi Pembayaran
                        </span>
                    </div>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 text-xs">
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase font-bold block">No. Referensi:</span>
                            <span class="font-mono font-bold text-stone-800 text-[11px]">{{ $sale->payment_ref ?: 'SIM-' . $sale->sale_number }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase font-bold block">Waktu Bayar:</span>
                            <span class="font-medium text-stone-800 text-[11px]">{{ $sale->paid_at ? $sale->paid_at->format('d/m/Y H:i') . ' WIB' : $sale->sold_at->format('d/m/Y H:i') . ' WIB' }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase font-bold block">Metode:</span>
                            <span class="font-bold text-stone-800 text-[11px]">{{ $sale->payment_method_label }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase font-bold block">Status Transaksi:</span>
                            <span class="inline-flex items-center text-emerald-700 font-bold text-[11px]">
                                <i class="fa-solid fa-circle-check mr-1 text-emerald-600 text-[10px]"></i> Pembayaran Berhasil
                            </span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase font-bold block">Total Dibayar:</span>
                            <span class="font-serif font-bold text-emerald-800 text-sm">Rp {{ number_format($sale->total, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-stone-400 uppercase font-bold block">Keterangan:</span>
                            <span class="text-stone-600 text-[11px]">Penilaian Kuliah</span>
                        </div>
                    </div>
                </div>
            @else
                @if($sale->payment_status === 'unconfigured_qris')
                    <div class="my-4 p-3.5 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 flex items-start space-x-2.5">
                        <i class="fa-solid fa-circle-info text-amber-600 text-sm mt-0.5"></i>
                        <div>
                            <div class="font-bold">Metode QRIS Toko Belum Dikonfigurasi</div>
                            <div class="text-[11px] text-amber-800 mt-0.5">QRIS resmi Nazelle Délices belum dikonfigurasi. Silakan tunjukkan nomor pesanan <strong>#{{ $sale->sale_number }}</strong> dan lakukan pembayaran di kasir toko saat mengambil pesanan, atau gunakan tombol simulasi pembayaran di bawah.</div>
                        </div>
                    </div>
                @elseif($sale->payment_status === 'unconfigured_bank')
                    <div class="my-4 p-3.5 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 flex items-start space-x-2.5">
                        <i class="fa-solid fa-circle-info text-amber-600 text-sm mt-0.5"></i>
                        <div>
                            <div class="font-bold">Rekening Transfer Toko Belum Dikonfigurasi</div>
                            <div class="text-[11px] text-amber-800 mt-0.5">Rekening bank resmi Nazelle Délices belum dikonfigurasi. Silakan tunjukkan nomor pesanan <strong>#{{ $sale->sale_number }}</strong> dan lakukan pembayaran di kasir toko saat mengambil pesanan, atau gunakan tombol simulasi pembayaran di bawah.</div>
                        </div>
                    </div>
                @elseif($sale->payment_method === 'cashier')
                    <div class="my-4 p-3.5 bg-bakery-50 border border-bakery-200 rounded-2xl text-xs text-stone-700 flex items-start space-x-2.5">
                        <i class="fa-solid fa-cash-register text-amber-700 text-sm mt-0.5"></i>
                        <div>
                            <div class="font-bold text-stone-900">Pembayaran di Kasir Toko</div>
                            <div class="text-[11px] text-stone-600 mt-0.5">Silakan tunjukkan nomor pesanan <strong>#{{ $sale->sale_number }}</strong> kepada kasir saat mengambil pesanan di butik kami, atau gunakan tombol simulasi pembayaran di bawah.</div>
                        </div>
                    </div>
                @endif

                <!-- Card Simulasi Pembayaran (Untuk Keperluan Penilaian Kuliah) -->
                <div class="my-4 p-4 bg-amber-50/80 border border-amber-300 rounded-2xl no-print">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                            <span class="font-bold text-xs text-amber-950 font-serif text-sm">Simulasi Pembayaran</span>
                        </div>
                        <!-- Label kecil Simulasi Pembayaran untuk penilaian kuliah -->
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-200 text-amber-900 border border-amber-400">
                            <i class="fa-solid fa-graduation-cap mr-1 text-[9px]"></i> Simulasi Pembayaran
                        </span>
                    </div>
                    <p class="text-[11px] text-amber-800 mb-3 leading-relaxed">
                        Tekan tombol di bawah untuk menyimulasikan transaksi pembayaran tanpa gateway sungguhan agar status pesanan berubah menjadi <strong>Pembayaran Berhasil</strong> dan tersimpan di database.
                    </p>
                    <form action="{{ route('sales.simulate-payment', $sale) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2.5 px-4 bg-[#3D2010] hover:bg-[#261309] text-white font-semibold text-xs rounded-xl shadow transition flex items-center justify-center space-x-2 hover:scale-[1.01] active:scale-[0.99]">
                            <i class="fa-solid fa-credit-card text-amber-300"></i>
                            <span>Bayar Sekarang (Simulasi Pembayaran Berhasil)</span>
                        </button>
                    </form>
                </div>
            @endif

            <!-- Order Items Table -->
            <div class="py-5 border-b border-dashed border-stone-200">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="text-stone-400 text-[10px] uppercase font-bold text-left border-b border-stone-100 pb-2">
                            <th class="pb-2">Varian Pastry</th>
                            <th class="pb-2 text-center">Qty</th>
                            <th class="pb-2 text-right">Harga</th>
                            <th class="pb-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($sale->items as $item)
                        <tr>
                            <td class="py-3 pr-2">
                                <div class="font-bold text-stone-900 font-serif text-sm">{{ $item->product->name }}</div>
                                <div class="font-mono text-[9px] text-stone-400">SKU: {{ $item->product->sku }}</div>
                            </td>
                            <td class="py-3 text-center font-bold text-stone-700">{{ $item->quantity }}</td>
                            <td class="py-3 text-right text-stone-500">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="py-3 text-right font-bold text-stone-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Grand Total Section -->
            <div class="py-5 space-y-2 border-b border-dashed border-stone-200">
                <div class="flex justify-between items-center text-xs text-stone-500">
                    <span>Total Item:</span>
                    <span class="font-bold text-stone-700">{{ $sale->items->sum('quantity') }} pcs</span>
                </div>
                <div class="flex justify-between items-center text-sm font-bold text-stone-900 pt-1">
                    <span class="font-serif text-base">Total Tagihan:</span>
                    <span class="font-serif text-2xl font-bold text-amber-700">
                        Rp {{ number_format($sale->total, 0, ',', '.') }}
                    </span>
                </div>
                @if($sale->notes)
                <div class="text-[11px] text-stone-500 italic pt-1">
                    Catatan: {{ $sale->notes }}
                </div>
                @endif
            </div>

            <!-- Receipt Footer & Stamp -->
            <div class="pt-6 text-center space-y-2 text-stone-400 text-xs">
                <p class="font-serif italic text-sm text-stone-700">
                    &ldquo;Merci pour votre visite!&rdquo;
                </p>
                <p class="text-[11px] text-stone-500">
                    Selamat menikmati pastry hangat kami bersama secangkir kopi.<br>
                    Produk sebaiknya dinikmati pada hari yang sama atau hangatkan 3 menit di oven 180°C.
                </p>
                <div class="pt-2 text-[9px] text-stone-300 font-mono">
                    ID Transaksi: {{ $sale->id }} &bull; Nazelle Délices POS System
                </div>
            </div>

        </div>
    </div>

</body>
</html>

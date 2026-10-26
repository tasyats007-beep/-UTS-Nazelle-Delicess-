@extends('layouts.app')

@section('title', 'Kasir POS & Penjualan Roti - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-amber-600 mb-1">
                <i class="fa-solid fa-cash-register"></i>
                <span>Point of Sale (POS) & Penjualan Kasir</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Kasir Pemesanan Roti & Pastry
            </h1>
            <p class="text-xs text-stone-500 mt-1">
                Pilih pastry dari menu di sebelah kiri untuk menambah pesanan secara cepat, atau pilih melalui form. Stok terpotong otomatis dan atomik.
            </p>
        </div>

        <a href="{{ route('sales.index') }}" class="inline-flex items-center space-x-2 text-xs font-semibold text-bakery-700 hover:text-bakery-900 bg-white border border-bakery-200 px-4 py-2 rounded-xl transition">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Riwayat Penjualan</span>
        </a>
    </div>

    <form action="{{ route('sales.store') }}" method="POST" id="posForm">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            <!-- LEFT: Quick Pastry Selector Grid (7 cols) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-white p-5 rounded-3xl border border-bakery-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif font-bold text-base text-bakery-950 flex items-center">
                            <span class="mr-2">🥐</span> Pilih Menu Cepat (Klik untuk Menambah)
                        </h3>
                        <span class="text-[11px] text-stone-400">Total {{ $products->count() }} varian siap jual</span>
                    </div>

                    <!-- Search & Filter in POS -->
                    <div class="relative">
                        <input type="text" id="posProductSearch" oninput="filterPosProducts()"
                               placeholder="Cari nama pastry atau SKU..."
                               class="w-full pl-9 pr-3 py-2 text-xs border border-bakery-200 rounded-xl bg-bakery-50/50 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-stone-400 text-xs"></i>
                    </div>

                    <!-- Pastry Tile Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 max-h-[520px] overflow-y-auto pr-1" id="posProductGrid">
                        @foreach($products as $p)
                            <div class="pos-item-card p-3 rounded-2xl border border-bakery-200 hover:border-amber-400 hover:shadow-md bg-white transition cursor-pointer flex flex-col justify-between select-none group"
                                 data-name="{{ strtolower($p->name) }}"
                                 data-sku="{{ strtolower($p->sku) }}"
                                 onclick="addPosProduct({{ $p->id }}, '{{ addslashes($p->name) }}', {{ $p->selling_price }}, {{ $p->stock }}, '{{ $p->aesthetic_image }}')">
                                
                                <div class="space-y-2">
                                    <div class="relative h-24 rounded-xl overflow-hidden bg-bakery-100">
                                        <img src="{{ $p->aesthetic_image }}" alt="{{ $p->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        <span class="absolute top-1.5 right-1.5 bg-black/60 backdrop-blur-xs text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">
                                            Stok: {{ $p->stock }}
                                        </span>
                                    </div>
                                    <div class="font-serif font-bold text-xs text-bakery-950 line-clamp-2 leading-tight group-hover:text-amber-700">
                                        {{ $p->name }}
                                    </div>
                                </div>

                                <div class="pt-2 mt-2 border-t border-bakery-100 flex items-center justify-between">
                                    <span class="text-[11px] font-bold text-bakery-900 font-serif">
                                        Rp {{ number_format($p->selling_price, 0, ',', '.') }}
                                    </span>
                                    <span class="w-6 h-6 rounded-lg bg-amber-50 text-amber-700 flex items-center justify-center text-xs font-bold group-hover:bg-amber-500 group-hover:text-white transition">
                                        +
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- RIGHT: Cashier Register & Order Items (5 cols) -->
            <div class="lg:col-span-5 space-y-5">
                <div class="bg-white p-6 rounded-3xl border border-bakery-200 shadow-sm space-y-5">

                    <!-- Customer & Transaction Header -->
                    <div class="space-y-3 pb-4 border-b border-bakery-100">
                        <div class="flex items-center justify-between">
                            <h3 class="font-serif font-bold text-base text-bakery-950">Nota Transaksi Kasir</h3>
                            <span class="text-[10px] text-stone-400 font-mono">{{ now()->format('d/m/Y H:i') }}</span>
                        </div>

                        <div>
                            <label for="customer_name" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                                Nama Pelanggan
                            </label>
                            <input type="text" name="customer_name" id="customer_name"
                                   value="{{ old('customer_name', 'Pelanggan Walk-In Toko') }}" required
                                   placeholder="Nama Pembeli / Meja"
                                   class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/40 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div>
                                <label for="sold_at" class="block text-[10px] font-semibold text-stone-600 mb-1">Waktu Transaksi</label>
                                <input type="datetime-local" name="sold_at" id="sold_at"
                                       value="{{ old('sold_at', now()->format('Y-m-d\TH:i')) }}" required
                                       class="w-full px-2.5 py-1.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/40 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div>
                                <label for="notes" class="block text-[10px] font-semibold text-stone-600 mb-1">Catatan / Keterangan</label>
                                <input type="text" name="notes" id="notes" value="{{ old('notes') }}"
                                       placeholder="Tunai / QRIS / Bungkus"
                                       class="w-full px-2.5 py-1.5 border border-bakery-200 rounded-xl text-xs bg-bakery-50/40 focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                        </div>
                    </div>

                    <!-- Selected Items List -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-stone-600">Daftar Item Terpilih</span>
                            <span class="text-[11px] text-stone-400" id="posTotalItemCount">0 item</span>
                        </div>

                        <div id="posItemsList" class="space-y-2 max-h-60 overflow-y-auto pr-1">
                            <div class="text-center py-8 text-stone-400 text-xs" id="posEmptyPrompt">
                                <span class="text-3xl block mb-1">🧺</span>
                                Belum ada pastry dipilih. Klik salah satu menu di sebelah kiri.
                            </div>
                        </div>

                        <!-- Hidden Form Inputs Container -->
                        <div id="posHiddenInputs"></div>
                    </div>

                    <!-- Payment Calculations -->
                    <div class="pt-4 border-t border-bakery-100 space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-stone-500">Total Tagihan:</span>
                            <span class="text-2xl font-serif font-bold text-bakery-950" id="posGrandTotalDisplay">Rp 0</span>
                        </div>

                        <!-- Cash & Change Calculator -->
                        <div class="p-3 bg-bakery-50/70 rounded-2xl border border-bakery-200 space-y-2">
                            <div class="flex items-center justify-between text-xs">
                                <label for="cashReceived" class="font-semibold text-stone-700">Uang Tunai Diterima:</label>
                                <input type="number" id="cashReceived" oninput="calculateChange()"
                                       placeholder="Rp 0"
                                       class="w-36 px-2.5 py-1 text-right text-xs border border-bakery-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                            </div>
                            <div class="flex items-center justify-between text-xs pt-1 border-t border-bakery-200">
                                <span class="text-stone-600 font-semibold">Kembalian:</span>
                                <span class="font-bold font-serif text-sm text-emerald-700" id="posChangeDisplay">Rp 0</span>
                            </div>
                        </div>

                        <button type="submit" id="posSubmitBtn" disabled
                                class="w-full py-3.5 bg-amber-500 hover:bg-amber-600 disabled:bg-stone-300 disabled:cursor-not-allowed text-white font-bold text-xs uppercase tracking-wider rounded-xl shadow-md transition flex items-center justify-center space-x-2">
                            <i class="fa-solid fa-check"></i>
                            <span>Selesaikan Transaksi & Cetak Nota</span>
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </form>

</div>

@push('scripts')
<script>
    let posCart = {};

    function formatRupiah(num) {
        return 'Rp ' + Number(num).toLocaleString('id-ID');
    }

    function addPosProduct(id, name, price, stock, image) {
        if (posCart[id]) {
            if (posCart[id].qty < stock) {
                posCart[id].qty += 1;
            } else {
                alert('Stok tidak mencukupi. Maksimum tersedia: ' + stock + ' pcs.');
                return;
            }
        } else {
            posCart[id] = {
                id: id,
                name: name,
                price: price,
                stock: stock,
                image: image,
                qty: 1
            };
        }

        renderPosCart();
    }

    function updatePosQty(id, delta) {
        if (!posCart[id]) return;
        let newQty = posCart[id].qty + delta;
        if (newQty <= 0) {
            delete posCart[id];
        } else if (newQty > posCart[id].stock) {
            alert('Stok maksimum tersedia: ' + posCart[id].stock + ' pcs.');
            return;
        } else {
            posCart[id].qty = newQty;
        }
        renderPosCart();
    }

    function removePosItem(id) {
        delete posCart[id];
        renderPosCart();
    }

    function renderPosCart() {
        const listEl = document.getElementById('posItemsList');
        const hiddenEl = document.getElementById('posHiddenInputs');
        const grandTotalEl = document.getElementById('posGrandTotalDisplay');
        const countEl = document.getElementById('posTotalItemCount');
        const submitBtn = document.getElementById('posSubmitBtn');

        const keys = Object.keys(posCart);
        let grandTotal = 0;
        let totalCount = 0;

        hiddenEl.innerHTML = '';

        if (keys.length === 0) {
            listEl.innerHTML = `
                <div class="text-center py-8 text-stone-400 text-xs">
                    <span class="text-3xl block mb-1">🧺</span>
                    Belum ada pastry dipilih. Klik salah satu menu di sebelah kiri.
                </div>
            `;
            grandTotalEl.textContent = 'Rp 0';
            countEl.textContent = '0 item';
            submitBtn.disabled = true;
            calculateChange();
            return;
        }

        let html = '';
        keys.forEach((key, index) => {
            const item = posCart[key];
            const subtotal = item.price * item.qty;
            grandTotal += subtotal;
            totalCount += item.qty;

            html += `
                <div class="p-2.5 bg-bakery-50/80 border border-bakery-200 rounded-xl flex items-center justify-between text-xs">
                    <div class="flex-1 min-w-0 pr-2">
                        <div class="font-serif font-bold text-bakery-950 truncate">${item.name}</div>
                        <div class="text-[10px] text-stone-500">${formatRupiah(item.price)} x ${item.qty} = <strong class="text-bakery-900">${formatRupiah(subtotal)}</strong></div>
                    </div>
                    <div class="flex items-center space-x-1.5 flex-shrink-0">
                        <button type="button" onclick="updatePosQty(${item.id}, -1)" class="w-6 h-6 rounded bg-white border border-stone-200 text-stone-700 font-bold hover:bg-stone-100 flex items-center justify-center">-</button>
                        <span class="font-bold text-xs text-stone-800 w-5 text-center">${item.qty}</span>
                        <button type="button" onclick="updatePosQty(${item.id}, 1)" class="w-6 h-6 rounded bg-white border border-stone-200 text-stone-700 font-bold hover:bg-stone-100 flex items-center justify-center">+</button>
                        <button type="button" onclick="removePosItem(${item.id})" class="text-stone-400 hover:text-rose-500 ml-1">
                            <i class="fa-regular fa-trash-can text-xs"></i>
                        </button>
                    </div>
                </div>
            `;

            hiddenEl.innerHTML += `
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
            `;
        });

        listEl.innerHTML = html;
        grandTotalEl.textContent = formatRupiah(grandTotal);
        countEl.textContent = totalCount + ' pcs';
        submitBtn.disabled = false;
        calculateChange();
    }

    function calculateChange() {
        let total = 0;
        Object.keys(posCart).forEach(key => {
            total += posCart[key].price * posCart[key].qty;
        });

        const cashInput = parseFloat(document.getElementById('cashReceived').value) || 0;
        const changeEl = document.getElementById('posChangeDisplay');

        if (cashInput >= total && total > 0) {
            changeEl.textContent = formatRupiah(cashInput - total);
            changeEl.className = 'font-bold font-serif text-sm text-emerald-700';
        } else if (cashInput > 0 && cashInput < total) {
            changeEl.textContent = 'Kurang ' + formatRupiah(total - cashInput);
            changeEl.className = 'font-bold font-serif text-xs text-rose-600';
        } else {
            changeEl.textContent = 'Rp 0';
            changeEl.className = 'font-bold font-serif text-sm text-stone-500';
        }
    }

    function filterPosProducts() {
        const query = document.getElementById('posProductSearch').value.toLowerCase();
        const cards = document.querySelectorAll('.pos-item-card');

        cards.forEach(card => {
            const name = card.getAttribute('data-name');
            const sku = card.getAttribute('data-sku');
            if (name.includes(query) || sku.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection

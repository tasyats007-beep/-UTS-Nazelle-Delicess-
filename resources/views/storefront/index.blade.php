@extends('layouts.app')

@section('title', 'Nazelle Délices | Artisan Bakery & Pastry Shop')

@section('content')
<div class="space-y-12">

    <!-- 1. Aesthetic Bakery Hero Section -->
    <section class="relative bg-gradient-to-b from-bakery-100 to-bakery-50 border-b border-bakery-200 overflow-hidden py-14 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                <!-- Left Hero Copy -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-bakery-200/80 border border-bakery-300 text-bakery-900 text-xs font-semibold tracking-wide shadow-sm">
                        <span>✨ Artisan French Boulangerie & Pâtisserie</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-serif font-bold text-bakery-950 leading-[1.15]">
                        Roti & Pastry Artisan <br>
                        <span class="italic text-bakery-600 font-normal">Dipanggang Hangat</span> Setiap Hari.
                    </h1>

                    <p class="text-stone-600 text-sm sm:text-base leading-relaxed max-w-xl">
                        Dibuat dari 100% Mentega Normandia Prancis AOP, ragi liar alami fermentasi lambat 36 jam, dan cokelat murni Valrhona. Rasakan sensasi kerak renyah keemasan dan aroma mentega khas toko roti Paris.
                    </p>

                    <!-- Feature Badges -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 pt-2 text-xs">
                        <div class="flex items-center space-x-2 p-2.5 rounded-xl bg-white/80 border border-bakery-200 shadow-xs">
                            <span class="text-xl">🧈</span>
                            <div>
                                <div class="font-bold text-bakery-900">100% French Butter</div>
                                <div class="text-[10px] text-stone-500">Mentega AOP Normandia</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 p-2.5 rounded-xl bg-white/80 border border-bakery-200 shadow-xs">
                            <span class="text-xl">🌾</span>
                            <div>
                                <div class="font-bold text-bakery-900">36h Sourdough</div>
                                <div class="text-[10px] text-stone-500">Fermentasi Ragi Alami</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 p-2.5 rounded-xl bg-white/80 border border-bakery-200 shadow-xs col-span-2 sm:col-span-1">
                            <span class="text-xl">🌿</span>
                            <div>
                                <div class="font-bold text-bakery-900">Tanpa Pengawet</div>
                                <div class="text-[10px] text-stone-500">Murni & Bernutrisi</div>
                            </div>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <form action="{{ route('storefront.index') }}" method="GET" class="pt-2 max-w-lg">
                        <div class="relative flex items-center shadow-md rounded-2xl overflow-hidden border border-bakery-300 focus-within:ring-2 focus-within:ring-bakery-500">
                            <input type="text" name="search" value="{{ $search }}"
                                   placeholder="Cari croissant, sourdough, tart, atau kue..."
                                   class="w-full pl-12 pr-28 py-3.5 bg-white text-sm focus:outline-none placeholder:text-stone-400">
                            <div class="absolute left-4 text-stone-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </div>
                            <button type="submit" class="absolute right-2 px-5 py-2 bg-bakery-700 hover:bg-bakery-800 text-white rounded-xl text-xs font-semibold transition">
                                Cari Menu
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Right Hero Showcase Image / Cards -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md">
                        <!-- Decorative Frame -->
                        <div class="absolute -inset-4 bg-gradient-to-tr from-bakery-300/40 to-amber-200/40 rounded-3xl blur-lg -z-10"></div>
                        
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white bg-white">
                            <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=800&q=80"
                                 alt="Fresh French Croissants"
                                 class="w-full h-80 object-cover hover:scale-105 transition-transform duration-500">
                            
                            <!-- Overlay Badge -->
                            <div class="p-5 bg-white space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs uppercase tracking-wider font-bold text-bakery-600 bg-bakery-100 px-2.5 py-1 rounded-full">
                                        Signature Viennoiserie
                                    </span>
                                    <span class="text-lg font-serif font-bold text-bakery-900">Rp 24.000</span>
                                </div>
                                <h3 class="font-serif font-bold text-lg text-bakery-950">Croissant au Beurre Pure French Butter</h3>
                                <p class="text-xs text-stone-500">27 lipatan mentega Normandia berkerak renyah dengan sarang lebah harum mentega.</p>
                            </div>
                        </div>

                        <!-- Small Floating Badge -->
                        <div class="absolute -bottom-5 -left-5 bg-white p-3.5 rounded-2xl shadow-xl border border-bakery-200 flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">
                                ⭐ 4.9
                            </div>
                            <div class="text-xs">
                                <div class="font-bold text-bakery-950">Favorit Pelanggan</div>
                                <div class="text-stone-500">Terjual 350+ minggu ini</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. Category Filter Pills -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
            <div>
                <h2 class="text-2xl font-serif font-bold text-bakery-950">Katalog Pilihan Pastry & Roti</h2>
                <p class="text-xs text-stone-500">Pilih kategori atau langsung tambahkan ke keranjang belanja Anda.</p>
            </div>

            <!-- Category Pills Bar -->
            <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none w-full sm:w-auto">
                <a href="{{ route('storefront.index') }}"
                   class="px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap transition {{ empty($categoryId) ? 'bg-bakery-800 text-white shadow-sm' : 'bg-white border border-bakery-200 text-stone-600 hover:bg-bakery-100' }}">
                    Semua Kategori ({{ $categories->sum('products_count') }})
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('storefront.index', ['category_id' => $cat->id]) }}"
                       class="px-4 py-2 rounded-full text-xs font-semibold whitespace-nowrap transition {{ $categoryId == $cat->id ? 'bg-bakery-800 text-white shadow-sm' : 'bg-white border border-bakery-200 text-stone-600 hover:bg-bakery-100' }}">
                        {{ $cat->name }} ({{ $cat->products_count }})
                    </a>
                @endforeach
            </div>
        </div>

        <!-- 3. Pastry Card Grid -->
        @if($products->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-bakery-200 max-w-xl mx-auto space-y-4">
                <div class="text-5xl">🥐</div>
                <h3 class="text-lg font-serif font-bold text-bakery-900">Pastry Belum Ditemukan</h3>
                <p class="text-xs text-stone-500">Tidak ada produk yang sesuai dengan pencarian "{{ $search }}". Silakan coba kata kunci lain atau lihat semua kategori.</p>
                <a href="{{ route('storefront.index') }}" class="inline-block px-5 py-2.5 bg-bakery-700 hover:bg-bakery-800 text-white text-xs font-semibold rounded-xl transition">
                    Lihat Semua Menu Pastry
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="bg-white rounded-2xl border border-bakery-200 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col overflow-hidden group">
                        
                        <!-- Product Image & Badges -->
                        <div class="relative h-48 overflow-hidden bg-bakery-100">
                            <img src="{{ $product->aesthetic_image }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/95 backdrop-blur-sm text-bakery-800 text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">
                                    {{ $product->category->name }}
                                </span>
                            </div>

                            <!-- Stock Indicator Badge -->
                            <div class="absolute top-3 right-3">
                                @if($product->stock <= 0)
                                    <span class="bg-rose-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                        Habis
                                    </span>
                                @elseif($product->isLowStock())
                                    <span class="bg-amber-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">
                                        Sisa {{ $product->stock }}
                                    </span>
                                @else
                                    <span class="bg-emerald-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                        Tersedia ({{ $product->stock }})
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <div class="text-[10px] font-mono text-stone-400 uppercase tracking-wider mb-1">
                                    SKU: {{ $product->sku }}
                                </div>
                                <h3 class="font-serif font-bold text-base text-bakery-950 group-hover:text-bakery-700 transition leading-snug">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-xs text-stone-500 line-clamp-2 mt-1.5 leading-relaxed">
                                    {{ $product->description ?: 'Pastry artisan khas Nazelle Délices, dipanggang dengan bahan bermutu tinggi.' }}
                                </p>
                            </div>

                            <!-- Price & Add to Cart -->
                            <div class="pt-3 border-t border-bakery-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-stone-400 block">Harga</span>
                                    <span class="text-base font-bold font-serif text-bakery-900">
                                        Rp {{ number_format($product->selling_price, 0, ',', '.') }}
                                    </span>
                                </div>

                                @if($product->stock > 0)
                                    <button type="button"
                                            onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->selling_price }}, {{ $product->stock }}, '{{ $product->aesthetic_image }}')"
                                            class="px-3.5 py-2 bg-amber-500 hover:bg-amber-600 active:scale-95 text-white rounded-xl text-xs font-semibold shadow-sm transition flex items-center space-x-1.5">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Pesan</span>
                                    </button>
                                @else
                                    <button disabled class="px-3.5 py-2 bg-stone-200 text-stone-400 rounded-xl text-xs font-semibold cursor-not-allowed">
                                        Habis
                                    </button>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </section>

</div>

<!-- 4. Floating Cart Button (Desktop & Mobile) -->
<div class="fixed bottom-6 right-6 z-50 no-print">
    <button type="button" onclick="openCartDrawer()"
            class="relative px-5 py-3.5 rounded-full bg-bakery-900 hover:bg-bakery-800 text-white shadow-2xl flex items-center space-x-3 transition hover:scale-105 active:scale-95 border-2 border-amber-400/50">
        <span class="text-xl">🧺</span>
        <div class="text-left">
            <div class="text-[10px] uppercase tracking-wider text-amber-300 font-bold">Keranjang</div>
            <div class="text-xs font-bold" id="floatingCartTotal">Rp 0</div>
        </div>
        <span id="floatingCartCount" class="absolute -top-2 -right-2 bg-rose-500 text-white text-[11px] font-bold w-6 h-6 rounded-full flex items-center justify-center border-2 border-white shadow">
            0
        </span>
    </button>
</div>

<!-- 5. Slide-Over Cart Drawer (Interactive Checkout) -->
<div id="cartDrawerBackdrop" class="fixed inset-0 bg-stone-900/60 backdrop-blur-xs z-50 hidden transition-opacity" onclick="closeCartDrawer()"></div>

<div id="cartDrawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white shadow-2xl z-50 transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col no-print">
    <!-- Drawer Header -->
    <div class="p-5 border-b border-bakery-200 flex items-center justify-between bg-bakery-50">
        <div class="flex items-center space-x-2.5">
            <span class="text-2xl">🥐</span>
            <div>
                <h3 class="font-serif font-bold text-lg text-bakery-950">Pesanan Pastry Anda</h3>
                <p class="text-[11px] text-stone-500">Nazelle Délices Artisan Checkout</p>
            </div>
        </div>
        <button type="button" onclick="closeCartDrawer()" class="p-2 text-stone-400 hover:text-stone-700 rounded-lg hover:bg-bakery-100 transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>
    </div>

    <!-- Drawer Items List -->
    <div class="flex-1 overflow-y-auto p-5 space-y-4" id="cartItemsList">
        <!-- Rendered dynamically via JS -->
        <div class="text-center py-16 text-stone-400 space-y-3" id="emptyCartNotice">
            <div class="text-5xl">🥐</div>
            <p class="text-sm font-serif">Keranjang belanja Anda masih kosong.</p>
            <p class="text-xs">Pilih varian roti atau pastry favorit untuk memulai pesanan.</p>
        </div>
    </div>

    <!-- Drawer Footer & Checkout Form -->
    <div class="p-5 border-t border-bakery-200 bg-bakery-50/70 space-y-4">
        <!-- Subtotal / Total -->
        <div class="space-y-1.5 text-xs">
            <div class="flex justify-between text-stone-600">
                <span>Subtotal Pastry:</span>
                <span id="drawerSubtotal" class="font-semibold text-stone-800">Rp 0</span>
            </div>
            <div class="flex justify-between text-base font-bold font-serif text-bakery-950 pt-2 border-t border-bakery-200">
                <span>Total Pembayaran:</span>
                <span id="drawerGrandTotal" class="text-amber-600">Rp 0</span>
            </div>
        </div>

        <!-- Order Form -->
        <form action="{{ route('storefront.checkout') }}" method="POST" id="checkoutForm" class="space-y-3">
            @csrf
            
            <div>
                <label for="checkout_name" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                    Nama Pemesan <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="customer_name" id="checkout_name"
                       value="{{ auth()->check() ? auth()->user()->name : old('customer_name', '') }}" required
                       placeholder="Contoh: Sophie Martin / Meja 04"
                       class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:outline-none focus:ring-2 focus:ring-bakery-500">
            </div>

            <div>
                <label for="checkout_notes" class="block text-[11px] font-semibold text-stone-600 mb-1">
                    Catatan Pesanan (Opsional)
                </label>
                <input type="text" name="notes" id="checkout_notes" value="{{ old('notes', '') }}"
                       placeholder="Contoh: Mohon dihangatkan / Takeaway dibungkus terpisah"
                       class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-white focus:outline-none focus:ring-2 focus:ring-bakery-500">
            </div>

            <!-- 3 Pilihan Metode Pembayaran -->
            <div>
                <label class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                    Metode Pembayaran <span class="text-rose-500">*</span>
                </label>
                <div class="grid grid-cols-3 gap-2">
                    <!-- Option 1: QRIS -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="qris" class="peer sr-only" onchange="updatePaymentMethodInfo('qris')">
                        <div class="p-2.5 rounded-xl border border-stone-200 peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-900 text-stone-600 text-center transition flex flex-col items-center justify-center space-y-1 hover:bg-stone-50">
                            <i class="fa-solid fa-qrcode text-base text-amber-600"></i>
                            <span class="text-[11px] font-bold block">QRIS</span>
                        </div>
                    </label>

                    <!-- Option 2: Transfer Bank -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only" onchange="updatePaymentMethodInfo('bank_transfer')">
                        <div class="p-2.5 rounded-xl border border-stone-200 peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-900 text-stone-600 text-center transition flex flex-col items-center justify-center space-y-1 hover:bg-stone-50">
                            <i class="fa-solid fa-building-columns text-base text-amber-600"></i>
                            <span class="text-[11px] font-bold block">Transfer Bank</span>
                        </div>
                    </label>

                    <!-- Option 3: Bayar di Kasir (Default) -->
                    <label class="cursor-pointer">
                        <input type="radio" name="payment_method" value="cashier" checked class="peer sr-only" onchange="updatePaymentMethodInfo('cashier')">
                        <div class="p-2.5 rounded-xl border border-stone-200 peer-checked:border-amber-600 peer-checked:bg-amber-50 peer-checked:text-amber-900 text-stone-600 text-center transition flex flex-col items-center justify-center space-y-1 hover:bg-stone-50">
                            <i class="fa-solid fa-cash-register text-base text-amber-600"></i>
                            <span class="text-[11px] font-bold block">Bayar di Kasir</span>
                        </div>
                    </label>
                </div>

                <!-- Info Box Keterangan Metode Pembayaran -->
                <div id="paymentMethodNotice" class="mt-2 text-xs">
                    <div class="p-2.5 bg-bakery-50/80 border border-bakery-200 rounded-xl text-stone-700 space-y-0.5">
                        <div class="font-bold text-[11px] text-bakery-900 flex items-center">
                            <i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i> Bayar Langsung di Kasir Toko
                        </div>
                        <p class="text-[11px] text-stone-500 leading-relaxed">
                            Pesanan Anda akan disiapkan oleh staf kami. Pembayaran dilakukan di kasir (Tunai / Debit / EDC) saat mengambil pesanan.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Simulasi Pembayaran Langsung Berhasil (Penilaian Kuliah) -->
            <div class="p-2.5 bg-amber-50/80 border border-amber-300 rounded-xl">
                <label class="flex items-start space-x-2.5 cursor-pointer">
                    <input type="checkbox" name="simulate_payment" value="1" checked class="mt-0.5 rounded text-amber-800 focus:ring-amber-700">
                    <div class="text-xs">
                        <div class="flex items-center space-x-1.5 font-semibold text-amber-950">
                            <span>Simulasi Pembayaran Langsung</span>
                            <span class="text-[9px] bg-amber-200 text-amber-900 px-1.5 py-0.5 rounded font-bold border border-amber-300">Simulasi Pembayaran</span>
                        </div>
                        <p class="text-[10px] text-amber-800 mt-0.5 leading-tight">
                            Status pesanan otomatis &ldquo;Pembayaran Berhasil&rdquo; untuk penilaian kuliah tanpa gateway sungguhan.
                        </p>
                    </div>
                </label>
            </div>

            <!-- Hidden Inputs Container for Cart Items -->
            <div id="hiddenItemsContainer"></div>

            <button type="submit" id="checkoutSubmitBtn" disabled
                    class="w-full py-3.5 bg-bakery-800 hover:bg-bakery-900 active:scale-95 disabled:bg-stone-300 disabled:cursor-not-allowed text-white font-semibold rounded-xl text-xs shadow-lg transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>Buat Pesanan</span>
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Cart State
    let cart = {};

    function formatRupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function addToCart(id, name, price, stock, image) {
        if (cart[id]) {
            if (cart[id].qty < stock) {
                cart[id].qty += 1;
            } else {
                alert('Maksimal stok yang tersedia untuk ' + name + ' adalah ' + stock + ' pcs.');
                return;
            }
        } else {
            cart[id] = {
                id: id,
                name: name,
                price: price,
                stock: stock,
                image: image,
                qty: 1
            };
        }

        renderCart();
        openCartDrawer();
    }

    function updateQty(id, delta) {
        if (!cart[id]) return;
        
        let newQty = cart[id].qty + delta;
        if (newQty <= 0) {
            delete cart[id];
        } else if (newQty > cart[id].stock) {
            alert('Stok tersedia hanya ' + cart[id].stock + ' pcs.');
            return;
        } else {
            cart[id].qty = newQty;
        }

        renderCart();
    }

    function removeFromCart(id) {
        delete cart[id];
        renderCart();
    }

    function renderCart() {
        const listEl = document.getElementById('cartItemsList');
        const emptyNotice = document.getElementById('emptyCartNotice');
        const hiddenContainer = document.getElementById('hiddenItemsContainer');
        const drawerSubtotal = document.getElementById('drawerSubtotal');
        const drawerGrandTotal = document.getElementById('drawerGrandTotal');
        const floatingCartTotal = document.getElementById('floatingCartTotal');
        const floatingCartCount = document.getElementById('floatingCartCount');
        const submitBtn = document.getElementById('checkoutSubmitBtn');

        const itemKeys = Object.keys(cart);
        let totalCount = 0;
        let grandTotal = 0;

        hiddenContainer.innerHTML = '';

        if (itemKeys.length === 0) {
            listEl.innerHTML = `
                <div class="text-center py-16 text-stone-400 space-y-3">
                    <div class="text-5xl">🥐</div>
                    <p class="text-sm font-serif font-bold text-bakery-900">Keranjang belanja Anda kosong.</p>
                    <p class="text-xs">Silakan klik tombol "Pesan" pada menu pastry pilihan Anda.</p>
                </div>
            `;
            drawerSubtotal.textContent = 'Rp 0';
            drawerGrandTotal.textContent = 'Rp 0';
            floatingCartTotal.textContent = 'Rp 0';
            floatingCartCount.textContent = '0';
            submitBtn.disabled = true;
            return;
        }

        let html = '';
        itemKeys.forEach((key, index) => {
            const item = cart[key];
            const subtotal = item.price * item.qty;
            totalCount += item.qty;
            grandTotal += subtotal;

            html += `
                <div class="flex items-center space-x-3 p-3 bg-bakery-50/70 border border-bakery-200 rounded-xl">
                    <img src="${item.image}" alt="${item.name}" class="w-14 h-14 object-cover rounded-lg border border-bakery-200">
                    <div class="flex-1 min-w-0">
                        <div class="font-serif font-bold text-xs text-bakery-950 truncate">${item.name}</div>
                        <div class="text-[11px] text-stone-500">${formatRupiah(item.price)}</div>
                        <div class="flex items-center space-x-2 mt-1.5">
                            <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-md bg-white border border-stone-200 text-stone-700 flex items-center justify-center text-xs hover:bg-stone-100 font-bold">-</button>
                            <span class="text-xs font-bold text-stone-800 px-1">${item.qty}</span>
                            <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-md bg-white border border-stone-200 text-stone-700 flex items-center justify-center text-xs hover:bg-stone-100 font-bold">+</button>
                            <span class="text-[10px] text-stone-400">/ max ${item.stock}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-serif font-bold text-xs text-bakery-900">${formatRupiah(subtotal)}</div>
                        <button type="button" onclick="removeFromCart(${item.id})" class="text-stone-400 hover:text-rose-500 text-xs mt-2 transition">
                            <i class="fa-regular fa-trash-can"></i>
                        </button>
                    </div>
                </div>
            `;

            // Hidden inputs for form submit
            hiddenContainer.innerHTML += `
                <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
            `;
        });

        listEl.innerHTML = html;
        drawerSubtotal.textContent = formatRupiah(grandTotal);
        drawerGrandTotal.textContent = formatRupiah(grandTotal);
        floatingCartTotal.textContent = formatRupiah(grandTotal);
        floatingCartCount.textContent = totalCount;
        submitBtn.disabled = false;
    }

    function openCartDrawer() {
        document.getElementById('cartDrawerBackdrop').classList.remove('hidden');
        document.getElementById('cartDrawer').classList.remove('translate-x-full');
    }

    function closeCartDrawer() {
        document.getElementById('cartDrawerBackdrop').classList.add('hidden');
        document.getElementById('cartDrawer').classList.add('translate-x-full');
    }

    const isQrisConfigured = {{ config('bakery.qris.is_configured') ? 'true' : 'false' }};
    const isBankConfigured = {{ config('bakery.bank_transfer.is_configured') ? 'true' : 'false' }};

    function updatePaymentMethodInfo(method) {
        const el = document.getElementById('paymentMethodNotice');
        if (method === 'qris') {
            if (isQrisConfigured) {
                el.innerHTML = `
                    <div class="p-2.5 bg-amber-50/90 border border-amber-200 rounded-xl text-stone-700 space-y-0.5">
                        <div class="font-bold text-[11px] text-amber-900 flex items-center">
                            <i class="fa-solid fa-qrcode text-amber-600 mr-1.5"></i> Pembayaran QRIS Resmi
                        </div>
                        <p class="text-[11px] text-stone-600 leading-relaxed">
                            Pindai kode QRIS toko untuk menyelesaikan pembayaran secara instan.
                        </p>
                    </div>
                `;
            } else {
                el.innerHTML = `
                    <div class="p-2.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-950 space-y-0.5">
                        <div class="font-bold text-[11px] text-amber-900 flex items-center">
                            <i class="fa-solid fa-circle-exclamation text-amber-600 mr-1.5"></i> Metode QRIS Belum Dikonfigurasi
                        </div>
                        <p class="text-[11px] text-amber-900/80 leading-relaxed">
                            QRIS resmi toko belum dikonfigurasi oleh administrator. Pesanan tetap dapat dibuat dan pembayaran dilakukan di kasir saat pengambilan.
                        </p>
                    </div>
                `;
            }
        } else if (method === 'bank_transfer') {
            if (isBankConfigured) {
                el.innerHTML = `
                    <div class="p-2.5 bg-amber-50/90 border border-amber-200 rounded-xl text-stone-700 space-y-0.5">
                        <div class="font-bold text-[11px] text-amber-900 flex items-center">
                            <i class="fa-solid fa-building-columns text-amber-600 mr-1.5"></i> Transfer Rekening Resmi
                        </div>
                        <p class="text-[11px] text-stone-600 leading-relaxed">
                            Transfer ke nomor rekening bank resmi Nazelle Délices.
                        </p>
                    </div>
                `;
            } else {
                el.innerHTML = `
                    <div class="p-2.5 bg-amber-50 border border-amber-200 rounded-xl text-amber-950 space-y-0.5">
                        <div class="font-bold text-[11px] text-amber-900 flex items-center">
                            <i class="fa-solid fa-circle-exclamation text-amber-600 mr-1.5"></i> Rekening Bank Belum Dikonfigurasi
                        </div>
                        <p class="text-[11px] text-amber-900/80 leading-relaxed">
                            Rekening transfer bank resmi belum dikonfigurasi oleh administrator. Pesanan tetap dapat dibuat dan pembayaran dilakukan di kasir saat pengambilan.
                        </p>
                    </div>
                `;
            }
        } else {
            el.innerHTML = `
                <div class="p-2.5 bg-bakery-50/80 border border-bakery-200 rounded-xl text-stone-700 space-y-0.5">
                    <div class="font-bold text-[11px] text-bakery-900 flex items-center">
                        <i class="fa-solid fa-circle-check text-emerald-600 mr-1.5"></i> Bayar Langsung di Kasir Toko
                    </div>
                    <p class="text-[11px] text-stone-500 leading-relaxed">
                        Pesanan Anda akan disiapkan oleh staf kami. Pembayaran dilakukan di kasir (Tunai / Debit / EDC) saat mengambil pesanan.
                    </p>
                </div>
            `;
        }
    }
</script>
@endpush
@endsection

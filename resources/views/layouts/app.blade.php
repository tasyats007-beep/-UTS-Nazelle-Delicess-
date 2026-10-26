<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Nazelle Délices | Artisan Bakery & Pastry') - Nazelle Délices</title>

    <!-- Google Fonts: Cormorant Garamond & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        bakery: {
                            50: '#FDFBF7',
                            100: '#FAF4EB',
                            200: '#F3E5D3',
                            300: '#E7CCA9',
                            400: '#D6A974',
                            500: '#C28445',
                            600: '#A76631',
                            700: '#874E25',
                            800: '#5F351B',
                            900: '#3D2010',
                            950: '#261309',
                        },
                        terracotta: {
                            500: '#C76343',
                            600: '#AC4D2F',
                        },
                        sage: {
                            50: '#F2F5F2',
                            100: '#E1E9E1',
                            600: '#526E52',
                            700: '#415841',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        [x-cloak] { display: none !important; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
        .font-cormorant { font-family: 'Cormorant Garamond', serif; }
        .hero-pattern {
            background-color: #FAF4EB;
            background-image: radial-gradient(#D6A974 0.75px, transparent 0.75px);
            background-size: 15px 15px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-bakery-50 text-stone-800 font-sans antialiased min-h-screen flex flex-col selection:bg-bakery-200 selection:text-bakery-900">

    <!-- 1. Top Bar: Store Announcement & Operating Hours -->
    <div class="bg-bakery-950 text-bakery-200 text-xs py-2 px-4 border-b border-bakery-800 no-print">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2">
            <!-- Left Info -->
            <div class="flex items-center space-x-2 text-[11px] tracking-wide text-bakery-300">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>✨ <strong>Fresh Bakes:</strong> Croissant & Sourdough dipanggang hangat setiap 06:30 & 14:00 WIB</span>
                <span class="hidden lg:inline text-bakery-600">|</span>
                <span class="hidden lg:inline">Pâtisserie & Boulangerie Artisanale</span>
            </div>

            <!-- Right Info -->
            <div class="flex items-center space-x-3 text-[11px] text-bakery-400">
                <span><i class="fa-regular fa-clock mr-1 text-amber-400"></i> Buka: 06:30 - 21:00 WIB</span>
                <span>&bull;</span>
                <span><i class="fa-solid fa-location-dot mr-1 text-terracotta-500"></i> Jl. Patisserie No. 42, Senopati</span>
            </div>
        </div>
    </div>

    <!-- 2. Main Navigation Header -->
    <header class="bg-white/95 backdrop-blur-md border-b border-bakery-200 shadow-sm sticky top-0 z-40 no-print transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Brand / Logo -->
                <div class="flex items-center space-x-3">
                    <a href="{{ route('storefront.index') }}" class="flex items-center space-x-3 group">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-bakery-700 to-amber-500 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-transform duration-200">
                            🥐
                        </div>
                        <div>
                            <div class="text-2xl font-bold font-serif tracking-wide text-bakery-950 group-hover:text-bakery-700 transition">
                                Nazelle Délices
                            </div>
                            <div class="text-[10px] tracking-[0.2em] uppercase text-bakery-600 font-semibold">
                                Pâtisserie & Boulangerie
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex items-center space-x-1 text-sm font-medium">
                    <!-- Beranda Landing Page Link -->
                    <a href="{{ route('landing') }}"
                       class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('landing*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                        <i class="fa-solid fa-house mr-1.5 text-amber-700"></i> Beranda
                    </a>

                    <!-- Storefront Catalog Link -->
                    <a href="{{ route('storefront.index') }}"
                       class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('storefront.*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                        <i class="fa-solid fa-store mr-1.5 text-bakery-600"></i> Menu & Toko
                    </a>

                    @auth
                        @if(auth()->user()->isCustomer())
                            <a href="{{ route('customer.orders') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('customer.orders') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-receipt mr-1.5 text-bakery-600"></i> Pesanan Saya
                            </a>
                        @else
                            <!-- Staff & Admin Operational Links -->
                            <a href="{{ route('dashboard') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('dashboard') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-chart-pie mr-1.5 text-bakery-600"></i> Dashboard
                            </a>

                            <a href="{{ route('sales.create') }}"
                               class="px-3.5 py-2 rounded-lg transition bg-amber-500 hover:bg-amber-600 text-white font-semibold shadow-sm {{ request()->routeIs('sales.create') ? 'ring-2 ring-amber-300' : '' }}">
                                <i class="fa-solid fa-cash-register mr-1.5"></i> Kasir (POS)
                            </a>

                            <a href="{{ route('sales.index') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('sales.index') || request()->routeIs('sales.show') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-clipboard-list mr-1.5 text-bakery-600"></i> Penjualan
                            </a>

                            <a href="{{ route('purchases.index') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('purchases.*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-dolly mr-1.5 text-emerald-600"></i> Restock (Beli)
                            </a>

                            <!-- Master Data Dropdown / Direct Links -->
                            <a href="{{ route('products.index') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('products.*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-bread-slice mr-1.5 text-bakery-600"></i> Master Produk
                            </a>

                            <a href="{{ route('categories.index') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('categories.*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-tag mr-1.5 text-bakery-500"></i> Kategori
                            </a>

                            <a href="{{ route('suppliers.index') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('suppliers.*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-truck-field mr-1.5 text-teal-600"></i> Supplier
                            </a>

                            @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}"
                               class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('users.*') ? 'bg-bakery-100 text-bakery-800 font-bold' : 'text-stone-600 hover:text-bakery-800 hover:bg-bakery-50' }}">
                                <i class="fa-solid fa-users-gear mr-1.5 text-terracotta-500"></i> Pengguna
                            </a>
                            @endif
                        @endif
                    @endauth
                </nav>

                <!-- User Profile / Auth Actions -->
                <div class="flex items-center space-x-3">
                    @auth
                        <div class="text-right hidden sm:block">
                            <div class="text-xs font-bold text-bakery-950">{{ auth()->user()->name }}</div>
                            <div class="text-[10px]">
                                @if(auth()->user()->isAdmin())
                                    <span class="bg-amber-100 text-amber-900 font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Owner / Admin</span>
                                @elseif(auth()->user()->isStaff())
                                    <span class="bg-bakery-100 text-bakery-900 font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Staff Kasir & Baker</span>
                                @else
                                    <span class="bg-rose-100 text-rose-900 font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">Pelanggan</span>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit"
                                    class="p-2 text-stone-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition"
                                    title="Keluar dari akun">
                                <i class="fa-solid fa-arrow-right-from-bracket text-base"></i>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-bakery-700 hover:text-bakery-900 px-3 py-2 rounded-lg transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-semibold rounded-lg shadow transition">
                            Daftar Pelanggan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- 3. Global Alert Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 no-print w-full">
        @if(session('success'))
            <div class="p-4 mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5 text-lg"></i>
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-rose-600 mt-0.5 text-lg"></i>
                <div class="flex-1">
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 mb-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-900 flex items-start space-x-3 shadow-sm">
                <i class="fa-solid fa-triangle-exclamation text-amber-600 mt-0.5 text-lg"></i>
                <div class="flex-1">
                    <p class="text-sm font-bold">Perhatian: Mohon perbaiki data input berikut:</p>
                    <ul class="list-disc list-inside text-xs mt-1 space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- 4. Main Page Body -->
    <main class="flex-1 pb-16">
        @yield('content')
    </main>

    <!-- 5. Aesthetic Bakery Footer -->
    <footer class="bg-bakery-950 text-bakery-200 border-t border-bakery-900 pt-12 pb-8 mt-auto no-print text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Col 1: Brand & Philosophy -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-3">
                        <span class="text-2xl">🥐</span>
                        <span class="text-2xl font-serif font-bold text-white tracking-wide">Nazelle Délices</span>
                    </div>
                    <p class="text-bakery-300 text-xs leading-relaxed max-w-md">
                        Toko roti & pastry artisan Prancis bernuansa hangat estetik. Dipanggang segar setiap pagi dengan 100% French butter AOP Normandia, ragi alami liar (wild sourdough starter 36 jam), tanpa pengawet atau pewarna buatan.
                    </p>
                    <div class="mt-4 flex items-center space-x-3 text-bakery-400 text-xs">
                        <span><i class="fa-regular fa-clock mr-1 text-amber-400"></i> Buka Setiap Hari: 06:30 - 21:00 WIB</span>
                        <span>&bull;</span>
                        <span><i class="fa-solid fa-location-dot mr-1 text-terracotta-500"></i> Jl. Patisserie No. 42, Senopati</span>
                    </div>
                </div>

                <!-- Col 2: Navigasi Menu -->
                <div>
                    <h3 class="font-serif text-white font-bold text-base mb-3 tracking-wide">Navigasi Toko</h3>
                    <ul class="space-y-2 text-xs text-bakery-300">
                        <li>
                            <a href="{{ route('landing') }}" class="hover:text-amber-300 transition flex items-center space-x-2">
                                <i class="fa-solid fa-house text-amber-400 w-4"></i>
                                <span>Beranda Utama</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('storefront.index') }}" class="hover:text-amber-300 transition flex items-center space-x-2">
                                <i class="fa-solid fa-store text-amber-400 w-4"></i>
                                <span>Katalog Pastry & Roti</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('customer.orders') }}" class="hover:text-amber-300 transition flex items-center space-x-2">
                                <i class="fa-solid fa-receipt text-terracotta-400 w-4"></i>
                                <span>Lacak Pesanan Saya</span>
                            </a>
                        </li>
                        @guest
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-amber-300 transition flex items-center space-x-2">
                                <i class="fa-solid fa-right-to-bracket text-emerald-400 w-4"></i>
                                <span>Masuk ke Akun</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="hover:text-amber-300 transition flex items-center space-x-2">
                                <i class="fa-solid fa-user-plus text-amber-300 w-4"></i>
                                <span>Daftar Pelanggan Baru</span>
                            </a>
                        </li>
                        @else
                        <li>
                            <a href="{{ route('dashboard') }}" class="hover:text-amber-300 transition flex items-center space-x-2">
                                <i class="fa-solid fa-gauge-high text-amber-400 w-4"></i>
                                <span>Dashboard Saya</span>
                            </a>
                        </li>
                        @endguest
                    </ul>
                </div>

                <!-- Col 3: Artisan Bakery Guarantee -->
                <div>
                    <h3 class="font-serif text-white font-bold text-base mb-3 tracking-wide">Kualitas Artisan</h3>
                    <p class="text-xs text-bakery-400 leading-relaxed">
                        <strong>100% Mentega Prancis AOP</strong><br>
                        Dipanggang Segar Setiap Pagi<br>
                        Fermentasi Ragi Alami 36 Jam<br>
                        <em>Bahan premium pilihan tanpa pewarna dan pengawet buatan.</em>
                    </p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 border-t border-bakery-900 flex flex-col sm:flex-row items-center justify-between text-xs text-bakery-400">
                <p>&copy; {{ date('Y') }} Nazelle Délices - Artisan Bakery & Pastry Management. All rights reserved.</p>
                <p class="mt-2 sm:mt-0 font-medium text-bakery-400">
                    Handcrafted with <i class="fa-solid fa-heart text-terracotta-500"></i> in Laravel
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

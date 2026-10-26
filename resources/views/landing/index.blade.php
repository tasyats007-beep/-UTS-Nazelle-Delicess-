<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nazelle Délices — A Little Taste of Elegance | Pâtisserie & Boulangerie Artisanale</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,400;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        bakery: {
                            50: '#FAF7F2',
                            100: '#F5EFE6',
                            200: '#EBDDCB',
                            300: '#DEC4A6',
                            400: '#C5A880',
                            500: '#B08D5B',
                            600: '#8F6E40',
                            700: '#6E522C',
                            800: '#4D361B',
                            900: '#3D2010',
                            950: '#261309',
                        }
                    },
                    fontFamily: {
                        serif: ['"Cormorant Garamond"', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#FAF7F2] text-stone-800 font-sans antialiased selection:bg-amber-200 selection:text-amber-900">

    <!-- Top Announcement Strip -->
    <div class="bg-[#261309] text-amber-200/90 py-2 px-4 text-center text-xs tracking-wider border-b border-amber-900/30">
        <span class="inline-flex items-center space-x-2">
            <span>✨</span>
            <span class="font-medium">Pâtisserie & Boulangerie Artisanale &mdash; Panggangan Segar Setiap Pagi di Senopati</span>
            <span>🥐</span>
        </span>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-40 bg-[#FAF7F2]/90 backdrop-blur-md border-b border-stone-200/60 transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-tr from-[#3D2010] to-amber-700 flex items-center justify-center text-2xl text-white shadow-md group-hover:scale-105 transition-transform">
                        🥐
                    </div>
                    <div>
                        <span class="font-serif text-2xl sm:text-3xl font-bold text-stone-900 tracking-wide block leading-none">
                            Nazelle Délices
                        </span>
                        <span class="text-[9px] sm:text-[10px] tracking-[0.25em] uppercase font-bold text-amber-700 block mt-1">
                            Pâtisserie & Boulangerie Artisanale
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center space-x-8 text-xs font-semibold tracking-wide text-stone-700">
                    <a href="{{ route('landing') }}" class="text-amber-800 hover:text-amber-900 transition font-bold">Beranda</a>
                    <a href="#tentang" class="hover:text-amber-800 transition">Tentang Kami</a>
                    <a href="#produk" class="hover:text-amber-800 transition">Produk Unggulan</a>
                    <a href="#keunggulan" class="hover:text-amber-800 transition">Keunggulan</a>
                    <a href="{{ route('storefront.index') }}" class="text-amber-700 hover:text-amber-900 transition flex items-center">
                        <i class="fa-solid fa-store mr-1.5 text-xs"></i> Menu & Katalog
                    </a>
                </nav>

                <!-- Auth Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-3.5 py-2 text-xs font-semibold text-amber-900 bg-amber-100/80 hover:bg-amber-200 rounded-full transition flex items-center">
                            <i class="fa-solid fa-gauge-high mr-1.5 text-amber-700"></i> Dashboard
                        </a>
                    @endauth
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-bold text-stone-700 hover:text-amber-900 transition flex items-center">
                        <i class="fa-regular fa-user mr-1.5"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-full bg-[#3D2010] hover:bg-[#261309] text-white text-xs font-bold tracking-wider uppercase transition shadow-md hover:shadow-lg border border-amber-900/30 flex items-center space-x-1.5">
                        <i class="fa-solid fa-signature text-[11px]"></i>
                        <span>Daftar</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center space-x-2">
                    <a href="{{ route('login') }}" class="px-2.5 py-1 text-stone-700 hover:text-amber-800 text-xs font-bold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="px-2.5 py-1 bg-[#3D2010] text-white rounded-lg text-xs font-bold">
                        Daftar
                    </a>
                    <button type="button" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')" class="p-2 rounded-lg text-stone-700 hover:bg-stone-200/50">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden px-4 pt-2 pb-6 bg-[#FAF7F2] border-b border-stone-200 space-y-3 text-xs font-semibold text-stone-700">
            <a href="{{ route('landing') }}" class="block py-2 text-amber-800 font-bold border-b border-stone-100">Beranda</a>
            <a href="#tentang" class="block py-2 hover:text-amber-800 border-b border-stone-100">Tentang Kami</a>
            <a href="#produk" class="block py-2 hover:text-amber-800 border-b border-stone-100">Produk Unggulan</a>
            <a href="#keunggulan" class="block py-2 hover:text-amber-800 border-b border-stone-100">Keunggulan</a>
            <a href="{{ route('storefront.index') }}" class="block py-2 text-amber-700 font-bold border-b border-stone-100">Menu & Katalog Pastry</a>
            <div class="pt-2 flex items-center space-x-2">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-center py-2.5 px-3 bg-amber-100 text-amber-900 rounded-xl font-bold text-xs">Dashboard</a>
                @endauth
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 bg-stone-100 hover:bg-stone-200 rounded-xl font-bold text-stone-800 text-xs">
                    <i class="fa-regular fa-user mr-1 text-xs"></i> Masuk
                </a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 bg-[#3D2010] hover:bg-[#261309] text-white rounded-xl font-bold text-xs">
                    <i class="fa-solid fa-signature mr-1 text-amber-300 text-xs"></i> Daftar
                </a>
            </div>
        </div>
    </header>

    <!-- 1. HERO SECTION -->
    <section class="relative overflow-hidden pt-12 pb-20 lg:pt-20 lg:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                
                <!-- Left Content -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <!-- Elegant Tagline Badge -->
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-amber-100/80 border border-amber-300 text-amber-900 text-[11px] font-bold tracking-widest uppercase shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-amber-600 animate-pulse"></span>
                        <span>A Little Taste of Elegance</span>
                    </div>

                    <!-- Main Headline -->
                    <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold text-stone-900 leading-[1.08] tracking-tight">
                        Sentuhan Elegan di Setiap Gigitan <span class="italic text-amber-800">Pastry Prancis</span>
                    </h1>

                    <!-- Store Description -->
                    <p class="text-stone-600 text-sm sm:text-base lg:text-lg max-w-2xl mx-auto lg:mx-0 leading-relaxed font-light">
                        Selamat datang di <strong>Nazelle Délices</strong>. Setiap fajar kami mengolah tepung gandum pilihan, mentega murni Prancis, dan ragi alami menjadi viennoiserie berlapis renyah, sourdough beraroma hangat, serta kue-kue klasik artisan yang membawa kehangatan butik roti Paris langsung ke meja Anda.
                    </p>

                    <!-- Call To Actions -->
                    <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-3">
                        <a href="{{ route('storefront.index') }}" 
                           class="w-full sm:w-auto px-7 py-3.5 rounded-full bg-[#3D2010] hover:bg-[#261309] text-white font-semibold text-xs uppercase tracking-wider shadow-xl hover:shadow-2xl transition hover:scale-[1.02] active:scale-[0.98] flex items-center justify-center space-x-2 border border-amber-700/40">
                            <i class="fa-solid fa-bag-shopping text-sm text-amber-400"></i>
                            <span>Buka Menu & Pesan Sekarang</span>
                        </a>

                        <a href="{{ route('login') }}" 
                           class="flex-1 sm:flex-none px-6 py-3.5 rounded-full bg-white hover:bg-stone-50 text-stone-800 font-semibold text-xs uppercase tracking-wider border border-stone-300 shadow-sm transition hover:border-amber-600 text-center flex items-center justify-center space-x-1.5">
                            <i class="fa-regular fa-user text-amber-800"></i>
                            <span>Masuk ke Akun</span>
                        </a>

                        <a href="{{ route('register') }}" 
                           class="flex-1 sm:flex-none px-6 py-3.5 rounded-full bg-amber-100/90 hover:bg-amber-200 text-amber-950 font-semibold text-xs uppercase tracking-wider border border-amber-300 shadow-sm transition text-center flex items-center justify-center space-x-1.5">
                            <i class="fa-solid fa-signature text-amber-800"></i>
                            <span>Daftar Pelanggan</span>
                        </a>

                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="w-full sm:w-auto px-5 py-3.5 rounded-full bg-amber-800/10 hover:bg-amber-800/20 text-amber-900 font-semibold text-xs uppercase tracking-wider border border-amber-400/40 shadow-sm transition text-center flex items-center justify-center space-x-1.5">
                                <i class="fa-solid fa-gauge-high text-amber-700"></i>
                                <span>Dashboard Saya</span>
                            </a>
                        @endauth
                    </div>

                    <!-- Trust Highlights -->
                    <div class="pt-8 border-t border-stone-200/80 grid grid-cols-3 gap-4 max-w-lg mx-auto lg:mx-0 text-center lg:text-left">
                        <div>
                            <div class="font-serif text-2xl font-bold text-[#3D2010]">100%</div>
                            <div class="text-[11px] text-stone-500 font-medium">Mentega Murni Prancis</div>
                        </div>
                        <div>
                            <div class="font-serif text-2xl font-bold text-[#3D2010]">24 Jam</div>
                            <div class="text-[11px] text-stone-500 font-medium">Fermentasi Alami</div>
                        </div>
                        <div>
                            <div class="font-serif text-2xl font-bold text-[#3D2010]">Setiap Fajar</div>
                            <div class="text-[11px] text-stone-500 font-medium">Dipanggang Segar</div>
                        </div>
                    </div>
                </div>

                <!-- Right Visual Showcase -->
                <div class="lg:col-span-5 relative">
                    <!-- Decorative Golden Glow -->
                    <div class="absolute -top-10 -left-10 w-72 h-72 bg-amber-200/40 rounded-full blur-3xl pointer-events-none"></div>
                    <div class="absolute -bottom-10 -right-10 w-72 h-72 bg-amber-600/10 rounded-full blur-3xl pointer-events-none"></div>

                    <!-- Main Hero Image Frame -->
                    <div class="relative bg-white p-3 rounded-3xl shadow-2xl border border-amber-900/10 transform lg:rotate-1 hover:rotate-0 transition duration-500">
                        <img src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&w=1000&q=85" 
                             alt="Artisan Croissant Nazelle Délices" 
                             class="rounded-2xl w-full h-[400px] sm:h-[480px] object-cover">
                        
                        <!-- Floating Badge 1: Top Right -->
                        <div class="absolute -top-4 -right-4 bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl shadow-xl border border-amber-900/10 flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-800 flex items-center justify-center text-lg">
                                🥐
                            </div>
                            <div class="text-left">
                                <div class="text-[10px] text-stone-400 uppercase font-bold">Croissant au Beurre</div>
                                <div class="text-xs font-serif font-bold text-stone-900">Flaky &amp; Honeycomb Air</div>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Bottom Left -->
                        <div class="absolute -bottom-5 -left-4 bg-[#261309] text-white px-5 py-3 rounded-2xl shadow-2xl border border-amber-500/30 flex items-center space-x-3">
                            <div class="w-9 h-9 rounded-full bg-amber-500 text-white flex items-center justify-center text-sm shadow">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="text-left">
                                <div class="text-xs font-serif font-bold tracking-wide">Pâtisserie Artisanale</div>
                                <div class="text-[10px] text-amber-300 font-medium">Aroma Autentik Paris</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. ABOUT US SECTION -->
    <section id="tentang" class="py-20 bg-white border-y border-stone-200/70 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center space-y-4 mb-16">
                <span class="text-xs font-bold uppercase tracking-[0.25em] text-amber-700">Filosofi &amp; Dedikasi</span>
                <h2 class="font-serif text-3xl sm:text-5xl font-bold text-stone-900">
                    Kisah di Balik Kehangatan Nazelle Délices
                </h2>
                <div class="w-16 h-1 bg-amber-600 mx-auto rounded-full"></div>
                <p class="text-stone-600 text-sm sm:text-base leading-relaxed font-light pt-2">
                    Berdiri dengan cinta mendalam terhadap seni pembuatan roti tradisional Prancis, Nazelle Délices menghidupkan kembali teknik klasik pembuatan adonan lapis (*lamination*) dan fermentasi lambat yang menghasilkan aroma wangi khas, kulit renyah (*crust*), serta remah lembut yang meleleh di mulut.
                </p>
            </div>

            <!-- 3 Pillars Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Pillar 1 -->
                <div class="p-8 rounded-3xl bg-[#FAF7F2] border border-amber-900/10 hover:border-amber-400/50 hover:shadow-xl transition duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100/80 text-amber-800 flex items-center justify-center text-2xl shadow-sm">
                        🌾
                    </div>
                    <h3 class="font-serif text-xl font-bold text-stone-900">Bahan Baku Autentik</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-light">
                        Kami hanya menggunakan mentega murni berlemak tinggi (*pure French butter*) dan tepung gandum tanpa pemutih untuk menjamin rasa yang kaya dan alami tanpa pengawet.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="p-8 rounded-3xl bg-[#FAF7F2] border border-amber-900/10 hover:border-amber-400/50 hover:shadow-xl transition duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100/80 text-amber-800 flex items-center justify-center text-2xl shadow-sm">
                        ⏱️
                    </div>
                    <h3 class="font-serif text-xl font-bold text-stone-900">Fermentasi Alami Lambat</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-light">
                        Roti sourdough kami melalui proses fermentasi alami hingga 24 jam. Menghasilkan rasa asam lembut yang kompleks, mudah dicerna, dan bernutrisi tinggi.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="p-8 rounded-3xl bg-[#FAF7F2] border border-amber-900/10 hover:border-amber-400/50 hover:shadow-xl transition duration-300 space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100/80 text-amber-800 flex items-center justify-center text-2xl shadow-sm">
                        👨‍🍳
                    </div>
                    <h3 class="font-serif text-xl font-bold text-stone-900">Karya Tangan Artisan</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed font-light">
                        Setiap lekukan croissant digulung dengan presisi tangan baker berpengalaman. Dipanggang segar setiap pagi demi kesempurnaan kerenyahan saat Anda nikmati.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. FEATURED PRODUCTS SECTION -->
    <section id="produk" class="py-20 bg-[#FAF7F2] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                <div>
                    <span class="text-xs font-bold uppercase tracking-[0.25em] text-amber-700 block mb-2">Pilihan Terbaik Toko</span>
                    <h2 class="font-serif text-3xl sm:text-5xl font-bold text-stone-900">
                        Kreasi Pastry &amp; Roti Unggulan
                    </h2>
                    <p class="text-stone-600 text-sm font-light mt-2 max-w-xl">
                        Varian pastry dan roti terfavorit yang selalu dicari oleh para penikmat cita rasa istimewa.
                    </p>
                </div>
                <div>
                    <a href="{{ route('storefront.index') }}" 
                       class="inline-flex items-center space-x-2 px-6 py-3 rounded-full bg-white hover:bg-stone-50 border border-stone-300 text-stone-800 font-semibold text-xs tracking-wider uppercase transition shadow-xs hover:border-amber-600">
                        <span>Lihat Semua Menu Toko</span>
                        <i class="fa-solid fa-arrow-right text-[11px] text-amber-700"></i>
                    </a>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredProducts as $item)
                    <div class="bg-white rounded-3xl overflow-hidden border border-amber-900/10 shadow-sm hover:shadow-xl transition duration-300 flex flex-col group">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden h-60 bg-stone-100">
                            <img src="{{ $item->aesthetic_image }}" 
                                 alt="{{ $item->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="px-3 py-1 rounded-full bg-white/90 backdrop-blur-md text-[10px] font-bold text-stone-800 uppercase tracking-wider shadow-xs">
                                    {{ $item->category->name ?? 'Artisan Pastry' }}
                                </span>
                            </div>
                            <div class="absolute top-3 right-3">
                                <span class="px-2.5 py-1 rounded-full bg-[#3D2010]/80 text-amber-200 text-[10px] font-mono font-semibold">
                                    Stok: {{ $item->stock }} pcs
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                            <div>
                                <h3 class="font-serif text-xl font-bold text-stone-900 group-hover:text-amber-800 transition">
                                    {{ $item->name }}
                                </h3>
                                <p class="text-xs text-stone-500 mt-2 line-clamp-2 font-light">
                                    {{ $item->description ?: 'Pastry autentik buatan tangan dengan bahan premium pilihan khas Nazelle Délices.' }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-stone-100 flex items-center justify-between">
                                <div>
                                    <span class="text-[10px] text-stone-400 block uppercase font-bold">Harga</span>
                                    <span class="font-serif text-xl font-bold text-[#3D2010]">
                                        Rp {{ number_format($item->selling_price, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback if empty -->
                    <div class="col-span-3 text-center py-12 text-stone-400">
                        <div class="text-4xl mb-2">🥐</div>
                        <p class="font-serif text-lg">Menu pastry sedang disiapkan oleh baker kami.</p>
                        <a href="{{ route('storefront.index') }}" class="text-xs text-amber-700 underline mt-2 inline-block">Buka katalog lengkap</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- 4. KEY BENEFITS / KEUNGGULAN SECTION -->
    <section id="keunggulan" class="py-20 bg-white border-t border-stone-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center space-y-3 mb-16">
                <span class="text-xs font-bold uppercase tracking-[0.25em] text-amber-700">Kenyamanan &amp; Kemudahan</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-stone-900">
                    Pengalaman Belanja di Nazelle Délices
                </h2>
                <div class="w-16 h-1 bg-amber-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-stone-200 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-800 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-fire-burner"></i>
                    </div>
                    <h4 class="font-serif text-lg font-bold text-stone-900">Panggang Setiap Pagi</h4>
                    <p class="text-xs text-stone-500 font-light">
                        Kami menjamin roti dan pastry selalu dalam kondisi hangat dan segar dari oven.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-stone-200 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-800 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h4 class="font-serif text-lg font-bold text-stone-900">Kemasan Elegan</h4>
                    <p class="text-xs text-stone-500 font-light">
                        Kotak kemasan eksklusif yang estetik dan ramah lingkungan, cocok untuk dinikmati atau hantaran.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-stone-200 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-800 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-mobile-screen"></i>
                    </div>
                    <h4 class="font-serif text-lg font-bold text-stone-900">Pesan Online Mudah</h4>
                    <p class="text-xs text-stone-500 font-light">
                        Pilih menu dari ponsel Anda, buat pesanan langsung, dan ambil tanpa perlu antre panjang.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-[#FAF7F2] border border-stone-200 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-800 mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h4 class="font-serif text-lg font-bold text-stone-900">Metode Bayar Fleksibel</h4>
                    <p class="text-xs text-stone-500 font-light">
                        Mendukung pembayaran via QRIS, Transfer Bank resmi, maupun Bayar di Kasir saat pengambilan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. CALL TO ACTION (CTA) SECTION -->
    <section class="py-16 bg-[#FAF7F2]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-r from-[#261309] via-[#3D2010] to-[#1C0D06] rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden border border-amber-500/20">
                <div class="relative z-10 max-w-2xl space-y-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-amber-400/20 text-amber-300 border border-amber-400/30">
                        A Little Taste of Elegance
                    </span>
                    <h2 class="font-serif text-3xl sm:text-5xl font-bold tracking-wide leading-tight">
                        Siap Menikmati Kehangatan Pastry Prancis Hari Ini?
                    </h2>
                    <p class="text-stone-300 text-xs sm:text-sm font-light leading-relaxed">
                        Daftar akun pelanggan sekarang untuk kemudahan pemesanan online, atau kunjungi butik bakery kami langsung di Senopati, Jakarta Selatan.
                    </p>
                    <div class="pt-4 flex flex-wrap gap-3">
                        <a href="{{ route('storefront.index') }}" 
                           class="px-7 py-3.5 rounded-full bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs uppercase tracking-wider shadow-lg transition flex items-center space-x-2">
                            <i class="fa-solid fa-store"></i>
                            <span>Buka Menu &amp; Pesan Pastry</span>
                        </a>
                        <a href="{{ route('login') }}" 
                           class="px-6 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white font-semibold text-xs uppercase tracking-wider border border-white/20 transition flex items-center space-x-1.5">
                            <i class="fa-regular fa-user"></i>
                            <span>Masuk ke Akun</span>
                        </a>
                        <a href="{{ route('register') }}" 
                           class="px-6 py-3.5 rounded-full bg-amber-400 hover:bg-amber-300 text-stone-900 font-bold text-xs uppercase tracking-wider shadow-md transition flex items-center space-x-1.5">
                            <i class="fa-solid fa-signature"></i>
                            <span>Daftar Akun Baru</span>
                        </a>
                        @auth
                            <a href="{{ route('dashboard') }}" 
                               class="px-6 py-3.5 rounded-full bg-white/20 hover:bg-white/30 text-amber-200 font-semibold text-xs uppercase tracking-wider border border-amber-400/40 transition flex items-center space-x-1.5">
                                <i class="fa-solid fa-gauge-high"></i>
                                <span>Ke Dashboard</span>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Watermark Background Decors -->
                <div class="absolute -right-8 -bottom-10 text-white/5 text-[220px] select-none pointer-events-none font-serif leading-none">
                    🥐
                </div>
            </div>
        </div>
    </section>

    <!-- 6. FOOTER -->
    <footer class="bg-[#261309] text-stone-400 pt-16 pb-12 border-t border-amber-900/30 text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-stone-800">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4 md:col-span-2">
                    <div class="flex items-center space-x-3">
                        <span class="text-3xl">🥐</span>
                        <div>
                            <span class="font-serif text-2xl font-bold text-white tracking-wide block">Nazelle Délices</span>
                            <span class="text-[9px] uppercase tracking-[0.2em] font-semibold text-amber-400 block">Pâtisserie &amp; Boulangerie Artisanale</span>
                        </div>
                    </div>
                    <p class="text-stone-400 text-xs leading-relaxed max-w-md font-light">
                        Menghadirkan kenikmatan roti dan kue berkualitas tinggi berakar pada tradisi artisan Prancis. Setiap gigitan adalah perpaduan cita rasa, tekstur, dan keanggunan.
                    </p>
                    <p class="text-amber-200/80 italic font-serif text-sm">
                        &ldquo;A Little Taste of Elegance&rdquo;
                    </p>
                </div>

                <!-- Col 2: Navigation Links -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Navigasi Website</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('landing') }}" class="hover:text-amber-400 transition">Beranda Utama</a></li>
                        <li><a href="#tentang" class="hover:text-amber-400 transition">Tentang Kami</a></li>
                        <li><a href="#produk" class="hover:text-amber-400 transition">Produk Unggulan</a></li>
                        <li><a href="{{ route('storefront.index') }}" class="hover:text-amber-400 transition">Menu &amp; Katalog Toko</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-amber-400 transition">Masuk ke Akun</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-amber-400 transition">Daftar Akun Baru</a></li>
                    </ul>
                </div>

                <!-- Col 3: Store Details -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white">Butik &amp; Kontak</h4>
                    <p class="text-xs leading-relaxed">
                        <strong class="text-stone-300">Lokasi Butik:</strong><br>
                        Jl. Patisserie No. 42, Senopati,<br>
                        Jakarta Selatan, 12190
                    </p>
                    <p class="text-xs leading-relaxed">
                        <strong class="text-stone-300">Jam Operasional:</strong><br>
                        Setiap Hari: 07.00 &ndash; 21.00 WIB
                    </p>
                    <p class="text-xs text-amber-400">
                        <i class="fa-solid fa-phone mr-1"></i> (021) 7890-1234<br>
                        <i class="fa-brands fa-instagram mr-1"></i> @nazelle.delices
                    </p>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-[11px] text-stone-500 gap-4">
                <div>
                    &copy; 2026 Nazelle Délices. Seluruh hak cipta dilindungi undang-undang.
                </div>
                <div class="flex items-center space-x-4">
                    <span>Pâtisserie &amp; Boulangerie Artisanale</span>
                    <span>&bull;</span>
                    <span>Jakarta Selatan</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>

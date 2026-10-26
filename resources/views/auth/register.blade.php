<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelanggan - Nazelle Délices | Artisan Bakery & Pastry</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .font-serif { font-family: 'Cormorant Garamond', serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-[#261309] via-[#3D2010] to-[#1C0D06] min-h-screen flex items-center justify-center p-4 font-sans text-stone-800">

    <div class="max-w-md w-full my-8">
        <!-- Logo & Header -->
        <div class="text-center mb-6">
            <a href="{{ route('storefront.index') }}" class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-tr from-amber-600 to-amber-400 text-3xl shadow-xl shadow-amber-500/20 mb-3 hover:scale-105 transition-transform">
                🥐
            </a>
            <h1 class="text-3xl font-serif font-bold text-white tracking-wide">Nazelle Délices</h1>
            <p class="text-amber-200/80 text-xs tracking-widest uppercase mt-0.5">Pâtisserie & Boulangerie Artisanale</p>
        </div>

        <!-- Register Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-amber-900/10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-serif font-bold text-stone-900 flex items-center">
                    <i class="fa-solid fa-user-plus mr-2 text-amber-600"></i> Buat Akun Pelanggan
                </h2>
                <a href="{{ route('login') }}" class="text-xs text-amber-700 hover:text-amber-900 font-semibold">
                    Sudah Punya Akun?
                </a>
            </div>

            @if ($errors->any())
                <div class="p-3 mb-4 text-xs text-rose-800 bg-rose-50 rounded-xl border border-rose-200 flex items-start">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-rose-600 text-sm mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                            <i class="fa-regular fa-user"></i>
                        </span>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Contoh: Sarah Wijaya"
                            class="w-full pl-10 pr-3.5 py-2.5 border border-stone-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Alamat Email
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required
                            placeholder="sarah@example.com"
                            class="w-full pl-10 pr-3.5 py-2.5 border border-stone-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Kata Sandi (Min. 6 Karakter)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                            placeholder="Minimal 6 karakter"
                            class="w-full pl-10 pr-3.5 py-2.5 border border-stone-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Konfirmasi Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                            <i class="fa-solid fa-check-double"></i>
                        </span>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            placeholder="Ulangi kata sandi"
                            class="w-full pl-10 pr-3.5 py-2.5 border border-stone-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-[#3D2010] hover:bg-[#261309] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center space-x-2">
                    <span>Daftar Sebagai Pelanggan</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
            </form>

            <div class="mt-6 text-center text-[11px] text-stone-400">
                Sudah punya akun? <a href="{{ route('login') }}" class="text-amber-700 font-semibold hover:underline">Masuk di sini</a>
            </div>
        </div>
    </div>

</body>
</html>

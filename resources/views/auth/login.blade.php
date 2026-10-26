<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - Nazelle Délices | Artisan Bakery & Pastry</title>
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

        <!-- Login Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-amber-900/10">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-serif font-bold text-stone-900 flex items-center">
                    <i class="fa-solid fa-lock-open mr-2 text-amber-600"></i> Masuk ke Sistem
                </h2>
                <a href="{{ route('storefront.index') }}" class="text-xs text-amber-700 hover:text-amber-900 font-semibold">
                    &larr; Ke Toko Depan
                </a>
            </div>

            @if (session('success'))
                <div class="p-3 mb-4 text-xs text-emerald-800 bg-emerald-50 rounded-xl border border-emerald-200 flex items-center">
                    <i class="fa-solid fa-circle-check mr-2 text-emerald-600 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="p-3 mb-4 text-xs text-rose-800 bg-rose-50 rounded-xl border border-rose-200 flex items-start">
                    <i class="fa-solid fa-circle-exclamation mr-2 text-rose-600 text-sm mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" id="loginForm" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Email atau Username
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                            <i class="fa-regular fa-envelope"></i>
                        </span>
                        <input type="text" id="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="Masukkan email atau username"
                            class="w-full pl-10 pr-3.5 py-2.5 border border-stone-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-[11px] font-bold uppercase tracking-wider text-stone-700 mb-1">
                        Kata Sandi
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                            <i class="fa-solid fa-key"></i>
                        </span>
                        <input type="password" id="password" name="password" required
                            placeholder="Masukkan kata sandi"
                            class="w-full pl-10 pr-10 py-2.5 border border-stone-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        <button type="button" id="togglePasswordBtn" onclick="togglePasswordVisibility()"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-stone-400 hover:text-stone-700 focus:outline-none cursor-pointer transition-colors"
                            title="Tampilkan / Sembunyikan Kata Sandi" aria-label="Tampilkan atau sembunyikan kata sandi">
                            <i class="fa-solid fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center text-xs text-stone-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-stone-300 text-amber-600 focus:ring-amber-500 mr-2">
                        Ingat Saya
                    </label>
                    <a href="{{ route('register') }}" class="text-xs font-semibold text-amber-700 hover:text-amber-900">
                        Daftar Pelanggan?
                    </a>
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-[#3D2010] hover:bg-[#261309] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-md hover:shadow-lg transition flex items-center justify-center space-x-2">
                    <span>Masuk ke Akun</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
            </form>

            <!-- Role Autofill Boxes (Without Title, No Direct Bypass) -->
            <div class="mt-6 pt-5 border-t border-stone-100">
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="fillCredentials('admin@nazelle.test', 'password')"
                        class="p-2.5 bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 rounded-xl text-center transition flex flex-col items-center justify-center shadow-xs cursor-pointer focus:outline-none focus:ring-2 focus:ring-amber-400 active:scale-95">
                        <i class="fa-solid fa-crown text-amber-600 text-xs mb-1"></i>
                        <span class="text-xs font-bold">Admin</span>
                        <span class="text-[9px] text-stone-500">Owner</span>
                    </button>
                    <button type="button" onclick="fillCredentials('staff@nazelle.test', 'password')"
                        class="p-2.5 bg-stone-100 hover:bg-stone-200 text-stone-800 border border-stone-200 rounded-xl text-center transition flex flex-col items-center justify-center shadow-xs cursor-pointer focus:outline-none focus:ring-2 focus:ring-stone-400 active:scale-95">
                        <i class="fa-solid fa-bread-slice text-stone-600 text-xs mb-1"></i>
                        <span class="text-xs font-bold">Staff</span>
                        <span class="text-[9px] text-stone-500">Kasir/Baker</span>
                    </button>
                    <button type="button" onclick="fillCredentials('pelanggan@nazelle.test', 'password')"
                        class="p-2.5 bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-200 rounded-xl text-center transition flex flex-col items-center justify-center shadow-xs cursor-pointer focus:outline-none focus:ring-2 focus:ring-rose-400 active:scale-95">
                        <i class="fa-solid fa-cookie-bite text-rose-500 text-xs mb-1"></i>
                        <span class="text-xs font-bold">Pelanggan</span>
                        <span class="text-[9px] text-stone-500">Customer</span>
                    </button>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-6 text-center text-[11px] text-stone-400">
                Nazelle Délices &bull; Pâtisserie & Boulangerie Artisanale
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('password').focus();
        }
    </script>
</body>
</html>

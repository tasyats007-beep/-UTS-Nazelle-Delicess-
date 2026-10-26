<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-slate-200 p-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rose-100 text-rose-600 text-2xl mb-4">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h1 class="text-3xl font-extrabold text-slate-800">403</h1>
        <h2 class="text-lg font-bold text-slate-700 mt-2">Akses Ditolak (Forbidden)</h2>
        <p class="text-sm text-slate-500 mt-2">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses yang memadai untuk membuka atau menjalankan tindakan pada halaman ini.' }}
        </p>
        <div class="mt-6 flex justify-center gap-3">
            <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white rounded-lg text-sm font-semibold transition">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>

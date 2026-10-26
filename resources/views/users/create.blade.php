@extends('layouts.app')

@section('title', 'Tambah Pengguna Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h1 class="text-xl font-bold text-slate-800 flex items-center">
                <i class="fa-solid fa-user-plus text-yellow-600 mr-2.5"></i> Tambah Pengguna Baru
            </h1>
            <a href="{{ route('users.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800">
                &larr; Kembali
            </a>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">
                    Nama Lengkap <span class="text-rose-500">*</span>
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none @error('name') border-rose-500 @enderror"
                    placeholder="Contoh: Budi Santoso">
                @error('name')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">
                    Alamat Email <span class="text-rose-500">*</span>
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none @error('email') border-rose-500 @enderror"
                    placeholder="nama@perusahaan.com">
                @error('email')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-slate-700 mb-1">
                    Hak Akses / Peran <span class="text-rose-500">*</span>
                </label>
                <select name="role" id="role" required
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none @error('role') border-rose-500 @enderror">
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff Gudang (Transaksi Pembelian & Penjualan)</option>
                    <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Pelanggan / Customer (Melihat Katalog & Riwayat Belanja)</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin / Owner (Akses Penuh Master Data, Users, dan Pembatalan)</option>
                </select>
                @error('role')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1">
                    Kata Sandi <span class="text-rose-500">*</span>
                </label>
                <input type="password" name="password" id="password" required
                    class="w-full px-3.5 py-2.5 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-yellow-500 focus:outline-none @error('password') border-rose-500 @enderror"
                    placeholder="Minimal 6 karakter">
                @error('password')
                    <p class="text-rose-600 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-3 pt-4 border-t border-slate-100">
                <a href="{{ route('users.index') }}" class="px-4 py-2 border border-slate-300 rounded-lg text-sm font-semibold text-slate-600 hover:bg-slate-50 transition">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    Simpan Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

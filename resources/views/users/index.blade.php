@extends('layouts.app')

@section('title', 'Manajemen Pengguna & Hak Akses - Nazelle Délices')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 sm:p-8 rounded-3xl shadow-xs border border-bakery-200">
        <div>
            <div class="flex items-center space-x-2 text-xs font-bold uppercase tracking-wider text-bakery-600 mb-1">
                <i class="fa-solid fa-users-gear"></i>
                <span>Otorisasi & Akun Pengguna</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-serif font-bold text-bakery-950">
                Manajemen Pengguna & Role
            </h1>
            <p class="text-xs text-stone-500 mt-1">Kelola akun Admin/Owner, Staff Kasir & Baker, serta Akun Pelanggan terdaftar.</p>
        </div>
        <div>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2.5 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-xs transition">
                <i class="fa-solid fa-user-plus mr-1.5"></i> Tambah Pengguna Baru
            </a>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white p-5 rounded-2xl border border-bakery-200 shadow-xs">
        <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            <!-- Search Text -->
            <div class="sm:col-span-6 relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-stone-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </span>
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama atau email pengguna..."
                    class="w-full pl-9 pr-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
            </div>

            <!-- Role Filter -->
            <div class="sm:col-span-3">
                <select name="role" class="w-full px-3 py-2 border border-bakery-200 rounded-xl text-xs bg-bakery-50/50 focus:ring-2 focus:ring-amber-500 focus:outline-none">
                    <option value="">-- Semua Role Pengguna --</option>
                    <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin / Owner</option>
                    <option value="staff" {{ $role == 'staff' ? 'selected' : '' }}>Staff Kasir & Baker</option>
                    <option value="customer" {{ $role == 'customer' ? 'selected' : '' }}>Pelanggan / Customer</option>
                </select>
            </div>

            <div class="sm:col-span-3 flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-bakery-800 hover:bg-bakery-900 text-white text-xs font-semibold rounded-xl transition shadow-xs">
                    Filter
                </button>

                @if($search || $role)
                    <a href="{{ route('users.index') }}" class="px-3 py-2 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-semibold rounded-xl transition">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="bg-white rounded-3xl shadow-xs border border-bakery-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-bakery-100 text-xs">
                <thead class="bg-bakery-50/60 text-stone-500 font-semibold text-left">
                    <tr>
                        <th class="px-6 py-4">Nama Pengguna</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4 text-center">Hak Akses (Role)</th>
                        <th class="px-6 py-4 text-center">Aktivitas Transaksi</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-bakery-100">
                    @forelse ($users as $u)
                    <tr class="hover:bg-bakery-50/40 transition">
                        <td class="px-6 py-4 font-serif font-bold text-sm text-bakery-950">
                            {{ $u->name }}
                        </td>
                        <td class="px-6 py-4 font-mono text-stone-600">
                            {{ $u->email }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($u->role === 'admin')
                                <span class="bg-amber-100 text-amber-900 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">
                                    👑 Owner / Admin
                                </span>
                            @elseif($u->role === 'staff')
                                <span class="bg-bakery-100 text-bakery-900 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">
                                    🥖 Staff Kasir & Baker
                                </span>
                            @else
                                <span class="bg-rose-100 text-rose-900 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">
                                    🧁 Pelanggan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-stone-500">
                            <span class="text-[11px] font-semibold">
                                {{ $u->sales_count }} Penjualan &bull; {{ $u->purchases_count }} Pembelian
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('users.edit', $u) }}" class="text-amber-600 hover:text-amber-800 font-semibold">
                                Edit
                            </a>
                            @if(auth()->id() !== $u->id)
                            <span class="text-stone-300">&bull;</span>
                            <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun pengguna ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-semibold">
                                    Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-stone-400">
                            Tidak ada pengguna ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-bakery-100">
            {{ $users->links() }}
        </div>
    </div>

</div>
@endsection

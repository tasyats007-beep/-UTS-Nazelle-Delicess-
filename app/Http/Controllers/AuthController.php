<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email atau username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $loginInput = trim($request->input('email'));
        $password = $request->input('password');

        // Allow login by email or username (name)
        $user = User::where('email', $loginInput)
            ->orWhere('name', $loginInput)
            ->first();

        // Strict validation: must match hashed password in database (no bypass)
        if (! $user || ! Hash::check($password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau kata sandi salah',
            ])->onlyInput('email');
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Clear intended URL if user is staff/customer and intended URL contains admin-only routes to avoid 403
        $intended = $request->session()->get('url.intended');
        if (($user->isStaff() || $user->isCustomer()) && $intended) {
            if (str_contains($intended, '/users') || str_contains($intended, '/create') || str_contains($intended, '/edit') || str_contains($intended, '-create') || str_contains($intended, '/purchases')) {
                $request->session()->forget('url.intended');
            }
        }

        if ($user->isAdmin()) {
            $roleLabel = 'Administrator / Bakery Owner';
        } elseif ($user->isStaff()) {
            $roleLabel = 'Staff Kasir & Baker';
        } else {
            $roleLabel = 'Pelanggan (Customer)';
        }

        return redirect()->intended(route('dashboard'))
            ->with('success', "Selamat datang, {$user->name} ({$roleLabel})! Anda berhasil masuk ke Nazelle Délices.");
    }

    public function showRegisterForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique' => 'Email ini sudah terdaftar. Silakan gunakan email lain atau masuk.',
            'password.min' => 'Kata sandi minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('storefront.index')
            ->with('success', "Pendaftaran berhasil! Selamat datang di Nazelle Délices, {$user->name}. Selamat menikmati aneka pastry segar kami.");
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}

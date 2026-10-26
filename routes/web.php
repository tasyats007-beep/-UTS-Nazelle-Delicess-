<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Nazelle Délices - Pâtisserie & Boulangerie Artisanale
|--------------------------------------------------------------------------
*/

// Public Landing Page & Storefront
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/beranda', [LandingController::class, 'index'])->name('landing.home');
Route::get('/katalog', [StorefrontController::class, 'index'])->name('storefront.index');
Route::get('/menu', [StorefrontController::class, 'index'])->name('storefront.catalog');
Route::post('/checkout', [StorefrontController::class, 'checkout'])->name('storefront.checkout');
Route::get('/sales/{sale}/invoice', [SaleController::class, 'invoice'])->name('sales.invoice');
Route::post('/sales/{sale}/simulate-payment', [SaleController::class, 'simulatePayment'])->name('sales.simulate-payment');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (Must be Logged in)
Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pesanan-saya', [StorefrontController::class, 'myOrders'])->name('customer.orders');
    Route::get('/orders', [StorefrontController::class, 'myOrders'])->name('storefront.orders');

    // Products (Staff & Customer can view; Admin has full CRUD)
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

    // Suppliers (Staff & Admin can view suppliers)
    Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers.index');

    // Purchases / Stock-In (Staff & Admin can record stock restock; Customer blocked)
    Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
    Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');
    Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

    // Sales / Stock-Out (Kasir POS & Penjualan)
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');
    Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');

    // -------------------------------------------------------------
    // Admin / Owner Only Routes (Protected by EnsureAdmin middleware)
    // -------------------------------------------------------------
    Route::middleware('admin')->group(function () {
        // User & Role Management
        Route::resource('users', UserController::class)->except(['show']);

        // Master Data Management (Create/Edit/Delete)
        Route::get('/products-create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');
        Route::post('/suppliers', [SupplierController::class, 'store'])->name('suppliers.store');
        Route::get('/suppliers/{supplier}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');

        // Transaction Cancellations with atomic stock restoration
        Route::post('/purchases/{purchase}/cancel', [PurchaseController::class, 'cancel'])->name('purchases.cancel');
        Route::post('/sales/{sale}/cancel', [SaleController::class, 'cancel'])->name('sales.cancel');
    });
});

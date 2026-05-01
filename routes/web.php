<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ───────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk', [ProductController::class, 'index'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'show'])->name('products.show');

// ─── Auth Routes ─────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Authenticated User Routes ────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/keranjang/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{cart}', [CartController::class, 'remove'])->name('cart.remove');

    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
    Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/pesanan/sukses/{order}', [OrderController::class, 'success'])->name('orders.success');
    Route::get('/pesanan/riwayat', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/produk', [Admin\ProductController::class, 'index'])->name('products.index');
    Route::get('/produk/tambah', [Admin\ProductController::class, 'create'])->name('products.create');
    Route::post('/produk', [Admin\ProductController::class, 'store'])->name('products.store');
    Route::get('/produk/{product}/edit', [Admin\ProductController::class, 'edit'])->name('products.edit');
    Route::put('/produk/{product}', [Admin\ProductController::class, 'update'])->name('products.update');
    Route::delete('/produk/{product}', [Admin\ProductController::class, 'destroy'])->name('products.destroy');

    // Categories
    Route::get('/kategori', [Admin\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/kategori', [Admin\CategoryController::class, 'store'])->name('categories.store');
    Route::put('/kategori/{category}', [Admin\CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/kategori/{category}', [Admin\CategoryController::class, 'destroy'])->name('categories.destroy');

    // Orders
    Route::get('/pesanan', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/pesanan/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');
});

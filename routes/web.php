<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes (Authenticated)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    
    // Order Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Products
    Route::resource('products', AdminProductController::class);
    Route::patch('/products/{product}/stock', [AdminProductController::class, 'updateStock'])->name('products.stock');
    
    // POS Routes
    Route::get('/pos', [App\Http\Controllers\Admin\PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/search', [App\Http\Controllers\Admin\PosController::class, 'searchProducts'])->name('pos.search');
    Route::post('/pos/process', [App\Http\Controllers\Admin\PosController::class, 'processSale'])->name('pos.process');
    Route::get('/pos/product/{id}', [App\Http\Controllers\Admin\PosController::class, 'getProduct'])->name('pos.product');
    Route::post('/pos/stock-updates', [App\Http\Controllers\Admin\PosController::class, 'getStockUpdates'])->name('pos.stock');
    Route::get('/pos/receipt/{order}', [App\Http\Controllers\Admin\PosController::class, 'printReceipt'])->name('pos.receipt');
    Route::get('/pos/stats', [App\Http\Controllers\Admin\PosController::class, 'getStats'])->name('pos.stats');
    Route::post('/pos/hold', [App\Http\Controllers\Admin\PosController::class, 'holdTransaction'])->name('pos.hold');
    Route::get('/pos/held', [App\Http\Controllers\Admin\PosController::class, 'getHeldTransactions'])->name('pos.held');
    Route::get('/pos/resume/{holdName}', [App\Http\Controllers\Admin\PosController::class, 'resumeTransaction'])->name('pos.resume');
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
});

require __DIR__.'/auth.php';

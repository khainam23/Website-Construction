<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AdminDeviceController;

// Liên kết các trang 
Route::view('/', 'index')->name('index');
Route::view('/login', 'login')->name('login');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/checkout', 'checkout')->name('checkout');
Route::view('/cart', 'cart')->name('cart');
Route::view('/product', 'product')->name('product');
Route::view('/product-details', 'product-details')->name('product-details');
Route::view('/shop', 'shop')->name('shop');
Route::view('/wishlist', 'wishlist')->name('wishlist');
Route::view('/404', '404')->name('404');

// Login
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login');
Route::get("/api/logout", [AuthController::class, 'logout'])->name('api.logout');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/devices/{device}', [DeviceController::class, 'show'])->name('devices.show');

// Group các route cần quyền admin
Route::middleware(['role:admin'])->group(function () {
    Route::resource('devices', DeviceController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('reports', ReportController::class);
});

// Group các route cho nhân viên bán hàng
Route::middleware(['role:sales'])->group(function () {
    Route::resource('sales', SaleController::class);
    Route::resource('orders', OrderController::class);
});

// Group các route cho nhân viên cho thuê
Route::middleware(['role:rental'])->group(function () {
    Route::resource('rentals', RentalController::class);
});

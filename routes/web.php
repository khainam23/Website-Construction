<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\VnpayController;

// Public Routes
Route::view('/', 'index')->name('index');
Route::view('/login', 'login')->name('login');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/shop', 'shop')->name('shop');
Route::view('/404', '404')->name('404');
Route::get('/product-details/{id}', fn($id) => view('product-details', compact('id')))->name('product-details');

// Authentication
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login');
Route::get('/api/logout', [AuthController::class, 'logout'])->name('api.logout');

// Protected Routes
Route::middleware([RoleMiddleware::class . ':customer,admin,sales,warehouse'])->group(function () {
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');
    Route::resource('/api/orders', OrderController::class)->only(['index', 'store']);
    Route::resource('/api/sales', SaleController::class)->only(['index', 'store']);
    Route::resource('/api/rentals', RentalController::class)->only(['index', 'store']);

    // VNPAY
    Route::post('/api/payment/vnpay', [VnpayController::class, 'createPayment'])->name('api.payment.vnpay');
    Route::get('/vnpay/return', [VnpayController::class, 'vnpayReturn'])->name('vnpay.return');
});

// Admin & Staff Routes
Route::middleware([RoleMiddleware::class . ':admin,sales,warehouse'])->group(function () {
    Route::get('/statistics', [ReportController::class, 'viewStatistics'])->name('statistics');
    Route::resource('/api/devices', DeviceController::class)->except(['create', 'edit']);
    Route::resource('/api/reports', ReportController::class)->except(['create', 'edit']);
    Route::get('/api/statistics/device-stats', [ReportController::class, 'getDeviceStatistics']);
    Route::get('/manager-product', [DeviceController::class, 'viewManagerProduct'])->name('manager-product');
});

// Admin Only Routes
Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::resource('/api/sales', SaleController::class)->except(['index', 'store']);
    Route::resource('/api/rentals', RentalController::class)->except(['index', 'store']);
    Route::get('/api/statistics/{period}-revenue', [ReportController::class, 'getRevenue'])->where('period', 'daily|weekly|quarterly|yearly');
});
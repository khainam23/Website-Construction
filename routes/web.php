<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
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
use Laravel\Sail\SailServiceProvider;

// Liên kết các trang 
Route::view('/', 'index')->name('index');
Route::view('/login', 'login')->name('login');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::get('/product-details/{id}', function ($id) {
    return view('product-details', ['id' => $id]);
})->name('product-details');
Route::view('/shop', 'shop')->name('shop');
Route::view('/404', '404')->name('404');

// Login and Logout - No middleware required
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login'); // Stateful
Route::get("/api/logout", [AuthController::class, 'logout'])->name('api.logout');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Service public 
Route::middleware([RoleMiddleware::class . ':customer,admin'])->group(function () {
    Route::post('/api/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');
    Route::get('/api/cart', [OrderController::class, 'index'])->name('orders.index');

    // Sales & Rentals for customers
    Route::post('/api/sales', [SaleController::class, 'store'])->name('api.sales');
    Route::get('/api/sales', [SaleController::class,'index'])->name('api.sales.index');
    Route::post('/api/rentals', [RentalController::class,'store'])->name('api.rentals');
    Route::get('/api/rentals', [RentalController::class,'index'])->name('api.rentals.index');
});

// Admin and Sales
Route::middleware([RoleMiddleware::class . ':admin']) -> group(
    function() {
        Route::get('/statistics', [ReportController::class, 'viewStatistics'])->name('statistics');
        
        // Statistics API routes accessible by both admin and sales - remove monthly route
        Route::get('/api/statistics/quarterly-revenue', [ReportController::class, 'getQuarterlyRevenue']);
        Route::get('/api/statistics/yearly-revenue', [ReportController::class, 'getYearlyRevenue']);
    }
);

// Admin only routes
Route::middleware([RoleMiddleware::class . ':admin']) -> group(
    function() {
        Route::delete("/api/device/{id}", [DeviceController::class, 'destroy'])->name('api.device.destroy');
        Route::get("/api/devices", [DeviceController::class, 'index'])->name('api.devices.index');
        Route::view('manager-product', 'manager-product')->name('manager-product');
        
        // Add new device management routes
        Route::post("/api/devices", [DeviceController::class, 'store'])->name('api.devices.store');
        Route::get("/api/devices/{id}", [DeviceController::class, 'show'])->name('api.devices.show');
        Route::put("/api/devices/{id}", [DeviceController::class, 'update'])->name('api.devices.update');
        
        // Admin-only statistics routes
        Route::get('/api/statistics/device-stats', [ReportController::class, 'getDeviceStatistics']);

        // Add Report API routes
        Route::get('/api/reports', [ReportController::class, 'index'])->name('api.reports.index');
        Route::post('/api/reports', [ReportController::class, 'store'])->name('api.reports.store');
        Route::get('/api/reports/{id}', [ReportController::class, 'show'])->name('api.reports.show');
        Route::put('/api/reports/{id}', [ReportController::class, 'update'])->name('api.reports.update');
        Route::delete('/api/reports/{id}', [ReportController::class, 'destroy'])->name('api.reports.destroy');

        // Full Sales API access for admin
        Route::get('/api/sales/{id}', [SaleController::class, 'show'])->name('api.sales.show');
        Route::put('/api/sales/{id}', [SaleController::class, 'update'])->name('api.sales.update');
        Route::delete('/api/sales/{id}', [SaleController::class, 'destroy'])->name('api.sales.destroy');

        // Full Rentals API access for admin  
        Route::get('/api/rentals/{id}', [RentalController::class, 'show'])->name('api.rentals.show');
        Route::put('/api/rentals/{id}', [RentalController::class, 'update'])->name('api.rentals.update');
        Route::delete('/api/rentals/{id}', [RentalController::class, 'destroy'])->name('api.rentals.destroy');
        
        // Remove duplicate routes and use consistent api prefix
        Route::get('/api/statistics/daily-revenue', [ReportController::class, 'getDailyRevenue']);
        Route::get('/api/statistics/weekly-revenue', [ReportController::class, 'getWeeklyRevenue']);
    }
);
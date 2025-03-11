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

// Login
Route::post('/api/login', [AuthController::class, 'login'])->name('api.login'); // Stateful
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Service public 
Route::middleware([RoleMiddleware::class . ':customer,admin'])->group(function () {
    Route::post('/api/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::view('/cart', 'cart')->name('cart');
    Route::view('/checkout', 'checkout')->name('checkout');
    Route::get('/api/cart', [OrderController::class, 'index'])->name('orders.index');

    Route::get("/api/logout", [AuthController::class, 'logout'])->name('api.logout');
    Route::post('/api/sales', [SaleController::class, 'store'])->name('api.sales');
    Route::get('/api/sales', [SaleController::class,'index'])->name('api.sales.index');
    Route::post('/api/rentals', [RentalController::class,'store'])->name('api.rentals');
    Route::get('/api/rentals', [RentalController::class,'index'])->name('api.rentals.index');
});

// Admin
Route::middleware([RoleMiddleware::class . ':admin,sales,warehouse']) -> group(
    function() {
        Route::get('/statistics', [ReportController::class, 'viewStatistics'])->name('statistics');
        Route::post("/api/device/delete/{id}", [DeviceController::class, 'destroy'])->name('api.device.destroy');
        Route::get("/api/devices", [DeviceController::class, 'index'])->name('api.devices.index');
        Route::get('manager-product', [DeviceController::class, 'viewManagerProduct'])->name('manager-product');

        Route::get("/api/devices/count", [DeviceController::class, 'count'])->name('api.devices.count');
        Route::get("/api/rentals/count", [RentalController::class, 'count'])->name('api.rentals.count');
        Route::get("/api/sales/count", [SaleController::class, 'count'])->name('api.sales.count');
        
        Route::post('/api/device/{id}', [DeviceController::class, 'update'])->name('api.device.update');

        Route::get('/api/sales/all', [SaleController::class, 'all'])->name('api.sales.all');
        Route::get('/api/rentals/all', [RentalController::class, 'all'])->name('api.rentals.all');
    }
);

// // Group các route cần quyền admin
// Route::middleware(['role:admin'])->group(function () {
//     Route::resource('devices', DeviceController::class);
//     Route::resource('inventories', InventoryController::class);
//     Route::resource('reports', ReportController::class);
// });

// // Group các route cho nhân viên bán hàng
// Route::middleware(['role:sales'])->group(function () {
//     Route::resource('sales', SaleController::class);
//     // Route::resource('orders', OrderController::class);
// });

// // Group các route cho nhân viên cho thuê
// Route::middleware(['role:rental'])->group(function () {
//     Route::resource('rentals', RentalController::class);
// });
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;

// Auth Routes
Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('login', [AuthController::class, 'login'])->name('api.login');
Route::post('forgot-password', [AuthController::class, 'forget'])->name('api.forgot-password');
Route::get('verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('api.verify-email');

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Devices
    Route::apiResource('devices', DeviceController::class);
    
    // Inventory
    Route::apiResource('inventory', InventoryController::class);
    
    // Orders
    Route::apiResource('orders', OrderController::class);
    
    // Rentals
    Route::apiResource('rentals', RentalController::class);
    
    // Sales
    Route::apiResource('sales', SaleController::class);
    
    // Reports
    Route::apiResource('reports', ReportController::class);
});

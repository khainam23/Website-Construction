<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\InvoiceController;

// Auth Routes
Route::post('register', [AuthController::class, 'register'])->name('api.register');
Route::post('forgot-password', [AuthController::class, 'forget'])->name('api.forgot-password');
Route::get('verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('api.verify-email');

Route::get('devices/{id}', [DeviceController::class, 'show']);

// Service public 
Route::middleware([RoleMiddleware::class . ':customer,admin'])->group(function () {

});

// Protected Routes
// Route::middleware('auth:sanctum')->group(function () {
//     // Inventory
//     Route::apiResource('inventory', InventoryController::class);
    
//     // Rentals
//     Route::apiResource('rentals', RentalController::class);
    
//     // Sales
//     Route::apiResource('sales', SaleController::class);
    
//     // Reports
//     Route::apiResource('reports', ReportController::class);
//     // Invoices
//     Route::prefix('invoices')->group(function () {
//         Route::get('/', [InvoiceController::class, 'index']);
//         Route::post('/', [InvoiceController::class, 'store']);
//         Route::get('/{id}', [InvoiceController::class, 'show']);
//         Route::post('/{id}/pay', [InvoiceController::class, 'markAsPaid']);
//         Route::post('/from-sale/{sale}', [InvoiceController::class, 'generateFromSale']);
//     });
// });

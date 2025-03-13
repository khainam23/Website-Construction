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



Route::get('/docs', function () {
    return view('swagger.index');
});

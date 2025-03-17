<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, "index"])->name("web.home");
Route::get("/", [HomeController::class, "index"])->name("web.index"); // Phòng trường hợp đổi tên
Route::view("/abouts", 'frontend.about')->name('web.about');
Route::view('/contact', 'frontend.contact')->name('web.contact');
Route::view('/news', 'frontend.news')->name('web.news');
    Route::get('/admin/language/{lang}', [LanguageController::class, 'changeLanguage'])
        ->name('admin.language');
Route::get('/product/{type}', [ProductController::class, 'viewAll'])
    ->where('type', 'sale|rental|all')
    ->name('web.product');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('web.product-detail');
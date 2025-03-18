<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

// Các tính năng public
Route::get("/", [HomeController::class, "index"])->name("web.index");
Route::get("/home", [HomeController::class, "index"])->name("web.index");
Route::view("/abouts", 'frontend.about')->name('web.about');
Route::view('/contact', 'frontend.contact')->name('web.contact');
Route::view('/news', 'frontend.news')->name('web.news');
Route::get('/admin/language/{lang}', [LanguageController::class, 'changeLanguage'])
    ->name('admin.language');
Route::get('/product/{type}', [ProductController::class, 'viewAll'])
    ->where('type', 'sale|rental|all')
    ->name('web.product');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('web.product-detail');
Route::post('/add-contact', [ContactController::class, 'add'])->name('web.addContact');

// Dành cho truy cập
Route::view('/login', 'frontend.login')->name('web.login');
Route::view('/register', 'frontend.register')->name('web.register');
Route::view('/forget', 'frontend.forget')->name('web.forget');
Route::post('/forget', [ForgetController::class, "forget"])->name("api.forget");
Route::post('/register', [RegisterController::class, 'register'])->name('api.register');
Route::post('/login', [LoginController::class, 'login'])->name('api.login');

// Dành cho email
Route::post('/email/resend', [EmailController::class, 'resend'])->name('verification.resend');
Route::get('/email/verify/{id}/{hash}', [EmailController::class, 'verify'])->name('verification.verify');

// Dành cho mọi tài khoản đăng nhập thành công 
Route::middleware([RoleMiddleware::class . ":customer,admin,sale,rental"])->group(function () {
    Route::get('logout', [])->name('api.logout');

    // Trang người dùng
    Route::get('/profile', [ProfileController::class, 'index'])->name('web.profile');
    Route::post('/profile/udpate/info', [ProfileController::class, 'updateInfo'])->name('api.update.info');
    Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('api.update.password');
});

// Dành cho admin
Route::middleware([RoleMiddleware::class . ':admin'])->group(function () { });

// Dành cho sale
Route::middleware([RoleMiddleware::class . ':sale,admin'])->group(function () { });

// Dành cho rental 
Route::middleware([RoleMiddleware::class . 'rental'])->group(function () { });

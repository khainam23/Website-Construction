<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RevenueController;

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
    Route::get('logout', [LogoutController::class, 'logout'])->name('api.logout');
});

// Dành cho admin
Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // User Management
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');

    // Product Management
    Route::get('/admin/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin.products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin.products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin.products/{product}', [ProductController::class, 'delete'])->name('admin.products.delete');

    // Order Management
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

    // Category Management Routes
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
    Route::post('/admin/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::get('/admin.categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
    Route::put('/admin.categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/admin.categories/{category}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
});

// Dành cho sale
// Route::middleware([RoleMiddleware::class . ':sale'])->group(function () {
    Route::get('/sale/dashboard', [SalesController::class, 'dashboard'])->name('sale.dashboard');
    Route::get('/sale/sales/revenue', [RevenueController::class, 'index'])->name('sale.sales.revenue');
    Route::get('/sale/sales/product-sales', [SalesController::class, 'productSales'])->name('sale.sales.productSales');
    Route::get('/sale/sales', [SalesController::class, 'index'])->name('sale.sales.index');
// });

// Dành cho rental
Route::middleware([RoleMiddleware::class . ':rental'])->group(function () {
});

<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PaymentContronller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Middleware\CategoryMiddleware;
use App\Http\Middleware\LanguageMiddleware;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AssetController;

// Apply language middleware to all routes
Route::middleware([LanguageMiddleware::class])->group(function () {
    // Các tính năng public
    Route::get("/", [HomeController::class, "index"])->name("web.index");
    Route::get("/home", [HomeController::class, "index"])->name("web.index");
    Route::view("/abouts", 'frontend.about')->name('web.about');
    Route::view('/contact', 'frontend.contact')->name('web.contact');
    Route::view('/news', 'frontend.news')->name('web.news');
    Route::get('/language/{lang}', [LanguageController::class, 'changeLanguage'])->name('web.language');
    Route::get('/product/{type}', [ProductController::class, 'viewAll'])
        ->where('type', 'staff|rental|all')
        ->name('web.product');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('web.product.detail');
    Route::post('/add-contact', [ContactController::class, 'add'])->name('api.contract.add');

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
    Route::middleware([RoleMiddleware::class . ":customer,admin,staff,rental"])->group(function () {
        Route::get('logout', [LogoutController::class, 'logout'])->name('api.logout');
        Route::post('logout', [LogoutController::class, 'logout'])->name('api.logout.post');
    });

    // Chỉ dành cho người dùng 
    Route::middleware([RoleMiddleware::class . ':customer'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('web.profile');
        Route::post('/profile/udpate/info', [ProfileController::class, 'updateInfo'])->name('api.update.info');
        Route::post('/profile/update/password', [ProfileController::class, 'updatePassword'])->name('api.update.password');

        Route::post('/cart/add', [CartController::class, 'add'])->name('api.cart.add');
        Route::post('/cart/payment', [PaymentContronller::class, 'all'])->name('api.payment');
        Route::get('/payment/vnpay/return', [PaymentContronller::class, 'vnpayReturn'])->name('api.payment.vnpay.return');
        Route::post('/order/cancel', [OrderController::class, 'cancel'])->name('api.order.cancel');
    });

    // Dành cho việc điều hành sản phẩm
    Route::middleware([RoleMiddleware::class . ':admin,staff'])->group(function () {
        // Product Management, phần middleware giúp category chỉ cần gọi một lần hạn chế gọi nhiều 
        Route::middleware([CategoryMiddleware::class])->group(function () {
            Route::get('/admin/products', [AssetController::class, 'loadProduct'])->name('admin.products.index');
            Route::get('/admin/products/{product}/edit', [AssetController::class, 'edit'])->name('admin.products.edit');
            Route::view('/admin/product/create', 'admin.products.create')->name('admin.products.create');
        });
        Route::post('/admin/product/store', [AssetController::class, 'store'])->name('admin.api.product.store');
        Route::post('/admin/products/{id}', [AssetController::class, 'update'])->name('admin.api.products.update');
        Route::delete('/admin.products/{product}', [AssetController::class, 'delete'])->name('admin.products.delete');
        Route::post('/admin/product/add/image', [AssetController::class, 'uploadImages'])->name('admin.api.product.upload.images');
        Route::delete('/admin.product/delete/image/{id}', [AssetController::class, 'deleteImage'])->name('admin.api.product.delete.image');
        Route::get('/admin/product/search/{name}', [AssetController::class, 'search'])->name('admin.api.product.search');
        
        // Shared revenue route for admin and staff
        Route::get('/admin/sales/revenue', [RevenueController::class, 'index'])->name('admin.sales.revenue');
        Route::get('/staff/sales/revenue', [RevenueController::class, 'index'])->name('staff.sales.revenue');
    });

    // Dành cho admin
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User Management
        Route::get('/admin/users', [AccountController::class, 'loadAccount'])->name('admin.users.index');
        Route::post('/admin/user/update', [AccountController::class, 'update'])->name('admin.api.user.update');
        Route::post('/admin/user/show', [AccountController::class, 'show'])->name('admin.api.user.show');

        // Order Management
        Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/admin.orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/admin/order/update/status', [OrderController::class, 'updateStatus'])->name('admin.api.order.update.status');

        // Category Management Routes
        Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/admin/categories/create', [CategoryController::class, 'create'])->name('admin.categories.create');
        Route::post('/admin.categories', [CategoryController::class, 'store'])->name('admin.categories.store');
        Route::get('/admin.categories/{category}/edit', [CategoryController::class, 'edit'])->name('admin.categories.edit');
        Route::put('/admin.categories/{category}', [CategoryController::class, 'update'])->name('admin.categories.update');
        Route::delete('/admin.categories/{category}', [CategoryController::class, 'delete'])->name('admin.categories.delete');
    });

    // Dành cho staff
    Route::middleware([RoleMiddleware::class . ':admin,staff'])->group(function () {
        Route::get('/staff/dashboard', [SalesController::class, 'dashboard'])->name('staff.dashboard');
        Route::get('/staff/sales/product-sales', [SalesController::class, 'productSales'])->name('staff.sales.productSales');
        Route::get('/staff/sales', [SalesController::class, 'index'])->name('staff.sales.index');
    });

    // Dành cho rental
    Route::middleware([RoleMiddleware::class . ':rental'])->group(function () {
    });

});

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $locale = Session::get('locale', env('APP_LOCALE')); // Lấy ngôn ngữ từ session, mặc định là 'en'
        App::setLocale($locale); // Cập nhật ngôn ngữ cho ứng dụng

        View::share('lang', $locale); // Chia sẻ biến $lang cho tất cả View
    }
}

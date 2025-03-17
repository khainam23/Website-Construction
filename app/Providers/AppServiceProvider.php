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

        $contact = Session::get('contacts', [
            'address' => env('CONTACT_ADRESS'),
            'address_en' => env('CONTACT_ADRESS_EN'),
            'representative_office' => env('CONTACT_REPRESENTATIVE_OFFICE'),
            'representative_office_en' => env('CONTACT_REPRESENTATIVE_OFFICE_EN'),
            'phone' => env('CONTACT_PHONE'),
            'phone_2' => env('CONTACT_PHONE_2'),
            'WeChat' => env('CONTACT_WE_CHAT'),
            'WhatsApp' => env('CONTACT_WHATS_APP'),
            'email' => env('CONTACT_EMAIL'),
        ]);

        View::share('lang', $locale); // Chia sẻ biến $lang cho tất cả View
        View::share('contacts', $contact);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage($lang)
    {
        session()->put('app_locale', $lang);

        // Redirect về trang trước
        return redirect()->back();
    }
}

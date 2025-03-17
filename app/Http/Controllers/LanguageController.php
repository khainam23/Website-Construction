<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function changeLanguage($lang)
    {
        if (in_array($lang, ['en', 'vi', 'my', 'lo'])) {
            session(['locale' => $lang]); // Lưu vào session
            App::setLocale($lang);
        }
        return redirect()->back()->with('reload', true);
    }
}

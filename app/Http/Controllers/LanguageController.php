<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function changeLanguage($lang, Request $request)
    {
        if (in_array($lang, ['en', 'vi', 'my', 'lo'])) {
            session(['locale' => $lang]); // Save to session
            App::setLocale($lang);
        }
        
        // Get the previous URL from the request
        $previousUrl = url()->previous();
        
        // Redirect back to the previous page
        return redirect($previousUrl);
    }
}

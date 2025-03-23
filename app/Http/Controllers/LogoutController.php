<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Save the current language preference before clearing the session
        $currentLocale = session('locale', config('app.locale'));
        
        // Clear the user session
        session()->forget('user');
        
        // If using Laravel's auth system as a backup
        if (Auth::check()) {
            Auth::logout();
        }
        
        // Clear all session data
        Session::flush();
        
        // Restore the language preference
        session(['locale' => $currentLocale]);
        
        // Redirect to home page with a success message
        return redirect('/')->with('success', 'You have been logged out successfully');
    }
}

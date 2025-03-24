<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get language from session or use default from config
        $lang = session('locale', config('app.locale'));
        
        if (in_array($lang, ['en', 'vi', 'my', 'lo'])) {
            App::setLocale($lang);
        }
        
        // Share the current language with all views
        view()->share('lang', $lang);
        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Category;

class CategoryMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $categories = Category::all();
        view()->share('categories', $categories);

        return $next($request);
    }
}

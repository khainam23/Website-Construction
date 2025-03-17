<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user =  session("user");

        if (!$user || !in_array($user['role'], $roles)) {
            abort(403, 'Unauthorized' );
        }

        return $next($request);
    }
}
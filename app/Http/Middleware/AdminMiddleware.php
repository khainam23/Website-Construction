<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }

        $user = $request->session()->get('user');
        if ($user['role'] !== 'admin') {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Kiểm tra email có tồn tại trong hệ thống không
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(__('Email không tồn tại trong hệ thống'), 404);
        }

        // Kiểm tra email đã xác thực chưa (nếu có cột email_verified_at)
        if (!$user->email_verified_at) {
            return response()->json(__('Vui lòng xác thực email trước khi đăng nhập'), 403);
        }

        // Thử đăng nhập
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'is_active' => 1])) {
            $request->session()->regenerate();

            session([
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->last_name,
                    'role' => $user->role
                ]
            ]);

            // Điều hướng theo vai trò
            $redirectRoutes = [
                'admin' => 'admin.dashboard',
                'sale' => 'sale.dashboard',
                'warehouse' => 'warehouse.dashboard'
            ];

            return response()->json([
                'message' => __('Login successful'),
                'url' => route($redirectRoutes[$user->role] ?? 'web.index')
            ], 200);
        }

        return response()->json(__('Mật khẩu không đúng'), 403);
    }
}

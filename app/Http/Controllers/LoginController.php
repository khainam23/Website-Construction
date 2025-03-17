<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = $request->only('email', 'password');

        // Thử đăng nhập
        if (Auth::attempt(array_merge($credentials, ['is_active' => 1]))) {
            // Đăng nhập thành công
            $request->session()->regenerate();

            // Lưu thông tin người dùng vào session (nếu cần)
            $user = Auth::user();
            session([
                'user' => [
                    'email' => $user->email,
                    'name' => $user->last_name,
                    'role' => $user->role
                ]
            ]);

            // Chuyển hướng đến trang chủ hoặc trang dashboard
            return response()->json('Đăng nhập thành công', 200);
        }

        // Đăng nhập thất bại
        return response()->json('Thông tin đăng nhập không chính xác', 403);
    }
}

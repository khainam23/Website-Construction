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
                    'id'=> $user->id,
                    'email' => $user->email,
                    'name' => $user->last_name,
                    'role' => $user->role
                ]
            ]);

            if($user->role == 'admin') {
                return response()->json([
                    'message' => 'Đang điều hướng đến trang quản trị',
                    'url' => route('admin.dashboard')
                ], 200);
            } else if($user->role == 'sale'){
                return response()->json([
                    'message' => 'Đang điều hướng đến trang sản phẩm',
                    'url' => route('sale.dashboard')
                ], 200);
            } else if($user->role == 'warehouse'){
                // Hiện không có
            } else {
                return response()->json([
                    'message' => 'Đăng nhập thành công',
                    'url' => route('web.index')
                ], 200);
            }
        }

        // Đăng nhập thất bại
        return response()->json('Thông tin đăng nhập không chính xác', 403);
    }
}

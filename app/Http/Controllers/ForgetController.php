<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewPasswordMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class ForgetController extends Controller
{
    public function forget(Request $request)
    {
        $email = $request->email;
        $user = User::where("email", $email)->first();

        if (!$user) {
            return response()->json("Không tìm thấy tài khoản", 404);
        }

        // Tạo mật khẩu mới
        $newPassword = Str::random(10);

        // Cập nhật mật khẩu mới trong database
        $user->password = Hash::make($newPassword);
        $user->save();

        // Gửi email thông báo mật khẩu mới
        Mail::to($email)->send(new NewPasswordMail($newPassword));

        return response()->json("Mật khẩu mới đã được gửi qua email");
    }
}

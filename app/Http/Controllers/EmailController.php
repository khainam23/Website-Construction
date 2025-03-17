<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class EmailController extends Controller
{
    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Email xác nhận đã được gửi lại.']);
    }

    public function verify(Request $request)
    {
        $user = User::find($request->id); // Lấy người dùng từ ID
        if ($user && hash_equals((string) $request->hash, sha1($user->getEmailForVerification()))) {
            $user->email_verified_at = now(); // Cập nhật thời gian xác thực
            $user->is_active = 1;
            $user->save(); // Lưu thay đổi
            return response()->redirectTo('/login');
        }
    
        return response()->redirectTo('/register');
    }
}

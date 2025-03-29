<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'regex:/^[A-Za-zÀ-Ỹà-ỹ\s]+$/u', 'max:255'],
            'last_name' => ['required', 'regex:/^[A-Za-zÀ-Ỹà-ỹ\s]+$/u', 'max:255'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20|confirmed',
            'phone' => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $fileName);
            $avatarPath = 'avatars/' . $fileName;
        }

        $user = User::create([
            'first_name' => ucfirst(strtolower(trim($validatedData['first_name']))),
            'last_name' => ucfirst(strtolower(trim($validatedData['last_name']))),
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'] ?? null,
            'date_of_birth' => $validatedData['date_of_birth'] ?? null,
            'gender' => $validatedData['gender'],
            'avatar' => $avatarPath,
            'is_active' => 0
        ]);

        $user->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.'
        ]);
    }
}

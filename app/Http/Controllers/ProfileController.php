<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $userId = session('user')['id'];

        $infoUser = User::where('id', $userId)->first()->makeHidden(['password', 'verification_token', 'role', 'is_active', 'last_login', 'email_verified_at']);

        $cartItems = Cart::where('user_id', $userId)->get();

        $orders = Order::where('user_id', $userId)
            ->with('details.product')
            ->get()
            ->toArray();

        return view('frontend.profile', compact('infoUser', 'cartItems', 'orders'));
    }

    public function updateInfo(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validate ảnh
        ]);

        // Lấy các trường có thay đổi
        $changes = array_diff_assoc($validatedData, $user->only(array_keys($validatedData)));

        // Kiểm tra nếu không có thay đổi
        if (empty($changes) && !$request->hasFile('avatar')) {
            return response()->json(['message' => 'Không có thay đổi nào để cập nhật.'], 200);
        }

        // Xử lý cập nhật avatar
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('avatars'), $fileName);

            // Xóa ảnh cũ nếu có
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $user->avatar = 'avatars/' . $fileName;
            $changes['avatar'] = $user->avatar;
        }

        // Chỉ cập nhật nếu có sự thay đổi
        if (!empty($changes)) {
            $user->update($changes);
        }

        // Lưu lại thông tin ở session
        session('user')['name'] = $user->last_name;

        return response()->json([
            'message' => 'Cập nhật thông tin thành công!',
            'avatar' => asset($user->avatar),
            'data' => $user
        ], 200);
    }


    public function updatePassword(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:1|max:32',
        ]);

        $user = auth()->user();

        // Kiểm tra mật khẩu cũ có đúng không
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Mật khẩu cũ không chính xác.'], 400);
        }

        // Kiểm tra mật khẩu mới có trùng mật khẩu cũ không
        if (Hash::check($request->new_password, $user->password)) {
            return response()->json(['message' => 'Mật khẩu mới không được trùng mật khẩu cũ.'], 400);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Cập nhật mật khẩu thành công.']);
    }
}

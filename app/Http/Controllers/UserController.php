<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request)
    {
        // Tìm người dùng theo ID
        $user = User::find($request->userId);

        // Kiểm tra nếu không tìm thấy user
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Người dùng không tồn tại'], 404);
        }

        // Cập nhật thông tin
        $user->role = $request->role;
        $user->is_active = filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN); // Chuyển đổi sang boolean
        $user->save();

        // Trả về phản hồi thành công
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thông tin người dùng thành công',
            'user' => $user
        ]);
    }

    public function show(Request $request)
    {
        // Tìm người dùng theo mã ID
        $user = User::findOrFail($request->userId);
        return response()->json($user);
    }
}

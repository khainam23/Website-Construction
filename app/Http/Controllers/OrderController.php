<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $orders = Order::query()
            ->when($search, function ($query, $search) {
                return $query->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
            })
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request)
    {
        $order = Order::find($request->order_id);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Đơn hàng không tồn tại']);
        }

        $currentStatus = $order->status;
        $newStatus = $request->status;

        // Danh sách ràng buộc
        $invalidTransitions = [
            'cancel' => ['return'],
            'delivery' => ['cancel'],
            'ship' => ['return'],
            'confirm' => ['delivery', 'return']
        ];

        // Kiểm tra nếu trạng thái mới bị chặn
        if (isset($invalidTransitions[$currentStatus]) && in_array($newStatus, $invalidTransitions[$currentStatus])) {
            return response()->json(['success' => false, 'message' => "Không thể chuyển từ '$currentStatus' sang '$newStatus'."]);
        }

        $order->status = $newStatus;
        $order->save();

        return response()->json(['success' => true]);
    }

    public function cancel(Request $request)
    {
        $order = Order::find($request->orderId);
        $order->status = 'cancel';
        $order->save();
        return response()->json(['success' => true]);
    }
}

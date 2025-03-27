<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Get all orders without filtering for client-side filtering
        $orders = Order::with(['user', 'details.product'])
            ->select('orders.*', DB::raw('SUM(order_details.cost * order_details.quantity) as calculated_total'))
            ->leftJoin('order_details', 'orders.id', '=', 'order_details.order_id')
            ->groupBy('orders.id')
            ->paginate(10);

        // Get all available statuses for filter dropdown
        $statuses = ['pending', 'confirm', 'ship', 'delivery', 'return', 'cancel'];

        return view('admin.orders.index', compact('orders', 'statuses'));
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

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        try {
            // Begin transaction for data integrity
            DB::beginTransaction();
            
            // Find the order
            $order = Order::findOrFail($request->orderId);
            
            // Only allow cancellation if status is 'confirm'
            if ($order->status !== 'confirm') {
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ những đơn hàng có trạng thái "Đã xác nhận" mới có thể hủy.'
                ], 400);
            }
            
            // Get order details
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            
            // Restore inventory for each product in the order
            foreach ($orderDetails as $detail) {
                // Determine product type (rental or sale)
                $type = !empty($detail->rental_end_date) ? 'rental' : 'sale';
                
                // Find the inventory record
                $inventory = ProductInventory::where('product_id', $detail->product_id)
                                           ->where('type', $type)
                                           ->first();
                
                if ($inventory) {
                    // Return the quantity back to inventory
                    $inventory->quantity += $detail->quantity;
                    $inventory->save();
                    
                    Log::info("Restored {$detail->quantity} items of product ID {$detail->product_id} (type: {$type}) to inventory.");
                } else {
                    Log::warning("Could not find inventory record for product ID {$detail->product_id} (type: {$type})");
                }
            }
            
            // Update order status to 'cancel'
            $order->status = 'cancel';
            $order->save();
            
            // Commit the transaction
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được hủy và số lượng sản phẩm đã được trả lại kho.'
            ]);
            
        } catch (\Exception $e) {
            // Roll back the transaction in case of error
            DB::rollBack();
            
            Log::error('Error canceling order: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại sau.'
            ], 500);
        }
    }
}

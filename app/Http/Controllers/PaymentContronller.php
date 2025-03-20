<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Crat;

class PaymentContronller extends Controller
{
    public function all(Request $request)
    {
        // Nhận toàn bộ dữ liệu JSON
        $data = $request->json()->all();

        // Lấy danh sách items
        $items = $data['items'] ?? [];

        // Lấy phương thức thanh toán
        $method = $data['method'] ?? '';

        // Lấy thông tin đơn hàng
        $paymentInfo = $data['paymentInfo'] ?? [];

        if ($method == 'vnpay') {

        } else {
            return $this->payment($items, $paymentInfo);
        }
    }

    public function payment($items, $paymentInfo)
    {
        $userId = auth()->id();

        // Tạo đơn hàng
        $order = Order::create([
            'type' => 'normal',
            'user_id' => $userId,
            'address' => $paymentInfo['address'] ?? 'Chưa cung cấp',
            'phone' => $paymentInfo['phone'] ?? 'Chưa cung cấp',
            'status' => 'pending',
            'total' => 0,
        ]);

        $totalAmount = 0; // Tổng tiền đơn hàng

        // Xử lý từng sản phẩm trong giỏ hàng
        collect($items)->each(function ($item) use ($order, &$totalAmount, $userId) {
            $cart = null;

            if (empty($item['end'])) {
                // Nếu không có điều chỉnh, lấy thông tin từ giỏ hàng
                $cart = Cart::where([
                    'id' => $item['id'],
                    'user_id' => $userId,
                    'product_id' => $item['product_id'] ?? $item['productId'],
                ])->first();

                if (!$cart)
                    return; // Bỏ qua nếu giỏ hàng không tồn tại

                // Cập nhật lại thông tin từ giỏ hàng
                $item = array_merge($item, [
                    'quantity' => optional($cart)->quantity ?? 0,
                    'cost' => optional($cart)->cost ?? 0,
                    'start' => optional($cart)->rental_start_date,
                    'end' => optional($cart)->rental_end_date,
                ]);
            }

            // Tạo OrderDetail
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'] ?? $item['productId'] ?? $cart->product_id,
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
                'rental_start_date' => $item['start'] ?? null,
                'rental_end_date' => $item['end'] ?? null,
            ]);

            // Xóa sản phẩm khỏi giỏ hàng nếu có
            $cart?->delete();

            // Cộng dồn tổng tiền đơn hàng (chuyển `null` thành `0` nếu có)
            $totalAmount += (float) ($item['cost'] ?? 0);
        });

        // Cập nhật tổng tiền vào Order
        $order->update([
            'total' => $totalAmount, 
            'status' => 'confirm'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được tạo thành công!',
            'order_id' => $order->id,
        ]);
    }
}

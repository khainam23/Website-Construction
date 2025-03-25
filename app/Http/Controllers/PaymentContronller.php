<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Crat;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\Mail;

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
            return $this->vnpay($items, $paymentInfo);
        } else {
            return $this->payment($items, $paymentInfo);
        }
    }

    public function vnpay($items, $paymentInfo)
    {
        session()->put('vnpay-items', $items);
        session()->put('vnpay-info', $paymentInfo);
        $vnp_TmnCode = env('VNP_TMN_CODE'); // Lấy từ .env
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Lấy từ .env
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURN_URL');
        $vnp_TxnRef = time();
        $vnp_OrderInfo = ''; // Thông tin đơn hàng
        $totalAmount = 0; // Tổng tiền đơn hàng
        foreach ($items as $item) {
            $totalAmount += (float) ($item['cost'] ?? 0);
            $vnp_OrderInfo .= '-Mã:' . ($item['product_id'] ?? $item['productId']);
        }
        $vnp_OrderType = "billpayment";
        $vnp_Locale = "vn";
        $vnp_Amount = $totalAmount * 100; // Bởi vnpay sẽ bỏ đi 2 số 0 ở cuối 
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";

        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return response()->json([
            'vnpay_url' => $vnp_Url,
            'success' => true,
        ]);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_ResponseCode = $request->query('vnp_ResponseCode');
        $vnp_TransactionStatus = $request->query('vnp_TransactionStatus');

        // Kiểm tra giao dịch thành công
        if ($vnp_ResponseCode == "00" && $vnp_TransactionStatus == "00") {
            // Xử lý khi thanh toán thành công
            $items = session()->remove('vnpay-items');
            $paymentInfo = session()->remove('vnpay-info');

            session()->put('type-payment', 'vnpay');
            $this->payment($items, $paymentInfo);
            return redirect(url(route('web.profile')) . '#orders');
        } else {
            // Xử lý khi thanh toán thất bại
            return redirect(url(route('web.profile')) . '#cart');
        }
    }

    public function payment($items, $paymentInfo)
    {
        $userId = session('user')['id'];

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

            // Update inventory
            $productId = $item['product_id'] ?? $item['productId'] ?? $cart->product_id;
            $type = empty($item['end']) ? 'sale' : 'rental';
            $inventory = ProductInventory::where([
                'product_id' => $productId,
                'type' => $type
            ])->first();

            if ($inventory) {
                $newQuantity = $inventory->quantity - $item['quantity'];
                $inventory->update(['quantity' => $newQuantity]);

                // Check if inventory is low (less than 3)
                if ($newQuantity < 3) {
                    $this->sendLowInventoryAlert($productId, $type, $newQuantity);
                }
            }

            // Xóa sản phẩm khỏi giỏ hàng nếu có
            $cart?->delete();

            // Cộng dồn tổng tiền đơn hàng (chuyển `null` thành `0` nếu có)
            $totalAmount += (float) ($item['cost'] ?? 0);
        });

        $type = session()->remove('type-vnpay') ?? 'confirm';

        // Cập nhật tổng tiền vào Order
        $order->update([
            'total' => $totalAmount,
            'status' => $type
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được tạo thành công!',
            'order_id' => $order->id,
        ]);
    }

    private function sendLowInventoryAlert($productId, $type, $quantity)
    {
        $adminEmail = 'khainam23@gmail.com';

        Mail::send('frontend.low-inventory', [
            'product_id' => $productId,
            'type' => $type,
            'quantity' => $quantity
        ], function ($message) use ($adminEmail) {
            $message->to($adminEmail)
                ->subject('Cảnh báo: Hàng tồn kho thấp');
        });
    }
}

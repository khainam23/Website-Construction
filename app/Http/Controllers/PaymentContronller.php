<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductInventory;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use App\Models\Product; // Added for product name lookup
use Illuminate\Support\Facades\Log; // Added for logging
use App\Models\User; // Added for user email lookup

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

        // Validate quantities against inventory before processing
        $invalidItems = [];
        foreach ($items as $item) {
            $itemId = $item['id'] ?? null;
            $productId = $item['product_id'] ?? $item['productId'] ?? null;
            $quantity = (int)($item['quantity'] ?? 0);
            
            if ($productId && $quantity > 0) {
                $type = empty($item['end']) ? 'sale' : 'rental';
                $inventory = ProductInventory::where([
                    'product_id' => $productId,
                    'type' => $type
                ])->first();
                
                if ($inventory && $quantity > $inventory->quantity) {
                    $product = Product::find($productId);
                    $invalidItems[] = [
                        'name' => $product ? $product->name : "Product #$productId",
                        'requested' => $quantity,
                        'available' => $inventory->quantity
                    ];
                }
            }
        }
        
        // Return error if any item exceeds inventory
        if (count($invalidItems) > 0) {
            $errorMessage = "The following products have insufficient inventory:\n";
            foreach ($invalidItems as $item) {
                $errorMessage .= "- {$item['name']}: Requested: {$item['requested']}, Available: {$item['available']}\n";
            }
            
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 400);
        }

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
        $processedCartIds = []; // Track cart IDs to delete later
        $orderItems = []; // Store order details for invoice email

        // Xử lý từng sản phẩm trong giỏ hàng
        collect($items)->each(function ($item) use ($order, &$totalAmount, $userId, &$processedCartIds, &$orderItems) {
            $cart = null;
            $itemId = $item['id'] ?? null;
            $productId = $item['product_id'] ?? $item['productId'] ?? null;
            
            // Find cart item regardless of whether there's end date or not
            $cart = Cart::where([
                'id' => $itemId,
                'user_id' => $userId,
            ])->first();

            // If we found a valid cart, add its ID to processed list
            if ($cart) {
                $processedCartIds[] = $cart->id;
                
                // If product ID wasn't set in the item, get it from cart
                if (!$productId) {
                    $productId = $cart->product_id;
                }
                
                // Use cart values if not provided in the item
                if (!isset($item['quantity'])) $item['quantity'] = $cart->quantity;
                if (!isset($item['cost'])) $item['cost'] = $cart->cost;
                if (!isset($item['start'])) $item['start'] = $cart->rental_start_date;
                if (!isset($item['end'])) $item['end'] = $cart->rental_end_date;
            }

            // Get product details for the invoice
            $product = Product::find($productId);

            // Store order item details for the invoice email
            $orderItems[] = [
                'product' => $product,
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
                'rental_start_date' => $item['start'] ?? null,
                'rental_end_date' => $item['end'] ?? null,
                'is_rental' => !empty($item['end']),
            ];

            // Tạo OrderDetail
            OrderDetail::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
                'rental_start_date' => $item['start'] ?? null,
                'rental_end_date' => $item['end'] ?? null,
            ]);

            // Update inventory
            $type = empty($item['end']) ? 'sale' : 'rental';
            // Lấy số lượng tồn kho trong database 
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

            // Cộng dồn tổng tiền đơn hàng (chuyển `null` thành `0` nếu có)
            $totalAmount += (float) ($item['cost'] ?? 0);
        });
        
        // Delete all cart items processed in this order
        if (!empty($processedCartIds)) {
            Cart::whereIn('id', $processedCartIds)->delete();
            Log::info('Deleted cart items after payment: ' . implode(', ', $processedCartIds));
        }

        $type = session()->remove('type-vnpay') ?? 'confirm';

        // Cập nhật tổng tiền vào Order
        $order->update([
            'total' => $totalAmount,
            'status' => $type
        ]);

        // Send invoice email to user
        $this->sendInvoiceEmail($userId, $order, $orderItems, $paymentInfo);

        return response()->json([
            'success' => true,
            'message' => 'Đơn hàng đã được tạo thành công!',
            'order_id' => $order->id,
        ]);
    }

    private function sendLowInventoryAlert($productId, $type, $quantity)
    {
        try {
            $adminEmail = env('MAIL_USERNAME');
            $product = Product::find($productId);
            $productName = $product ? $product->name : "Product ID: $productId";
            
            $typeText = $type == 'sale' ? 'Bán' : 'Cho thuê';
            
            Log::info("Sending low inventory alert for product: $productId ($productName), type: $type, quantity: $quantity");
            
            Mail::send('frontend.low-inventory', [
                'product_id' => $productId,
                'product_name' => $productName,
                'type' => $type,
                'type_text' => $typeText,
                'quantity' => $quantity
            ], function ($message) use ($adminEmail, $productName) {
                $message->to($adminEmail)
                    ->subject("Cảnh báo: Hàng tồn kho thấp - $productName");
            });
            
            Log::info("Low inventory email sent successfully");
        } catch (\Exception $e) {
            Log::error("Failed to send low inventory email: " . $e->getMessage());
        }
    }

    /**
     * Send invoice email to user
     * 
     * @param int $userId User ID
     * @param Order $order Order object
     * @param array $orderItems Order items with product details
     * @param array $paymentInfo Payment information
     * @return void
     */
    private function sendInvoiceEmail($userId, $order, $orderItems, $paymentInfo)
    {
        try {
            $user = User::find($userId);
            
            if (!$user || !$user->email) {
                Log::warning("Cannot send invoice email: user not found or no email address. User ID: $userId");
                return;
            }

            $paymentMethod = session()->has('type-payment') ? session('type-payment') : 'direct';

            Log::info("Sending invoice email to user: {$user->email} for order: {$order->id}");
            
            Mail::send('frontend.emails.invoice', [
                'user' => $user,
                'order' => $order,
                'orderItems' => $orderItems,
                'paymentInfo' => $paymentInfo,
                'paymentMethod' => $paymentMethod,
                'date' => now()->format('d/m/Y H:i:s')
            ], function ($message) use ($user, $order) {
                $message->to($user->email)
                    ->subject("Hóa đơn mua hàng #{$order->id} - BMQ");
            });
            
            Log::info("Invoice email sent successfully to: {$user->email}");
        } catch (\Exception $e) {
            Log::error("Failed to send invoice email: " . $e->getMessage());
        }
    }
}
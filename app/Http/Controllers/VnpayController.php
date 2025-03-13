<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\DB;
use App\Models\Order;

class VnpayController extends Controller
{
    public function createPayment(Request $request)
    {
        $vnp_TmnCode = env('VNP_TMN_CODE'); // Lấy từ .env
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Lấy từ .env
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = env('VNP_RETURN_URL');

        $vnp_TxnRef = time();
        $vnp_OrderInfo = 'USD' . '_' . $request->type . '_' . $request->order_id . '_' . $request->device_id . '_' . $request->quantity;
        if ($request->type !== 'sales') {
            $vnp_OrderInfo .= '_' . $request->rental_date . '_' . $request->return_date;
        }
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $request->total_price;
        $vnp_Locale = "vn";
        $vnp_BankCode = $request->bank_code ?? "";
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

        return response()->json(['payment_url' => $vnp_Url]);
    }

    public function vnpayReturn(Request $request)
    {
        $text = explode("_", $request->vnp_OrderInfo);

        // Tạo một Request mới để truyền vào store()
        $storeRequest = [
            'order_id' => $text[2] ?? null,
            'device_id' => $text[3] ?? null,
            'quantity' => $text[4] ?? null,
            'total_price' => $request->vnp_Amount,
        ];
        if ($text[1] == 'sales') {
            SaleController::store(new Request($storeRequest));
        } else {
            $storeRequest['rental_date'] = $text[5];
            $storeRequest['return_date'] = $text[6];
            $storeRequest['rental_fee'] = $request->vnp_Amount;
            RentalController::store(new Request($storeRequest));
        }

        return redirect()->route('index');
        // return response()->json([$request]); // For test
    }
}

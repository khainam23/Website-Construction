<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $user = auth()->user();

        // Chuyển đổi giá tiền từ string thành số
        $totalPrice = floatval(str_replace(',', '', $request->total_price));

        $data = [
            'user_id' => $user->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'cost' => $totalPrice,
        ];

        if ($request->type == 'rental') {
            $data['rental_start_date'] = $request->rental_start;
            $data['rental_end_date'] = $request->rental_end;
        }

        Cart::create($data);

        return response()->json(['message' => 'Sản phẩm đã được thêm vào đơn hàng!']);
    }
}

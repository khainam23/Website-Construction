<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

    /**
     * Delete cart items
     */
    public function delete(Request $request)
    {
        try {
            $itemIds = $request->ids;
            $userId = session('user')['id'];
            
            if (!is_array($itemIds)) {
                $itemIds = [$itemIds];
            }
            
            // Only delete items that belong to the current user
            $deleted = Cart::where('user_id', $userId)
                ->whereIn('id', $itemIds)
                ->delete();
            
            return response()->json([
                'success' => true,
                'message' => $deleted > 0 
                    ? ($deleted == 1 
                        ? 'Đã xóa 1 sản phẩm khỏi giỏ hàng' 
                        : "Đã xóa {$deleted} sản phẩm khỏi giỏ hàng")
                    : 'Không tìm thấy sản phẩm để xóa',
                'deleted_count' => $deleted
            ]);
        } catch (\Exception $e) {
            
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xóa sản phẩm: ' . $e->getMessage()
            ], 500);
        }
    }
}

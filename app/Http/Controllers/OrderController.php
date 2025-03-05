<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @OA\Tag(
 *     name="Orders",
 *     description="API Endpoints for managing orders"
 * )
 */
class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get all orders",
     *     tags={"Orders"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all orders",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Order")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Order::with('user')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Create a new order with items",
     *     tags={"Orders"},
     *     security={{ "bearerAuth":{} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "items"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="type", type="string", example="online"),
     *             @OA\Property(
     *                 property="items",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"device_id", "quantity", "unit_price"},
     *                     @OA\Property(property="device_id", type="integer", example=101),
     *                     @OA\Property(property="quantity", type="integer", example=2),
     *                     @OA\Property(property="unit_price", type="number", format="float", example=150.5)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Order created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - User not logged in",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Bạn cần đăng nhập trước!"),
     *             @OA\Property(property="redirect", type="string", example="http://yourdomain.com/login")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal Server Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Error creating order: Database error")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        session()->start();
        if (session()->has('user')) {
            try {
                DB::beginTransaction();

                $total_price = 0;
                foreach ($request->items as $item) {
                    $total_price += $item['quantity'] * $item['unit_price'];
                }

                $order = Order::create([
                    'user_id' => $request->user_id,
                    'type' => $request->type,
                    'total_price' => $total_price,
                    'status' => 'pending'
                ]);

                foreach ($request->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'device_id' => $item['device_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'subtotal' => $item['quantity'] * $item['unit_price']
                    ]);
                }

                DB::commit();
                return response()->json($order->load('items'), 201);

            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => 'Error creating order: ' . $e->getMessage()], 500);
            }
        } else {
            return response()->json([
                'error' => 'Bạn cần đăng nhập trước!',
                'redirect' => url('/login')
            ], 401);
            ;
        }

    }

    /**
     * @OA\Get(
     *     path="/api/orders/{id}",
     *     summary="Get order by ID",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order details",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Order::with(['user', 'items.device'])->findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/orders/{id}",
     *     summary="Update order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());
        return response()->json($order);
    }

    /**
     * @OA\Delete(
     *     path="/api/orders/{id}",
     *     summary="Delete order",
     *     tags={"Orders"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Order deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Order::destroy($id);
        return response()->json(['message' => 'Đơn hàng đã bị xóa']);
    }
}

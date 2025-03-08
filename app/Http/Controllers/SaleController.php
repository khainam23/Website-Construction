<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Device;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Sales",
 *     description="API Endpoints for managing sales"
 * )
 */
class SaleController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/sales",
     *     summary="Get list of all sales",
     *     tags={"Sales"},
     *     @OA\Response(
     *         response=200,
     *         description="List of sales",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Sale")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $user_id = session('user')['id'];

        $sale = Sale::where('user_id', $user_id)->get();

        $productIds = $sale->pluck('device_id');

        // Lấy danh sách sản phẩm từ danh sách product_id
        $products = Device::whereIn('id', $productIds)->get();

        return response()->json([
            'products' => $products,
            'sales' => $sale
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/sales",
     *     summary="Create a new sale",
     *     tags={"Sales"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","user_id","quantity","total_price"},
     *             @OA\Property(property="device_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="quantity", type="integer", minimum=1),
     *             @OA\Property(property="total_price", type="number", format="float", minimum=0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sale created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Sale")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'device_id' => 'required|exists:devices,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0'
        ]);

        // Lấy user_id từ session
        $user = session('user');
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated['user_id'] = $user['id']; // Gán user_id vào dữ liệu đã validate

        $sale = Sale::create($validated);
        
        // Xóa đơn hàng
        Order::destroy($validated['order_id']);

        // Cập nhật số lượng đơn hàng
        Device::updateStock($validated['device_id'], $validated['quantity']);
        
        return response()->json('Thanh toán thành công', 201);
    }


    /**
     * @OA\Get(
     *     path="/api/sales/{id}",
     *     summary="Get sale details",
     *     tags={"Sales"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Sale ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale details",
     *         @OA\JsonContent(ref="#/components/schemas/Sale")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Sale not found"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Sale::with(['user', 'device'])->findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/sales/{id}",
     *     summary="Update sale details",
     *     tags={"Sales"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="device_id", type="integer"),
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="quantity", type="integer", minimum=1),
     *             @OA\Property(property="total_price", type="number", format="float", minimum=0)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Sale")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'device_id' => 'exists:devices,id',
            'user_id' => 'exists:users,id',
            'quantity' => 'integer|min:1',
            'total_price' => 'numeric|min:0'
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update($validated);
        return response()->json($sale);
    }

    /**
     * @OA\Delete(
     *     path="/api/sales/{id}",
     *     summary="Delete a sale",
     *     tags={"Sales"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sale deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Sale::destroy($id);
        return response()->json(['message' => 'Giao dịch bán đã bị xóa']);
    }
}

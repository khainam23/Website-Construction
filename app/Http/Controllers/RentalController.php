<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Device;

/**
 * @OA\Tag(
 *     name="Rentals",
 *     description="API Endpoints for managing device rentals"
 * )
 */
class RentalController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rentals",
     *     summary="Get list of all rentals",
     *     tags={"Rentals"},
     *     @OA\Response(
     *         response=200,
     *         description="List of rentals",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Rental")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Rental::with(['user', 'device'])->get());
    }

    /**
     * @OA\Post(
     *     path="/api/rentals",
     *     summary="Create a new rental",
     *     tags={"Rentals"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id","device_id","rental_date","return_date","rental_fee"},
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="device_id", type="integer"),
     *             @OA\Property(property="rental_date", type="string", format="date"),
     *             @OA\Property(property="return_date", type="string", format="date"),
     *             @OA\Property(property="rental_fee", type="number", format="float")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Rental created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_id' => 'required|exists:devices,id',
            'rental_date' => 'required|date',
            'return_date' => 'required|date|after:rental_date',
            'rental_fee' => 'required|numeric|min:0',
            'quantity'=> 'required|numeric|min:1',
        ]);

        // Lấy user_id từ session
        $user = session('user');
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated['user_id'] = $user['id']; // Gán user_id vào dữ liệu đã validate

        $rental = Rental::create($validated);
        
        // Xóa đơn hàng
        Order::destroy($validated['order_id']);

        // Cập nhật số lượng đơn hàng
        Device::updateStock($validated['device_id'], $validated['quantity']);
        
        return response()->json('Thanh toán thành công', 201);
    }

    /**
     * @OA\Get(
     *     path="/api/rentals/{id}",
     *     summary="Get rental details",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rental details",
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Rental::with(['user', 'device'])->findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/rentals/{id}",
     *     summary="Update rental details",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rental updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'device_id' => 'sometimes|exists:devices,id',
            'rental_date' => 'sometimes|date',
            'return_date' => 'sometimes|date|after:rental_date',
            'rental_fee' => 'sometimes|numeric|min:0'
        ]);

        $rental = Rental::findOrFail($id);
        $rental->update($validated);
        return response()->json($rental);
    }

    /**
     * @OA\Delete(
     *     path="/api/rentals/{id}",
     *     summary="Delete a rental",
     *     tags={"Rentals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rental deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Rental::destroy($id);
        return response()->json(['message' => 'Giao dịch thuê đã bị xóa']);
    }
}

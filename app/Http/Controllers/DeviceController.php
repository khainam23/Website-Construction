<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Devices",
 *     description="API Endpoints for managing devices"
 * )
 */
class DeviceController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/devices",
     *     summary="Get all devices",
     *     tags={"Devices"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all devices",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Device name"),
     *                 @OA\Property(property="category", type="string", example="Category"),
     *                 @OA\Property(property="description", type="string", example="Device description"),
     *                 @OA\Property(property="price", type="number", format="float", example=999.99),
     *                 @OA\Property(property="stock", type="integer", example=10)
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Device::all());
    }

    /**
     * @OA\Post(
     *     path="/api/devices",
     *     summary="Create a new device",
     *     tags={"Devices"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","category","price","stock"},
     *             @OA\Property(property="name", type="string", example="New Device"),
     *             @OA\Property(property="category", type="string", example="Electronics"),
     *             @OA\Property(property="description", type="string", example="Device description"),
     *             @OA\Property(property="price", type="number", format="float", example=999.99),
     *             @OA\Property(property="stock", type="integer", example=10)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Device created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             ref="#/components/schemas/Device"
     *         )
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
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $device = Device::create($validated);
        return response()->json($device, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/devices/{id}",
     *     summary="Get a specific device",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of device",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device details",
     *         @OA\JsonContent(ref="#/components/schemas/Device")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Device::findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/devices/{id}",
     *     summary="Update an existing device",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of device",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","category","price","stock"},
     *             @OA\Property(property="name", type="string", example="Updated Device"),
     *             @OA\Property(property="category", type="string", example="Electronics"),
     *             @OA\Property(property="description", type="string", example="Updated description"),
     *             @OA\Property(property="price", type="number", format="float", example=1099.99),
     *             @OA\Property(property="stock", type="integer", example=15)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Device")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     )
     * )
     */
    public function update(Request $request, Device $device)
    {
        $this-> authorize('update', $device);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);
        
        $device->update($validated);
        return response()->json($device);
    }

    /**
     * @OA\Delete(
     *     path="/api/devices/{id}",
     *     summary="Delete a device",
     *     tags={"Devices"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of device",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Device deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Thiết bị đã bị xóa")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Device not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        Device::destroy($id);
        return response()->json(['message' => 'Thiết bị đã bị xóa']);
    }
}

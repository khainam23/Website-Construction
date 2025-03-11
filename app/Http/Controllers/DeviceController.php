<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Tag(
 *     name="Devices",
 *     description="API Endpoints for managing devices"
 * )
 */
class DeviceController extends Controller
{
    public function __construct()
    {
        // Tạm thời bỏ middleware check
    }

    /**
     * @OA\Get(
     *     path="/api/devices",
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
        return response()->json(Device::with('category')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/devices",
     *     summary="Create a new device",
     *     tags={"Devices"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","category_id","price","stock"},
     *                 @OA\Property(property="name", type="string", example="New Device"),
     *                 @OA\Property(property="category_id", type="integer", example=1),
     *                 @OA\Property(property="description", type="string", example="Device description"),
     *                 @OA\Property(property="price", type="number", format="float", example=999.99),
     *                 @OA\Property(property="stock", type="integer", example=10),
     *                 @OA\Property(property="image", type="string", format="binary", description="Device image file")
     *             )
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
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Thêm validation cho image
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            // Store with relative path
            $path = $image->store('devices', 'public');
            $validated['image'] = $path;
        }

        $device = Device::create($validated);
        
        // Add image URL using relative path
        if ($device->image) {
            $device->image_url = Storage::url($device->image);
        }
        
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
        return response()->json(Device::with('category')->findOrFail($id));
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
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name","category","price","stock"},
     *                 @OA\Property(property="name", type="string", example="Updated Device"),
     *                 @OA\Property(property="category", type="string", example="Electronics"),
     *                 @OA\Property(property="description", type="string", example="Updated description"),
     *                 @OA\Property(property="price", type="number", format="float", example=1099.99),
     *                 @OA\Property(property="stock", type="integer", example=15),
     *                 @OA\Property(property="image", type="string", format="binary", description="Device image file")
     *             )
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
        $this->authorize('update', $device);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Thêm validation cho image
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu có
            if ($device->image) {
                Storage::disk('public')->delete($device->image);
            }

            // Store with relative path
            $path = $request->file('image')->store('devices', 'public');
            $validated['image'] = $path;
        }

        $device->update($validated);
        
        // Add image URL using relative path
        if ($device->image) {
            $device->image_url = Storage::url($device->image);
        }
        
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
        $device = Device::findOrFail($id);

        // Xóa ảnh khi xóa thiết bị
        if ($device->image) {
            Storage::disk('public')->delete($device->image);
        }

        $device->delete();
        return response()->json(['message' => 'Thiết bị đã bị xóa']);
    }

    public function count() {
        return response()->json(['totalDevices' => 'hello']);
    }

    public function viewManagerProduct() {
        $categories = Category::all();

        return view('manager-product', [
            'categories'=> $categories
        ]);
    }

}

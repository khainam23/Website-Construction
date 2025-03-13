<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Inventory",
 *     description="API Endpoints for managing inventory"
 * )
 */
class InventoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/inventory",
     *     summary="Get all inventory items",
     *     tags={"Inventory"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all inventory items",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Inventory")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Inventory::with('device')->get());
    }

    /**
     * @OA\Post(
     *     path="/api/inventory",
     *     summary="Create new inventory record",
     *     tags={"Inventory"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"device_id","quantity","status"},
     *             @OA\Property(property="device_id", type="integer"),
     *             @OA\Property(property="quantity", type="integer", minimum=0),
     *             @OA\Property(property="status", type="string", enum={"in_stock","out_of_stock","low_stock"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Inventory record created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Inventory")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'quantity' => 'required|integer|min:0',
            'status' => 'required|in:in_stock,out_of_stock,low_stock'
        ]);

        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/inventory/{id}",
     *     summary="Get inventory record details",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventory record details",
     *         @OA\JsonContent(ref="#/components/schemas/Inventory")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Inventory::with('device')->findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/inventory/{id}",
     *     summary="Update inventory record",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="device_id", type="integer"),
     *             @OA\Property(property="quantity", type="integer", minimum=0),
     *             @OA\Property(property="status", type="string", enum={"in_stock","out_of_stock","low_stock"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventory record updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Inventory")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'device_id' => 'exists:devices,id',
            'quantity' => 'integer|min:0',
            'status' => 'in:in_stock,out_of_stock,low_stock'
        ]);

        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());
        return response()->json($inventory);
    }

    /**
     * @OA\Delete(
     *     path="/api/inventory/{id}",
     *     summary="Delete inventory record",
     *     tags={"Inventory"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Inventory record deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Inventory::destroy($id);
        return response()->json(['message' => 'Inventory record deleted']);
    }
}

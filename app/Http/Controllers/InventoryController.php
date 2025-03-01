<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json(Inventory::with('devices')->get());
    }

    public function store(Request $request)
    {
        $inventory = Inventory::create($request->all());
        return response()->json($inventory, 201);
    }

    public function show($id)
    {
        return response()->json(Inventory::with('devices')->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->update($request->all());
        return response()->json($inventory);
    }

    public function destroy($id)
    {
        Inventory::destroy($id);
        return response()->json(['message' => 'Kho đã bị xóa']);
    }
}

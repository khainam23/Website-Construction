<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        return response()->json(Sale::with(['user', 'device'])->get());
    }

    public function store(Request $request)
    {
        $sale = Sale::create($request->all());
        return response()->json($sale, 201);
    }

    public function show($id)
    {
        return response()->json(Sale::with(['user', 'device'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        return response()->json($sale);
    }

    public function destroy($id)
    {
        Sale::destroy($id);
        return response()->json(['message' => 'Giao dịch bán đã bị xóa']);
    }
}

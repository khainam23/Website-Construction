<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
    {
        return response()->json(Rental::with(['user', 'device'])->get());
    }

    public function store(Request $request)
    {
        $rental = Rental::create($request->all());
        return response()->json($rental, 201);
    }

    public function show($id)
    {
        return response()->json(Rental::with(['user', 'device'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->update($request->all());
        return response()->json($rental);
    }

    public function destroy($id)
    {
        Rental::destroy($id);
        return response()->json(['message' => 'Giao dịch thuê đã bị xóa']);
    }
}

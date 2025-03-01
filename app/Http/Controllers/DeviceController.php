<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        return response()->json(Device::all());
    }

    public function store(Request $request)
    {
        $device = Device::create($request->all());
        return response()->json($device, 201);
    }

    public function show($id)
    {
        return response()->json(Device::findOrFail($id));
    }

    public function update(Request $request, Device $device)
    {
        $this->authorize('update', $device);
    
        $device->update($request->all());
        return redirect()->route('devices.index')->with('success', 'Thiết bị đã được cập nhật.');
    }
    

    public function destroy($id)
    {
        Device::destroy($id);
        return response()->json(['message' => 'Thiết bị đã bị xóa']);
    }
}

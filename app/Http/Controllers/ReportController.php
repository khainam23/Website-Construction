<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return response()->json(Report::all());
    }

    public function store(Request $request)
    {
        $report = Report::create($request->all());
        return response()->json($report, 201);
    }

    public function show($id)
    {
        return response()->json(Report::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->all());
        return response()->json($report);
    }

    public function destroy($id)
    {
        Report::destroy($id);
        return response()->json(['message' => 'Báo cáo đã bị xóa']);
    }
}

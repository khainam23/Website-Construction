<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Reports",
 *     description="API Endpoints for managing reports"
 * )
 */
class ReportController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reports",
     *     summary="Get all reports",
     *     tags={"Reports"},
     *     @OA\Response(
     *         response=200,
     *         description="List of all reports",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Report")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Report::all());
    }

    /**
     * @OA\Post(
     *     path="/api/reports",
     *     summary="Create a new report",
     *     tags={"Reports"},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Report")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Report created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Report")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $report = Report::create($request->all());
        return response()->json($report, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/reports/{id}",
     *     summary="Get report by ID",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report details",
     *         @OA\JsonContent(ref="#/components/schemas/Report")
     *     )
     * )
     */
    public function show($id)
    {
        return response()->json(Report::findOrFail($id));
    }

    /**
     * @OA\Put(
     *     path="/api/reports/{id}",
     *     summary="Update report",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/Report")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Report")
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $report = Report::findOrFail($id);
        $report->update($request->all());
        return response()->json($report);
    }

    /**
     * @OA\Delete(
     *     path="/api/reports/{id}",
     *     summary="Delete report",
     *     tags={"Reports"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Report deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        Report::destroy($id);
        return response()->json(['message' => 'Báo cáo đã bị xóa']);
    }
}

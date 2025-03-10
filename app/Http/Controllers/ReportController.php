<?php

namespace App\Http\Controllers;

use App\Models\Category;
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

    public function viewStatistics()
    {
        $latestReport = Report::latest('date')->first();
        $categories = Category::all();

        // Check if user has sales role
        if (auth()->check() && auth()->user()->role === 'sales') {
            return view('sales-statistics', [
                'latestReport' => $latestReport ?? new \stdClass()
            ]);
        }
        
        // Default admin view with all statistics
        return view('statistics', [
            'latestReport' => $latestReport ?? new \stdClass(),
            'categories' => $categories
        ]);
    }    

    public function getMonthlyRevenue()
    {
        try {
            // Get year for filtering (default to current year)
            $year = request('year', date('Y'));
            
            // Get monthly data from reports table
            $reports = Report::selectRaw('
                date,
                MONTH(date) as month,
                CAST(sales_revenue/1000000000.0 as DECIMAL(10,1)) as sales_revenue,
                CAST(rental_revenue/1000000000.0 as DECIMAL(10,1)) as rental_revenue,
                CAST((sales_revenue + rental_revenue)/1000000000.0 as DECIMAL(10,1)) as total_revenue
            ')
            ->whereYear('date', $year)
            ->orderBy('month')
            ->get();
            
            // Log for debugging
            \Log::info('Monthly Revenue Data retrieved:', ['count' => $reports->count(), 'year' => $year]);
            
            // Format data for all months
            $formattedData = collect(range(1, 12))->map(function($month) use ($reports) {
                $report = $reports->firstWhere('month', $month);
                
                // If data exists for this month, return it, otherwise return zeros
                return [
                    'month' => $month,
                    'sales_revenue' => $report ? (float)$report->sales_revenue : 0,
                    'rental_revenue' => $report ? (float)$report->rental_revenue : 0,
                    'total_revenue' => $report ? (float)$report->total_revenue : 0
                ];
            });
            
            return response()->json($formattedData);
        } catch (\Exception $e) {
            \Log::error('Error in getMonthlyRevenue: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve monthly revenue data'], 500);
        }
    }
    
    // Add method to get quarterly reports
    public function getQuarterlyRevenue()
    {
        try {
            $year = request('year', date('Y'));
            
            // Use the quarterly_reports view
            $quarterlyData = \DB::table('quarterly_reports')
                ->where('year', $year)
                ->get()
                ->map(function($quarter) {
                    return [
                        'quarter' => $quarter->quarter,
                        'total_sales' => round($quarter->total_sales / 1000000000, 1),
                        'total_rentals' => round($quarter->total_rentals / 1000000000, 1),
                        'total_revenue' => round($quarter->total_revenue / 1000000000, 1)
                    ];
                });
                
            return response()->json($quarterlyData);
        } catch (\Exception $e) {
            \Log::error('Error in getQuarterlyRevenue: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve quarterly report data'], 500);
        }
    }
    
    // Add method to get yearly comparison
    public function getYearlyRevenue()
    {
        try {
            // Use the yearly_reports view
            $yearlyData = \DB::table('yearly_reports')
                ->get()
                ->map(function($year) {
                    return [
                        'year' => $year->year,
                        'total_sales' => round($year->total_sales / 1000000000, 1),
                        'total_rentals' => round($year->total_rentals / 1000000000, 1),
                        'total_revenue' => round($year->total_revenue / 1000000000, 1),
                        'months_reported' => $year->months_reported
                    ];
                });
                
            return response()->json($yearlyData);
        } catch (\Exception $e) {
            \Log::error('Error in getYearlyRevenue: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve yearly report data'], 500);
        }
    }

    public function getDeviceStatistics()
    {
        $deviceStats = \DB::table('devices')
            ->join('categories', 'devices.category_id', '=', 'categories.id')
            ->selectRaw('
                categories.name as category,
                COUNT(*) as device_count,
                SUM(price * stock) as inventory_value,
                SUM(stock) as total_stock
            ')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $totalDevices = $deviceStats->sum('device_count');
        
        foreach ($deviceStats as $stat) {
            $stat->percentage = round(($stat->device_count / $totalDevices) * 100, 2);
        }

        return response()->json($deviceStats);
    }
}

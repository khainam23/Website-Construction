<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  // Add this import

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
        // Get the latest report for date reference
        $latestReport = Report::latest('date')->first();
        
        // Calculate totals across all reports
        $totalRevenues = [
            'sales_revenue' => Report::sum('sales_revenue'),
            'rental_revenue' => Report::sum('rental_revenue'),
            'total_revenue' => Report::sum(DB::raw('sales_revenue + rental_revenue')),
            'date' => $latestReport ? $latestReport->date : now()->format('Y-m-d')
        ];
        
        // Convert to object for consistent use in the view
        $revenueData = (object)$totalRevenues;
        
        $categories = Category::all();
    
        // Ensure we have sample data
        Report::ensureDataExists(now()->year);
    
        // Check if user has sales role
        if (auth()->check() && auth()->user()->role === 'sales') {
            return view('sales-statistics', [
                'latestReport' => $latestReport ?? new \stdClass(),
                'revenueData' => $revenueData
            ]);
        }
        
        // Default admin view with all statistics
        return view('statistics', [
            'latestReport' => $latestReport ?? new \stdClass(),
            'revenueData' => $revenueData,
            'categories' => $categories
        ]);
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

    public function getDailyRevenue(Request $request)
    {
        try {
            $days = (int)$request->input('days', 7); // Default to 7 days if not specified
            
            // Validate days parameter
            if ($days <= 0 || $days > 90) {
                $days = 7; // Default to 7 if invalid
            }
            
            $endDate = now()->format('Y-m-d');
            $startDate = now()->subDays($days - 1)->format('Y-m-d');

            \Log::info("Daily Revenue Query", [
                'days' => $days,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

            // Ensure we have sample data
            Report::ensureDataExists(now()->year);

            $dailyRevenue = Report::selectRaw('
                date,
                sales_revenue,
                rental_revenue,
                (sales_revenue + rental_revenue) as total_revenue
            ')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'desc')
            ->get()
            ->map(function($report) {
                $date = new \DateTime($report->date);
                return [
                    'date' => $report->date,
                    'sales_revenue' => $report->sales_revenue,
                    'rental_revenue' => $report->rental_revenue,
                    'total_revenue' => $report->total_revenue,
                    'day_name' => $this->getVietnameseDayName($date->format('N'))
                ];
            });

            return response()->json($dailyRevenue);
        } catch (\Exception $e) {
            \Log::error('Error in getDailyRevenue: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve daily revenue data: ' . $e->getMessage()], 500);
        }
    }

    private function getVietnameseDayName($dayNumber) {
        $days = [
            1 => 'Thứ Hai',
            2 => 'Thứ Ba',
            3 => 'Thứ Tư',
            4 => 'Thứ Năm',
            5 => 'Thứ Sáu',
            6 => 'Thứ Bảy',
            7 => 'Chủ Nhật'
        ];
        return $days[$dayNumber] ?? '';
    }

    public function getWeeklyRevenue(Request $request)
    {
        try {
            $period = $request->input('period', 'current');
            $currentDate = now();
            
            // Validate period parameter
            if (!in_array($period, ['current', 'previous', 'quarter'])) {
                $period = 'current'; // Default to current if invalid
            }
            
            // Determine date range based on selected period
            switch($period) {
                case 'previous':
                    $startDate = $currentDate->copy()->subMonth()->startOfMonth();
                    $endDate = $currentDate->copy()->subMonth()->endOfMonth();
                    $periodLabel = 'Tháng trước';
                    break;
                case 'quarter':
                    $startDate = $currentDate->copy()->startOfQuarter();
                    $endDate = $currentDate->copy()->endOfQuarter();
                    $periodLabel = 'Quý hiện tại';
                    break;
                case 'current':
                default:
                    $startDate = $currentDate->copy()->startOfMonth();
                    $endDate = $currentDate->copy()->endOfMonth();
                    $periodLabel = 'Tháng hiện tại';
                    break;
            }
            
            \Log::info("Weekly Revenue Query", [
                'period' => $period,
                'periodLabel' => $periodLabel,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ]);

            // Ensure we have sample data
            Report::ensureDataExists($currentDate->year);

            $weeklyRevenue = DB::table('reports')
                ->select(DB::raw('
                    YEARWEEK(date, 1) as yearweek,
                    WEEK(date, 1) as week_number,
                    MIN(date) as week_start,
                    MAX(date) as week_end,
                    SUM(sales_revenue) as sales_revenue,
                    SUM(rental_revenue) as rental_revenue,
                    SUM(sales_revenue + rental_revenue) as total_revenue
                '))
                ->whereBetween('date', [$startDate, $endDate])
                ->groupBy('yearweek', 'week_number')
                ->orderBy('yearweek', 'asc') // Change to ascending to show in chronological order
                ->get()
                ->map(function($report) {
                    return [
                        'week_number' => $report->week_number,
                        'week_start' => $report->week_start,
                        'week_end' => $report->week_end,
                        'sales_revenue' => round((float)$report->sales_revenue, 1),
                        'rental_revenue' => round((float)$report->rental_revenue, 1),
                        'total_revenue' => round((float)$report->total_revenue, 1)
                    ];
                });

            return response()->json($weeklyRevenue);
        } catch (\Exception $e) {
            \Log::error('Error in getWeeklyRevenue: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve weekly revenue data: ' . $e->getMessage()], 500);
        }
    }
}

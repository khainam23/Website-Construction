<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Dompdf\Dompdf;
use Dompdf\Options;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Convert strings to Carbon instances and ensure end date includes current time
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay(); // Changed to end of day
        
        // Get revenue data with date filters
        $dailyRevenue = $this->getDailyRevenue($startDateCarbon, $endDateCarbon);
        $weeklyRevenue = $this->getWeeklyRevenue($startDateCarbon, $endDateCarbon);
        $monthlyRevenue = $this->getCombinedMonthlyRevenue($startDateCarbon, $endDateCarbon);
        $yearlyRevenue = $this->getCombinedYearlyRevenue($startDateCarbon, $endDateCarbon);
        $monthlyProductRevenue = $this->getMonthlyProductRevenue($startDateCarbon, $endDateCarbon);
        $yearlyProductRevenue = $this->getYearlyProductRevenue();
        
        // Get summary statistics for immediate display
        $summaryStats = $this->getSummaryStatistics($startDateCarbon, $endDateCarbon);
        $topSellingProducts = $this->getTopSellingProducts(5);
        $revenueByCategory = $this->getRevenueByCategory($startDateCarbon, $endDateCarbon);
        $comparisonWithPreviousPeriod = $this->getComparisonWithPreviousPeriod($startDateCarbon, $endDateCarbon);

        // Check if OrderDetail table has any data
        $hasData = OrderDetail::count() > 0;
        
        // Prepare data to pass to the view
        $data = compact(
            'monthlyRevenue',
            'yearlyRevenue',
            'monthlyProductRevenue',
            'yearlyProductRevenue',
            'dailyRevenue',
            'weeklyRevenue',
            'startDate',
            'endDate',
            'hasData',
            'summaryStats',
            'topSellingProducts',
            'revenueByCategory',
            'comparisonWithPreviousPeriod'
        );
        
        // Check the user role and return appropriate view
        $user = Auth::user();
        if ($user && $user->role == 'admin') {
            return view('admin.revenue.index', $data);
        }
        
        // Default to sale view
        return view('sale.sales.revenue', $data);
    }

    // Get summary statistics for immediate display
    private function getSummaryStatistics($startDate, $endDate)
    {
        $totalRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        $totalOrders = Order::where('status', 'delivery')
            ->whereBetween('created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->count();
            
        $totalSalesRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereNull('rental_start_date')
            ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        $totalRentalRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereNotNull('rental_start_date')
            ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Get today's revenue - use current time
        $today = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();
        $todayRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$today->toDateTimeString(), $todayEnd->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        // Get this week's revenue - use current time
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now(); // Current time, not end of week
        $thisWeekRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startOfWeek->toDateTimeString(), $endOfWeek->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        // Get this month's revenue - use current time
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now(); // Current time, not end of month
        $thisMonthRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startOfMonth->toDateTimeString(), $endOfMonth->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        // Get this year's revenue - use current time
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now(); // Current time, not end of year
        $thisYearRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startOfYear->toDateTimeString(), $endOfYear->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        return [
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalSalesRevenue' => $totalSalesRevenue,
            'totalRentalRevenue' => $totalRentalRevenue,
            'averageOrderValue' => $averageOrderValue,
            'todayRevenue' => $todayRevenue,
            'thisWeekRevenue' => $thisWeekRevenue,
            'thisMonthRevenue' => $thisMonthRevenue,
            'thisYearRevenue' => $thisYearRevenue
        ];
    }

    // Get top selling products for immediate display
    private function getTopSellingProducts($limit = 5)
    {
        return OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('SUM(order_details.cost * order_details.quantity) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_quantity', 'desc')
            ->limit($limit)
            ->get();
    }

    // Get revenue by category for immediate display
    private function getRevenueByCategory($startDate, $endDate)
    {
        return OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('SUM(order_details.cost * order_details.quantity) as total_revenue')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();
    }

    // Compare current period with previous period
    private function getComparisonWithPreviousPeriod($startDate, $endDate)
    {
        $daysDifference = $endDate->diffInDays($startDate);
        $previousStartDate = (clone $startDate)->subDays($daysDifference + 1);
        $previousEndDate = (clone $startDate)->subDay()->endOfDay(); // Add endOfDay()
        
        $currentPeriodRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        $previousPeriodRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$previousStartDate->toDateTimeString(), $previousEndDate->toDateTimeString()])
            ->sum(DB::raw('cost * quantity'));
            
        $percentageChange = 0;
        if ($previousPeriodRevenue > 0) {
            $percentageChange = (($currentPeriodRevenue - $previousPeriodRevenue) / $previousPeriodRevenue) * 100;
        } elseif ($currentPeriodRevenue > 0) {
            $percentageChange = 100; // If previous period had 0 revenue, but current has some, that's a 100% increase
        }
        
        return [
            'currentPeriodRevenue' => $currentPeriodRevenue,
            'previousPeriodRevenue' => $previousPeriodRevenue,
            'percentageChange' => $percentageChange,
            'previousStartDate' => $previousStartDate->format('Y-m-d'),
            'previousEndDate' => $previousEndDate->format('Y-m-d')
        ];
    }

    public function getDailyRevenue($startDate, $endDate)
    {
        try {
            $result = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
                ->where('orders.status', 'delivery')
                ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
                ->select(
                    DB::raw("DATE_FORMAT(order_details.created_at, '%Y-%m-%d') as date"),
                    DB::raw('SUM(cost * quantity) as revenue')
                )
                ->groupBy('date')
                ->orderBy('date')
                ->get();
            
            // Convert to associative array with consistent format
            $formattedResult = [];
            foreach ($result as $item) {
                $formattedResult[$item->date] = [
                    'revenue' => (float) $item->revenue,
                    'formatted_revenue' => number_format($item->revenue, 0, ',', '.') . ' đ'
                ];
            }
            
            return $formattedResult;
        } catch (\Exception $e) {
            return [];
        }
    }

    public function getWeeklyRevenue($startDate, $endDate)
    {
        $result = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()])
            ->select(
                DB::raw("CONCAT(YEAR(order_details.created_at), '-', WEEK(order_details.created_at)) as week"), 
                DB::raw("DATE_FORMAT(MIN(order_details.created_at), '%Y-%m-%d') as start_date"),
                DB::raw("DATE_FORMAT(MAX(order_details.created_at), '%Y-%m-%d') as end_date"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('week')
            ->orderBy(DB::raw('MIN(order_details.created_at)'))
            ->get();
            
        // Ensure numerical values are properly cast
        foreach ($result as $item) {
            $item->revenue = (float) $item->revenue;
        }
        
        return $result->toArray();
    }

    // Changed from private to public so AdminController can use it
    public function getCombinedMonthlyRevenue($startDate = null, $endDate = null)
    {
        $query = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery');
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()]);
        } else {
            // Default to start of the current year to now if no dates provided
            $defaultStart = Carbon::now()->startOfYear();
            $defaultEnd = Carbon::now()->endOfDay();
            $query->whereBetween('order_details.created_at', [$defaultStart->toDateTimeString(), $defaultEnd->toDateTimeString()]);
        }
        
        $rentalRevenue = $query->clone()->whereNotNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(order_details.created_at, '%Y-%m') as month"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('month')
            ->get();

        $productSalesRevenue = $query->clone()->whereNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(order_details.created_at, '%Y-%m') as month"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('month')
            ->get();

        $combinedRevenue = [];
        $allMonths = [];

        // First, gather all unique months from both revenue types
        foreach ($rentalRevenue as $rental) {
            $allMonths[$rental->month] = true;
        }
        foreach ($productSalesRevenue as $productSale) {
            $allMonths[$productSale->month] = true;
        }

        // Create the basic structure with both types initialized to zero
        foreach (array_keys($allMonths) as $month) {
            $combinedRevenue[$month] = [
                [
                    'month' => $month,
                    'revenue' => 0,
                    'type' => 'rental'
                ],
                [
                    'month' => $month,
                    'revenue' => 0,
                    'type' => 'sale'
                ]
            ];
        }

        // Now fill in the actual rental revenue data
        foreach ($rentalRevenue as $rental) {
            // Find the rental entry for this month and update it
            foreach ($combinedRevenue[$rental->month] as &$entry) {
                if ($entry['type'] === 'rental') {
                    $entry['revenue'] = (float) $rental->revenue;
                    break;
                }
            }
        }

        // Now fill in the actual sales revenue data
        foreach ($productSalesRevenue as $productSale) {
            // Find the sale entry for this month and update it
            foreach ($combinedRevenue[$productSale->month] as &$entry) {
                if ($entry['type'] === 'sale') {
                    $entry['revenue'] = (float) $productSale->revenue;
                    break;
                }
            }
        }

        // If there's no data at all, generate placeholder data for current month
        if (empty($combinedRevenue)) {
            $currentMonth = Carbon::now()->format('Y-m');
            $combinedRevenue[$currentMonth] = [
                [
                    'month' => $currentMonth,
                    'revenue' => 0,
                    'type' => 'rental'
                ],
                [
                    'month' => $currentMonth,
                    'revenue' => 0,
                    'type' => 'sale'
                ]
            ];
        }

        // Sort combined revenue by month
        ksort($combinedRevenue);
        
        // Log for debugging
        \Log::info('Monthly Revenue Data:', ['data' => $combinedRevenue]);

        return $combinedRevenue;
    }

    // Changed from private to public so AdminController can use it
    public function getCombinedYearlyRevenue($startDate = null, $endDate = null)
    {
        $query = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery');
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()]);
        } else {
            // Default to 5 years ago to now if no dates provided
            $defaultStart = Carbon::now()->subYears(5)->startOfYear();
            $defaultEnd = Carbon::now()->endOfDay();
            $query->whereBetween('order_details.created_at', [$defaultStart->toDateTimeString(), $defaultEnd->toDateTimeString()]);
        }
        
        $rentalRevenue = $query->clone()->whereNotNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(order_details.created_at, '%Y') as year"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('year')
            ->get();

        $productSalesRevenue = $query->clone()->whereNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(order_details.created_at, '%Y') as year"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('year')
            ->get();

        $combinedRevenue = [];
        $allYears = [];

        // First, gather all unique years from both revenue types
        foreach ($rentalRevenue as $rental) {
            $allYears[$rental->year] = true;
        }
        foreach ($productSalesRevenue as $productSale) {
            $allYears[$productSale->year] = true;
        }

        // Create the basic structure with both types initialized to zero
        foreach (array_keys($allYears) as $year) {
            $combinedRevenue[$year] = [
                [
                    'year' => $year,
                    'revenue' => 0,
                    'type' => 'rental'
                ],
                [
                    'year' => $year,
                    'revenue' => 0,
                    'type' => 'sale'
                ]
            ];
        }

        // Now fill in the actual rental revenue data
        foreach ($rentalRevenue as $rental) {
            // Find the rental entry for this year and update it
            foreach ($combinedRevenue[$rental->year] as &$entry) {
                if ($entry['type'] === 'rental') {
                    $entry['revenue'] = (float) $rental->revenue;
                    break;
                }
            }
        }

        // Now fill in the actual sales revenue data
        foreach ($productSalesRevenue as $productSale) {
            // Find the sale entry for this year and update it
            foreach ($combinedRevenue[$productSale->year] as &$entry) {
                if ($entry['type'] === 'sale') {
                    $entry['revenue'] = (float) $productSale->revenue;
                    break;
                }
            }
        }

        // If there's no data at all, generate placeholder data for current year
        if (empty($combinedRevenue)) {
            $currentYear = Carbon::now()->format('Y');
            $combinedRevenue[$currentYear] = [
                [
                    'year' => $currentYear,
                    'revenue' => 0,
                    'type' => 'rental'
                ],
                [
                    'year' => $currentYear,
                    'revenue' => 0,
                    'type' => 'sale'
                ]
            ];
        }

        // Log the revenue types for debugging
        $revenueTypes = [];
        foreach ($combinedRevenue as $year => $entries) {
            $revenueTypes[$year] = array_map(function($item) {
                return $item['type'];
            }, $entries);
        }
        \Log::info('Yearly Revenue Types:', ['types' => $revenueTypes]);

        // Sort combined revenue by year
        ksort($combinedRevenue);
        
        // Log for debugging
        \Log::info('Yearly Revenue Data:', ['data' => $combinedRevenue]);

        return $combinedRevenue;
    }

    // Modified to also include date defaults
    public function getMonthlyProductRevenue($startDate = null, $endDate = null)
    {
        $query = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery');
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_details.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()]);
        } else {
            // Default to start of the current year to now if no dates provided
            $defaultStart = Carbon::now()->startOfYear();
            $defaultEnd = Carbon::now()->endOfDay();
            $query->whereBetween('order_details.created_at', [$defaultStart->toDateTimeString(), $defaultEnd->toDateTimeString()]);
        }
        
        // Check if Product model exists
        try {
            $productSalesRevenue = $query->whereNull('rental_start_date')
                ->join('products', 'order_details.product_id', '=', 'products.id')
                ->where('orders.type', 'sales')
                ->select(
                    DB::raw("DATE_FORMAT(order_details.created_at, '%Y-%m') as month"),
                    'products.name',
                    DB::raw('SUM(cost * quantity) as revenue')
                )
                ->groupBy('month', 'products.name')
                ->get()
                ->toArray();

            $monthlyProductRevenue = [];
            foreach ($productSalesRevenue as $productSale) {
                $monthlyProductRevenue[$productSale['month']][] = [
                    'month' => $productSale['month'],
                    'name' => $productSale['name'],
                    'revenue' => (float) $productSale['revenue'],
                ];
            }

            return $monthlyProductRevenue;
        } catch (\Exception $e) {
            // If there's an error, return empty array and log error
            \Log::error('Error in getMonthlyProductRevenue: ' . $e->getMessage());
            return [];
        }
    }

    // Include default date range in yearly product revenue
    public function getYearlyProductRevenue()
    {
        // Default to 5 years ago to now
        $defaultStart = Carbon::now()->subYears(5)->startOfYear();
        $defaultEnd = Carbon::now()->endOfDay();
        
        $productSalesRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->whereNull('rental_start_date')
            ->whereBetween('order_details.created_at', [$defaultStart->toDateTimeString(), $defaultEnd->toDateTimeString()])
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->where('orders.type', 'sales')
            ->select(
                DB::raw("DATE_FORMAT(order_details.created_at, '%Y') as year"),
                'products.name',
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('year', 'products.name')
            ->get()
            ->toArray();

        $yearlyProductRevenue = [];
        foreach ($productSalesRevenue as $productSale) {
            $yearlyProductRevenue[$productSale['year']][] = [
                'year' => $productSale['year'],
                'name' => $productSale['name'],
                'revenue' => (float) $productSale['revenue'],
            ];
        }

        return $yearlyProductRevenue;
    }

    /**
     * Export revenue data as Excel or PDF
     * 
     * @param Request $request
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function exportRevenue(Request $request, $type)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Convert strings to Carbon instances and ensure end date includes current time
        $startDateCarbon = Carbon::parse($startDate)->startOfDay();
        $endDateCarbon = Carbon::parse($endDate)->endOfDay(); // Changed to end of day
        
        // Get data for export
        $dailyRevenue = $this->getDailyRevenue($startDateCarbon, $endDateCarbon);
        $weeklyRevenue = $this->getWeeklyRevenue($startDateCarbon, $endDateCarbon);
        $monthlyRevenue = $this->getCombinedMonthlyRevenue($startDateCarbon, $endDateCarbon);
        $yearlyRevenue = $this->getCombinedYearlyRevenue($startDateCarbon, $endDateCarbon);
        $summaryStats = $this->getSummaryStatistics($startDateCarbon, $endDateCarbon);
        $topSellingProducts = $this->getTopSellingProducts(10); // Get top 10 for export
        
        // Format file name
        $fileName = 'revenue_report_' . $startDateCarbon->format('Y-m-d') . '_to_' . $endDateCarbon->format('Y-m-d');
        
        if ($type === 'excel') {
            return $this->exportToExcel($fileName, $dailyRevenue, $weeklyRevenue, $monthlyRevenue, $yearlyRevenue, $summaryStats, $topSellingProducts, $startDateCarbon, $endDateCarbon);
        } else if ($type === 'pdf') {
            return $this->exportToPDF($fileName, $dailyRevenue, $weeklyRevenue, $monthlyRevenue, $yearlyRevenue, $summaryStats, $topSellingProducts, $startDateCarbon, $endDateCarbon);
        }
        
        return response()->json(['error' => 'Invalid export type'], 400);
    }
    
    /**
     * Export revenue data to Excel
     */
    private function exportToExcel($fileName, $dailyRevenue, $weeklyRevenue, $monthlyRevenue, $yearlyRevenue, $summaryStats, $topSellingProducts, $startDate, $endDate)
    {
        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        
        // Set document properties with additional null check for user name
        $creator = 'System';
        if (Auth::check() && Auth::user() && !empty(Auth::user()->name)) {
            $creator = Auth::user()->name;
        }
        
        $spreadsheet->getProperties()
            ->setCreator($creator)
            ->setLastModifiedBy($creator)
            ->setTitle(__('Revenue Report'))
            ->setSubject(__('Revenue Report'))
            ->setDescription(__('Revenue Report generated on') . ' ' . date('Y-m-d H:i:s'))
            ->setKeywords(__('revenue report export'))
            ->setCategory(__('Report'));
        
        // Create Summary sheet
        $summarySheet = $spreadsheet->getActiveSheet();
        $summarySheet->setTitle(__('Summary'));
        
        // Add title
        $summarySheet->setCellValue('A1', strtoupper(__('Revenue Report')));
        $summarySheet->mergeCells('A1:E1');
        $summarySheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $summarySheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Add date range
        $summarySheet->setCellValue('A2', __('Period') . ': ' . $startDate->format('Y-m-d') . ' ' . __('to') . ' ' . $endDate->format('Y-m-d'));
        $summarySheet->mergeCells('A2:E2');
        $summarySheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        // Add summary statistics
        $summarySheet->setCellValue('A4', __('Summary Statistics'));
        $summarySheet->getStyle('A4')->getFont()->setBold(true);
        
        $summarySheet->setCellValue('A5', __('Total Revenue') . ':');
        $summarySheet->setCellValue('B5', number_format($summaryStats['totalRevenue'], 0, ',', '.') . ' đ');
        
        $summarySheet->setCellValue('A6', __('Sales Revenue') . ':');
        $summarySheet->setCellValue('B6', number_format($summaryStats['totalSalesRevenue'], 0, ',', '.') . ' đ');
        
        $summarySheet->setCellValue('A7', __('Rental Revenue') . ':');
        $summarySheet->setCellValue('B7', number_format($summaryStats['totalRentalRevenue'], 0, ',', '.') . ' đ');
        
        $summarySheet->setCellValue('A8', __('Total Orders') . ':');
        $summarySheet->setCellValue('B8', $summaryStats['totalOrders']);
        
        $summarySheet->setCellValue('A9', __('Average Order Value') . ':');
        $summarySheet->setCellValue('B9', number_format($summaryStats['averageOrderValue'], 0, ',', '.') . ' đ');
        
        // Add top selling products
        $summarySheet->setCellValue('A11', __('Top Selling Products'));
        $summarySheet->getStyle('A11')->getFont()->setBold(true);
        
        $summarySheet->setCellValue('A12', __('Product'));
        $summarySheet->setCellValue('B12', __('Units Sold'));
        $summarySheet->setCellValue('C12', __('Revenue'));
        
        $summarySheet->getStyle('A12:C12')->getFont()->setBold(true);
        $summarySheet->getStyle('A12:C12')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
        
        $row = 13;
        foreach ($topSellingProducts as $product) {
            $summarySheet->setCellValue('A' . $row, $product->name);
            $summarySheet->setCellValue('B' . $row, $product->total_quantity);
            $summarySheet->setCellValue('C' . $row, number_format($product->total_revenue, 0, ',', '.') . ' đ');
            $row++;
        }
        
        // Create Daily Revenue Sheet
        $dailySheet = $spreadsheet->createSheet();
        $dailySheet->setTitle(__('Daily Revenue'));
        
        $dailySheet->setCellValue('A1', __('Daily Revenue'));
        $dailySheet->getStyle('A1')->getFont()->setBold(true);
        
        $dailySheet->setCellValue('A2', __('Date'));
        $dailySheet->setCellValue('B2', __('Revenue'));
        $dailySheet->getStyle('A2:B2')->getFont()->setBold(true);
        $dailySheet->getStyle('A2:B2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
        
        $row = 3;
        foreach ($dailyRevenue as $date => $data) {
            $dailySheet->setCellValue('A' . $row, $date);
            $dailySheet->setCellValue('B' . $row, $data['revenue']);
            $row++;
        }
        
        // Create Weekly Revenue Sheet
        $weeklySheet = $spreadsheet->createSheet();
        $weeklySheet->setTitle(__('Weekly Revenue'));
        
        $weeklySheet->setCellValue('A1', __('Weekly Revenue'));
        $weeklySheet->getStyle('A1')->getFont()->setBold(true);
        
        $weeklySheet->setCellValue('A2', __('Week'));
        $weeklySheet->setCellValue('B2', __('Start Date'));
        $weeklySheet->setCellValue('C2', __('End Date'));
        $weeklySheet->setCellValue('D2', __('Revenue'));
        $weeklySheet->getStyle('A2:D2')->getFont()->setBold(true);
        $weeklySheet->getStyle('A2:D2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
        
        $row = 3;
        foreach ($weeklyRevenue as $week) {
            $weeklySheet->setCellValue('A' . $row, $week['week']);
            $weeklySheet->setCellValue('B' . $row, $week['start_date']);
            $weeklySheet->setCellValue('C' . $row, $week['end_date']);
            $weeklySheet->setCellValue('D' . $row, $week['revenue']);
            $row++;
        }
        
        // Create Monthly Revenue Sheet
        $monthlySheet = $spreadsheet->createSheet();
        $monthlySheet->setTitle(__('Monthly Revenue'));
        
        $monthlySheet->setCellValue('A1', __('Monthly Revenue'));
        $monthlySheet->getStyle('A1')->getFont()->setBold(true);
        
        $monthlySheet->setCellValue('A2', __('Month'));
        $monthlySheet->setCellValue('B2', __('Type'));
        $monthlySheet->setCellValue('C2', __('Revenue'));
        $monthlySheet->getStyle('A2:C2')->getFont()->setBold(true);
        $monthlySheet->getStyle('A2:C2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
        
        $row = 3;
        foreach ($monthlyRevenue as $month => $revenues) {
            foreach ($revenues as $revenue) {
                $monthlySheet->setCellValue('A' . $row, $revenue['month']);
                $monthlySheet->setCellValue('B' . $row, __(ucfirst($revenue['type'])));
                $monthlySheet->setCellValue('C' . $row, $revenue['revenue']);
                $row++;
            }
        }
        
        // Create Yearly Revenue Sheet
        $yearlySheet = $spreadsheet->createSheet();
        $yearlySheet->setTitle(__('Yearly Revenue'));
        
        $yearlySheet->setCellValue('A1', __('Yearly Revenue'));
        $yearlySheet->getStyle('A1')->getFont()->setBold(true);
        
        $yearlySheet->setCellValue('A2', __('Year'));
        $yearlySheet->setCellValue('B2', __('Type'));
        $yearlySheet->setCellValue('C2', __('Revenue'));
        $yearlySheet->getStyle('A2:C2')->getFont()->setBold(true);
        $yearlySheet->getStyle('A2:C2')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFD3D3D3');
        
        $row = 3;
        foreach ($yearlyRevenue as $year => $revenues) {
            foreach ($revenues as $revenue) {
                $yearlySheet->setCellValue('A' . $row, $revenue['year']);
                $yearlySheet->setCellValue('B' . $row, __(ucfirst($revenue['type'])));
                $yearlySheet->setCellValue('C' . $row, $revenue['revenue']);
                $row++;
            }
        }
        
        // Auto-size columns for all sheets
        foreach ($spreadsheet->getWorksheetIterator() as $worksheet) {
            foreach ($worksheet->getColumnIterator() as $column) {
                $worksheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        }
        
        // Set active sheet to first sheet
        $spreadsheet->setActiveSheetIndex(0);
        
        // Create Excel file in memory
        $writer = new Xlsx($spreadsheet);
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '.xlsx"');
        header('Cache-Control: max-age=0');
        
        // Save to PHP output stream
        $writer->save('php://output');
        exit;
    }
    
    /**
     * Export revenue data to PDF
     */
    private function exportToPDF($fileName, $dailyRevenue, $weeklyRevenue, $monthlyRevenue, $yearlyRevenue, $summaryStats, $topSellingProducts, $startDate, $endDate)
    {
        // Configure Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');
        
        $dompdf = new Dompdf($options);
        
        // Build HTML content
        $html = '
        <html>
        <head>
            <style>
                body {
                    font-family: DejaVu Sans, sans-serif;
                    font-size: 12px;
                }
                h1 {
                    text-align: center;
                    font-size: 18px;
                    margin-bottom: 5px;
                }
                h2 {
                    font-size: 14px;
                    margin-top: 20px;
                    margin-bottom: 10px;
                }
                .period {
                    text-align: center;
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 15px;
                }
                table, th, td {
                    border: 1px solid #ddd;
                }
                th {
                    background-color: #f2f2f2;
                    padding: 8px;
                    text-align: left;
                }
                td {
                    padding: 8px;
                }
                .summary-item {
                    margin-bottom: 5px;
                }
                .summary-label {
                    font-weight: bold;
                    display: inline-block;
                    width: 160px;
                }
            </style>
        </head>
        <body>
            <h1>' . strtoupper(__('Revenue Report')) . '</h1>
            <div class="period">' . __('Period') . ': ' . $startDate->format('Y-m-d') . ' ' . __('to') . ' ' . $endDate->format('Y-m-d') . '</div>
            
            <h2>' . __('Summary Statistics') . '</h2>
            <div class="summary-item">
                <span class="summary-label">' . __('Total Revenue') . ':</span>
                <span>' . number_format($summaryStats['totalRevenue'], 0, ',', '.') . ' đ</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">' . __('Sales Revenue') . ':</span>
                <span>' . number_format($summaryStats['totalSalesRevenue'], 0, ',', '.') . ' đ</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">' . __('Rental Revenue') . ':</span>
                <span>' . number_format($summaryStats['totalRentalRevenue'], 0, ',', '.') . ' đ</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">' . __('Total Orders') . ':</span>
                <span>' . $summaryStats['totalOrders'] . '</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">' . __('Average Order Value') . ':</span>
                <span>' . number_format($summaryStats['averageOrderValue'], 0, ',', '.') . ' đ</span>
            </div>
            
            <h2>' . __('Top Selling Products') . '</h2>
            <table>
                <thead>
                    <tr>
                        <th>' . __('Product') . '</th>
                        <th>' . __('Units Sold') . '</th>
                        <th>' . __('Revenue') . '</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($topSellingProducts as $product) {
            $html .= '
                    <tr>
                        <td>' . $product->name . '</td>
                        <td>' . $product->total_quantity . '</td>
                        <td>' . number_format($product->total_revenue, 0, ',', '.') . ' đ</td>
                    </tr>';
        }
        
        $html .= '
                </tbody>
            </table>
            
            <h2>' . __('Monthly Revenue') . '</h2>
            <table>
                <thead>
                    <tr>
                        <th>' . __('Month') . '</th>
                        <th>' . __('Type') . '</th>
                        <th>' . __('Revenue') . '</th>
                    </tr>
                </thead>
                <tbody>';
        
        // Limit to display latest 6 months only to avoid PDF becoming too long
        $latestMonths = array_slice($monthlyRevenue, -6, 6, true);
        foreach ($latestMonths as $month => $revenues) {
            foreach ($revenues as $revenue) {
                $html .= '
                    <tr>
                        <td>' . $revenue['month'] . '</td>
                        <td>' . __(ucfirst($revenue['type'])) . '</td>
                        <td>' . number_format($revenue['revenue'], 0, ',', '.') . ' đ</td>';
            }
        }
        
        $html .= '
                </tbody>
            </table>
            
            <h2>' . __('Yearly Revenue') . '</h2>
            <table>
                <thead>
                    <tr>
                        <th>' . __('Year') . '</th>
                        <th>' . __('Type') . '</th>
                        <th>' . __('Revenue') . '</th>
                    </tr>
                </thead>
                <tbody>';
        
        foreach ($yearlyRevenue as $year => $revenues) {
            foreach ($revenues as $revenue) {
                $html .= '
                    <tr>
                        <td>' . $revenue['year'] . '</td>
                        <td>' . __(ucfirst($revenue['type'])) . '</td>
                        <td>' . number_format($revenue['revenue'], 0, ',', '.') . ' đ</td>';
            }
        }
        
        $html .= '
                </tbody>
            </table>
        </body>
        </html>';
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        return $dompdf->stream($fileName . '.pdf', ['Attachment' => true]);
    }
}

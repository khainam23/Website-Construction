<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        // Get date range from request or default to last 30 days
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        
        // Convert strings to Carbon instances
        $startDateCarbon = Carbon::parse($startDate);
        $endDateCarbon = Carbon::parse($endDate);
        
        // Get revenue data with date filters
        $dailyRevenue = $this->getDailyRevenue($startDateCarbon, $endDateCarbon);
        $weeklyRevenue = $this->getWeeklyRevenue($startDateCarbon, $endDateCarbon);
        $monthlyRevenue = $this->getCombinedMonthlyRevenue($startDateCarbon, $endDateCarbon);
        $yearlyRevenue = $this->getCombinedYearlyRevenue($startDateCarbon, $endDateCarbon);
        $monthlyProductRevenue = $this->getMonthlyProductRevenue($startDateCarbon, $endDateCarbon);
        $yearlyProductRevenue = $this->getYearlyProductRevenue();

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
            'hasData'
        );
        
        // Check the user role and return appropriate view
        $user = Auth::user();
        if ($user && $user->role == 'admin') {
            return view('admin.revenue.index', $data);
        }
        
        // Default to staff view
        return view('staff.sales.revenue', $data);
    }

    public function getDailyRevenue($startDate, $endDate)
    {
        try {
            $result = OrderDetail::whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"),
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
        $result = OrderDetail::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw("CONCAT(YEAR(created_at), '-', WEEK(created_at)) as week"), 
                DB::raw("DATE_FORMAT(MIN(created_at), '%Y-%m-%d') as start_date"),
                DB::raw("DATE_FORMAT(MAX(created_at), '%Y-%m-%d') as end_date"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('week')
            ->orderBy(DB::raw('MIN(created_at)'))
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
        $query = OrderDetail::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $rentalRevenue = $query->clone()->whereNotNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('month')
            ->get();

        $productSalesRevenue = $query->clone()->whereNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('month')
            ->get();

        $combinedRevenue = [];

        // Process rental revenue
        foreach ($rentalRevenue as $rental) {
            $combinedRevenue[$rental['month']][] = [
                'month' => $rental['month'],
                'revenue' => (float) $rental['revenue'],
                'type' => 'rental'
            ];
        }

        // Process product sales revenue
        foreach ($productSalesRevenue as $productSale) {
            $combinedRevenue[$productSale['month']][] = [
                'month' => $productSale['month'],
                'revenue' => (float) $productSale['revenue'],
                'type' => 'staff'
            ];
        }

        // If there's no data at all, return an empty array
        if (empty($combinedRevenue)) {
            return [];
        }

        // Sort combined revenue by month
        ksort($combinedRevenue);

        return $combinedRevenue;
    }

    // Changed from private to public so AdminController can use it
    public function getCombinedYearlyRevenue($startDate = null, $endDate = null)
    {
        $query = OrderDetail::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        
        $rentalRevenue = $query->clone()->whereNotNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('year')
            ->get()
            ->toArray();

        $productSalesRevenue = $query->clone()->whereNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('year')
            ->get()
            ->toArray();

        $combinedRevenue = [];

        // Process rental revenue
        foreach ($rentalRevenue as $rental) {
            $combinedRevenue[$rental['year']][] = [
                'year' => $rental['year'],
                'revenue' => (float) $rental['revenue'],
                'type' => 'rental'
            ];
        }

        // Process product sales revenue
        foreach ($productSalesRevenue as $productSale) {
            $combinedRevenue[$productSale['year']][] = [
                'year' => $productSale['year'],
                'revenue' => (float) $productSale['revenue'],
                'type' => 'staff'
            ];
        }

        // Sort combined revenue by year
        ksort($combinedRevenue);

        return $combinedRevenue;
    }

    // Changed from private to public so AdminController can use it
    public function getMonthlyProductRevenue($startDate = null, $endDate = null)
    {
        $query = OrderDetail::query();
        
        if ($startDate && $endDate) {
            $query->whereBetween('order_details.created_at', [$startDate, $endDate]);
        }
        
        // Check if Product model exists
        try {
            $productSalesRevenue = $query->whereNull('rental_start_date')
                ->join('orders', 'order_details.order_id', '=', 'orders.id')
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

    // Changed from private to public so AdminController can use it
    public function getYearlyProductRevenue()
    {
        $productSalesRevenue = OrderDetail::whereNull('rental_start_date')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
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
}

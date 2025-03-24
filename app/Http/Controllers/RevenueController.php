<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    public function index()
    {
        $monthlyRevenue = $this->getCombinedMonthlyRevenue();
        $yearlyRevenue = $this->getCombinedYearlyRevenue();
        $monthlyProductRevenue = $this->getMonthlyProductRevenue();
        $yearlyProductRevenue = $this->getYearlyProductRevenue();

        return view('sale.sales.revenue', compact(
            'monthlyRevenue',
            'yearlyRevenue',
            'monthlyProductRevenue',
            'yearlyProductRevenue'
        ));
    }

    // Changed from private to public so AdminController can use it
    public function getCombinedMonthlyRevenue()
    {
        $rentalRevenue = OrderDetail::whereNotNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                'rental_start_date',
                'rental_end_date',
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('month', 'rental_start_date', 'rental_end_date')
            ->get()
            ->toArray();

        $productSalesRevenue = OrderDetail::whereNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(cost * quantity) as revenue')
            )
            ->groupBy('month')
            ->get()
            ->toArray();

        $combinedRevenue = [];

        // Process rental revenue
        foreach ($rentalRevenue as $rental) {
            $combinedRevenue[$rental['month']][] = [
                'month' => $rental['month'],
                'revenue' => $rental['revenue'],
                'rental_start_date' => $rental['rental_start_date'],
                'rental_end_date' => $rental['rental_end_date'],
                'type' => 'rental'
            ];
        }

        // Process product sales revenue
        foreach ($productSalesRevenue as $productSale) {
            $combinedRevenue[$productSale['month']][] = [
                'month' => $productSale['month'],
                'revenue' => $productSale['revenue'],
                'rental_start_date' => null,
                'rental_end_date' => null,
                'type' => 'sale'
            ];
        }

        // Sort combined revenue by month
        ksort($combinedRevenue);

        return $combinedRevenue;
    }

    // Changed from private to public so AdminController can use it
    public function getCombinedYearlyRevenue()
    {
        $rentalRevenue = OrderDetail::whereNotNull('rental_start_date')
            ->select(
                DB::raw("DATE_FORMAT(created_at, '%Y') as year"),
                DB::raw('SUM(cost * quantity) as revenue'),
                'rental_start_date',
                'rental_end_date'
            )
            ->groupBy('year', 'rental_start_date', 'rental_end_date')
            ->get()
            ->toArray();

        $productSalesRevenue = OrderDetail::whereNull('rental_start_date')
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
                'revenue' => $rental['revenue'],
                'rental_start_date' => $rental['rental_start_date'],
                'rental_end_date' => $rental['rental_end_date'],
                'type' => 'rental'
            ];
        }

        // Process product sales revenue
        foreach ($productSalesRevenue as $productSale) {
            $combinedRevenue[$productSale['year']][] = [
                'year' => $productSale['year'],
                'revenue' => $productSale['revenue'],
                'rental_start_date' => null,
                'rental_end_date' => null,
                'type' => 'sale'
            ];
        }

        // Sort combined revenue by year
        ksort($combinedRevenue);

        return $combinedRevenue;
    }

    // Changed from private to public so AdminController can use it
    public function getMonthlyProductRevenue()
    {
        $productSalesRevenue = OrderDetail::whereNull('rental_start_date')
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
                'revenue' => $productSale['revenue'],
            ];
        }

        return $monthlyProductRevenue;
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
                'revenue' => $productSale['revenue'],
            ];
        }

        return $yearlyProductRevenue;
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function dashboard()
    {
        // Get today's revenue up to the current moment
        $todayRevenue = Order::whereDate('orders.created_at', Carbon::today())
            ->where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->sum(DB::raw('order_details.cost * order_details.quantity'));
        
        // Get weekly revenue up to the current moment
        $weeklyRevenue = Order::where('orders.status', 'delivery')
            ->whereBetween('orders.created_at', [Carbon::now()->startOfWeek(), Carbon::now()])
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->sum(DB::raw('order_details.cost * order_details.quantity'));
        
        // Get monthly revenue up to the current moment
        $monthlyRevenue = Order::where('orders.status', 'delivery')
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->whereMonth('orders.created_at', Carbon::now()->month)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->sum(DB::raw('order_details.cost * order_details.quantity'));
            
        // Get yearly revenue up to the current moment
        $yearlyRevenue = Order::where('orders.status', 'delivery')
            ->whereYear('orders.created_at', Carbon::now()->year)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->sum(DB::raw('order_details.cost * order_details.quantity'));
            
        // Add timestamp when the data was generated
        $generatedAt = Carbon::now()->format('Y-m-d H:i:s');
        
        return view('sale.dashboard', compact('todayRevenue', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue', 'generatedAt'));
    }

    public function index()
    {
        // Calculate total revenue
        $totalRevenue = Order::where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->sum(DB::raw('order_details.cost * order_details.quantity'));

        // Calculate total orders
        $totalOrders = Order::where('orders.status', 'delivery')->count();

        // Calculate average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Get recent orders with calculated total and product details
        $recentOrders = Order::select('orders.*', DB::raw('SUM(order_details.cost * order_details.quantity) as calculated_total'))
            ->with(['details.product']) // Include product information
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->where('orders.status', 'delivery') // Add this line to filter by delivery status
            ->groupBy('orders.id')
            ->latest('orders.created_at')
            ->take(5)
            ->get();

        // Get sales by product category
        $salesByCategory = DB::table('orders')
            ->where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(order_details.cost * order_details.quantity) as total_sales'))
            ->groupBy('categories.name')
            ->get();

        return view('sale.sales.index', compact('totalRevenue', 'totalOrders', 'averageOrderValue', 'recentOrders', 'salesByCategory'));
    }

    public function revenueStatistics()
    {
        // Track when statistics were generated
        $generatedAt = Carbon::now()->format('Y-m-d H:i:s');
        
        // Calculate daily revenue for current month up to current moment
        $dailyRevenue = Order::where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m-%d') as date"), 
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->where(function($query) {
                $query->whereMonth('orders.created_at', '<', Carbon::now()->month)
                      ->whereYear('orders.created_at', '=', Carbon::now()->year)
                      ->orWhere(function($q) {
                          $q->whereMonth('orders.created_at', '=', Carbon::now()->month)
                            ->whereYear('orders.created_at', '=', Carbon::now()->year)
                            ->where('orders.created_at', '<=', Carbon::now());
                      });
            })
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Calculate weekly revenue
        $weeklyRevenue = Order::where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                DB::raw("CONCAT(YEAR(orders.created_at), '-', WEEK(orders.created_at)) as week"), 
                DB::raw("DATE_FORMAT(MIN(orders.created_at), '%Y-%m-%d') as start_date"),
                DB::raw("DATE_FORMAT(MAX(orders.created_at), '%Y-%m-%d') as end_date"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->take(10)
            ->get();

        // Calculate monthly revenue
        $monthlyRevenue = Order::where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at, '%Y-%m') as month"), 
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate quarterly revenue
        $quarterlyRevenue = Order::where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                DB::raw("CONCAT(YEAR(orders.created_at), '-Q', QUARTER(orders.created_at)) as quarter"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('quarter')
            ->orderBy(DB::raw("YEAR(orders.created_at)"), 'desc')
            ->orderBy(DB::raw("QUARTER(orders.created_at)"), 'desc')
            ->get();

        // Calculate yearly revenue
        $yearlyRevenue = Order::where('orders.status', 'delivery')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->select(
                DB::raw("DATE_FORMAT(orders.created_at, '%Y') as year"), 
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('sale.sales.revenue', compact(
            'dailyRevenue', 
            'weeklyRevenue', 
            'monthlyRevenue', 
            'quarterlyRevenue', 
            'yearlyRevenue',
            'generatedAt'
        ));
    }

    public function productSales()
    {
        // Get top selling products
        $topSellingProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name', 
                DB::raw('SUM(order_details.quantity) as total_quantity'),
                DB::raw('SUM(order_details.cost * order_details.quantity) as total_revenue')
            )
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        // Get recently sold products
        $recentlySoldProducts = DB::table('order_details')
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name', 
                'order_details.created_at',
                'order_details.quantity',
                'order_details.cost',
                DB::raw('order_details.cost * order_details.quantity as total_cost')
            )
            ->orderByDesc('order_details.created_at')
            ->take(5)
            ->get();

        return view('sale.sales.product_sales', compact('topSellingProducts', 'recentlySoldProducts'));
    }
}

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
        // Get today's revenue
        $todayRevenue = Order::whereDate('created_at', Carbon::today())->sum('total');
        
        // Get weekly revenue
        $weeklyRevenue = Order::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total');
        
        // Get monthly revenue
        $monthlyRevenue = Order::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('total');
            
        // Get yearly revenue
        $yearlyRevenue = Order::whereYear('created_at', Carbon::now()->year)->sum('total');
        
        return view('staff.dashboard', compact('todayRevenue', 'weeklyRevenue', 'monthlyRevenue', 'yearlyRevenue'));
    }

    public function index()
    {
        // Calculate total revenue
        $totalRevenue = Order::sum('total');

        // Calculate total orders
        $totalOrders = Order::count();

        // Calculate average order value
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Get recent orders
        $recentOrders = Order::latest()->take(5)->get();

        // Get sales by product category
        $salesByCategory = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(order_details.cost * order_details.quantity) as total_sales'))
            ->groupBy('categories.name')
            ->get();

        return view('staff.sales.index', compact('totalRevenue', 'totalOrders', 'averageOrderValue', 'recentOrders', 'salesByCategory'));
    }

    public function revenueStatistics()
    {
        // Calculate daily revenue for current month
        $dailyRevenue = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw('SUM(total) as revenue'))
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Calculate weekly revenue
        $weeklyRevenue = Order::select(DB::raw("CONCAT(YEAR(created_at), '-', WEEK(created_at)) as week"), 
            DB::raw("DATE_FORMAT(MIN(created_at), '%Y-%m-%d') as start_date"),
            DB::raw("DATE_FORMAT(MAX(created_at), '%Y-%m-%d') as end_date"),
            DB::raw('SUM(total) as revenue'))
            ->groupBy('week')
            ->orderBy('week', 'desc')
            ->take(10)
            ->get();

        // Calculate monthly revenue
        $monthlyRevenue = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('SUM(total) as revenue'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate quarterly revenue
        $quarterlyRevenue = Order::select(
            DB::raw("CONCAT(YEAR(created_at), '-Q', QUARTER(created_at)) as quarter"),
            DB::raw('SUM(total) as revenue'))
            ->groupBy('quarter')
            ->orderBy(DB::raw("YEAR(created_at)"), 'desc')
            ->orderBy(DB::raw("QUARTER(created_at)"), 'desc')
            ->get();

        // Calculate yearly revenue
        $yearlyRevenue = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y') as year"), DB::raw('SUM(total) as revenue'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('staff.sales.revenue', compact(
            'dailyRevenue', 
            'weeklyRevenue', 
            'monthlyRevenue', 
            'quarterlyRevenue', 
            'yearlyRevenue'
        ));
    }

    public function productSales()
    {
        // Get top selling products
        $topSellingProducts = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.name as product_name', DB::raw('SUM(order_details.quantity) as total_quantity'))
            ->groupBy('products.name')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        // Get recently sold products
        $recentlySoldProducts = DB::table('order_details')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->select('products.name as product_name', 'order_details.created_at')
            ->orderByDesc('order_details.created_at')
            ->take(5)
            ->get();

        return view('staff.sales.product_sales', compact('topSellingProducts', 'recentlySoldProducts'));
    }
}

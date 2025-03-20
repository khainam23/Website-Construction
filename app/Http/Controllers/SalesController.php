<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class SalesController extends Controller
{
    public function dashboard()
    {
        return view('sale.dashboard');
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

        return view('sale.sales.index', compact('totalRevenue', 'totalOrders', 'averageOrderValue', 'recentOrders', 'salesByCategory'));
    }

    public function revenueStatistics()
    {
        // Calculate monthly revenue
        $monthlyRevenue = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"), DB::raw('SUM(total) as revenue'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Calculate yearly revenue
        $yearlyRevenue = Order::select(DB::raw("DATE_FORMAT(created_at, '%Y') as year"), DB::raw('SUM(total) as revenue'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        return view('sale.sales.revenue', compact('monthlyRevenue', 'yearlyRevenue'));
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

        return view('sale.sales.product_sales', compact('topSellingProducts', 'recentlySoldProducts'));
    }
}

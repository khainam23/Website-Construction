<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();
        
        // Get total revenue - only for orders with delivery status
        $totalRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->sum(DB::raw('order_details.cost * order_details.quantity'));
        
        // Get monthly revenue for current year - only for orders with delivery status
        $monthlyRevenue = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivery')
            ->select(
                DB::raw("DATE_FORMAT(order_details.created_at, '%m') as month"),
                DB::raw('SUM(order_details.cost * order_details.quantity) as revenue')
            )
            ->whereYear('order_details.created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalCategories', 
            'totalUsers', 
            'totalOrders',
            'totalRevenue',
            'monthlyRevenue'
        ));
    }
    
    public function revenue()
    {
        // Use the RevenueController to get the revenue data
        $revenueController = new RevenueController();
        
        $monthlyRevenue = $revenueController->getCombinedMonthlyRevenue();
        $yearlyRevenue = $revenueController->getCombinedYearlyRevenue();
        $monthlyProductRevenue = $revenueController->getMonthlyProductRevenue();
        $yearlyProductRevenue = $revenueController->getYearlyProductRevenue();
        
        return view('admin.revenue.revenue', compact(
            'monthlyRevenue',
            'yearlyRevenue',
            'monthlyProductRevenue',
            'yearlyProductRevenue'
        ));
    }
}

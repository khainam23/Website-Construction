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
        
        // Get total revenue
        $totalRevenue = OrderDetail::sum(DB::raw('cost * quantity'));
        
        // Get monthly revenue for current year
        $monthlyRevenue = OrderDetail::select(
            DB::raw("DATE_FORMAT(created_at, '%m') as month"),
            DB::raw('SUM(cost * quantity) as revenue')
        )
        ->whereYear('created_at', date('Y'))
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

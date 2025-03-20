<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();

        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalUsers', 'totalOrders'));
    }
}

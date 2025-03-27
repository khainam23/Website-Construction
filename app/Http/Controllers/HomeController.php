<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index() {
        $role = auth()->user()->role ?? 'guest';
    
        if($role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else if($role == 'staff') {
            return view('staff.dashboard');
        } else {
            // Get popular products from orders
            $popularProducts = Product::select('products.*', DB::raw('COUNT(order_details.product_id) as order_count'))
                ->leftJoin('order_details', 'products.id', '=', 'order_details.product_id')
                ->groupBy('products.id')
                ->having('order_count', '>', 0)
                ->orderBy('order_count', 'desc')
                ->limit(10)
                ->get();
    
            // If popular products are less than 3, add more from regular products
            if ($popularProducts->count() < 3) {
                $additionalProducts = Product::whereNotIn('id', $popularProducts->pluck('id'))
                    ->limit(10 - $popularProducts->count())
                    ->get();
                
                $products = $popularProducts->concat($additionalProducts);
            } else {
                $products = $popularProducts;
            }
    
            return view("frontend.home", compact("products"));
        }
    }
}

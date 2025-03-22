<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() {
        $role = auth()->user()->role ?? 'guest';

        if($role == 'admin') {
            return redirect()->route('admin.dashboard');
        } else if($role == 'sale') {
            return view('sale.dashboard');
        } else if($role == 'warehouse') {
            // Chưa có
        } else {
            $products = Product::all();
            return view("frontend.home", compact("products"));
        }
    }
}

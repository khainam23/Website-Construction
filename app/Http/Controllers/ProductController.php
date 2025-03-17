<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function viewAll($type)
    {
        $products = null;
        if ($type == 'all') {
            $products = Product::all();
        } else {
            $products = Product::whereRaw("LOWER(type) = ?", [strtolower($type)])->get();
        }
        $categories = Category::all();

        return view("frontend.product", compact("products", "categories"));
    }

    public function show(Request $request)
    {

    }
}

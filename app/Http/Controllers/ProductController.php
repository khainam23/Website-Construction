<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function viewAll()
    {
        $products = Product::all();
        return $products;
    }

    public function show(Request $request)
    {

    }
}

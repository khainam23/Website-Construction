<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AssetController extends Controller
{
    public function loadProduct()
    {
        $products = Product::with(['category', 'productInventories'])->orderBy("id")->paginate(10);
        return view('admin.products.index', compact('products'));
    }
}

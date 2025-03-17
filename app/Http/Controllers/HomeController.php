<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index() {
        if(!session() -> has("lang")){
            session(['lang' => 'vi']); // set defauls lang
        }

        $products = Product::all();
        return view("frontend.home", compact("products"));
    }
}

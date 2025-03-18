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
        $product = Product::with(['category', 'images'])
            ->where('id', $request->id)
            ->first();

        // Đảm bảo sản phẩm tồn tại
        if (!$product) {
            abort(404); // Trả về lỗi 404 nếu sản phẩm không tồn tại
        }

        // Ẩn một số thuộc tính không cần thiết
        $product->makeHidden(['status', 'created_at']);

        // Lấy danh sách sản phẩm cùng danh mục, ngoại trừ sản phẩm hiện tại
        $products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->get();

        return view("frontend.product-detail", compact("product", "products"));
    }

}

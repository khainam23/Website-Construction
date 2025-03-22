<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

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
        $product = Product::with(['category', 'images', 'productDescriptions', 'productInventories'])
            ->where('id', $request->id)
            ->first();

        // Đảm bảo sản phẩm tồn tại
        if (!$product) {
            abort(404); // Trả về lỗi 404 nếu sản phẩm không tồn tại
        }

        // Ẩn một số thuộc tính không cần thiết
        $product->makeHidden(['status', 'created_at']);

        // Nếu có productDescriptions, gộp vào thuộc tính chính của product
        if ($product->productDescriptions) {
            $product->info = $product->productDescriptions->infomations;
            $product->features = $product->productDescriptions->features;
            $product->applications = $product->productDescriptions->applications;
            unset($product->productDescriptions);
        }

        // Lấy danh sách sản phẩm cùng danh mục, ngoại trừ sản phẩm hiện tại
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->get();

        return view("frontend.product-detail", compact("product", "relatedProducts"));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function loadProduct()
    {
        $products = Product::with(['category', 'productInventories'])->orderBy("id")->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'images', 'productDescriptions', 'productInventories'])
            ->where('id', $id)
            ->first();

        $categories = Category::all();

        // Đảm bảo sản phẩm tồn tại
        if (!$product) {
            abort(404); // Trả về lỗi 404 nếu sản phẩm không tồn tại
        }

        // Nếu có productDescriptions, gộp vào thuộc tính chính của product
        if ($product->productDescriptions) {
            $product->info = $product->productDescriptions->infomations;
            $product->features = $product->productDescriptions->features;
            $product->applications = $product->productDescriptions->applications;
            unset($product->productDescriptions);
        }

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function deleteImage($idImage)
    {
        // Tìm ảnh theo ID
        $image = Image::find($idImage);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Ảnh không tồn tại!'], 404);
        }

        // Xóa ảnh khỏi database
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Ảnh đã được xóa thành công!']);
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $uploadedImages = [];

        try {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');

                $productImage = Image::create([
                    'product_id' => $request->product_id,
                    'path' => 'storage/' . $imagePath
                ]);

                $uploadedImages[] = [
                    'id' => $productImage->id,
                    'path' => asset($productImage->path)
                ];
            }

            return response()->json(['success' => true, 'images' => $uploadedImages]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function loadProduct($page = 1)
    {
        $products = Product::with(['category', 'productInventories'])->orderBy("id")->get();
        return view('admin.products.index', compact('products', "page"));
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'images', 'productDescriptions', 'productInventories'])
            ->where('id', $id)
            ->first();
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

        return view('admin.products.edit', compact('product'));
    }

    public function deleteImage($idImage)
    {
        // Tìm ảnh theo ID
        $image = Image::find($idImage);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Ảnh không tồn tại!'], 404);
        }

        // Delete physical file
        $imagePath = public_path($image->path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete database record
        $image->delete();

        return response()->json(['success' => true, 'message' => 'Ảnh đã được xóa thành công!']);
    }

    // In uploadImages method
    public function uploadImages(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $uploadedImages = [];

        try {
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('products'), $fileName);

                $productImage = Image::create([
                    'product_id' => $request->product_id,
                    'path' => 'products/' . $fileName
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

    public function update(Request $request, $id)
    {
        try {
            // Tìm sản phẩm theo ID
            $product = Product::findOrFail($id);

            // Validate dữ liệu đầu vào
            $request->validate([
                'name' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'description' => 'nullable|string',
                'info' => 'nullable|string',
                'feature' => 'nullable|string',
                'application' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
            ]);

            // Cập nhật thông tin sản phẩm
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'price' => $request->price,
            ]);

            // Cập nhật số lượng tồn kho
            $product->productInventories()->updateOrCreate(
                ['product_id' => $product->id],
                ['quantity' => $request->stock]
            );

            // Cập nhật thông tin mô tả sản phẩm
            $product->productDescriptions()->updateOrCreate(
                ['product_id' => $product->id],
                [
                    'infomations' => $request->info,
                    'features' => $request->feature,
                    'applications' => $request->application
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã được cập nhật!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function delete($id)
    {
        $product = Product::with('images')->findOrFail($id);

        // Delete physical image files
        if ($product->avatar) {
            $avatarPath = public_path($product->avatar);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }

        // Delete all related images
        foreach ($product->images as $image) {
            $imagePath = public_path($image->path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete the product (this will cascade delete related records)
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm và các ảnh liên quan đã được xóa thành công.');
    }

    public function store(Request $request)
    {
        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'info' => 'nullable|string',
            'feature' => 'nullable|string',
            'application' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:1',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Tạo sản phẩm
        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();

        if ($request->hasFile('images')) {
            $isFirstImage = true;
            foreach ($request->file('images') as $image) {
                $fileName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('products'), $fileName);
                $path = 'products/' . $fileName;

                if ($isFirstImage) {
                    $product->avatar = $path;
                    $product->save();
                    $isFirstImage = false;
                }

                $product->images()->create(['path' => $path]);
            }
        }

        // Xử lý mô tả thông tin
        $product->productDescriptions()->create([
            'infomations' => $request->info,
            'features' => $request->feature,
            'applications' => $request->application
        ]);

        // Xử lý lưu trữ 
        $product->productInventories()->create([
            'quantity' => $request->stock
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm thành công!'
        ]);
    }

    public function search($name)
    {
        // Tìm các sản phẩm có tên chứa $name (không phân biệt chữ hoa/thường)
        $products = Product::where('name', 'like', "%{$name}%")->get();

        // Trả về JSON nếu gọi bằng AJAX
        return response()->json($products);
    }
}

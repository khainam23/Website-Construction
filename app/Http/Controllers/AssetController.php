<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use App\Models\Category;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function loadProduct($page = 1)
    {
        $products = Product::with(['category', 'productInventories'])->get();
        $categories = Category::all();

        // Determine which view to render based on user role
        $role = session('user')['role'];
        $view = $role == 'sale' ? 'sale.products.index' : 'admin.products.index';

        return view($view, compact('products', 'categories', 'page'));
    }

    public function edit(Request $request, $id)
    {
        $product = Product::with(['category', 'images', 'productInventories', 'productDescriptions'])
            ->where('id', $id)->first();

        // Fill in product features from descriptions
        if ($product->productDescriptions) {
            $product->info = $product->productDescriptions->infomations;
            $product->features = $product->productDescriptions->features;
            $product->applications = $product->productDescriptions->applications;
        }

        $categories = Category::all();

        // Determine which view to render based on user role
        $role = session('user')['role'];
        $view = $role == 'sale' ? 'sale.products.edit' : 'admin.products.edit';

        return view($view, compact('product', 'categories'));
    }

    public function deleteImage($idImage)
    {
        // Tìm ảnh theo ID
        $image = Image::find($idImage);

        if (!$image) {
            return response()->json(['success' => false, 'message' => 'Ảnh không tồn tại!'], 404);
        }

        // Get product before deleting image
        $productId = $image->product_id;
        $product = Product::find($productId);

        // Check if the deleted image is the avatar
        $isAvatar = ($product->avatar == $image->path);

        // Delete physical file
        $imagePath = public_path($image->path);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete database record
        $image->delete();

        // Count remaining images after deletion
        $remainingImages = Image::where('product_id', $productId)->get();

        // If we deleted the avatar or if there's only one image left
        if ($isAvatar || $remainingImages->count() == 1) {
            if ($remainingImages->count() > 0) {
                // Set the first remaining image as the avatar
                $lastImage = $remainingImages->first();
                $product->avatar = $lastImage->path;
                $product->save();
            } else {
                // No images left, clear the avatar
                $product->avatar = null;
                $product->save();
            }
        }

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
                'type_product' => 'nullable|string',
                'info' => 'nullable|string',
                'feature' => 'nullable|string',
                'application' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'delete_images' => 'nullable|array',
                'delete_images.*' => 'exists:images,id',
            ]);

            // Xử lý xóa hình ảnh (nếu có)
            if ($request->has('delete_images') && !empty($request->delete_images)) {
                foreach ($request->delete_images as $imageId) {
                    $image = Image::find($imageId);

                    if ($image && $image->product_id == $product->id) {
                        // Check if the deleted image is the avatar
                        $isAvatar = ($product->avatar == $image->path);

                        // Delete physical file
                        $imagePath = public_path($image->path);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }

                        // Delete database record
                        $image->delete();

                        // If we deleted the avatar or if there's only one image left, update avatar
                        if ($isAvatar || Image::where('product_id', $product->id)->count() == 1) {
                            $remainingImage = Image::where('product_id', $product->id)->first();
                            if ($remainingImage) {
                                $product->avatar = $remainingImage->path;
                                $product->save();
                            } else {
                                $product->avatar = null;
                                $product->save();
                            }
                        }
                    }
                }
            }

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
                [
                    'quantity' => $request->stock,
                    'type' => $request->type_product
                ]
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
            'type_product' => 'nullable|string',
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
            'quantity' => $request->stock,
            'type' => $request->type_product
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

    /**
     * Set an image as the product avatar
     */
    public function setAvatar(Request $request)
    {
        try {
            $request->validate([
                'image_id' => 'required|exists:images,id',
                'product_id' => 'required|exists:products,id'
            ]);

            $image = Image::findOrFail($request->image_id);
            $product = Product::findOrFail($request->product_id);

            // Verify the image belongs to this product
            if ($image->product_id != $product->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'The image does not belong to this product'
                ], 403);
            }

            // Set as avatar
            $product->avatar = $image->path;
            $product->save();

            return response()->json([
                'success' => true,
                'message' => 'Avatar has been updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

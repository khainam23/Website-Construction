<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'productInventories'])->orderBy("id")->paginate(10);
        return view('admin.products.index', compact('products'));
    }

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

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Starting update for product ID: ' . $id);

        $product = Product::findOrFail($id);

        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->save();

        Log::info('Basic product info updated');

        if ($request->hasFile('images')) {
            Log::info('Images detected in request. Count: ' . count($request->file('images')));

            try {
                foreach ($request->file('images') as $index => $image) {
                    Log::info("Processing image {$index}: " . $image->getClientOriginalName());

                    // Check if image is valid
                    if (!$image->isValid()) {
                        Log::error("Image {$index} is not valid");
                        continue;
                    }

                    // Store the image
                    $path = $image->store('public/products');
                    Log::info("Image stored at path: {$path}");

                    if (!$path) {
                        Log::error("Failed to store image {$index}");
                        continue;
                    }

                    // Create database record
                    $dbPath = str_replace('public/', '', $path);
                    Log::info("Saving path to database: {$dbPath}");

                    $imageModel = $product->images()->create([
                        'path' => $dbPath,
                    ]);

                    if ($imageModel) {
                        Log::info("Image record created with ID: {$imageModel->id}");
                    } else {
                        Log::error("Failed to create image record in database");
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error uploading images: ' . $e->getMessage());
                Log::error($e->getTraceAsString());
                return redirect()->back()->with('error', 'Error uploading images: ' . $e->getMessage());
            }
        } else {
            Log::info('No images in request');
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}

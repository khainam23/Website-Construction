<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $query = Device::query();

        // Get all parent categories with their children
        $categories = Category::with('children')
                            ->whereNull('parent_id')
                            ->orderBy('order')
                            ->get();

        // Xử lý tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Lọc theo danh mục (chỉ khi có category parameter)
        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug)
                  ->orWhereHas('parent', function($q) use ($categorySlug) {
                      $q->where('slug', $categorySlug);
                  });
            });
        }
        // Nếu không có category parameter, sẽ hiển thị tất cả sản phẩm

        // Lọc theo giá
        if ($request->filled(['price_min', 'price_max'])) {
            $query->whereBetween('price', [
                $request->price_min,
                $request->price_max
            ]);
        }

        // Sắp xếp
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Eager load category để tối ưu truy vấn
        $query->with('category');
        
        $devices = $query->paginate(9)->withQueryString();

        return view('shop', compact('devices', 'categories'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Order; // Import the Order model
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('totalProducts', 'totalCategories', 'totalUsers'));
    }

    public function indexUsers(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully.');
    }

    public function indexProducts(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->description = $request->input('description');
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function indexOrders(Request $request)
    {
        $search = $request->input('search');

         $orders = Order::query()
            ->when($search, function ($query, $search) {
                $query->where('address', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('status', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('first_name', 'like', "%{$search}%")
                                      ->orWhere('last_name', 'like', "%{$search}%")
                                      ->orWhere('email', 'like', "%{$search}%");
                      });
            })
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        return view('admin.orders.show', compact('order'));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Xóa dữ liệu cũ để tránh trùng lặp
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_details')->truncate();
        DB::table('orders')->truncate();
        DB::table('cart')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Tạo Users
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '0123456789',
                'address' => '123 Admin Street',
                'date_of_birth' => '1985-05-10',
                'gender' => 'male',
                'is_active' => true,
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john' . rand(1000, 9999) . '@example.com', // Tránh trùng email
                'password' => Hash::make('password'),
                'role' => 'customer',
                'phone' => '0987654321',
                'address' => '456 Customer Avenue',
                'date_of_birth' => '1990-08-15',
                'gender' => 'male',
                'is_active' => true,
                'last_login' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);

        // Tạo Categories
        DB::table('categories')->insert([
            ['name' => 'Electronics', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Furniture', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Tạo Products
        DB::table('products')->insert([
            [
                'name' => 'Laptop',
                'category_id' => 1,
                'description' => 'High-end gaming laptop',
                'price' => 1500.00,
                'stock' => 10,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Office Chair',
                'category_id' => 2,
                'description' => 'Comfortable ergonomic chair',
                'price' => 200.00,
                'stock' => 20,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tạo Orders
        DB::table('orders')->insert([
            [
                'type' => 'normal',
                'user_id' => 2, // John Doe
                'total' => 1700.00,
                'status' => 'pending',
                'address' => '456 Customer Avenue',
                'phone' => '0987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tạo Order Details
        DB::table('order_details')->insert([
            [
                'order_id' => 1,
                'product_id' => 1, // Laptop
                'cost' => 1500.00,
                'quantity' => 1,
                'rental_start_date' => null,
                'rental_end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
            [
                'order_id' => 1,
                'product_id' => 2, // Office Chair (Rental)
                'cost' => 200.00,
                'quantity' => 1,
                'rental_start_date' => '2025-03-20',
                'rental_end_date' => '2025-04-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

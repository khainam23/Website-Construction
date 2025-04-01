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
        DB::table('carts')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
        Db::table('images')->truncate();
        DB::table('product_descriptions')->truncate();
        DB::table('product_inventories')->truncate();
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
                'updated_at' => now(),
                'email_verified_at' => now()
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
                'updated_at' => now(),
                'email_verified_at' => now()
            ],
        ]);

        // Tạo CategoriesF
        DB::table('categories')->insert([
            // Danh mục chính
            ['id' => 1, 'name' => 'Xe cẩu', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Xe tải', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Xe xúc', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Máy ủi', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()], // New category
            ['id' => 14, 'name' => 'Máy san gạt', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()], // New category

            // Danh mục con của Xe cẩu
            ['id' => 4, 'name' => 'Xe cẩu bánh xích', 'is_active' => true, 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Xe cẩu bánh lốp', 'is_active' => true, 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Xe cẩu tự hành', 'is_active' => true, 'parent_id' => 1, 'created_at' => now(), 'updated_at' => now()],

            // Danh mục con của Xe tải
            ['id' => 7, 'name' => 'Xe tải nhẹ', 'is_active' => true, 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Xe tải trung', 'is_active' => true, 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Xe tải nặng', 'is_active' => true, 'parent_id' => 2, 'created_at' => now(), 'updated_at' => now()],

            // Danh mục con của Xe xúc
            ['id' => 10, 'name' => 'Máy xúc mini', 'is_active' => true, 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Máy xúc đào', 'is_active' => true, 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Máy xúc lật', 'is_active' => true, 'parent_id' => 3, 'created_at' => now(), 'updated_at' => now()],

            // Danh mục con của Máy ủi
            ['id' => 15, 'name' => 'Máy ủi cỡ nhỏ', 'is_active' => true, 'parent_id' => 13, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Máy ủi cỡ lớn', 'is_active' => true, 'parent_id' => 13, 'created_at' => now(), 'updated_at' => now()],

            // Danh mục con của Máy san gạt
            ['id' => 17, 'name' => 'Máy san gạt tự hành', 'is_active' => true, 'parent_id' => 14, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Máy san gạt kéo', 'is_active' => true, 'parent_id' => 14, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Tạo Products
        DB::table('products')->insert([
            [
                'name' => 'Xe Tải Cẩu 8 Tấn Dongfeng 4 Chân',
                'category_id' => 9, // Xe tải nặng
                'description' => 'Xe tải cẩu 8 tấn Dongfeng 4 chân với sức nâng mạnh mẽ, phù hợp cho công trình lớn.',
                'avatar' => 'products/1.jpg',
                'price' => 150000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Mini 5 Tấn Komatsu LC785',
                'category_id' => 6, // Xe cẩu tự hành
                'description' => 'Cần cẩu mini 5 tấn, thích hợp cho không gian hẹp',
                'avatar' => 'products/2.jpg',
                'price' => 80000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Bánh Xích 10 Tấn Hitachi',
                'category_id' => 4, // Xe cẩu bánh xích
                'description' => 'Xe cẩu bánh xích chuyên dụng cho địa hình khó',
                'avatar' => 'products/3.jpg',
                'price' => 200000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Tự Hành 15 Tấn XCMG',
                'category_id' => 6, // Xe cẩu tự hành
                'description' => 'Xe cẩu tự hành công suất lớn',
                'avatar' => 'products/4.jpg',
                'price' => 250000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Gấp 3 Tấn Hyundai',
                'category_id' => 5, // Xe cẩu bánh lốp
                'description' => 'Xe cẩu gấp nhỏ gọn, linh hoạt',
                'avatar' => 'products/5.jpg',
                'price' => 120000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Container 45 Tấn Kalmar',
                'category_id' => 5, // Xe cẩu bánh lốp
                'description' => 'Xe cẩu container chuyên dụng cho cảng biển',
                'avatar' => 'products/6.jpg',
                'price' => 350000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Bánh Lốp 25 Tấn Grove',
                'category_id' => 5, // Xe cẩu bánh lốp
                'description' => 'Xe cẩu bánh lốp đa năng',
                'avatar' => 'products/7.jpg',
                'price' => 280000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Tháp 50 Tấn Potain',
                'category_id' => 6, // Xe cẩu tự hành
                'description' => 'Xe cẩu tháp cho công trình cao tầng',
                'avatar' => 'products/8.jpg',
                'price' => 400000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe cẩu 5 tấn mini Komatsu-LC785-6 - JCT Việt Nam',
                'category_id' => 1,
                'description' => 'Cần cẩu 5 tấn mini Komatsu-LC785-6 là dòng xe cẩu nhỏ chuyên để phục vụ nâng hạ hàng hóa trong kho xưởng hoặc trong những công trường có diện tích nhỏ và thấp. Cần trục mini 5 tấn được nhập khẩu trực tiếp từ Nhật Bản thông qua JCT Việt Nam, xe được bảo dưỡng toàn bộ hệ thống trước khi bàn giao.

                                Khách hàng có nhu cầu mua hoặc thuê xe cẩu vui lòng liên hệ JCT Việt Nam để nhận báo giá tốt nhất và nhanh nhất.

                                Khách hàng tham khảo thêm:

                                Địa chỉ bán xe cẩu nhỏ đa dạng tải trọng – giá rẻ bất ngờ

                                Sửa chữa hệ thống thủy lực xe cẩu – Công ty JCT Việt Nam',
                'avatar' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg',
                'price' => 20000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe cẩu 5 tấn mini Komatsu-LC785-6 - JCT Việt Nam',
                'category_id' => 1,
                'description' => 'Cần cẩu 5 tấn mini Komatsu-LC785-6 là dòng xe cẩu nhỏ chuyên để phục vụ nâng hạ hàng hóa trong kho xưởng hoặc trong những công trường có diện tích nhỏ và thấp. Cần trục mini 5 tấn được nhập khẩu trực tiếp từ Nhật Bản thông qua JCT Việt Nam, xe được bảo dưỡng toàn bộ hệ thống trước khi bàn giao.

                                Khách hàng có nhu cầu mua hoặc thuê xe cẩu vui lòng liên hệ JCT Việt Nam để nhận báo giá tốt nhất và nhanh nhất.

                                Khách hàng tham khảo thêm:

                                Địa chỉ bán xe cẩu nhỏ đa dạng tải trọng – giá rẻ bất ngờ

                                Sửa chữa hệ thống thủy lực xe cẩu – Công ty JCT Việt Nam',
                'avatar' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg',
                'price' => 20000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Máy Ủi Caterpillar D6',
                'category_id' => 16, // Máy ủi cỡ lớn
                'description' => 'Máy ủi Caterpillar D6 mạnh mẽ và bền bỉ.',
                'avatar' => 'products/11.jpg',
                'price' => 550000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Máy San Gạt John Deere 672G',
                'category_id' => 17, // Máy san gạt tự hành
                'description' => 'Máy san gạt John Deere 672G hiệu suất cao.',
                'avatar' => 'products/12.jpg',
                'price' => 620000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Tải Cẩu 8 Tấn Dongfeng 4 Chân',
                'category_id' => 9, // Xe tải nặng
                'description' => 'Xe tải cẩu 8 tấn Dongfeng 4 chân với sức nâng mạnh mẽ, phù hợp cho công trình lớn.',
                'avatar' => 'products/1.jpg',
                'price' => 150000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Mini 5 Tấn Komatsu LC785',
                'category_id' => 6, // Xe cẩu tự hành
                'description' => 'Cần cẩu mini 5 tấn, thích hợp cho không gian hẹp',
                'avatar' => 'products/2.jpg',
                'price' => 80000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Bánh Xích 10 Tấn Hitachi',
                'category_id' => 4, // Xe cẩu bánh xích
                'description' => 'Xe cẩu bánh xích chuyên dụng cho địa hình khó',
                'avatar' => 'products/3.jpg',
                'price' => 200000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Tự Hành 15 Tấn XCMG',
                'category_id' => 6, // Xe cẩu tự hành
                'description' => 'Xe cẩu tự hành công suất lớn',
                'avatar' => 'products/4.jpg',
                'price' => 250000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Gấp 3 Tấn Hyundai',
                'category_id' => 5, // Xe cẩu bánh lốp
                'description' => 'Xe cẩu gấp nhỏ gọn, linh hoạt',
                'avatar' => 'products/5.jpg',
                'price' => 120000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Container 45 Tấn Kalmar',
                'category_id' => 5, // Xe cẩu bánh lốp
                'description' => 'Xe cẩu container chuyên dụng cho cảng biển',
                'avatar' => 'products/6.jpg',
                'price' => 350000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Bánh Lốp 25 Tấn Grove',
                'category_id' => 5, // Xe cẩu bánh lốp
                'description' => 'Xe cẩu bánh lốp đa năng',
                'avatar' => 'products/7.jpg',
                'price' => 280000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe Cẩu Tháp 50 Tấn Potain',
                'category_id' => 6, // Xe cẩu tự hành
                'description' => 'Xe cẩu tháp cho công trình cao tầng',
                'avatar' => 'products/8.jpg',
                'price' => 400000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe cẩu 5 tấn mini Komatsu-LC785-6 - JCT Việt Nam',
                'category_id' => 1,
                'description' => 'Cần cẩu 5 tấn mini Komatsu-LC785-6 là dòng xe cẩu nhỏ chuyên để phục vụ nâng hạ hàng hóa trong kho xưởng hoặc trong những công trường có diện tích nhỏ và thấp. Cần trục mini 5 tấn được nhập khẩu trực tiếp từ Nhật Bản thông qua JCT Việt Nam, xe được bảo dưỡng toàn bộ hệ thống trước khi bàn giao.

                                Khách hàng có nhu cầu mua hoặc thuê xe cẩu vui lòng liên hệ JCT Việt Nam để nhận báo giá tốt nhất và nhanh nhất.

                                Khách hàng tham khảo thêm:

                                Địa chỉ bán xe cẩu nhỏ đa dạng tải trọng – giá rẻ bất ngờ

                                Sửa chữa hệ thống thủy lực xe cẩu – Công ty JCT Việt Nam',
                'avatar' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg',
                'price' => 20000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Xe cẩu 5 tấn mini Komatsu-LC785-6 - JCT Việt Nam',
                'category_id' => 1,
                'description' => 'Cần cẩu 5 tấn mini Komatsu-LC785-6 là dòng xe cẩu nhỏ chuyên để phục vụ nâng hạ hàng hóa trong kho xưởng hoặc trong những công trường có diện tích nhỏ và thấp. Cần trục mini 5 tấn được nhập khẩu trực tiếp từ Nhật Bản thông qua JCT Việt Nam, xe được bảo dưỡng toàn bộ hệ thống trước khi bàn giao.

                                Khách hàng có nhu cầu mua hoặc thuê xe cẩu vui lòng liên hệ JCT Việt Nam để nhận báo giá tốt nhất và nhanh nhất.

                                Khách hàng tham khảo thêm:

                                Địa chỉ bán xe cẩu nhỏ đa dạng tải trọng – giá rẻ bất ngờ

                                Sửa chữa hệ thống thủy lực xe cẩu – Công ty JCT Việt Nam',
                'avatar' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg',
                'price' => 20000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Máy Ủi Caterpillar D6',
                'category_id' => 16, // Máy ủi cỡ lớn
                'description' => 'Máy ủi Caterpillar D6 mạnh mẽ và bền bỉ.',
                'avatar' => 'products/11.jpg',
                'price' => 550000,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Máy San Gạt John Deere 672G',
                'category_id' => 17, // Máy san gạt tự hành
                'description' => 'Máy san gạt John Deere 672G hiệu suất cao.',
                'avatar' => 'products/12.jpg',
                'price' => 620000,
                'type' => 'rental',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tạo giá trị lưu kho
        DB::table('product_inventories')->insert([
            [
                'product_id' => 1,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 6,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 7,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 8,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 9,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 10,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 11,
                'type' => 'sale',
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 12,
                'type' => 'rental',
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 13,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 14,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 15,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 16,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 17,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 18,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 19,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 20,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 21,
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 22,
                'type' => 'sale',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 23,
                'type' => 'sale',
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 24,
                'type' => 'rental',
                'quantity' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Tạo Product Descriptions
        DB::table('product_descriptions')->insert([
            [
                'product_id' => 1,
                'infomations' => 'Xe tải cẩu 8 tấn Dongfeng 4 chân là sự kết hợp hoàn hảo giữa khả năng vận chuyển và nâng hạ hàng hóa. Được sản xuất theo tiêu chuẩn quốc tế.',
                'features' => '- Sức nâng tối đa: 8000 kg
                      - Chiều dài cần: 12m
                      - Động cơ: Cummins 315HP
                      - Hệ thống thủy lực Soosan
                      - Cabin kép tiện nghi',
                'applications' => 'Phù hợp cho các công trình xây dựng lớn, vận chuyển vật liệu nặng, lắp đặt thiết bị công nghiệp.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2,
                'infomations' => 'Xe cẩu mini Komatsu LC785 là giải pháp tối ưu cho các không gian làm việc hạn chế. Thiết kế nhỏ gọn nhưng mạnh mẽ.',
                'features' => '- Tải trọng nâng: 5000 kg
                      - Bán kính hoạt động: 8m
                      - Động cơ tiết kiệm nhiên liệu
                      - Hệ thống điều khiển thông minh
                      - Độ ổn định cao',
                'applications' => 'Sử dụng trong nhà xưởng, công trình đô thị, khu vực không gian hẹp.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 3,
                'infomations' => 'Xe cẩu bánh xích Hitachi 10 tấn là thiết bị chuyên dụng cho các địa hình phức tạp. Được trang bị công nghệ tiên tiến và hệ thống an toàn đáng tin cậy.',
                'features' => '- Tải trọng nâng tối đa: 10000 kg
                      - Chiều cao nâng tối đa: 30m
                      - Hệ thống bánh xích bền bỉ
                      - Cabin điều khiển 360 độ
                      - Hệ thống cân bằng tự động',
                'applications' => 'Thích hợp cho các công trình xây dựng có địa hình khó khăn, khu vực đồi núi, và các dự án cơ sở hạ tầng.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 4,
                'infomations' => 'Xe cẩu tự hành XCMG 15 tấn là sự kết hợp hoàn hảo giữa công nghệ hiện đại và độ tin cậy cao. Thiết kế đa năng cho nhiều mục đích sử dụng.',
                'features' => '- Sức nâng tối đa: 15000 kg
                      - Chiều dài cần: 47m
                      - Hệ thống điều khiển thông minh
                      - Động cơ tiết kiệm nhiên liệu
                      - Hệ thống an toàn tích hợp',
                'applications' => 'Phù hợp cho các công trình xây dựng cao tầng, lắp đặt thiết bị công nghiệp, và các dự án cơ sở hạ tầng quy mô lớn.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 5,
                'infomations' => 'Xe cẩu gấp Hyundai 3 tấn là thiết bị đa năng với thiết kế gọn nhẹ. Khả năng vận hành linh hoạt và hiệu quả cao.',
                'features' => '- Tải trọng: 3000 kg
                      - Bán kính hoạt động: 8m
                      - Cần gấp thông minh
                      - Hệ thống điều khiển từ xa
                      - Tiết kiệm không gian',
                'applications' => 'Thích hợp cho các công việc trong đô thị, khu công nghiệp, và các dự án xây dựng nhỏ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // ... continue with existing entries ...
        ]);

        // Ảnh cho sản phẩm
        DB::table('images')->insert([
            // Product 1 - 3 images
            ['product_id' => 1, 'path' => 'products/1.jpg'],
            ['product_id' => 1, 'path' => 'products/2.jpg'],
            ['product_id' => 1, 'path' => 'products/3.jpg'],

            // Product 2 - 2 images
            ['product_id' => 2, 'path' => 'products/4.jpg'],
            ['product_id' => 2, 'path' => 'products/5.jpg'],

            // Product 3 - 4 images
            ['product_id' => 3, 'path' => 'products/6.jpg'],
            ['product_id' => 3, 'path' => 'products/7.jpg'],
            ['product_id' => 3, 'path' => 'products/8.jpg'],
            ['product_id' => 3, 'path' => 'products/9.jpg'],

            // Product 4 - 1 image
            ['product_id' => 4, 'path' => 'products/10.jpg'],

            // Product 5 - 5 images
            ['product_id' => 5, 'path' => 'products/1.jpg'],
            ['product_id' => 5, 'path' => 'products/2.jpg'],
            ['product_id' => 5, 'path' => 'products/3.jpg'],
            ['product_id' => 5, 'path' => 'products/4.jpg'],
            ['product_id' => 5, 'path' => 'products/5.jpg'],

            // Product 6 - 2 images
            ['product_id' => 6, 'path' => 'products/6.jpg'],
            ['product_id' => 6, 'path' => 'products/7.jpg'],

            // Product 7 - 3 images
            ['product_id' => 7, 'path' => 'products/8.jpg'],
            ['product_id' => 7, 'path' => 'products/9.jpg'],
            ['product_id' => 7, 'path' => 'products/10.jpg'],

            // Product 8 - 4 images
            ['product_id' => 8, 'path' => 'products/1.jpg'],
            ['product_id' => 8, 'path' => 'products/2.jpg'],
            ['product_id' => 8, 'path' => 'products/3.jpg'],
            ['product_id' => 8, 'path' => 'products/4.jpg'],

            // Product 9 - 1 image
            ['product_id' => 9, 'path' => 'products/5.jpg'],

            // Product 10 - 3 images
            ['product_id' => 10, 'path' => 'products/6.jpg'],
            ['product_id' => 10, 'path' => 'products/7.jpg'],
            ['product_id' => 10, 'path' => 'products/8.jpg'],

            // Product 11 - 2 images
            ['product_id' => 11, 'path' => 'products/9.jpg'],
            ['product_id' => 11, 'path' => 'products/10.jpg'],

            // Product 12 - 3 images
            ['product_id' => 12, 'path' => 'products/11.jpg'],
            ['product_id' => 12, 'path' => 'products/12.jpg'],
            ['product_id' => 12, 'path' => 'products/1.jpg'],

            // Product 13 - 3 images
            ['product_id' => 13, 'path' => 'products/2.jpg'],
            ['product_id' => 13, 'path' => 'products/3.jpg'],
            ['product_id' => 13, 'path' => 'products/4.jpg'],

            // Product 14 - 2 images
            ['product_id' => 14, 'path' => 'products/5.jpg'],
            ['product_id' => 14, 'path' => 'products/6.jpg'],

            // Product 15 - 3 images
            ['product_id' => 15, 'path' => 'products/7.jpg'],
            ['product_id' => 15, 'path' => 'products/8.jpg'],
            ['product_id' => 15, 'path' => 'products/9.jpg'],

            // Product 16 - 2 images
            ['product_id' => 16, 'path' => 'products/10.jpg'],
            ['product_id' => 16, 'path' => 'products/11.jpg'],

            // Product 17 - 3 images
            ['product_id' => 17, 'path' => 'products/12.jpg'],
            ['product_id' => 17, 'path' => 'products/1.jpg'],
            ['product_id' => 17, 'path' => 'products/2.jpg'],

            // Product 18 - 2 images
            ['product_id' => 18, 'path' => 'products/3.jpg'],
            ['product_id' => 18, 'path' => 'products/4.jpg'],

            // Product 19 - 3 images
            ['product_id' => 19, 'path' => 'products/5.jpg'],
            ['product_id' => 19, 'path' => 'products/6.jpg'],
            ['product_id' => 19, 'path' => 'products/7.jpg'],

            // Product 20 - 2 images
            ['product_id' => 20, 'path' => 'products/8.jpg'],
            ['product_id' => 20, 'path' => 'products/9.jpg'],

            // Product 21 - 3 images
            ['product_id' => 21, 'path' => 'products/10.jpg'],
            ['product_id' => 21, 'path' => 'products/11.jpg'],
            ['product_id' => 21, 'path' => 'products/12.jpg'],

            // Product 22 - 2 images
            ['product_id' => 22, 'path' => 'products/1.jpg'],
            ['product_id' => 22, 'path' => 'products/2.jpg'],

            // Product 23 - 3 images
            ['product_id' => 23, 'path' => 'products/3.jpg'],
            ['product_id' => 23, 'path' => 'products/4.jpg'],
            ['product_id' => 23, 'path' => 'products/5.jpg'],

            // Product 24 - 2 images
            ['product_id' => 24, 'path' => 'products/6.jpg'],
            ['product_id' => 24, 'path' => 'products/7.jpg'],
        ]);

        // Tạo Orders
        DB::table('orders')->insert([
            [
                'type' => 'normal',
                'user_id' => 2, // John Doe
                'total' => 1700.00,
                'status' => 'confirm',
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
                'product_id' => 1,
                'cost' => 1500.00,
                'quantity' => 1,
                'rental_start_date' => null,
                'rental_end_date' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => 1,
                'product_id' => 2,
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
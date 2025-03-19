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
            ['name' => 'Xe cẩu', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Tạo Products
        DB::table('products')->insert([
            [
                'name' => 'Xe Tải Cẩu 8 Tấn Dongfeng 4 Chân 13.7 Tấn',
                'category_id' => 1,
                'description' => '- Sức nâng tối đa: 8100 kg
                                - Sức nâng tầm với lớn nhất: 8100 kg/2.0 m
                                - Sức nâng tầm với trung bình: Trung bình: 2700 kg/6.0 m – 1050 kg/12.0 m
                                - Sức nâng nhở nhất tầm với xa nhất: 400 kg/20.3 m
                                - Bán kính làm việc tối đa: 20.3 m
                                - Chiều cao làm việc tối đa: 23.3 m
                                - Trọng lượng bản thân: 16.170 kg
                                - Tải trọng cho phép chở: 13.700 kg
                                - Số người cho phép chở: 2 người
                                - Trọng lượng toàn bộ: 30.000 kg
                                - Kích thước xe (D x R x C): 11.640 x 2.500 x 3.880 mm
                                - Kích thước lòng thùng hàng: 8.300 x 2.350 x 650 mm',
                'avatar' => 'https://xetaiphuman.vn/uploads/images/products-images/xe-cau-8-tan.jpg',
                'price' => 1500.00,
                'type' => 'sale',
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
                'price' => 200.00,
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
                'price' => 200.00,
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
                'price' => 200.00,
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
                'price' => 200.00,
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
                'price' => 200.00,
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
                'price' => 200.00,
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
                'type' => 'rental',
                'quantity' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);

        // Tạo Product Descriptions
        DB::table('product_descriptions')->insert([
            [
                'product_id' => 1, // Gắn với sản phẩm đầu tiên
                'infomations' => 'Xe tải cẩu 8 tấn Dongfeng với sức nâng mạnh mẽ, phù hợp cho công trình lớn.',
                'features' => '- Sức nâng tối đa: 8100 kg
                      - Bán kính làm việc tối đa: 20.3 m
                      - Trọng lượng toàn bộ: 30.000 kg',
                'applications' => 'Sử dụng để vận chuyển hàng hóa nặng, lắp ráp công trình, và xây dựng cầu đường.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 2, // Gắn với sản phẩm thứ hai
                'infomations' => 'Xe cẩu mini 5 tấn Komatsu nhỏ gọn, thích hợp cho kho xưởng và công trình nhỏ.',
                'features' => '- Công suất nâng tối đa: 5000 kg
                      - Nhập khẩu nguyên chiếc từ Nhật Bản
                      - Hệ thống thủy lực tiên tiến',
                'applications' => 'Dùng để nâng hạ hàng hóa trong nhà kho, công trường có diện tích nhỏ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Ảnh cho sản phẩm
        DB::table('images')->insert([
            [
                'product_id'=> 1,
                'path' => 'https://xetaiphuman.vn/uploads/images/products-images/xe-cau-8-tan.jpg'
            ],
            [
                'product_id'=> 1,
                'path' => 'https://banxetai.com.vn/Images/SanPham/NLB_xe-4-chan-dongfeng-hoang-huy-gan-cau-8-tan-kanglim.jpg'
            ],
            [
                'product_id'=> 1,
                'path' => 'https://www.xechuyendungmienbac.com/uploads/data/3119/imgproducts/dongfeng-4-chan-kanglim-ks5206-15-tan%20(2).jpg'
            ],
            [
                'product_id'=> 2,
                'path' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg'
            ],
            [
                'product_id'=> 3,
                'path' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg'
            ],
            [
                'product_id'=> 4,
                'path' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg'
            ],
            [
                'product_id'=> 5,
                'path' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg'
            ],
            [
                'product_id'=> 6,
                'path' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg'
            ],
            [
                'product_id'=> 7,
                'path' => 'https://jct.com.vn/wp-content/uploads/2021/10/xe-cau-mini-5-tan-komatsu-lc785-6-1-.jpg'
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

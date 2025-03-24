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
<<<<<<< Updated upstream
            ['name' => 'Xe cẩu', 'is_active' => true, 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
=======
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
>>>>>>> Stashed changes
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
            [
                'name' => 'Máy Ủi Caterpillar D6',
                'category_id' => 16, // Máy ủi cỡ lớn
                'description' => 'Máy ủi Caterpillar D6 mạnh mẽ và bền bỉ.',
                'avatar' => 'products/11.jpg',
                'price' => 5500.00,
                'type' => 'sale',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Máy San Gạt John Deere 672G',
                'category_id' => 17, // Máy san gạt tự hành
                'description' => 'Máy san gạt John Deere 672G hiệu suất cao.',
                'avatar' => 'products/12.jpg',
                'price' => 6200.00,
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
<<<<<<< Updated upstream
            
=======
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
>>>>>>> Stashed changes
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
            [
                'product_id' => 11,
                'infomations' => 'Máy ủi Caterpillar D6 là sự lựa chọn hàng đầu cho các công trình lớn. Với sức mạnh vượt trội và độ bền cao, nó đáp ứng mọi yêu cầu công việc.',
                'features' => '- Động cơ mạnh mẽ Caterpillar
                            - Lưỡi ủi lớn, hiệu suất cao
                            - Hệ thống điều khiển hiện đại
                            - Khả năng làm việc liên tục
                            - Bảo trì dễ dàng',
                'applications' => 'Sử dụng trong các công trình xây dựng đường, san lấp mặt bằng, khai thác mỏ.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 12,
                'infomations' => 'Máy san gạt John Deere 672G là thiết bị không thể thiếu cho việc duy trì và xây dựng đường. Độ chính xác cao và khả năng vận hành linh hoạt.',
                'features' => '- Hệ thống lái tự động
                            - Lưỡi san có thể điều chỉnh
                            - Động cơ tiết kiệm nhiên liệu
                            - Cabin thoải mái cho người vận hành
                            - Dễ dàng bảo trì',
                'applications' => 'Dùng để san lấp đường, làm phẳng bề mặt, và duy trì đường sá.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Ảnh cho sản phẩm
        DB::table('images')->insert([
<<<<<<< Updated upstream
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

=======
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
        ]);

>>>>>>> Stashed changes
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

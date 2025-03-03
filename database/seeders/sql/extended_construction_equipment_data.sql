-- Thêm danh mục con
INSERT INTO categories (id, name, slug, description, is_active, parent_id, `order`, image, created_at, updated_at) VALUES
-- Con của Thiết bị đào đất (id: 1)
(6, 'Máy đào bánh xích', 'may-dao-banh-xich', 'Máy đào chuyên dụng sử dụng bánh xích', 1, 1, 1, 'https://example.com/images/excavator.jpg', NOW(), NOW()),
(7, 'Máy xúc lật', 'may-xuc-lat', 'Máy xúc lật đa năng', 1, 1, 2, 'https://example.com/images/loader.jpg', NOW(), NOW()),
(8, 'Máy đào mini', 'may-dao-mini', 'Máy đào cỡ nhỏ cho công trình hẹp', 1, 1, 3, 'https://example.com/images/mini-excavator.jpg', NOW(), NOW()),

-- Con của Thiết bị nâng (id: 2)
(9, 'Cẩu tháp', 'cau-thap', 'Cẩu tháp các loại', 1, 2, 1, 'https://example.com/images/tower-crane.jpg', NOW(), NOW()),
(10, 'Xe nâng', 'xe-nang', 'Xe nâng hàng các loại', 1, 2, 2, 'https://example.com/images/forklift.jpg', NOW(), NOW()),
(11, 'Pa lăng và tời', 'pa-lang-va-toi', 'Thiết bị nâng dạng cáp', 1, 2, 3, 'https://example.com/images/hoist.jpg', NOW(), NOW()),

-- Con của Thiết bị bê tông (id: 3)
(12, 'Máy trộn bê tông', 'may-tron-be-tong', 'Thiết bị trộn bê tông', 1, 3, 1, 'https://example.com/images/concrete-mixer.jpg', NOW(), NOW()),
(13, 'Máy bơm bê tông', 'may-bom-be-tong', 'Thiết bị bơm bê tông', 1, 3, 2, 'https://example.com/images/concrete-pump.jpg', NOW(), NOW()),
(14, 'Máy xoa nền', 'may-xoa-nen', 'Thiết bị hoàn thiện bề mặt', 1, 3, 3, 'https://example.com/images/power-trowel.jpg', NOW(), NOW());

-- Cập nhật thiết bị với hình ảnh và chi tiết hơn
UPDATE devices SET 
    image = 'https://example.com/images/komatsu-pc200.jpg',
    description = 'Máy đào bánh xích Komatsu PC200-8, công suất 150HP, trọng lượng 20 tấn, gầu xúc 0.8m³, chiều sâu đào tối đa 6.6m, cabin điều hòa, màn hình LCD'
WHERE name = 'Máy đào Komatsu PC200-8';

UPDATE devices SET 
    image = 'https://example.com/images/cat-950gc.jpg',
    description = 'Máy xúc lật Caterpillar 950GC, động cơ Cat C7.1, công suất 225HP, gầu xúc 5m³, tải trọng nâng 8 tấn, cabin điều hòa, hệ thống cân điện tử'
WHERE name = 'Máy xúc lật Caterpillar 950GC';

-- Thêm thiết bị mới với category con
INSERT INTO devices (name, category_id, description, price, stock, image, created_at, updated_at) VALUES
-- Máy đào bánh xích (category_id: 6)
('Máy đào Hitachi ZX350LC', 6, 'Máy đào 35 tấn, công suất 270HP, gầu 1.6m³, độ sâu đào 7.3m', 3500000000, 1, 'https://example.com/images/hitachi-zx350.jpg', NOW(), NOW()),
('Máy đào Doosan DX300LC', 6, 'Máy đào 30 tấn, động cơ Doosan DB58TIS, cabin lớn', 2800000000, 2, 'https://example.com/images/doosan-dx300.jpg', NOW(), NOW()),

-- Xe nâng (category_id: 10)
('Xe nâng điện BT Staxio', 10, 'Xe nâng điện 2 tấn, độ nâng 4.5m, sạc nhanh', 450000000, 3, 'https://example.com/images/bt-staxio.jpg', NOW(), NOW()),
('Xe nâng TCM FD50T9', 10, 'Xe nâng dầu 5 tấn, động cơ Isuzu, cabin kín', 850000000, 2, 'https://example.com/images/tcm-fd50.jpg', NOW(), NOW()),

-- Máy trộn bê tông (category_id: 12)
('Máy trộn Liebherr 2.5', 12, 'Máy trộn tự hành 2.5m³, hệ thống cân điện tử', 980000000, 2, 'https://example.com/images/liebherr-mixer.jpg', NOW(), NOW()),
('Máy trộn Hino 238', 12, 'Bồn trộn 7m³, chassis Hino 238', 1200000000, 1, 'https://example.com/images/hino-mixer.jpg', NOW(), NOW());

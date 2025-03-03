
-- Thêm danh mục thiết bị công trình
INSERT INTO categories (id, name, slug, description, is_active, parent_id, `order`, created_at, updated_at) VALUES
(1, 'Thiết bị đào đất', 'thiet-bi-dao-dat', 'Các loại máy đào, xúc đất', 1, NULL, 1, NOW(), NOW()),
(2, 'Thiết bị nâng', 'thiet-bi-nang', 'Thiết bị nâng hạ vật liệu', 1, NULL, 2, NOW(), NOW()),
(3, 'Thiết bị bê tông', 'thiet-bi-be-tong', 'Thiết bị trộn và vận chuyển bê tông', 1, NULL, 3, NOW(), NOW()),
(4, 'Máy đầm nén', 'may-dam-nen', 'Thiết bị đầm nén đất, bê tông', 1, NULL, 4, NOW(), NOW()),
(5, 'Dụng cụ cầm tay', 'dung-cu-cam-tay', 'Các loại dụng cụ điện cầm tay', 1, NULL, 5, NOW(), NOW());

-- Thêm thiết bị công trình
INSERT INTO devices (name, category_id, description, price, stock, created_at, updated_at) VALUES
-- Thiết bị đào đất
('Máy đào Komatsu PC200-8', 1, 'Máy đào bánh xích 20 tấn, công suất 150HP', 2150000000, 3, NOW(), NOW()),
('Máy xúc lật Caterpillar 950GC', 1, 'Máy xúc lật 5 khối, động cơ Cat C7.1', 1850000000, 2, NOW(), NOW()),
('Máy đào mini Kubota U17-3α', 1, 'Máy đào mini 1.7 tấn, phù hợp công trình nhỏ', 450000000, 5, NOW(), NOW()),
('Máy ủi Shantui SD16', 1, 'Máy ủi công suất 160HP, lưỡi ủi 3.97m', 1650000000, 2, NOW(), NOW()),

-- Thiết bị nâng
('Cẩu tháp Potain MCT 85', 2, 'Cẩu tháp tải trọng 5 tấn, chiều cao 42m', 2850000000, 1, NOW(), NOW()),
('Xe nâng hàng Toyota 8FD30', 2, 'Xe nâng dầu 3 tấn, độ nâng cao 3m', 580000000, 4, NOW(), NOW()),
('Pa lăng điện 2 tấn Vital', 2, 'Pa lăng điện độ cao nâng 12m, điện 380V', 15000000, 8, NOW(), NOW()),
('Vận thăng lồng TCMT SC100', 2, 'Vận thăng lồng tải trọng 1 tấn, cao 120m', 168000000, 3, NOW(), NOW()),

-- Thiết bị bê tông
('Máy trộn bê tông Carmix 3.5TT', 3, 'Máy trộn tự hành 3.5 khối, 4x4', 1250000000, 2, NOW(), NOW()),
('Bơm bê tông Putzmeister BSF 36.4', 3, 'Bơm bê tông cần dài 36m, công suất 160m³/h', 3500000000, 1, NOW(), NOW()),
('Máy xoa nền bê tông Dynamic DE36', 3, 'Máy xoa nền đường kính 90cm, động cơ Honda', 25000000, 10, NOW(), NOW()),
('Máy băm bê tông Hilti TE 3000-AVR', 3, 'Máy đục phá bê tông công suất 2070W', 85000000, 6, NOW(), NOW()),

-- Máy đầm nén
('Máy lu rung Hamm HD12VV', 4, 'Lu rung 3 tấn, động cơ Kubota', 850000000, 3, NOW(), NOW()),
('Đầm cóc Mikasa MT-76D', 4, 'Đầm cóc 75kg, động cơ Robin EH12-2D', 28000000, 15, NOW(), NOW()),
('Máy đầm dùi Jinlong ZN70', 4, 'Đầm dùi điện 1.5KW, đường kính 70mm', 3500000, 20, NOW(), NOW()),
('Máy đầm bàn Masalta MS160', 4, 'Đầm bàn động cơ Honda GX160', 12500000, 12, NOW(), NOW()),

-- Dụng cụ cầm tay
('Máy khoan bê tông Bosch GBH 8-45D', 5, 'Khoan búa 1500W, lực đập 12.5J', 18500000, 8, NOW(), NOW()),
('Máy cắt bê tông Makita 4112HS', 5, 'Máy cắt 2400W, đĩa 305mm', 15200000, 10, NOW(), NOW()),
('Máy hàn điện tử Hồng Ký HK200A', 5, 'Máy hàn inverter 200A, điện áp 220V', 4500000, 15, NOW(), NOW()),
('Máy mài góc Dewalt DWE4060', 5, 'Máy mài 1200W, đĩa 100mm', 2800000, 25, NOW(), NOW());

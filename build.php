<?php

echo "📦 Cài đặt các dependency với Composer...\n";
shell_exec("composer install --no-interaction --prefer-dist");
echo "✅ Composer install hoàn tất!\n";

// Lấy thông tin database từ .env
$dotenv = parse_ini_file('.env');
$dbHost = $dotenv['DB_HOST'] ?? '127.0.0.1';
$dbPort = $dotenv['DB_PORT'] ?? '3306';
$dbName = $dotenv['DB_DATABASE'] ?? 'laravel';
$dbUser = $dotenv['DB_USERNAME'] ?? 'root';
$dbPass = $dotenv['DB_PASSWORD'] ?? '';

// Kiểm tra kết nối MySQL và tạo database nếu chưa có
echo "🔍 Kiểm tra database '$dbName'...\n";
$conn = new mysqli($dbHost, $dbUser, $dbPass, "", $dbPort);

if ($conn->connect_error) {
    die("❌ Không thể kết nối MySQL: " . $conn->connect_error . "\n");
}

// Tạo database nếu chưa có
$sql = "CREATE DATABASE IF NOT EXISTS `$dbName`";
if ($conn->query($sql) === TRUE) {
    echo "✅ Database '$dbName' đã sẵn sàng!\n";
} else {
    die("❌ Lỗi tạo database: " . $conn->error . "\n");
}
$conn->close();

echo "🔄 Đang dọn dẹp cache Laravel...\n";
$commands = ['cache:clear', 'config:clear', 'route:clear', 'view:clear', 'event:clear', 'optimize:clear'];

foreach ($commands as $command) {
    echo "➡️ Chạy: php artisan $command\n";
    shell_exec("php artisan $command");
}

echo "✅ Dọn dẹp cache hoàn tất!\n";

echo "🔄 Đang chạy migration...\n";
$migrateOutput = shell_exec("php artisan migrate --force 2>&1");
sleep(2); // Đợi 4 giây để chắc chắn migration hoàn tất
echo $migrateOutput; // In ra log migration để kiểm tra
echo "✅ Migration hoàn tất!\n";

echo "🔄 Đang chạy seeder...\n";
$seederOutput = shell_exec("php artisan db:seed --force 2>&1");
echo $seederOutput; // In ra log seeder để kiểm tra

echo "✅ Seeder hoàn tất!\n";
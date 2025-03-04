<?php

echo "🔄 Đang dọn dẹp cache Laravel...\n";

// Danh sách lệnh cần chạy
$commands = [
    'cache:clear',
    'config:clear',
    'route:clear',
    'view:clear',
    'event:clear',
    'optimize:clear'
];

// Chạy từng lệnh artisan
foreach ($commands as $command) {
    echo "➡️ Chạy: php artisan $command\n";
    shell_exec("php artisan $command");
}

echo "✅ Dọn dẹp cache hoàn tất!\n";
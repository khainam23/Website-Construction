<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SqlFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Đọc và chạy file SQL 1
        $sql1 = File::get(database_path('\seeders\sql\construction_equipment_data.sql'));
        DB::unprepared($sql1);
        echo "✅ Thêm dữ liệu!\n";

        // Đọc và chạy file SQL 2
        $sql2 = File::get(database_path('\seeders\sql\extended_construction_equipment_data.sql'));
        DB::unprepared($sql2);
        echo "✅ Thêm dữ liệu!\n";
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert([
            ['id' => 1, 'role_id' => 11, 'page_id' => 1, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 2, 'role_id' => 11, 'page_id' => 2, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 3, 'role_id' => 11, 'page_id' => 3, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 4, 'role_id' => 11, 'page_id' => 4, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            // ['id' => 5, 'role_id' => 11, 'page_id' => 5, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 6, 'role_id' => 11, 'page_id' => 6, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 7, 'role_id' => 11, 'page_id' => 8, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 8, 'role_id' => 11, 'page_id' => 12, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 9, 'role_id' => 11, 'page_id' => 15, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 10, 'role_id' => 11, 'page_id' => 17, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 11, 'role_id' => 11, 'page_id' => 19, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 12, 'role_id' => 11, 'page_id' => 21, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 13, 'role_id' => 11, 'page_id' => 24, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 14, 'role_id' => 11, 'page_id' => 11, 'created_at' => '2022-06-02 07:30:00', 'updated_at' => '2022-06-02 07:30:00'],
            ['id' => 15, 'role_id' => 11, 'page_id' => 25, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 16, 'role_id' => 11, 'page_id' => 26, 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 1342, 'role_id' => 14, 'page_id' => 1, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1343, 'role_id' => 14, 'page_id' => 2, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1344, 'role_id' => 14, 'page_id' => 4, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1345, 'role_id' => 14, 'page_id' => 19, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1346, 'role_id' => 14, 'page_id' => 11, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1347, 'role_id' => 14, 'page_id' => 6, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1348, 'role_id' => 13, 'page_id' => 1, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1349, 'role_id' => 13, 'page_id' => 2, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1350, 'role_id' => 13, 'page_id' => 4, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1351, 'role_id' => 13, 'page_id' => 19, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1352, 'role_id' => 13, 'page_id' => 11, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1353, 'role_id' => 13, 'page_id' => 6, 'created_at' => '2023-07-23 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 1354, 'role_id' => 15, 'page_id' => 1, 'created_at' => '2024-01-11 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
            ['id' => 1355, 'role_id' => 15, 'page_id' => 2, 'created_at' => '2024-01-11 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
            ['id' => 1356, 'role_id' => 15, 'page_id' => 4, 'created_at' => '2024-01-11 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
            ['id' => 1357, 'role_id' => 15, 'page_id' => 19, 'created_at' => '2024-01-11 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
            ['id' => 1358, 'role_id' => 15, 'page_id' => 11, 'created_at' => '2024-01-11 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
            ['id' => 1359, 'role_id' => 15, 'page_id' => 6, 'created_at' => '2024-01-11 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
        ]);
    }
}

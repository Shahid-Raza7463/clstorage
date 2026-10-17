<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaverolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('leaveroles')->insert([
            ['id' => 26, 'leavetype_id' => 8, 'role' => 14, 'created_at' => null, 'updated_at' => null],
            ['id' => 27, 'leavetype_id' => 10, 'role' => 14, 'created_at' => null, 'updated_at' => null],
            ['id' => 28, 'leavetype_id' => 9, 'role' => 14, 'created_at' => null, 'updated_at' => null],
            ['id' => 29, 'leavetype_id' => 8, 'role' => 18, 'created_at' => null, 'updated_at' => null],
            ['id' => 30, 'leavetype_id' => 10, 'role' => 18, 'created_at' => null, 'updated_at' => null],
            ['id' => 31, 'leavetype_id' => 9, 'role' => 18, 'created_at' => null, 'updated_at' => null],
            ['id' => 32, 'leavetype_id' => 8, 'role' => 17, 'created_at' => null, 'updated_at' => null],
            ['id' => 33, 'leavetype_id' => 9, 'role' => 17, 'created_at' => null, 'updated_at' => null],
            ['id' => 34, 'leavetype_id' => 10, 'role' => 17, 'created_at' => null, 'updated_at' => null],
            ['id' => 35, 'leavetype_id' => 8, 'role' => 15, 'created_at' => null, 'updated_at' => null],
            ['id' => 36, 'leavetype_id' => 9, 'role' => 15, 'created_at' => null, 'updated_at' => null],
            ['id' => 37, 'leavetype_id' => 10, 'role' => 15, 'created_at' => null, 'updated_at' => null],
            ['id' => 38, 'leavetype_id' => 11, 'role' => 15, 'created_at' => null, 'updated_at' => null],
            ['id' => 39, 'leavetype_id' => 8, 'role' => 16, 'created_at' => null, 'updated_at' => null],
            ['id' => 40, 'leavetype_id' => 10, 'role' => 16, 'created_at' => null, 'updated_at' => null],
            ['id' => 41, 'leavetype_id' => 9, 'role' => 16, 'created_at' => null, 'updated_at' => null],
            ['id' => 42, 'leavetype_id' => 8, 'role' => 12, 'created_at' => null, 'updated_at' => null],
            ['id' => 43, 'leavetype_id' => 10, 'role' => 12, 'created_at' => null, 'updated_at' => null],
            ['id' => 44, 'leavetype_id' => 9, 'role' => 12, 'created_at' => null, 'updated_at' => null],
            ['id' => 45, 'leavetype_id' => 11, 'role' => 13, 'created_at' => '2023-09-20 01:13:31', 'updated_at' => null],
            ['id' => 46, 'leavetype_id' => 11, 'role' => 14, 'created_at' => '2023-09-20 01:13:31', 'updated_at' => null],
            ['id' => 47, 'leavetype_id' => 9, 'role' => 13, 'created_at' => '2023-09-20 01:13:31', 'updated_at' => null],
            ['id' => 48, 'leavetype_id' => 15, 'role' => 13, 'created_at' => '2023-09-19 19:43:31', 'updated_at' => null],
            ['id' => 49, 'leavetype_id' => 15, 'role' => 14, 'created_at' => null, 'updated_at' => null],
            ['id' => 51, 'leavetype_id' => 15, 'role' => 15, 'created_at' => '2023-09-19 19:43:31', 'updated_at' => null],
        ]);
    }
}

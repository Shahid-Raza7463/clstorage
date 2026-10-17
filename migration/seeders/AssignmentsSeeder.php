<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentsSeeder extends Seeder
{
    public function run()
    {
        DB::table('assignments')->insert([
            ['id' => 213, 'assignment_name' => 'Other', 'status' => 1, 'created_at' => '2023-09-06 01:16:51', 'updated_at' => '2023-09-06 01:16:51'],
            ['id' => 214, 'assignment_name' => 'Exam Leave', 'status' => 1, 'created_at' => '2023-09-20 00:57:38', 'updated_at' => '2023-09-20 00:57:38'],
            ['id' => 215, 'assignment_name' => 'Casual Leave', 'status' => 1, 'created_at' => '2023-09-20 00:57:46', 'updated_at' => '2023-09-20 00:57:46'],
            ['id' => 222, 'assignment_name' => 'Unplanned Leave', 'status' => 1, 'created_at' => '2023-09-19 19:27:46', 'updated_at' => '2023-09-19 19:27:46'],
        ]);
    }
}

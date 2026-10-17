<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesheetdaySeeder extends Seeder
{
    public function run()
    {
        DB::table('timesheetday')->insert([
            [
                'id' => 1,
                'createdby' => null,
                'day' => 'Monday',
                'date' => '2026-09-07',
                'created_at' => '2023-08-23 09:13:22',
                'updated_at' => '2026-09-06 18:31:03',
            ],
        ]);
    }
}

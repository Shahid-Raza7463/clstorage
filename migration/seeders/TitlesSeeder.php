<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TitlesSeeder extends Seeder
{
    public function run()
    {
        DB::table('titles')->insert([
            ['id' => 1, 'title' => 'Mr.', 'created_at' => '2023-08-01 18:14:40', 'updated_at' => null],
            ['id' => 2, 'title' => 'Mrs.', 'created_at' => '2023-08-01 18:14:45', 'updated_at' => null],
            ['id' => 3, 'title' => 'Ms.', 'created_at' => '2023-08-01 18:14:45', 'updated_at' => null],
        ]);
    }
}

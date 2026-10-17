<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            ['id' => 11, 'rolename' => 'Super Admin', 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2020-12-28 13:00:00'],
            ['id' => 12, 'rolename' => 'Admin', 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2022-06-02 07:30:00'],
            ['id' => 13, 'rolename' => 'Partner', 'created_at' => '2020-12-28 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 14, 'rolename' => 'Manager', 'created_at' => '2021-01-01 13:00:00', 'updated_at' => '2023-07-23 13:00:00'],
            ['id' => 15, 'rolename' => 'Staff', 'created_at' => '2021-01-08 13:00:00', 'updated_at' => '2024-01-11 13:00:00'],
            ['id' => 16, 'rolename' => 'IT Department', 'created_at' => '2021-01-08 13:00:00', 'updated_at' => '2023-06-08 07:30:00'],
            ['id' => 17, 'rolename' => 'Accountant', 'created_at' => '2021-01-08 13:00:00', 'updated_at' => '2022-10-16 07:30:00'],
            ['id' => 18, 'rolename' => 'HR', 'created_at' => '2021-01-08 13:00:00', 'updated_at' => '2023-04-05 07:30:00'],
            ['id' => 19, 'rolename' => 'Intern', 'created_at' => '2021-01-08 13:00:00', 'updated_at' => '2023-01-22 07:30:00'],
            ['id' => 20, 'rolename' => 'Consultant', 'created_at' => '2021-01-08 13:00:00', 'updated_at' => '2022-06-27 07:30:00'],
        ]);
    }
}

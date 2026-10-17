<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentteammappingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('assignmentteammappings')->insert([
            ['id' => 40, 'assignmentmapping_id' => 24, 'teammember_id' => 936, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => null, 'created_at' => '2023-09-06 02:43:25', 'updated_at' => null],
            ['id' => 41, 'assignmentmapping_id' => 24, 'teammember_id' => 951, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => '0', 'created_at' => '2023-09-06 02:43:26', 'updated_at' => null],
            ['id' => 88, 'assignmentmapping_id' => 25, 'teammember_id' => 936, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => null, 'created_at' => '2023-09-06 02:44:00', 'updated_at' => null],
            ['id' => 89, 'assignmentmapping_id' => 25, 'teammember_id' => 951, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => '25', 'created_at' => '2023-09-06 02:44:00', 'updated_at' => null],
            ['id' => 136, 'assignmentmapping_id' => 26, 'teammember_id' => 936, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => null, 'created_at' => '2023-09-06 02:44:41', 'updated_at' => null],
            ['id' => 137, 'assignmentmapping_id' => 26, 'teammember_id' => 951, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => '0', 'created_at' => '2023-09-06 02:44:41', 'updated_at' => null],
            ['id' => 184, 'assignmentmapping_id' => 27, 'teammember_id' => 936, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => null, 'created_at' => '2023-09-06 02:44:55', 'updated_at' => null],
            ['id' => 370, 'assignmentmapping_id' => 27, 'teammember_id' => 951, 'type' => '2', 'fromdate' => null, 'todate' => null, 'status' => 1, 'viewerteam' => null, 'teamhour' => '8', 'created_at' => '2023-09-06 02:46:55', 'updated_at' => null],
        ]);
    }
}

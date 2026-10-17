<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->insert([
            ['id' => 1, 'pagename' => 'client', 'created_at' => '2020-11-22 17:28:17', 'updated_at' => null],
            ['id' => 2, 'pagename' => 'assignment', 'created_at' => '2020-11-22 17:28:15', 'updated_at' => null],
            ['id' => 3, 'pagename' => 'configuration', 'created_at' => '2020-11-18 11:18:24', 'updated_at' => null],
            ['id' => 4, 'pagename' => 'team', 'created_at' => '2020-11-18 11:18:22', 'updated_at' => null],
            ['id' => 6, 'pagename' => 'notification', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 7, 'pagename' => 'finance', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 8, 'pagename' => 'tender', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 9, 'pagename' => 'assetassign', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 10, 'pagename' => 'calendar', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 11, 'pagename' => 'task', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 12, 'pagename' => 'staffrequest', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 13, 'pagename' => 'profile', 'created_at' => '2020-11-18 11:18:20', 'updated_at' => null],
            ['id' => 14, 'pagename' => 'assets', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 15, 'pagename' => 'teamprofile', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 16, 'pagename' => 'ticketsupport', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 17, 'pagename' => 'appointmentletter', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 18, 'pagename' => 'conversion', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 19, 'pagename' => 'human resources', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 20, 'pagename' => 'lead', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 21, 'pagename' => 'Trainingassessments', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 22, 'pagename' => 'contract', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 23, 'pagename' => 'assetprocurement', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 24, 'pagename' => 'icard', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 25, 'pagename' => 'vendor', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 26, 'pagename' => 'Material', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
            ['id' => 27, 'pagename' => 'Courier', 'created_at' => '2020-11-18 11:18:21', 'updated_at' => null],
        ]);
    }
}

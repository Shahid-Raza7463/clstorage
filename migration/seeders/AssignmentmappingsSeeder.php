<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentmappingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('assignmentmappings')->insert([
            [
                'id' => 24,
                'assignmentgenerate_id' => 'SEM100001',
                'assignment_id' => 213,
                'leadpartner' => 887,
                'otherpartner' => null,
                'created_at' => '2023-09-05 13:00:00',
                'updated_at' => '2023-09-05 13:00:00',
                'periodend' => '2023-09-07',
                'periodstart' => '2023-09-06',
                'year' => '2023',
                'location' => null,
                'fees' => null,
                'gst' => null,
                'roleassignment' => 1,
                'independenceform' => null,
                'esthours' => '0',
                'stdcost' => '0',
                'estcost' => '0',
                'filecreationdate' => '23-09-06',
                'modifieddate' => '23-09-06',
                'auditcompletiondate' => '23-09-06',
                'documentationdate' => '23-09-06',
                'leadpartnerhour' => null,
                'otherpartnerhour' => null
            ],
            [
                'id' => 25,
                'assignmentgenerate_id' => 'UNA100002',
                'assignment_id' => 213,
                'leadpartner' => 887,
                'otherpartner' => null,
                'created_at' => '2023-09-05 13:00:00',
                'updated_at' => '2023-09-05 13:00:00',
                'periodend' => '2023-09-07',
                'periodstart' => '2023-09-06',
                'year' => '2023',
                'location' => null,
                'fees' => null,
                'gst' => null,
                'roleassignment' => 1,
                'independenceform' => null,
                'esthours' => '0',
                'stdcost' => '0',
                'estcost' => '0',
                'filecreationdate' => '23-09-06',
                'modifieddate' => '23-09-06',
                'auditcompletiondate' => '23-09-06',
                'documentationdate' => '23-09-06',
                'leadpartnerhour' => null,
                'otherpartnerhour' => null
            ],
            [
                'id' => 26,
                'assignmentgenerate_id' => 'OFF100003',
                'assignment_id' => 213,
                'leadpartner' => 887,
                'otherpartner' => null,
                'created_at' => '2023-09-05 13:00:00',
                'updated_at' => '2023-09-05 13:00:00',
                'periodend' => '2023-09-07',
                'periodstart' => '2023-09-06',
                'year' => '2023',
                'location' => null,
                'fees' => null,
                'gst' => null,
                'roleassignment' => 1,
                'independenceform' => null,
                'esthours' => '0',
                'stdcost' => '0',
                'estcost' => '0',
                'filecreationdate' => '23-09-06',
                'modifieddate' => '23-09-06',
                'auditcompletiondate' => '23-09-06',
                'documentationdate' => '23-09-06',
                'leadpartnerhour' => null,
                'otherpartnerhour' => null
            ],
            [
                'id' => 27,
                'assignmentgenerate_id' => 'OFF100004',
                'assignment_id' => 213,
                'leadpartner' => 887,
                'otherpartner' => null,
                'created_at' => '2023-09-05 13:00:00',
                'updated_at' => '2023-09-05 13:00:00',
                'periodend' => '2023-09-06',
                'periodstart' => '2023-09-06',
                'year' => '2023',
                'location' => null,
                'fees' => null,
                'gst' => null,
                'roleassignment' => 1,
                'independenceform' => null,
                'esthours' => '0',
                'stdcost' => '0',
                'estcost' => '0',
                'filecreationdate' => '23-09-06',
                'modifieddate' => '23-09-06',
                'auditcompletiondate' => '23-09-06',
                'documentationdate' => '23-09-06',
                'leadpartnerhour' => null,
                'otherpartnerhour' => null
            ],
        ]);
    }
}

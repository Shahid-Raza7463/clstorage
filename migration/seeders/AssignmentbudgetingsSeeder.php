<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentbudgetingsSeeder extends Seeder
{
    public function run()
    {
        DB::table('assignmentbudgetings')->insert([
            [
                'id' => 25,
                'client_id' => 34,
                'assignment_id' => 213,
                'assignmentgenerate_id' => 'SEM100001',
                'assignmentnumber' => 100001,
                'assignmentname' => 'Seminar/Conference/Post Qualification Course',
                'otp' => null,
                'otpverifydate' => null,
                'closedby' => null,
                'billingfrequency' => null,
                'duedate' => '2023-09-06',
                'billdate' => null,
                'billlingamount' => null,
                'finalreportdate' => null,
                'draftreportdate' => null,
                'moneyreceiveddate' => null,
                'status' => 1,
                'appointment_letter' => null,
                'balanceconfirmationotp' => null,
                'balanceconfirmationstatus' => 1,
                'created_by' => 485,
                'created_at' => '2023-09-06 01:20:46',
                'updated_at' => '2023-09-06 01:20:46'
            ],
            [
                'id' => 26,
                'client_id' => 29,
                'assignment_id' => 213,
                'assignmentgenerate_id' => 'UNA100002',
                'assignmentnumber' => 100002,
                'assignmentname' => 'Unallocated',
                'otp' => null,
                'otpverifydate' => null,
                'closedby' => null,
                'billingfrequency' => null,
                'duedate' => '2023-09-06',
                'billdate' => null,
                'billlingamount' => null,
                'finalreportdate' => null,
                'draftreportdate' => null,
                'moneyreceiveddate' => null,
                'status' => 1,
                'appointment_letter' => null,
                'balanceconfirmationotp' => null,
                'balanceconfirmationstatus' => 1,
                'created_by' => 485,
                'created_at' => '2023-09-06 01:43:34',
                'updated_at' => '2023-09-06 01:43:34'
            ],
            [
                'id' => 27,
                'client_id' => 32,
                'assignment_id' => 213,
                'assignmentgenerate_id' => 'OFF100003',
                'assignmentnumber' => 100003,
                'assignmentname' => 'Official Travel',
                'otp' => null,
                'otpverifydate' => null,
                'closedby' => null,
                'billingfrequency' => null,
                'duedate' => '2023-09-06',
                'billdate' => null,
                'billlingamount' => null,
                'finalreportdate' => null,
                'draftreportdate' => null,
                'moneyreceiveddate' => null,
                'status' => 1,
                'appointment_letter' => null,
                'balanceconfirmationotp' => null,
                'balanceconfirmationstatus' => 1,
                'created_by' => 485,
                'created_at' => '2023-09-06 01:44:53',
                'updated_at' => '2023-09-06 01:44:53'
            ],
            [
                'id' => 28,
                'client_id' => 33,
                'assignment_id' => 213,
                'assignmentgenerate_id' => 'OFF100004',
                'assignmentnumber' => 100004,
                'assignmentname' => 'Off/Holiday',
                'otp' => null,
                'otpverifydate' => null,
                'closedby' => null,
                'billingfrequency' => null,
                'duedate' => '2023-09-06',
                'billdate' => null,
                'billlingamount' => null,
                'finalreportdate' => null,
                'draftreportdate' => null,
                'moneyreceiveddate' => null,
                'status' => 1,
                'appointment_letter' => null,
                'balanceconfirmationotp' => null,
                'balanceconfirmationstatus' => 1,
                'created_by' => 485,
                'created_at' => '2023-09-06 01:46:37',
                'updated_at' => '2023-09-06 01:46:37'
            ],
        ]);
    }
}

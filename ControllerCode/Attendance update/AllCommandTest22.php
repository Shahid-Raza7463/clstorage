<?php

namespace App\Console\Commands;

use App\Models\Attendance;
use App\Models\Teammember;
use App\Models\User;
use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AllCommandTest extends Command
{

    protected $signature = 'command:test';

    protected $description = 'This command only for testing';

    public function __construct()
    {
        parent::__construct();
    }

    // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         ->where('status', 0)
    //         // ->where('id', 844)
    //         ->whereNotIn('role_id', ['11'])
    //         ->pluck('id')
    //         ->toArray();

    //     foreach ($teammembers as $teammemberid) {
    //         $recordsToDelete = DB::table('attendances')
    //             ->where('employee_name', $teammemberid)
    //             ->whereIn('month', ['August', 'September'])
    //             ->whereNull('total_no_of_days');

    //         $allattendanceDatas = $recordsToDelete->get();
    //         $recordsToDelete->delete();
    //     }

    //     dd('Attendance updated success');
    // }

    // // 1 .final done p,cl,t,w,oh / persent and sundaycount done 
    // // it take 10 min without status
    // // it take 2 min for status 0 for one months
    // // it take 8 min for status 1 for one months
    // public function handle()
    // {

    //     // $attendances = DB::table('attendances')
    //     //     ->delete();

    //     // $teammembers = DB::table('teammembers')
    //     //     ->where('status', 1)
    //     //     // ->where('id', 847)
    //     //     ->whereNotIn('role_id', ['11'])
    //     //     ->pluck('id')
    //     //     // ->skip(100)
    //     //     // ->take(100)
    //     //     ->toArray();

    //     $startdateleav = "2024-09-01";
    //     $enddateleave = "2024-11-25";

    //     $teammembers = DB::table('teammembers')
    //         ->whereBetween('leavingdate', [$startdateleav, $enddateleave])
    //         // ->where('id', 847)
    //         ->where('status', 0)
    //         ->whereNotIn('id', [799, 907, 937, 941, 960])
    //         ->pluck('id')
    //         ->toArray();

    //     // dd($teammembers);


    //     foreach ($teammembers as $teammemberid) {

    //         // $enddate = "2024-04-30";
    //         // $enddate = "2024-05-31";
    //         // $enddate = "2024-06-30";
    //         // $enddate = "2024-07-31";
    //         // $enddate = "2024-08-31";
    //         // $enddate = "2024-09-30";

    //         $startdate = "2024-09-01";
    //         $enddate = "2024-11-25";

    //         $getAlltimesheetdata = DB::table('timesheetusers')
    //             ->whereIn('status', [1, 2, 3])
    //             ->where('createdby', $teammemberid)
    //             ->whereBetween('date', [$startdate, $enddate])
    //             ->orderBy('date', 'ASC')
    //             ->get();

    //         $getallexamtimesheet = DB::table('timesheetusers')
    //             ->whereIn('status', [1, 2, 3])
    //             ->where('assignment_id', 214)
    //             ->where('createdby', $teammemberid)
    //             ->whereBetween('date', [$startdate, $enddate])
    //             ->orderBy('date', 'ASC')
    //             ->get();

    //         //? 1 .final done p,cl,t,w,oh / persent and sundaycount done 
    //         if ($getAlltimesheetdata->isNotEmpty()) {

    //             foreach ($getAlltimesheetdata as $getsixdata) {

    //                 // Attendance code start hare 
    //                 $gettotaldays = Carbon::parse($getsixdata->date);
    //                 $totalDaysInMonth = $gettotaldays->daysInMonth;

    //                 $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
    //                 $day = Carbon::parse($hdatess)->format('d');
    //                 $month = Carbon::parse($hdatess)->format('F');
    //                 $yeardata = Carbon::parse($hdatess)->format('Y');

    //                 $dates = [
    //                     '26' => 'twentysix',
    //                     '27' => 'twentyseven',
    //                     '28' => 'twentyeight',
    //                     '29' => 'twentynine',
    //                     '30' => 'thirty',
    //                     '31' => 'thirtyone',
    //                     '01' => 'one',
    //                     '02' => 'two',
    //                     '03' => 'three',
    //                     '04' => 'four',
    //                     '05' => 'five',
    //                     '06' => 'six',
    //                     '07' => 'seven',
    //                     '08' => 'eight',
    //                     '09' => 'nine',
    //                     '10' => 'ten',
    //                     '11' => 'eleven',
    //                     '12' => 'twelve',
    //                     '13' => 'thirteen',
    //                     '14' => 'fourteen',
    //                     '15' => 'fifteen',
    //                     '16' => 'sixteen',
    //                     '17' => 'seventeen',
    //                     '18' => 'eighteen',
    //                     '19' => 'ninghteen',
    //                     '20' => 'twenty',
    //                     '21' => 'twentyone',
    //                     '22' => 'twentytwo',
    //                     '23' => 'twentythree',
    //                     '24' => 'twentyfour',
    //                     '25' => 'twentyfive',
    //                 ];

    //                 $column = $dates[$day];

    //                 // check attendenace record exist or not 
    //                 $attendances = DB::table('attendances')
    //                     ->where('employee_name', $teammemberid)
    //                     ->where('month', $month)
    //                     ->first();



    //                 if ($attendances == null) {
    //                     $teammember = DB::table('teammembers')->where('id', $teammemberid)->first();

    //                     $monthcase = strtolower($month);
    //                     if ($monthcase == 'april') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-04-02 11:00:11'));
    //                     } elseif ($monthcase == 'may') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-05-02 11:00:11'));
    //                     } elseif ($monthcase == 'june') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-06-02 11:00:11'));
    //                     } elseif ($monthcase == 'july') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-07-02 11:00:11'));
    //                     } elseif ($monthcase == 'august') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-08-02 11:00:11'));
    //                     } elseif ($monthcase == 'september') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-09-02 11:00:11'));
    //                     } elseif ($monthcase == 'october') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-10-02 11:00:11'));
    //                     }

    //                     DB::table('attendances')->insert([
    //                         'employee_name' => $teammemberid,
    //                         'month' => $month,
    //                         'year' => $yeardata,
    //                         'total_no_of_days' => $totalDaysInMonth,
    //                         'dateofjoining' => $teammember->joining_date,
    //                         'fulldate' => date('Y-m-d', strtotime($monthdate)),
    //                         'created_at' => $monthdate,
    //                         'updated_at' =>  $monthdate,
    //                     ]);
    //                 }

    //                 $attendances = DB::table('attendances')
    //                     ->where('employee_name', $teammemberid)
    //                     ->where('month', $month)
    //                     ->first();

    //                 if ($attendances != null && property_exists($attendances, $column)) {

    //                     $client = $getsixdata->client_id;
    //                     $assignmentid = $getsixdata->assignment_id;

    //                     if ($client == 32) {
    //                         $updatewording = 'T'; // Travel
    //                     } elseif ($client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $getsixdata->workitem) == 'Saturday') {
    //                         $updatewording = 'OH'; // Off holidays
    //                     } elseif ($client == 33) {
    //                         $updatewording = 'H'; // Other holidays from calendar
    //                     } elseif ($assignmentid == 213 && $getsixdata->workitem == 'NA') {
    //                         $updatewording = null; // Casual leave
    //                     } elseif ($client == 134 && $assignmentid == 215) {
    //                         $updatewording = 'CL'; // Casual leave
    //                     } elseif ($client == 134 && $assignmentid == 214) {
    //                         $updatewording = 'EL'; // Exam leave
    //                     } else {
    //                         $updatewording = 'P'; // Default presence
    //                     }
    //                 }

    //                 $totalCountMapping = [
    //                     'P' => 'no_of_days_present',
    //                     'CL' => 'casual_leave',
    //                     'EL' => 'exam_leave',
    //                     'T' => 'travel',
    //                     'OH' => 'offholidays',
    //                     'W' => 'sundaycount',
    //                     'H' => 'holidays',
    //                     null => 'beforejoiningcount'
    //                 ];


    //                 if (isset($totalCountMapping[$updatewording])) {
    //                     $totalcountColumn = $totalCountMapping[$updatewording];
    //                     $totalcountupdate = $attendances->$totalcountColumn + 1;

    //                     if ($totalcountColumn != "exam_leave") {
    //                         $iftwotimesheetinday = DB::table('attendances')
    //                             ->where('id', $attendances->id)
    //                             ->value($column);

    //                         if ($iftwotimesheetinday == "P") {
    //                             $updatewording = "P";
    //                             $totalcountupdate = $attendances->$totalcountColumn + 0;
    //                         } elseif ($iftwotimesheetinday == 'T') {
    //                             $updatewording = "P";
    //                             $totalcountupdate = $attendances->$totalcountColumn + 0;
    //                         }

    //                         DB::table('attendances')
    //                             ->where('id', $attendances->id)
    //                             ->update([
    //                                 $column => $updatewording,
    //                                 $totalcountColumn => $totalcountupdate,
    //                             ]);
    //                     }
    //                 }
    //                 // Attendance code end hare 
    //             }

    //             // Attendance code end hare 

    //             // update sunday data in attendance
    //             $startDateCarbon = Carbon::parse($startdate);
    //             $endDateCarbon = Carbon::parse($enddate);

    //             $numberWords = [
    //                 '1' => 'one',
    //                 '2' => 'two',
    //                 '3' => 'three',
    //                 '4' => 'four',
    //                 '5' => 'five',
    //                 '6' => 'six',
    //                 '7' => 'seven',
    //                 '8' => 'eight',
    //                 '9' => 'nine',
    //                 '10' => 'ten',
    //                 '11' => 'eleven',
    //                 '12' => 'twelve',
    //                 '13' => 'thirteen',
    //                 '14' => 'fourteen',
    //                 '15' => 'fifteen',
    //                 '16' => 'sixteen',
    //                 '17' => 'seventeen',
    //                 '18' => 'eighteen',
    //                 '19' => 'ninghteen',
    //                 '20' => 'twenty',
    //                 '21' => 'twentyone',
    //                 '22' => 'twentytwo',
    //                 '23' => 'twentythree',
    //                 '24' => 'twentyfour',
    //                 '25' => 'twentyfive',
    //                 '26' => 'twentysix',
    //                 '27' => 'twentyseven',
    //                 '28' => 'twentyeight',
    //                 '29' => 'twentynine',
    //                 '30' => 'thirty',
    //                 '31' => 'thirtyone'
    //             ];

    //             if ($startDateCarbon->isSunday()) {

    //                 $day = $startDateCarbon->day;
    //                 $month = $startDateCarbon->format('F'); // Get the month name
    //                 $dayWord = $numberWords[$day]; // Convert day number to word

    //                 // Format the date for checking holiday
    //                 $formattedDate = $startDateCarbon->format('Y-m-d');

    //                 // Check if the date is a holiday
    //                 $holidayCheck = DB::table('holidays')
    //                     ->where('startdate', '=', $formattedDate)
    //                     ->orWhere('enddate', '=', $formattedDate)
    //                     ->first();


    //                 // Determine whether to mark as 'H' (holiday) or 'W' (workday)
    //                 $attendanceStatus = $holidayCheck ? 'H' : 'W';

    //                 // Define mapping for columns to update
    //                 $totalCountMapping = [
    //                     'P' => 'no_of_days_present',
    //                     'CL' => 'casual_leave',
    //                     'EL' => 'exam_leave',
    //                     'T' => 'travel',
    //                     'OH' => 'offholidays',
    //                     'W' => 'sundaycount',
    //                     'H' => 'holidays'
    //                 ];
    //                 // Check attendance record for this user, month, and day
    //                 $attendanceRecord = DB::table('attendances')
    //                     ->where('employee_name', $teammemberid)
    //                     ->where('month', $month)
    //                     ->whereNull($dayWord) // Make sure the day is not already set
    //                     ->first();


    //                 if ($attendanceRecord && isset($totalCountMapping[$attendanceStatus])) {
    //                     $totalcountColumn = $totalCountMapping[$attendanceStatus];
    //                     $newTotalCount = $attendanceRecord->$totalcountColumn + 1;
    //                     // Update attendance table with holiday or workday for the current Sunday
    //                     DB::table('attendances')
    //                         ->where('id', $attendanceRecord->id)
    //                         ->update([
    //                             $dayWord => $attendanceStatus,
    //                             $totalcountColumn => $newTotalCount,
    //                         ]);
    //                 }
    //             }

    //             for ($date = $startDateCarbon->copy()->next(Carbon::SUNDAY); $date->lte($endDateCarbon); $date->addWeek()) {

    //                 $day = $date->day; // Get the day number
    //                 $month = $date->format('F'); // Get the month name
    //                 $dayWord = $numberWords[$day]; // Convert day number to word

    //                 // Format the date for checking holiday
    //                 $formattedDate = $date->format('Y-m-d');

    //                 // Check if the date is a holiday
    //                 $holidayCheck = DB::table('holidays')
    //                     ->where('startdate', '=', $formattedDate)
    //                     ->orWhere('enddate', '=', $formattedDate)
    //                     ->first();


    //                 // Determine whether to mark as 'H' (holiday) or 'W' (workday)
    //                 $attendanceStatus = $holidayCheck ? 'H' : 'W';

    //                 // Define mapping for columns to update
    //                 $totalCountMapping = [
    //                     'P' => 'no_of_days_present',
    //                     'CL' => 'casual_leave',
    //                     'EL' => 'exam_leave',
    //                     'T' => 'travel',
    //                     'OH' => 'offholidays',
    //                     'W' => 'sundaycount',
    //                     'H' => 'holidays'
    //                 ];
    //                 // Check attendance record for this user, month, and day
    //                 $attendanceRecord = DB::table('attendances')
    //                     ->where('employee_name', $teammemberid)
    //                     ->where('month', $month)
    //                     ->whereNull($dayWord) // Make sure the day is not already set
    //                     ->first();


    //                 if ($attendanceRecord && isset($totalCountMapping[$attendanceStatus])) {
    //                     $totalcountColumn = $totalCountMapping[$attendanceStatus];
    //                     $newTotalCount = $attendanceRecord->$totalcountColumn + 1;
    //                     // Update attendance table with holiday or workday for the current Sunday
    //                     DB::table('attendances')
    //                         ->where('id', $attendanceRecord->id)
    //                         ->update([
    //                             $dayWord => $attendanceStatus,
    //                             $totalcountColumn => $newTotalCount,
    //                         ]);
    //                 }
    //             }
    //         }
    //         // 1 .final done p,cl,t,w,oh / persent and sundaycount done  end hare

    //         //? 2 .exam leave done with holidays 
    //         if ($getallexamtimesheet->isNotEmpty()) {

    //             foreach ($getallexamtimesheet as $getsixdata) {

    //                 // Attendance code start hare 
    //                 $gettotaldays = Carbon::parse($getsixdata->date);
    //                 $totalDaysInMonth = $gettotaldays->daysInMonth;

    //                 $hdatess = Carbon::parse($getsixdata->date)->format('Y-m-d');
    //                 $day = Carbon::parse($hdatess)->format('d');
    //                 $month = Carbon::parse($hdatess)->format('F');
    //                 $yeardata = Carbon::parse($hdatess)->format('Y');

    //                 $dates = [
    //                     '26' => 'twentysix',
    //                     '27' => 'twentyseven',
    //                     '28' => 'twentyeight',
    //                     '29' => 'twentynine',
    //                     '30' => 'thirty',
    //                     '31' => 'thirtyone',
    //                     '01' => 'one',
    //                     '02' => 'two',
    //                     '03' => 'three',
    //                     '04' => 'four',
    //                     '05' => 'five',
    //                     '06' => 'six',
    //                     '07' => 'seven',
    //                     '08' => 'eight',
    //                     '09' => 'nine',
    //                     '10' => 'ten',
    //                     '11' => 'eleven',
    //                     '12' => 'twelve',
    //                     '13' => 'thirteen',
    //                     '14' => 'fourteen',
    //                     '15' => 'fifteen',
    //                     '16' => 'sixteen',
    //                     '17' => 'seventeen',
    //                     '18' => 'eighteen',
    //                     '19' => 'ninghteen',
    //                     '20' => 'twenty',
    //                     '21' => 'twentyone',
    //                     '22' => 'twentytwo',
    //                     '23' => 'twentythree',
    //                     '24' => 'twentyfour',
    //                     '25' => 'twentyfive',
    //                 ];

    //                 $column = $dates[$day];

    //                 // check attendenace record exist or not 
    //                 $attendances = DB::table('attendances')
    //                     ->where('employee_name', $teammemberid)
    //                     ->where('month', $month)
    //                     ->first();

    //                 if ($attendances == null) {
    //                     $teammember = DB::table('teammembers')->where('id', $teammemberid)->first();

    //                     $monthcase = strtolower($month);
    //                     if ($monthcase == 'april') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-04-02 11:00:11'));
    //                     } elseif ($monthcase == 'may') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-05-02 11:00:11'));
    //                     } elseif ($monthcase == 'june') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-06-02 11:00:11'));
    //                     } elseif ($monthcase == 'july') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-07-02 11:00:11'));
    //                     } elseif ($monthcase == 'august') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-08-02 11:00:11'));
    //                     } elseif ($monthcase == 'september') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-09-02 11:00:11'));
    //                     } elseif ($monthcase == 'october') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-10-02 11:00:11'));
    //                     }

    //                     DB::table('attendances')->insert([
    //                         'employee_name' => $teammemberid,
    //                         'month' => $month,
    //                         'year' => $yeardata,
    //                         'total_no_of_days' => $totalDaysInMonth,
    //                         'dateofjoining' => $teammember->joining_date,
    //                         'fulldate' => date('Y-m-d', strtotime($monthdate)),
    //                         'created_at' => $monthdate,
    //                         'updated_at' =>  $monthdate,
    //                     ]);
    //                 }

    //                 $attendances = DB::table('attendances')
    //                     ->where('employee_name', $teammemberid)
    //                     ->where('month', $month)
    //                     ->first();


    //                 if (!empty($column)) {

    //                     $getholidaysss = DB::table('holidays')
    //                         ->where('startdate', '=', $getsixdata->date)
    //                         ->orWhere('enddate', '=', $getsixdata->date)
    //                         ->first();

    //                     if ($getholidaysss != null) {

    //                         $updateddata = 'H';
    //                         $totalcountupdate = $attendances->holidays += 1;

    //                         DB::table('attendances')
    //                             ->where('id', $attendances->id)
    //                             ->update([
    //                                 $column => $updateddata,
    //                                 'holidays' => $totalcountupdate,
    //                             ]);
    //                     } else {
    //                         $updateddata = 'EL';
    //                         $examleavecountupdate = $attendances->exam_leave += 1;

    //                         DB::table('attendances')
    //                             ->where('id', $attendances->id)
    //                             ->update([
    //                                 $column => $updateddata,
    //                                 'exam_leave' => $examleavecountupdate,
    //                             ]);
    //                     }
    //                 }
    //                 // Attendance code end hare 
    //             }
    //         }
    //         // 2 .exam leave done with holidays end hare
    //     }

    //     dd('Status 0 Attendance updated success');
    // }


    // // 3 .cross sign updated in this function
    // // you need to run only once
    // // it take 1 min
    // public function handle()
    // {

    //     $startdateleav = "2024-09-01";
    //     $enddateleave = "2024-11-25";

    //     $teammembers = DB::table('teammembers')
    //         ->whereBetween('leavingdate', [$startdateleav, $enddateleave])
    //         // ->where('id', 847)
    //         ->where('status', 0)
    //         ->whereNotIn('id', [799, 907, 937, 941, 960])
    //         ->pluck('id')
    //         ->toArray();

    //     // $teammembersname = DB::table('teammembers')
    //     //     ->whereBetween('leavingdate', [$startdate, $enddate])
    //     //     // ->where('id', 847)
    //     //     ->where('status', 0)
    //     //     ->select('id', 'team_member')
    //     //     ->get();

    //     // dd($teammembersname);


    //     foreach ($teammembers as $teammemberid) {

    //         $leavinigdate = DB::table('teammembers')->where('id', $teammemberid)->first();

    //         $exitDate = Carbon::parse($leavinigdate->leavingdate);
    //         $exitMonth = $exitDate->format('F');
    //         $exitYear = $exitDate->year;
    //         $dayOfExit = $exitDate->day;
    //         $totalDaysInExitMonth = $exitDate->daysInMonth;

    //         // // Attendance delete after leaving date 
    //         // $attendencedelete = DB::table('attendances')
    //         //     ->where('employee_name', $id)
    //         //     ->whereDate('created_at', '>', $request->leavingdate)
    //         //     ->delete();

    //         // Check if the attendance record exists for the exit month
    //         $exitmonthattendances = DB::table('attendances')
    //             ->where('employee_name', $teammemberid)
    //             ->where('month', $exitMonth)
    //             ->first();

    //         // If not, insert a new record
    //         if (!$exitmonthattendances) {
    //             $monthcase = strtolower($exitMonth);
    //             if ($monthcase == 'april') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-04-02 11:00:11'));
    //             } elseif ($monthcase == 'may') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-05-02 11:00:11'));
    //             } elseif ($monthcase == 'june') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-06-02 11:00:11'));
    //             } elseif ($monthcase == 'july') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-07-02 11:00:11'));
    //             } elseif ($monthcase == 'august') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-08-02 11:00:11'));
    //             } elseif ($monthcase == 'september') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-09-02 11:00:11'));
    //             }

    //             DB::table('attendances')->insert([
    //                 'employee_name' => $teammemberid,
    //                 'month' => $exitMonth,
    //                 'year' => $exitYear,
    //                 'total_no_of_days' => $totalDaysInExitMonth,
    //                 'dateofjoining' => $leavinigdate->joining_date,
    //                 'fulldate' => date('Y-m-d', strtotime($monthdate)),
    //                 'created_at' => $monthdate,
    //                 'updated_at' =>  $monthdate,
    //             ]);

    //             // Fetch the newly inserted attendance record
    //             $exitmonthattendances = DB::table('attendances')
    //                 ->where('employee_name', $teammemberid)
    //                 ->where('month', $exitMonth)
    //                 ->first();
    //         }

    //         // Map day numbers to column names
    //         $daysToColumns = [
    //             1 => 'one',
    //             2 => 'two',
    //             3 => 'three',
    //             4 => 'four',
    //             5 => 'five',
    //             6 => 'six',
    //             7 => 'seven',
    //             8 => 'eight',
    //             9 => 'nine',
    //             10 => 'ten',
    //             11 => 'eleven',
    //             12 => 'twelve',
    //             13 => 'thirteen',
    //             14 => 'fourteen',
    //             15 => 'fifteen',
    //             16 => 'sixteen',
    //             17 => 'seventeen',
    //             18 => 'eighteen',
    //             19 => 'ninghteen',
    //             20 => 'twenty',
    //             21 => 'twentyone',
    //             22 => 'twentytwo',
    //             23 => 'twentythree',
    //             24 => 'twentyfour',
    //             25 => 'twentyfive',
    //             26 => 'twentysix',
    //             27 => 'twentyseven',
    //             28 => 'twentyeight',
    //             29 => 'twentynine',
    //             30 => 'thirty',
    //             31 => 'thirtyone'
    //         ];

    //         // Prepare the update data
    //         $updateData = [];
    //         foreach ($daysToColumns as $day => $column) {
    //             if ($day > $dayOfExit && $day <= $totalDaysInExitMonth) {
    //                 $updateData[$column] = 'X';
    //                 // $updateData[$column] = null;
    //             }
    //         }
    //         // Update the attendance record
    //         if (!empty($updateData)) {
    //             DB::table('attendances')
    //                 ->where('id', $exitmonthattendances->id)
    //                 ->update($updateData);
    //         }
    //         // update cross sign after exit date of users end hare 
    //         // Attendance code end hare 
    //     }

    //     dd('cross sign updated successfull');
    // }

    // // //! 4 . attendance count update then
    // // you need to run only twice 
    // // it take 40 second for status 0 
    // // it take 2 min status 1 
    // public function handle()
    // {
    //     $startdateleav = "2024-09-01";
    //     $enddateleave = "2024-11-25";

    //     $teammembers = DB::table('teammembers')
    //         ->whereBetween('leavingdate', [$startdateleav, $enddateleave])
    //         // ->where('id', 847)
    //         ->where('status', 0)
    //         ->whereNotIn('id', [799, 907, 937, 941, 960])
    //         ->pluck('id')
    //         ->toArray();



    //     foreach ($teammembers as $teammemberid) {

    //         $allattendanceDatas = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->where('attendances.employee_name', $teammemberid)
    //             // ->where('attendances.month', 'August')
    //             ->select(
    //                 'attendances.*',
    //                 'teammembers.team_member',
    //             )
    //             ->get();

    //         // dd($allattendanceDatas);

    //         foreach ($allattendanceDatas as $allattendanceData) {

    //             $monthcase = strtolower($allattendanceData->month);
    //             if ($monthcase != 'october' && $monthcase != 'november') {
    //                 if ($monthcase == 'april') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-04-02 11:00:11'));
    //                 } elseif ($monthcase == 'may') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-05-02 11:00:11'));
    //                 } elseif ($monthcase == 'june') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-06-02 11:00:11'));
    //                 } elseif ($monthcase == 'july') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-07-02 11:00:11'));
    //                 } elseif ($monthcase == 'august') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-08-02 11:00:11'));
    //                 } elseif ($monthcase == 'september') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-09-02 11:00:11'));
    //                 } elseif ($monthcase == 'october') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-10-02 11:00:11'));
    //                 } elseif ($monthcase == 'november') {
    //                     $monthdate = date('Y-m-d', strtotime('2024-11-02 11:00:11'));
    //                 }

    //                 $gettotaldays = Carbon::parse($monthdate);
    //                 $totalDaysInMonth = $gettotaldays->daysInMonth;
    //                 // dd($allattendanceDatas, 11);

    //                 $keysToFilter = [
    //                     'twentysix',
    //                     'twentyseven',
    //                     'twentyeight',
    //                     'twentynine',
    //                     'thirty',
    //                     'thirtyone',
    //                     'one',
    //                     'two',
    //                     'three',
    //                     'four',
    //                     'five',
    //                     'six',
    //                     'seven',
    //                     'eight',
    //                     'nine',
    //                     'ten',
    //                     'eleven',
    //                     'twelve',
    //                     'thirteen',
    //                     'fourteen',
    //                     'fifteen',
    //                     'sixteen',
    //                     'seventeen',
    //                     'eighteen',
    //                     'ninghteen',
    //                     'twenty',
    //                     'twentyone',
    //                     'twentytwo',
    //                     'twentythree',
    //                     'twentyfour',
    //                     'twentyfive'
    //                 ];

    //                 $days = array_intersect_key($allattendanceData->toArray(), array_flip($keysToFilter));

    //                 $dayspresent = 0;
    //                 $casualLeaveCount = 0;
    //                 $examLeaveCount = 0;
    //                 $travelCount = 0;
    //                 $offholidaysCount = 0;
    //                 $sundayCount = 0;
    //                 $holidaysCount = 0;
    //                 // $beforejoinigCount = 0;

    //                 foreach ($days as $key => $value) {
    //                     if ($value == 'P') {
    //                         $dayspresent++;
    //                     } else if ($value == 'CL') {
    //                         $casualLeaveCount++;
    //                     } else if ($value == 'EL') {
    //                         $examLeaveCount++;
    //                     } else if ($value == 'T') {
    //                         $travelCount++;
    //                     } else if ($value == 'OH') {
    //                         $offholidaysCount++;
    //                     } else if ($value == 'W') {
    //                         $sundayCount++;
    //                     } else if ($value == 'H') {
    //                         $holidaysCount++;
    //                     }
    //                     //  else if ($value == null) {
    //                     //     $beforejoinigCount++;
    //                     // }
    //                 }

    //                 $dayspresentcount = $dayspresent;
    //                 $casualLeave = $casualLeaveCount;
    //                 $examLeave =  $examLeaveCount;
    //                 $travel =  $travelCount;
    //                 $offholidays =  $offholidaysCount;
    //                 $sunday =  $sundayCount;
    //                 $holidays =  $holidaysCount;
    //                 // $sunday =  $beforejoinigCount;

    //                 $attendanceData = [
    //                     'total_no_of_days' => $totalDaysInMonth,
    //                     'no_of_days_present' => $dayspresentcount,
    //                     'casual_leave' => $casualLeave,
    //                     'exam_leave' => $examLeave,
    //                     'holidays' => $holidays,
    //                     'travel' => $travel,
    //                     'offholidays' => $offholidays,
    //                     'sundaycount' => $sunday,
    //                     // 'beforejoiningcount' => $beforejoinigCount,
    //                 ];
    //                 // dd($allattendanceData);
    //                 DB::table('attendances')->where('id', $allattendanceData->id)
    //                     ->update($attendanceData);
    //             }
    //         }
    //     }

    //     dd('Count updated success 1');
    // }
}

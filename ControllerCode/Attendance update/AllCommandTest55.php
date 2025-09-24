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
    // /command-test
    // 1 .final done p,cl,t,w,oh / persent and sundaycount done 
    // it take 10 min without status
    // it take 2 min for status 0 for one months
    // it take 8 min for status 1 for one months
    // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         ->whereIn('id', [770, 772, 806, 943, 835, 940, 938, 916, 947, 805, 944])
    //         // ->whereIn('id', [832])
    //         // ->whereIn('id', [777])
    //         ->pluck('id')
    //         ->toArray();

    //     // dd($teammembers);

    //     foreach ($teammembers as $teammemberid) {

    //         // $enddate = "2024-08-31";
    //         // $enddate = "2024-09-30";
    //         // $enddate = "2024-10-31";
    //         // $enddate = "2024-11-30";
    //         // $enddate = "2024-12-31";


    //         $startdate = "2024-10-01";
    //         // $startdate = "2024-09-01";
    //         // $startdate = "2024-07-01";

    //         $enddate = "2024-11-30";

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
    //                     } elseif ($monthcase == 'november') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-11-02 11:00:11'));
    //                     } elseif ($monthcase == 'december') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-12-02 11:00:11'));
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
    //                     } elseif ($monthcase == 'november') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-11-02 11:00:11'));
    //                     } elseif ($monthcase == 'december') {
    //                         $monthdate = date('Y-m-d H:i:s', strtotime('2024-12-02 11:00:11'));
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


    // //! 4 . attendance count update then
    // you need to run only twice 
    // it take 40 second for status 0 
    // it take 2 min status 1 
    // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         ->whereIn('id', [770, 772, 806, 943, 835, 940, 938, 916, 947, 805, 944])
    //         // ->whereIn('id', [832])
    //         // ->whereIn('id', [777])
    //         ->pluck('id')
    //         ->toArray();

    //     foreach ($teammembers as $teammemberid) {

    //         $allattendanceDatas = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->where('attendances.employee_name', $teammemberid)
    //             ->whereIn('attendances.month', ['October', 'November'])
    //             // ->whereIn('attendances.month', ['September', 'October', 'November'])
    //             // ->whereIn('attendances.month', ['July', 'August', 'September', 'October', 'November'])
    //             ->select(
    //                 'attendances.*',
    //                 'teammembers.team_member',
    //             )
    //             ->get();

    //         // dd($allattendanceDatas);

    //         // dd($allattendanceDatas);

    //         foreach ($allattendanceDatas as $allattendanceData) {

    //             $monthcase = strtolower($allattendanceData->month);
    //             // if ($monthcase != 'october' && $monthcase != 'november') {
    //             if ($monthcase == 'april') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-04-02 11:00:11'));
    //             } elseif ($monthcase == 'may') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-05-02 11:00:11'));
    //             } elseif ($monthcase == 'june') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-06-02 11:00:11'));
    //             } elseif ($monthcase == 'july') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-07-02 11:00:11'));
    //             } elseif ($monthcase == 'august') {
    //                 $monthdate = date('Y-m-d', strtotime('2024-08-02 11:00:11'));
    //             } elseif ($monthcase == 'september') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-09-02 11:00:11'));
    //             } elseif ($monthcase == 'october') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-10-02 11:00:11'));
    //             } elseif ($monthcase == 'november') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-11-02 11:00:11'));
    //             } elseif ($monthcase == 'december') {
    //                 $monthdate = date('Y-m-d H:i:s', strtotime('2024-12-02 11:00:11'));
    //             }

    //             $gettotaldays = Carbon::parse($monthdate);
    //             $totalDaysInMonth = $gettotaldays->daysInMonth;
    //             // dd($allattendanceDatas, 11);

    //             $keysToFilter = [
    //                 'twentysix',
    //                 'twentyseven',
    //                 'twentyeight',
    //                 'twentynine',
    //                 'thirty',
    //                 'thirtyone',
    //                 'one',
    //                 'two',
    //                 'three',
    //                 'four',
    //                 'five',
    //                 'six',
    //                 'seven',
    //                 'eight',
    //                 'nine',
    //                 'ten',
    //                 'eleven',
    //                 'twelve',
    //                 'thirteen',
    //                 'fourteen',
    //                 'fifteen',
    //                 'sixteen',
    //                 'seventeen',
    //                 'eighteen',
    //                 'ninghteen',
    //                 'twenty',
    //                 'twentyone',
    //                 'twentytwo',
    //                 'twentythree',
    //                 'twentyfour',
    //                 'twentyfive'
    //             ];

    //             $days = array_intersect_key($allattendanceData->toArray(), array_flip($keysToFilter));

    //             $dayspresent = 0;
    //             $casualLeaveCount = 0;
    //             $examLeaveCount = 0;
    //             $travelCount = 0;
    //             $offholidaysCount = 0;
    //             $sundayCount = 0;
    //             $holidaysCount = 0;
    //             // $beforejoinigCount = 0;

    //             foreach ($days as $key => $value) {
    //                 if ($value == 'P') {
    //                     $dayspresent++;
    //                 } else if ($value == 'CL') {
    //                     $casualLeaveCount++;
    //                 } else if ($value == 'EL') {
    //                     $examLeaveCount++;
    //                 } else if ($value == 'T') {
    //                     $travelCount++;
    //                 } else if ($value == 'OH') {
    //                     $offholidaysCount++;
    //                 } else if ($value == 'W') {
    //                     $sundayCount++;
    //                 } else if ($value == 'H') {
    //                     $holidaysCount++;
    //                 }
    //                 //  else if ($value == null) {
    //                 //     $beforejoinigCount++;
    //                 // }
    //             }

    //             $dayspresentcount = $dayspresent;
    //             $casualLeave = $casualLeaveCount;
    //             $examLeave =  $examLeaveCount;
    //             $travel =  $travelCount;
    //             $offholidays =  $offholidaysCount;
    //             $sunday =  $sundayCount;
    //             $holidays =  $holidaysCount;
    //             // $sunday =  $beforejoinigCount;

    //             $attendanceData = [
    //                 'total_no_of_days' => $totalDaysInMonth,
    //                 'no_of_days_present' => $dayspresentcount,
    //                 'casual_leave' => $casualLeave,
    //                 'exam_leave' => $examLeave,
    //                 'holidays' => $holidays,
    //                 'travel' => $travel,
    //                 'offholidays' => $offholidays,
    //                 'sundaycount' => $sunday,
    //                 // 'beforejoiningcount' => $beforejoinigCount,
    //             ];
    //             // dd($allattendanceData);
    //             DB::table('attendances')->where('id', $allattendanceData->id)
    //                 ->update($attendanceData);
    //             // }
    //         }
    //     }

    //     dd('Count updated success 1');
    // }

    // Delete Attendance before joinig date 
    // 6 data will be delete
    // public function handle()
    // {
    //     $teammembersjoin = DB::table('attendances')
    //         // ->whereIn('employee_name', [950])
    //         ->select('employee_name')
    //         ->distinct()
    //         ->get()
    //         ->toArray();

    //     foreach ($teammembersjoin as $teammemberid) {
    //         $teamdata = DB::table('teammembers')
    //             ->where('id', $teammemberid->employee_name)
    //             ->select('team_member', 'staffcode', 'joining_date', 'leavingdate', 'status')
    //             ->first();

    //         $exitDate = Carbon::parse($teamdata->joining_date);
    //         $exitMonth = $exitDate->format('F');
    //         $exitYear = $exitDate->year;

    //         $months = [
    //             'January',
    //             'February',
    //             'March',
    //             'April',
    //             'May',
    //             'June',
    //             'July',
    //             'August',
    //             'September',
    //             'October',
    //             'November',
    //             'December'
    //         ];

    //         $exitMonthIndex = array_search($exitMonth, $months);
    //         $monthsAfterExitMonth = array_slice($months, $exitMonthIndex);

    //         $attendencedelete = DB::table('attendances')
    //             ->where('employee_name', $teammemberid->employee_name)
    //             ->where('year', $exitYear)
    //             ->whereNotIn('month', $monthsAfterExitMonth)
    //             // ->get();
    //             ->delete();

    //         // dd($attendencedelete);
    //     }

    //     // Delete Attendance after leaving date 
    //     // 11 data will be delete 
    //     $teammembersexit = DB::table('attendances')
    //         // ->whereIn('employee_name', [818])
    //         ->select('employee_name')
    //         ->distinct()
    //         ->get()
    //         ->toArray();

    //     foreach ($teammembersexit as $teammemberid) {
    //         $teamdata = DB::table('teammembers')
    //             ->where('id', $teammemberid->employee_name)
    //             ->select('team_member', 'staffcode', 'joining_date', 'leavingdate', 'status')
    //             ->first();


    //         if ($teamdata->status == 0) {
    //             $lastsubmitdata =  DB::table('timesheetreport')
    //                 ->where('teamid', $teammemberid->employee_name)
    //                 ->orderBy('enddate', 'desc')
    //                 ->first();

    //             $exitDate = Carbon::parse($lastsubmitdata->enddate);
    //             $exitMonth = $exitDate->format('F');
    //             $exitYear = $exitDate->year;

    //             $months = [
    //                 'January',
    //                 'February',
    //                 'March',
    //                 'April',
    //                 'May',
    //                 'June',
    //                 'July',
    //                 'August',
    //                 'September',
    //                 'October',
    //                 'November',
    //                 'December'
    //             ];


    //             $exitMonthIndex = array_search($exitMonth, $months);
    //             $monthsAfterExitMonth = array_slice($months, $exitMonthIndex + 1);

    //             // dd($monthsAfterExitMonth);
    //             $attendencedelete = DB::table('attendances')
    //                 ->where('employee_name', $teammemberid->employee_name)
    //                 ->where('year', $exitYear)
    //                 ->whereIn('month', $monthsAfterExitMonth)
    //                 // ->get();
    //                 ->delete();


    //             // dd($attendencedelete);
    //         }
    //     }

    //     dd('updated successfull');
    // }
}

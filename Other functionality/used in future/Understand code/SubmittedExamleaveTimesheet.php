<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Exports\TimesheetLastWeekExport;
use App\Models\Timesheetuser;
use DB;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class SubmittedExamleaveTimesheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:submittedexamleavetimesheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */

    // public function handle()
    // {

    //     // $nextweektimesheet = DB::table('timesheetusers')
    //     //     ->where('createdby', 847)
    //     //     ->whereBetween('date', ['2024-03-11', '2024-03-20'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);


    //     // $nextweektimesheet = DB::table('timesheets')
    //     //     ->where('created_by', 847)
    //     //     ->whereBetween('date', ['2024-03-11', '2024-03-20'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);

    //     // // dd('hi');

    //     // $nextweektimesheet = DB::table('timesheetreport')
    //     //     ->where('teamid', 847)
    //     //     ->where('startdate', '2024-03-11')
    //     //     // ->get();
    //     //     ->delete();

    //     // // dd($nextweektimesheet);

    //     // dd('hi');

    //     if ('Thursday' == date('l', time())) {

    //         $createdby = DB::table('timesheetusers')
    //             ->distinct()->pluck('createdby')->toArray();


    //         $timesheetleave = DB::table('timesheetusers')
    //             ->where('status', 0)
    //             ->where('assignment_id', 214)
    //             // ->whereIn('createdby', $createdby)
    //             ->where('createdby', 847)
    //             // ->select('assignment_id')
    //             ->get();

    //         // 2024-03-11 to 2024-03-20
    //         dd($timesheetleave);

    //         // 222222222222222222222222222222222222222222222222222222222222222222

    //         $usertimesheetfirstdate =  DB::table('timesheetusers')
    //             ->where('status', '0')
    //             ->where('assignment_id', 214)
    //             // ->where('createdby', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
    //             ->where('createdby', 847)->orderBy('date', 'ASC')->first();

    //         $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

    //         if ($usertimesheetfirstdate) {
    //             $firstDate = new DateTime($usertimesheetfirstdate->date);
    //             $dayOfWeek = $firstDate->format('w');

    //             $daysToAdd = 0;

    //             if ($dayOfWeek !== '0') {
    //                 $daysToAdd = 7 - $dayOfWeek;
    //             }

    //             if ($dayOfWeek > 0) {
    //                 $daysToSubtract = $dayOfWeek - 1;
    //             } else {
    //                 $daysToSubtract = $dayOfWeek;
    //             }
    //             $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
    //             $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
    //         }

    //         $get_six_Data = DB::table('timesheetusers')
    //             ->where('status', '0')
    //             ->where('assignment_id', 214)
    //             // ->where('created_by', auth()->user()->teammember_id)
    //             ->where('createdby', 847)
    //             ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
    //             ->orderBy('date', 'ASC')
    //             ->get();

    //         $lastdate = $get_six_Data->max('date');

    //         $retrievedDates = [];
    //         foreach ($get_six_Data as $entry) {
    //             $date = new DateTime($entry->date);
    //             $retrievedDates[] = $date->format('Y-m-d');
    //         }
    //         // 0 => "2024-03-11"
    //         // 1 => "2024-03-12"
    //         // 2 => "2024-03-13"
    //         // 3 => "2024-03-14"
    //         // 4 => "2024-03-15"
    //         // 5 => "2024-03-16"
    //         // 6 => "2024-03-17"

    //         $firstDate = new DateTime($presentWeekMonday);
    //         $upcomingSundayDate = new DateTime($upcomingSunday);
    //         $currentDate = clone $firstDate;

    //         $expectedDates = [];
    //         while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
    //             $expectedDates[] = $currentDate->format('Y-m-d');
    //             $currentDate->modify("+1 day");
    //         }

    //         $missingDates = array_diff($expectedDates, $retrievedDates);
    //         // dd($missingDates);
    //         if (!empty($missingDates)) {
    //             $count1 = count($missingDates);
    //             $missingDatesexist =  DB::table('timesheetusers')
    //                 // ->where('status', '0')
    //                 ->whereIn('date', $missingDates)
    //                 ->where('createdby', 847)
    //                 ->orderBy('date', 'ASC')
    //                 ->get();
    //             $count2 = $missingDatesexist->count();
    //             // dd($count1, $count2);
    //             // if ($count1 == $count2) {
    //             //     foreach ($get_six_Data as $getsixdata) {
    //             //         $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //             //         if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
    //             //             $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
    //             //             // Find the nearest next Saturday to the requested date
    //             //             $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

    //             //             $previousMondayFormatted = $getsixdata->date;
    //             //             $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //             //             $nextSaturdayFormatted = $lastdate;


    //             //             $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

    //             //             $co = DB::table('timesheetusers')
    //             //                 ->where('status', '0')
    //             //                 ->where('assignment_id', 214)
    //             //                 ->where('createdby', 847)
    //             //                 ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //             //                 ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //             //                 ->get();

    //             //             // 0 => {#3494 ▼
    //             //             //     +"total_hours": 56.0
    //             //             //     +"row_count": 7
    //             //             //   }

    //             //             foreach ($co as $codata) {
    //             //                 DB::table('timesheetreport')->insert([
    //             //                     'teamid'       =>     847,
    //             //                     'week'       =>     $week,
    //             //                     'totaldays'       =>     $codata->row_count,
    //             //                     'totaltime' =>  $codata->total_hours,
    //             //                     'startdate'  => $previousMondayFormatted,
    //             //                     'enddate'  => $nextSaturdayFormatted,
    //             //                     'created_at'                =>      date('y-m-d H:i:s'),
    //             //                 ]);
    //             //             }
    //             //         }

    //             //         DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
    //             //             'status'         =>     1,
    //             //             'updated_at'              =>     date('y-m-d H:i:s'),
    //             //         ]);

    //             //         DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
    //             //             'status'         =>     1,
    //             //             'updated_at'              =>     date('y-m-d H:i:s'),
    //             //         ]);
    //             //     }
    //             // }
    //         } else {
    //             // dd($get_six_Data, 'hi122');
    //             foreach ($get_six_Data as $getsixdata) {
    //                 $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //                 if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
    //                     $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
    //                     // Find the nearest next Saturday to the requested date
    //                     $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

    //                     $previousMondayFormatted = $getsixdata->date;
    //                     $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                     $nextSaturdayFormatted = $lastdate;


    //                     $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

    //                     $co = DB::table('timesheetusers')
    //                         ->where('status', '0')
    //                         ->where('assignment_id', 214)
    //                         ->where('createdby', 847)
    //                         ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //                         ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //                         ->get();

    //                     // 0 => {#3494 ▼
    //                     //     +"total_hours": 56.0
    //                     //     +"row_count": 7
    //                     //   }

    //                     foreach ($co as $codata) {
    //                         DB::table('timesheetreport')->insert([
    //                             'teamid'       =>     847,
    //                             'week'       =>     $week,
    //                             'totaldays'       =>     $codata->row_count,
    //                             'totaltime' =>  $codata->total_hours,
    //                             'startdate'  => $previousMondayFormatted,
    //                             'enddate'  => $nextSaturdayFormatted,
    //                             'created_at'                =>      date('y-m-d H:i:s'),
    //                         ]);
    //                     }
    //                 }

    //                 DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>     date('y-m-d H:i:s'),
    //                 ]);

    //                 DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>     date('y-m-d H:i:s'),
    //                 ]);
    //             }
    //         }

    //         //   return 'message'
    //     }
    // }

    // public function handle()
    // {

    //     // $nextweektimesheet = DB::table('timesheetusers')
    //     //     ->where('createdby', 847)
    //     //     ->whereBetween('date', ['2024-03-11', '2024-03-20'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);


    //     // $nextweektimesheet = DB::table('timesheets')
    //     //     ->where('created_by', 847)
    //     //     ->whereBetween('date', ['2024-03-11', '2024-03-20'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);

    //     // // dd('hi');

    //     // $nextweektimesheet = DB::table('timesheetreport')
    //     //     ->where('teamid', 847)
    //     //     ->where('startdate', '2024-03-11')
    //     //     // ->get();
    //     //     ->delete();

    //     // // dd($nextweektimesheet);

    //     // dd('hi');

    //     if ('Friday' == date('l', time())) {

    //         $usertimesheetfirstdate =  DB::table('timesheetusers')
    //             ->where('status', '0')
    //             ->where('assignment_id', 214)
    //             // ->where('createdby', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
    //             ->where('createdby', 847)->orderBy('date', 'ASC')->first();

    //         $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

    //         if ($usertimesheetfirstdate) {
    //             $firstDate = new DateTime($usertimesheetfirstdate->date);
    //             $dayOfWeek = $firstDate->format('w');

    //             $daysToAdd = 0;

    //             if ($dayOfWeek !== '0') {
    //                 $daysToAdd = 7 - $dayOfWeek;
    //             }

    //             if ($dayOfWeek > 0) {
    //                 $daysToSubtract = $dayOfWeek - 1;
    //             } else {
    //                 $daysToSubtract = $dayOfWeek;
    //             }
    //             $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
    //             $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
    //         }

    //         $get_six_Data = DB::table('timesheetusers')
    //             ->where('status', '0')
    //             ->where('assignment_id', 214)
    //             // ->where('created_by', auth()->user()->teammember_id)
    //             ->where('createdby', 847)
    //             ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
    //             ->orderBy('date', 'ASC')
    //             ->get();

    //         $lastdate = $get_six_Data->max('date');

    //         $retrievedDates = [];
    //         foreach ($get_six_Data as $entry) {
    //             $date = new DateTime($entry->date);
    //             $retrievedDates[] = $date->format('Y-m-d');
    //         }

    //         $firstDate = new DateTime($presentWeekMonday);
    //         $upcomingSundayDate = new DateTime($upcomingSunday);
    //         $currentDate = clone $firstDate;

    //         $expectedDates = [];
    //         while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
    //             $expectedDates[] = $currentDate->format('Y-m-d');
    //             $currentDate->modify("+1 day");
    //         }

    //         $missingDates = array_diff($expectedDates, $retrievedDates);
    //         if (empty($missingDates)) {
    //             dd('hi shah');
    //         } else {
    //             dd('hi222');
    //             foreach ($get_six_Data as $getsixdata) {
    //                 $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //                 if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
    //                     $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
    //                     // Find the nearest next Saturday to the requested date
    //                     $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

    //                     $previousMondayFormatted = $getsixdata->date;
    //                     $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                     $nextSaturdayFormatted = $lastdate;

    //                     $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

    //                     $co = DB::table('timesheetusers')
    //                         ->where('status', '0')
    //                         ->where('assignment_id', 214)
    //                         ->where('createdby', 847)
    //                         ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //                         ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //                         ->get();

    //                     foreach ($co as $codata) {
    //                         DB::table('timesheetreport')->insert([
    //                             'teamid'       =>     847,
    //                             'week'       =>     $week,
    //                             'totaldays'       =>     $codata->row_count,
    //                             'totaltime' =>  $codata->total_hours,
    //                             'startdate'  => $previousMondayFormatted,
    //                             'enddate'  => $nextSaturdayFormatted,
    //                             'created_at'                =>      date('y-m-d H:i:s'),
    //                         ]);
    //                     }
    //                 }

    //                 DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>     date('y-m-d H:i:s'),
    //                 ]);

    //                 DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>     date('y-m-d H:i:s'),
    //                 ]);
    //             }
    //         }

    //         //   return 'message'
    //     }
    // }
    //! ok done  for one user 
    // public function handle()
    // {

    //     // $nextweektimesheet = DB::table('timesheetusers')
    //     //     ->where('createdby', 847)
    //     //     ->whereBetween('date', ['2024-03-11', '2024-03-20'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);


    //     // $nextweektimesheet = DB::table('timesheets')
    //     //     ->where('created_by', 847)
    //     //     ->whereBetween('date', ['2024-03-11', '2024-03-20'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);

    //     // // dd('hi');

    //     // $nextweektimesheet = DB::table('timesheetreport')
    //     //     ->where('teamid', 847)
    //     //     ->where('startdate', '2024-03-11')
    //     //     // ->get();
    //     //     ->delete();

    //     // // dd($nextweektimesheet);

    //     // dd('hi');


    //     if ('Friday' == date('l', time())) {

    //         $usertimesheetfirstdate =  DB::table('timesheetusers')
    //             ->where('status', '0')
    //             ->where('assignment_id', 214)
    //             // ->where('createdby', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
    //             ->where('createdby', 847)->orderBy('date', 'ASC')->first();

    //         $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);


    //         // $date = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date);
    //         // $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(3);
    //         // $todaydate = Carbon::now('Asia/Kolkata');
    //         //// if wednesday of previus week then 
    //         // if ($autosubmitdate->isSameDay($todaydate)) {
    //         //     dd('hi date');
    //         // }

    //         // dd($date);

    //         // $autosubmitdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(9);
    //         // // $autosubmitdate = Carbon::createFromFormat('Y-m-d', '2024-02-26' ?? '')->addDays(11);
    //         // $todaydate = Carbon::now('Asia/Kolkata');


    //         // // if ($autosubmitdate->isSameDay($todaydate)) {
    //         // //     dd('hi date');
    //         // // }

    //         if ($usertimesheetfirstdate) {
    //             $firstDate = new DateTime($usertimesheetfirstdate->date);
    //             $dayOfWeek = $firstDate->format('w');

    //             $daysToAdd = 0;

    //             if ($dayOfWeek !== '0') {
    //                 $daysToAdd = 7 - $dayOfWeek;
    //             }

    //             if ($dayOfWeek > 0) {
    //                 $daysToSubtract = $dayOfWeek - 1;
    //             } else {
    //                 $daysToSubtract = $dayOfWeek;
    //             }
    //             $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
    //             $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
    //         }

    //         $get_six_Data = DB::table('timesheetusers')
    //             ->where('status', '0')
    //             ->where('assignment_id', 214)
    //             // ->where('created_by', auth()->user()->teammember_id)
    //             ->where('createdby', 847)
    //             ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
    //             ->orderBy('date', 'ASC')
    //             ->get();

    //         $lastdate = $get_six_Data->max('date');

    //         $retrievedDates = [];
    //         foreach ($get_six_Data as $entry) {
    //             $date = new DateTime($entry->date);
    //             $retrievedDates[] = $date->format('Y-m-d');
    //         }

    //         $firstDate = new DateTime($presentWeekMonday);
    //         $upcomingSundayDate = new DateTime($upcomingSunday);
    //         $currentDate = clone $firstDate;

    //         $expectedDates = [];
    //         while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
    //             $expectedDates[] = $currentDate->format('Y-m-d');
    //             $currentDate->modify("+1 day");
    //         }

    //         $missingDates = array_diff($expectedDates, $retrievedDates);
    //         if (empty($missingDates)) {
    //             // dd('hi2');
    //             foreach ($get_six_Data as $getsixdata) {
    //                 $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //                 if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
    //                     $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
    //                     // Find the nearest next Saturday to the requested date
    //                     $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

    //                     $previousMondayFormatted = $getsixdata->date;
    //                     $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                     $nextSaturdayFormatted = $lastdate;

    //                     $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

    //                     $co = DB::table('timesheetusers')
    //                         ->where('status', '0')
    //                         ->where('assignment_id', 214)
    //                         ->where('createdby', 847)
    //                         ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //                         ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //                         ->get();

    //                     foreach ($co as $codata) {
    //                         DB::table('timesheetreport')->insert([
    //                             'teamid'       =>     847,
    //                             'week'       =>     $week,
    //                             'totaldays'       =>     $codata->row_count,
    //                             'totaltime' =>  $codata->total_hours,
    //                             'startdate'  => $previousMondayFormatted,
    //                             'enddate'  => $nextSaturdayFormatted,
    //                             'created_at'                =>      date('y-m-d H:i:s'),
    //                         ]);
    //                     }
    //                 }

    //                 DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>     date('y-m-d H:i:s'),
    //                 ]);

    //                 DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
    //                     'status'         =>     1,
    //                     'updated_at'              =>     date('y-m-d H:i:s'),
    //                 ]);
    //             }
    //         }

    //         //   return 'message'
    //     }
    // }

    //! ok done  for All user 
    // public function handle()
    // {

    //     // $nextweektimesheet = DB::table('timesheetusers')
    //     //     ->where('createdby', 847)
    //     //     ->whereBetween('date', ['2024-02-26', '2024-03-04'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);


    //     // $nextweektimesheet = DB::table('timesheets')
    //     //     ->where('created_by', 847)
    //     //     ->whereBetween('date', ['2024-02-26', '2024-03-04'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);

    //     // // dd('hi');

    //     // $nextweektimesheet = DB::table('timesheetreport')
    //     //     ->where('teamid', 847)
    //     //     ->where('startdate', '2024-02-26')
    //     //     // ->get();
    //     //     ->delete();

    //     // // dd($nextweektimesheet);

    //     // dd('hi');

    //     // 222222222222222222

    //     // $nextweektimesheet = DB::table('timesheetusers')
    //     //     ->where('createdby', 913)
    //     //     ->whereBetween('date', ['2024-04-15', '2024-04-24'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);


    //     // $nextweektimesheet = DB::table('timesheets')
    //     //     ->where('created_by', 913)
    //     //     ->whereBetween('date', ['2024-04-15', '2024-04-24'])
    //     //     // ->get();
    //     //     ->update(['status' => 0]);

    //     // // dd('hi');

    //     // $nextweektimesheet = DB::table('timesheetreport')
    //     //     ->where('teamid', 913)
    //     //     ->where('startdate', '2024-04-15')
    //     //     // ->get();
    //     //     ->delete();

    //     // // dd($nextweektimesheet);

    //     // dd('hi');

    //     // it wil be run on Wednesday


    //     if ('Friday' == date('l', time())) {

    //         $createdbyList = DB::table('timesheetusers')->distinct()->pluck('createdby')->toArray();

    //         // Implementation for all employee
    //         foreach ($createdbyList as $createdby) {
    //             // Exam leave data 
    //             $usertimesheetfirstdate =  DB::table('timesheetusers')
    //                 ->where('status', '0')
    //                 ->where('assignment_id', 214)
    //                 ->where('createdby', $createdby)
    //                 ->orderBy('date', 'ASC')->first();

    //             if ($usertimesheetfirstdate && !empty($usertimesheetfirstdate->date)) {
    //                 $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date)->addDays(6);

    //                 $firstDate = new DateTime($usertimesheetfirstdate->date);
    //                 $dayOfWeek = $firstDate->format('w');

    //                 $daysToAdd = 0;

    //                 if ($dayOfWeek !== '0') {
    //                     $daysToAdd = 7 - $dayOfWeek;
    //                 }

    //                 if ($dayOfWeek > 0) {
    //                     $daysToSubtract = $dayOfWeek - 1;
    //                 } else {
    //                     $daysToSubtract = $dayOfWeek;
    //                 }
    //                 $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
    //                 $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');

    //                 $get_six_Data = DB::table('timesheetusers')
    //                     ->where('status', '0')
    //                     ->where('assignment_id', 214)
    //                     ->where('createdby', $createdby)
    //                     ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
    //                     ->orderBy('date', 'ASC')
    //                     ->get();

    //                 $lastdate = $get_six_Data->max('date');

    //                 $retrievedDates = [];
    //                 foreach ($get_six_Data as $entry) {
    //                     $date = new DateTime($entry->date);
    //                     $retrievedDates[] = $date->format('Y-m-d');
    //                 }

    //                 $firstDate = new DateTime($presentWeekMonday);
    //                 $upcomingSundayDate = new DateTime($upcomingSunday);
    //                 $currentDate = clone $firstDate;

    //                 $expectedDates = [];
    //                 while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {
    //                     //excluding sunday
    //                     $expectedDates[] = $currentDate->format('Y-m-d');
    //                     $currentDate->modify("+1 day");
    //                 }

    //                 $missingDates = array_diff($expectedDates, $retrievedDates);
    //                 if (empty($missingDates)) {
    //                     foreach ($get_six_Data as $getsixdata) {
    //                         $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

    //                         if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
    //                             $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
    //                             // Find the nearest next Saturday to the requested date
    //                             $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

    //                             $previousMondayFormatted = $getsixdata->date;
    //                             $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
    //                             $nextSaturdayFormatted = $lastdate;

    //                             $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

    //                             $co = DB::table('timesheetusers')
    //                                 ->where('status', '0')
    //                                 ->where('assignment_id', 214)
    //                                 ->where('createdby', $createdby)
    //                                 ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
    //                                 ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
    //                                 ->get();

    //                             foreach ($co as $codata) {
    //                                 DB::table('timesheetreport')->insert([
    //                                     'teamid'       =>     $createdby,
    //                                     'week'       =>     $week,
    //                                     'totaldays'       =>     $codata->row_count,
    //                                     'totaltime' =>  $codata->total_hours,
    //                                     'startdate'  => $previousMondayFormatted,
    //                                     'enddate'  => $nextSaturdayFormatted,
    //                                     'created_at'                =>      date('y-m-d H:i:s'),
    //                                 ]);
    //                             }
    //                         }

    //                         DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
    //                             'status'         =>     1,
    //                             'updated_at'              =>     date('y-m-d H:i:s'),
    //                         ]);

    //                         DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
    //                             'status'         =>     1,
    //                             'updated_at'              =>     date('y-m-d H:i:s'),
    //                         ]);
    //                     }
    //                 }

    //                 //   return 'message'
    //             }
    //         }
    //     }
    // }

    //! ok done  for All user and also condition apply done 
    public function handle()
    {
        if ('Wednesday' == date('l', time())) {
            // All employee temmeber id 
            $createdbyList = DB::table('timesheetusers')->distinct()->pluck('createdby')->toArray();

            // Implementation for all employee
            foreach ($createdbyList as $createdby) {
                // Exam leave data get hare
                $usertimesheetfirstdate =  DB::table('timesheetusers')
                    ->where('status', '0')
                    ->where('assignment_id', 214)
                    ->where('createdby', $createdby)
                    ->orderBy('date', 'ASC')->first();
                // Exam leave data should not be empty
                if ($usertimesheetfirstdate && !empty($usertimesheetfirstdate->date)) {

                    $date = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date);
                    // Automatic submit will be on this date 
                    // find days name Wednesday 
                    $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(3);
                    // $autosubmitdate = $date->copy()->next(Carbon::SUNDAY)->addDays(5);
                    $todaydate = Carbon::now('Asia/Kolkata');

                    //autosubmitdate and todaydate should be same 
                    if ($autosubmitdate->isSameDay($todaydate)) {
                        $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date)->addDays(6);

                        $firstDate = new DateTime($usertimesheetfirstdate->date);
                        $dayOfWeek = $firstDate->format('w');

                        $daysToAdd = 0;

                        if ($dayOfWeek !== '0') {
                            $daysToAdd = 7 - $dayOfWeek;
                        }

                        if ($dayOfWeek > 0) {
                            $daysToSubtract = $dayOfWeek - 1;
                        } else {
                            $daysToSubtract = $dayOfWeek;
                        }
                        $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
                        $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');

                        // Get six data of exam leave 
                        $get_six_Data = DB::table('timesheetusers')
                            ->where('status', '0')
                            ->where('assignment_id', 214)
                            ->where('createdby', $createdby)
                            ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                            ->orderBy('date', 'ASC')
                            ->get();

                        $lastdate = $get_six_Data->max('date');

                        // get date only of retrived data 
                        $retrievedDates = [];
                        foreach ($get_six_Data as $entry) {
                            $date = new DateTime($entry->date);
                            $retrievedDates[] = $date->format('Y-m-d');
                        }

                        $firstDate = new DateTime($presentWeekMonday);
                        $upcomingSundayDate = new DateTime($upcomingSunday);
                        $currentDate = clone $firstDate;

                        $expectedDates = [];
                        while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {
                            //excluding sunday
                            $expectedDates[] = $currentDate->format('Y-m-d');
                            $currentDate->modify("+1 day");
                        }

                        $missingDates = array_diff($expectedDates, $retrievedDates);
                        // missing date should be empty 
                        if (empty($missingDates)) {
                            foreach ($get_six_Data as $getsixdata) {
                                $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);

                                if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {
                                    $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
                                    // Find the nearest next Saturday to the requested date
                                    $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
                                    $previousMondayFormatted = $getsixdata->date;
                                    $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                                    $nextSaturdayFormatted = $lastdate;

                                    $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

                                    $co = DB::table('timesheetusers')
                                        ->where('status', '0')
                                        ->where('assignment_id', 214)
                                        ->where('createdby', $createdby)
                                        ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                        ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                        ->get();

                                    foreach ($co as $codata) {
                                        DB::table('timesheetreport')->insert([
                                            'teamid'       =>     $createdby,
                                            'week'       =>     $week,
                                            'totaldays'       =>     $codata->row_count,
                                            'totaltime' =>  $codata->total_hours,
                                            'startdate'  => $previousMondayFormatted,
                                            'enddate'  => $nextSaturdayFormatted,
                                            'created_at'                =>      date('y-m-d H:i:s'),
                                        ]);
                                    }
                                }

                                DB::table('timesheetusers')->where('id', $getsixdata->id)->update([
                                    'status'         =>     1,
                                    'updated_at'              =>     date('y-m-d H:i:s'),
                                ]);

                                DB::table('timesheets')->where('id', $getsixdata->timesheetid)->update([
                                    'status'         =>     1,
                                    'updated_at'              =>     date('y-m-d H:i:s'),
                                ]);
                            }
                        }

                        //   return 'message'
                    }
                }
            }
        }
    }
}

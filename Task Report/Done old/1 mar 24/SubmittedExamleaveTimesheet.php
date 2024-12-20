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

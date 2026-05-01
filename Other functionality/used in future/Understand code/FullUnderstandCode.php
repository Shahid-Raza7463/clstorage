<?php

class ZipController extends Controller
{
//*
//*
//*
//*
public function handle()
{
    // if (now()->format('H:i') === '18:00') {
    if ('Thursday' == date('l', time()) || 'Saturday' == date('l', time())) {
        // Get data that is not fill timesheet
        // $teammember =  DB::table('teammembers')
        //     ->whereNotIn('id', function ($query) {
        //         $query->select('createdby')->from('timesheetusers');
        //     })
        //     ->where('teammembers.status', 1)
        //     ->whereIn('teammembers.role_id', [13, 14, 15]);

        // $teammemberChunks = array_chunk($teammember->pluck('id')->toArray(), 1000);

        // foreach ($teammemberChunks as $chunk) {
        //     $teammembersChunk = DB::table('teammembers')
        //         ->whereIn('id', $chunk)
        //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
        //         ->get();
        //     // dd($teammembersChunk);
        //     foreach ($teammembersChunk as $teammembermail) {
        //         $data = array(
        //             'subject' => "Reminder || Timesheet not filled till date",
        //             'name' =>   $teammembermail->team_member,
        //             'email' =>   $teammembermail->emailid,
        //         );
        //         Mail::send('emails.timesheetnotfilledstaffremidner', $data, function ($msg) use ($data) {
        //             $msg->to($data['email']);
        //             $msg->subject($data['subject']);
        //         });
        //     }
        // }


        // 222222222222222222222222222222222222
        // another mail start from hare
        $teammembers = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            ->where('teammembers.status', 1)
            ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())
            ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
            ->distinct('timesheetusers.createdby')
            ->get();


        // Get the last submission date for each user only sunday and suterday
        // foreach ($teammembers as $user) {

        //     $lastSubmissionDate = DB::table('timesheetusers')
        //         // get all date of this user
        //         ->where('createdby', $user->id)
        //         ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
        //         ->where('status', '!=', 0)
        //         ->where(function ($query) {
        //             $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
        //                 ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
        //         })
        //         ->max('date');


        //     // Format the date as 'd-m-y'
        //     // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
        //     $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
        //     $user->last_submission_date = $lastSubmissionDate;
        // }

        // find previus sunday 
        // $previewsunday = now()->subWeeks(1)->endOfWeek();
        // $previewsundayformate = $previewsunday->format('d-m-Y');

        $previewsunday1 = Carbon::parse('2024-09-05');
        $previewsunday =  $previewsunday1->subWeeks(1)->endOfWeek();
        $previewsundayformate = $previewsunday->format('d-m-Y');


        // // find previus saturday
        // $previewsaturday = now()->subWeeks(1)->endOfWeek();
        // // Subtract one day from sunday
        // $previewsaturdaydate = $previewsaturday->subDay();
        // $previewsaturdaydateformate = $previewsaturdaydate->format('d-m-Y');


        $previewsunday11 = Carbon::parse('2024-09-05');
        $previewsaturday = $previewsunday11->subWeeks(1)->endOfWeek();
        // Subtract one day from sunday
        $previewsaturdaydate = $previewsaturday->subDay();
        $previewsaturdaydateformate = $previewsaturdaydate->format('d-m-Y');


        foreach ($teammembers as $teammembermail) {
            // both date store in an array 
            $validDates = [$previewsundayformate, $previewsaturdaydateformate];
            dd($validDates);
            if (!in_array($teammembermail->last_submission_date, $validDates)) {
                $data = array(
                    'subject' => "Reminder || Timesheet not filled Last Week",
                    'name' =>   $teammembermail->team_member,
                    'email' =>   $teammembermail->emailid,
                );

                Mail::send('emails.timesheetnotfilledstafflastweekremidner', $data, function ($msg) use ($data) {
                    $msg->to($data['email']);
                    $msg->subject($data['subject']);
                });
            }
        }
    }
    // }
}
//*  regarding attendance 

 //! 20-02-2024 understanding
 public function handle()
 {



     // $nextweektimesheet1 = DB::table('timesheetusers')
     //     ->where('createdby', 847)
     //     ->whereBetween('date', ['2024-07-15', '2024-07-20'])
     //     // ->get();
     //     ->update(['status' => 0]);


     // $nextweektimesheet2 = DB::table('timesheets')
     //     ->where('created_by', 847)
     //     ->whereBetween('date', ['2024-07-15', '2024-07-20'])
     //     // ->get();
     //     ->update(['status' => 0]);

     // $nextweektimesheet3 = DB::table('timesheetreport')
     //     ->where('teamid', 847)
     //     ->where('startdate', '2024-07-15')
     //     // ->get();
     //     ->delete();

     // dd('hi');

     // 2222222222222222222222222222222222222222222

     $currentDate = now()->subDay(); // Get the previous day from the current date
     // 2024-07-22
     $currentMonth = $currentDate->format('F');
     $currentYear = $currentDate->format('Y');


     // Define the attendance period from 26th of the previous month to 25th of the current month
     $attendanceStartDate = Carbon::create($currentYear, $currentDate->copy()->subMonth()->format('m'), 26);
     // 2024-07-26
     $attendanceEndDate = Carbon::create($currentYear, $currentDate->format('m'), 25);
     // 2024-08-25

     // Calculate total days in the period (from 26th of prev month to 25th of current month)
     $totalDays = $attendanceStartDate->diffInDays($attendanceEndDate) + 1;
     // 31 days


     $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
         ->where('attendances.month', $currentMonth)
         ->whereYear('attendances.created_at', $currentYear)
         ->whereNotNull('teammembers.joining_date')
         //->where('teammembers.id',739)
         ->get();


     foreach ($teammembers as $team) {
         $attendanceStartDate = Carbon::parse($attendanceStartDate, 'Asia/Kolkata')->startOfDay()->setTimezone('UTC');
         // 2024-07-25 
         $attendanceEndDate = Carbon::parse($attendanceEndDate, 'Asia/Kolkata')->endOfDay()->setTimezone('UTC');
         // 2024-08-25


         $getholidaydates = DB::table('holidays')
             ->where(function ($query) use ($attendanceStartDate, $attendanceEndDate) {
                 $query->whereBetween('startdate', [$attendanceStartDate, $attendanceEndDate])
                     ->orWhereBetween('enddate', [$attendanceStartDate, $attendanceEndDate]);
             })
             ->where('startdate', '>', $team->joining_date)
             ->get();


         $holidayCount = 0;
         foreach ($getholidaydates as $holiday) {
             $holidayCount += intval($holiday->number_of_dates);
         }
         // 2
         // dd($holidayCount);
         // remove date hare 
         $keysToFilter = [
             'twentysix',
             'twentyseven',
             'twentyeight',
             'twentynine',
             'thirty',
             'thirtyone',
             'one',
             'two',
             'three',
             'four',
             'five',
             'six',
             'seven',
             'eight',
             'nine',
             'ten',
             'eleven',
             'twelve',
             'thirteen',
             'fourteen',
             'fifteen',
             'sixteen',
             'seventeen',
             'eighteen',
             'ninghteen',
             'twenty',
             'twentyone',
             'twentytwo',
             'twentythree',
             'twentyfour',
             'twentyfive'
         ];

         $dayMapping = [
             'twentysix' => 26,
             'twentyseven' => 27,
             'twentyeight' => 28,
             'twentynine' => 29,
             'thirty' => 30,
             'thirtyone' => 31,
             'one' => 1,
             'two' => 2,
             'three' => 3,
             'four' => 4,
             'five' => 5,
             'six' => 6,
             'seven' => 7,
             'eight' => 8,
             'nine' => 9,
             'ten' => 10,
             'eleven' => 11,
             'twelve' => 12,
             'thirteen' => 13,
             'fourteen' => 14,
             'fifteen' => 15,
             'sixteen' => 16,
             'seventeen' => 17,
             'eighteen' => 18,
             'ninghteen' => 19,
             'twenty' => 20,
             'twentyone' => 21,
             'twentytwo' => 22,
             'twentythree' => 23,
             'twentyfour' => 24,
             'twentyfive' => 25,
         ];

         $daysToRemove = [];
         if ($totalDays < 31) {
             $daysToRemove[] = 'thirtyone';
         }

         if ($totalDays < 30) {
             $daysToRemove[] = 'thirty';
         }

         if ($totalDays < 29) {
             $daysToRemove[] = 'twentynine';
         }
         $keysToFilter = array_diff($keysToFilter, $daysToRemove);

         // remove date hare end


         $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));

         $casualLeaveCount = 0;
         $sickLeaveCount = 0;
         $dayspresent = 0;
         $absentCount = 0;


         foreach ($days as $key => $value) {

             // hare $keys= twentysix
             $dayOfMonth = $dayMapping[$key] ?? 0;
             // 26
             $month = $currentMonth;
             $year = $currentYear;

             if (in_array($dayOfMonth, [26, 27, 28, 29, 30, 31])) {

                 // previous months date 
                 $previousMonthDate = $currentDate->copy()->subMonth();
                 // 2024-07-22
                 $month = $previousMonthDate->format('m');
                 // "07"
                 $year = $previousMonthDate->format('Y');
             } else {
                 $month = $currentDate->format('m');
                 // "08"
                 $year = $currentDate->format('Y');
             }



             // Correctly format the target date
             $targetDate = Carbon::createFromFormat('Y-m-d', "$year-$month-$dayOfMonth")->format('Y-m-d');
             // hare  "$year-$month-$dayOfMonth" 2024-07-26
             // hare   targetDate  = "2024-07-26"

             $isHoliday = DB::table('holidays')->where(function ($query) use ($targetDate) {
                 $query->where('startdate', '<=', $targetDate)
                     ->where('enddate', '>=', $targetDate);
             })->exists();

             // false

             if ($value === null) {
                 // hare $value = "SL/C", 8,7,8  basically this is attandance value 
                 if (!$isHoliday) {
                     $absentCount++;
                     //    1
                 } elseif ($targetDate < $team->joining_date) {
                     $absentCount++;
                 }
             }
             // else if (is_numeric($value) && !$isHoliday) {
             //     $dayspresent++;
             // } 
             // else if (!is_numeric($value) && !$isHoliday) {
             //     $dayspresent++;
             // } 
             else if ($value == 'P' && !$isHoliday) {
                 $dayspresent++;
             } else if ($value == 'CL') {
                 $casualLeaveCount++;
             } else if ($value == 'EL') {
                 $sickLeaveCount++;
                 // 1
             }
         }


         //dd($casualLeaveCount);
         $attendance_existing = DB::table('attendances')->where('employee_name', $team->employee_name)
             ->where('month', $currentMonth)
             ->where('year', $currentYear)
             ->first();


         if ($dayspresent == 0) {
             $holidayCount = 0;
         }
         // 4


         $casualLeave = $casualLeaveCount;
         $sickLeave =  $sickLeaveCount;
         // $lwpLeave = $lwpLeaveCount;

         // $totalCount = $dayspresent + $attendance_existing->casual_leave + $attendance_existing->sick_leave + $attendance_existing->birthday_religious + $holidayCount;


         $attendanceData = [
             'no_of_days_present' => $dayspresent,
             // 'totaldaystobepaid' => $totalCount,
             'total_no_of_days' => $totalDays,
             'absent' => $absentCount,
             'weekend' => $holidayCount,
             'casual_leave' => $casualLeave,
             'sick_leave' => $sickLeave,
             // 'lwp' => $lwpLeave,
         ];

         // dd($attendanceData, 1);


         DB::table('attendances')->where('employee_name', $team->employee_name)
             ->where('month', $currentMonth)
             ->where('year', $currentYear)
             ->update($attendanceData);
     }

     return "Attendance updated";
 }
 //! 20-02-2024 understanding
public function store(Request $request)
{

  try {
    $Newteammeber = DB::table('timesheetusers')
      ->where('createdby', auth()->user()->teammember_id)
      ->first();

    // check promotion data
    $pormotionandrejoiningdata = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
      ->where('teammembers.id', auth()->user()->teammember_id)
      ->select(
        'teammembers.team_member',
        'teammembers.staffcode',
        'teammembers.joining_date',
        'teamrolehistory.newstaff_code',
        'teamrolehistory.rejoiningdate',
        'rejoiningsamepost.rejoiningdate as samepostrejoiningdate'
      )
      ->first();




    $joining_date = $pormotionandrejoiningdata->joining_date ?
      Carbon::parse($pormotionandrejoiningdata->joining_date)->format('d-m-Y') : null;

    $rejoining_date = null;
    if ($pormotionandrejoiningdata->rejoiningdate || $pormotionandrejoiningdata->samepostrejoiningdate) {
      $rejoining_date = Carbon::parse($pormotionandrejoiningdata->rejoiningdate ?? $pormotionandrejoiningdata->samepostrejoiningdate)
        ->format('d-m-Y');
      $rejoiningDateformate = Carbon::parse($rejoining_date);
    }

    $requestDate = Carbon::parse($request->date);
    $joiningDate = Carbon::parse($joining_date);


    if ($Newteammeber == null || $rejoining_date != null) {
      dd($request, 1);

      if ($rejoining_date != null && $requestDate < $rejoiningDateformate) {
        $output = array('msg' => 'You can not fill timesheet before Rejoining date :' . $rejoining_date);
        // dd($output, 1);
        return redirect('timesheet/mylist')->with('statuss', $output);
      }

      if ($requestDate < $joiningDate) {
        $output = array('msg' => 'You can not fill timesheet before joining date :' . $joining_date);
        return redirect('timesheet/mylist')->with('statuss', $output);
      }

      if ($Newteammeber == null) {
        // Get previuse sunday from joining date
        $joining_timestamp = strtotime($joining_date);
        $day_of_week = date('w', $joining_timestamp);
        $days_to_subtract = $day_of_week;
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
        // Get all dates beetween two dates 
        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);
        $period = CarbonPeriod::create($startDate, $endDate);
      }
      //this code related rejoining teammember 
      else {
        $joining_timestamp = strtotime($rejoining_date);
        $day_of_week = date('w', $joining_timestamp);
        $days_to_subtract = $day_of_week;
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);
        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);
        // Get all dates beetween two dates 
        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($rejoining_date);
        $period = CarbonPeriod::create($startDate, $endDate);
      }

      // store all date in $result vairable
      $result = [];
      foreach ($period as $key => $date) {
        if ($key !== 0 && $key !== count($period) - 1) {
          $result[] = $date->toDateString();
        }
      }
      // return $result;
      // dd('yes', $result);
      foreach ($result as $date) {
        $prevcheck = DB::table('timesheets')->where('date', $date)
          ->where('created_by', auth()->user()->teammember_id)
          ->first();

        if (($Newteammeber == null && $prevcheck == null) || ($rejoining_date != null && $prevcheck == null)) {
          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>   date('F', strtotime($date)),
              'date'     =>    date('Y-m-d', strtotime($date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );
          DB::table('timesheetusers')->insert([
            'date'     =>   date('Y-m-d', strtotime($date)),
            'client_id'     =>     29,
            'workitem'     =>     'NA',
            'location'     =>     'NA',
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>     date('Y-m-d', strtotime($date)),
            'hour'     =>     0,
            'totalhour' =>      0,
            'assignment_id'     =>     213,
            'partner'     =>     887,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);
        }
      }
    }

    // dd($pormotionandrejoiningdata);
    if ($requestDate >= $joiningDate) {


      if ($rejoining_date != null && $requestDate < $rejoiningDateformate) {
        // dd('hi', 1);
        $output = array('msg' => 'You can not fill timesheet before Rejoining date :' . $rejoining_date);
        return redirect('timesheet')->with('success', $output);
      }
      // dd('hi', 0);

      $data = $request->except(['_token', 'teammember_id', 'amount']);

      // check allready submited
      if (date('w', strtotime($request->date)) == 0) {
        $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->date)));
        $previousSaturdayFilled = DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', $previousSaturday)
          ->where('status', 1)
          ->first();
        // dd('hi1', $previousSaturdayFilled);
        if ($previousSaturdayFilled != null) {
          $output = array('msg' => 'You already submitted for this week');
          return back()->with('success', $output);
        }
      }

      // check hour
      $hours = $request->input('totalhour');
      if (!is_numeric($hours) || $hours > 12) {
        $output = array('msg' => 'The total hours cannot be greater than 12');
        return back()->with('success', $output);
      }
      // dd(auth()->user()->teammember_id);
      //? dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"
      $previouschck = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('date', date('Y-m-d', strtotime($request->date)))
        ->where('status', 1)
        ->first();

      if ($previouschck != null) {
        //dd('hi');
        $output = array('msg' => 'You already submitted for this week');
        return back()->with('success', $output);
      }

      $previoussavechck = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('date', date('Y-m-d', strtotime($request->date)))
        ->where('status', 0)
        ->first();

      if ($previoussavechck != null) {
        //dd('hi');
        $output = array('msg' => 'You already submitted for this date');
        return back()->with('success', $output);
      }



      $currentDate = Carbon::now()->format('d-m-Y');
      //dd($currentHour);
      if ($currentDate == $request->date && Carbon::now()->hour < 18) {
        //   //dd('hi');
        $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
        return back()->with('success', $output);
      }


      $leaves = DB::table('applyleaves')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->where('status', '!=', 2)
        ->select('applyleaves.from', 'applyleaves.to')
        ->get();
      // dd('hi 1', $leaves);
      foreach ($leaves as $leave) {
        //Convert each data from table to Y-m-d format to compare
        $days = CarbonPeriod::create(
          date('Y-m-d', strtotime($leave->from)),
          date('Y-m-d', strtotime($leave->to))
        );

        foreach ($days as $day) {
          $leavess[] = $day->format('Y-m-d');
        }
      }
      // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"
      $currentday = date('Y-m-d', strtotime($request->date));
      // dd('hi 2', $currentday);
      // $ifcount=0;
      //  $elsecount=0;
      if (count($leaves) != 0) {

        //dd('if');
        foreach ($leavess as $leave) {
          // echo"<pre>";
          //  print_r($leave);

          if ($leave == $currentday) {
            //dd('if');
            // $ifcount=$ifcount+1;
            $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
            return redirect('timesheet')->with('statuss', $output);
          }
        }
      }

      // insert data in timesheet from request and get id 
      // $id = DB::table('timesheets')->insertGetId(
      //   [
      //     'created_by' => auth()->user()->teammember_id,
      //     'month'     =>    date('F', strtotime($request->date)),
      //     'date'     =>    date('Y-m-d', strtotime($request->date)),
      //     'created_at'          =>     date('Y-m-d H:i:s'),
      //   ]
      // );


      $count = count($request->assignment_id);

      // dd('hi 3', $count);
      for ($i = 0; $i < $count; $i++) {
        //dd($request->workitem[$i]);
        $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

        // $a = DB::table('timesheetusers')->insert([
        //   'date'     =>     $request->date,
        //   'client_id'     =>     $request->client_id[$i],
        //   'assignmentgenerate_id'     =>     $request->assignment_id[$i],
        //   'workitem'     =>     $request->workitem[$i],
        //   'location'     =>     $request->location[$i],
        //   //   'billable_status'     =>     $request->billable_status[$i],
        //   'timesheetid'     =>     $id,
        //   'date'     =>     date('Y-m-d', strtotime($request->date)),
        //   'hour'     =>     $request->hour[$i],
        //   'totalhour' =>      $request->totalhour,
        //   'assignment_id'     =>     $assignment->assignment_id,
        //   'partner'     =>     $request->partner[$i],
        //   'createdby' => auth()->user()->teammember_id,
        //   'created_at'          =>     date('Y-m-d H:i:s'),
        //   'updated_at'              =>    date('Y-m-d H:i:s'),
        // ]);

        if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
          // dd($request);
          $gettotalteamhour = DB::table('assignmentmappings')
            ->leftJoin(
              'assignmentteammappings',
              'assignmentteammappings.assignmentmapping_id',
              'assignmentmappings.id',
            )
            ->where(
              'assignmentmappings.assignmentgenerate_id',
              $request->assignment_id[$i]
            )
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->first();

          if ($gettotalteamhour) {
            $gettotalteamhour = $gettotalteamhour->teamhour;
            // dd($gettotalteamhour);

            $finalresult =  $gettotalteamhour + $request->hour[$i];

            $totalteamhourupdate = DB::table('assignmentmappings')
              ->leftJoin(
                'assignmentteammappings',
                'assignmentteammappings.assignmentmapping_id',
                'assignmentmappings.id',
              )
              ->where(
                'assignmentmappings.assignmentgenerate_id',
                $request->assignment_id[$i]
              )
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              // ->get();
              ->update(['teamhour' =>  $finalresult]);
          }
        }

        // if (auth()->user()->role_id == 13) {
        //   $assignmentdata = DB::table('assignmentmappings')
        //     ->where('assignmentgenerate_id', $request->assignment_id[$i])
        //     ->first();
        //   $finalresultleadpatner =  $assignmentdata->leadpartnerhour + $request->hour[$i];
        //   $finalresultotherpatner =  $assignmentdata->otherpartnerhour + $request->hour[$i];

        //   if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
        //     $update = DB::table('assignmentmappings')
        //       ->where('assignmentgenerate_id', $request->assignment_id[$i])
        //       ->where('leadpartner', auth()->user()->teammember_id)
        //       ->update(['leadpartnerhour' => $finalresultleadpatner]);
        //   }
        //   if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
        //     $update = DB::table('assignmentmappings')
        //       ->where('assignmentgenerate_id', $request->assignment_id[$i])
        //       ->where('otherpartner', auth()->user()->teammember_id)
        //       ->update(['otherpartnerhour' => $finalresultotherpatner]);
        //   }
        // }
      }
    } else {
      // dd(auth()->user()->teammember_id);
      $output = array('msg' => 'You can not fill timesheet before Rejoining date :' . $joining_date);
      return redirect('timesheet')->with('success', $output);
    }




    $hdatess = Carbon::parse($request->date)->format('Y-m-d');
    // 21-08-2024
    $day = Carbon::parse($hdatess)->format('d');
    // 21
    $month = Carbon::parse($hdatess)->format('F');

    $currentDate = now();
    // 22-08-2024

    $currentMonth = $currentDate->format('F');


    $dates = [
      '26' => 'twentysix',
      '27' => 'twentyseven',
      '28' => 'twentyeight',
      '29' => 'twentynine',
      '30' => 'thirty',
      '31' => 'thirtyone',
      '01' => 'one',
      '02' => 'two',
      '03' => 'three',
      '04' => 'four',
      '05' => 'five',
      '06' => 'six',
      '07' => 'seven',
      '08' => 'eight',
      '09' => 'nine',
      '10' => 'ten',
      '11' => 'eleven',
      '12' => 'twelve',
      '13' => 'thirteen',
      '14' => 'fourteen',
      '15' => 'fifteen',
      '16' => 'sixteen',
      '17' => 'seventeen',
      '18' => 'eighteen',
      '19' => 'ninghteen',
      '20' => 'twenty',
      '21' => 'twentyone',
      '22' => 'twentytwo',
      '23' => 'twentythree',
      '24' => 'twentyfour',
      '25' => 'twentyfive',
    ];



    if ($month != $currentMonth && $day > 25) {
      dd('hi', 1);
      $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
      $month = $dateTime->format('F');
    } elseif ($month != $currentMonth && $day < 25) {
      $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess);
      $month = $dateTime->format('F');
      dd('hi', 2);
    } elseif ($month == $currentMonth && $day > 25) {
      $dateTime = Carbon::createFromFormat('Y-m-d', $hdatess)->addMonth();
      $month = $dateTime->format('F');
      dd('hi', 3);
    }


    $column = $dates[$day];
    // "twentyone"

    // check attendenace record exist or not 
    $attendances = DB::table('attendances')
      ->where('employee_name', auth()->user()->teammember_id)
      ->where('month', $month)
      ->first();



    if ($attendances == null) {
      // $teammember = DB::table('teammembers')->where('id', $request->createdby)->first();
      $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();


      // DB::table('attendances')->insert([
      //   'employee_name' => $teammember->id,
      //   'month' => $month,
      //   'dateofjoining' => $teammember->joining_date,
      //   'created_at' => date('Y-m-d H:i:s'),
      //   'updated_at' => date('Y-m-d H:i:s'),
      // ]);

    }

    if ($attendances != null && property_exists($attendances, $column)) {
      // twentyone in column 
      $updatedtotalhour = $request->totalhour + $attendances->$column;
      // 7  ye seven attendance me jata hai ok 
    } else {
      $updatedtotalhour = $request->totalhour;
    }



    DB::table('attendances')
      ->where('employee_name', auth()->user()->teammember_id)
      ->where('month', $month)
      ->update([$column => $updatedtotalhour]);
    // hare $column is twentyone and $updatedtotalhour is 7


    $output = array('msg' => 'Create Successfully');


    dd($output);

    // //Attendance code
    // $hdatess = date('Y-m-d', strtotime($request->date));
    // $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
    // $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
    // $currentDate = new DateTime();
    // $currentMonth = $currentDate->format('F');
    // //dd($month);
    // //   if ($currentDate->format('j') > 25) {
    // //     $currentDate->modify('-1 month');
    // //     $currentMonth = $currentDate->format('F');
    // // }



    // $dates = [
    //   '26' => 'twentysix',
    //   '27' => 'twentyseven',
    //   '28' => 'twentyeight',
    //   '29' => 'twentynine',
    //   '30' => 'thirty',
    //   '31' => 'thirtyone',
    //   '01' => 'one',
    //   '02' => 'two',
    //   '03' => 'three',
    //   '04' => 'four',
    //   '05' => 'five',
    //   '06' => 'six',
    //   '07' => 'seven',
    //   '08' => 'eight',
    //   '09' => 'nine',
    //   '10' => 'ten',
    //   '11' => 'eleven',
    //   '12' => 'twelve',
    //   '13' => 'thirteen',
    //   '14' => 'fourteen',
    //   '15' => 'fifteen',
    //   '16' => 'sixteen',
    //   '17' => 'seventeen',
    //   '18' => 'eighteen',
    //   '19' => 'ninghteen',
    //   '20' => 'twenty',
    //   '21' => 'twentyone',
    //   '22' => 'twentytwo',
    //   '23' => 'twentythree',
    //   '24' => 'twentyfour',
    //   '25' => 'twentyfive',
    // ];



    // if ($month != $currentMonth && $day > 25) {
    //   $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
    //   $dateTime->modify('+1 month');
    //   $month = $dateTime->format('F');
    // }
    // if ($month != $currentMonth && $day < 25) {
    //   $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
    //   $month = $dateTime->format('F');
    // }
    // if ($month == $currentMonth && $day > 25) {

    //   $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
    //   $dateTime->modify('+1 month');
    //   $month = $dateTime->format('F');
    // }

    // //dd($month);


    // $column = $dates[$day];

    // $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
    //   ->where('month', $month)->first();

    // if ($attendances ==  null) {
    //   $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

    //   $a = DB::table('attendances')->insert([
    //     'employee_name'         =>     auth()->user()->teammember_id,
    //     'month'         =>    $month,
    //     'dateofjoining' =>   $teammember->joining_date,
    //     'created_at'          =>     date('Y-m-d H:i:s'),
    //     //   'exam_leave'      =>$value->date_total,
    //   ]);
    //   //dd($a);
    // }


    // //   dd($noofdaysaspertimesheet);

    // // $updatedtotalhour = $request->totalhour;
    // // if ($attendances != null && property_exists($attendances, $column)) {
    // //   if ($attendances->$column != "LWP") {
    // //     $updatedtotalhour = $request->totalhour + $attendances->$column;
    // //   }
    // // }
    // // DB::table('attendances')
    // //   ->where('employee_name', auth()->user()->teammember_id)
    // //   ->where('month', $month)
    // //   ->update([$column => $updatedtotalhour]);


    // //end attendance


    $output = array('msg' => 'Create Successfully');
    if (auth()->user()->role_id == 14 || auth()->user()->role_id == 13 || auth()->user()->role_id == 15) {
      return redirect('timesheet/mylist')->with('success', $output);
    } else {
      return redirect('timesheet')->with('success', $output);
    }
  } catch (Exception $e) {
    DB::rollBack();
    Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    report($e);
    $output = array('msg' => $e->getMessage());
    return back()->withErrors($output)->withInput();
  }
}
//*
    //! 20-02-2024 understanding
    public function store(Request $request)
    {
      // app\Http\Controllers\AssignmentmappingController.php
        // dd($request);
        $request->validate([
            'client_id' => "required",
            'assignment_id' => "required",
            'teammember_id.*' => "required",
            'type.*' => "required"
        ]);

        try {
            $previouschck = DB::table('assignmentmappings')
                ->where('assignmentgenerate_id', $request->assignment_id)
                ->first();
            // "NEW100467"


            // dd($previouschck);
            // if ($previouschck != null) {
            //     //dd('hi');
            //     $output = array('msg' => 'You already created assignment for this.');
            //     return back()->with('success', $output);
            // }

            $assignment_id = Assignmentbudgeting::where('assignmentgenerate_id', $request->assignment_id)->select('assignment_id')->pluck('assignment_id')->first();
            // $request->assignment_id
            // "NEW100467"
            // dd($assignment_id);

            // Storage::disk('s3')->makeDirectory($request->assignment_id);
            $request->except(['_token']);
            //  dd($data); die();
            //insert data 
            $id = DB::table('assignmentmappings')->insertGetId([

                'assignmentgenerate_id'         =>     $request->assignment_id,
                'periodstart'         =>     $request->periodstart,
                'periodend'         =>     $request->periodend,
                'year'         =>     Carbon::parse($request->periodend)->year,
                'roleassignment'                =>      $request->roleassignment,
                'assignment_id'         =>     $assignment_id,
                'esthours'            =>       $request->esthours,
                'leadpartner'            =>       $request->leadpartner,
                'otherpartner'            =>       $request->otherpartner,
                'stdcost'            =>       $request->stdcost,
                'estcost'            =>       $request->estcost,
                'filecreationdate'                =>       date('y-m-d'),
                'modifieddate'              =>    date('y-m-d'),
                'auditcompletiondate'                =>       date('y-m-d'),
                'documentationdate'              =>    date('y-m-d'),
                'created_at'                =>       date('y-m-d'),
                'updated_at'              =>    date('y-m-d'),
            ]);
            // 477
            // dd($request->teammember_id);

            if ($request->teammember_id != '0') {
                $count = count($request->teammember_id);
                // 1

                // dd($count); die;
                for ($i = 0; $i < $count; $i++) {
                    DB::table('assignmentteammappings')->insert([
                        'assignmentmapping_id'       =>     $id,
                        'type'       =>     $request->type[$i],
                        'teammember_id'       =>     $request->teammember_id[$i],
                        // default status 0 so that i can active or inactive assignment assrejected
                        'status'       =>  0,
                        'created_at'                =>       date('y-m-d'),
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }

                // dd($request->assignment_id);
                $clientname = DB::table('clients')->where('id', $request->client_id)->select('client_name')->first();
                $assignmentnames = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id)->select('assignmentname')->first();

                $teamemail = DB::table('teammembers')->wherein('id', $request->teammember_id)->select('emailid')->get();
                foreach ($teamemail as $teammember) {
                    $data = array(
                        'assignmentid' =>  $request->assignment_id,
                        'clientname' =>  $clientname->client_name,
                        'assignmentname' =>  $assignmentnames->assignmentname,
                        'emailid' =>  $teammember->emailid,


                    );

                    Mail::send('emails.assignmentassign', $data, function ($msg) use ($data) {
                        $msg->to($data['emailid']);
                        $msg->subject('VSA New Assignment Assigned || ' . $data['assignmentname'] . ' / ' . $data['assignmentid']);
                    });
                }
            }
            $assignmentname = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();
            // dd($assignmentname);
            $actionName = class_basename($request->route()->getActionname());
            dd($actionName);
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            $id = auth()->user()->teammember_id;
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => 'New Assignment Mapping Added' . ' ' . '( ' . $assignmentname . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);
            $output = array('msg' => 'Create Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }
//*
//! 20-02-2024 before implementation assignment mapping and budegeting one place 
    public function store(Request $request)
    {
      // app\Http\Controllers\AssignmentbudgetingController.php
        $request->validate([
            'client_id' => "required",
            'assignment_id' => "required",

        ]);

        try {
            $data = $request->except(['_token']);
            //             array:4 [▼
            //   "client_id" => "199"
            //   "assignment_id" => "198"
            //   "assignmentname" => "asdf"
            //   "duedate" => "2024-02-14"
            // ]


            $data['created_by'] = auth()->user()->id;

            //             array:5 [▼
            //   "client_id" => "199"
            //   "assignment_id" => "198"
            //   "assignmentname" => "asdf"
            //   "duedate" => "2024-02-14"
            //   "created_by" => 634
            // ]

            $clientcode = DB::table('clients')->where('id', $request->client_id)->first();
            $assignmentgenerateid = strtoupper(substr($clientcode->client_name, 0, 3));
            // "ANI"

            $assign = Assignmentbudgeting::latest()->get();

            // dd($assign); die;
            if ($assign->isEmpty()) {
                // false
                // dd('hia1');
                $assignmentnumbers = '100001';
            } else {
                $assignmentnumb = Assignmentbudgeting::latest()->first()->assignmentnumber;
                // 100467
                if ($assignmentnumb ==  null) {
                    $assignmentnumbers = '100001';
                } else {
                    $assignmentnumbers = $assignmentnumb + 1;
                    // 100468

                }
            }


            $assignmentgenerate = $assignmentgenerateid . $assignmentnumbers;
            // "ANI100468"
            $data['assignmentgenerate_id'] = $assignmentgenerate;
            $data['assignmentnumber'] = $assignmentnumbers;
            //     array:7 [▼
            //     "client_id" => "199"
            //     "assignment_id" => "198"
            //     "assignmentname" => "asdf"
            //     "duedate" => "2024-02-14"
            //     "created_by" => 634
            //     "assignmentgenerate_id" => "ANI100468"
            //     "assignmentnumber" => 100468
            //   ]

            // insert data
            // Assignmentbudgeting::Create($data);
            $assignmentname = Assignment::where('id', $request->assignment_id)->select('assignment_name')->pluck('assignment_name')->first();
            // "Special Purpose Audit"
            $actionName = class_basename($request->route()->getActionname());
            // "AssignmentbudgetingController@store"
            $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
            // "Assignmentbudgeting"

            $id = auth()->user()->teammember_id;
            // insert data
            DB::table('activitylogs')->insert([
                'user_id' => $id,
                'ip_address' => $request->ip(),
                'activitytitle' => $pagename,
                'description' => 'New Assignment Budgeting Added' . ' ' . '( ' . $assignmentname . ' )',
                'created_at' => date('y-m-d'),
                'updated_at' => date('y-m-d')
            ]);
            $output = array('msg' => 'Create Successfully');
            dd($output);
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

// 22222222222222222222222222222222222222222222222222222222222222222222222222
// app\Http\Controllers\TimesheetController.php
// } else {  only understand else part in this 
  // !old code 20-12-23
  public function timesheet_mylist()
  {
    if (auth()->user()->role_id == 13) {
      // die;
      $client = Client::select('id', 'client_name')->get();
      $getauth =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '0')
        ->orderby('id', 'desc')->first();

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');
      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');


      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();

      $currentDate = now();


      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      $time =  DB::table('timesheets')->get();
      foreach ($time as $value) {
        //dd(date('F', strtotime($value->date)));
        DB::table('timesheets')->where('id', $value->id)->update([
          'month'         =>     date('F', strtotime($value->date)),
        ]);
      }
      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // dd($timesheetData);

      // $timesheetData = DB::table('timesheetusers')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      //   ->where('timesheetusers.createdby', auth()->user()->teammember_id)
      //   ->where('timesheetusers.status', 1)
      //   ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // // dd($timesheetData);
      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        // shahid
        return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
      }
    } else {

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      // dd($dropdownYears);
      // 0 => 2024
      // 1 => 2023

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      // dd($dropdownMonths);
      // 0 => "October"
      // 1 => "December"
      // 2 => "November"
      // 3 => "January"
      // 4 => "February"

      $currentDate = now();
      // 2024-01-16 00:46:21.610590

      $month = $currentDate->format('F');
      // "January"
      $year = $currentDate->format('Y');
      // "2024"



      $getauths =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '1')
        ->orderby('id', 'desc')->first();
      if ($getauths != null) {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '1')
          ->orderby('id', 'desc')->first();
        //dd($getauth);
      } else {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        // dd($getauth);
      }

      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();

      $client = Client::select('id', 'client_name')->get();

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        //   ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'DESC')->get();

      $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->with('title')->get();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
      // dd($timesheetrequest);
      // +"validate": "2024-01-09"
      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact(
          'timesheetData',
          'getauth',
          'client',
          'partner',
          'timesheetrequest',
          'dropdownYears',
          'dropdownMonths',
          'month',
          'year',
        ));
      }
    }
  }
// 22222222222222222222222222222222222222222222222222222222222222222222222222
// app\Http\Controllers\TimesheetrequestController.php

// first 1
public function timesheetsubmission(Request $request)
    {


        try {
            $usertimesheetfirstdate =  DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
            $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

            if ($usertimesheetfirstdate) {
                // Convert the retrieved date to a DateTime object
                $firstDate = new DateTime($usertimesheetfirstdate->date);
                // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)

                // Find the day of the week for the first date (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
                $dayOfWeek = $firstDate->format('w');
                // 6
                $daysToAdd = 0;
                if ($dayOfWeek !== '0') {
                    $daysToAdd = 7 - $dayOfWeek;
                    // 1
                } else {
                    $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                    return back()->with('success', $output);
                }

                if ($dayOfWeek > 0) {
                    $daysToSubtract = $dayOfWeek - 1;
                    //5

                } else {
                    $daysToSubtract = $dayOfWeek;
                }

                $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');
                // "2023-11-19"
                $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                // "2023-11-13"

            }



            $get_six_Data = DB::table('timesheets')
                ->where('status', '0')
                ->where('created_by', auth()->user()->teammember_id)
                ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                ->orderBy('date', 'ASC')
                ->get();

            $lastdate = $get_six_Data->max('date');


            $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

            foreach ($get_six_Data as $entry) {
                $date = new DateTime($entry->date);
                $retrievedDates[] = $date->format('Y-m-d');
            }
            //   0 => "2023-11-15"
            //   1 => "2023-11-16"
            //   2 => "2023-11-17"




            $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

            $firstDate = new DateTime($presentWeekMonday);
            // date: 2023-11-13 00:00:00.0 Asia/Kolkata (+05:30)
            $upcomingSundayDate = new DateTime($upcomingSunday);


            // Clone $firstDate so that it is not modified
            $currentDate = clone $firstDate;
            // date: 2023-11-13 00:00:00.0 Asia/Kolkata (+05:30)

            while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                $expectedDates[] = $currentDate->format('Y-m-d');

                // 0 => "2023-11-13"
                $currentDate->modify("+1 day");
                // date: 2023-11-14 00:00:00.0 Asia/Kolkata (+05:30)

            }
            // Check for missing dates
            $missingDates = array_diff($expectedDates, $retrievedDates);
            // 0 => "2023-11-13"
            // 1 => "2023-11-14"
            //  otherwise []


            if (!empty($missingDates)) {
                $missingDatesString = implode(', ', $missingDates);
                // "2023-11-13, 2023-11-14"


                $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                // "msg" => "Timesheet Submit Failed Missing dates: 2023-11-13, 2023-11-14"
                return back()->with('success', $output);
            } else {   //"All dates present"    //------------------- Suhail's code end---------------------

                foreach ($get_six_Data as $getsixdata) {
                    // dd('hi', $getsixdata);

                    // Convert the requested date to a Carbon instance
                    $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);
                    // date: 2023-11-13 12:47:54.0 Asia/Kolkata (+05:30)

                    if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

                        $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);
                        // date: 2023-11-06 00:00:00.0 Asia/Kolkata (+05:30)
                        // dd($previousMonday);
                        // Find the nearest next Saturday to the requested date
                        $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);
                        // date: 2023-11-18 00:00:00.0 Asia/Kolkata (+05:30)

                        // Format the dates in 'Y-m-d' format
                        $previousMondayFormatted = $getsixdata->date;
                        // "2023-11-13"
                        $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                        // "2023-11-18"
                        $nextSaturdayFormatted = $lastdate;
                        // "2023-11-18"


                        $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));
                        // "13-11-2023 to 18-11-2023"

                        // $co = DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)
                        //     ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                        //     ->select('partner', DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                        //     ->groupBy('partner')
                        //     ->get();
                        //! good
                        $co = DB::table('timesheetusers')
                            ->where('createdby', auth()->user()->teammember_id)
                            ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                            ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                            ->get();


                        // when one patner then 
                        //   +"partner": 887
                        //   +"total_hours": 48.0
                        //   +"row_count": 6

                        // when two patner then 
                        // 0 => {#3490 ▼
                        //     +"partner": 844
                        //     +"total_hours": 8.0
                        //     +"row_count": 1
                        //   }
                        //   1 => {#3487 ▼
                        //     +"partner": 887
                        //     +"total_hours": 40.0
                        //     +"row_count": 5
                        //   }

                        dd($co);
                        foreach ($co as $codata) {
                            DB::table('timesheetreport')->insert([
                                'teamid'       =>     auth()->user()->teammember_id,
                                'week'       =>     $week,
                                'totaldays'       =>     $codata->row_count,
                                'totaltime' =>  $codata->total_hours,
                                // 'partnerid'  => $codata->partner,
                                'startdate'  => $previousMondayFormatted,
                                'enddate'  => $nextSaturdayFormatted,
                                // 'created_at'                =>       date('y-m-d'),
                                'created_at'                =>      date('y-m-d H:i:s'),
                            ]);
                        }

                        // dd($co);
                    }
                    dd('ho', $getsixdata->id);


                    DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                    DB::table('timesheets')->where('id', $getsixdata->id)->update([
                        'status'         =>     1,
                        'updated_at'              =>    date('y-m-d'),
                    ]);
                }
            }


            $output = array('msg' => 'Timesheet Submit Successfully');
            return back()->with('success', $output);
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

    // first 2
    public function timesheetsubmission(Request $request)
    {
        try {
            // -----------------------------Shahid coding start------------------------------------------
            // Get latest submited timesheet end date from timesheetreport table
            $latesttimesheetreport =  DB::table('timesheetreport')
                ->where('teamid', auth()->user()->teammember_id)
                ->orderBy('id', 'desc')
                ->first();

            // 2024-01-22

            // $latesttimesheetreport is not null 
            if ($latesttimesheetreport !== null) {
                $timesheetreportenddate = Carbon::parse($latesttimesheetreport->enddate);
                // find next sturday 
                // 2024-01-27
                $nextSaturday = $timesheetreportenddate->copy()->next(Carbon::SATURDAY);
                // 2024-02-03
                $formattedNextSaturday = $nextSaturday->format('Y-m-d');
                // "2024-02-03"
                $formattedNextSaturday1 = $timesheetreportenddate->format('d-m-Y');
                // dd($formattedNextSaturday1);
                // "27-01-2024"

                // find next week timesheet filled or not 
                $nextweektimesheet = DB::table('timesheetusers')
                    ->where('createdby', auth()->user()->teammember_id)
                    // ->where('status', '0')
                    // dev khurana problem fixed if any problem came then  ->where('status', '0') wla uncomment kare aur ise ->whereIn('status', [0, 1]) comment kar de
                    ->whereIn('status', [0, 1])
                    ->where('date', $formattedNextSaturday)
                    ->first();
                // dd($nextweektimesheet);
                // if not filled next week timesheet then 
                if ($nextweektimesheet == null) {
                    $output = array('msg' => "Fill the Week timesheet After this week : $formattedNextSaturday1");
                    return back()->with('statuss', $output);
                }
                // -----------------------------Shahid coding end------------------------------------------
                else {



                    $usertimesheetfirstdate =  DB::table('timesheets')
                        ->where('status', '0')
                        ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                    // 2024-02-26

                    $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);
                    // 2024-02-03

                    if ($usertimesheetfirstdate) {
                        $firstDate = new DateTime($usertimesheetfirstdate->date);
                        // 2024-02-26
                        $dayOfWeek = $firstDate->format('w');
                        // "1"
                        $daysToAdd = 0;


                        if ($dayOfWeek !== '0') {
                            $daysToAdd = 7 - $dayOfWeek;
                            // 6
                        } else {
                            $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                            return back()->with('success', $output);
                        }

                        if ($dayOfWeek > 0) {
                            // "1"
                            $daysToSubtract = $dayOfWeek - 1;
                            // 0

                        } else {
                            $daysToSubtract = $dayOfWeek;
                        }
                        $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                        $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                        // "2024-02-26"
                    }




                    $get_six_Data = DB::table('timesheets')
                        ->where('status', '0')
                        ->where('created_by', auth()->user()->teammember_id)
                        ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                        ->orderBy('date', 'ASC')
                        ->get();


                    $lastdate = $get_six_Data->max('date');
                    // "2024-03-03"



                    $retrievedDates = [];   //copy dates in retrievedDates array in datetime format
                    foreach ($get_six_Data as $entry) {
                        $date = new DateTime($entry->date);
                        // date: 2024-02-26
                        $retrievedDates[] = $date->format('Y-m-d');
                        // 0 => "2024-02-26"

                    }

                    // 0 => "2024-02-26"
                    // 1 => "2024-02-27"
                    // 2 => "2024-02-28"
                    // 3 => "2024-02-29"
                    // 4 => "2024-03-01"
                    // 5 => "2024-03-02"
                    // 6 => "2024-03-03"




                    $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

                    // 0 => "2024-02-26"
                    // 1 => "2024-02-27"
                    // 2 => "2024-02-28"
                    // 3 => "2024-02-29"
                    // 4 => "2024-03-01"
                    // 5 => "2024-03-02"


                    $firstDate = new DateTime($presentWeekMonday);
                    $upcomingSundayDate = new DateTime($upcomingSunday);


                    // Clone $firstDate so that it is not modified
                    $currentDate = clone $firstDate;


                    while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                        $expectedDates[] = $currentDate->format('Y-m-d');
                        // 2024-02-26
                        $currentDate->modify("+1 day");
                        // 2024-02-27
                    }
                    // 0 => "2024-02-26"
                    // 1 => "2024-02-27"
                    // 2 => "2024-02-28"
                    // 3 => "2024-02-29"
                    // 4 => "2024-03-01"
                    // 5 => "2024-03-02"




                    $missingDates = array_diff($expectedDates, $retrievedDates);


                    if (!empty($missingDates)) {
                        $missingDatesString = implode(', ', $missingDates);
                        // "2023-11-13, 2023-11-14"

                        $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                        return back()->with('success', $output);
                    } else {
                        foreach ($get_six_Data as $getsixdata) {
                            // dd('hi', $getsixdata);
                            // Convert the requested date to a Carbon instance
                            $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);


                            // "Monday" 
                            if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {


                                $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

                                // Find the nearest next Saturday to the requested date
                                $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

                                // Format the dates in 'Y-m-d' format
                                $previousMondayFormatted = $getsixdata->date;
                                $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                                $nextSaturdayFormatted = $lastdate;


                                $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));


                                //------------------- Shahid's code start---------------------
                                $co = DB::table('timesheetusers')
                                    ->where('createdby', auth()->user()->teammember_id)
                                    ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                    ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                    ->get();

                                // 0 => {#3503 ▼
                                //     +"total_hours": 13.0
                                //     +"row_count": 7
                                //   }




                                // dd($co);
                                foreach ($co as $codata) {
                                    DB::table('timesheetreport')->insert([
                                        'teamid'       =>     auth()->user()->teammember_id,
                                        'week'       =>     $week,
                                        'totaldays'       =>     $codata->row_count,
                                        'totaltime' =>  $codata->total_hours,
                                        // 'partnerid'  => $codata->partner,
                                        'startdate'  => $previousMondayFormatted,
                                        'enddate'  => $nextSaturdayFormatted,
                                        // 'created_at'                =>       date('y-m-d'),
                                        'created_at'                =>      date('y-m-d H:i:s'),
                                    ]);
                                }

                                // dd($co);
                            }

                            dd($getsixdata->id, 'hi88');

                            DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                                'status'         =>     1,
                                'updated_at'              =>    date('y-m-d'),
                            ]);
                            DB::table('timesheets')->where('id', $getsixdata->id)->update([
                                'status'         =>     1,
                                'updated_at'              =>    date('y-m-d'),
                            ]);
                        }
                    }


                    // $output = array('msg' => 'Timesheet Submit Successfully');
                    $output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));

                    // $output = array('msg' => "Timesheet Submit Successfully till $previousMondayFormatted to $nextSaturdayFormatted ");
                    return back()->with('success', $output);
                }
            }

            // $latesttimesheetreport is null then 
            // else {
            //     $output = array('msg' => 'No timesheet report found.');
            //     return back()->with('statuss', $output);
            // }

            // $latesttimesheetreport is null then 
            else {
                dd('hi');

                $usertimesheetfirstdate =  DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)->orderBy('date', 'ASC')->first();
                $lastdate = Carbon::createFromFormat('Y-m-d', $usertimesheetfirstdate->date ?? '')->addDays(6);

                if ($usertimesheetfirstdate) {
                    $firstDate = new DateTime($usertimesheetfirstdate->date);
                    $dayOfWeek = $firstDate->format('w');
                    $daysToAdd = 0;

                    if ($dayOfWeek !== '0') {
                        $daysToAdd = 7 - $dayOfWeek;
                    } else {
                        $output = array('msg' => 'Submit the timesheet from Monday to Sunday.');
                        return back()->with('success', $output);
                    }

                    if ($dayOfWeek > 0) {
                        $daysToSubtract = $dayOfWeek - 1;
                    } else {
                        $daysToSubtract = $dayOfWeek;
                    }

                    $upcomingSunday = (new DateTime($firstDate->format('Y-m-d')))->modify("+$daysToAdd days")->format('Y-m-d');

                    $presentWeekMonday = (new DateTime($firstDate->format('Y-m-d')))->modify("-$daysToSubtract days")->format('Y-m-d');
                }



                $get_six_Data = DB::table('timesheets')
                    ->where('status', '0')
                    ->where('created_by', auth()->user()->teammember_id)
                    ->whereBetween('date', [$firstDate->format('Y-m-d'), $upcomingSunday])
                    ->orderBy('date', 'ASC')
                    ->get();

                $lastdate = $get_six_Data->max('date');


                $retrievedDates = [];   //copy dates in retrievedDates array in datetime format

                foreach ($get_six_Data as $entry) {
                    $date = new DateTime($entry->date);
                    $retrievedDates[] = $date->format('Y-m-d');
                }

                $expectedDates = [];   // will contain ALL the dates occurs b/w first day to upcoming sunday

                $firstDate = new DateTime($presentWeekMonday);

                $upcomingSundayDate = new DateTime($upcomingSunday);


                // Clone $firstDate so that it is not modified
                $currentDate = clone $firstDate;

                while ($currentDate->format('Y-m-d') < $upcomingSundayDate->format('Y-m-d')) {  //excluding sunday
                    $expectedDates[] = $currentDate->format('Y-m-d');


                    $currentDate->modify("+1 day");
                }

                $missingDates = array_diff($expectedDates, $retrievedDates);

                if (!empty($missingDates)) {
                    $missingDatesString = implode(', ', $missingDates);
                    // "2023-11-13, 2023-11-14"

                    $output = array('msg' => "Timesheet Submit Failed Missing dates: $missingDatesString");
                    return back()->with('success', $output);
                } else {

                    foreach ($get_six_Data as $getsixdata) {
                        // dd('hi', $getsixdata);

                        // Convert the requested date to a Carbon instance
                        $requestedDate = Carbon::createFromFormat('Y-m-d', $getsixdata->date);


                        if (date('l', strtotime(date('d-m-Y', strtotime($getsixdata->date)))) == 'Monday') {

                            $previousMonday = $requestedDate->copy()->previous(Carbon::MONDAY);

                            // Find the nearest next Saturday to the requested date
                            $nextSaturday = $requestedDate->copy()->next(Carbon::SATURDAY);

                            // Format the dates in 'Y-m-d' format
                            $previousMondayFormatted = $getsixdata->date;
                            $nextSaturdayFormatted = $nextSaturday->format('Y-m-d');
                            $nextSaturdayFormatted = $lastdate;


                            $week =  date('d-m-Y', strtotime($previousMondayFormatted))  . ' to ' . date('d-m-Y', strtotime($nextSaturdayFormatted));

                            //------------------- Shahid's code start---------------------
                            $co = DB::table('timesheetusers')
                                ->where('createdby', auth()->user()->teammember_id)
                                ->whereBetween('date', [$previousMondayFormatted, $nextSaturdayFormatted])
                                ->select(DB::raw('SUM(hour) as total_hours'), DB::raw('COUNT(DISTINCT timesheetid) as row_count'))
                                ->get();


                            // dd($co);
                            foreach ($co as $codata) {
                                DB::table('timesheetreport')->insert([
                                    'teamid'       =>     auth()->user()->teammember_id,
                                    'week'       =>     $week,
                                    'totaldays'       =>     $codata->row_count,
                                    'totaltime' =>  $codata->total_hours,
                                    // 'partnerid'  => $codata->partner,
                                    'startdate'  => $previousMondayFormatted,
                                    'enddate'  => $nextSaturdayFormatted,
                                    // 'created_at'                =>       date('y-m-d'),
                                    'created_at'                =>      date('y-m-d H:i:s'),
                                ]);
                            }

                            // dd($co);
                        }



                        DB::table('timesheetusers')->where('timesheetid', $getsixdata->id)->update([
                            'status'         =>     1,
                            'updated_at'              =>    date('y-m-d'),
                        ]);
                        DB::table('timesheets')->where('id', $getsixdata->id)->update([
                            'status'         =>     1,
                            'updated_at'              =>    date('y-m-d'),
                        ]);
                    }
                }


                // $output = array('msg' => 'Timesheet Submit Successfully');
                $output = array('msg' => "Timesheet Submit Successfully till " . Carbon::createFromFormat('Y-m-d', $previousMondayFormatted)->format('d-m-Y') . " to " . Carbon::createFromFormat('Y-m-d', $nextSaturdayFormatted)->format('d-m-Y'));

                // $output = array('msg' => "Timesheet Submit Successfully till $previousMondayFormatted to $nextSaturdayFormatted ");
                return back()->with('success', $output);
            }
        } catch (Exception $e) {
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }

// 2222222222222222222222222222222222222222222222222222222222222222
// applyleave controller update function 

public function update(Request $request, $id)
{

  // dd($request);
  try {

    if ($request->status == 1) {
      $team = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.id', $id)
        ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday')->first();

      if ($team->leavetype == '8' && $team->type == '1') {
        $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $team->from);

        $period = date('Y-m-d', strtotime($team->to));
        $bl_leave_day = date('d', strtotime($period));
        $bl_leave_month = date('F', strtotime($period));

        if ($bl_leave_day >= 26 && $bl_leave_day <= 31) {
          $bl_leave_month = date('F', strtotime($period . ' +1 month'));
        }

        $requestdays = $to->diffInDays($from) + 1;

        $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)
          ->count();

        $totalrqstday = $requestdays - $holidaycount;

        DB::table('leaveapprove')->insert([
          'teammemberid'     =>     $team->createdby,
          'leavetype'     =>     $team->leavetype,
          'totaldays'     =>     $totalrqstday,
          'year'     =>     '2023',
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);


        $lstatus = "BL/A";

        $attendances = DB::table('attendances')
          ->where('employee_name', $team->createdby)
          ->where('month', $bl_leave_month)->first();


        if ($attendances->birthday_religious == null) {
          $birthday = 0;
        } else {
          $birthday = $attendances->birthday_religious;
        }

        $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
          ->where('month', $bl_leave_month)->first();

        $column = '';
        switch ($bl_leave_day) {
          case '26':
            $column = 'twentysix';
            break;
          case '27':
            $column = 'twentyseven';
            break;
          case '28':
            $column = 'twentyeight';
            break;
          case '29':
            $column = 'twentynine';
            break;
          case '30':
            $column = 'thirty';
            break;
          case '31':
            $column = 'thirtyone';
            break;
          case '01':
            $column = 'one';
            break;
          case '02':
            $column = 'two';
            break;
          case '03':
            $column = 'three';
            break;
          case '04':
            $column = 'four';
            break;
          case '05':
            $column = 'five';
            break;
          case '06':
            $column = 'six';
            break;
          case '07':
            $column = 'seven';
            break;
          case '08':
            $column = 'eight';
            break;
          case '09':
            $column = 'nine';
            break;
          case '10':
            $column = 'ten';
            break;
          case '11':
            $column = 'eleven';
            break;
          case '12':
            $column = 'twelve';
            break;
          case '13':
            $column = 'thirteen';
            break;
          case '14':
            $column = 'fourteen';
            break;
          case '15':
            $column = 'fifteen';
            break;
          case '16':
            $column = 'sixteen';
            break;
          case '17':
            $column = 'seventeen';
            break;
          case '18':
            $column = 'eighteen';
            break;
          case '19':
            $column = 'ninghteen';
            break;
          case '20':
            $column = 'twenty';
            break;
          case '21':
            $column = 'twentyone';
            break;
          case '22':
            $column = 'twentytwo';
            break;
          case '23':
            $column = 'twentythree';
            break;
          case '24':
            $column = 'twentyfour';
            break;
          case '25':
            $column = 'twentyfive';
            break;
        }

        if (!empty($column)) {

          DB::table('attendances')
            ->where('employee_name', $team->createdby)
            ->where('month', $bl_leave_month)
            ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
            ->update([
              $column => $lstatus,
            ]);
        }
      } elseif ($team->leavetype == '8' && $team->type == '0') {
        $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $team->from);

        $period = date('Y-m-d', strtotime($team->to));
        $bl_leave_day = date('d', strtotime($period));
        $bl_leave_month = date('F', strtotime($period));

        $requestdays = $to->diffInDays($from) + 1;

        $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)
          ->count();

        $totalrqstday = $requestdays - $holidaycount;

        DB::table('leaveapprove')->insert([
          'teammemberid'     =>     $team->createdby,
          'leavetype'     =>     $team->leavetype,
          'type'     =>     $team->type,
          'totaldays'     =>     $totalrqstday,
          'year'     =>     '2023',
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);



        // dd($period);
        $lstatus = "BL/A";




        $attendances = DB::table('attendances')
          ->where('employee_name', $team->createdby)
          ->where('month', $bl_leave_month)->first();

        // dd($attendances);
        if ($attendances->birthday_religious == null) {
          $birthday = 0;
        } else {
          $birthday = $attendances->birthday_religious;
        }




        $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
          ->where('month', $bl_leave_month)->first();

        $column = '';
        switch ($bl_leave_day) {
          case '26':
            $column = 'twentysix';
            break;
          case '27':
            $column = 'twentyseven';
            break;
          case '28':
            $column = 'twentyeight';
            break;
          case '29':
            $column = 'twentynine';
            break;
          case '30':
            $column = 'thirty';
            break;
          case '31':
            $column = 'thirtyone';
            break;
          case '01':
            $column = 'one';
            break;
          case '02':
            $column = 'two';
            break;
          case '03':
            $column = 'three';
            break;
          case '04':
            $column = 'four';
            break;
          case '05':
            $column = 'five';
            break;
          case '06':
            $column = 'six';
            break;
          case '07':
            $column = 'seven';
            break;
          case '08':
            $column = 'eight';
            break;
          case '09':
            $column = 'nine';
            break;
          case '10':
            $column = 'ten';
            break;
          case '11':
            $column = 'eleven';
            break;
          case '12':
            $column = 'twelve';
            break;
          case '13':
            $column = 'thirteen';
            break;
          case '14':
            $column = 'fourteen';
            break;
          case '15':
            $column = 'fifteen';
            break;
          case '16':
            $column = 'sixteen';
            break;
          case '17':
            $column = 'seventeen';
            break;
          case '18':
            $column = 'eighteen';
            break;
          case '19':
            $column = 'ninghteen';
            break;
          case '20':
            $column = 'twenty';
            break;
          case '21':
            $column = 'twentyone';
            break;
          case '22':
            $column = 'twentytwo';
            break;
          case '23':
            $column = 'twentythree';
            break;
          case '24':
            $column = 'twentyfour';
            break;
          case '25':
            $column = 'twentyfive';
            break;
        }

        if (!empty($column)) {

          DB::table('attendances')
            ->where('employee_name', $team->createdby)
            ->where('month', $bl_leave_month)
            ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
            ->update([
              $column => $lstatus,
            ]);
        }
      }
      if ($team->name == 'Casual Leave') {
        $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $team->from);
      
        $requestdays = $to->diffInDays($from) + 1;
      
        $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)
          ->count();
      
        $totalrqstday = $requestdays - $holidaycount;
      
        DB::table('leaveapprove')->insert([
          'teammemberid'     =>     $team->createdby,
          'leavetype'     =>     $team->leavetype,
          'totaldays'     =>     $totalrqstday,
          'year'     =>     '2023',
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);
      
      
        $period = CarbonPeriod::create($team->from, $team->to);
        // dd($period);
      
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }
      
      
      
      
        $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)->select('startdate')->get();
      
        if (count($getholidays) != 0) {
          foreach ($getholidays as $date) {
            $hdatess[] = date('Y-m-d', strtotime($date->startdate));
          }
        } else {
          $hdatess[] = 0;
        }
        $cl_leave = array_diff($datess, $hdatess);
      
      
      
        $lstatus = "CL/A";
      
      
      
      
        foreach ($cl_leave as $cl_leave) {
      
      
          $cl_leave_day = date('d', strtotime($cl_leave));
          $cl_leave_month = date('F', strtotime($cl_leave));
      
          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
          }
      
      
          $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
            ->where('month', $cl_leave_month)->first();
      
          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }
      
          if (!empty($column)) {
      
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->whereRaw("{$column} != 'LWP'")
              ->update([
                $column => $lstatus,
              ]);
          }
        }
      }

      if ($team->name == 'Exam Leave') {

        $from = Carbon::createFromFormat('Y-m-d', $team->from);
        //2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
        $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
        // 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
        $camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
        // dd($camefromexam);
        // $nowrequestdays = $to->diffInDays($camefromexam) + 1;
        // remove days from database 
        $removedays = $to->diffInDays($camefromexam) + 1;
        // dd($removedays);
        // my total leave now after coming
        $nowtotalleave = $from->diffInDays($camefromexam);
        // 5 days
        // dd($nowtotalleave);
        // for serching from data base 
        $finddatafromleaverequest = $to->diffInDays($from) + 1;
        // dd($finddatafromleaverequest);
        // 9
        // dd($finddatafromleaverequest);
      
        // dd($requestdays);
        // $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
        //   ->where('enddate', '<=', $team->to)
        //   ->count();
        // //0
        // $totalrqstday = $nowrequestdays - $holidaycount;
        // 9
        // dd($holidaycount);
        // dd($totalrqstday);
      
        DB::table('leaveapprove')
          ->where('teammemberid', $team->createdby)
          ->where('totaldays', $finddatafromleaverequest)
          ->latest()
          ->update([
            'totaldays' => $nowtotalleave,
            'updated_at' => now(),
          ]);
        // dd($finddatafromleaverequest);
      
        // dd($team->from);
        // "2023-12-16"
        // dd($team->date);
        // "2023-12-20"
        // dd($team->to);
        // "2023-12-24"
        //! working one delete ek baar me
        // // $period = CarbonPeriod::create($team->date, $team->to);
        // $period = CarbonPeriod::create('2023-12-21', $team->to);
        // // dd($period);
        // $datess = [];
        // foreach ($period as $date) {
        //   $datess[] = $date->format('Y-m-d');
        //   // dd($datess);
        //   $deletedIds = DB::table('timesheets')
        //     ->where('created_by', $team->createdby)
        //     ->where('date', $datess)
        //     ->pluck('id');
        //   // dd($deletedIds);
      
        //   DB::table('timesheets')
        //     ->where('created_by', $team->createdby)
        //     ->where('date', $datess)
        //     ->delete();
      
        //   $a = DB::table('timesheetusers')
        //     ->whereIn('timesheetid', $deletedIds)
        //     ->delete();
        // }
        // dd($datess);
        // dd($deletedIds);
      
        $period = CarbonPeriod::create($team->date, $team->to);
      
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
      
          $deletedIds = DB::table('timesheets')
            ->where('created_by', $team->createdby)
            ->whereIn('date', $datess)
            ->pluck('id');
      
          DB::table('timesheets')
            ->where('created_by', $team->createdby)
            ->whereIn('date', $datess)
            ->delete();
      
          $a = DB::table('timesheetusers')
            ->whereIn('timesheetid', $deletedIds)
            ->delete();
        }
      
        // dd($datess);
      
      
        // $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
        //   ->where('enddate', '<=', $team->to)->select('startdate')->get();
      
        // if (count($getholidays) != 0) {
        //   foreach ($getholidays as $date) {
        //     $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        //   }
        // } else {
        //   $hdatess[] = 0;
        // }
      
        // dd($hdatess);
        $el_leave = $datess;
        // 0 => "2023-09-16"
        // 1 => "2023-09-17"
        // 2 => "2023-09-18"
        // $exam_leave_total = count(array_diff($datess, $hdatess));
        // 62
      
      
        // $lstatus = "EL/A";
        // $lstatus = "Null";
        // $lstatus = "";
        $lstatus = null;
      
        foreach ($el_leave as $cl_leave) {
          // date get one by one 
      
          $cl_leave_day = date('d', strtotime($cl_leave));
          // "16"
      
      
      
          $cl_leave_month = date('F', strtotime($cl_leave));
      
          // September
          // dd($cl_leave_month);
          // dd($cl_leave_day);
          // 16
          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
          }
          // dd('hi1', $team->createdby);
          // 802
          $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
            ->where('month', $cl_leave_month)->first();
          // September
          // dd($attendances);
          //  dd($value->created_by);
      
          // dd('hi2', $attendances);
          // dd($cl_leave_day);
          // 16
          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }
          // dd('pa', $column);
          // sixteen
          // dd('pa', $lstatus);
          // EL/A
          if (!empty($column)) {
            // store EL/A sexteen to 25 tak 
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->whereRaw("{$column} != 'LWP'")
              ->update([
                $column => $lstatus,
              ]);
          }
          // if (!empty($column)) {
          //   // store EL/A sexteen to 25 tak 
          //   DB::table('attendances')
          //     ->where('employee_name', $team->createdby)
          //     ->where('month', $cl_leave_month)
          //     ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
          //     ->whereRaw("{$column} != 'LWP'")
          //     ->delete();
          // }
        }
        // dd('hq');
      }
      if ($team->name == 'Sick Leave') {
        $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
        $from = Carbon::createFromFormat('Y-m-d', $team->from);

        $requestdays = $to->diffInDays($from) + 1;
        // dd($requestdays);
        $holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)
          ->count();
        // dd($holidaycount);
        $totalrqstday = $requestdays - $holidaycount;
        // dd($totalrqstday); die;

        DB::table('leaveapprove')->insert([
          'teammemberid'     =>     $team->createdby,
          'leavetype'     =>     $team->leavetype,
          'totaldays'     =>     $totalrqstday,
          'year'     =>     '2023',
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);




        $period = CarbonPeriod::create($team->from, $team->to);
        $datess = [];
        foreach ($period as $date) {
          $datess[] = $date->format('Y-m-d');
        }


        $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
          ->where('enddate', '<=', $team->to)->select('startdate')->get();

        if (count($getholidays) != 0) {
          foreach ($getholidays as $date) {
            $hdatess[] = date('Y-m-d', strtotime($date->startdate));
          }
        } else {
          $hdatess[] = 0;
        }
        $sl_leave = array_diff($datess, $hdatess);

        //  dd( $cl_leave );
        $sl_leave_total = count(array_diff($datess, $hdatess));

        $lstatus = "SL/A";




        $noofdaysaspertimesheet = DB::table('timesheets')
          ->where('created_by', auth()->user()->teammember_id)
          ->where('date', '>=', '2023-04-26')
          ->where('date', '<=', '2023-05-25')
          ->select('timesheets.*')
          ->first();
        // dd($noofdaysaspertimesheet );

        foreach ($sl_leave as $cl_leave) {




          $cl_leave_day = date('d', strtotime($cl_leave));
          $cl_leave_month = date('F', strtotime($cl_leave));

          if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
            $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
          }


          $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
            ->where('month', $cl_leave_month)->first();

          $column = '';
          switch ($cl_leave_day) {
            case '26':
              $column = 'twentysix';
              break;
            case '27':
              $column = 'twentyseven';
              break;
            case '28':
              $column = 'twentyeight';
              break;
            case '29':
              $column = 'twentynine';
              break;
            case '30':
              $column = 'thirty';
              break;
            case '31':
              $column = 'thirtyone';
              break;
            case '01':
              $column = 'one';
              break;
            case '02':
              $column = 'two';
              break;
            case '03':
              $column = 'three';
              break;
            case '04':
              $column = 'four';
              break;
            case '05':
              $column = 'five';
              break;
            case '06':
              $column = 'six';
              break;
            case '07':
              $column = 'seven';
              break;
            case '08':
              $column = 'eight';
              break;
            case '09':
              $column = 'nine';
              break;
            case '10':
              $column = 'ten';
              break;
            case '11':
              $column = 'eleven';
              break;
            case '12':
              $column = 'twelve';
              break;
            case '13':
              $column = 'thirteen';
              break;
            case '14':
              $column = 'fourteen';
              break;
            case '15':
              $column = 'fifteen';
              break;
            case '16':
              $column = 'sixteen';
              break;
            case '17':
              $column = 'seventeen';
              break;
            case '18':
              $column = 'eighteen';
              break;
            case '19':
              $column = 'ninghteen';
              break;
            case '20':
              $column = 'twenty';
              break;
            case '21':
              $column = 'twentyone';
              break;
            case '22':
              $column = 'twentytwo';
              break;
            case '23':
              $column = 'twentythree';
              break;
            case '24':
              $column = 'twentyfour';
              break;
            case '25':
              $column = 'twentyfive';
              break;
          }

          if (!empty($column)) {

            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
              ->whereRaw("{$column} != 'LWP'")
              ->update([
                $column => $lstatus,
              ]);
          }
        }
      }
      // dd($id);
      $applyleaveteam = DB::table('leaveteams')
        ->leftjoin('teammembers', 'teammembers.id', 'leaveteams.teammember_id')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('leaveteams.leave_id', $id)
        ->select('teammembers.emailid')->get();
      //   dd($applyleaveteam);
      if ($applyleaveteam != null) {
        foreach ($applyleaveteam as $applyleaveteammail) {
          $data = array(
            'emailid' =>  $applyleaveteammail->emailid,
            'team_member' =>  $team->team_member,
            'from' =>  $team->from,
            'to' =>  $team->to,
          );

          Mail::send('emails.applyleaveteam', $data, function ($msg) use ($data) {
            $msg->to($data['emailid']);
            $msg->subject('VSA Leave Approved');
          });
        }
      }
      $data = array(
        'emailid' =>  $team->emailid,
        'id' =>  $id,
        'from' =>  $team->from,
        'to' =>  $team->to,
      );

      Mail::send('emails.applyleavestatus', $data, function ($msg) use ($data) {
        $msg->to($data['emailid']);
        // $msg->cc('priyankasharma@kgsomani.com');
        $msg->subject('VSA Leave Approved');
      });
    }
    if ($request->status == 2) {

      $team = DB::table('applyleaves')
        ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
        ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('applyleaves.id', $id)
        ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name')->first();


      $data = array(
        'emailid' =>  $team->emailid,
        'id' =>  $id,
        'from' =>  $team->from,
        'to' =>  $team->to,
      );

      Mail::send('emails.applyleavereject', $data, function ($msg) use ($data) {
        $msg->to($data['emailid']);
        // $msg->cc('priyankasharma@kgsomani.com');
        $msg->subject('VSA Leave Reject');
      });


      $period = CarbonPeriod::create($team->from, $team->to);

      $datess = [];
      foreach ($period as $date) {
        $datess[] = $date->format('Y-m-d');

        DB::table('timesheets')->where('date', $date->format('Y-m-d'))
          ->where('created_by', $team->createdby)->delete();
        DB::table('timesheetusers')->where('createdby', $team->createdby)
          ->where('date', $date->format('Y-m-d'))->delete();
      }


      $getholidays = DB::table('holidays')->where('startdate', '>=', $team->from)
        ->where('enddate', '<=', $team->to)->select('startdate')->get();

      if (count($getholidays) != 0) {
        foreach ($getholidays as $date) {
          $hdatess[] = date('Y-m-d', strtotime($date->startdate));
        }
      } else {
        $hdatess[] = 0;
      }
      $leave = array_diff($datess, $hdatess);

      //  dd( $cl_leave );
      $leave_total = count(array_diff($datess, $hdatess));

      $lstatus = NULL;






      foreach ($leave as $cl_leave) {

        $cl_leave_day = date('d', strtotime($cl_leave));
        $cl_leave_month = date('F', strtotime($cl_leave));

        if ($cl_leave_day >= 26 && $cl_leave_day <= 31) {
          $cl_leave_month = date('F', strtotime($cl_leave . ' +1 month'));
        }


        $attendances = DB::table('attendances')->where('employee_name', $team->createdby)
          ->where('month', $cl_leave_month)->first();

        $column = '';

        switch ($cl_leave_day) {
          case '26':
            $column = 'twentysix';
            break;
          case '27':
            $column = 'twentyseven';
            break;
          case '28':
            $column = 'twentyeight';
            break;
          case '29':
            $column = 'twentynine';
            break;
          case '30':
            $column = 'thirty';
            break;
          case '31':
            $column = 'thirtyone';
            break;
          case '01':
            $column = 'one';
            break;
          case '02':
            $column = 'two';
            break;
          case '03':
            $column = 'three';
            break;
          case '04':
            $column = 'four';
            break;
          case '05':
            $column = 'five';
            break;
          case '06':
            $column = 'six';
            break;
          case '07':
            $column = 'seven';
            break;
          case '08':
            $column = 'eight';
            break;
          case '09':
            $column = 'nine';
            break;
          case '10':
            $column = 'ten';
            break;
          case '11':
            $column = 'eleven';
            break;
          case '12':
            $column = 'twelve';
            break;
          case '13':
            $column = 'thirteen';
            break;
          case '14':
            $column = 'fourteen';
            break;
          case '15':
            $column = 'fifteen';
            break;
          case '16':
            $column = 'sixteen';
            break;
          case '17':
            $column = 'seventeen';
            break;
          case '18':
            $column = 'eighteen';
            break;
          case '19':
            $column = 'ninghteen';
            break;
          case '20':
            $column = 'twenty';
            break;
          case '21':
            $column = 'twentyone';
            break;
          case '22':
            $column = 'twentytwo';
            break;
          case '23':
            $column = 'twentythree';
            break;
          case '24':
            $column = 'twentyfour';
            break;
          case '25':
            $column = 'twentyfive';
            break;
        }

        if (!empty($column)) {
          $columnValue = DB::table('attendances')
            ->where('employee_name', $team->createdby)
            ->where('month', $cl_leave_month)
            ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
            ->value($column);



          if ($columnValue == "SL/C" || $columnValue == "SL/A") {
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->decrement('sick_leave');
          }

          if ($columnValue == "EL/C" || $columnValue == "EL/A") {
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->decrement('exam_leave');
          }
          if ($columnValue == "BL/C" || $columnValue == "BL/A") {
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->decrement('birthday_religious');
          }
          if ($columnValue == "LWP") {
            DB::table('attendances')
              ->where('employee_name', $team->createdby)
              ->where('month', $cl_leave_month)
              ->decrement('LWP');
          }
          DB::table('attendances')
            ->where('employee_name', $team->createdby)
            ->where('month', $cl_leave_month)
            ->whereRaw("NOT ({$column} REGEXP '^-?[0-9]+$')")
            ->update([
              $column => $lstatus
            ]);
        }
      }
      // dd('end');
    }

    $data = $request->except(['_token', 'teammember_id']);
    $data['updatedby'] = auth()->user()->teammember_id;
    Applyleave::find($id)->update($data);


    $output = array('msg' => 'Updated Successfully');
    return redirect('applyleave')->with('success', $output);
  } catch (Exception $e) {
    DB::rollBack();
    Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
    report($e);
    $output = array('msg' => $e->getMessage());
    return back()->withErrors($output)->withInput();
  }
}

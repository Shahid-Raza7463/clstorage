<?php

class ZipController extends Controller
{
//*
//*
if ($request->status == 1) {
  $team = DB::table('leaverequest')
    ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
    ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
    ->leftjoin('teammembers', 'teammembers.id', 'applyleaves.createdby')
    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    ->where('leaverequest.id', $id)
    ->select('applyleaves.*', 'teammembers.emailid', 'teammembers.team_member', 'roles.rolename', 'leavetypes.name', 'leavetypes.holiday', 'leaverequest.id as examrequestId', 'leaverequest.date')
    ->first();


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
}
dd('end hare ', $team->name);
//* insert null value in database 

$lstatus = null;
//* delete data between two dates from database 
app\Http\Controllers\ApplyleaveController.php

$to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
// 2023-12-24 16:12:00.0 Asia/Kolkata (+05:30)
$from = Carbon::createFromFormat('Y-m-d', $team->from);
//2023-12-16 16:12:40.0 Asia/Kolkata (+05:30)
$camefromexam = Carbon::createFromFormat('Y-m-d', $team->date);
// dd($from);
$nowrequestdays = $from->diffInDays($camefromexam) + 1;
// 5 days

$finddatafromleaverequest = $to->diffInDays($from) + 1;


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

dd($datess);
//* error get patch ya any route related use it 

Route::any('/examleaverequestapprove/{id}', [ApplyleaveController::class, 'examleaverequest'])->name('examleaveapprove');

//* holidays count
// app\Http\Controllers\ApplyleaveController.php in update function 

$holidaycount = DB::table('holidays')->where('startdate', '>=', $team->from)
->where('enddate', '<=', $team->to)
->count();
dd($holidaycount);
//* regarding redirect 
$output = array('msg' => 'Please Approve Latest Timesheet Request');
return redirect('timesheetrequest/view/' . $id)->with('statuss', $output);
// for rejected message 
$output = array('msg' => 'Rejected Successfully');
return back()->with('statuss', $output);

// for success message 
$output = array('msg' => 'You have already submitted a request');
return back()->with('success', $output);
//* update one column in table for all 

use Illuminate\Support\Facades\DB;

// Your update query
DB::table('assignmentteammappings')
    ->update(['status' => 0]);

//* Ternary operator vs Null coalescing operator in PHP
// Ternary Operator

// Ternary operator is the conditional operator which helps to cut the number of lines in the coding while performing comparisons and conditionals. It is an alternative method of using if else and nested if else statements. The order of execution is from left to right. It is absolutely the best case time saving option. It does produces an e-notice while encountering a void value with its conditionals. 

// Syntax:

// (Condition) ? (Statement1) : (Statement2);
// Example
// PHP program to check number is even
// or odd using ternary operator
 
// Assign number to variable
$num = 21;
 
// Check condition and display result
print ($num % 2 == 0) ? "Even Number" : "Odd Number";


// Null coalescing operator

// The Null coalescing operator is used to check whether the given variable is null or not and returns the non-null value from the pair of customized values. Null Coalescing operator is mainly used to avoid the object function to return a NULL value rather returning a default optimized value. It is used to avoid exception and compiler error as it does not produce E-Notice at the time of execution. The order of execution is from right to left. While execution, the right side operand which is not null would be the return value, if null the left operand would be the return value. It facilitates better readability of the source code. 

// Syntax:

// (Condition) ? (Statement1) ? (Statement2);

// PHP program to use Null 
// Coalescing Operator
 
// Assign value to variable
$num = 10;
 
// Use Null Coalescing Operator 
// and display result
print ($num) ?? "NULL";
Output:
10

//*
    //BAN100157Nitin Singhal
    //* inactive and active / rejected / submitted  / mail send / send mail
    public function  assignmentreject($id, $status,$teamid)
    {
        // dd($teamid);
      try {

       if($status==1){
        DB::table('assignmentteammappings')->where('id', $id)->update([
            'status'   => 1,
          ]);
       }
        else{
            DB::table('assignmentteammappings')->where('id', $id)->update([
                'status'   => 0,
              ]); 

              // timesheet rejected mail
        $data = DB::table('teammembers')
        ->where('teammembers.id', $teamid)
        ->first();
      //   dd($data);
      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.assignmentrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Assignment rejected');
      });
      // timesheet rejected mail end hare

        }
        
  
  
        $output = array('msg' => 'Rejected Successfully');
        return back()->with('statuss', $output);
      } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
      }
    }
    // find date beetween two dates/ all dates find  

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
          $a = DB::table('timesheetusers')->insert([
            'date'        => date('Y-m-d', strtotime($date)),
            'createdby'   => auth()->user()->teammember_id,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => date('Y-m-d H:i:s'),
          ]);
        }
      }
    //*order by  desc / DESC/ASC/ Ascending  order / Descending 

    $getauthh =  DB::table('timesheetusers')
    ->where('createdby', auth()->user()->teammember_id)
    ->orderBy('id', 'ASC')->paginate(10);
    ->orderby('id', 'desc')->first();
    //* compare date in controller 

    $requestDate = Carbon::parse($request->date);
    $joiningDate = Carbon::parse($joining_date);

    if ($requestDate >= $joiningDate) {
    }
    //* how to  get all date beteen two dates in laravel/ two dates get beetweeen
    elseif ($Newteammeber->id != null) {
        $Newteammeberjoining_date = DB::table('teammembers')
          ->where('id', auth()->user()->teammember_id)
          ->select('joining_date')
          ->first();

        $joining_date = date('d-m-Y', strtotime($Newteammeberjoining_date->joining_date));
        $joining_timestamp = strtotime($joining_date);

        // Calculate the day of the week for the joining date (0 for Sunday, 1 for Monday, and so on)
        $day_of_week = date('w', $joining_timestamp);

        // Calculate the number of days to subtract to reach the previous Sunday
        $days_to_subtract = $day_of_week;

        // Calculate the timestamp of the previous Sunday
        $previous_sunday_timestamp = strtotime("-$days_to_subtract days", $joining_timestamp);

        // Format the previous Sunday date in the desired format
        $previous_sunday_date = date('d-m-Y', $previous_sunday_timestamp);

        $startDate = Carbon::parse($previous_sunday_date);
        $endDate = Carbon::parse($joining_date);

        // Create a date period
        $period = CarbonPeriod::create($startDate, $endDate);

        $result = [];

        // Iterate over the period and store each date in the result array
        foreach ($period as $key => $date) {
          // Skip the first and last iterations
          if ($key !== 0 && $key !== count($period) - 1) {
            $result[] = $date->toDateString();
          }
        }

        // Return the result array
        return $result;
      }

    // 11111111111111111
      use Carbon\Carbon;
      use Carbon\CarbonPeriod;
      
      $startDate = Carbon::parse('2023-01-01');
      $endDate = Carbon::parse('2023-01-10');
      
      // Create a date period
      $period = CarbonPeriod::create($startDate, $endDate);
      
      // Iterate over the period and get each date
      foreach ($period as $date) {
          echo $date->toDateString() . "\n";
      }
      
    //* insert months in database 
          // insert data in timesheet from request and get id only
          $id = DB::table('timesheets')->insertGetId(
            [
              'created_by' => auth()->user()->teammember_id,
              'month'     =>    date('F', strtotime($request->date)),
              'date'     =>    date('Y-m-d', strtotime($request->date)),
              'created_at'          =>     date('Y-m-d H:i:s'),
            ]
          );

    //*  week days in numbric/ regarding months / weeks days / regarding date and time  /regarding date 
        // dd(date('w', strtotime($request->date))); // 4

        $period = CarbonPeriod::create($team->from, $team->to);
        
        //  dd(date('Y-m-d', strtotime($request->date))); "2023-11-30"

        // $currentDate = Carbon::now()->format('d-m-Y');// "30-11-2023"

        // $currentday = date('Y-m-d', strtotime($request->date));// "2023-11-30"

        //   dd(date('F', strtotime($request->date)));// "November"

             // dd(date('Y-m-d H:i:s')); // "2023-11-30 15:26:18"

        // 'month'     =>    date('F', strtotime($request->date)),//November

        date('F d,Y', strtotime($holidayDatas->startdate)); //January 14,2023
// Get hour
          dd(date('H', strtotime($latestrequest->created_at))); //11

          dd($latestrequesthour->diffInHours($currentDateTime));

          DB::table('leaverequest')->insert([
            'applyleaveid' => $request->applyleaveid,
            'createdby' => $request->createdby,
            'approver' => $request->approver,
            'status' => $request->status,
            'reason' => $request->reason,
            'date' => date('Y-m-d', strtotime($request->date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

          // count days 

          $to = Carbon::createFromFormat('Y-m-d', $team->to ?? '');
            // date: 2023-11-16 15:42:44.0 Asia/Kolkata (+05:30)
            // dd($to);
            $from = Carbon::createFromFormat('Y-m-d', $team->from);

            // date: 2023-09-16 15:43:42.0 Asia/Kolkata (+05:30)
            // dd($from);
            $requestdays = $to->diffInDays($from) + 1;
            // 62 days
          // count days  end


       // now() function 
    //    12
        dd(now()->month); 
        // 2023
        dd(now()->year); 
        // 1 
        dd(now()->day); 
        // 17
        dd(now()->hour); 
        // 13;
        dd(now()->minute); 
        // Formats the date and time as a string (e.g., '2023-12-01 15:30:00').
        $formattedDateTime = now()->format('Y-m-d H:i:s'); 
        // Formats the date and time as a string (e.g., '2023-12-01 15:30:00').
        $formattedDateTime = now()->format('Y-m-d H:i:s'); 
        // Current year (e.g., 2023)
        $year = now()->year;     
        // Current month (e.g., 12)
        $month = now()->month;   
        // Current day of the month (e.g., 1)
        $day = now()->day;       
        // Current hour (e.g., 15)
        $hour = now()->hour;     
        // Current minute (e.g., 30)
        $minute = now()->minute; 
        // Add 7 days to the current date
        $futureDate = now()->addDays(7);   
        // Subtract 2 hours from the current date and time
         $pastDate = now()->subHours(2);    
         // Check if the current date and time is in the future
         $isFuture = now()->isFuture();     
         // Check if the current date and time is in the past
         $isPast = now()->isPast();         
         // Convert the current date and time to a different timezone
         $userTimeZone = now()->setTimezone('America/New_York'); 


      //* date() function 
      // Formats the current date and time as a string
      $currentDateTime = date('Y-m-d H:i:s'); 
      // Formats a specific date
      $formattedDate = date('Y-m-d', strtotime('2023-12-01')); 
      // Convert a string to a Unix timestamp
      $timestamp = strtotime('2023-12-01'); 
      // Format the Unix timestamp
      $formattedDate = date('Y-m-d', $timestamp); 
      
      // Current year
       $year = date('Y');     
       // Current month
       $month = date('m');    
       // Current day of the month
       $day = date('d');      
       // Current hour (24-hour format)
       $hour = date('H');     
       // Current minute
       $minute = date('i');   
       // Current second
       $second = date('s');   
       // Current day of the week (full text, e.g., "Monday")
       $dayOfWeek = date('l');
       // Custom date and time format (e.g., "December 1, 2023, 3:30 pm")
       $customFormat = date('F j, Y, g:i a'); 

       date('d-m-Y', strtotime($timesheetrequestsData->created_at))
      //  12-10-2023
      // get only date
      $cl_leave_day = date('d', strtotime($cl_leave));
      // 12
       date('h-m-s', strtotime($timesheetrequestsData->created_at)) 
      //  11:12:53
      // 10 days only in table then
      <td>{{ date('F d,Y', strtotime($applyleaveDatas->from)) ?? '' }} -
      {{ date('F d,Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>

    // Sunday=1
    // Monday=2
    // Tuesday=3
    // Wednesday=4
    // Thursday=5
    // Friday=6
    // Saturday=7
    // Sunday=8

    if(
        (now()->isSunday() && now()->hour >= 18) ||
            now()->isMonday() ||
            now()->isTuesday() ||
            now()->isWednesday() ||
            now()->isThursday() ||
            now()->isFriday() ||
            (now()->isSaturday() && now()->hour <= 18)){

            }


     //* format() function 
     // Formats the current date and time as a string
     $formattedDateTime = now()->format('Y-m-d H:i:s'); 
     // Formats a specific date
     $formattedDate = Carbon\Carbon::parse('2023-12-01')->format('Y-m-d'); 
     $user = User::find(1);
     // Formats a date property of a model
     $formattedBirthdate = $user->birthdate->format('F j, Y'); 
     {{-- Blade View --}}
     {{ $user->created_at->format('M d, Y') }}
     $formattedDate = $user->created_at->format('d/m/Y');
     // "2 days ago"
     $relativeTime = now()->subDays(2)->diffForHumans(); 
     // Custom date and time format
     $customFormat = now()->format('F j, Y \a\t g:i A'); 
     // Spanish locale
     $formattedDate = now()->locale('es')->isoFormat('dddd, MMMM D, YYYY'); 








     //* auth() function 

     if (auth()->check()) {
        // User is authenticated
    } else {
        // User is not authenticated
    }
    // Returns the currently authenticated user or null if not authenticated
    $user = auth()->user(); 
    if (auth()->user()->isAdmin()) {
        // User is an admin
    }
    
    if (auth()->user()->can('edit_posts')) {
        // User has permission to edit posts
    }
    // Manually Authenticate a User:
    $user = User::find(1);
    // Manually log in a user
     auth()->login($user); 
    //  Log Out the Currently Authenticated User:
    // Log out the currently authenticated user
     auth()->logout(); 

     if (auth()->guest()) {
        // User is a guest (not authenticated)
    }
    // Check if a User is Authenticated via a Guard:
    if (auth('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    // Returns the ID of the currently authenticated user or null if not authenticated
    $userId = auth()->id(); 

    if (auth()->guard('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    // Check if a User is Remembered:
    if (auth()->viaRemember()) {
        // User is authenticated via "remember me" cookie
    }
    // Returns the user's authentication identifier
    $identifier = auth()->id(); 
    // Returns the authentication provider instance
    $provider = auth()->getProvider(); 
    // Returns the "remember me" token
    $rememberToken = auth()->user()->getRememberToken(); 
    // Log in a user by ID
    auth()->loginUsingId(1); 
    // Log the user out of all other devices
    auth()->user()->logoutOtherDevices('password'); 
    // Returns the name of the default guard
    $guardName = auth()->getDefaultDriver(); 
    // Returns the currently authenticated user or null if not authenticated
    $user = user(); 
    if (user()) {
        // User is authenticated
    } else {
        // User is not authenticated
    }
    // Get the user's ID
    $userId = user()->id;      
     // Get the user's name
    $userName = user()->name;  
    // Get the user's email
     $userEmail = user()->email; 
     if (user()->isAdmin()) {
        // User is an admin
    }
    
    if (user()->can('edit_posts')) {
        // User has permission to edit posts
    }
    $user = User::find(1);
    // Manually set the authenticated user
     user($user); 
     // Log out the currently authenticated user
     user()->logout(); 
     // Returns the user's authentication identifier
     $identifier = user()->getAuthIdentifier(); 
     // Returns the user's authentication provider name
     $provider = user()->getAuthIdentifierName(); 
     if (user()->guard('admin')->check()) {
        // User is authenticated using the 'admin' guard
    }
    
//* compare houre / hour compare 
    $latestrequest = DB::table('timesheetrequests')
        ->where('createdby', auth()->user()->teammember_id)
        ->select('created_at')
        ->first();

      $latestrequesthour = Carbon::parse($latestrequest->created_at);
      $currentDateTime = Carbon::now();
      // Check if the difference is more than 24 hours
      if ($latestrequesthour->diffInHours($currentDateTime) > 24) {
        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     => $request->partner,
          'reason'      => $request->reason,
          'status'      => 0,
          'createdby'   => auth()->user()->teammember_id,
          'created_at'  => now(),
          'updated_at'  => now(),
        ]);
      }
    



   //*  dd with mesaage/ check dd output 
    // dd('hi', $previoussavechck);

    //* ager ek table ke id ko dusre table ke kisi id se compare karna ho to / id pass /pass data in another table 


    $excludedIds = DB::table('timesheetusers')->select('createdby')->distinct()->get()->pluck('createdby')->toArray();
    $teammemberOnlySave = DB::table('teammembers')
        ->leftJoin('timesheets', 'timesheets.created_by', 'teammembers.id')
        ->where('teammembers.status', 1)
        ->whereIn('timesheets.created_by', $excludedIds)
        ->select('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        ->groupBy('teammembers.team_member', 'teammembers.emailid', 'teammembers.id')
        ->havingRaw('COUNT(DISTINCT timesheets.id) = COUNT(CASE WHEN timesheets.status = 0 THEN 1 ELSE NULL END)')
        ->get();


    dd($teammemberOnlySave);
    //* today time insert in database /time/ current time in database 'created_at' => now(),
    public function timesheeteditstore(Request $request)
    {
      try {
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   1,
          'client_id'   =>  $request->client_id,
          'assignment_id'   =>  $request->assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   1,
            'created_at' => now(),
            'updated_at' => now(),
          ]);
        }
        $output = array('msg' => 'Updated Successfully');
        // return back()->with('statuss', $output);
        return redirect()->to('rejectedlist')->with('statuss', $output);
      } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
      }

    //* filter on mail days wise

    if ('Friday' == date('l', time()) || 'Saturday' == date('l', time())) {
    }
    //* last week reminder /mail / notification on mail

    // public function handle()
    // {
    //     $teammember =  DB::table('teammembers')
    //         ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.created_at', '<', now()->subWeek())
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
    //     dd($teammember);
    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' =>   $teammember,
    //     );
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }

    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         $lastSubmissionDate = DB::table('timesheetusers')
    //             // get all date of this user
    //             ->where('createdby', $user->id)
    //             ->where('date', '<', now()->subWeeks(1))
    //             ->where(function ($query) {
    //                 $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    //                     ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    //             })
    //             // ->distinct('date')
    //             ->max('date');

    //         // Format the date as 'd-m-y'
    //         // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    //         $user->last_submission_date = $lastSubmissionDate;
    //     }

    //     // dd($teammember);

    //     $data = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember,
    //     );

    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $data, function ($msg) use ($data) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         $msg->subject($data['subject']);
    //     });
    // }

//! god code 
    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         // $lastSubmissionDate = DB::table('timesheetusers')
    //         //     // get all date of this user
    //         //     ->where('createdby', $user->id)
    //         //     ->where('date', '<', now()->subWeeks(1))
    //         //     ->where('status', '!=', 0)
    //         //     ->where(function ($query) {
    //         //         $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
    //         //             ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
    //         //     })
    //         //     // ->distinct('date')
    //         //     ->max('date');
        
    //         // Format the date as 'd-m-y'
    //         // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

    //         $user->last_submission_date = $lastSubmissionDate;
    //     }
    //     // dd($teammember);
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammember->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();

    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);

    //     // Modify the data for the email (excluding 'id')
    //     $emailData = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     );

    //     // dd($teammember);

    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    public function handle()
    {
        $teammember = DB::table('teammembers')
            ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
            // ->where('timesheetusers.date', '<', now()->subWeeks(1))
             ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek()) 
            ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
            ->distinct('timesheetusers.createdby')
            ->get();

        // Get the last submission date for each user only sunday and suterday
        foreach ($teammember as $user) {
            $lastSubmissionDate = DB::table('timesheetusers')
                // get all date of this user
                ->where('createdby', $user->id)
                ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
                // ->where('date', '<', now()->subWeeks(1))
                ->where('status', '!=', 0)
                ->where(function ($query) {
                    $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
                        ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
                })
                // ->distinct('date')
                ->max('date');
        
            // Format the date as 'd-m-y'
            // $lastSubmissionDate = Carbon::parse($lastSubmissionDate)->format('d-m-y');
            $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';

            $user->last_submission_date = $lastSubmissionDate;
        }
        // dd($teammember);
        // Create an array for the Excel export (excluding 'id')
        $excelData = $teammember->filter(function ($user) {
            return !empty($user->last_submission_date);
        })->map(function ($user) {
            return [
                'team_member' => $user->team_member,
                'emailid' => $user->emailid,
                'last_submission_date' => $user->last_submission_date,
            ];
        })->toArray();

        $export = new TimesheetLastWeekExport(collect($excelData));
        $excelFileName = 'Timesheet_last_week.xlsx';
        Excel::store($export, $excelFileName);

        // Modify the data for the email (excluding 'id')
        $emailData = array(
            'subject' => "Timesheet Not filled Last Week",
            'teammember' => $teammember->map(function ($user) {
                return (object) [
                    'team_member' => $user->team_member,
                    'emailid' => $user->emailid,
                    'last_submission_date' => $user->last_submission_date,
                ];
            }),
        );

        // dd($teammember);

        // Attach the Excel file to the email
        Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
            $msg->to('itsupport_delhi@vsa.co.in');
            $msg->cc('Admin_delhi@vsa.co.in');
            // Attach the Excel file to the email
            $msg->attach(storage_path('app/' . $excelFileName), [
                'as' => $excelFileName,
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            $msg->subject($emailData['subject']);
        });
    }
    // 222222222222222222
    // public function handle()
    // {
    //     $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
    //         ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();

    //     // Get the last submission date for each user only sunday and suterday
    //     foreach ($teammember as $user) {
    //         $teammember = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', function ($join) {
    //             $join->on('timesheetusers.createdby', '=', 'teammembers.id')
    //                 ->where('timesheetusers.date', '<', now()->subWeeks(1))
    //                 ->where('timesheetusers.status', '!=', 0)
    //                 ->where(function ($query) {
    //                     $query->whereRaw('DAYOFWEEK(timesheetusers.date) = 1') // Sunday
    //                         ->orWhereRaw('DAYOFWEEK(timesheetusers.date) = 7'); // Saturday
    //                 });
    //         })
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->distinct('timesheetusers.createdby')
    //         ->get();
        
    //     // Get the last submission date for each user
    //     foreach ($teammember as $user) {
    //         $lastSubmissionDate = $user->max('date');
            
    //         // Format the date as 'd-m-y'
    //         $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
        
    //         $user->last_submission_date = $lastSubmissionDate;
    //     }
        
    //     // Rest of your code...
        
    //     }
    //     // dd($teammember);
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammember->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();

    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);

    //     // Modify the data for the email (excluding 'id')
    //     $emailData = array(
    //         'subject' => "Timesheet Not filled Last Week",
    //         'teammember' => $teammember->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     );

    //     // dd($teammember);

    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    
    // public function handle()
    // {
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('timesheetusers', function ($join) {
    //             $join->on('timesheetusers.createdby', '=', 'teammembers.id')
    //                 ->where('timesheetusers.date', '>=', now()->subWeeks(1)->startOfWeek()) // Adjusted start date
    //                 ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())   // Adjusted end date
    //                 ->where('timesheetusers.status', '!=', 0)
    //                 ->where(function ($query) {
    //                     $query->whereRaw('DAYOFWEEK(timesheetusers.date) = 1') // Sunday
    //                         ->orWhereRaw('DAYOFWEEK(timesheetusers.date) = 7'); // Saturday
    //                 });
    //         })
    //         ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id', DB::raw('MAX(timesheetusers.date) as last_submission_date'))
    //         ->groupBy('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
    //         ->get();
    
    //     // Format the date as 'd-m-y'
    //     $teammembers->transform(function ($user) {
    //         $user->last_submission_date = $user->last_submission_date ? Carbon::parse($user->last_submission_date)->format('d-m-Y') : '';
    //         return $user;
    //     });
    
    //     // Create an array for the Excel export (excluding 'id')
    //     $excelData = $teammembers->filter(function ($user) {
    //         return !empty($user->last_submission_date);
    //     })->map(function ($user) {
    //         return [
    //             'team_member' => $user->team_member,
    //             'emailid' => $user->emailid,
    //             'last_submission_date' => $user->last_submission_date,
    //         ];
    //     })->toArray();
    
    //     // Create and store the Excel file
    //     $export = new TimesheetLastWeekExport(collect($excelData));
    //     $excelFileName = 'Timesheet_last_week.xlsx';
    //     Excel::store($export, $excelFileName);
    
    //     // Modify the data for the email (excluding 'id')
    //     $emailData = [
    //         'subject' => "Timesheet Not Filled Last Week",
    //         'teammembers' => $teammembers->map(function ($user) {
    //             return (object) [
    //                 'team_member' => $user->team_member,
    //                 'emailid' => $user->emailid,
    //                 'last_submission_date' => $user->last_submission_date,
    //             ];
    //         }),
    //     ];
    
    //     // Attach the Excel file to the email
    //     Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
    //         $msg->to('itsupport_delhi@vsa.co.in');
    //         $msg->cc('Admin_delhi@vsa.co.in');
    //         // Attach the Excel file to the email
    //         $msg->attach(storage_path('app/' . $excelFileName), [
    //             'as' => $excelFileName,
    //             'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    //         ]);
    //         $msg->subject($emailData['subject']);
    //     });
    // }
    

}
    //* success message from controller

    try {
        DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
          'status'   =>   1,
          'client_id'   =>  $request->client_id,
          'assignment_id'   =>  $request->assignment_id,
          'partner'   =>  $request->partner,
          'workitem'   =>   $request->workitem,
          'createdby'   =>   $request->createdby,
          'location'   =>   $request->location,
          'hour'   =>   $request->hour,
        ]);
  
        if ($request->status == 2) {
          DB::table('timesheetupdatelogs')->insert([
            'timesheetusers_id'   =>  $request->timesheetusersid,
            'status'   =>   1,
          ]);
        }
        $output = array('msg' => 'Updated Successfully');
        // return back()->with('statuss', $output);
        return redirect()->to('rejectedlist')->with('statuss', $output);
      } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
      }
    //* auth user

      dd(auth()->user()->teammember_id);
    //* store data in database / s3 problem /path store 
    public function store(Request $request)
    {
        // dd(auth()->user()->teammember_id);
        $request->validate([
            'particular' => 'required',
            'file' => 'required',
        ]);

        try {
            $data = $request->except(['_token']);
            $files = [];

            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $name = $file->getClientOriginalName();
                    $path = $file->storeAs('public\image\task', $name);
                    $files[] = $name;
                }
            }
            foreach ($files as $filess) {
                // dd($auth()->user()->teammember_id);
                // dd($files); die;
                $s = DB::table('assignmentfolderfiles')->insert([
                    'particular' => $request->particular,
                    'assignmentgenerateid' => $request->assignmentgenerateid,
                    'assignmentfolder_id' =>  $request->assignmentfolder_id,
                    'createdby' =>  auth()->user()->teammember_id,
                    'filesname' => $filess,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            $output = array('msg' => 'Submit Successfully');
            return back()->with('success', ['message' => $output, 'success' => true]);
        } catch (Exception $e) {
            // dd($e);
            DB::rollBack();
            Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
            report($e);
            $output = array('msg' => $e->getMessage());
            return back()->withErrors($output)->withInput();
        }
    }



    //* Download image on click 
    // !runnig code download image
    public function downloadAll(Request $request)
    {

        $articlefiles = DB::table('assignmentfolderfiles')->where('createdby', auth()->user()->id)->first();

        return response()->download(('backEnd/image/articlefiles/' . $articlefiles->filesname));
    }
    //* Download image on click 
}

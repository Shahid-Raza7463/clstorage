<?php

namespace App\Http\Controllers;

use App\Models\Teammember;
use App\Models\Timesheet;
use App\Jobs\TimesheetAttendanceinsert;
use App\imports\Timesheetimport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Assignmentmapping;
use App\Models\Assignment;
use App\Models\Job;
use App\Models\Timesheetusers;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use Auth;
use Excel;
use DateTime;

class TimesheetController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  public function transformDate($value, $format = 'Y-m-d')
  {
    try {
      return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
      return \Carbon\Carbon::createFromFormat($format, $value);
    }
  }
  public function timesheetexcelStore(Request $request)
  {
    $request->validate([
      'file' => 'required'
    ]);

    try {
      $file = $request->file;
      //  dd($file);
      $data = $request->except(['_token']);
      $dataa = Excel::toArray(new Timesheetimport, $file);
      //dd($dataa);
      foreach ($dataa[0] as $key => $value) {


        $currentday =
          \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value['date'])->format('Y-m-d');
        // $currentday= date('Y-m-d', strtotime($value['date']));
        // dd($currentday);

        $mytime = Carbon::now();

        $currentdate = $mytime->toDateString();
        $hour = $value['hour'];





        if ($currentday > $currentdate) {
          $output = array('msg' => 'You Can Not Fill Timesheet For Future Date (' . date('d-m-Y', strtotime($currentday)) . ')');
          return redirect('timesheet')->with('statuss', $output);
        } elseif ($hour > 24) {
          $output = array('msg' => 'The time entered exceeds the maximum of 24 hours !');
          return back()->with('statuss', $output);
        } else {

          $leaves = DB::table('applyleaves')
            ->where('applyleaves.createdby', auth()->user()->teammember_id)
            ->where('status', '!=', 2)
            //->orWhere('status',0)
            ->select('applyleaves.from', 'applyleaves.to')
            ->get();
          // dd($leaves);
          if (count($leaves) != 0) {
            foreach ($leaves as $leave) {
              //Convert each data from table to Y-m-d format to compare
              $days = CarbonPeriod::create(
                date('Y-m-d', strtotime($leave->from)),
                date('Y-m-d', strtotime($leave->to))
              );

              foreach ($days as $day) {
                $leavess[] = $day->format('Y-m-d');
                // dd($leavess);



              }
            }
            //dd($leavess);


            //  date('Y-m-d', strtotime($intval($value['date'])));
            // dd($currentday);
            if ($leavess != null) {
              //dd('if');
              foreach ($leavess as $leave) {

                if ($leave == $currentday) {
                  // dd('if');
                  // $ifcount=$ifcount+1;
                  $output = array('msg' => 'You Have Leave for the Day (' . date('d-m-Y', strtotime($leave)) . ')');
                  return redirect('timesheet')->with('statuss', $output);
                } else {
                  //  dd($currentday);
                }
              }
            }
          }
          $clients   = DB::table('clients')->where('client_name', $value['clientname'])->pluck('id')->first();
          //dd($clients);
          if ($clients == null) {
            //dd($clients);
            $output = array('msg' => 'Client Name (' . $value['clientname'] . ') Not Match Please Check!!');
            return back()->with('statuss', $output);
          } else {
            //dd($clients);
            $assignments = DB::table('assignments')->where('assignment_name', $value['assignmentname'])->pluck('id')->first();
            if ($assignments == null) {
              $output = array('msg' => 'Assigment Name (' . $value['assignmentname'] . ') Not Found Please Check!!');
              return back()->with('statuss', $output);
            }
            $partner = DB::table('teammembers')->where('team_member', $value['partner'])->pluck('id')->first();
            if ($partner == null) {
              $output = array('msg' => 'Partner Name (' . $value['partner'] . ') Not Match Please Check!!');
              return back()->with('statuss', $output);
            }
            if ($value['billablestatus'] != "Non Billable" && $value['billablestatus'] != "Billable") {
              $output = array('msg' => 'Billable status (' . $value['billablestatus'] . ') Not Match Please Check!!');
              return back()->with('statuss', $output);
            }
            $timesheet = DB::table('timesheets')->where('created_by', auth()->user()->teammember_id)
              ->where('date', $value['date'])->pluck('id')->first();

            if ($timesheet == null) {

              $id = DB::table('timesheets')->insertGetId(
                [
                  'created_by' => auth()->user()->teammember_id,
                  'date'     =>     $this->transformDate($value['date']),
                  'created_at'          =>     date('Y-m-d H:i:s'),
                ]
              );
              $timesheets = DB::table('timesheets')->where('id', $id)->first();
              DB::table('timesheets')->where('id', $timesheets->id)->update([
                'date'     =>    date('Y-m-d', strtotime($timesheets->date)),
                'month'     =>    date('F', strtotime($timesheets->date)),
              ]);
            }



            DB::table('timesheetusers')->insert([
              'date'     =>       $this->transformDate($value['date']),
              'client_id'     =>     $clients,
              'workitem'     =>     $value['workitem'],
              'billable_status'     =>      $value['billablestatus'],
              'timesheetid'     =>     $id,

              'hour'     =>     $value['hour'],
              'totalhour' =>      $value['hour'],
              'assignment_id'     =>     $assignments,
              'partner'     =>     $partner,
              'createdby' => auth()->user()->teammember_id,
              'created_at'          =>     date('Y-m-d H:i:s'),
              'updated_at'              =>    date('Y-m-d H:i:s'),
            ]);
            $totalhour = DB::table('timesheetusers')->select('date', DB::raw('COUNT(*) as `count`'))
              ->where('createdby', auth()->user()->teammember_id)
              ->groupBy('date')
              ->havingRaw('COUNT(*) > 1')

              ->get();
            foreach ($totalhour as $value) {
              $sum = DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)->where('date', $value->date)->sum('hour');

              DB::table('timesheetusers')->where('createdby', auth()->user()->teammember_id)->where('date', $value->date)->update([
                'totalhour'         =>   $sum,
              ]);

              //attendance reflection'

              $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
                ->where('month', 'June')->first();
              //  dd($value->created_by);

              // dd($attendances);
              if ($attendances ==  null) {
                $a = DB::table('attendances')->insert([
                  'employee_name'         =>     auth()->user()->teammember_id,
                  'month'         =>    'June',
                  'created_at'          =>     date('Y-m-d H:i:s'),
                  //   'exam_leave'      =>$value->date_total,
                ]);
                // dd($a);
              }

              //   dd($noofdaysaspertimesheet);
              $hdatess = date('Y-m-d', strtotime($value->date));

              // dd($hdatess);
              if ($hdatess == '2023-05-26') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentysix'         =>     $sum,
                  ]);
              }

              if ($hdatess == '2023-05-27') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyseven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-28') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyeight'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-29') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentynine'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-30') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirty'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-05-31') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirtyone'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-01') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'one'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-02') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'two'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-03') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'three'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-04') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'four'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-05') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'five'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-06') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'six'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-07') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'seven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-08') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eight'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-09') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'nine'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-10') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'ten'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-11') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eleven'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-12') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twelve'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-13') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'thirteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-14') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'fourteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-15') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'fifteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-16') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'sixteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-17') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'seventeen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-18') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'eighteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-19') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'ninghteen'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-20') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twenty'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-21') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyone'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-22') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentytwo'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-23') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentythree'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-24') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyfour'         =>     $sum,
                  ]);
              }
              if ($hdatess == '2023-06-25') {
                DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)

                  ->where('month', 'June')->update([
                    'twentyfive'         =>     $sum,
                  ]);
              }

              //end attendance




            }
          }
        }
      }
      //dd($dataa);
      $output = array('msg' => 'Excel file upload Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function index()
  {
    if (auth()->user()->teammember_id == 99 || auth()->user()->teammember_id == 550 || auth()->user()->teammember_id == 161 || auth()->user()->teammember_id == 157) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();
      $result = DB::table('timesheets')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');


      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      return view('backEnd.timesheet.hrsearch', compact('timesheetData', 'teammember', 'month', 'years'));
    } elseif (auth()->user()->role_id == 11) {

      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
        ->where('teammembers.status', '1')->distinct()->get();

      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();
      $result = DB::table('timesheets')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();

      $years = $result->pluck('year');

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);

      return view('backEnd.timesheet.hrsearch', compact('timesheetData', 'teammember', 'month', 'years'));
    } elseif (auth()->user()->role_id == 18) {

      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
        ->distinct()->get();

      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheets')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');


      $getauths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->whereNotNull('created_at') // Ensure date is not null

        ->orderBy('date', 'desc') // Make sure 'date' is the correct column name for your date field
        ->first();


      if ($getauths ==  null) {
        $getauth = date('Y-m-d');
      } else {
        $getauth = $getauths->date;
      }


      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);

      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $client = DB::table('assignmentmappings')
        ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
        ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
        ->select('clients.id', 'clients.client_name')
        ->groupBy('assignmentbudgetings.client_id', 'clients.id', 'clients.client_name')
        ->orderBy('clients.client_name', 'ASC')
        ->get();

      return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years', 'getauth', 'timesheetrequest', 'client', 'partner'));
    } else {
      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');

      $currentDate = now();


      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');


      $getauth =  DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->whereNotNull('created_at') // Ensure date is not null

        ->orderby('date', 'desc')->first();

      if (auth()->user()->role_id == 13) {
        $client = DB::table('assignmentmappings')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->where(function ($query) {
            $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
              ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
          })
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();
      } else {
        $client = DB::table('assignmentmappings')
          ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
          ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
          ->select('clients.id', 'clients.client_name')
          ->groupBy('assignmentbudgetings.client_id', 'clients.id', 'clients.client_name')
          ->orderBy('clients.client_name', 'ASC')
          ->get();
      }


      $timesheetData =  $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', auth()->user()->teammember_id)
        ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheets.date) = ?', [$year])
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(100);

      if (auth()->user()->role_id == 13) {
        $partner = Teammember::where('id', '=', 156)->where('status', '=', 1)->with('title')->get();
      } else {
        $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      }


      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)
        ->orderBy('id', 'DESC')
        ->first();

      if ($getauth  == null) {
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
  public function mytimelist()
  {
    $teammember = DB::table('timesheets')
      ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->where('timesheetusers.partner', auth()->user()->teammember_id)
      ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
    //  dd($teammember);
    $month = DB::table('timesheets')
      ->select('timesheets.month')->distinct()->get();

    $result = DB::table('timesheets')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');


    $timesheetData = DB::table('timesheets')
      ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      ->where('timesheetusers.partner', auth()->user()->teammember_id)
      ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    // dd($timesheetData);
    return view('backEnd.timesheet.partnerindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }


  public function show(Request $request)
  {
    if ($request->method() === 'POST') {

      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      $dropdownMonths = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->distinct()
        ->pluck('month');


      $month = $request->month;
      $year = $request->year;


      $getauth =  DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->whereNotNull('created_at') // Ensure date is not null

        ->orderby('date', 'desc')->first();

      //   dd($getauth);
      $client = Client::select('id', 'client_name')->get();
      $timesheetData =  $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', auth()->user()->teammember_id)
        ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheets.date) = ?', [$year])
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(100);
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauth  == null) {
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

    $result = DB::table('timesheets')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    if (auth()->user()->teammember_id == 23) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('teammembers.role_id', '15')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();


      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    } elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    } elseif (auth()->user()->role_id == 13) {
      $teammember = DB::table('timesheets')
        ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member')->get();
    }
    return view('backEnd.timesheet.hrsearch', compact('timesheetData', 'teammember', 'month', 'years'));
  }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create(Request $request)
  {

    if (auth()->user()->role_id == 11 or auth()->user()->role_id == 13) {

      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
      if (auth()->user()->role_id == 13) {
        $client = DB::table('assignmentmappings')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
          ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
          ->where(function ($query) {
            $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
              ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
          })
          ->where('assignmentbudgetings.status', 1)
          //     ->where('assignmentbudgetings.approvalstatus', 1)
          ->select('clients.client_name', 'clients.id', 'clients.client_code')
          ->orderBy('client_name', 'ASC')
          ->distinct()->get();
      } else {
        $client = Assignmentmapping::getClientNames();
      }
      $assignment = Assignment::select('id', 'assignment_name')->get();
      //   dd($assignment);
      if ($request->ajax()) {
        //  dd($request);
        if (isset($request->cid)) {
          echo "<option value=''>Select Assignment</option>";
          foreach (
            DB::table('assignmentbudgetings')->where('client_id', $request->cid)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
              ->orderBy('assignment_name')
              ->where('assignmentbudgetings.status', 1)->get() as $sub
          ) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '(' . $sub->assignmentname . ')' . '(' . $sub->assignmentgenerate_id . ')' . "</option>";
          }
        }
        if (isset($request->assignment)) {


          if ($request->assignment == '329177531230') {
            echo "<option value=''>Select Partner</option>";

            $teammembers = DB::table('teammembers')
              ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
              ->where('teammembers.role_id', 13)
              ->select('teammembers.id', 'teammembers.team_member')
              ->get();

            foreach ($teammembers as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
            }
          } else {
            //  dd($request->assignment);
            if (auth()->user()->role_id == 13) {
              //  dd($request->assignment);
              echo "<option value=''>Select Partner</option>";
              foreach (
                DB::table('teammembers')
                  ->whereIn('id', [156, 171])
                  ->get() as $subs
              ) {
                echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
              }
            } else {
              //  dd($request->assignment);
              echo "<option value=''>Select Partner</option>";
              foreach (
                DB::table('assignmentmappings')

                  ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                  ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)->get() as $subs
              ) {
                echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
              }
            }
          }
        }
      } else {
        return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
      }
    } else {
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
      $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
      $client = AssignmentMapping::getClientNames();
      $assignment = Assignment::select('id', 'assignment_name')->get();

      $getauth =  DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->whereNotNull('created_at') // Ensure date is not null

        ->orderby('date', 'desc')->first();

      if ($getauth ==  null) {
        $getauths = date('Y-m-d');
        //dd($getauth->date);
      } else {
        $getauths = $getauth->date;
      }
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();
      $sevenDaysAgo = Carbon::now()->subDays(10)->startOfDay();

      $selectedDate = Carbon::parse($getauths)->startOfDay();


      $currentdate = date('Y-m-d');
      $to = Carbon::createFromFormat('Y-m-d', $getauths ?? '');

      $from = Carbon::createFromFormat('Y-m-d', $currentdate);
      $diff_in_days = $to->diffInDays($from);



      if ($request->ajax()) {
        //  dd($request);
        if (isset($request->cid)) {
          echo "<option value=''>Select Assignment</option>";
          foreach (
            DB::table('assignmentbudgetings')->where('client_id', $request->cid)
              ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->orderBy('assignment_name')
              ->where('assignmentbudgetings.status', 1)->get() as $sub
          ) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '(' . $sub->assignmentname . ')' . '(' . $sub->assignmentgenerate_id . ')' . "</option>";
          }
        }
        if (isset($request->assignment)) {


          if ($request->assignment == '329177531230') {
            echo "<option value=''>Select Partner</option>";

            $teammembers = DB::table('teammembers')
              ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
              ->where('teammembers.role_id', 13)
              ->select('teammembers.id', 'teammembers.team_member')
              ->get();

            foreach ($teammembers as $subs) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
            }
          } else {
            //  dd($request->assignment);
            echo "<option value=''>Select Partner</option>";
            foreach (
              DB::table('assignmentmappings')

                ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)->get() as $subs
            ) {
              echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
            }
          }
        }
      } else {

        $user_id = auth()->user()->teammember_id;
        $allowed_ids = [951, 984, 708, 1008, 1001, 1003];


        if ($timesheetrequest && $timesheetrequest->status == 0) {
          // Fetch the previous timesheet request
          $previousTimesheetRequest = DB::table('timesheetrequests')
            ->where('createdby', $user_id)
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->first();



          //dd($previousTimesheetRequest);

          if ($previousTimesheetRequest && $previousTimesheetRequest->status == 1) {
            // Validate the date
            $validateDate = Carbon::parse($previousTimesheetRequest->validate)->startOfDay();
            $today = Carbon::today();

            //dd($today);


            if ($today->lessThanOrEqualTo($validateDate)) {
              // Update $timesheetRequest with the latest approved timesheet request
              $timesheetrequest = $previousTimesheetRequest;
              //  dd('hi');
            } else {
              //  dd('hello');
            }
          }
        }
        if (!in_array($user_id, $allowed_ids)) {

          if ($diff_in_days > 11) {
            if ($timesheetrequest == null) {
              abort(403, ' you have to request to partner for access this page ');
            } else {


              if ($currentdate <= $timesheetrequest->validate) {

                if ($request->ajax()) {
                  //  dd($request);
                  if (isset($request->cid)) {
                    echo "<option value=''>Select Assignment</option>";
                    foreach (
                      DB::table('assignmentbudgetings')->where('client_id', $request->cid)
                        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
                        ->orderBy('assignment_name')
                        ->where('assignmentbudgetings.status', 1)->get() as $sub
                    ) {
                      echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name  . '(' . $sub->assignmentname . ')' . '(' . $sub->assignmentgenerate_id . ')' . "</option>";
                    }
                  }
                  if (isset($request->assignment)) {


                    if ($request->assignment == '329177531230') {
                      echo "<option value=''>Select Partner</option>";

                      $teammembers = DB::table('teammembers')
                        ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
                        ->where('teammembers.role_id', 13)
                        ->select('teammembers.id', 'teammembers.team_member')
                        ->get();

                      foreach ($teammembers as $subs) {
                        echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
                      }
                    } else {
                      //  dd($request->assignment);
                      echo "<option value=''>Select Partner</option>";
                      foreach (
                        DB::table('assignmentmappings')

                          ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
                          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)->get() as $subs
                      ) {
                        echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
                      }
                    }
                  }
                } else {
                  return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
                }
              } else {
                abort(403, ' you already requested done for timesheet.');
              }
            }
          } else {
            return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
          }
        } else {
          return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner'));
        }
      }
    }
  }
  public function timesheetajax()
  {
    if ($request->ajax()) {
      //  dd($request);
      if (isset($request->cid)) {
        echo "<option>Select Assignment</option>";
        foreach (
          DB::table('assignmentbudgetings')->where('client_id', $request->cid)
            ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
            ->orderBy('assignment_name')->get() as $sub
        ) {
          echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        }
      }
    }
  }


  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {



    try {

      $data = $request->except(['_token', 'teammember_id', 'amount']);

      $teamjoiningdate = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();


      if (date('Y-m-d', strtotime($request->date)) < date('Y-m-d', strtotime($teamjoiningdate->joining_date))) {
        //dd('hi');
        $output = array('msg' => 'You cannot fill before joining date');
        return back()->with('statuss', $output);
      }


      $currentDate = Carbon::now()->format('d-m-Y');
      //dd($currentHour);
      if ($currentDate == $request->date && Carbon::now()->hour < 18) {
        //dd('hi');
        $output = array('msg' => 'You can only fill today timesheet after 6:00 pm.');
        return back()->with('statuss', $output);
      }


      $previoussavechck = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('date', date('d-m-Y', strtotime($request->date)))
        //->where('status',0)
        //->latest()
        ->first();

      //dd($previoussavechck);
      if ($previoussavechck != null) {
        //dd('hi');
        $output = array('msg' => 'You already submitted for this date');
        return back()->with('statuss', $output);
      }


      //	 $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();
      //dd($sevenDaysAgo);
      //   $selectedDate = Carbon::parse($request->date)->startOfDay();
      //dd($selectedDate);
      //  if ($selectedDate < $sevenDaysAgo) {
      //dd('if');
      //		    $output = array('msg' => 'You can only fill timesheet for the last 7 days.');
      //   return back()->with('statuss', $output);
      //  }



      $leaves = DB::table('applyleaves')
        ->where('applyleaves.createdby', auth()->user()->teammember_id)
        ->where('status', '!=', 2)
        ->select('applyleaves.from', 'applyleaves.to')
        ->get();

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
      $currentday = date('Y-m-d', strtotime($request->date));
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

      //timesheet block

      $startDate = Carbon::now()->startOfMonth();
      $currentYear = $startDate->year;
      $currentMonth = $startDate->month;
      // dd($currentMonth);
      $startDateFormatted = $startDate->format('d-m-Y');



      $checkedInDates = DB::table('checkins')
        ->where('teammember_id', auth()->user()->teammember_id)
        ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$startDate->format('Y-m-d')])
        ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$startDate->endOfMonth()->format('Y-m-d')])
        ->pluck('date')
        ->toArray();


      $inputDate1 = Carbon::parse($request->input('date'))->format('d-m-Y');

      /* if (!in_array($inputDate1, $checkedInDates)) {
      
        $output = array('msg' => 'You cannot fill timesheet as you have not checked in for the selected date .');
        return redirect('timesheet/create')->with('statuss', $output);
      }
*/

      $inputDate = Carbon::parse($request->input('date'))->day;
      $currentDate = Carbon::now()->day;


      $allowed_ids =  [951, 984, 708, 1008, 1001, 1003];
      $id = auth()->user()->teammember_id; // Example ID to check

      if ($currentDate >= 27 && $currentDate <= 31 && $inputDate <= 25 && !in_array($id, $allowed_ids)) {

        $output = array('msg' => 'You cannot fill out the timesheet for the period from the 27th to the End of this month.');
        return redirect('timesheet/create')->with('statuss', $output);
      }



      //block 30 days akshay

      $user_id = auth()->user()->teammember_id;
      $allowed_ids =  [951, 984, 708, 1008, 1001, 1003];

      if (!in_array($user_id, $allowed_ids)) {

        $selectedDate = Carbon::parse($request->date)->startOfDay();
        $team_id =  auth::user()->teammember_id;

        $timesheetrequest = DB::table('timesheetrequests')
          ->where('createdby', $team_id)
          ->where('validate', '>=', now()) // Check if created_at is greater than the current date

          // ->whereMonth('created_at', now()->month) // Check if it's the current month
          ->latest()
          ->first();
        //dd($timesheetrequest);
        $timesheetData = DB::table('timesheets')

          ->where('created_by', $team_id)
          ->latest()
          ->first();
        //  dd($timesheetData);

        if (isset($timesheetrequest) && $timesheetData != null) {

          if ($timesheetrequest == null || $timesheetrequest->status == 1) {
            //  dd('hii');
            $thirtyDaysAgo = Carbon::now()->subDays(30)->startOfDay();
            // Correct the condition to check if the current date is greater than or equal to 30 days ago
            if ($selectedDate <= $thirtyDaysAgo) {
              $output = array('msg' => 'You can fill out your timesheet for the last 30 days from the current date.');
              return redirect('timesheet/create')->with('statuss', $output);
            }
          }

          if ($timesheetrequest == null || $timesheetrequest->status == 0) {
            // dd('hii');
            $sevenDaysAgo = Carbon::now()->subDays(10)->startOfDay();

            if ($selectedDate < $sevenDaysAgo) {
              $output = ['msg' => 'You cannot submit timesheet if more than 10 days have passed since your last submission.'];
              return redirect('timesheet/create')->with('statuss', $output);
            }
          }
        } else {
          $thirtyDaysAgo = Carbon::now()->subDays(30)->startOfDay();
          // Correct the condition to check if the current date is greater than or equal to 30 days ago
          if ($selectedDate <= $thirtyDaysAgo) {
            $output = array('msg' => 'You can only fill timesheet for the last 30 days when the timesheet request is approved.');
            return redirect('timesheet/create')->with('statuss', $output);
          }
        }
      }
      //end user allowed to fill timesheet
      //end 30 day

      //end timesheet block



      $id = DB::table('timesheets')->insertGetId(
        [
          'created_by' => auth()->user()->teammember_id,
          'month'     =>    date('F', strtotime($request->date)),
          'date'     =>    date('Y-m-d', strtotime($request->date)),
          'created_at'          =>     date('Y-m-d H:i:s'),
        ]
      );
      // dd('else');
      $count = count($request->assignment_id);
      // dd($count);
      for ($i = 0; $i < $count; $i++) {
        //dd($request->workitem[$i]);
        $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

        $a = DB::table('timesheetusers')->insert([
          'date'     =>     $request->date,
          'client_id'     =>     $request->client_id[$i],
          'workitem'     =>     $request->workitem[$i],
          'billable_status'     =>     $request->billable_status[$i],
          'timesheetid'     =>     $id,
          'date'     =>     date('d-m-Y', strtotime($request->date)),
          'hour'     =>     $request->hour[$i],
          'totalhour' =>      $request->totalhour,
          'assignment_id'     =>     $assignment->assignment_id,
          'assignmentgenerate_id'     =>     $assignment->assignmentgenerate_id,
          'partner'     =>     $request->partner[$i],
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);
      }


      //Attendance code


      $data = array(
        'rqstdate' => $request->date ?? '',
        'totalhour'   => $request->totalhour,
        'authid' => auth()->user()->teammember_id ?? '',
      );

      TimesheetAttendanceinsert::dispatch($data)->onQueue('TimesheetAttendanceinserts');

      //end attendance





      $output = array('msg' => 'Create Successfully');
      return redirect('timesheet')->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function timesheetUpload(Request $request)
  {
    $request->validate([
      'file' => 'required'
    ]);

    try {
      $file = $request->file;
      //  dd($file);
      $data = $request->except(['_token']);
      $dataa = Excel::toArray(new Timesheetimport, $file);
      //     dd($dataa);
      foreach ($dataa[0] as $key => $value) {
        //  $informationresource   = Informationresource::where('question',$value['question'])->pluck('question')->first();

        //    if($informationresource == null){
        $db['clientname'] = $request->clientname;
        $db['assignmentname'] = $request->assignmentname;
        $db['workitem'] = $request->workitem;
        $db['billable_status'] = $request->billable_status;
        $db['hour'] = $request->hour;
        //   dd($request->clientname);
        if ($request->clientname != NULL) {
          $client_id   = clients::where('client_name', $value['clientname'])->pluck('id')->first();
          //    dd($client_id);
          if ($assignmentname != NULL) {
            $assignment_id   = assignments::where('assignment_name', $value['assignmentname'])->pluck('id')->first();
          }
        }


        //  'createdby' => auth()->user()->teammember_id,
        //     Timesheet::Create($db);

        //       }

      }
      //dd($dataa);
      $output = array('msg' => 'Excel file upload Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //dd($date);
    //$id=77;
    $client = Client::select('id', 'client_name')->get();
    $time = DB::table('timesheets')->where('id', $id)->first();
    $date = $time->date;
    $assignment = Assignment::select('id', 'assignment_name')->get();
    $timesheet = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name')
      ->get();
    //   dd($timesheet);
    $count = count($timesheet = DB::table('timesheetusers')->where('timesheetusers.date', $date)->get());
    //  dd( $count);
    // $totalhour=$timesheet->totalhour;

    $rcount = 5 - $count;




    return view('backEnd.timesheet.edit', compact('id', 'timesheet', 'client', 'assignment', 'date', 'rcount', 'count'));
  }
  public function view($id)
  {
    //  dd($id);
    $timesheet = timesheet::where('id', $id)->first();
    return view('backEnd.timesheet.view', compact('id', 'timesheet'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      $data = $request->except(['_token']);
      $count = count($request->assignment_id);
      // dd($count);
      $timesheet = DB::table('timesheets')->where('date', $request->date)->delete();

      for ($i = 0; $i < $count; $i++) {
        DB::table('timesheets')->insert([
          'client_id'     =>     $request->client_id[$i],
          'workitem'     =>     $request->workitem[$i],
          'billable_status'     =>     $request->billable_status[$i],
          'hour'     =>     $request->hour[$i],
          'assignment_id'     =>     $request->assignment_id[$i],
          'createdby' => auth()->user()->teammember_id,
          'updatedby' => auth()->user()->teammember_id,
          'date'      => $request->date,
          'totalhour' => $request->totalhour,
          'created_at'          =>     date('y-m-d'),
          'updated_at'              =>    date('y-m-d'),
        ]);
      }

      $output = array('msg' => 'Updated Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Outstationconveyance  $outstationconveyance
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $timesheet = DB::table('timesheets')->where('id', $id)->first();

      if ($timesheet) {
        $hdate = date('Y-m-d', strtotime($timesheet->date));
        // dd($hdate);
        $day = DateTime::createFromFormat('Y-m-d', $hdate)->format('d');
        //dd($day);
        $year = DateTime::createFromFormat('Y-m-d', $hdate)->format('Y');
        $month =  DateTime::createFromFormat('Y-m-d', $hdate)->format('F');
        $currentDate = new DateTime();
        $currentDay = $currentDate->format('d');
        //   dd($currentDay);
        $currentMonth = $currentDate->format('F');

        // Calculate the start date to allow deletion for the current month until the 25th
        // $startDate = date('Y-m-26');
        if ($currentDay >= 26 && $currentDay <= 31 && $day <= 26 && auth()->user()->teammember_id != 336) {
          $output = array('msg' => 'You can only delete timesheet data for the current month until the 26th and not on the 27th.');
          return back()->with('success', $output);
        } else {
          // Delete the timesheet record
          DB::table('timesheets')->where('id', $id)->delete();
          // Delete related records in timesheetusers table
          DB::table('timesheetusers')->where('timesheetid', $id)->delete();

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

          if ($month != $currentMonth && $day > 26) {
            $dateTime = DateTime::createFromFormat('Y-m-d', $hdate);
            $dateTime->modify('+1 month');
            $month = $dateTime->format('F');
          }
          if ($month != $currentMonth && $day < 26) {
            $dateTime = DateTime::createFromFormat('Y-m-d', $hdate);
            $month = $dateTime->format('F');
          }
          if ($month == $currentMonth && $day > 26) {
            $dateTime = DateTime::createFromFormat('Y-m-d', $hdate);
            $dateTime->modify('+1 month');
            $month = $dateTime->format('F');
          }

          // Set the default value to null
          $column = null;

          // Check if the $day exists in the $dates array
          if (array_key_exists($day, $dates)) {
            $column = $dates[$day];
          }

          DB::table('attendances')
            ->where('employee_name', $timesheet->created_by)
            ->where('month', $month)
            ->where('year', $year)
            ->update([$column => null]);

          $output = array('msg' => 'Deleted Successfully');
          return redirect('timesheet')->with('statuss', $output);
        }
      }
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function timesheetrequestStore(Request $request)
  {
    //dd($request);
    try {
      $data = $request->except(['_token']);
      $assignment = DB::table('assignmentbudgetings')->where('assignmentgenerate_id', $request->assignment_id)->first();
      $id = DB::table('timesheetrequests')->insertGetId([
        'client_id'     =>     $request->client_id,
        'assignment_id'     =>     $assignment->assignment_id,
        'partner'     =>     $request->partner,
        'reason'     =>     $request->reason,
        'status'     =>     0,
        'createdby' => auth()->user()->teammember_id,
        'created_at'          =>     date('Y-m-d H:i:s'),
        'updated_at'              =>    date('Y-m-d H:i:s'),
      ]);

      //     $travel = Assetprocurement::where('id', $id)->first();
      $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
      $client_name = Client::where('id', $request->client_id)->pluck('client_name')->first();
      //dd($client_name);
      $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

      $data = array(
        'teammember' => $name ?? '',
        'email' => $teammembermail ?? '',
        'id' => $id ?? '',
        'client_id' => $client_name ?? '',
        'reason'     =>     $request->reason ?? '',
      );
      //dd($data);
      Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        $msg->cc('hr@kgsomani.com');
        $msg->subject('Timesheet Submission Request | ' . $data['teammember']);
      });
      $output = array('msg' => 'Request Successfully');
      return redirect('timesheet')->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function timesheetrequestlist()
  {
    $timesheetrequestlist = DB::table('timesheetrequests')
      ->leftjoin('timesheetusers', 'clients.client_id', 'timesheetrequests.id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
      ->leftjoin('teammembers as team', 'team.id', 'timesheetrequests.partner')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.createdby')
      ->where('timesheetrequests.createdby', auth()->user()->teammember_id)
      ->where('timesheetrequests.partner', auth()->user()->teammember_id)
      ->select('timesheetrequests.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
    // dd($timesheetData);

    return view('backEnd.timesheet.timesheetrequest', compact('timesheetrequestlist'));
  }


  //Report

  public function Reportsection(Request $request)
  {

    $employeename = Teammember::where('role_id', '!=', 11)->where('status', 1)->with('title', 'role')->get();
    $client = Client::select('id', 'client_name')->get();
    $assignment = Assignment::select('id', 'assignment_name')->get();
    $partner = Teammember::where('role_id', '=', 13)->where('status', 1)->with('title', 'role')->get();

    $result = DB::table('timesheets')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    //dd($assignment);
    if ($request->ajax()) {
      //   dd($request);
      if (isset($request->cid)) {
        $clientdata = explode(",", $request->cid);
        echo "<option value=''>Select Assignment</option>";
        foreach (
          DB::table('timesheetusers')->whereIn('client_id', $clientdata)
            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
            ->orderBy('assignment_name')->distinct()->get(['assignments.id', 'assignments.assignment_name']) as $sub
        ) {
          echo "<option value='" . $sub->id . "'>" . $sub->assignment_name . "</option>";
        }
      }

      if (isset($request->clientid)) {
        $clientdata = explode(",", $request->clientid);
        echo "<option value=''>Select Employee</option>";
        foreach (
          DB::table('timesheetusers')->whereIn('client_id', $clientdata)
            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
            ->orderBy('team_member')->distinct()->get(['teammembers.id', 'teammembers.team_member']) as $sub
        ) {
          echo "<option value='" . $sub->id . "'>" . $sub->team_member . "</option>";
        }
      }

      if (isset($request->ass_id)) {
        //dd($request->ass_id);;
        $ass_data = explode(",", $request->ass_id);
        //dd($ass_data);


        echo "<option value=''>Select Partner</option>";
        foreach (
          DB::table('teammembers')
            ->leftjoin('timesheetusers', 'timesheetusers.partner', 'teammembers.id')
            ->whereIn('timesheetusers.assignment_id', $ass_data)
            ->distinct()->get(['teammembers.id', 'teammembers.team_member']) as $subs
        ) {
          echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
        }
        //   die;
      }
    } else {
      return view('backEnd.timesheet.reportsection', compact('employeename', 'client', 'assignment', 'partner', 'years'));
    }
  }

  public function filtersection(Request $request)
  {
    //dd($request);
    if ($request->ajax()) {
      $clients = collect(is_array($request->clientid) ? $request->clientid : explode(',', $request->clientid))->filter();
      $employeeIds = collect(is_array($request->employeeid) ? $request->employeeid : explode(',', $request->employeeid))->filter();
      $assignmentIds = collect(is_array($request->assignmentid) ? $request->assignmentid : explode(',', $request->assignmentid))->filter();
      $partners = collect(is_array($request->partnerid) ? $request->partnerid : explode(',', $request->partnerid))->filter();
      //$dateRange = collect(is_array($request->daterange) ? $request->daterange : explode(' - ', $request->daterange))->filter();
      // $dateRange = collect(explode(' - ', $request->daterange))->filter();
      //[$startDate, $endDate] = $dateRange->map(fn ($date) => Carbon::parse($date));

      $date = explode(" - ", $request->daterange);
      // dd($date);
      $start = Carbon::parse($date[0]);
      $end = Carbon::parse($date[1]);

      $now = Carbon::now();
      $noww = Carbon::parse($now);
      //dd($start);
      if ($start == $end) {
        $daterange = null;
      } else {
        $daterange = 1;
      }
      /*
$financial_year = $request->yearly;


		
		
$quarter = $request->quarter; // Update with the desired quarter (q1, q2, q3, or q4)

$Qstart = '';
$Qend = '';
//dd($quarter);
if ($quarter == 'Q1') {
	
    $Qstart = $financial_year .'-05-01';
    $Qend = $financial_year .'-06-30';
} elseif ($quarter == 'Q2') {
	//dd('hi');
    $Qstart = $financial_year .'-07-01';
	//dd($Qstart);
    $Qend = $financial_year . '-09-30';
} elseif ($quarter == 'Q3') {
    $Qstart = $financial_year . '-10-01';
    $Qend = ($financial_year + 1) . '-01-01';
} elseif ($quarter == 'Q4') {
    $Qstart = ($financial_year + 1) . '-01-01';
    $Qend = $financial_year . '-03-31';
}
*/



      //	dd($Qstart);

      $query1 = $request->workitem;
      $query1 = str_replace(' ', '%', $query1);

      if ($request->month == 0) {
        $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn($query) => $query->whereIn('partner', $partners))
          //  ->when($financial_year !='2025', fn ($query) => $query->whereYear('date', $financial_year))

          ->when($daterange == 1, function ($query) use ($start, $end) {
            $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
              ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
          })
          //		   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
          //  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
          //->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
          //   ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
          //  ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
          //	})

          ->when($request->billableid, fn($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month != 0, fn($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn($query) => $query->where('workitem', 'like', "%$query1%"))
          ->where('teammembers.status', '!=', 0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as 				partnername')
          ->get();
      } else {
        $timesheetData = Timesheetusers::join('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftJoin('teammembers as pt', 'pt.id', 'timesheetusers.partner')
          ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->with(['client', 'assignment', 'createdBy', 'partner'])
          ->when($clients->isNotEmpty(), fn($query) => $query->whereIn('client_id', $clients))
          ->when($employeeIds->isNotEmpty(), fn($query) => $query->whereIn('timesheetusers.createdby', $employeeIds))
          ->when($assignmentIds->isNotEmpty(), fn($query) => $query->whereIn('assignment_id', $assignmentIds))
          ->when($partners->isNotEmpty(), fn($query) => $query->whereIn('partner', $partners))

          //		->when($request->yearly !=2025, fn ($query) => $query->whereYear('timesheetusers.date', $request->yearly))

          ->when($daterange == 1, function ($query) use ($start, $end) {
            $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$end])
              ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$start])
              ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$end]);
          })
          //			   ->when($financial_year!=2025, function ($query) use ($Qstart, $Qend) {
          //	  $query->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') >= ?", [$Qstart])
          //     ->whereRaw("STR_TO_DATE(date, '%d-%m-%Y') <= ?", [$Qend])
          //    ->orWhereRaw("STR_TO_DATE(date, '%Y-%m-%d') >= ?", [$Qstart])
          //    ->whereRaw("STR_TO_DATE(date, '%Y-%m-%d') <= ?", [$Qend]);
          //	})

          // ->when($startDate && $endDate, fn ($query) => $query->whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate))
          ->when($request->billableid, fn($query) => $query->where('billable_status', $request->billableid))
          ->when($request->month, fn($query) => $query->whereMonth('timesheetusers.date', $request->month))
          ->when($query1, fn($query) => $query->where('workitem', 'like', "%$query1%"))
          ->where('teammembers.status', '!=', 0)
          ->select('timesheetusers.*', 'clients.client_name', 'teammembers.team_member', 'assignments.assignment_name', 'pt.team_member as partnername')
          ->get();
      }

      return response()->json($timesheetData);
    }
  }
  public function TimesheetReportsection(Request $request)
  {

    $employeename = DB::table('teammembers')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->where('role_id', '!=', 11)->where('role_id', '!=', 13)->where('role_id', '!=', 12)->where('status', 1)
      ->select('teammembers.*', 'roles.rolename', 'titles.title')
      ->get();

    $result = DB::table('timesheets')->select(DB::raw('YEAR(created_at) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();

    $years = $result->pluck('year');
    $client = DB::table('clients')
      ->where('client_name', '!=', null)->where('client_name', '!=', '-')->latest()->get();
    //dd($client);
    return view('backEnd.timesheet.timesheetreport', compact('employeename', 'years', 'client'));
  }

  public function timesheetfiltersection(Request $request)
  {
    $employeeId = (int) $request->employeeid;
    $month = (int) $request->month;
    $fromDate = $request->fromdate;
    $toDate = $request->todate;
    $hasAnyFilter = !empty($request->employeeid)
      || !empty($request->client_id)
      || !empty($request->assignment_id)
      || !empty($request->month)
      || !empty($request->yearly)
      || !empty($request->hour)
      || !empty($request->fromdate)
      || !empty($request->todate)
      || !empty($request->search)
      || !empty($request->sortColumn)
      || !empty($request->page);

    $perPage = $request->perPage ?? 25;
    if (!$hasAnyFilter) {
      $records = new LengthAwarePaginator([], 0, $perPage, 1, [
        'path' => url('timesheetfiltersection'),
        'query' => $request->query(),
      ]);
      $datatable = view('backEnd.timesheet.datatable', compact('records'))->render();

      return response()->json([
        'status' => 200,
        'msg' => 'Data loaded',
        'data' => $datatable,
        'paginationInfo' => getPaginationInfo($records)
      ]);
    }

    $query = DB::table('timesheets')
      ->leftJoin('timesheetusers', 'timesheetusers.timesheetid', '=', 'timesheets.id')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheets.created_by')
      ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
      ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
      ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teammembers as teampartner', 'teampartner.id', '=', 'assignmentmappings.leadpartner')
      ->when($employeeId, function ($query) use ($employeeId) {
        return $query->where('timesheets.created_by', $employeeId);
      })
      ->when($request->client_id != 0, function ($query) use ($request) {
        return $query->where('timesheetusers.client_id', $request->client_id);
      })
      ->when($request->assignment_id != 0, function ($query) use ($request) {
        return $query->where('timesheetusers.assignmentgenerate_id', $request->assignment_id);
      })
      ->when($month, function ($query) use ($month) {
        return $query->whereMonth('timesheets.date', '=', $month);
      })
      ->when($request->yearly != 0, function ($query) use ($request) {
        return $query->whereYear('timesheets.date', $request->yearly);
      })
      ->when($request->hour != null, function ($query) use ($request) {
        $startTime = $request->hour;
        return $query->whereRaw("TIME(timesheetusers.hour) <= ?", [$startTime]);
      })
      ->when($fromDate && $toDate, function ($query) use ($fromDate, $toDate) {
        $nextDay = date('Y-m-d', strtotime($toDate . ' +1 day'));
        return $query->whereBetween('timesheets.date', [$fromDate, $nextDay]);
      })
      ->select(
        'roles.rolename',
        'timesheetusers.date',
        'timesheets.month',
        'teammembers.team_member',
        'clients.client_name',
        'timesheetusers.hour',
        'timesheetusers.assignmentgenerate_id',
        'teammembers.emailid',
        'assignmentbudgetings.assignmentname',
        'assignments.assignment_name',
        'teampartner.team_member as teampartner',
        'timesheetusers.workitem',
        'timesheetusers.billable_status',
        'timesheetusers.id'
      );

    if (!empty($request->search)) {
      $search = $request->search;
      $query->where(function ($q) use ($search) {
        $q->where('teammembers.team_member', 'like', "%{$search}%")
          ->orWhere('teammembers.emailid', 'like', "%{$search}%")
          ->orWhere('roles.rolename', 'like', "%{$search}%")
          ->orWhere('timesheetusers.date', 'like', "%{$search}%")
          ->orWhere('timesheets.month', 'like', "%{$search}%")
          ->orWhere('clients.client_name', 'like', "%{$search}%")
          ->orWhere('assignments.assignment_name', 'like', "%{$search}%")
          ->orWhere('assignmentbudgetings.assignmentname', 'like', "%{$search}%")
          ->orWhere('timesheetusers.assignmentgenerate_id', 'like', "%{$search}%")
          ->orWhere('timesheetusers.workitem', 'like', "%{$search}%")
          ->orWhere('teampartner.team_member', 'like', "%{$search}%")
          ->orWhere('timesheetusers.hour', 'like', "%{$search}%")
          ->orWhere('timesheetusers.billable_status', 'like', "%{$search}%");
      });
    }

    $allowedSorts = ['team_member', 'emailid', 'rolename', 'date', 'month', 'client_name', 'assignment_name', 'assignmentgenerate_id', 'workitem', 'teampartner', 'hour', 'billable_status'];
    if (!empty($request->sortColumn) && in_array($request->sortColumn, $allowedSorts, true)) {
      $query->orderBy($request->sortColumn, $request->sortDirection ?? 'desc');
    } else {
      $query->orderBy('timesheetusers.id', 'DESC');
    }

    $records = $query->paginate($perPage);
    $datatable = view('backEnd.timesheet.datatable', compact('records'))->render();

    return response()->json([
      'status' => 200,
      'msg' => 'Data loaded',
      'data' => $datatable,
      'paginationInfo' => getPaginationInfo($records)
    ]);
  }

  /*	public function updateremaingTimesheet(Request $request)
	{
		
		$dates = [
            '26-05-2024' => 'twentysix',
            '27-05-2024' => 'twentyseven',
            '28-05-2024' => 'twentyeight',
            '29-05-2024' => 'twentynine',
            '30-05-2024' => 'thirty',
            '31-05-2024' => 'thirtyone',
            '01-06-2024' => 'one',
            '02-06-2024' => 'two',
            '03-06-2024' => 'three',
            '04-06-2024' => 'four',
            '05-06-2024' => 'five',
            '06-06-2024' => 'six',
            '07-06-2024' => 'seven',
            '08-06-2024' => 'eight',
            '09-06-2024' => 'nine',
            '10-06-2024' => 'ten',
            '11-06-2024' => 'eleven',
            '12-06-2024' => 'twelve',
            '13-06-2024' => 'thirteen',
            '14-06-2024' => 'fourteen',
            '15-06-2024' => 'fifteen',
            '16-06-2024' => 'sixteen',
            '17-06-2024' => 'seventeen',
            '18-06-2024' => 'eighteen',
            '19-06-2024' => 'ninghteen',
            '20-06-2024' => 'twenty',
            '21-06-2024' => 'twentyone',
            '22-06-2024' => 'twentytwo',
            '23-06-2024' => 'twentythree',
            '24-06-2024' => 'twentyfour',
            '25-06-2024' => 'twentyfive',
        ];
        
        foreach ($dates as $date => $column) {
                 $lastdate = DB::table('timesheetusers')
            ->where('date', $date)
            ->select('date', 'createdby', DB::raw('CAST(SUBSTRING_INDEX(totalhour, ":", 1) AS UNSIGNED) AS totalhour'))
            ->get();
           
            foreach ($lastdate as $lastdatevalue) {
                DB::table('attendances')
                    ->where('month', 'June')
                    ->where('year', '2024')
                    ->where('employee_name', $lastdatevalue->createdby)
                    ->update([
                        $column => $lastdatevalue->totalhour,
                    ]);
            }
        }
	}
	*/
}

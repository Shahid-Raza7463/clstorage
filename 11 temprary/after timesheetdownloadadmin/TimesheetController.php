<?php

namespace App\Http\Controllers;

use App\Models\Teammember;
use App\Models\Timesheet;
use App\Models\Assignmentmapping;
use App\imports\Timesheetimport;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Assignment;
use App\Models\Job;
use App\Models\Timesheetusers;
use Carbon\CarbonPeriod;
use Carbon\Carbon;
use DB;
use Excel;
use DateTime;
use App\Exports\TimesheetLastWeekExport;

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
  public function holidaysselect(Request $request)
  {
    if ($request->ajax()) {

      $selectedDate = date('Y-m-d', strtotime($request->datepickers));
      // Get the day of the week (0 for Sunday, 6 for Saturday)
      $dayOfWeek = date('w', strtotime($selectedDate));
      if ($dayOfWeek == 6) {
        // Get the day of the month
        $dayOfMonth = date('j', strtotime($selectedDate));
        // Calculate which Saturday of the month it is
        $saturdayNumber = ceil($dayOfMonth / 7);
        if ($saturdayNumber == 1.0) {
          $saturday = '1st Saturday';
        } elseif ($saturdayNumber == 2.0) {
          $saturday = '2nd Saturday';
        } elseif ($saturdayNumber == 3.0) {
          $saturday = '3rd Saturday';
        } elseif ($saturdayNumber == 4.0) {
          $saturday = '4th Saturday';
        } elseif ($saturdayNumber == 5.0) {
          $saturday = '5th Saturday';
        }
      }

      $holidayname = DB::table('holidays')->where('startdate', $selectedDate)->select('holidayname')->first();
      $selectassignment = DB::table('assignmentbudgetings')->where('client_id', $request->cid)
        ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->orderBy('assignment_name')->first();
      $selectpartner = DB::table('assignmentmappings')
        ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
        ->where('assignmentmappings.assignmentgenerate_id', $selectassignment->assignmentgenerate_id)
        ->select('teammembers.team_member', 'teammembers.id')
        ->first();

      return response()->json([
        'holidayName' => $holidayname->holidayname ?? 'null',
        'saturday' => $saturday ?? 'null',
        'assignmentid' => $selectassignment->id,
        'assignmentgenerate_id' => $selectassignment->assignmentgenerate_id,
        'assignmentname' => $selectassignment->assignmentname,
        'assignment_name' => $selectassignment->assignment_name,
        'team_member' => $selectpartner->team_member,
        'team_memberid' => $selectpartner->id,
      ]);
    }
  }

  public function mytimesheetlist(Request $request, $teamid)
  {
    // dd($teamid);
    if (auth()->user()->role_id == 13) {

      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        // ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcode', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreateddate')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();

      // dd($timesheetData);
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        // ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcode', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreateddate')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();
    }
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }

  public function admintimesheetlist(Request $request)
  {


    $teammembers = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->where('teammembers.status', 1)
      ->whereIn('teammembers.role_id', [14, 15, 13, 11])
      ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    $clientsname = DB::table('clients')
      ->whereIn('status', [0, 1])
      ->select('id', 'client_name', 'client_code')
      ->orderBy('client_name', 'ASC')
      ->get();

    $assignmentsname = DB::table('timesheetusers')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereNotNull('assignmentbudgetings.assignmentname')
      ->select('timesheetusers.*', 'assignmentbudgetings.assignmentname')
      ->orderBy('assignmentname', 'Asc')
      ->distinct('assignmentname')
      ->get();

    if (auth()->user()->role_id == 11) {

      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        // ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();
    }
    // for patner team 
    else {
      // die;
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.partner', auth()->user()->teammember_id)
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername')
        ->orderBy('date', 'DESC')
        ->take(7)
        ->get();

      // dd($teammembers);
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.timesheetdownloadadmin', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }



  // timesheet filtering function 

  public function searchingtimesheet(Request $request)
  {
    // dd($request);
    // Get all input from form
    $startDate = $request->input('startdate', null);
    $endDate = $request->input('enddate', null);
    $teamId = $request->input('teamid', null);
    $teammemberId = $request->input('teammemberId', null);
    // $year = $request->input('year', null);

    $teammembers = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->where('teammembers.status', 1)
      ->whereIn('teammembers.role_id', [14, 15, 13, 11])
      ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
      ->orderBy('team_member', 'ASC')
      ->get();

    // For patner
    if (auth()->user()->role_id == 13) {
      $query = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        // ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcode', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreateddate')
        ->orderBy('date', 'DESC');



      if ($startDate && $endDate && $teamId) {
        $query->where(function ($q) use ($startDate, $endDate, $teamId) {
          $q->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        });
      }

      $timesheetData = $query->get();
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
    // For staff and manager
    else {

      $query = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        // ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcode', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreateddate')
        ->orderBy('date', 'DESC');

      if ($startDate && $endDate && $teamId) {
        $query->where(function ($q) use ($startDate, $endDate, $teamId) {
          $q->where('timesheetusers.createdby', $teamId)
            ->where('timesheetusers.date', '>=', $startDate)
            ->where('timesheetusers.date', '<=', $endDate);
        });
      }
      $timesheetData = $query->get();
      // dd($timesheetData);

      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }



  public function adminsearchtimesheet(Request $request)
  {

    if ($request->ajax()) {
      echo "<option value='null'>Select Assignment</option>";
      foreach (
        DB::table('assignmentbudgetings')
          ->where('assignmentbudgetings.client_id', $request->cid)
          ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
          ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
          ->orderBy('assignment_name')->get() as $sub
      ) {
        echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . ' )' . '( ' . $sub->assignmentgenerate_id . ' )' . "</option>";
      }
    } else {
      // Get all input from form
      $startDate = $request->input('startdate', null);
      $endDate = $request->input('enddate', null);
      $teamId = $request->input('teamid', null);
      $teammemberId = $request->input('teammemberId', null);
      // $year = $request->input('year', null);
      $clientId = $request->input('clientId', null);
      $assignmentIddummy = $request->input('assignmentId', null);

      if ($assignmentIddummy == 'null') {
        $assignmentId = null;
      } else {
        $assignmentId =  $assignmentIddummy;
      }
      // dd($assignmentId);
      $teammembers = DB::table('teammembers')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->where('teammembers.status', 1)
        ->whereIn('teammembers.role_id', [14, 15, 13, 11])
        ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
        ->orderBy('team_member', 'ASC')
        ->get();

      $clientsname = DB::table('clients')
        ->whereIn('status', [0, 1])
        ->select('id', 'client_name', 'client_code')
        ->orderBy('client_name', 'ASC')
        ->get();

      $assignmentsname = DB::table('timesheetusers')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('assignmentbudgetings.assignmentname')
        ->select('timesheetusers.*', 'assignmentbudgetings.assignmentname')
        ->orderBy('assignmentname', 'Asc')
        ->distinct('assignmentname')
        ->get();

      if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {

        $timesheetData = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          // When startDate and endDate exist then run 'when' clause
          ->when($startDate && $endDate && $teammemberId, function ($query) use ($startDate, $endDate, $teammemberId) {
            // dd('teammemberId');
            return $query->where('timesheetusers.createdby', $teammemberId)
              ->where('timesheetusers.date', '>=', $startDate)
              ->where('timesheetusers.date', '<=', $endDate);
          })
          ->when($startDate && $endDate && $clientId, function ($query) use ($startDate, $endDate, $clientId) {
            // dd($clientId);
            return $query->where('timesheetusers.client_id', $clientId)
              ->where('timesheetusers.date', '>=', $startDate)
              ->where('timesheetusers.date', '<=', $endDate);
          })
          ->when($startDate && $endDate && $assignmentId, function ($query) use ($startDate, $endDate, $assignmentId) {
            // dd('assignmentId');
            return $query->where('timesheetusers.assignmentgenerate_id', $assignmentId)
              ->where('timesheetusers.date', '>=', $startDate)
              ->where('timesheetusers.date', '<=', $endDate);
          })
          ->when($startDate && $endDate && $teammemberId == null && $clientId == null && $assignmentId == null, function ($query) use ($startDate, $endDate) {
            // dd('year');
            return $query->where('timesheetusers.date', '>=', $startDate)
              ->where('timesheetusers.date', '<=', $endDate);
          })
          ->whereIn('timesheetusers.status', [1, 2, 3])
          ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
          ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
          ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
          ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
          ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcode', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreateddate')
          ->orderBy('date', 'DESC')
          ->get();

        $request->flash();
        return view('backEnd.timesheet.timesheetdownloadadmin', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname', 'assignmentId'));
      }
    }
  }



  // timesheet download on admin and patner team after search

  public function timesheetupdatesubmit(Request $request)
  {
    // dd($request);
    if ($request->ajax()) {
      if (isset($request->id)) {
        //   dd($request->id);
        $conversion = DB::table('timesheetusers')
          ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
          ->where('timesheetusers.id', $request->id)
          ->select('teammembers.team_member', 'timesheetusers.*')->first();
        //  dd($conversion);
        return response()->json($conversion);
      }
    }
  }

  public function full_list()
  {

    $teammember = DB::table('teammembers')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->select('teammembers.id', 'teammembers.team_member', 'teammembers.emailid', 'roles.rolename', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
      ->where('teammembers.status', '1')->distinct()->get();

    $month = DB::table('timesheets')
      ->select('timesheets.month')->distinct()->get();
    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
    $years = $result->pluck('year');

    //dd($month);
    $timesheetData = DB::table('timesheets')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      ->select('timesheets.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'DESC')->paginate(30);
    // dd($timesheetData);
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }



  public function allteamsubmitted()
  {
    // Fetch all necessary data in a single query
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
      })
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->select(
        'timesheetreport.*',
        'teamrolehistory.newstaff_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'partners.team_member as partnername',
        'teammembers.emailid'
      )
      ->latest()
      ->get();

    $permissiontimesheet = DB::table('timesheetreport')->first();

    // Map and group data
    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'dayscount' => $group->sum('dayscount'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        // Use newstaff_code if available, otherwise staffcode
        'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }


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

      $partner = Teammember::where('role_id', '=', 11)->whereNotIn('id', [447])->where('status', '=', 1)->where('team_member', '!=', 'Partner')->with('title')->get();


      $currentDate = now();


      $month = $currentDate->format('F');
      $year = $currentDate->format('Y');

      //	  $time =  DB::table('timesheets')->get();
      // foreach ($time as $value) {
      //dd(date('F', strtotime($value->date)));
      //      DB::table('timesheets')->where('id',$value->id)->update([	
      //          'month'         =>     date('F', strtotime($value->date)),
      //           ]);
      // }
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
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname', 'assignmentbudgetings.created_at as assignmentcreated')->orderBy('date', 'ASC')
        ->paginate(14);
      // dd($timesheetData);
      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();
      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
      }
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

      $getauths =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '1')
        ->orderby('id', 'desc')->first();
      if ($getauths != null) {
        $currentDate = now();
        $currentDateformate = $currentDate->format('Y-m-d');
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', '<=', $currentDateformate)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        // dd($getauth);
      } else {
        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderby('id', 'desc')->first();
        //dd($getauth);
      }
      $getauthh =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->orderby('id', 'desc')->first();

      $client = Client::select('id', 'client_name')->get();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->where('timesheetusers.status', 0)
        //   ->where('timesheets.month', $month)
        //  ->whereRaw('YEAR(timesheetusers.date) = ?', [$year])
        ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname', 'assignmentbudgetings.created_at as assignmentcreated')->orderBy('date', 'ASC')
        ->paginate(14);

      $partner = Teammember::whereNotIn('id', [887, 663, 841, 836, 843, 447])->where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $timesheetrequest = DB::table('timesheetrequests')->where('createdby', auth()->user()->teammember_id)->orderBy('id', 'DESC')->first();

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

  public function timesheet_teamlist()
  {

    if (auth()->user()->role_id == 13) {
      // get all partner
      // dd('hi');
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.staffcode', 'partners.team_member as partnername')
        ->latest()->get();

      // For permission
      $permissiontimesheet = DB::table('timesheetreport')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->first();
      // dd($get_datess);
    } else {

      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();
      $get_datess = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
        })
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        // ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.staffcode', 'partners.team_member as partnername')
        ->select('timesheetreport.*', 'teamrolehistory.newstaff_code', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
        ->latest()->get();

      // For permission working 
      $permissiontimesheet = DB::table('timesheetreport')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->first();
    }

    $groupedData = $get_datess->groupBy(function ($item) {
      return $item->team_member . '|' . $item->week;
    })->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
        'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
      ];
    });

    $get_date = collect($groupedData->values());


    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner', 'permissiontimesheet'));
  }

  public function partnersubmitted()
  {
    // Fetch timesheet data with necessary joins
    $get_datess = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
          ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
      })
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teamrolehistory.newstaff_code', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
      ->latest()
      ->get();

    // Fetch the first permission timesheet record for the authenticated user
    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();

    // Group data by week and map the necessary attributes
    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object)[
        'id' => $firstItem->id,
        'teamid' => $firstItem->teamid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'startdate' => $firstItem->startdate,
        'enddate' => $firstItem->enddate,
        'partnername' => $firstItem->partnername,
        'created_at' => $firstItem->created_at,
        'team_member' => $firstItem->team_member,
        'partnerid' => $firstItem->partnerid,
        'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
      ];
    });

    // Convert the grouped data to a collection
    $get_date = collect($groupedData->values());

    // Return the view with the grouped data and permission timesheet
    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }



  public function timesheet_submit(Request $request)
  {
    //dd($request);
    try {
      DB::table('timesheetusers')->where('id', $request->imsheetid)->update([
        'client_id' => $request->client_id,
        'assignment_id' => $request->assignment_id,
        'workitem' => $request->workitem,
        'totalhour' => $request->totalhour,
        'status'         =>     1,
        'updatedby'  => auth()->user()->teammember_id,
        'updated_at'              =>    date('y-m-d'),
      ]);

      $output = array('msg' => 'Submit Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }
  public function transformDate($value, $format = 'Y-m-d')
  {
    try {
      return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
    } catch (\ErrorException $e) {
      return \Carbon\Carbon::createFromFormat($format, $value);
    }
  }


  public function timesheetnotfilledlastweek(Request $request)
  {

    $teammember = DB::table('teammembers')
      ->leftJoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
      ->where('teammembers.status', 1)
      ->where('timesheetusers.date', '<=', now()->subWeeks(1)->endOfWeek())
      ->select('teammembers.emailid', 'teammembers.team_member', 'teammembers.id')
      ->distinct('timesheetusers.createdby')
      ->get();

    foreach ($teammember as $user) {
      $lastSubmissionDate = DB::table('timesheetusers')
        ->where('createdby', $user->id)
        ->where('date', '<=', now()->subWeeks(1)->endOfWeek())
        ->where('status', '!=', 0)
        ->where(function ($query) {
          $query->whereRaw('DAYOFWEEK(date) = 1') // Sunday
            ->orWhereRaw('DAYOFWEEK(date) = 7'); // Saturday
        })
        ->max('date');

      $lastSubmissionDate = $lastSubmissionDate ? Carbon::parse($lastSubmissionDate)->format('d-m-Y') : '';
      $user->last_submission_date = $lastSubmissionDate;
    }

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


    Mail::send('emails.timesheetnotfilledlastweekreminder', $emailData, function ($msg) use ($emailData, $excelFileName) {
      $msg->to('itsupport_delhi@vsa.co.in');
      // $msg->cc('Admin_delhi@vsa.co.in');
      // Attach the Excel file to the email
      $msg->attach(storage_path('app/' . $excelFileName), [
        'as' => $excelFileName,
        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
      ]);
      $msg->subject($emailData['subject']);
    });

    $output = array('msg' => 'I have sent excel on mail');
    return back()->with('success', $output);
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
    if (auth()->user()->role_id == 11) {
      //			  $time =  DB::table('timesheets')->get();
      //foreach ($time as $value) {
      //dd(date('F', strtotime($value->date)));
      //   DB::table('timesheets')->where('id',$value->id)->where('month',null)->update([	
      //     'month'         =>     date('F', strtotime($value->date)),
      //       ]);
      //}
      //			   $time =  DB::table('timesheets')->where('month','November')
      //     ->orwhere('month','October')->get();
      //dd($time);
      //foreach ($time as $value) {
      //dd(date('Y-m-d', strtotime($value->date)));
      //DB::table('timesheets')->where('id',$value->id)->update([	
      //  'date'         =>     date('Y-m-d', strtotime($value->date)),
      //  ]);
      //}
      // $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
      //   ->where('teammembers.status', '1')->distinct()->get();
      // //  dd($teammember);
      // $month = DB::table('timesheets')
      //   ->select('timesheets.month')->distinct()->get();
      // $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      //   ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      // $years = $result->pluck('year');

      // //dd($month);
      // $timesheetData = DB::table('timesheets')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      // // dd($timesheetData);
      // return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
      return view('backEnd.timesheet.adminstatustime');
    } elseif (auth()->user()->role_id == 18) {

      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')
        //   ->where('teammembers.status','1')
        ->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      $years = $result->pluck('year');

      //dd($month );

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(80);
      // dd($timesheetData);
      return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
    } elseif (auth()->user()->role_id == 13) {
      //die;
      // dd(auth()->user()->teammember_id);
      // 			  $time =  DB::table('timesheets')->get();
      // foreach ($time as $value) {
      //     //dd(date('F', strtotime($value->date)));
      //     DB::table('timesheets')->where('id',$value->id)->update([	
      //         'month'         =>     date('F', strtotime($value->date)),
      //          ]);
      // }
      // $teammember = DB::table('timesheets')
      //   ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      //   ->where('timesheetusers.partner', auth()->user()->teammember_id)
      //   ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
      // //  dd($teammember);
      // $month = DB::table('timesheets')
      //   ->select('timesheets.month')->distinct()->get();

      // $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      //   ->distinct()->orderBy('year', 'DESC')->limit(5)->get();
      // $years = $result->pluck('year');


      // $timesheetData = DB::table('timesheets')
      //   ->leftjoin('timesheetusers', 'timesheetusers.timesheetid', 'timesheets.id')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
      //   ->where('timesheetusers.partner', auth()->user()->teammember_id)
      //   ->select('timesheets.*', 'teammembers.team_member')->orderBy('id', 'DESC')->paginate(200);
      // // dd($timesheetData);
      // return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
      return view('backEnd.timesheet.statustime');
    } else {
      return view('backEnd.timesheet.staffworksheet');
    }
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
        ->orderby('id', 'desc')->first();

      //   dd($getauth);
      $client = Client::select('id', 'client_name')->get();
      $timesheetData =  $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', auth()->user()->teammember_id)
        ->where('timesheets.month', $month)
        ->whereRaw('YEAR(timesheets.date) = ?', [$year])
        ->select('timesheets.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'DESC')->paginate(100);
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

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
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
        ->select('timesheets.*', 'teammembers.team_member', 'teammembers.staffcode')->get();
    }

    // elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
    //   $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //     ->select('teammembers.id', 'teammembers.team_member', 'roles.rolename')->distinct()->get();
    //   //  dd($teammember);
    //   $month = DB::table('timesheets')
    //     ->select('timesheets.month')->distinct()->get();

    //   $timesheetData = DB::table('timesheets')
    //     ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
    //     ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
    //     ->whereYear('timesheets.date', '=', $request->year)
    //     ->select('timesheets.*', 'teammembers.team_member')->get();
    // } 
    elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
      $teammember = DB::table('teammembers')->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->select('teammembers.id', 'teammembers.team_member', 'teammembers.staffcode', 'roles.rolename')->distinct()->get();
      //  dd($teammember);
      $month = DB::table('timesheets')
        ->select('timesheets.month')->distinct()->get();

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->select('timesheets.*', 'teammembers.team_member', 'teammembers.staffcode')->get();
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
        ->select('timesheets.*', 'teammembers.team_member', 'teammembers.staffcode')->get();
    }
    return view('backEnd.timesheet.hrindex', compact('timesheetData', 'teammember', 'month', 'years'));
  }

  // before optimize 
  // public function assignmentHourShow()
  // {
  //   $teammemberDatass = DB::table('assignmentteammappings')
  //     ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //     // ->where('assignmentbudgetings.status', 1)
  //     ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
  //     ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour')
  //     // ->take(10)
  //     ->get();

  //   // dd($teammemberDatas);

  //   $patnerdata = DB::table('assignmentmappings')
  //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //     ->leftjoin('teammembers', function ($join) {
  //       $join->on('teammembers.id', 'assignmentmappings.otherpartner')
  //         ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
  //     })
  //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //     // ->where('assignmentbudgetings.status', 1)
  //     ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
  //     ->select(
  //       'assignmentmappings.id',
  //       'teammembers.id as teamid',
  //       'teammembers.team_member',
  //       'teammembers.staffcode',
  //       'teammembers.role_id',
  //       'titles.title',
  //       'assignmentmappings.assignmentgenerate_id',
  //       'assignmentbudgetings.assignmentname',
  //       'assignmentmappings.otherpartner',
  //       'assignmentmappings.leadpartner',
  //       'assignmentmappings.leadpartnerhour',
  //       'assignmentmappings.otherpartnerhour',
  //     )
  //     // ->take(10)
  //     ->get();
  //   $teammemberDatas = $teammemberDatass->merge($patnerdata);
  //   // dd($teammemberDatas);
  //   return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   // return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas', 'patnerdata'));
  // }

  // after optimize 
  public function assignmentHourShow()
  {
    // Fetch all necessary data with a single query per table
    $teammemberDatass = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
      ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour')
      ->get();

    $patnerdata = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', function ($join) {
        $join->on('teammembers.id', 'assignmentmappings.otherpartner')
          ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
      })
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
      ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.role_id', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentmappings.otherpartner', 'assignmentmappings.leadpartner', 'assignmentmappings.leadpartnerhour', 'assignmentmappings.otherpartnerhour')
      ->get();

    $teammemberDatas = $teammemberDatass->merge($patnerdata);

    // Collect ids to fetch role history and assignment budgetings in bulk
    $teamIds = $teammemberDatas->pluck('teamid')->unique();
    $assignmentIds = $teammemberDatas->pluck('assignmentgenerate_id')->unique();

    // Fetch role history and assignment budgetings in bulk
    $roleHistories = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $teamIds)
      ->get()
      ->keyBy('teammember_id');

    $assignmentBudgetings = DB::table('assignmentbudgetings')
      ->whereIn('assignmentgenerate_id', $assignmentIds)
      ->get()
      ->keyBy('assignmentgenerate_id');

    // Pass data to the view
    return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas', 'roleHistories', 'assignmentBudgetings'));
  }


  // public function assignmentHourShow()
  // {
  //   // First query with teamrolehistory join
  //   $teammemberDatass = DB::table('assignmentteammappings')
  //     ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //     ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //     ->leftJoin('teamrolehistory', function ($join) {
  //       $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
  //         ->on('teamrolehistory.created_at', '<', 'assignmentbudgetings.created_at');
  //     })
  //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //     ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
  //     ->select(
  //       'assignmentmappings.id',
  //       'teamrolehistory.newstaff_code',
  //       'teammembers.id as teamid',
  //       'teammembers.team_member',
  //       'teammembers.role_id',
  //       'teammembers.staffcode',
  //       'titles.title',
  //       'assignmentmappings.assignmentgenerate_id',
  //       'assignmentbudgetings.assignmentname',
  //       'assignmentbudgetings.created_at',
  //       'assignmentteammappings.teamhour'
  //     )
  //     ->get();

  //   // Second query with teamrolehistory join
  //   $patnerdata = DB::table('assignmentmappings')
  //     ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //     ->leftjoin('teammembers', function ($join) {
  //       $join->on('teammembers.id', 'assignmentmappings.otherpartner')
  //         ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
  //     })
  //     ->leftJoin('teamrolehistory', function ($join) {
  //       $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
  //         ->on('teamrolehistory.created_at', '<', 'assignmentbudgetings.created_at');
  //     })
  //     ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //     ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
  //     ->select(
  //       'assignmentmappings.id',
  //       'teammembers.id as teamid',
  //       'teammembers.team_member',
  //       'teammembers.staffcode',
  //       'teammembers.role_id',
  //       'titles.title',
  //       'assignmentmappings.assignmentgenerate_id',
  //       'assignmentbudgetings.assignmentname',
  //       'assignmentbudgetings.created_at',
  //       'assignmentmappings.otherpartner',
  //       'assignmentmappings.leadpartner',
  //       'assignmentmappings.leadpartnerhour',
  //       'assignmentmappings.otherpartnerhour',
  //       'teamrolehistory.newstaff_code'
  //     )
  //     ->get();


  //   $teammemberDatas = $teammemberDatass->merge($patnerdata);
  //   return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  // }


  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */

  //  before optimize 
  // public function assignmentHourShowfilter(Request $request)
  // {
  //   $employee = $request->input('employee');
  //   $assignmentgenerateid = $request->input('assignmentgenerateid');
  //   if ($employee != null) {
  //     $employeValues = explode('/', $employee);
  //     $teamname = $employeValues[0];
  //     $role_id = $employeValues[1];
  //   }

  //   if ($employee == null) {
  //     $query = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //       ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
  //       ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour');

  //     if ($assignmentgenerateid) {
  //       $query->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid);
  //     }
  //     $teammemberall = $query->get();

  //     $query = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('teammembers', function ($join) {
  //         $join->on('teammembers.id', '=', 'assignmentmappings.otherpartner')
  //           ->orOn('teammembers.id', '=', 'assignmentmappings.leadpartner');
  //       })
  //       ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
  //       ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
  //       ->select(
  //         'assignmentmappings.id',
  //         'teammembers.id as teamid',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'teammembers.role_id',
  //         'titles.title',
  //         'assignmentmappings.assignmentgenerate_id',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentmappings.otherpartner',
  //         'assignmentmappings.leadpartner',
  //         'assignmentmappings.leadpartnerhour',
  //         'assignmentmappings.otherpartnerhour'
  //       );

  //     if ($assignmentgenerateid) {
  //       $query->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid);
  //     }
  //     $partnerall = $query->get();
  //     $teammemberDatas = $teammemberall->merge($partnerall);
  //     $request->flash();
  //     return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   }
  //   if ($role_id != 13) {

  //     $query = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //       ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
  //       ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour');

  //     if ($teamname) {
  //       $query->where('assignmentteammappings.teammember_id', $teamname);
  //     }
  //     if ($assignmentgenerateid) {
  //       $query->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid);
  //     }
  //     $teammemberDatas = $query->get();
  //     $request->flash();
  //     return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   }

  //   if ($role_id == 13) {
  //     $query = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('teammembers', function ($join) {
  //         $join->on('teammembers.id', '=', 'assignmentmappings.otherpartner')
  //           ->orOn('teammembers.id', '=', 'assignmentmappings.leadpartner');
  //       })
  //       ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
  //       ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
  //       ->select(
  //         'assignmentmappings.id',
  //         'teammembers.id as teamid',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'teammembers.role_id',
  //         'titles.title',
  //         'assignmentmappings.assignmentgenerate_id',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentmappings.otherpartner',
  //         'assignmentmappings.leadpartner',
  //         'assignmentmappings.leadpartnerhour',
  //         'assignmentmappings.otherpartnerhour'
  //       );

  //     if ($teamname) {
  //       $query->where(function ($query) use ($teamname) {
  //         $query->where('assignmentmappings.leadpartner', $teamname)
  //           ->orWhere('assignmentmappings.otherpartner', $teamname)
  //           ->where('teammembers.id', $teamname);
  //       });
  //     }

  //     if ($assignmentgenerateid) {
  //       $teammemberDatas = $query->get()->filter(function ($item) use ($assignmentgenerateid, $teamname) {
  //         return $item->assignmentgenerate_id == $assignmentgenerateid && $item->teamid == $teamname;
  //       });
  //     } else {
  //       $teammemberDatas = $query->get()->filter(function ($item) use ($teamname) {
  //         return $item->teamid == $teamname;
  //       });
  //     }

  //     $request->flash();
  //     return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   }
  // }


  // public function assignmentHourShowfilter(Request $request)
  // {
  //   $employee = $request->input('employee');
  //   $assignmentgenerateid = $request->input('assignmentgenerateid');
  //   if ($employee != null) {
  //     $employeValues = explode('/', $employee);
  //     $teamname = $employeValues[0];
  //     $role_id = $employeValues[1];
  //   }

  //   if ($employee == null) {
  //     $query = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //       ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
  //       ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour');

  //     if ($assignmentgenerateid) {
  //       $query->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid);
  //     }
  //     $teammemberall = $query->get();

  //     $query = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('teammembers', function ($join) {
  //         $join->on('teammembers.id', '=', 'assignmentmappings.otherpartner')
  //           ->orOn('teammembers.id', '=', 'assignmentmappings.leadpartner');
  //       })
  //       ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
  //       ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
  //       ->select(
  //         'assignmentmappings.id',
  //         'teammembers.id as teamid',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'teammembers.role_id',
  //         'titles.title',
  //         'assignmentmappings.assignmentgenerate_id',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentmappings.otherpartner',
  //         'assignmentmappings.leadpartner',
  //         'assignmentmappings.leadpartnerhour',
  //         'assignmentmappings.otherpartnerhour'
  //       );

  //     if ($assignmentgenerateid) {
  //       $query->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid);
  //     }
  //     $partnerall = $query->get();
  //     $teammemberDatas = $teammemberall->merge($partnerall);
  //     $request->flash();
  //     return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   }
  //   if ($role_id != 13) {

  //     $query = DB::table('assignmentteammappings')
  //       ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
  //       ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
  //       ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
  //       ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour');

  //     if ($teamname) {
  //       $query->where('assignmentteammappings.teammember_id', $teamname);
  //     }
  //     if ($assignmentgenerateid) {
  //       $query->where('assignmentmappings.assignmentgenerate_id', $assignmentgenerateid);
  //     }
  //     $teammemberDatas = $query->get();
  //     $request->flash();
  //     return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   }

  //   if ($role_id == 13) {
  //     $query = DB::table('assignmentmappings')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
  //       ->leftJoin('teammembers', function ($join) {
  //         $join->on('teammembers.id', '=', 'assignmentmappings.otherpartner')
  //           ->orOn('teammembers.id', '=', 'assignmentmappings.leadpartner');
  //       })
  //       ->leftJoin('titles', 'titles.id', '=', 'teammembers.title_id')
  //       ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
  //       ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
  //       ->select(
  //         'assignmentmappings.id',
  //         'teammembers.id as teamid',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'teammembers.role_id',
  //         'titles.title',
  //         'assignmentmappings.assignmentgenerate_id',
  //         'assignmentbudgetings.assignmentname',
  //         'assignmentmappings.otherpartner',
  //         'assignmentmappings.leadpartner',
  //         'assignmentmappings.leadpartnerhour',
  //         'assignmentmappings.otherpartnerhour'
  //       );

  //     if ($teamname) {
  //       $query->where(function ($query) use ($teamname) {
  //         $query->where('assignmentmappings.leadpartner', $teamname)
  //           ->orWhere('assignmentmappings.otherpartner', $teamname)
  //           ->where('teammembers.id', $teamname);
  //       });
  //     }

  //     if ($assignmentgenerateid) {
  //       $teammemberDatas = $query->get()->filter(function ($item) use ($assignmentgenerateid, $teamname) {
  //         return $item->assignmentgenerate_id == $assignmentgenerateid && $item->teamid == $teamname;
  //       });
  //     } else {
  //       $teammemberDatas = $query->get()->filter(function ($item) use ($teamname) {
  //         return $item->teamid == $teamname;
  //       });
  //     }

  //     $request->flash();
  //     return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas'));
  //   }
  // }


  // after optimize this code
  public function assignmentHourShowfilter(Request $request)
  {
    // Fetch all necessary data with a single query per table
    $teammemberDatass = DB::table('assignmentteammappings')
      ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
      ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.role_id', 'teammembers.staffcode', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentteammappings.teamhour')
      ->get();

    $patnerdata = DB::table('assignmentmappings')
      ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
      ->leftjoin('teammembers', function ($join) {
        $join->on('teammembers.id', 'assignmentmappings.otherpartner')
          ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
      })
      ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
      ->select('assignmentmappings.id', 'teammembers.id as teamid', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.role_id', 'titles.title', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentname', 'assignmentmappings.otherpartner', 'assignmentmappings.leadpartner', 'assignmentmappings.leadpartnerhour', 'assignmentmappings.otherpartnerhour')
      ->get();

    $allData = $teammemberDatass->merge($patnerdata);

    // Collect ids to fetch role history and assignment budgetings in bulk
    $teamIds = $allData->pluck('teamid')->unique();
    $assignmentIds = $allData->pluck('assignmentgenerate_id')->unique();

    // Fetch role history and assignment budgetings in bulk
    $roleHistories = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $teamIds)
      ->get()
      ->keyBy('teammember_id');

    $assignmentBudgetings = DB::table('assignmentbudgetings')
      ->whereIn('assignmentgenerate_id', $assignmentIds)
      ->get()
      ->keyBy('assignmentgenerate_id');

    // Apply filters
    $teammemberDatas = $allData->filter(function ($item) use ($request, $roleHistories, $assignmentBudgetings) {
      $employee = $request->input('employee');
      $assignmentgenerateid = $request->input('assignmentgenerateid');

      $employeValues = $employee ? explode('/', $employee) : null;
      $teamname = $employeValues[0] ?? null;
      $role_id = $employeValues[1] ?? null;

      $matchesEmployee = $employee ? $item->teamid == $teamname && $item->role_id == $role_id : true;
      $matchesAssignment = $assignmentgenerateid ? $item->assignmentgenerate_id == $assignmentgenerateid : true;

      return $matchesEmployee && $matchesAssignment;
    });

    // Pass filtered data to the view
    $request->flash();
    return view('backEnd.timesheet.assignmentlistwithhour', compact('teammemberDatas', 'roleHistories', 'assignmentBudgetings'));
  }



  public function create(Request $request)
  {

    $permotioncheck = DB::table('teamrolehistory')
      ->where('teammember_id', auth()->user()->teammember_id)->first();
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name', 'client_code')->orderBy('client_name', 'ASC')->get();
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();
    } elseif ($permotioncheck && auth()->user()->role_id == 13) {
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();

      $clientssbefore = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $clientssafter = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
        })
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      // $clients = DB::table('clients')
      //   ->whereIn('id', [29, 32, 33, 34])
      //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
      //   ->orderBy('client_name', 'ASC')
      //   ->distinct()->get();
      // $client = $clientss->merge($clients);

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
            $clientIds = [29, 32, 33, 34];
          } else {
            $clientIds = [29, 32, 34];
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }

      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientssafter->merge($clientssbefore)->merge($clients);
    } elseif (auth()->user()->role_id == 13) {
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();

      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
        })
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      // $clients = DB::table('clients')
      //   ->whereIn('id', [29, 32, 33, 34])
      //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
      //   ->orderBy('client_name', 'ASC')
      //   ->distinct()->get();
      // $client = $clientss->merge($clients);

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
            $clientIds = [29, 32, 33, 34];
          } else {
            $clientIds = [29, 32, 34];
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }


      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientss->merge($clients);
    } else {
      $timesheetrejectData = DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', 2)
        ->first();

      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        // i have add this line becouse manager contain it but staff not contain it so basically after add this code no contain staff and manager 
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where('assignmentbudgetings.status', 1)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      // $clients = DB::table('clients')
      //   ->whereIn('id', [29, 32, 33, 34])
      //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
      //   ->orderBy('client_name', 'ASC')
      //   ->distinct()->get();

      // $client = $clientss->merge($clients);

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if (auth()->user()->role_id == 14) {
            if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } else {
              $clientIds = [29, 32, 34];
            }
          } else {
            if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
              $clientIds = [29, 32, 33, 34];
            }
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }
      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientss->merge($clients);
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    if ($request->ajax()) {
      // dd($request);
      if (isset($request->timesheetdate)) {
        if ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);


          $clientssbefore = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          $clientssafter = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            // ->whereNotNull('clients.client_name')
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          // $clients = DB::table('clients')
          //   ->whereIn('id', [29, 32, 33, 34])
          //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
          //   ->orderBy('client_name', 'ASC')
          //   ->distinct()->get();

          // if you selected sturday date then offholydays client will be show otherwise not

          $formattedDate = $selectedDate1->format('Y-m-d');
          $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

          if ($holidaydatecheck) {
            $clientIds = [29, 32, 33, 34];
          } else {
            // if not holidays then go hare
            $dayOfWeek = $selectedDate1->format('w');
            if ($selectedDate1->format('l') == 'Saturday') {
              $dayOfMonth = $selectedDate1->format('j');
              // Calculate which Saturday of the month it is
              $saturdayNumber = ceil($dayOfMonth / 7);
              // offholiday client name will be show on 2nd and 4rth sturday
              if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                $clientIds = [29, 32, 33, 34];
              } else {
                $clientIds = [29, 32, 34];
              }
            } else {
              $clientIds = [29, 32, 34];
            }
          }
          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          // $client = $clientss->merge($clients);
          $client = $clientssafter->merge($clientssbefore)->merge($clients);
          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

          $clientss = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            // ->whereNotNull('clients.client_name')
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();

          // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          // $clients = DB::table('clients')
          //   ->whereIn('id', [29, 32, 33, 34])
          //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
          //   ->orderBy('client_name', 'ASC')
          //   ->distinct()->get();

          // if you selected sturday date then offholydays client will be show otherwise not

          $formattedDate = $selectedDate1->format('Y-m-d');
          $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

          if ($holidaydatecheck) {
            $clientIds = [29, 32, 33, 34];
          } else {
            // if not holidays then go hare
            $dayOfWeek = $selectedDate1->format('w');
            if ($selectedDate1->format('l') == 'Saturday') {
              $dayOfMonth = $selectedDate1->format('j');
              // Calculate which Saturday of the month it is
              $saturdayNumber = ceil($dayOfMonth / 7);
              // offholiday client name will be show on 2nd and 4rth sturday
              if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                $clientIds = [29, 32, 33, 34];
              } else {
                $clientIds = [29, 32, 34];
              }
            } else {
              $clientIds = [29, 32, 34];
            }
          }
          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        } else {

          echo "<option>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $clientss = DB::table('assignmentteammappings')
            ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
            ->where(function ($query) use ($selectedDate) {
              $query->whereNull('otpverifydate')
                ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
            })
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()->get();
          // ->get();

          // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
          // $clients = DB::table('clients')
          //   ->whereIn('id', [29, 32, 33, 34])
          //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
          //   ->orderBy('client_name', 'ASC')
          //   ->distinct()->get();

          // $client = $clientss->merge($clients);



          $formattedDate = $selectedDate1->format('Y-m-d');
          $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

          if ($holidaydatecheck) {
            $clientIds = [29, 32, 33, 34];
          } else {
            // if not holidays then go hare
            $dayOfWeek = $selectedDate1->format('w');
            if ($selectedDate1->format('l') == 'Saturday') {
              $dayOfMonth = $selectedDate1->format('j');
              // Calculate which Saturday of the month it is
              $saturdayNumber = ceil($dayOfMonth / 7);
              // offholiday client name will be show on 2nd and 4rth sturday
              if (auth()->user()->role_id == 14) {
                if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
                  $clientIds = [29, 32, 33, 34];
                } else {
                  $clientIds = [29, 32, 34];
                }
              } else {
                if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
                  $clientIds = [29, 32, 33, 34];
                }
              }
            } else {
              $clientIds = [29, 32, 34];
            }
          }
          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        }
      }

      if (isset($request->cid)) {
        if ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();

            $id = $clients[0]->id;
            $assignments = DB::table('assignmentbudgetings')->where('client_id', $id)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignments.assignmentname')
              ->orderBy('assignment_name');
          } else {
            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            $assignments = DB::table('assignmentbudgetings')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
              ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->where(function ($query) {
                $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                  ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname');

            $additionalAssignments = DB::table('assignmentbudgetings')
              ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
              ->leftJoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
              ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
              ->where('assignmentbudgetings.client_id', $request->cid)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->where(function ($query) {
                $query->whereNull('assignmentteammappings.status')
                  ->orWhere('assignmentteammappings.status', '=', 1);
              })
              ->where(function ($query) use ($selectedDate) {
                $query->whereNull('otpverifydate')
                  ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
              })
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname');

            $assignments = $assignments->union($additionalAssignments)->orderBy('assignment_name')->get();
            // dd($assignments);
          }

          foreach ($assignments as $sub) {
            echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
          }
        }

        // 22222222
        elseif (auth()->user()->role_id == 13) {

          echo "<option>Select Assignment</option>";
          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (
              DB::table('assignmentbudgetings')->where('client_id', $id)
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            // dd('hi 3');

            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (
              DB::table('assignmentbudgetings')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->where(function ($query) {
                  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        } else {

          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (
              DB::table('assignmentbudgetings')->where('client_id', $id)
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            //  i have add this code after kartic bindal problem 
            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (
              DB::table('assignmentbudgetings')
                ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                //  ->where('assignmentteammappings.status', '!=', 0)
                // ->whereNull('assignmentteammappings.status')
                ->where(function ($query) {
                  $query->whereNull('assignmentteammappings.status')
                    ->orWhere('assignmentteammappings.status', '=', 1);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    //   ->orWhere('otpverifydate', '>=', $selectedDate);
                    // // ->orWhere('otpverifydate', '>=', $selectedDate);
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        }
      }

      if (isset($request->assignment)) {
        // dd($request->assignment);
        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('assignmentmappings')

              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          // dd($request->assignment);
          $partnerbefore = DB::table('assignmentmappings')
            ->leftJoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->select('teammembers.id', 'teammembers.team_member');

          // $partnerafter = DB::table('assignmentmappings')
          //   ->leftJoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
          //   ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
          //   ->select('teammembers.id', 'teammembers.team_member');

          $partnerafter = DB::table('assignmentmappings')
            ->leftJoin('teammembers as leadpartner', 'leadpartner.id', '=', 'assignmentmappings.leadpartner')
            ->leftJoin('teammembers as otherpartner', 'otherpartner.id', '=', 'assignmentmappings.otherpartner')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
            })
            ->select(DB::raw("
          CASE
              WHEN assignmentmappings.leadpartner = " . auth()->user()->teammember_id . " THEN leadpartner.id
              WHEN assignmentmappings.otherpartner = " . auth()->user()->teammember_id . " THEN otherpartner.id
          END as id,
          CASE
              WHEN assignmentmappings.leadpartner = " . auth()->user()->teammember_id . " THEN leadpartner.team_member
              WHEN assignmentmappings.otherpartner = " . auth()->user()->teammember_id . " THEN otherpartner.team_member
          END as team_member
      "));

          $partnerresult = $partnerafter->union($partnerbefore)->get();
          foreach ($partnerresult as $subs) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('teammembers')
              ->where('id', auth()->user()->teammember_id)
              ->select('teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {

          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('assignmentmappings')

              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    } else {
      return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetrejectData'));
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

        //	if ($request->date < '11-09-2023') {
        //dd('hi');
        // $output = array('msg' => 'Please fill timesheet from 11/09/2023, Monday onwards');
        //  return back()->with('success', $output);
        //   }

        //die;
        //? dd(date('w', strtotime($request->date))); // 4
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
        $id = DB::table('timesheets')->insertGetId(
          [
            'created_by' => auth()->user()->teammember_id,
            'month'     =>    date('F', strtotime($request->date)),
            'date'     =>    date('Y-m-d', strtotime($request->date)),
            'created_at'          =>     date('Y-m-d H:i:s'),
          ]
        );


        $count = count($request->assignment_id);

        // dd('hi 3', $count);
        for ($i = 0; $i < $count; $i++) {
          //dd($request->workitem[$i]);
          $assignment =  DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->assignment_id[$i])->first();

          $a = DB::table('timesheetusers')->insert([
            'date'     =>     $request->date,
            'client_id'     =>     $request->client_id[$i],
            'assignmentgenerate_id'     =>     $request->assignment_id[$i],
            'workitem'     =>     $request->workitem[$i],
            'location'     =>     $request->location[$i],
            //   'billable_status'     =>     $request->billable_status[$i],
            'timesheetid'     =>     $id,
            'date'     =>     date('Y-m-d', strtotime($request->date)),
            'hour'     =>     $request->hour[$i],
            'totalhour' =>      $request->totalhour,
            'assignment_id'     =>     $assignment->assignment_id,
            'partner'     =>     $request->partner[$i],
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

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

          if (auth()->user()->role_id == 13) {
            $assignmentdata = DB::table('assignmentmappings')
              ->where('assignmentgenerate_id', $request->assignment_id[$i])
              ->first();
            $finalresultleadpatner =  $assignmentdata->leadpartnerhour + $request->hour[$i];
            $finalresultotherpatner =  $assignmentdata->otherpartnerhour + $request->hour[$i];

            if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
              $update = DB::table('assignmentmappings')
                ->where('assignmentgenerate_id', $request->assignment_id[$i])
                ->where('leadpartner', auth()->user()->teammember_id)
                ->update(['leadpartnerhour' => $finalresultleadpatner]);
            }
            if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
              $update = DB::table('assignmentmappings')
                ->where('assignmentgenerate_id', $request->assignment_id[$i])
                ->where('otherpartner', auth()->user()->teammember_id)
                ->update(['otherpartnerhour' => $finalresultotherpatner]);
            }
          }
        }
      } else {
        // dd(auth()->user()->teammember_id);
        $output = array('msg' => 'You can not fill timesheet before Rejoining date :' . $joining_date);
        return redirect('timesheet')->with('success', $output);
      }

      //Attendance code

      $hdatess = date('Y-m-d', strtotime($request->date));
      $day =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('d');      //
      $month =  DateTime::createFromFormat('Y-m-d', $hdatess)->format('F');   //
      $currentDate = new DateTime();
      $currentMonth = $currentDate->format('F');
      //dd($month);
      //   if ($currentDate->format('j') > 25) {
      //     $currentDate->modify('-1 month');
      //     $currentMonth = $currentDate->format('F');
      // }



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
        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $dateTime->modify('+1 month');
        $month = $dateTime->format('F');
      }
      if ($month != $currentMonth && $day < 25) {
        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $month = $dateTime->format('F');
      }
      if ($month == $currentMonth && $day > 25) {

        $dateTime = DateTime::createFromFormat('Y-m-d', $hdatess);
        $dateTime->modify('+1 month');
        $month = $dateTime->format('F');
      }

      //dd($month);


      $column = $dates[$day];

      $attendances = DB::table('attendances')->where('employee_name', auth()->user()->teammember_id)
        ->where('month', $month)->first();

      if ($attendances ==  null) {
        $teammember = DB::table('teammembers')->where('id', auth()->user()->teammember_id)->first();

        $a = DB::table('attendances')->insert([
          'employee_name'         =>     auth()->user()->teammember_id,
          'month'         =>    $month,
          'dateofjoining' =>   $teammember->joining_date,
          'created_at'          =>     date('Y-m-d H:i:s'),
          //   'exam_leave'      =>$value->date_total,
        ]);
        //dd($a);
      }


      //   dd($noofdaysaspertimesheet);

      // $updatedtotalhour = $request->totalhour;
      // if ($attendances != null && property_exists($attendances, $column)) {
      //   if ($attendances->$column != "LWP") {
      //     $updatedtotalhour = $request->totalhour + $attendances->$column;
      //   }
      // }
      // DB::table('attendances')
      //   ->where('employee_name', auth()->user()->teammember_id)
      //   ->where('month', $month)
      //   ->update([$column => $updatedtotalhour]);


      //end attendance


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
        //  $db['billable_status'] = $request->billable_status;
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
          //    'billable_status'     =>     $request->billable_status[$i],
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
      $timesheetdelete = DB::table('timesheetusers')->where('timesheetid', $id)->first();
      // dd($timesheetdelete);
      if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {

        $gettotalteamhour = DB::table('assignmentmappings')
          ->leftJoin(
            'assignmentteammappings',
            'assignmentteammappings.assignmentmapping_id',
            'assignmentmappings.id',
          )
          ->where(
            'assignmentmappings.assignmentgenerate_id',
            $timesheetdelete->assignmentgenerate_id
          )
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->first();
        if ($gettotalteamhour) {
          $gettotalteamhour = $gettotalteamhour->teamhour;
          $finalresult =  $gettotalteamhour - $timesheetdelete->hour;

          $totalteamhourupdate = DB::table('assignmentmappings')
            ->leftJoin(
              'assignmentteammappings',
              'assignmentteammappings.assignmentmapping_id',
              'assignmentmappings.id',
            )
            ->where(
              'assignmentmappings.assignmentgenerate_id',
              $timesheetdelete->assignmentgenerate_id
            )
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            // ->get();
            ->update(['teamhour' =>  $finalresult]);
        }
      }

      if (auth()->user()->role_id == 13) {
        $assignmentdata = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
          ->first();

        $finalresultleadpatner =  $assignmentdata->leadpartnerhour - $timesheetdelete->hour;
        $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $timesheetdelete->hour;

        if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
          $update2 = DB::table('assignmentmappings')
            ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
            ->where('leadpartner', auth()->user()->teammember_id)
            ->update(['leadpartnerhour' => $finalresultleadpatner]);
        }
        if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
          $update2 = DB::table('assignmentmappings')
            ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
            ->where('otherpartner', auth()->user()->teammember_id)
            ->update(['otherpartnerhour' => $finalresultotherpatner]);
        }
      }
      DB::table('timesheets')->where('id', $id)->delete();
      DB::table('timesheetusers')->where('timesheetid', $id)->delete();
      $output = array('msg' => 'Deleted Successfully');
      return back()->with('statuss', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  // public function timesheetrequestStore(Request $request)
  // {
  //   try {
  //     $request->validate([
  //       'reason' => 'required',
  //       'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
  //     ], [
  //       'file.max' => 'The file may not be greater than 5 MB.',
  //     ]);

  //     $data = $request->except(['_token', 'file']);
  //     $latestrequest = DB::table('timesheetrequests')
  //       ->where('createdby', auth()->user()->teammember_id)
  //       ->latest()
  //       ->select('created_at', 'status')
  //       ->first();
  //     // dd($latestrequest);

  //     if ($latestrequest != null && $latestrequest->status != 2) {
  //       $latestrequesthour = Carbon::parse($latestrequest->created_at);
  //       // dd($latestrequest->created_at);
  //       $currentDateTime = Carbon::now();
  //       // Check if the difference is more than 24 hours
  //       if ($latestrequesthour->diffInHours($currentDateTime) > 24) {

  //         $fileName = '';
  //         if ($request->hasFile('file')) {
  //           $file = $request->file('file');
  //           // public\backEnd\image\confirmationfile
  //           $destinationPath = 'backEnd/image/confirmationfile';
  //           $fileName = $file->getClientOriginalName();
  //           $file->move($destinationPath, $fileName);
  //         }

  //         $id = DB::table('timesheetrequests')->insertGetId([
  //           'partner'     =>     $request->partner,
  //           'reason'     =>     $request->reason,
  //           'attachment'     =>     $fileName,
  //           'status'     =>     0,
  //           'createdby' => auth()->user()->teammember_id,
  //           'created_at'          =>     date('Y-m-d H:i:s'),
  //           'updated_at'              =>    date('Y-m-d H:i:s'),
  //         ]);

  //         // timesheet request mail to admin
  //         $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
  //         $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

  //         $data = array(
  //           'teammember' => $name ?? '',
  //           'email' => $teammembermail ?? '',
  //           'id' => $id ?? '',
  //         );
  //         Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
  //           $msg->to($data['email']);
  //           //     $msg->cc('itsupport_delhi@vsa.co.in');
  //           $msg->subject('Timesheet Submission Request');
  //         });
  //         // timesheet request mail to admin
  //         return response()->json(['success' => true, 'msg' => 'Request Successfully']);
  //       } else {
  //         $msg = 'You can submit new timesheet request after 24 hour from ' . date('h:i:s A', strtotime($latestrequest->created_at));
  //         return response()->json(['success' => false, 'msg' => $msg]);
  //       }
  //     } else {


  //       $fileName = '';
  //       if ($request->hasFile('file')) {
  //         $file = $request->file('file');
  //         // public\backEnd\image\confirmationfile
  //         $destinationPath = 'backEnd/image/confirmationfile';
  //         $fileName = $file->getClientOriginalName();
  //         $file->move($destinationPath, $fileName);
  //       }

  //       $id = DB::table('timesheetrequests')->insertGetId([
  //         'partner'     =>     $request->partner,
  //         'reason'     =>     $request->reason,
  //         'attachment'     =>     $fileName,
  //         'status'     =>     0,
  //         'createdby' => auth()->user()->teammember_id,
  //         'created_at'          =>     date('Y-m-d H:i:s'),
  //         'updated_at'              =>    date('Y-m-d H:i:s'),
  //       ]);

  //       // timesheet request mail to admin
  //       $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
  //       $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

  //       $data = array(
  //         'teammember' => $name ?? '',
  //         'email' => $teammembermail ?? '',
  //         'id' => $id ?? '',
  //       );
  //       Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
  //         $msg->to($data['email']);
  //         //   $msg->cc('itsupport_delhi@vsa.co.in');
  //         $msg->subject('Timesheet Submission Request');
  //       });
  //       // timesheet request mail to admin
  //       return response()->json(['success' => true, 'msg' => 'Request Successfully Done']);
  //     }
  //   } catch (Exception $e) {
  //     DB::rollBack();
  //     Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
  //     report($e);
  //     return response()->json(['success' => false, 'msg' => $e->getMessage()]);
  //   }
  // }

  public function timesheetrequestStore(Request $request)
  {
    try {
      $request->validate([
        'reason' => 'required',
        'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
      ], [
        'file.max' => 'The file may not be greater than 5 MB.',
      ]);

      $data = $request->except(['_token', 'file']);
      $latestrequest = DB::table('timesheetrequests')
        ->where('createdby', auth()->user()->teammember_id)
        ->latest()
        ->select('created_at', 'status')
        ->first();
      // dd($latestrequest);

      if ($latestrequest != null && $latestrequest->status != 2) {
        $latestrequesthour = Carbon::parse($latestrequest->created_at);
        // dd($latestrequest->created_at);
        $currentDateTime = Carbon::now();
        // Check if the difference is more than 24 hours
        if ($latestrequesthour->diffInHours($currentDateTime) > 24) {


          $fileName = '';
          if ($request->hasFile('file')) {
            $file = $request->file('file');
            // public\backEnd\image\confirmationfile
            $destinationPath = 'backEnd/image/confirmationfile';
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
          }

          $id = DB::table('timesheetrequests')->insertGetId([
            'partner'     =>     $request->partner,
            'reason'     =>     $request->reason,
            'attachment'     =>     $fileName,
            'status'     =>     0,
            'createdby' => auth()->user()->teammember_id,
            'created_at'          =>     date('Y-m-d H:i:s'),
            'updated_at'              =>    date('Y-m-d H:i:s'),
          ]);

          // timesheet request mail to admin
          $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
          $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

          $data = array(
            'teammember' => $name ?? '',
            'email' => $teammembermail ?? '',
            'id' => $id ?? '',
          );
          Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
            $msg->to($data['email']);
            //     $msg->cc('itsupport_delhi@vsa.co.in');
            $msg->subject('Timesheet Submission Request');
          });
          // timesheet request mail to admin
          return response()->json(['success' => true, 'msg' => 'Request Successfully']);
        } else {
          $msg = 'You can submit new timesheet request after 24 hour from ' . date('h:i:s A', strtotime($latestrequest->created_at));
          return response()->json(['success' => false, 'msg' => $msg]);
        }
      } else {


        $fileName = '';
        if ($request->hasFile('file')) {
          $file = $request->file('file');
          // public\backEnd\image\confirmationfile
          $destinationPath = 'backEnd/image/confirmationfile';
          $fileName = $file->getClientOriginalName();
          $file->move($destinationPath, $fileName);
        }

        $id = DB::table('timesheetrequests')->insertGetId([
          'partner'     =>     $request->partner,
          'reason'     =>     $request->reason,
          'attachment'     =>     $fileName,
          'status'     =>     0,
          'createdby' => auth()->user()->teammember_id,
          'created_at'          =>     date('Y-m-d H:i:s'),
          'updated_at'              =>    date('Y-m-d H:i:s'),
        ]);

        // timesheet request mail to admin
        $teammembermail = Teammember::where('id', $request->partner)->pluck('emailid')->first();
        $name = Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first();

        $data = array(
          'teammember' => $name ?? '',
          'email' => $teammembermail ?? '',
          'id' => $id ?? '',
        );
        Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
          $msg->to($data['email']);
          //   $msg->cc('itsupport_delhi@vsa.co.in');
          $msg->subject('Timesheet Submission Request');
        });
        // timesheet request mail to admin
        return response()->json(['success' => true, 'msg' => 'Request Successfully Done']);
      }
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
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

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
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

  // public function filterDataAdmin(Request $request)
  // {
  //   $urlheader = $request->headers->get('referer');
  //   $url = parse_url($urlheader);
  //   $path = $url['path'];
  //   // dd($url);
  //   // this is for patner submitted timesheet 
  //   if (auth()->user()->role_id == 13 && $path == '/timesheet/partnersubmitted') {
  //     // dd('patner');
  //     $teamname = $request->input('teamname');
  //     $start = $request->input('start');
  //     $end = $request->input('end');
  //     $totalhours = $request->input('totalhours');
  //     $partnerId = $request->input('partnersearch');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //       ->latest();

  //     // teamname with othser field to  filter
  //     if ($teamname) {
  //       $query->where('timesheetreport.teamid', $teamname);
  //     }

  //     if ($teamname && $totalhours) {
  //       $query->where(function ($q) use ($teamname, $totalhours) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }
  //     if ($teamname && $partnerId) {
  //       $query->where(function ($q) use ($teamname, $partnerId) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.partnerid', $partnerId);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($partnerId) {
  //       $query->where('timesheetreport.partnerid', $partnerId);
  //     }

  //     if ($partnerId && $totalhours) {
  //       $query->where(function ($q) use ($partnerId, $totalhours) {
  //         $q->where('timesheetreport.partnerid', $partnerId)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }

  //     // total hour wise  wise or othser data
  //     if ($totalhours) {
  //       $query->where('timesheetreport.totaltime', $totalhours);
  //     }
  //     //! end date 
  //     if ($start && $end) {
  //       $query->where(function ($query) use ($start, $end) {
  //         $query->whereBetween('timesheetreport.startdate', [$start, $end])
  //           ->orWhereBetween('timesheetreport.enddate', [$start, $end])
  //           ->orWhere(function ($query) use ($start, $end) {
  //             $query->where('timesheetreport.startdate', '<=', $start)
  //               ->where('timesheetreport.enddate', '>=', $end);
  //           });
  //       });
  //     }
  //   }
  //   // this is for team submitted timesheet on patner
  //   elseif (auth()->user()->role_id == 13 && $path == '/timesheet/teamlist') {
  //     // dd($request);
  //     // dd('team');
  //     $teamname = $request->input('teamname');
  //     $start = $request->input('start');
  //     $end = $request->input('end');
  //     $totalhours = $request->input('totalhours');
  //     $partnerId = $request->input('partnersearch');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
  //       // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
  //       ->orderBy('timesheetreport.startdate', 'desc');

  //     // teamname with othser field to  filter
  //     if ($teamname) {
  //       $query->where('timesheetreport.teamid', $teamname);
  //     }

  //     if ($teamname && $totalhours) {
  //       $query->where(function ($q) use ($teamname, $totalhours) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }
  //     if ($teamname && $partnerId) {
  //       $query->where(function ($q) use ($teamname, $partnerId) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.partnerid', $partnerId);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($partnerId) {
  //       $query->where('timesheetreport.partnerid', $partnerId);
  //     }

  //     if ($partnerId && $totalhours) {
  //       $query->where(function ($q) use ($partnerId, $totalhours) {
  //         $q->where('timesheetreport.partnerid', $partnerId)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }

  //     // total hour wise  wise or othser data
  //     if ($totalhours) {
  //       $query->where('timesheetreport.totaltime', $totalhours);
  //     }
  //     //! end date 
  //     if ($start && $end) {
  //       $query->where(function ($query) use ($start, $end) {
  //         $query->whereBetween('timesheetreport.startdate', [$start, $end])
  //           ->orWhereBetween('timesheetreport.enddate', [$start, $end])
  //           ->orWhere(function ($query) use ($start, $end) {
  //             $query->where('timesheetreport.startdate', '<=', $start)
  //               ->where('timesheetreport.enddate', '>=', $end);
  //           });
  //       });
  //     }
  //   }
  //   // this is for submitted timesheet on staff and manager 
  //   elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
  //     // dd($request);
  //     $teamname = $request->input('teamname');
  //     $start = $request->input('start');
  //     $end = $request->input('end');
  //     $totalhours = $request->input('totalhours');
  //     $partnerId = $request->input('partnersearch');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
  //       ->latest();

  //     // teamname with othser field to  filter
  //     if ($teamname) {
  //       $query->where('timesheetreport.teamid', $teamname);
  //     }

  //     if ($teamname && $totalhours) {
  //       $query->where(function ($q) use ($teamname, $totalhours) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }
  //     if ($teamname && $partnerId) {
  //       $query->where(function ($q) use ($teamname, $partnerId) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.partnerid', $partnerId);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($partnerId) {
  //       $query->where('timesheetreport.partnerid', $partnerId);
  //     }

  //     if ($partnerId && $totalhours) {
  //       $query->where(function ($q) use ($partnerId, $totalhours) {
  //         $q->where('timesheetreport.partnerid', $partnerId)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }

  //     // total hour wise  wise or othser data
  //     if ($totalhours) {
  //       $query->where('timesheetreport.totaltime', $totalhours);
  //     }
  //     //! end date 
  //     if ($start && $end) {
  //       $query->where(function ($query) use ($start, $end) {
  //         $query->whereBetween('timesheetreport.startdate', [$start, $end])
  //           ->orWhereBetween('timesheetreport.enddate', [$start, $end])
  //           ->orWhere(function ($query) use ($start, $end) {
  //             $query->where('timesheetreport.startdate', '<=', $start)
  //               ->where('timesheetreport.enddate', '>=', $end);
  //           });
  //       });
  //     }
  //   }
  //   // this is for team submitted timesheet on Admin
  //   else {
  //     // dd(auth()->user()->role_id);
  //     $teamname = $request->input('teamname');
  //     $start = $request->input('start');
  //     $end = $request->input('end');
  //     $totalhours = $request->input('totalhours');
  //     $partnerId = $request->input('partnersearch');


  //     $query = DB::table('timesheetreport')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //       ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //       ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
  //       ->orderBy('timesheetreport.startdate', 'desc');

  //     // teamname with othser field to  filter
  //     if ($teamname) {
  //       $query->where('timesheetreport.teamid', $teamname);
  //     }

  //     if ($teamname && $totalhours) {
  //       $query->where(function ($q) use ($teamname, $totalhours) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }
  //     if ($teamname && $partnerId) {
  //       $query->where(function ($q) use ($teamname, $partnerId) {
  //         $q->where('timesheetreport.teamid', $teamname)
  //           ->where('timesheetreport.partnerid', $partnerId);
  //       });
  //     }

  //     // patner or othse one data
  //     if ($partnerId) {
  //       $query->where('timesheetreport.partnerid', $partnerId);
  //     }

  //     if ($partnerId && $totalhours) {
  //       $query->where(function ($q) use ($partnerId, $totalhours) {
  //         $q->where('timesheetreport.partnerid', $partnerId)
  //           ->where('timesheetreport.totaltime', $totalhours);
  //       });
  //     }

  //     // total hour wise  wise or othser data
  //     if ($totalhours) {
  //       $query->where('timesheetreport.totaltime', $totalhours);
  //     }
  //     //! end date 
  //     if ($start && $end) {
  //       $query->where(function ($query) use ($start, $end) {
  //         $query->whereBetween('timesheetreport.startdate', [$start, $end])
  //           ->orWhereBetween('timesheetreport.enddate', [$start, $end])
  //           ->orWhere(function ($query) use ($start, $end) {
  //             $query->where('timesheetreport.startdate', '<=', $start)
  //               ->where('timesheetreport.enddate', '>=', $end);
  //           });
  //       });
  //     }

  //     $filteredDataaa = $query->get();

  //     // maping double date ************
  //     $groupedData = $filteredDataaa->groupBy(function ($item) {
  //       return $item->team_member . '|' . $item->week;
  //     })->map(function ($group) {
  //       $firstItem = $group->first();

  //       return (object)[
  //         'id' => $firstItem->id,
  //         'teamid' => $firstItem->teamid,
  //         'week' => $firstItem->week,
  //         'totaldays' => $group->sum('totaldays'),
  //         'totaltime' => $group->sum('totaltime'),
  //         'dayscount' => $group->sum('dayscount'),
  //         'startdate' => $firstItem->startdate,
  //         'enddate' => $firstItem->enddate,
  //         'partnername' => $firstItem->partnername,
  //         'created_at' => $firstItem->created_at,
  //         'team_member' => $firstItem->team_member,
  //         'staffcode' => $firstItem->staffcode,
  //         'partnerid' => $firstItem->partnerid,
  //       ];
  //     });

  //     $filteredData = collect($groupedData->values());
  //     // dd($filteredData);
  //     return response()->json($filteredData);
  //   }

  //   if (auth()->user()->role_id != 11) {
  //     $filteredDataaa = $query->get();

  //     // maping double date ************
  //     $groupedData = $filteredDataaa->groupBy(function ($item) {
  //       return $item->team_member . '|' . $item->week;
  //     })->map(function ($group) {
  //       $firstItem = $group->first();

  //       return (object)[
  //         'id' => $firstItem->id,
  //         'teamid' => $firstItem->teamid,
  //         'week' => $firstItem->week,
  //         'totaldays' => $group->sum('totaldays'),
  //         'totaltime' => $group->sum('totaltime'),
  //         'startdate' => $firstItem->startdate,
  //         'enddate' => $firstItem->enddate,
  //         'partnername' => $firstItem->partnername,
  //         'created_at' => $firstItem->created_at,
  //         'team_member' => $firstItem->team_member,
  //         'staffcode' => $firstItem->staffcode,
  //         'partnerid' => $firstItem->partnerid,
  //       ];
  //     });

  //     $filteredData = collect($groupedData->values());
  //     return response()->json($filteredData);
  //   }
  // }


  public function filterDataAdmin(Request $request)
  {
    $urlheader = $request->headers->get('referer');
    $url = parse_url($urlheader);
    $path = $url['path'];
    // dd($url);
    // this is for patner submitted timesheet 
    if (auth()->user()->role_id == 13 && $path == '/timesheet/partnersubmitted') {
      // dd('patner');
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
        ->latest();

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    // this is for team submitted timesheet on patner
    elseif (auth()->user()->role_id == 13 && $path == '/timesheet/teamlist') {
      // dd($request);
      // dd('team');
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
        ->orderBy('timesheetreport.startdate', 'desc');

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    // this is for submitted timesheet on staff and manager 
    elseif (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
      // dd($request);
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
        ->latest();

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }
    }
    // this is for team submitted timesheet on Admin
    else {
      // dd(auth()->user()->role_id);
      $teamname = $request->input('teamname');
      $start = $request->input('start');
      $end = $request->input('end');
      $totalhours = $request->input('totalhours');
      $partnerId = $request->input('partnersearch');


      $query = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
        ->orderBy('timesheetreport.startdate', 'desc');

      // teamname with othser field to  filter
      if ($teamname) {
        $query->where('timesheetreport.teamid', $teamname);
      }

      if ($teamname && $totalhours) {
        $query->where(function ($q) use ($teamname, $totalhours) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }
      if ($teamname && $partnerId) {
        $query->where(function ($q) use ($teamname, $partnerId) {
          $q->where('timesheetreport.teamid', $teamname)
            ->where('timesheetreport.partnerid', $partnerId);
        });
      }

      // patner or othse one data
      if ($partnerId) {
        $query->where('timesheetreport.partnerid', $partnerId);
      }

      if ($partnerId && $totalhours) {
        $query->where(function ($q) use ($partnerId, $totalhours) {
          $q->where('timesheetreport.partnerid', $partnerId)
            ->where('timesheetreport.totaltime', $totalhours);
        });
      }

      // total hour wise  wise or othser data
      if ($totalhours) {
        $query->where('timesheetreport.totaltime', $totalhours);
      }
      //! end date 
      if ($start && $end) {
        $query->where(function ($query) use ($start, $end) {
          $query->whereBetween('timesheetreport.startdate', [$start, $end])
            ->orWhereBetween('timesheetreport.enddate', [$start, $end])
            ->orWhere(function ($query) use ($start, $end) {
              $query->where('timesheetreport.startdate', '<=', $start)
                ->where('timesheetreport.enddate', '>=', $end);
            });
        });
      }

      $filteredDataaa = $query->get();

      // maping double date ************
      $groupedData = $filteredDataaa->groupBy(function ($item) {
        return $item->team_member . '|' . $item->week;
      })->map(function ($group) {
        $firstItem = $group->first();

        return (object)[
          'id' => $firstItem->id,
          'teamid' => $firstItem->teamid,
          'week' => $firstItem->week,
          'totaldays' => $group->sum('totaldays'),
          'totaltime' => $group->sum('totaltime'),
          'dayscount' => $group->sum('dayscount'),
          'startdate' => $firstItem->startdate,
          'enddate' => $firstItem->enddate,
          'partnername' => $firstItem->partnername,
          'created_at' => $firstItem->created_at,
          'team_member' => $firstItem->team_member,
          'staffcode' => $firstItem->staffcode,
          'partnerid' => $firstItem->partnerid,
        ];
      });

      $filteredData = collect($groupedData->values());
      // dd($filteredData);
      return response()->json($filteredData);
    }

    if (auth()->user()->role_id != 11) {
      $filteredDataaa = $query->get();

      // maping double date ************
      $groupedData = $filteredDataaa->groupBy(function ($item) {
        return $item->team_member . '|' . $item->week;
      })->map(function ($group) {
        $firstItem = $group->first();

        return (object)[
          'id' => $firstItem->id,
          'teamid' => $firstItem->teamid,
          'week' => $firstItem->week,
          'totaldays' => $group->sum('totaldays'),
          'totaltime' => $group->sum('totaltime'),
          'startdate' => $firstItem->startdate,
          'enddate' => $firstItem->enddate,
          'partnername' => $firstItem->partnername,
          'created_at' => $firstItem->created_at,
          'team_member' => $firstItem->team_member,
          'staffcode' => $firstItem->staffcode,
          'partnerid' => $firstItem->partnerid,
        ];
      });

      $filteredData = collect($groupedData->values());
      return response()->json($filteredData);
    }
  }



  public function weeklylist(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {

      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        // ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'assignmentbudgetings.assignmentname')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcodee', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreated')
        ->orderBy('id', 'ASC')
        //   ->orderBy('date', 'DESC')
        ->get();
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->where('timesheetusers.date', '>=', $date->startdate)
        ->where('timesheetusers.date', '<=', $date->enddate)
        ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'patnerid.id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->select('timesheetusers.*', 'assignments.assignment_name', 'clients.client_name', 'clients.client_code', 'teammembers.team_member', 'teammembers.staffcode', 'patnerid.team_member as patnername', 'patnerid.staffcode as patnerstaffcodee', 'assignmentbudgetings.assignmentname', 'teamrolehistory.newstaff_code', 'assignmentbudgetings.created_at as assignmentcreated')
        ->orderBy('id', 'ASC')
        ->get();
      // dd($timesheetData);
    }
    return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  }


  //* timesheet edit fubctionality
  public function timesheetEdit(Request $request, $id)
  {
    $timesheetedit = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->where('timesheetusers.timesheetid', $id)
      ->select('timesheetusers.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
      ->first();

    // $timesheetedit = DB::table('assignmentbudgetings')->where('client_id', $id)
    //   ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
    //   ->orderBy('assignment_name')->get();
    // dd($timesheetedit);

    // client of particular partner
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')->get();
    $teammember = Teammember::where('role_id', '!=', 11)->with('title', 'role')->get();
    if (auth()->user()->role_id == 11) {
      $client = Client::where('status', 1)->select('id', 'client_name')->orderBy('client_name', 'ASC')->get();
    } elseif (auth()->user()->role_id == 13) {
      $selectedDate = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);
      $selectedDate1 = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);

      $clientss = DB::table('assignmentmappings')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
        })
        ->where(function ($query) use ($selectedDate) {
          $query->whereNull('otpverifydate')
            ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
        })
        // ->whereNotNull('clients.client_name')
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      // // done default $clients in ajax if need then $clientss add in ajax target $request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34
      // $clients = DB::table('clients')
      //   ->whereIn('id', [29, 32, 33, 34])
      //   ->select('clients.client_name', 'clients.id', 'clients.client_code')
      //   ->orderBy('client_name', 'ASC')
      //   ->distinct()->get();

      // if you selected sturday date then offholydays client will be show otherwise not

      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
            $clientIds = [29, 32, 33, 34];
          } else {
            $clientIds = [29, 32, 34];
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }
      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientss->merge($clients);
    } else {

      $selectedDate = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);
      $selectedDate1 = \DateTime::createFromFormat('Y-m-d', $timesheetedit->date);

      $clientss = DB::table('assignmentteammappings')
        ->leftjoin('assignmentmappings', 'assignmentmappings.id', 'assignmentteammappings.assignmentmapping_id')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->orwhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
        ->whereNotIn('assignmentbudgetings.assignmentname', ['Unallocated', 'Official Travel', 'Off/Holiday', 'Seminar/Conference/Post Qualification Course'])
        ->where(function ($query) use ($selectedDate) {
          $query->whereNull('otpverifydate')
            ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
        })
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()->get();

      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      if ($holidaydatecheck) {
        $clientIds = [29, 32, 33, 34];
      } else {
        // if not holidays then go hare
        $dayOfWeek = $selectedDate1->format('w');
        if ($selectedDate1->format('l') == 'Saturday') {
          $dayOfMonth = $selectedDate1->format('j');
          // Calculate which Saturday of the month it is
          $saturdayNumber = ceil($dayOfMonth / 7);
          // offholiday client name will be show on 2nd and 4rth sturday
          if (auth()->user()->role_id == 14) {
            if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
              $clientIds = [29, 32, 33, 34];
            } else {
              $clientIds = [29, 32, 34];
            }
          } else {
            if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
              $clientIds = [29, 32, 33, 34];
            }
          }
        } else {
          $clientIds = [29, 32, 34];
        }
      }
      $clients = DB::table('clients')
        ->whereIn('id', $clientIds)
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->orderBy('client_name', 'ASC')
        ->distinct()
        ->get();

      $client = $clientss->merge($clients);
    }
    $assignment = Assignment::select('id', 'assignment_name')->get();
    return view('backEnd.timesheet.correction', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
  }

  public function timesheeteditstore(Request $request)
  {
    if (!is_numeric($request->assignment_id)) {
      $assignment = Assignmentmapping::where('assignmentgenerate_id', $request->assignment_id)
        ->select('assignment_id')
        ->first();
      // ->toArray();
      // $assignment_id = $assignment[0]['assignment_id'];
      $assignment_id = $assignment->assignment_id;
      $assignmentgenerateId = $request->assignment_id;
      $oldtimesheetdata = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
      // update total hour 

      if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {

        $gettotalteamhour = DB::table('assignmentmappings')
          ->leftJoin(
            'assignmentteammappings',
            'assignmentteammappings.assignmentmapping_id',
            'assignmentmappings.id',
          )
          ->where(
            'assignmentmappings.assignmentgenerate_id',
            $oldtimesheetdata->assignmentgenerate_id
          )
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->select('assignmentteammappings.*')
          ->first();



        $gettotalteamhournew = DB::table('assignmentmappings')
          ->leftJoin(
            'assignmentteammappings',
            'assignmentteammappings.assignmentmapping_id',
            'assignmentmappings.id',
          )
          ->where(
            'assignmentmappings.assignmentgenerate_id',
            $request->assignment_id
          )
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->select('assignmentteammappings.*')
          ->first();




        if ($gettotalteamhour) {
          if ($gettotalteamhour->teamhour == null) {
            $gettotalteamhour->teamhour = 0;
          }
          $finalresult =  $gettotalteamhour->teamhour - $request->hour;
          $totalteamhourupdate = DB::table('assignmentteammappings')
            ->where('id', $gettotalteamhour->id)
            // ->get();
            ->update(['teamhour' =>  $finalresult]);
        }
        if ($gettotalteamhournew) {
          if ($gettotalteamhournew->teamhour == null) {
            $gettotalteamhournew->teamhour = 0;
          }
          $finalresult =  $gettotalteamhournew->teamhour + $request->hour;
          $totalteamhourupdate = DB::table('assignmentteammappings')
            ->where('id', $gettotalteamhournew->id)
            // ->get();
            ->update(['teamhour' =>  $finalresult]);
        }
      }

      if (auth()->user()->role_id == 13) {
        $assignmentdata = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $assignmentgenerateId)
          ->first();
        $assignmentdataold = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
          ->first();

        // old assignment hour subtract 
        if ($assignmentdataold->leadpartner == auth()->user()->teammember_id) {
          if ($assignmentdataold->leadpartnerhour == null) {
            $assignmentdataold->leadpartnerhour = 0;
          }
          $finalresultleadpatner =  $assignmentdataold->leadpartnerhour + $oldtimesheetdata->hour;
          $totalteamhourupdate = DB::table('assignmentmappings')
            ->where('id', $assignmentdataold->id)
            // ->get();
            ->update(['leadpartnerhour' => $finalresultleadpatner]);
        }
        if ($assignmentdataold->otherpartner == auth()->user()->teammember_id) {
          if ($assignmentdataold->otherpartnerhour == null) {
            $assignmentdataold->otherpartnerhour = 0;
          }
          $finalresultotherpatner =  $assignmentdataold->otherpartnerhour - $oldtimesheetdata->hour;
          $totalteamhourupdate = DB::table('assignmentmappings')
            ->where('id', $assignmentdataold->id)
            // ->get();
            ->update(['otherpartnerhour' => $finalresultotherpatner]);
        }

        // new assignment hour add
        if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
          if ($assignmentdata->leadpartnerhour == null) {
            $assignmentdata->leadpartnerhour = 0;
          }
          $finalresultleadpatner =  $assignmentdata->leadpartnerhour + $request->hour;
          $totalteamhourupdate = DB::table('assignmentmappings')
            ->where('id', $assignmentdata->id)
            // ->get();
            ->update(['leadpartnerhour' => $finalresultleadpatner]);
        }
        if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
          if ($assignmentdata->otherpartnerhour == null) {
            $assignmentdata->otherpartnerhour = 0;
          }
          $finalresultotherpatner =  $assignmentdata->otherpartnerhour + $request->hour;
          $totalteamhourupdate = DB::table('assignmentmappings')
            ->where('id', $assignmentdata->id)
            // ->get();
            ->update(['otherpartnerhour' => $finalresultotherpatner]);
        }
      }
    }

    if (is_numeric($request->assignment_id)) {
      $assignment_id = $request->assignment_id;
      $getassignmentgenerateId = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
      $assignmentgenerateId = $getassignmentgenerateId->assignmentgenerate_id;

      $oldtimesheetdata = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
      // update total hour 
      if ($oldtimesheetdata->hour != $request->hour) {
        if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
          $gettotalteamhour = DB::table('assignmentmappings')
            ->leftJoin(
              'assignmentteammappings',
              'assignmentteammappings.assignmentmapping_id',
              'assignmentmappings.id',
            )
            ->where(
              'assignmentmappings.assignmentgenerate_id',
              $oldtimesheetdata->assignmentgenerate_id
            )
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->select('assignmentteammappings.*')
            ->first();
          if ($gettotalteamhour) {
            $totalteamhour = $gettotalteamhour->teamhour;
            $subtractoldhour =  $totalteamhour - $oldtimesheetdata->hour;
            $finalresult =  $subtractoldhour + $request->hour;

            $totalteamhourupdate = DB::table('assignmentteammappings')
              ->where('id', $gettotalteamhour->id)
              // ->get();
              ->update(['teamhour' =>  $finalresult]);
          }
        }
        if (auth()->user()->role_id == 13) {
          $assignmentdata = DB::table('assignmentmappings')
            ->where('assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
            ->first();

          if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
            $subtractoldhour =  $assignmentdata->leadpartnerhour - $oldtimesheetdata->hour;
            $finalresultleadpatner =  $subtractoldhour + $request->hour;
            $totalteamhourupdate = DB::table('assignmentmappings')
              ->where('id', $assignmentdata->id)
              // ->get();
              ->update(['leadpartnerhour' => $finalresultleadpatner]);
          }
          if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
            $subtractoldhour =  $assignmentdata->otherpartnerhour - $oldtimesheetdata->hour;
            $finalresultotherpatner =  $subtractoldhour + $request->hour;

            $totalteamhourupdate = DB::table('assignmentmappings')
              ->where('id', $assignmentdata->id)
              // ->get();
              ->update(['otherpartnerhour' => $finalresultotherpatner]);
          }
        }
      }
    }

    try {
      $timesheetdataupdate = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();

      // dd($assignmentgenerateId);
      DB::table('timesheets')->where('id', $timesheetdataupdate->timesheetid)->update([
        'status'   =>   3,
      ]);

      DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
        'status'   =>   3,
        'client_id'   =>  $request->client_id,
        'assignmentgenerate_id'   =>  $assignmentgenerateId,
        'assignment_id'   =>   $assignment_id,
        'partner'   =>  $request->partner,
        'workitem'   =>   $request->workitem,
        'createdby'   =>   $request->createdby,
        'location'   =>   $request->location,
        'hour'   =>   $request->hour,
      ]);

      if ($request->status == 2) {
        DB::table('timesheetupdatelogs')->insert([
          'timesheetusers_id'   =>  $request->timesheetusersid,
          'status'   =>   3,
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
  }


  public function timesheeteditonchange(Request $request)
  {
    if ($request->ajax()) {
      // dd($request);
      if (isset($request->cid)) {
        if (auth()->user()->role_id == 13) {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (
              DB::table('assignmentbudgetings')->where('client_id', $id)
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            // dd('hi 3');

            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (
              DB::table('assignmentbudgetings')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->where(function ($query) {
                  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        } else {
          echo "<option>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              // ->whereIn('id', [29, 32, 33, 34])
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();
            // dd($clients);
            $id = $clients[0]->id;
            foreach (
              DB::table('assignmentbudgetings')->where('client_id', $id)
                ->leftjoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          } else {
            //  i have add this code after kartic bindal problem 
            $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->datepickers);

            foreach (
              DB::table('assignmentbudgetings')
                ->join('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftjoin('assignments', 'assignments.id', 'assignmentmappings.assignment_id')
                ->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                //  ->where('assignmentteammappings.status', '!=', 0)
                // ->whereNull('assignmentteammappings.status')
                ->where(function ($query) {
                  $query->whereNull('assignmentteammappings.status')
                    ->orWhere('assignmentteammappings.status', '=', 1);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    //   ->orWhere('otpverifydate', '>=', $selectedDate);
                    // // ->orWhere('otpverifydate', '>=', $selectedDate);
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        }
      }

      if (isset($request->assignment)) {
        // dd($request->assignment);
        if (auth()->user()->role_id == 11) {
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('assignmentmappings')

              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } elseif (auth()->user()->role_id == 13) {
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('teammembers')
              ->where('id', auth()->user()->teammember_id)
              ->select('teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        } else {
          //die;
          echo "<option value=''>Select Partner</option>";
          foreach (
            DB::table('assignmentmappings')

              ->leftjoin('teammembers', 'teammembers.id', 'assignmentmappings.leadpartner')
              ->leftjoin('teammembers as team', 'team.id', 'assignmentmappings.otherpartner')
              ->where('assignmentmappings.assignmentgenerate_id', $request->assignment)
              ->select('team.team_member as team_member', 'team.id', 'teammembers.id', 'teammembers.team_member')
              ->get() as $subs
          ) {
            echo "<option value='" . $subs->id . "'>" . $subs->team_member . "</option>";
          }
        }
      }
    }
  }
  public function rejectedlist(Request $request)
  {
    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        // ->where('timesheetusers.status', 2)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->paginate(10);
      // dd($timesheetData);
    } else if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->get();
    } else {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->paginate(10);
      // dd($timesheetData);
    }
    // dd($timesheetData);
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  }

  // all rejected timesheet on patner for team
  public function rejectedlistteam(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->get();
    }
    // return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
    return view('backEnd.timesheet.rejectedlistteam', compact('timesheetData'));
  }

  // after rejectedlistteam()

  public function rejectedtimesheetlog(Request $request)
  {
    if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member')->orderBy('id', 'ASC')->get();
    }
    return view('backEnd.timesheet.rejectedlist', compact('timesheetData'));
  }

  public function  timesheetreject($id)
  {

    try {
      $timesheetdata = DB::table('timesheetusers')->where('id', $id)->first();
      DB::table('timesheets')->where('id', $timesheetdata->timesheetid)->update([
        'status'   => 2,
      ]);
      DB::table('timesheetusers')->where('id', $id)->update([
        'status'   => 2,
        'rejectedby'   =>   auth()->user()->teammember_id,

      ]);
      // timesheet rejected mail
      $data = DB::table('teammembers')
        ->leftjoin('timesheetusers', 'timesheetusers.createdby', 'teammembers.id')
        ->where('timesheetusers.id', $id)
        ->first();
      $emailData = [
        'emailid' => $data->emailid,
        'teammember_name' => $data->team_member,
      ];

      Mail::send('emails.timesheetrejected', $emailData, function ($msg) use ($emailData) {
        $msg->to([$emailData['emailid']]);
        $msg->subject('Timesheet rejected');
      });
      // timesheet rejected mail end hare


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
}

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
use Illuminate\Support\Facades\Auth;

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

      $roleId = auth()->user()->role_id;

      return response()->json([
        'holidayName' => $holidayname->holidayname ?? 'null',
        'saturday' => $saturday ?? 'null',
        'assignmentid' => $selectassignment->id,
        'assignmentgenerate_id' => $selectassignment->assignmentgenerate_id,
        'assignmentname' => $selectassignment->assignmentname,
        'assignment_name' => $selectassignment->assignment_name,
        'team_member' => $selectpartner->team_member,
        'team_memberid' => $selectpartner->id,
        'roleId' =>   $roleId,
      ]);
    }
  }

  public function mytimesheetlist(Request $request, $teamid)
  {

    if (auth()->user()->role_id == 13) {
      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC')
        ->limit(7)
        ->get();

      $timesheetData = $this->rejoinedOrPromotion($timesheetData);
    } else {
      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC')
        ->limit(7)
        ->get();

      $timesheetData = $this->rejoinedOrPromotion($timesheetData);
    }
    session()->forget('_old_input');
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
  }

  public function admintimesheetlist(Request $request)
  {
    session()->forget('_old_input');
    $teammembers = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      // ->where('teammembers.status', 1)
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
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname'));
  }

  public function totalworkingdays(Request $request, $teamid)
  {

    // total working days startfrom january to december 
    $currentDate = Carbon::now();
    $currentMonth = $currentDate->format('F');
    $startDate = Carbon::create($currentDate->year, 1, 1);
    $endDate = Carbon::create($currentDate->year, 12, 31);

    // $startDate = Carbon::create('01-04-2024');
    // $endDate = Carbon::create('30-09-2024');

    // $home = DB::table('timesheetusers')
    //   ->where('createdby', 847)
    //   ->whereIn('status', [1, 2, 3])
    //   ->whereNotIn('assignmentgenerate_id', ['OFF100004', 'OFF100003'])
    //   ->whereNotIn('client_id', [134])
    //   ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
    //   ->select('date') // Select only the date column
    //   ->distinct() // Apply distinct on the selected columns
    //   ->get();

    // dd($home);

    $promotionCheck = DB::table('teamrolehistory')
      ->where('teammember_id', $teamid)
      ->select('newstaff_code', 'created_at')
      ->first();

    $promotionorRejoinDate = $promotionCheck
      ? Carbon::parse($promotionCheck->created_at)->startOfDay()
      : null;

    // dd($attendancesstartDate);
    $query = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
        $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
          ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
      })
      ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
      })
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      // hide offholidays and travel timesheet
      ->whereNotIn('timesheetusers.assignmentgenerate_id', ['OFF100004', 'OFF100003'])
      // hide  casual leave and exam leave timesheet
      ->whereNotIn('timesheetusers.client_id', [134])
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcodee',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code as ptnrstaffcode',
        'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
        // 'assignmentbudgetings.created_at as assignmentcreateddate'
        'assignmentbudgetings.created_at as assignmentcreated'
      )
      ->orderBy('timesheetusers.date', 'DESC');

    // Apply filters for partner 
    if (auth()->user()->role_id == 13) {
    }

    $timesheetData = $query->get();

    $timesheetData = $this->promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate);

    return view('backEnd.timesheet.totalworkingdays', compact('timesheetData'));
  }


  public function totaltraveldays(Request $request, $teamid)
  {

    // total working days startfrom january to december 
    $currentDate = Carbon::now();
    $currentMonth = $currentDate->format('F');
    $startDate = Carbon::create($currentDate->year, 1, 1);
    $endDate = Carbon::create($currentDate->year, 12, 31);

    $promotionCheck = DB::table('teamrolehistory')
      ->where('teammember_id', $teamid)
      ->select('newstaff_code', 'created_at')
      ->first();

    $promotionorRejoinDate = $promotionCheck
      ? Carbon::parse($promotionCheck->created_at)->startOfDay()
      : null;

    $query = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
        $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
          ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
      })
      ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
      })
      ->where('timesheetusers.createdby', $teamid)
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereBetween('timesheetusers.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
      // Get only travel data
      ->whereIn('timesheetusers.assignmentgenerate_id', ['OFF100003'])
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcodee',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code as ptnrstaffcode',
        'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
        // 'assignmentbudgetings.created_at as assignmentcreateddate'
        'assignmentbudgetings.created_at as assignmentcreated'
      )
      ->orderBy('timesheetusers.date', 'DESC');

    // Apply role-specific filters if necessary
    if (auth()->user()->role_id == 13) {
      // Add any specific conditions or modifications for role_id 13 if needed.
    }

    $timesheetData = $query->get();

    $timesheetData = $this->promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate);

    return view('backEnd.timesheet.totaltraveldays', compact('timesheetData'));
  }



  // timesheet filtering function 

  public function searchingtimesheet(Request $request)
  {
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
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamId)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$startDate, $endDate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC');

      $timesheetData = $query->get();

      $timesheetData = $this->rejoinedOrPromotion($timesheetData);

      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
    // For staff and manager
    else {
      $query = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $teamId)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$startDate, $endDate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderBy('timesheetusers.date', 'DESC');

      $timesheetData = $query->get();

      $timesheetData = $this->rejoinedOrPromotion($timesheetData);
      // dd($timesheetData);
      $request->flash();
      return view('backEnd.timesheet.timesheetdownload', compact('timesheetData'));
    }
  }


  private function rejoinedOrPromotion($timesheetData)
  {
    $targetClients = [29, 34, 32, 33, 134];
    $createdbyIds = $timesheetData->pluck('createdby')->unique()->toArray();

    $promotionData = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $createdbyIds)
      ->select('teammember_id', 'newstaff_code', 'created_at')
      ->get()
      ->keyBy('teammember_id');

    $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();

    $promotionChecksPartner = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $partnerIds)
      ->select('teammember_id', 'newstaff_code', 'created_at')
      ->get()
      ->keyBy('teammember_id')
      ->map(fn($row) => [
        'newstaff_code' => $row->newstaff_code,
        'promotion_date' => Carbon::parse($row->created_at)->startOfDay(),
      ]);

    return $timesheetData->map(function ($row) use ($targetClients, $promotionData, $promotionChecksPartner) {

      $row->final_staffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';
      if (in_array($row->client_id, $targetClients) && $row->date) {
        $dataDate = Carbon::parse($row->date)->startOfDay();
        $promotion = $promotionData[$row->createdby] ?? null;
        if ($promotion && $dataDate->greaterThanOrEqualTo(Carbon::parse($promotion->created_at)->startOfDay())) {
          $row->final_staffcode = $promotion->newstaff_code;
        } else {
          $row->final_staffcode = $row->staffcode ?? '';
        }
      }

      $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
      if (in_array($row->client_id, $targetClients) && $row->date) {
        $dataDate = Carbon::parse($row->date)->startOfDay();
        $promotionPartner = $promotionChecksPartner->get($row->partner);
        if ($promotionPartner && $dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
          $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
        } else {
          $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
        }
      }
      return $row;
    });
  }


  // private function promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate)
  // {

  //   $targetClients = [29, 34, 32, 33, 134];
  //   $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();
  //   $promotionChecksPartner = DB::table('teamrolehistory')
  //     ->whereIn('teammember_id', $partnerIds)
  //     ->select('teammember_id', 'newstaff_code', 'created_at')
  //     ->get()
  //     ->keyBy('teammember_id')
  //     ->map(fn($row) => [
  //       'newstaff_code' => $row->newstaff_code,
  //       'promotion_date' => Carbon::parse($row->created_at)->startOfDay(),
  //     ]);

  //   return $timesheetData->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate, $promotionChecksPartner) {
  //     $row->final_teamstaffcode = $row->teamnewstaffcode ?? $row->staffcode ?? '';
  //     if (in_array($row->client_id, $targetClients) && $row->date) {
  //       $dataDate = Carbon::parse($row->date)->startOfDay();
  //       if ($promotionCheck && $dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
  //         $row->final_teamstaffcode = $promotionCheck->newstaff_code;
  //       } else {
  //         $row->final_teamstaffcode = $row->staffcode ?? '';
  //       }
  //     }

  //     $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
  //     if (in_array($row->client_id, $targetClients) && $row->date) {
  //       $dataDate = Carbon::parse($row->date)->startOfDay();
  //       $promotionPartner = $promotionChecksPartner->get($row->partner);
  //       if ($promotionPartner && $dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
  //         $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
  //       } else {
  //         $row->final_partnerstaffcode = $row->ptnrstaffcode ?? $row->patnerstaffcodee ?? '';
  //       }
  //     }

  //     return $row;
  //   });
  // }

  private function promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate)
  {
    // These are the client IDs that exist across rejoining periods
    $targetClients = [29, 34, 32, 33, 134];

    // Fetch promotion details for partners
    $partnerIds = $timesheetData->pluck('partner')->unique()->filter()->values();
    $promotionChecksPartner = DB::table('teamrolehistory')
      ->whereIn('teammember_id', $partnerIds)
      ->orderByDesc('created_at')
      ->select('teammember_id', 'newstaff_code', 'created_at')
      ->get()
      ->groupBy('teammember_id')
      ->map(function ($rows) {
        $latest = $rows->first();
        return [
          'newstaff_code' => $latest->newstaff_code,
          'promotion_date' => Carbon::parse($latest->created_at)->startOfDay(),
        ];
      });

    return $timesheetData->map(function ($row) use ($targetClients, $promotionCheck, $promotionorRejoinDate, $promotionChecksPartner) {
      $dataDate = Carbon::parse($row->date)->startOfDay();

      // ✅ TEAM STAFF CODE
      $row->final_teamstaffcode = $row->team_staffcode;

      if (in_array($row->client_id, $targetClients) && $promotionorRejoinDate) {
        // If date >= rejoin date, use new staffcode
        if ($dataDate->greaterThanOrEqualTo($promotionorRejoinDate)) {
          $row->final_teamstaffcode = $promotionCheck->newstaff_code;
        }
        // else keep existing (automatically from getStaffCodeAt)
      }

      // ✅ PARTNER STAFF CODE
      $row->final_partnerstaffcode = $row->partner_staffcode;
      $promotionPartner = $promotionChecksPartner->get($row->partner);

      if (in_array($row->client_id, $targetClients) && $promotionPartner) {
        if ($dataDate->greaterThanOrEqualTo($promotionPartner['promotion_date'])) {
          $row->final_partnerstaffcode = $promotionPartner['newstaff_code'];
        }
      }

      return $row;
    });
  }

  public function adminsearchtimesheet(Request $request)
  {
    if ($request->ajax()) {
      echo "<option value='null'>Select Assignment</option>";
      $assignments = DB::table('assignmentbudgetings')
        ->where('assignmentbudgetings.client_id', $request->cid)
        ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
        ->orderBy('assignment_name')
        ->get();

      foreach ($assignments as $sub) {
        echo "<option value='{$sub->assignmentgenerate_id}'>{$sub->assignment_name} ({$sub->assignmentname}) ({$sub->assignmentgenerate_id})</option>";
      }
      return;
    }

    $startDate = $request->input('startdate');
    $endDate = $request->input('enddate');
    $teamId = $request->input('teamid');
    $teammemberId = $request->input('teammemberId');
    $clientId = $request->input('clientId');
    $assignmentId = $request->input('assignmentId') !== 'null' ? $request->input('assignmentId') : null;


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
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->whereNotNull('assignmentbudgetings.assignmentname')
      ->select('timesheetusers.assignmentgenerate_id', 'assignmentbudgetings.assignmentname')
      ->distinct()
      ->orderBy('assignmentname', 'ASC')
      ->get();

    if (!in_array(auth()->user()->role_id, [11, 13])) {
      $output = array('msg' => 'Unauthorized access');
      return back()->with('statuss', $output);
    }

    // Base query
    $query = DB::table('timesheetusers')
      ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
      ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
        $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
          ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
      })
      ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
      ->leftJoin('teamrolehistory', function ($join) {
        $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
          ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
      })
      ->whereIn('timesheetusers.status', [1, 2, 3])
      ->select(
        'timesheetusers.*',
        'assignments.assignment_name',
        'clients.client_name',
        'clients.client_code',
        'teammembers.team_member',
        'teammembers.staffcode',
        'patnerid.team_member as patnername',
        'patnerid.staffcode as patnerstaffcodee',
        'assignmentbudgetings.assignmentname',
        'teamrolehistory.newstaff_code as ptnrstaffcode',
        'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
        'assignmentbudgetings.created_at as assignmentcreated'
      )
      ->orderBy('date', 'DESC');

    // if ($startDate && $endDate) {
    //   $query->whereBetween('timesheetusers.date', [$startDate, $endDate]);

    //   if ($teammemberId) {
    //     $query->where('timesheetusers.createdby', $teammemberId);
    //   } elseif ($clientId) {
    //     $query->where('timesheetusers.client_id', $clientId);
    //   } elseif ($assignmentId) {
    //     $query->where('timesheetusers.assignmentgenerate_id', $assignmentId);
    //   }
    // }

    if ($startDate && $endDate) {
      $query->whereBetween('timesheetusers.date', [$startDate, $endDate]);
      if ($teammemberId) {
        $query->where('timesheetusers.createdby', $teammemberId);
      }
      if ($clientId) {
        $query->where('timesheetusers.client_id', $clientId);
      }
      if ($assignmentId) {
        $query->where('timesheetusers.assignmentgenerate_id', $assignmentId);
      }
    }

    $timesheetData = $query->get();

    $timesheetData = $this->rejoinedOrPromotion($timesheetData);

    $request->flash();
    return view('backEnd.timesheet.timesheetdownload', compact('timesheetData', 'teammembers', 'clientsname', 'assignmentsname', 'assignmentId'));
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
    // die;
    $teammember = DB::table('teammembers')
      ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->select('teammembers.id', 'teammembers.team_member', 'teammembers.emailid', 'roles.rolename', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
      ->where('teammembers.status', '1')->distinct()->get();

    $month = collect([
      'January',
      'February',
      'March',
      'April',
      'May',
      'June',
      'July',
      'August',
      'September',
      'October',
      'November',
      'December'
    ]);

    $result = DB::table('timesheetusers')->select(DB::raw('YEAR(date) as year'))
      ->distinct()->orderBy('year', 'DESC')->limit(5)->get();

    $years = $result->pluck('year');

    $timesheetData = DB::table('timesheets')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheets.created_by')
      ->where('timesheets.status', 0)
      // ->where('timesheets.created_by', 780)
      ->select([
        'timesheets.*',
        'teammembers.team_member',
        'teammembers.staffcode'
      ])
      ->orderByDesc('timesheets.id')
      ->limit(20)
      ->get();


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
      // ->where('timesheetreport.teamid', 868)
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
        'emailid' => $firstItem->emailid,
        // Use newstaff_code if available, otherwise staffcode
        'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
        'partnerid' => $firstItem->partnerid,
      ];
    });

    $get_date = collect($groupedData->values());


    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }

  //! When we update this function from vsademo then please update partner varable becouse client wnt to hide admin name sukhbahadur
  public function timesheet_mylist()
  {
    if (auth()->user()->role_id == 13) {
      // die;
      $client = Client::select('id', 'client_name')->get();
      // $getauth =  DB::table('timesheetusers')
      //   ->where('createdby', auth()->user()->teammember_id)
      //   ->where('status', '0')
      //   ->orderby('id', 'desc')->first();

      // $getauth =  DB::table('timesheetusers')
      //   ->where('createdby', auth()->user()->teammember_id)
      //   ->where('status', '1')
      //   ->orderby('id', 'desc')->first();

      $getauth =  DB::table('timesheetusers')
        ->where('createdby', auth()->user()->teammember_id)
        ->where('status', '1')
        // Sort by date in descending order to get the most recent date
        ->orderBy('date', 'desc')
        ->first();

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
      // $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->where('team_member', '!=', 'Partner')->with('title')->get();

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
      // dd($timesheetrequest, 2);
      if ($getauthh  == null) {
        return view('backEnd.timesheet.firstindex', compact('timesheetData', 'getauth', 'client', 'partner'));
      } else {
        return view('backEnd.timesheet.index', compact('timesheetrequest', 'partner', 'client', 'getauth', 'dropdownMonths', 'timesheetData', 'year', 'dropdownYears', 'month', 'teammember', 'month', 'years'));
      }
    } else {

      // Get year like 2023.2024,2025
      $dropdownYears = DB::table('timesheets')
        ->where('created_by', auth()->user()->teammember_id)
        ->select(DB::raw('YEAR(date) as year'))
        ->distinct()->orderBy('year', 'DESC')->pluck('year');

      // Get months like january to december
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
        // this gatauth goes to backEnd.timesheet.index file
        // $getauth =  DB::table('timesheetusers')
        //   ->where('createdby', auth()->user()->teammember_id)
        //   ->where('date', '<=', $currentDateformate)
        //   ->where('status', '1')
        //   ->orderby('id', 'desc')->first();

        $getauth = DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('date', '<=', $currentDateformate)
          ->where('status', '1')
          // Sort by date in descending order to get the most recent date
          ->orderBy('date', 'desc')
          ->first();
      } else {

        // this gatauth goes to backEnd.timesheet.index file
        // $getauth =  DB::table('timesheetusers')
        //   ->where('createdby', auth()->user()->teammember_id)
        //   ->where('status', '0')
        //   ->orderby('id', 'desc')->first();

        $getauth =  DB::table('timesheetusers')
          ->where('createdby', auth()->user()->teammember_id)
          ->where('status', '0')
          ->orderBy('date', 'desc')
          ->first();
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

      // $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
      //   ->orderBy('team_member', 'asc')->get();

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
      $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
        ->orderBy('team_member', 'asc')->get();

      // $get_datess = DB::table('timesheetreport')
      //   ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      //   ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      //   ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
      //   // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
      //   ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.staffcode', 'partners.team_member as partnername')
      //   ->latest()->get();

      $get_datess = DB::table('timesheetreport')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
        })
        ->leftJoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->whereColumn('timesheetreport.teamid', '!=', 'timesheetreport.partnerid')
        ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.staffcode', 'partners.team_member as partnername', 'teammembers.emailid', 'teamrolehistory.newstaff_code')
        ->latest()
        ->get();

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
        ->select('timesheetreport.*', 'teammembers.team_member', 'teammembers.staffcode', 'partners.team_member as partnername', 'teammembers.emailid', 'teamrolehistory.newstaff_code')
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
        'emailid' => $firstItem->emailid,
        'week' => $firstItem->week,
        'totaldays' => $group->sum('totaldays'),
        'totaltime' => $group->sum('totaltime'),
        'dayscount' => $group->sum('dayscount'),
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

  // public function partnersubmitted()
  // {
  //   // Fetch timesheet data with necessary joins
  //   $get_datess = DB::table('timesheetreport')
  //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
  //     ->leftJoin('teamrolehistory', function ($join) {
  //       $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
  //         ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
  //     })
  //     ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select('timesheetreport.*', 'teamrolehistory.newstaff_code', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode')
  //     ->latest()
  //     ->get();

  //   // Fetch the first permission timesheet record for the authenticated user
  //   $permissiontimesheet = DB::table('timesheetreport')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->first();

  //   // Group data by week and map the necessary attributes
  //   $groupedData = $get_datess->groupBy('week')->map(function ($group) {
  //     $firstItem = $group->first();

  //     return (object)[
  //       'id' => $firstItem->id,
  //       'teamid' => $firstItem->teamid,
  //       'week' => $firstItem->week,
  //       'totaldays' => $group->sum('totaldays'),
  //       'totaltime' => $group->sum('totaltime'),
  //       'startdate' => $firstItem->startdate,
  //       'enddate' => $firstItem->enddate,
  //       'partnername' => $firstItem->partnername,
  //       'created_at' => $firstItem->created_at,
  //       'team_member' => $firstItem->team_member,
  //       'partnerid' => $firstItem->partnerid,
  //       'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
  //     ];
  //   });

  //   // Convert the grouped data to a collection
  //   $get_date = collect($groupedData->values());

  //   // Return the view with the grouped data and permission timesheet
  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  // }

  // public function partnersubmitted()
  // {
  //   $get_datess = DB::table('timesheetreport')
  //     ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
  //     ->leftJoin('teamrolehistory as trh', function ($join) {
  //       $join->on('trh.teammember_id', '=', 'teammembers.id')
  //         ->whereRaw('trh.created_at = (
  //                   SELECT MAX(trh2.created_at)
  //                   FROM teamrolehistory as trh2
  //                   WHERE trh2.teammember_id = teammembers.id
  //                     AND trh2.created_at < timesheetreport.created_at
  //               )');
  //     })
  //     ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select(
  //       'timesheetreport.*',
  //       'trh.newstaff_code',
  //       'teammembers.team_member',
  //       'partners.team_member as partnername',
  //       'teammembers.staffcode'
  //     )
  //     ->latest()
  //     ->get();

  //   // Fetch the first permission timesheet record for the authenticated user
  //   $permissiontimesheet = DB::table('timesheetreport')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->first();

  //   // Group data by week and map
  //   $groupedData = $get_datess->groupBy('week')->map(function ($group) {
  //     $firstItem = $group->first();

  //     return (object) [
  //       'id' => $firstItem->id,
  //       'teamid' => $firstItem->teamid,
  //       'week' => $firstItem->week,
  //       'totaldays' => $group->sum('totaldays'),
  //       'totaltime' => $group->sum('totaltime'),
  //       'startdate' => $firstItem->startdate,
  //       'enddate' => $firstItem->enddate,
  //       'partnername' => $firstItem->partnername,
  //       'created_at' => $firstItem->created_at,
  //       'team_member' => $firstItem->team_member,
  //       'partnerid' => $firstItem->partnerid,
  //       // ✅ pick latest staffcode correctly
  //       'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
  //     ];
  //   });

  //   $get_date = collect($groupedData->values());

  //   dd($get_date);

  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  // }

  // public function partnersubmitted()
  // {
  //   $get_datess = DB::table('timesheetreport')
  //     ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
  //     ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select(
  //       'timesheetreport.*',
  //       'teammembers.team_member',
  //       'partners.team_member as partnername',
  //       // Subquery to determine staffcode valid at timesheet.created_at
  //       DB::raw("(
  //               SELECT COALESCE(
  //                   -- 1) latest newstaff_code on or before timesheet.created_at
  //                   (SELECT tr1.newstaff_code
  //                    FROM teamrolehistory tr1
  //                    WHERE tr1.teammember_id = timesheetreport.teamid
  //                      AND tr1.created_at <= timesheetreport.created_at
  //                    ORDER BY tr1.created_at DESC
  //                    LIMIT 1),
  //                   -- 2) if no previous record, take earliest oldstaff_code AFTER timesheet.created_at
  //                   (SELECT tr2.oldstaff_code
  //                    FROM teamrolehistory tr2
  //                    WHERE tr2.teammember_id = timesheetreport.teamid
  //                      AND tr2.created_at > timesheetreport.created_at
  //                    ORDER BY tr2.created_at ASC
  //                    LIMIT 1),
  //                   -- 3) fallback to current teammembers.staffcode
  //                   (SELECT tm.staffcode FROM teammembers tm WHERE tm.id = timesheetreport.teamid LIMIT 1)
  //               )
  //           ) as staffcode")
  //     )
  //     ->orderByDesc('timesheetreport.created_at')
  //     ->get();

  //   $permissiontimesheet = DB::table('timesheetreport')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->first();

  //   $groupedData = $get_datess->groupBy('week')->map(function ($group) {
  //     $firstItem = $group->first();

  //     return (object) [
  //       'id' => $firstItem->id,
  //       'teamid' => $firstItem->teamid,
  //       'week' => $firstItem->week,
  //       'totaldays' => $group->sum('totaldays'),
  //       'totaltime' => $group->sum('totaltime'),
  //       'startdate' => $firstItem->startdate,
  //       'enddate' => $firstItem->enddate,
  //       'partnername' => $firstItem->partnername,
  //       'created_at' => $firstItem->created_at,
  //       'team_member' => $firstItem->team_member,
  //       'partnerid' => $firstItem->partnerid,
  //       'staffcode' => $firstItem->staffcode,
  //     ];
  //   });

  //   $get_date = collect($groupedData->values());

  //   // dd($get_date); // debug if needed
  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  // }

  // public function partnersubmitted()
  // {
  //   $get_datess = DB::table('timesheetreport')
  //     ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
  //     ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
  //     ->orderByDesc('timesheetreport.created_at')
  //     ->get();

  //   // Add staffcode dynamically using the helper
  //   $get_datess = $get_datess->map(function ($item) {
  //     $item->staffcode = \App\Helpers\StaffCodeHelper::getStaffCodeAt($item->teamid, $item->created_at);
  //     return $item;
  //   });

  //   $permissiontimesheet = DB::table('timesheetreport')
  //     ->where('timesheetreport.teamid', auth()->user()->teammember_id)
  //     ->first();

  //   $groupedData = $get_datess->groupBy('week')->map(function ($group) {
  //     $firstItem = $group->first();

  //     return (object) [
  //       'id' => $firstItem->id,
  //       'teamid' => $firstItem->teamid,
  //       'week' => $firstItem->week,
  //       'totaldays' => $group->sum('totaldays'),
  //       'totaltime' => $group->sum('totaltime'),
  //       'startdate' => $firstItem->startdate,
  //       'enddate' => $firstItem->enddate,
  //       'partnername' => $firstItem->partnername,
  //       'created_at' => $firstItem->created_at,
  //       'team_member' => $firstItem->team_member,
  //       'partnerid' => $firstItem->partnerid,
  //       'staffcode' => $firstItem->staffcode,
  //     ];
  //   });

  //   $get_date = collect($groupedData->values());

  //   return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  // }

  public function partnersubmitted()
  {
    $get_datess = DB::table('timesheetreport')
      ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetreport.teamid')
      ->leftJoin('teammembers as partners', 'partners.id', '=', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->orderByDesc('timesheetreport.created_at')
      ->get();


    $get_datess = $get_datess->map(function ($item) {
      $item->staffcode = $this->getStaffCodeAt($item->teamid, $item->created_at);
      return $item;
    });

    $permissiontimesheet = DB::table('timesheetreport')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->first();

    $groupedData = $get_datess->groupBy('week')->map(function ($group) {
      $firstItem = $group->first();

      return (object) [
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
        'staffcode' => $firstItem->staffcode,
      ];
    });

    $get_date = collect($groupedData->values());

    return view('backEnd.timesheet.myteamindex', compact('get_date', 'permissiontimesheet'));
  }


  public function getStaffCodeAt($teammember_id, $date)
  {
    // Get the latest newstaff_code before or equal to the given date
    $newCode = DB::table('teamrolehistory')
      ->where('teammember_id', $teammember_id)
      ->where('created_at', '<=', $date)
      ->orderByDesc('created_at')
      ->value('newstaff_code');

    if ($newCode) {
      return $newCode;
    }

    // If not found, get the next oldstaff_code after the date
    $oldCode = DB::table('teamrolehistory')
      ->where('teammember_id', $teammember_id)
      ->where('created_at', '>', $date)
      ->orderBy('created_at')
      ->value('oldstaff_code');

    if ($oldCode) {
      return $oldCode;
    }

    //if user not rejoined and promoted teammembers.staffcode
    return DB::table('teammembers')
      ->where('id', $teammember_id)
      ->value('staffcode');
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

    $output = array('msg' => 'We have sent the Excel file successfully on mail');
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
    // Fetch the user's status
    $checkuserstatus = DB::table('users')
      ->where('teammember_id', auth()->user()->teammember_id)
      ->where('status', 1)
      ->first();

    if (!$checkuserstatus) {
      Auth::logout();
      return redirect()->route('login')->with('message', 'You have been logged out due to your account inactive.');
    }

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
      $timesheetData =  DB::table('timesheets')
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
    } elseif (auth()->user()->role_id == 11 || auth()->user()->role_id == 18) {
      $teammember = DB::table('teammembers')
        ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        ->select('teammembers.id', 'teammembers.team_member', 'teammembers.emailid', 'roles.rolename', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
        ->where('teammembers.status', '1')->distinct()->get();

      $month = collect([
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
      ]);

      $timesheetData = DB::table('timesheets')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheets.created_by')
        ->where('timesheets.created_by', $request->teammember)
        ->where('timesheets.month', $request->month)
        ->whereYear('timesheets.date', '=', $request->year)
        ->where('timesheets.status', '=', 0)
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



  // after optimize 
  public function assignmentHourShow()
  {
    // Fetch all necessary data with a single query per table
    session()->forget('_old_input');
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

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
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

      // if ($holidaydatecheck) {
      //   $clientIds = [29, 32, 33, 34];
      // } else {
      //   // if not holidays then go hare
      //   $dayOfWeek = $selectedDate1->format('w');
      //   if ($selectedDate1->format('l') == 'Saturday') {
      //     $dayOfMonth = $selectedDate1->format('j');
      //     // Calculate which Saturday of the month it is
      //     $saturdayNumber = ceil($dayOfMonth / 7);
      //     // offholiday client name will be show on 2nd and 4rth sturday
      //     if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
      //       $clientIds = [29, 32, 33, 34];
      //     } else {
      //       $clientIds = [29, 32, 34];
      //     }
      //   } else {
      //     $clientIds = [29, 32, 34];
      //   }
      // }

      $clientIds = [29, 32, 33, 34];

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

      $clientss = DB::table('clients')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.client_id', '=', 'clients.id')
        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'assignmentbudgetings.assignmentgenerate_id')
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->where('assignmentbudgetings.status', 1)
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
        })
        ->select('clients.client_name', 'clients.id', 'clients.client_code')
        ->distinct()
        ->orderBy('clients.client_name', 'ASC')
        ->get();

      $selectedDate1 = new \DateTime();
      $formattedDate = $selectedDate1->format('Y-m-d');
      $holidaydatecheck = DB::table('holidays')->where('startdate', $formattedDate)->select('holidayname')->first();

      // if ($holidaydatecheck) {
      //   $clientIds = [29, 32, 33, 34];
      // } else {
      //   // if not holidays then go hare
      //   $dayOfWeek = $selectedDate1->format('w');
      //   if ($selectedDate1->format('l') == 'Saturday') {
      //     $dayOfMonth = $selectedDate1->format('j');
      //     // Calculate which Saturday of the month it is
      //     $saturdayNumber = ceil($dayOfMonth / 7);
      //     // offholiday client name will be show on 2nd and 4rth sturday
      //     if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
      //       $clientIds = [29, 32, 33, 34];
      //     } else {
      //       $clientIds = [29, 32, 34];
      //     }
      //   } else {
      //     $clientIds = [29, 32, 34];
      //   }
      // }
      $clientIds = [29, 32, 33, 34];

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

      // if ($holidaydatecheck) {
      //   $clientIds = [29, 32, 33, 34];
      // } else {
      //   // if not holidays then go hare
      //   $dayOfWeek = $selectedDate1->format('w');
      //   if ($selectedDate1->format('l') == 'Saturday') {
      //     $dayOfMonth = $selectedDate1->format('j');
      //     // Calculate which Saturday of the month it is
      //     $saturdayNumber = ceil($dayOfMonth / 7);
      //     // offholiday client name will be show on 2nd and 4rth sturday
      //     if (auth()->user()->role_id == 14) {
      //       if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
      //         $clientIds = [29, 32, 33, 34];
      //       } else {
      //         $clientIds = [29, 32, 34];
      //       }
      //     } else {
      //       if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
      //         $clientIds = [29, 32, 33, 34];
      //       }
      //     }
      //   } else {
      //     $clientIds = [29, 32, 34];
      //   }
      // }
      $clientIds = [29, 32, 33, 34];

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

      if (isset($request->timesheetdate)) {
        if ($permotioncheck && auth()->user()->role_id == 13) {
          echo "<option value=''>Select Client</option>";

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

          // if ($holidaydatecheck) {
          //   $clientIds = [29, 32, 33, 34];
          // } else {
          //   // if not holidays then go hare
          //   $dayOfWeek = $selectedDate1->format('w');
          //   if ($selectedDate1->format('l') == 'Saturday') {
          //     $dayOfMonth = $selectedDate1->format('j');
          //     // Calculate which Saturday of the month it is
          //     $saturdayNumber = ceil($dayOfMonth / 7);
          //     // offholiday client name will be show on 2nd and 4rth sturday
          //     if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
          //       $clientIds = [29, 32, 33, 34];
          //     } else {
          //       $clientIds = [29, 32, 34];
          //     }
          //   } else {
          //     $clientIds = [29, 32, 34];
          //   }
          // }

          $clientIds = [29, 32, 33, 34];
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
          echo "<option value=''>Select Client</option>";

          $selectedDate = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);
          $selectedDate1 = \DateTime::createFromFormat('d-m-Y', $request->timesheetdate);

          $clientss = DB::table('assignmentmappings')
            ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'assignmentmappings.assignmentgenerate_id')
            ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
            ->where(function ($query) {
              $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
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

          // if ($holidaydatecheck) {
          //   $clientIds = [29, 32, 33, 34];
          // } else {
          //   // if not holidays then go hare
          //   $dayOfWeek = $selectedDate1->format('w');
          //   if ($selectedDate1->format('l') == 'Saturday') {
          //     $dayOfMonth = $selectedDate1->format('j');
          //     // Calculate which Saturday of the month it is
          //     $saturdayNumber = ceil($dayOfMonth / 7);
          //     // offholiday client name will be show on 2nd and 4rth sturday
          //     if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
          //       $clientIds = [29, 32, 33, 34];
          //     } else {
          //       $clientIds = [29, 32, 34];
          //     }
          //   } else {
          //     $clientIds = [29, 32, 34];
          //   }
          // }

          $clientIds = [29, 32, 33, 34];

          $clients = DB::table('clients')
            ->whereIn('id', $clientIds)
            ->select('clients.client_name', 'clients.id', 'clients.client_code')
            ->orderBy('client_name', 'ASC')
            ->distinct()
            ->get();

          $client = $clientss->merge($clients);

          // foreach ($client as $clients) {
          //   if ($clients->client_name !== 'Official Travel') {
          //     echo "<option value='" . $clients->id . "'>" . $clients->client_name . ' ( ' . $clients->client_code . ' )' . "</option>";
          //   }
          // }

          foreach ($client as $clients) {
            echo "<option value='" . $clients->id . "'>" . $clients->client_name . '( ' . $clients->client_code . ' )' . "</option>";
          }
        } else {

          echo "<option value=''>Select Client</option>";

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

          // if ($holidaydatecheck) {
          //   $clientIds = [29, 32, 33, 34];
          // } else {
          //   // if not holidays then go hare
          //   $dayOfWeek = $selectedDate1->format('w');
          //   if ($selectedDate1->format('l') == 'Saturday') {
          //     $dayOfMonth = $selectedDate1->format('j');
          //     // Calculate which Saturday of the month it is
          //     $saturdayNumber = ceil($dayOfMonth / 7);
          //     // offholiday client name will be show on 2nd and 4rth sturday
          //     if (auth()->user()->role_id == 14) {
          //       if ($saturdayNumber == 2.0 || $saturdayNumber == 4.0) {
          //         $clientIds = [29, 32, 33, 34];
          //       } else {
          //         $clientIds = [29, 32, 34];
          //       }
          //     } else {
          //       if ($saturdayNumber == 1.0 || $saturdayNumber == 2.0 || $saturdayNumber == 3.0 || $saturdayNumber == 4.0 || $saturdayNumber == 5.0) {
          //         $clientIds = [29, 32, 33, 34];
          //       }
          //     }
          //   } else {
          //     $clientIds = [29, 32, 34];
          //   }
          // }

          $clientIds = [29, 32, 33, 34];
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
          echo "<option value=''>Select Assignment</option>";

          if ($request->cid == 29 || $request->cid == 32 || $request->cid == 33 || $request->cid == 34) {
            $clients = DB::table('clients')
              ->where('id', $request->cid)
              ->select('clients.client_name', 'clients.id', 'clients.client_code')
              ->orderBy('client_name', 'ASC')
              ->distinct()->get();

            $id = $clients[0]->id;
            $assignments = DB::table('assignmentbudgetings')
              ->where('client_id', $id)
              ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
              ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname')
              ->orderBy('assignments.assignment_name')
              ->get();
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
        } elseif (auth()->user()->role_id == 13) {

          echo "<option value=''>Select Assignment</option>";
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
            // dd($selectedDate);
            foreach (
              DB::table('assignmentbudgetings')
                ->select(
                  'assignmentbudgetings.assignmentgenerate_id',
                  'assignments.assignment_name',
                  'assignmentbudgetings.assignmentname'
                )
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where(function ($query) {
                  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')
                ->distinct() // Ensure unique rows
                ->get() as $sub
            ) {
              echo "<option value='" . $sub->assignmentgenerate_id . "'>" . $sub->assignment_name . '( ' . $sub->assignmentname . '/' . $sub->assignmentgenerate_id . ' )' . "</option>";
            }
          }
        } else {

          echo "<option value=''>Select Assignment</option>";

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

      $authUserId = auth()->user()->teammember_id;

      // Fetch common data
      $lasttimesheetsubmiteddata = DB::table('timesheetreport')
        ->where('teamid', $authUserId)
        ->latest()
        ->first();

      $datanotexistaftermonday = null;
      if ($lasttimesheetsubmiteddata) {
        $carbondate = Carbon::parse($lasttimesheetsubmiteddata->enddate);
        $nextMonday = $carbondate->copy()->next(Carbon::MONDAY);
        $timesheetRecordcheck = DB::table('timesheetusers')
          ->where('status', '0')
          ->where('createdby', $authUserId)
          ->where('date', $nextMonday->format('Y-m-d'))
          ->exists();

        if (!$timesheetRecordcheck) {
          $datanotexistaftermonday = $nextMonday->format('Y-m-d');
        }
      }

      $timesheetmaxDateRecord = DB::table('timesheetusers')
        ->where('status', '0')
        ->where('createdby', $authUserId)
        ->orderBy('date', 'desc')
        ->get();



      // Available dates extract hare
      $availableDates = $timesheetmaxDateRecord->pluck('date')->toArray();

      $dateSelectionresult = null;
      if (!empty($availableDates)) {
        // Min aur Max Date get
        $minDate = Carbon::parse(min($availableDates));
        $maxDate = Carbon::parse(max($availableDates));

        // Continuous date range generate
        $allDates = [];
        while ($minDate->lte($maxDate)) {
          $allDates[] = $minDate->toDateString();
          $minDate->addDay();
        }

        // dd($availableDates);
        // Missing dates find
        $missingDates = array_diff($allDates, $availableDates);
        // First missing date get hare
        $dateSelectionresult = reset($missingDates);

        if (!$dateSelectionresult) {
          $decrementonedays = $maxDate->copy()->addDay()->toDateString();
          $dateSelectionresult = $decrementonedays;
        }
      }

      // Fetch rejoining data
      $rejoiningdate = $this->getRejoiningDate($authUserId, $lasttimesheetsubmiteddata);


      $newteammember = null;
      if (!$lasttimesheetsubmiteddata) {
        // Fetch new team member joining date
        $newteammember = DB::table('teammembers')
          ->where('id', $authUserId)
          ->value('joining_date');
      }

      return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner', 'timesheetrejectData', 'lasttimesheetsubmiteddata', 'timesheetmaxDateRecord', 'newteammember', 'rejoiningdate', 'dateSelectionresult', 'datanotexistaftermonday'));
    }
  }

  public function filterleavedata(Request $request)
  {
    $start = Carbon::createFromFormat('d-m-Y', $request->start_date)->format('Y-m-d');
    $end = Carbon::createFromFormat('d-m-Y', $request->end_date)->format('Y-m-d');
    // dd('djd');

    $dates = DB::table('timesheetusers')
      ->where('status', '0')
      ->where('client_id', 134)
      ->where('createdby', auth()->user()->teammember_id)
      ->whereBetween('date', [$start, $end])
      ->pluck('date')
      ->map(function ($date) {
        return Carbon::parse($date)->format('d-m-Y');
      });
    // dd($dates);

    return response()->json($dates);
  }

  private function getRejoiningDate($userId, $lasttimesheetsubmiteddata)
  {
    $rejoiningData = DB::table('teammembers')
      ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
      ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
      ->where('teammembers.id', $userId)
      ->select('teamrolehistory.rejoiningdate', 'rejoiningsamepost.rejoiningdate as samepostrejoiningdate')
      ->first();

    if ($rejoiningData) {
      $rejoiningDateStore = $rejoiningData->samepostrejoiningdate ?? $rejoiningData->rejoiningdate;

      if ($rejoiningDateStore && $lasttimesheetsubmiteddata) {
        $rejoiningdate = Carbon::parse($rejoiningDateStore);
        $lastSubmissionDate = Carbon::parse($lasttimesheetsubmiteddata->enddate);

        return $rejoiningdate->greaterThan($lastSubmissionDate) ? $rejoiningDateStore : null;
      }
    }

    return null;
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

      $joiningDate = $pormotionandrejoiningdata->joining_date ? Carbon::parse($pormotionandrejoiningdata->joining_date) : null;
      $rejoiningDateRaw = $pormotionandrejoiningdata->rejoiningdate ?? $pormotionandrejoiningdata->samepostrejoiningdate;
      $rejoiningDate = $rejoiningDateRaw ? Carbon::parse($rejoiningDateRaw) : null;
      $requestDate = Carbon::parse($request->day1);

      // hare only created timesheet before joinig date like NA
      if (!$Newteammeber || $rejoiningDate) {
        if ($rejoiningDate && $requestDate < $rejoiningDate) {
          return redirect('timesheet/mylist')->with('statuss', ['msg' => 'You can not fill timesheet before Rejoining date : ' . $rejoiningDate->format('d-m-Y')]);
        }

        if ($joiningDate && $requestDate < $joiningDate) {
          return redirect('timesheet/mylist')->with('statuss', ['msg' => 'You can not fill timesheet before Joining date : ' . $joiningDate->format('d-m-Y')]);
        }

        // Determine base date
        $baseDate = $rejoiningDate ?? $joiningDate;
        $previousSunday = $baseDate->copy()->startOfWeek(Carbon::SUNDAY);
        $period = CarbonPeriod::create($previousSunday, $baseDate);

        $datesToInsert = collect($period)->slice(1, -1); // skip first and last day

        foreach ($datesToInsert as $date) {
          $dateString = $date->toDateString();

          $alreadyExists = DB::table('timesheets')
            ->where('date', $dateString)
            ->where('created_by', auth()->user()->teammember_id)
            ->exists();

          if (!$alreadyExists) {
            $timesheetId = DB::table('timesheets')->insertGetId([
              'created_by' => auth()->user()->teammember_id,
              'month' => $date->format('F'),
              'date' => $dateString,
              'created_at' => now(),
            ]);

            DB::table('timesheetusers')->insert([
              'date' => $dateString,
              'client_id' => 29,
              'workitem' => 'NA',
              'location' => 'NA',
              'timesheetid' => $timesheetId,
              'hour' => 0,
              'totalhour' => 0,
              'assignment_id' => 213,
              'partner' => 887,
              'createdby' => auth()->user()->teammember_id,
              'created_at' => now(),
              'updated_at' => now(),
            ]);
          }
        }
      }


      if ($requestDate >= $joiningDate) {
        if ($rejoiningDate && $requestDate < $rejoiningDate) {
          return redirect('timesheet')->with('success', ['msg' => 'You can not fill timesheet before Rejoining date : ' . $rejoiningDate->format('d-m-Y')]);
        }

        $data = $request->except(['_token', 'teammember_id', 'amount']);

        // insert data in timesheet and timesheetusers table 
        for ($j = 1; $j <= 7; $j++) {
          $dayKey = 'day' . $j;
          if (!isset($request->$dayKey)) {
            continue;
          }
          // dd($request->$dayKey);
          // check allready submited
          if (date('w', strtotime($request->$dayKey)) == 0) {
            $previousSaturday = date('Y-m-d', strtotime('-1 day', strtotime($request->$dayKey)));
            $previousSaturdayFilled = DB::table('timesheetusers')
              ->where('createdby', auth()->user()->teammember_id)
              ->where('date', $previousSaturday)
              ->where('status', 1)
              ->first();

            if ($previousSaturdayFilled != null) {
              $output = array('msg' => 'You already submitted for this week');
              return back()->with('success', $output);
            }
          }

          $previouschck = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('date', date('Y-m-d', strtotime($request->$dayKey)))
            ->where('status', 1)
            ->first();

          if ($previouschck != null) {
            $output = array('msg' => 'You already submitted for this week');
            return back()->with('success', $output);
          }

          $previoussavechck = DB::table('timesheetusers')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('date', date('Y-m-d', strtotime($request->$dayKey)))
            ->where('status', 0)
            ->first();

          if ($previoussavechck != null) {
            $output = array('msg' => 'You already submitted for this date');
            return back()->with('success', $output);
          }

          // today timesheet validation 
          $timesheetAccess = DB::table('teammembers')
            ->where('id', auth()->user()->teammember_id)
            ->value('timesheet_access');

          $currentDate = Carbon::now()->format('d-m-Y');
          // $currentDate = "07-03-2025";

          if ($timesheetAccess == 0  && $currentDate == $request->$dayKey && Carbon::now()->hour < 18) {
            $output = array('msg' => 'You can only fill today timesheet after 6:00 pm');
            return back()->with('success', $output);
          }

          // Exam leave validation  optimized code 
          $leaves = DB::table('applyleaves')
            ->where('createdby', auth()->user()->teammember_id)
            ->where('status', '!=', 2)
            ->select('from', 'to')
            ->get();

          $currentday = Carbon::parse($request->$dayKey)->format('Y-m-d');

          // Proceed only if leaves exist
          if (!$leaves->isEmpty()) {
            foreach ($leaves as $leave) {
              $start = Carbon::parse($leave->from);
              $end = Carbon::parse($leave->to);

              if ($currentday >= $start->format('Y-m-d') && $currentday <= $end->format('Y-m-d')) {
                $output = array('msg' => 'You Have Leave for the Day (' . Carbon::parse($currentday)->format('d-m-Y') . '). Please Approved/Reject leave');
                return redirect('timesheet')->with('statuss', $output);
              }
            }
          }
          // Exam leave validation ends here

          $id = DB::table('timesheets')->insertGetId([
            'created_by' => auth()->user()->teammember_id,
            'month' => date('F', strtotime($request->$dayKey)),
            'date' => date('Y-m-d', strtotime($request->$dayKey)),
            'created_at' => now(),
            'updated_at' => now(),
          ]);

          $count = count($request->{'assignment_id' . $j});
          for ($k = 0; $k < $count; $k++) {
            $assignment = DB::table('assignmentmappings')->where('assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])->first();

            DB::table('timesheetusers')->insert([
              'date' => date('Y-m-d', strtotime($request->$dayKey)),
              'client_id' => $request->{'client_id' . $j}[$k],
              'assignmentgenerate_id' => $request->{'assignment_id' . $j}[$k],
              'workitem' => $request->{'workitem' . $j}[$k],
              'location' => $request->{'location' . $j}[$k],
              'timesheetid' => $id,
              'hour' => $request->{'hour' . $j}[$k],
              'totalhour' => $request->{'totalhour' . $j},
              'assignment_id' => $assignment->assignment_id ?? null,
              'partner' => $request->{'partner' . $j}[$k],
              'createdby' => auth()->user()->teammember_id,
              'created_at' => now(),
              'updated_at' => now(),
            ]);

            // total hour update
            if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
              $getTotalTeamHour = DB::table('assignmentteammappings')
                ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where('assignmentmappings.assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                ->value('teamhour') ?? 0;

              $finalResult = $getTotalTeamHour + $request->{'hour' . $j}[$k];

              DB::table('assignmentteammappings')
                ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where('assignmentmappings.assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                ->update(['teamhour' => $finalResult]);
            }

            if (auth()->user()->role_id == 13) {

              $assignmentdata = DB::table('assignmentmappings')
                ->where('assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                ->first();

              $finalresultleadpatner =  $assignmentdata->leadpartnerhour + $request->{'hour' . $j}[$k];
              $finalresultotherpatner =  $assignmentdata->otherpartnerhour + $request->{'hour' . $j}[$k];

              if ($assignmentdata->leadpartner == auth()->user()->teammember_id) {
                $update = DB::table('assignmentmappings')
                  ->where('assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                  ->where('leadpartner', auth()->user()->teammember_id)
                  ->update(['leadpartnerhour' => $finalresultleadpatner]);
              }
              if ($assignmentdata->otherpartner == auth()->user()->teammember_id) {
                $update = DB::table('assignmentmappings')
                  ->where('assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                  ->where('otherpartner', auth()->user()->teammember_id)
                  ->update(['otherpartnerhour' => $finalresultotherpatner]);
              }

              if ($assignmentdata->otherpartner != auth()->user()->teammember_id && $assignmentdata->leadpartner != auth()->user()->teammember_id) {
                $getTotalTeamHour = DB::table('assignmentteammappings')
                  ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                  ->where('assignmentmappings.assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                  ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                  ->value('teamhour') ?? 0;

                $finalResult = $getTotalTeamHour + $request->{'hour' . $j}[$k];

                DB::table('assignmentteammappings')
                  ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                  ->where('assignmentmappings.assignmentgenerate_id', $request->{'assignment_id' . $j}[$k])
                  ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                  ->update(['teamhour' => $finalResult]);
              }
            }
          }
        }
        // dd('COMPLETED');
      } else {
        return redirect('timesheet')->with('success', ['msg' => 'You can not fill timesheet before Rejoining date : ' . $rejoiningDate->format('d-m-Y')]);
      }

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



  public function destroy(Request $request, $id)
  {
    try {
      $timesheetdelete = DB::table('timesheetusers')->where('timesheetid', $id)->first();
      // total hour update for staff and manager
      if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
        $getTotalTeamHour = DB::table('assignmentteammappings')
          ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
          ->where('assignmentmappings.assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->value('teamhour') ?? 0;

        $finalResult = $getTotalTeamHour - $timesheetdelete->hour;

        if ($finalResult >= 0) {
          DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->update(['teamhour' => $finalResult]);
        }
      }

      //total hour update for partner
      if (auth()->user()->role_id == 13) {
        // dd('cech');
        $assignmentdata = DB::table('assignmentmappings')
          ->where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
          ->first();

        //akhsay code

        $leadPartnerHour = $assignmentdata->leadpartnerhour; // Numeric value

        $timesheetHour = $timesheetdelete->hour; // Time string in "HH:MM" format

        // Split the timesheet hour (e.g., "08:00") into hours and minutes
        if (strpos($timesheetHour, ':') !== false) {


          // If the value contains a colon, split it into hours and minutes
          list($hours, $minutes) = explode(':', $timesheetHour);

          // Convert the time to decimal hours
          $timesheetDecimalHour = $hours + ($minutes / 60);
          $roundedHour = floor($timesheetDecimalHour);
          $roundedHour = (int)$roundedHour;
          // Perform the subtractiond
          // dd($leadPartnerHour);
          $finalresultleadpatner = $leadPartnerHour - $roundedHour;
          // dd($finalresultleadpatner);
          $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $roundedHour;
          // dd($finalresultotherpatner);

        } else {
          // dd('out');
          $finalresultleadpatner =  $assignmentdata->leadpartnerhour - $timesheetdelete->hour;
          $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $timesheetdelete->hour;
        }




        ///end aksshay code
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

        if ($assignmentdata->otherpartner != auth()->user()->teammember_id && $assignmentdata->leadpartner != auth()->user()->teammember_id) {
          $getTotalTeamHour = DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->value('teamhour') ?? 0;

          $finalResult = $getTotalTeamHour - $timesheetdelete->hour;

          if ($finalResult >= 0) {
            DB::table('assignmentteammappings')
              ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
              ->where('assignmentmappings.assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->update(['teamhour' => $finalResult]);
          }
        }
      }

      //total hour update for admin
      if (!is_numeric($timesheetdelete->assignmentgenerate_id)) {
        $assignment = Assignmentmapping::where('assignmentgenerate_id', $timesheetdelete->assignmentgenerate_id)
          ->select('assignment_id')
          ->first();
        // dd($timesheetdelete);
        $teammemberrole =  DB::table('teammembers')
          ->where('id', $timesheetdelete->createdby)
          ->select('team_member', 'role_id')
          ->first();

        $assignment_id = $assignment->assignment_id;
        $assignmentgenerateId = $timesheetdelete->assignmentgenerate_id;

        // update total hour 
        if (auth()->user()->role_id == 11) {
          if ($teammemberrole->role_id == 14 || $teammemberrole->role_id == 15) {
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
              ->where('assignmentteammappings.teammember_id', $timesheetdelete->createdby)
              ->select('assignmentteammappings.*')
              ->first();


            if ($gettotalteamhour) {
              if ($gettotalteamhour->teamhour == null) {
                $gettotalteamhour->teamhour = 0;
              }

              $finalresult =  $gettotalteamhour->teamhour - $timesheetdelete->hour;
              $totalteamhourupdate = DB::table('assignmentteammappings')
                ->where('id', $gettotalteamhour->id)
                ->update(['teamhour' =>  $finalresult]);
            }
          }

          if ($teammemberrole->role_id == 13) {
            $assignmentdata = DB::table('assignmentmappings')
              ->where('assignmentgenerate_id', $assignmentgenerateId)
              ->first();

            if ($assignmentdata->leadpartner == $timesheetdelete->createdby) {
              if ($assignmentdata->leadpartnerhour == null) {
                $assignmentdata->leadpartnerhour = 0;
              }

              $finalresultleadpatner =  $assignmentdata->leadpartnerhour - $timesheetdelete->hour;
              $totalteamhourupdate = DB::table('assignmentmappings')
                ->where('id', $assignmentdata->id)
                ->update(['leadpartnerhour' => $finalresultleadpatner]);
            }

            if ($assignmentdata->otherpartner == $timesheetdelete->createdby) {
              if ($assignmentdata->otherpartnerhour == null) {
                $assignmentdata->otherpartnerhour = 0;
              }
              $finalresultotherpatner =  $assignmentdata->otherpartnerhour - $timesheetdelete->hour;
              $totalteamhourupdate = DB::table('assignmentmappings')
                ->where('id', $assignmentdata->id)
                ->update(['otherpartnerhour' => $finalresultotherpatner]);
            }
          }
        }
      }
      //total hour update end hare 

      DB::table('timesheets')->where('id', $id)->delete();
      DB::table('timesheetusers')->where('timesheetid', $id)->delete();

      $actionName = class_basename($request->route()->getActionname());
      $pagename = substr($actionName, 0, strpos($actionName, "Controller"));
      $userId = auth()->user()->teammember_id;
      // dd('Saved Timesheet Delete: Date ( ' . $timesheetdelete->date . ', ' . $timesheetdelete->createdby . ')');
      DB::table('activitylogs')->insert([
        'user_id' => $userId,
        'ip_address' => $request->ip(),
        'activitytitle' => $pagename,
        'description' => 'Saved Timesheet Delete: Details ( ' . $timesheetdelete->date . ', ' . $timesheetdelete->createdby . ' )',
        'created_at' => now(),
        'updated_at' => now(),
      ]);

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
          $name = Teammember::where('id', auth()->user()->teammember_id)
            ->select('team_member', 'staffcode')
            ->first();

          $data = array(
            'teammember' => $name ?? '',
            'reason' => $request->reason ?? '',
            'created_at' => date('d-m-Y H:i:s'),
            'email' => $teammembermail ?? '',
            'id' => $id ?? '',
          );

          Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
            $msg->to($data['email']);
            $msg->cc('itsupport_delhi@vsa.co.in');
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
        $name = Teammember::where('id', auth()->user()->teammember_id)
          ->select('team_member', 'staffcode')
          ->first();

        $data = array(
          'teammember' => $name ?? '',
          'reason' => $request->reason ?? '',
          'created_at' => date('d-m-Y H:i:s'),
          'email' => $teammembermail ?? '',
          'id' => $id ?? '',
        );
        Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
          $msg->to($data['email']);
          $msg->cc('itsupport_delhi@vsa.co.in');
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

  public function savedtimesheetEdit(Request $request, $id)
  {
    $timesheetedit = DB::table('timesheetusers')
      ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
      // ->where('timesheetusers.timesheetid', $id)
      ->where('timesheetusers.id', $id)
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
        ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
        ->leftjoin('clients', 'clients.id', 'assignmentbudgetings.client_id')
        ->where(function ($query) {
          $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
            ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
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
    return view('backEnd.timesheet.savedtimesheetedit', compact('client', 'teammember', 'assignment', 'partner', 'timesheetedit'));
  }

  //! When we update this function from vsalocal then please update partner varable becouse client want to hide admin name sukhbahadur
  public function timesheetrequestform(Request $request, $id)
  {

    $timesheetrequestedit = DB::table('timesheetrequests')
      ->leftjoin('clients', 'clients.id', 'timesheetrequests.client_id')
      ->leftjoin('assignments', 'assignments.id', 'timesheetrequests.assignment_id')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetrequests.partner')
      ->leftjoin('teammembers as createdby', 'createdby.id', 'timesheetrequests.createdby')
      ->where('timesheetrequests.id', $id)
      ->select(
        'timesheetrequests.*',
        'clients.client_name',
        'clients.client_code',
        'assignments.assignment_name',
        'teammembers.team_member',
        'teammembers.staffcode',
        'createdby.team_member as createdbyauth',
        'createdby.staffcode as staffcodeid',
      )
      ->first();


    if (auth()->user()->role_id == 13) {
      // for vsalive 
      $partner = DB::table('teammembers')
        ->where('role_id', '=', 11)
        ->whereNotIn('id', [447])
        ->where('status', '=', 1)
        ->where('team_member', '!=', 'Partner')
        ->select('id', 'team_member', 'staffcode')
        ->get();

      // for vsademo 
      // $partner = Teammember::where('role_id', '=', 11)->where('status', '=', 1)->where('team_member', '!=', 'Partner')->with('title')->get();
    } else {
      // for vsalive 
      $partner = DB::table('teammembers')
        ->whereNotIn('id', [887, 663, 841, 836, 843, 447])
        ->where('role_id', '=', 13)
        ->where('status', '=', 1)
        ->select('id', 'team_member', 'staffcode')
        ->orderBy('team_member', 'asc')
        // ->distinct()
        ->get();

      // for vsademo 
      // $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
      //   ->orderBy('team_member', 'asc')->get();
    }

    // dd($timesheetrequestedit);
    return view('backEnd.timesheet.timesheetrequestedit', compact('timesheetrequestedit', 'partner'));
  }


  public function savedtimesheeteditstore(Request $request)
  {
    $oldtimesheetsubmiteddata = DB::table('timesheetusers')
      ->where('timesheetid', $request->timesheetid)
      ->where('createdby', $request->createdby)
      ->get();

    $SubmittedTimesheetHours = 0;
    if ($oldtimesheetsubmiteddata->count() >= 2) {
      $filteredData = $oldtimesheetsubmiteddata->reject(function ($item) use ($request) {
        return $item->id == $request->timesheetusersid;
      });

      $SubmittedTimesheetHours = $filteredData->whereIn('status', [0])->sum('hour');
    }

    $RejectedTimesheetHours = $request->input('hour');
    $RejectedTimesheetHours = (int)$RejectedTimesheetHours;
    $totalHours = $SubmittedTimesheetHours + $RejectedTimesheetHours;
    // Check if the total hours exceed the limit of 12
    if (!is_numeric($totalHours) || $totalHours > 12) {
      $output = ['msg' => 'The total hours cannot be greater than 12'];
      return back()->with('statuss', $output);
    }

    if (!is_numeric($request->assignment_id)) {
      $assignment = Assignmentmapping::where('assignmentgenerate_id', $request->assignment_id)
        ->select('assignment_id')
        ->first();
      // dd('hi');
      // ->toArray();
      // $assignment_id = $assignment[0]['assignment_id'];
      $assignment_id = $assignment->assignment_id;
      $assignmentgenerateId = $request->assignment_id;
      $oldtimesheetdata = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
      // update total hour 

      if (auth()->user()->role_id == 14 || auth()->user()->role_id == 15) {
        $gettotalteamhour = DB::table('assignmentteammappings')
          ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
          ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->value('teamhour') ?? 0;


        $finalresult =  $gettotalteamhour - $oldtimesheetdata->hour;
        if ($finalresult >= 0) {
          DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->update(['teamhour' => $finalresult]);
        }

        $gettotalteamhournew = DB::table('assignmentteammappings')
          ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id)
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->value('teamhour') ?? 0;

        $finalresult =   $gettotalteamhournew + $request->hour;

        if ($finalresult >= 0) {
          DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->update(['teamhour' => $finalresult]);
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
          $finalresultleadpatner =  $assignmentdataold->leadpartnerhour - $oldtimesheetdata->hour;
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

        // if ($assignmentdata->otherpartner != auth()->user()->teammember_id && $assignmentdata->leadpartner != auth()->user()->teammember_id) {
        $gettotalteamhour = DB::table('assignmentteammappings')
          ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
          ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->value('teamhour') ?? 0;


        $finalresult =  $gettotalteamhour - $oldtimesheetdata->hour;
        if ($finalresult >= 0) {
          DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->update(['teamhour' => $finalresult]);
        }

        $gettotalteamhournew = DB::table('assignmentteammappings')
          ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
          ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id)
          ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
          ->value('teamhour') ?? 0;

        $finalresult =   $gettotalteamhournew + $request->hour;

        if ($finalresult >= 0) {
          DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $request->assignment_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->update(['teamhour' => $finalresult]);
        }
        // }

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
          $gettotalteamhour = DB::table('assignmentteammappings')
            ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
            ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
            ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
            ->value('teamhour') ?? 0;

          $subtractoldhour =  $gettotalteamhour - $oldtimesheetdata->hour;
          $finalresult =  $subtractoldhour + $request->hour;

          if ($finalresult >= 0) {
            DB::table('assignmentteammappings')
              ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
              ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->update(['teamhour' => $finalresult]);
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

          if ($assignmentdata->otherpartner != auth()->user()->teammember_id && $assignmentdata->leadpartner != auth()->user()->teammember_id) {
            $gettotalteamhour = DB::table('assignmentteammappings')
              ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
              ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
              ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
              ->value('teamhour') ?? 0;

            $subtractoldhour =  $gettotalteamhour - $oldtimesheetdata->hour;
            $finalresult =  $subtractoldhour + $request->hour;

            if ($finalresult >= 0) {
              DB::table('assignmentteammappings')
                ->join('assignmentmappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where('assignmentmappings.assignmentgenerate_id', $oldtimesheetdata->assignmentgenerate_id)
                ->where('assignmentteammappings.teammember_id', auth()->user()->teammember_id)
                ->update(['teamhour' => $finalresult]);
            }
          }
        }
      }
    }

    try {
      $timesheetdataupdate = DB::table('timesheetusers')->where('id', $request->timesheetusersid)->first();
      DB::table('timesheets')->where('id', $timesheetdataupdate->timesheetid)->update([
        'status'   =>   0,
      ]);

      DB::table('timesheetusers')->where('id', $request->timesheetusersid)->update([
        'status'   =>   0,
        'client_id'   =>  $request->client_id,
        'assignmentgenerate_id'   =>  $assignmentgenerateId,
        'assignment_id'   =>   $assignment_id,
        'partner'   =>  $request->partner,
        'workitem'   =>   $request->workitem,
        'createdby'   =>   $request->createdby,
        'location'   =>   $request->location,
        'hour'   =>   $request->hour,
      ]);

      $output = array('msg' => 'Updated Successfully');
      return redirect()->to('timesheet/mylist')->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      $output = array('msg' => $e->getMessage());
      return back()->withErrors($output)->withInput();
    }
  }

  public function timesheetrequestupdate(Request $request)
  {
    try {
      $request->validate([
        'reason' => 'required',
        'file' => 'nullable|mimes:png,pdf,jpeg,jpg|max:5120',
      ], [
        'file.max' => 'The file may not be greater than 5 MB.',
      ]);

      $fileName =  $request->attachmentexist ?? null;
      if ($request->hasFile('file')) {
        // public\backEnd\image\confirmationfile
        $destinationPath = public_path('backEnd/image/confirmationfile');
        // Delete the existing file if it exists
        if ($request->attachmentexist) {
          $existingFilePath = $destinationPath . '/' . $request->attachmentexist;
          if (file_exists($existingFilePath)) {
            unlink($existingFilePath);
          }
        }
        // Process the new file upload
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
      }

      DB::table('timesheetrequests')
        ->where('id', $request->timesheetrequestid)
        ->update([
          'reason' => $request->reason,
          'partner' => $request->approver,
          'attachment' => $fileName,
          'updated_at' => date('Y-m-d H:i:s'),
        ]);

      // timesheet request mail to partner
      $teammembermail = Teammember::where('id', $request->approver)->pluck('emailid')->first();
      $name = Teammember::where('id', auth()->user()->teammember_id)
        ->select('team_member', 'staffcode')
        ->first();

      $data = array(
        'teammember' => $name ?? '',
        'reason' => $request->reason ?? '',
        'created_at' => date('d-m-Y H:i:s'),
        'email' => $teammembermail ?? '',
        'id' => $id ?? '',
      );

      Mail::send('emails.timesheetrequestform', $data, function ($msg) use ($data) {
        $msg->to($data['email']);
        // $msg->cc('itsupport_delhi@vsa.co.in');
        $msg->subject('Timesheet Submission Request has been Edited');
      });

      $output = array('msg' => 'Updated Successfully');
      return back()->with('success', $output);
    } catch (Exception $e) {
      DB::rollBack();
      Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
      report($e);
      return response()->json(['success' => false, 'msg' => $e->getMessage()]);
    }
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
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
        })
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
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
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
        })
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', auth()->user()->teammember_id)
        // ->whereJsonContains('timesheetreport.partnerid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
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
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
        })
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
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
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->on('teamrolehistory.created_at', '<', 'timesheetreport.created_at');
        })
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername', 'teammembers.staffcode', 'teamrolehistory.newstaff_code')
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
          'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
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
          'staffcode' => $firstItem->newstaff_code ?? $firstItem->staffcode,
          'partnerid' => $firstItem->partnerid,
        ];
      });

      $filteredData = collect($groupedData->values());
      return response()->json($filteredData);
    }
  }


  // public function weeklylist(Request $request)
  // {
  //   // dd($request);
  //   if (auth()->user()->role_id == 13) {
  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();

  //     $promotionCheck = DB::table('teamrolehistory')
  //       ->where('teammember_id', $request->teamid)
  //       ->select('newstaff_code', 'created_at')
  //       ->first();

  //     $promotionorRejoinDate = $promotionCheck
  //       ? Carbon::parse($promotionCheck->created_at)->startOfDay()
  //       : null;

  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //       ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
  //         $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
  //           ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
  //       })
  //       ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
  //       ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //       ->leftjoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //       ->leftJoin('teamrolehistory', function ($join) {
  //         $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
  //           ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
  //       })
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->whereNotNull('timesheetusers.date')
  //       ->where('timesheetusers.date', '>=', $date->startdate)
  //       ->where('timesheetusers.date', '<=', $date->enddate)
  //       ->select(
  //         'timesheetusers.*',
  //         'assignments.assignment_name',
  //         'clients.client_name',
  //         'clients.client_code',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'patnerid.team_member as patnername',
  //         'patnerid.staffcode as patnerstaffcodee',
  //         'assignmentbudgetings.assignmentname',
  //         'teamrolehistory.newstaff_code as ptnrstaffcode',
  //         'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
  //         'assignmentbudgetings.created_at as assignmentcreated'
  //       )
  //       // ->orderBy('timesheetusers.id', 'ASC')
  //       ->orderBy('timesheetusers.date', 'DESC')
  //       ->get();

  //     $timesheetData = $this->promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate);
  //   } else {
  //     $date = DB::table('timesheetreport')->where('id', $request->id)->first();

  //     $promotionCheck = DB::table('teamrolehistory')
  //       ->where('teammember_id', $request->teamid)
  //       ->select('newstaff_code', 'created_at')
  //       ->first();

  //     $promotionorRejoinDate = $promotionCheck
  //       ? Carbon::parse($promotionCheck->created_at)->startOfDay()
  //       : null;

  //     $timesheetData = DB::table('timesheetusers')
  //       ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
  //       ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
  //       ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
  //         $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
  //           ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
  //       })
  //       ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
  //       ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
  //       ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
  //       ->leftJoin('teamrolehistory', function ($join) {
  //         $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
  //           ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
  //       })
  //       ->where('timesheetusers.createdby', $request->teamid)
  //       ->whereIn('timesheetusers.status', [1, 2, 3])
  //       ->whereNotNull('timesheetusers.date')
  //       ->whereBetween('timesheetusers.date', [$date->startdate, $date->enddate])
  //       ->select(
  //         'timesheetusers.*',
  //         'assignments.assignment_name',
  //         'clients.client_name',
  //         'clients.client_code',
  //         'teammembers.team_member',
  //         'teammembers.staffcode',
  //         'patnerid.team_member as patnername',
  //         'patnerid.staffcode as patnerstaffcodee',
  //         'assignmentbudgetings.assignmentname',
  //         'teamrolehistory.newstaff_code as ptnrstaffcode',
  //         'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
  //         'assignmentbudgetings.created_at as assignmentcreated'
  //       )
  //       // ->orderBy('timesheetusers.id', 'ASC')
  //       ->orderBy('timesheetusers.date', 'DESC')
  //       ->get();

  //     $timesheetData = $this->promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate);
  //   }
  //   return view('backEnd.timesheet.weeklylist', compact('timesheetData'));
  // }

  public function weeklylist(Request $request)
  {
    // dd($request);
    if (auth()->user()->role_id == 13) {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();

      $promotionCheck = DB::table('teamrolehistory')
        ->where('teammember_id', $request->teamid)
        ->orderByDesc('created_at')
        ->select('newstaff_code', 'created_at')
        ->first();

      $promotionorRejoinDate = $promotionCheck
        ? Carbon::parse($promotionCheck->created_at)->startOfDay()
        : null;

      $date = (object)[
        'startdate' => $request->startdate,
        'enddate' => $request->enddate,
      ];

      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('clients', 'clients.id', '=', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', '=', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as partnerid', 'partnerid.id', '=', 'timesheetusers.partner')
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$date->startdate, $date->enddate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'partnerid.team_member as partnername',
          'assignmentbudgetings.assignmentname',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        ->orderByDesc('timesheetusers.date')
        ->get();

      // ✅ Apply dynamic staff code logic (simplified)
      $timesheetData = $timesheetData->map(function ($item) {
        $assignmentDate = $item->assignmentcreated ?? $item->date;

        $item->team_staffcode = $this->getStaffCodeAt($item->createdby, $assignmentDate);
        $item->partner_staffcode = $item->partner
          ? $this->getStaffCodeAt($item->partner, $assignmentDate)
          : null;

        return $item;
      });
      // ✅ Adjust staffcodes for rejoining/promotion logic
      $timesheetData = $this->promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate);
    } else {
      $date = DB::table('timesheetreport')->where('id', $request->id)->first();

      $promotionCheck = DB::table('teamrolehistory')
        ->where('teammember_id', $request->teamid)
        ->select('newstaff_code', 'created_at')
        ->first();

      $promotionorRejoinDate = $promotionCheck
        ? Carbon::parse($promotionCheck->created_at)->startOfDay()
        : null;

      $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->leftJoin('teamrolehistory as teamrolehistoryteam', function ($join) {
          $join->on('teamrolehistoryteam.teammember_id', '=', 'teammembers.id')
            ->whereRaw('teamrolehistoryteam.created_at < assignmentbudgetings.created_at');
        })
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as patnerid', 'patnerid.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', function ($join) {
          $join->on('teamrolehistory.teammember_id', '=', 'patnerid.id')
            ->whereRaw('teamrolehistory.created_at < assignmentbudgetings.created_at');
        })
        ->where('timesheetusers.createdby', $request->teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereNotNull('timesheetusers.date')
        ->whereBetween('timesheetusers.date', [$date->startdate, $date->enddate])
        ->select(
          'timesheetusers.*',
          'assignments.assignment_name',
          'clients.client_name',
          'clients.client_code',
          'teammembers.team_member',
          'teammembers.staffcode',
          'patnerid.team_member as patnername',
          'patnerid.staffcode as patnerstaffcodee',
          'assignmentbudgetings.assignmentname',
          'teamrolehistory.newstaff_code as ptnrstaffcode',
          'teamrolehistoryteam.newstaff_code as teamnewstaffcode',
          'assignmentbudgetings.created_at as assignmentcreated'
        )
        // ->orderBy('timesheetusers.id', 'ASC')
        ->orderBy('timesheetusers.date', 'DESC')
        ->get();

      $timesheetData = $this->promotionOrRejoined($timesheetData, $promotionCheck, $promotionorRejoinDate);
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
      // ->where('timesheetusers.timesheetid', $id)
      ->where('timesheetusers.id', $id)
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

  // after attendance


  public function timesheeteditstore(Request $request)
  {
    //akshay kumar

    $oldtimesheetsubmiteddata = DB::table('timesheetusers')
      ->where('timesheetid', $request->timesheetid)
      ->where('createdby', $request->createdby) // Assuming you are storing user ID
      ->get();

    // Calculate the total hours from previously submitted timesheets (status = 1)
    $SubmittedTimesheetHours = $oldtimesheetsubmiteddata->whereIn('status', [1, 3])->sum('hour');

    // Get the new rejected hours from the request
    $RejectedTimesheetHours = $request->input('hour');

    // Cast rejected hours to integer to ensure it's a numeric value
    $RejectedTimesheetHours = (int)$RejectedTimesheetHours;

    // Calculate the total hours by adding both submitted and rejected hours
    $totalHours = $SubmittedTimesheetHours + $RejectedTimesheetHours;
    // dd($request);


    // Check if the total hours exceed the limit of 12
    if (!is_numeric($totalHours) || $totalHours > 12) {

      $output = ['msg' => 'The total hours cannot be greater than 12'];
      return redirect('timesheetreject/edit/' . $request->timesheetusersid)->with('statuss', $output);
    }

    if (!is_numeric($request->assignment_id)) {
      $assignment = Assignmentmapping::where('assignmentgenerate_id', $request->assignment_id)
        ->select('assignment_id')
        ->first();
      // dd('hi');
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

          $finalresult =  $gettotalteamhour->teamhour - $oldtimesheetdata->hour;
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
          $finalresultleadpatner =  $assignmentdataold->leadpartnerhour - $oldtimesheetdata->hour;
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

      // Attendance code start hare 
      $hdatess = Carbon::parse($request->date)->format('Y-m-d');
      $day = Carbon::parse($hdatess)->format('d');
      $month = Carbon::parse($hdatess)->format('F');
      $yeardata = Carbon::parse($hdatess)->format('Y');

      $dates = [
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
        '26' => 'twentysix',
        '27' => 'twentyseven',
        '28' => 'twentyeight',
        '29' => 'twentynine',
        '30' => 'thirty',
        '31' => 'thirtyone',
      ];

      $column = $dates[$day];

      // check attendenace record exist or not 
      $attendances = DB::table('attendances')
        ->where('employee_name', $request->createdby)
        ->where('month', $month)
        ->first();


      if ($attendances && property_exists($attendances, $column)) {
        $checkwording = DB::table('attendances')
          ->where('id', $attendances->id)
          ->value($column);

        if ($checkwording == 'R') {
          $client = $request->client_id;
          // $assignmentid = $request->assignment_id;
          if (is_numeric($request->assignment_id)) {
            $assignmentid = $request->assignment_id;
          } else {
            $assignmentid = $assignment_id;
          }

          // Determine update wording based on client and assignment conditions
          // $updatewording = match (true) {
          //   // Travel
          //   $client == 32 => 'T',
          //   // Off holidays
          //   $client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday' => 'OH',
          //   // Other holidays from calendar
          //   $client == 33 => 'H',
          //   // Casual leave
          //   $client == 134 && $assignmentid == 215 => 'CL',
          //   // Exam leave
          //   $client == 134 && $assignmentid == 214 => 'EL',
          //     // Default presence
          //   default => 'P',
          // };


          if ($client == 32) {
            $updatewording = 'T'; // Travel
          } elseif ($client == 33 && str_replace(['1st ', '2nd ', '3rd ', '4th ', '5th '], '', $request->workitem) == 'Saturday') {
            $updatewording = 'OH'; // Off holidays
          } elseif ($client == 33) {
            $updatewording = 'H'; // Other holidays from calendar
          } elseif ($client == 134 && $assignmentid == 215) {
            $updatewording = 'CL'; // Casual leave
          } elseif ($client == 134 && $assignmentid == 214) {
            $updatewording = 'EL'; // Exam leave
          } else {
            $updatewording = 'P'; // Default presence
          }

          // Mapping for total count columns
          $totalCountMapping = [
            'P' => 'no_of_days_present',
            'CL' => 'casual_leave',
            'EL' => 'exam_leave',
            'T' => 'travel',
            'OH' => 'offholidays',
            'W' => 'sundaycount',
            'H' => 'holidays'
          ];

          // Update the total count and attendance record if applicable
          if (isset($totalCountMapping[$updatewording])) {
            $totalcountColumn = $totalCountMapping[$updatewording];
            $totalcountupdate = $attendances->$totalcountColumn + 1;
            DB::table('attendances')
              ->where('id', $attendances->id)
              ->update([
                $column => $updatewording,
                $totalcountColumn => $totalcountupdate,
              ]);
          }
        }
      }

      // dd('updated', 1);
      // Attendance code end hare 

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
                ->select('assignmentbudgetings.assignmentgenerate_id', 'assignments.assignment_name', 'assignmentbudgetings.assignmentname')
                ->where('assignmentbudgetings.client_id', $request->cid)
                ->leftJoin('assignments', 'assignments.id', 'assignmentbudgetings.assignment_id')
                ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', 'assignmentbudgetings.assignmentgenerate_id')
                ->leftJoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', '=', 'assignmentmappings.id')
                ->where(function ($query) {
                  $query->where('assignmentmappings.leadpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentmappings.otherpartner', auth()->user()->teammember_id)
                    ->orWhere('assignmentteammappings.teammember_id', auth()->user()->teammember_id);
                })
                ->where(function ($query) use ($selectedDate) {
                  $query->whereNull('otpverifydate')
                    ->orWhere('otpverifydate', '>=', $selectedDate->modify('-1 day'));
                })
                ->orderBy('assignment_name')
                ->distinct()
                ->get() as $sub
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
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        // ->where('timesheetusers.status', 2)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'assignmentbudgetings.assignmentname', 'teammembers.team_member', 'teammembers.staffcode')->orderBy('id', 'ASC')->get();
      // dd($timesheetData);
    } else if (auth()->user()->role_id == 11) {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->whereIn('timesheetusers.status', [2, 3])
        ->where('timesheetusers.rejectedby', auth()->user()->teammember_id)
        ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname', 'teammembers.staffcode')->orderBy('id', 'ASC')->get();
    } else {
      $timesheetData = DB::table('timesheetusers')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftjoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'timesheetusers.assignmentgenerate_id')
        ->where('timesheetusers.createdby', auth()->user()->teammember_id)
        ->whereIn('timesheetusers.status', [2, 3])
        ->select('timesheetusers.*', 'teammembers.team_member', 'assignmentbudgetings.assignmentname', 'teammembers.staffcode')->orderBy('id', 'ASC')->get();
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

  // after attendance 
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

      // Attendance code start hare 
      $hdatess = Carbon::parse($timesheetdata->date)->format('Y-m-d');
      $day = Carbon::parse($hdatess)->format('d');
      $month = Carbon::parse($hdatess)->format('F');
      $yeardata = Carbon::parse($hdatess)->format('Y');

      $dates = [
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
        '26' => 'twentysix',
        '27' => 'twentyseven',
        '28' => 'twentyeight',
        '29' => 'twentynine',
        '30' => 'thirty',
        '31' => 'thirtyone',
      ];
      $column = $dates[$day];

      // check attendenace record exist or not 
      $attendances = DB::table('attendances')
        ->where('employee_name', $timesheetdata->createdby)
        ->where('month', $month)
        ->first();

      if ($attendances != null) {
        if (property_exists($attendances, $column)) {
          $checkwording = DB::table('attendances')
            ->where('id', $attendances->id)
            ->value($column);

          $updatewording = 'R';

          // Get which column want to update 
          $totalCountmapping = [
            'P' => 'no_of_days_present',
            'CL' => 'casual_leave',
            'EL' => 'exam_leave',
            'T' => 'travel',
            'OH' => 'offholidays',
            'W' => 'sundaycount',
            'H' => 'holidays'
          ];

          if (isset($totalCountmapping[$checkwording])) {
            // Get Total count column name 
            $totalcountColumn = $totalCountmapping[$checkwording];
            // Get value and - 1 valve
            $totalcountupdate = $attendances->$totalcountColumn - 1;
            // Update the attendance record
            DB::table('attendances')
              ->where('id', $attendances->id)
              ->update([
                $column => $updatewording,
                $totalcountColumn => $totalcountupdate,
              ]);
          }
        }
      }
      // Attendance code end hare 
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

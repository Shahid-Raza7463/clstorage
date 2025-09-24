<?php

namespace App\Http\Controllers;

use App\Models\Teammember;
use App\Models\Timesheet;
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

class TimesheetController extends Controller
{
  //! web.php
  // filter on timesheet routes
  // Route::get('/filter-data', [TimesheetController::class, 'filterData']);

  public function partnersubmitted()
  {
    // get all partner
    $partner = Teammember::where('role_id', '=', 13)->where('status', '=', 1)->with('title')
      ->orderBy('team_member', 'asc')->get();

    // dd($partner);
    $get_date = DB::table('timesheetreport')
      ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
      ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
      ->where('timesheetreport.teamid', auth()->user()->teammember_id)
      ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
      ->latest()->get();
    // dd($get_date);
    // shahid
    return view('backEnd.timesheet.myteamindex', compact('get_date', 'partner'));
  }
  // filter on timesheet submitted 
  public function filterData(Request $request)
  {
    //  Patner filter
    $partnerId = $request->input('partnersearch');
    if ($partnerId) {
      $filteredData = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.partnerid', $partnerId)
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
      // shahid
      return response()->json($filteredData);
    }
    // date wise filter
    $searchdate = $request->input('searchdate');
    if ($searchdate) {
      $filteredData = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.week', $searchdate)
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
      // shahid
      return response()->json($filteredData);
    }
    //  total days wise filter
    $totaldays = $request->input('totaldays');
    if ($totaldays) {
      $filteredData = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.totaldays', $totaldays)
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
      // shahid
      return response()->json($filteredData);
    }
    //  total hour wise filter
    $totalhours = $request->input('totalhours');
    if ($totalhours) {
      $filteredData = DB::table('timesheetreport')
        ->leftjoin('teammembers', 'teammembers.id', 'timesheetreport.teamid')
        ->leftjoin('teammembers as partners', 'partners.id', 'timesheetreport.partnerid')
        ->where('timesheetreport.totaltime', $totalhours)
        ->where('timesheetreport.teamid', auth()->user()->teammember_id)
        ->select('timesheetreport.*', 'teammembers.team_member', 'partners.team_member as partnername')
        ->latest()->get();
      // shahid
      return response()->json($filteredData);
    }
  }
}

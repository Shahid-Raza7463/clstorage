<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Teammember;
use Carbon\Carbon;
use DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // public function index()
    // {
    //     //die;
    //     $currentMonth = date('F');
    //     $currentYear = date('Y');

    //     if (auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18 || auth()->user()->teammember_id == 157) {
    //         $attendanceDatass = DB::table('attendances')
    //             ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //             // ->where('teammembers.employment_status','Employee')
    //             ->whereNotIn('role_id', ['11', '12', '13', '15', '19', '20'])
    //             ->where('attendances.year', $currentYear)
    //             ->where('attendances.month', $currentMonth)
    //             ->whereNotIn('employee_name', ['170', '169', '307', '447', '336', '558', '418', '645', '549', '318', '660', '647', '685', '256'])
    //             ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')
    //             ->paginate(100);

    //         //dd($attendanceDatass);
    //         $attendanceDatasss = DB::table('attendances')
    //             ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //             ->where('teammembers.role_id', 19)
    //             ->where('attendances.year', $currentYear)
    //             ->where('attendances.month', $currentMonth)

    //             // ->where('teammembers.employment_status','Intern')
    //             ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')
    //             ->paginate(100);
    //         //dd($attendanceData);

    //         $supportstaffDatas  = DB::table('attendances')
    //             ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //             //->where('attendances.month',$request->month)
    //             ->where('attendances.year', $currentYear)
    //             ->where('attendances.month', $currentMonth)

    //             //	 ->where('attendances.year',$request->year)
    //             ->WhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647', '685', '256'])   //manual attendance - support staff
    //             ->select('attendances.*', 'teammembers.team_member', 'teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')
    //             ->get();



    //         $activitylogDatas = DB::table('activitylogs')
    //             ->leftJoin('teammembers', 'teammembers.id', '=', 'activitylogs.user_id')
    //             ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    //             ->whereIn('activitylogs.activitytitle', ['Attendance Updated'])
    //             ->select('activitylogs.*', 'teammembers.team_member', 'roles.rolename')
    //             ->latest()
    //             ->get();

    //         // ###########################################################################################

    //         // $attendanceDatas = DB::table('attendances')
    //         //     ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         //     //->where('teammembers.employment_status','CA Article')
    //         //     ->where('teammembers.role_id', 15)
    //         //     ->where('attendances.year', $currentYear)
    //         //     ->where('attendances.month', $currentMonth)
    //         //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')
    //         //     ->paginate(100);

    //         // $attendanceDatas = DB::table('attendances')
    //         //     ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         //     //->where('teammembers.employment_status','CA Article')
    //         //     ->where('teammembers.role_id', 14)
    //         //     ->where('attendances.year', $currentYear)
    //         //     ->where('attendances.month', $currentMonth)
    //         //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')
    //         //     ->paginate(100);


    //         $attendanceDatas = DB::table('attendances')
    //             ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //             //->where('teammembers.employment_status','CA Article')
    //             ->where('teammembers.role_id', 14)
    //             // ->where('attendances.year', $currentYear)
    //             // ->where('attendances.month', $currentMonth)
    //             ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')
    //             ->paginate(100);

    //         // dd($attendanceDatas);









    //         return view('backEnd.attendance.index', compact('attendanceDatas', 'attendanceDatass', 'attendanceDatasss', 'activitylogDatas', 'supportstaffDatas'));
    //     } elseif (auth()->user()->teammember_id == 79) // access to skultala -- support staff attendance
    //     {
    //         $attendanceDatas = DB::table('attendances')
    //             ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //             ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //             ->where('attendances.month', 'April')
    //             ->where('attendances.year', '2024')
    //             ->WhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647', '685', '256'])   //manual attendance - support staff
    //             ->select('attendances.*', 'teammembers.team_member', 'teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')->get();

    //         $activitylogDatas = DB::table('activitylogs')
    //             ->leftJoin('teammembers', 'teammembers.id', '=', 'activitylogs.user_id')
    //             ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    //             ->whereIn('activitylogs.activitytitle', ['Attendance Updated'])
    //             ->select('activitylogs.*', 'teammembers.team_member', 'roles.rolename')
    //             ->latest()
    //             ->get();

    //         return view('backEnd.attendance.staff-index', compact('attendanceDatas', 'activitylogDatas'));
    //     }
    //     abort(403, ' you have no permission to access this page ');
    // }

    public function index()
    {

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                // ->where('teammembers.status', 1)
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();

            return view('backEnd.attendance.index', compact('teammembers'));
        } else {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.id', auth()->user()->teammember_id)
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();

            return view('backEnd.attendance.teamindex', compact('teammembers'));
        }
        abort(403, ' you have no permission to access this page ');
    }
    // i have worked
    // public function adminattendancereport(Request $request)
    // {

    //     $teamnid = $request->input('teammemberId');
    //     $startdate = $request->input('startdate');
    //     $enddate = $request->input('enddate');
    //     // All teammember 
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();
    //     // only attendance user 
    //     // $teammembers = DB::table('attendances')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
    //     //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //     //     ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //     //     ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //     //     ->distinct()
    //     //     ->orderBy('teammembers.team_member', 'ASC')
    //     //     ->get();

    //     $query  = DB::table('attendances')
    //         ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     if ($startdate && $enddate) {
    //         $query->whereBetween('attendances.fulldate', [$startdate, $enddate]);
    //     }

    //     // if ($startdate) {
    //     //     $query->where('applyleaves.leavetype', $startdate);
    //     // }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }

    // Akshay have worked
    // public function adminattendancereport(Request $request)
    // {
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = $request->input('startdate');
    //     $enddate = $request->input('enddate');
    //     // All teammember 
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();

    //     // only attendance user 
    //     // $teammembers = DB::table('attendances')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
    //     //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //     //     ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //     //     ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //     //     ->distinct()
    //     //     ->orderBy('teammembers.team_member', 'ASC')
    //     //     ->get();

    //     // $query  = DB::table('attendances')
    //     //     ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //     //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     $query  = DB::table('attendances')
    //         ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     //akshay code
    //     if ($startdate && $enddate) {
    //         // Convert the start and end dates to full month names
    //         $startMonth = Carbon::parse($startdate)->format('F'); // e.g., "January"
    //         $endMonth = Carbon::parse($enddate)->format('F');     // e.g., "December"

    //         // Map months to numbers for correct comparison
    //         $months = [
    //             'January' => 1,
    //             'February' => 2,
    //             'March' => 3,
    //             'April' => 4,
    //             'May' => 5,
    //             'June' => 6,
    //             'July' => 7,
    //             'August' => 8,
    //             'September' => 9,
    //             'October' => 10,
    //             'November' => 11,
    //             'December' => 12,
    //         ];

    //         $startMonthNumber = $months[$startMonth];
    //         $endMonthNumber = $months[$endMonth];

    //         // Filter by month names by converting the stored string month to its respective number
    //         $query->whereBetween(DB::raw("FIELD(attendances.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')"), [$startMonthNumber, $endMonthNumber]);
    //     }

    //     //and akshay code 

    //     // if ($startdate) {
    //     //     $query->where('applyleaves.leavetype', $startdate);
    //     // }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     // dd($attendanceDatas);
    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }


    // public function adminattendancereport(Request $request)
    // {

    //     // dd($request);
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = $request->input('startdate');
    //     $enddate = $request->input('enddate');
    //     // Convert start date to a date object for accurate comparison
    //     $startdate = \Carbon\Carbon::parse($startdate);
    //     $enddate = \Carbon\Carbon::parse($enddate);

    //     // All teammember 
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();


    //     $singleusersearched = DB::table('teammembers')
    //         ->where('id', $teamnid)
    //         ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
    //         ->first();
    //     // dd($singleusersearched);
    //     // Check if leavingdate exists and is after the startdate
    //     if ($singleusersearched && $singleusersearched->leavingdate != null) {
    //         $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);
    //         if ($startdate->gt($leavingdate)) {
    //             // $output = array('msg' => 'You cannot select this user as their leaving date is before the start date.');
    //             $output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
    //             // return back()->with('statuss', $output);
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     if ($singleusersearched && $singleusersearched->joining_date != null) {
    //         $joiningdate = \Carbon\Carbon::parse($singleusersearched->joining_date);
    //         if ($joiningdate->gt($enddate)) {
    //             // $output = array('msg' => 'You cannot select this user as their Joining date is After the end date.');
    //             $output = ['msg' => 'You cannot select this user as their Joining date (' . $joiningdate->format('d-m-Y') . ') is After the end date.'];
    //             // return back()->with('statuss', $output);
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // only attendance user 
    //     // $teammembers = DB::table('attendances')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'attendances.employee_name')
    //     //     ->leftJoin('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //     //     ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //     //     ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //     //     ->distinct()
    //     //     ->orderBy('teammembers.team_member', 'ASC')
    //     //     ->get();

    //     // $query  = DB::table('attendances')
    //     //     ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     //     ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //     //     ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     $query  = DB::table('attendances')
    //         ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     //akshay code
    //     if ($startdate && $enddate) {
    //         // Convert the start and end dates to full month names
    //         $startMonth = Carbon::parse($startdate)->format('F'); // e.g., "January"
    //         $endMonth = Carbon::parse($enddate)->format('F');     // e.g., "December"

    //         // Map months to numbers for correct comparison
    //         $months = [
    //             'January' => 1,
    //             'February' => 2,
    //             'March' => 3,
    //             'April' => 4,
    //             'May' => 5,
    //             'June' => 6,
    //             'July' => 7,
    //             'August' => 8,
    //             'September' => 9,
    //             'October' => 10,
    //             'November' => 11,
    //             'December' => 12,
    //         ];

    //         $startMonthNumber = $months[$startMonth];
    //         $endMonthNumber = $months[$endMonth];

    //         // Filter by month names by converting the stored string month to its respective number
    //         $query->whereBetween(DB::raw("FIELD(attendances.month, 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December')"), [$startMonthNumber, $endMonthNumber]);
    //     }

    //     //and akshay code 

    //     // if ($startdate) {
    //     //     $query->where('applyleaves.leavetype', $startdate);
    //     // }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     // dd($attendanceDatas);
    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }

    // public function adminattendancereport(Request $request)
    // {
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = \Carbon\Carbon::parse($request->input('startdate'));
    //     $enddate = \Carbon\Carbon::parse($request->input('enddate'));

    //     // All team members with the specified roles
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();

    //     // Fetch the selected team member
    //     $singleusersearched = DB::table('teammembers')
    //         ->where('id', $teamnid)
    //         ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
    //         ->first();

    //     // Validate leaving date
    //     if ($singleusersearched && $singleusersearched->leavingdate) {
    //         $leavingdate = \Carbon\Carbon::parse($singleusersearched->leavingdate);
    //         if ($startdate->gt($leavingdate)) {
    //             $output = ['msg' => 'You cannot select this user as their leaving date (' . $leavingdate->format('d-m-Y') . ') is before the start date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Validate joining date
    //     if ($singleusersearched && $singleusersearched->joining_date) {
    //         $joiningdate = \Carbon\Carbon::parse($singleusersearched->joining_date);
    //         if ($joiningdate->gt($enddate)) {
    //             $output = ['msg' => 'You cannot select this user as their joining date (' . $joiningdate->format('d-m-Y') . ') is after the end date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Build the attendance query
    //     $query = DB::table('attendances')
    //         ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select('attendances.*', 'teammembers.team_member', 'teammembers.staffcode', 'teamrolehistory.newstaff_code', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date');

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     // Optimize date filtering
    //     if ($startdate && $enddate) {
    //         $query->whereBetween('attendances.fulldate', [$startdate, $enddate]);
    //     }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }

    // public function adminattendancereport(Request $request)
    // {
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = Carbon::parse($request->input('startdate'));
    //     $enddate = Carbon::parse($request->input('enddate'));

    //     // Convert start and end dates to their respective month numbers like Month number (1-12)
    //     $startMonth = $startdate->format('n');
    //     $startYear = $startdate->format('Y');

    //     $endMonth = $enddate->format('n');
    //     $endYear = $enddate->format('Y');

    //     // Retrieve all team members
    //     $teammembers = DB::table('teammembers')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //         ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //         ->orderBy('team_member', 'ASC')
    //         ->get();

    //     // Fetch single user data
    //     $singleusersearched = DB::table('teammembers')
    //         ->where('id', $teamnid)
    //         ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
    //         ->first();

    //     // Check leaving date validation
    //     if ($singleusersearched && $singleusersearched->leavingdate) {
    //         $leavingdate = Carbon::parse($singleusersearched->leavingdate);
    //         if ($startdate->gt($leavingdate)) {
    //             $output = ['msg' => 'User left on ' . $leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Check joining date validation
    //     if ($singleusersearched && $singleusersearched->joining_date) {
    //         $joiningdate = Carbon::parse($singleusersearched->joining_date);
    //         if ($joiningdate->gt($enddate)) {
    //             $output = ['msg' => 'User joined on ' . $joiningdate->format('d-m-Y') . ', cannot select before this date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Build attendance query filtered by month
    //     $query = DB::table('attendances')
    //         ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
    //         ->select(
    //             'attendances.*',
    //             'teammembers.team_member',
    //             'teammembers.staffcode',
    //             'teamrolehistory.newstaff_code',
    //             'teammembers.employment_status',
    //             'roles.rolename',
    //             'teammembers.joining_date'
    //         );

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     // // Filter where the attendance month falls between the start and end month
    //     // if ($startMonth && $endMonth) {
    //     //     $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
    //     // }

    //     // Filter attendance records by month and year
    //     if ($startMonth && $endMonth && $startYear && $endYear) {
    //         $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
    //             ->whereBetween('attendances.year', [$startYear, $endYear]);
    //     }

    //     $attendanceDatas = $query->get();
    //     $request->flash();

    //     return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    // }

    // with old code 
    // public function adminattendancereport(Request $request)
    // {
    //     $teamnid = $request->input('teammemberId');
    //     $startdate = Carbon::parse($request->input('startdate'));
    //     $enddate = Carbon::parse($request->input('enddate'));

    //     // Convert start and end dates to their respective month numbers like Month number (1-12)
    //     $startMonth = $startdate->format('n');
    //     $startYear = $startdate->format('Y');

    //     $endMonth = $enddate->format('n');
    //     $endYear = $enddate->format('Y');

    //     // Retrieve all team members
    //     if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
    //         $teammembers = DB::table('teammembers')
    //             ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //             ->whereIn('teammembers.role_id', [14, 15, 13, 11])
    //             ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //             ->orderBy('team_member', 'ASC')
    //             ->get();
    //     } else {
    //         $teammembers = DB::table('teammembers')
    //             ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //             ->where('teammembers.id', auth()->user()->teammember_id)
    //             ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
    //             ->orderBy('team_member', 'ASC')
    //             ->get();
    //     }

    //     // Fetch single user data
    //     $singleusersearched = DB::table('teammembers')
    //         ->where('id', $teamnid)
    //         ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
    //         ->first();

    //     // Check leaving date validation
    //     if ($singleusersearched && $singleusersearched->leavingdate) {
    //         $leavingdate = Carbon::parse($singleusersearched->leavingdate);
    //         if ($startdate->gt($leavingdate)) {
    //             $output = ['msg' => 'User left on ' . $leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Check joining date validation
    //     if ($singleusersearched && $singleusersearched->joining_date) {
    //         $joiningdate = Carbon::parse($singleusersearched->joining_date);
    //         if ($joiningdate->gt($enddate)) {
    //             $output = ['msg' => 'User joined on ' . $joiningdate->format('d-m-Y') . ', cannot select before this date.'];
    //             $request->flash();
    //             return redirect()->to('attendance')->with('statuss', $output);
    //         }
    //     }

    //     // Build attendance query filtered by month
    //     // $query = DB::table('attendances')
    //     //     ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
    //     //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //     //     ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
    //     //     // ->whereNotNull('attendances.id')
    //     //     ->select(
    //     //         'attendances.*',
    //     //         'teammembers.team_member',
    //     //         'teammembers.staffcode',
    //     //         'teamrolehistory.newstaff_code',
    //     //         'teammembers.employment_status',
    //     //         'roles.rolename',
    //     //         'teammembers.joining_date'
    //     //     );

    //     // Build attendance query filtered by month
    //     $query = DB::table('attendances')
    //         ->join('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
    //         ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
    //         ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
    //         ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
    //         ->select([
    //             'attendances.*',
    //             'teammembers.team_member',
    //             'teammembers.staffcode',
    //             'teammembers.employment_status',
    //             'roles.rolename',
    //             'teamrolehistory.newstaff_code',
    //             'teammembers.staffcode',
    //             // Combine rejoining dates
    //             // DB::raw('COALESCE(teamrolehistory.newstaff_code, teammembers.staffcode) AS final_staff_code'),
    //             // Combine rejoining dates
    //             DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate,teamrolehistory.promotion_date) AS final_rejoining_date'),
    //             // 'teamrolehistory.promotion_date',
    //             'teammembers.joining_date'
    //         ]);

    //     if ($teamnid) {
    //         $query->where('attendances.employee_name', $teamnid);
    //     }

    //     // // Filter where the attendance month falls between the start and end month
    //     // if ($startMonth && $endMonth) {
    //     //     $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
    //     // }

    //     // Filter attendance records by month and year
    //     if ($startMonth && $endMonth && $startYear && $endYear) {
    //         $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
    //             ->whereBetween('attendances.year', [$startYear, $endYear]);
    //     }

    //     // ordering using month name like Dec,Nov,Oct etc
    //     $query->orderBy('attendances.year', 'desc')
    //         ->orderBy(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), 'desc');

    //     $attendanceDatas = $query->get();
    //     $request->flash();
    //     // dd($attendanceDatas);

    //     if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
    //         return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
    //     } else {
    //         return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
    //     }
    // }

    public function adminattendancereport(Request $request)
    {
        $teamnid = $request->input('teammemberId');
        $startdate = Carbon::parse($request->input('startdate'));
        $enddate = Carbon::parse($request->input('enddate'));

        // Convert start and end dates to their respective month numbers like Month number (1-12)
        $startMonth = $startdate->format('n');
        $startYear = $startdate->format('Y');

        $endMonth = $enddate->format('n');
        $endYear = $enddate->format('Y');

        // Retrieve all team members
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();
        } else {
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                ->where('teammembers.id', auth()->user()->teammember_id)
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();
        }

        // Fetch single user data
        $singleusersearched = DB::table('teammembers')
            ->where('id', $teamnid)
            ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
            ->first();

        // Check leaving date validation
        if ($singleusersearched && $singleusersearched->leavingdate) {
            $leavingdate = Carbon::parse($singleusersearched->leavingdate);
            if ($startdate->gt($leavingdate)) {
                $output = ['msg' => 'User left on ' . $leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Check joining date validation
        if ($singleusersearched && $singleusersearched->joining_date) {
            $joiningdate = Carbon::parse($singleusersearched->joining_date);
            if ($joiningdate->gt($enddate)) {
                $output = ['msg' => 'User joined on ' . $joiningdate->format('d-m-Y') . ', cannot select before this date.'];
                $request->flash();
                return redirect()->to('attendance')->with('statuss', $output);
            }
        }

        // Build attendance query filtered by month
        // $query = DB::table('attendances')
        //     ->leftJoin('teammembers', 'teammembers.id', 'attendances.employee_name')
        //     ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
        //     ->leftJoin('roles', 'roles.id', 'teammembers.role_id')
        //     // ->whereNotNull('attendances.id')
        //     ->select(
        //         'attendances.*',
        //         'teammembers.team_member',
        //         'teammembers.staffcode',
        //         'teamrolehistory.newstaff_code',
        //         'teammembers.employment_status',
        //         'roles.rolename',
        //         'teammembers.joining_date'
        //     );

        // Build attendance query filtered by month
        $query = DB::table('attendances')
            ->join('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
            ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
            ->select([
                'attendances.*',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teammembers.employment_status',
                'roles.rolename',
                // Combine rejoining dates
                DB::raw('COALESCE(teamrolehistory.newstaff_code, teammembers.staffcode) AS final_staff_code'),
                // Combine rejoining dates
                DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate,teamrolehistory.promotion_date) AS final_rejoining_date'),
                // 'teamrolehistory.promotion_date',
                'teammembers.joining_date'
            ]);

        if ($teamnid) {
            $query->where('attendances.employee_name', $teamnid);
        }

        // // Filter where the attendance month falls between the start and end month
        // if ($startMonth && $endMonth) {
        //     $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth]);
        // }

        // Filter attendance records by month and year
        if ($startMonth && $endMonth && $startYear && $endYear) {
            $query->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), [$startMonth, $endMonth])
                ->whereBetween('attendances.year', [$startYear, $endYear]);
        }

        // ordering using month name like Dec,Nov,Oct etc
        $query->orderBy('attendances.year', 'desc')
            ->orderBy(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), 'desc');

        $attendanceDatas = $query->get();
        $request->flash();
        // dd($attendanceDatas);

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
        } else {
            return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
        }
    }

    public function attendances(Request $request)
    {
        //   dd($request);
        if (auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18 || auth()->user()->teammember_id == 157) {
            $attendanceDatas = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                //->where('teammembers.employment_status','CA Article')
                ->where('teammembers.role_id', 15)
                ->where('attendances.month', $request->month)
                ->where('attendances.year', $request->year)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')->get();


            $attendanceDatass = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                //->where('teammembers.employment_status','Employee')
                ->whereNotIn('role_id', ['11', '12', '13', '15', '19', '20'])
                ->whereNotIn('employee_name', ['170', '169', '307', '447', '336', '558', '418', '645', '549', '318', '660', '647', '685', '256'])

                ->where('attendances.month', $request->month)
                ->where('attendances.year', $request->year)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')->get();


            $attendanceDatasss = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                // ->where('teammembers.employment_status','Intern')
                ->where('teammembers.role_id', 19)
                ->where('attendances.month', $request->month)
                ->where('attendances.year', $request->year)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')->get();
            //dd($attendanceData);

            $supportstaffDatas  = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->where('attendances.month', $request->month)
                ->where('attendances.year', $request->year)
                ->WhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647', '685', '256'])   //manual attendance - support staff
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')->get();


            $activitylogDatas = DB::table('activitylogs')
                ->leftJoin('teammembers', 'teammembers.id', '=', 'activitylogs.user_id')
                ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
                ->whereIn('activitylogs.activitytitle', ['Attendance Updated'])
                ->select('activitylogs.*', 'teammembers.team_member', 'roles.rolename')
                ->latest()
                ->get();



            return view('backEnd.attendance.index', compact('attendanceDatas', 'attendanceDatass', 'attendanceDatasss', 'activitylogDatas', 'supportstaffDatas'));
        } elseif (auth()->user()->teammember_id == 79) // access to shakuntala -- support staff attendance
        {
            $attendanceDatas = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->WhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647', '685', '256'])   //manual attendance - support staff
                ->where('attendances.month', $request->month)
                ->where('attendances.year', $request->year)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')->get();

            return view('backEnd.attendance.staff-index', compact('attendanceDatas'));
        }
        abort(403, ' you have no permission to access this page ');
    }

    public function update(Request $request)
    {
        $oldAttendance = Attendance::find($request->attendance_id);
        // Retrieve the attendance data
        $attendanceId = $request->attendance_id;

        // Prepare an array of fields to update
        $fieldsToUpdate = [];
        $fields = ['sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'total_no_of_days', 'no_of_days_present', 'casual_leave', 'sick_leave', 'comp_off', 'birthday_religious', 'lwp', 'absent', 'totaldaystobepaid', 'comment', 'weekend'];

        foreach ($fields as $field) {
            $fieldsToUpdate[$field] = $request->input($field);
        }


        // Update the attendance data
        Attendance::where('id', $attendanceId)->update($fieldsToUpdate);
        // Retrieve the updated attendance data
        $newAttendance = Attendance::find($request->attendance_id);

        // Compare old and new values
        $changes = [];
        foreach ($fields as $field) {
            $oldValue = $oldAttendance->$field;
            $newValue = $newAttendance->$field;

            // Check if the value has changed
            if ($oldValue != $newValue) {
                $changes[$field] = "( field $field is changed from  $oldValue to $newValue)";
            }
        }

        // Prepare additional information
        $currentDateTime = now()->format('Y-m-d H:i:s');
        $id = auth()->user()->teammember_id;
        $employeename = Teammember::where('id', $oldAttendance->employee_name)->value('team_member');

        // Prepare the description for the activity log
        $description = "(Employee Name: $employeename, " . implode(', ', $changes) . ", Comment: $request->comment)";

        // Limit the description to a reasonable length
        $description = substr($description, 0, 65535); // 65535 is the maximum length for a longtext column

        // Insert an entry into the activitylogs table
        DB::table('activitylogs')->insert([
            'user_id' => $id,
            'ip_address' => $request->ip(),
            'activitytitle' => 'Attendance Updated',
            'month_year' => $oldAttendance->year . '-' . $oldAttendance->month,
            'generate_date_time' => $currentDateTime,
            'description' => $description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $output = array('msg' => 'Attendance updated successfully');
        return back()->with('success', $output);
    }
}

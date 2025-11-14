<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            session()->forget('_old_input');
            $teammembers = DB::table('teammembers')
                ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', '=', 'teammembers.id')
                // ->where('teammembers.status', 1)
                ->whereIn('teammembers.role_id', [14, 15, 13, 11])
                ->select('teammembers.team_member', 'teamrolehistory.newstaff_code', 'teammembers.id', 'teammembers.staffcode')
                ->orderBy('team_member', 'ASC')
                ->get();

            return view('backEnd.attendance.index', compact('teammembers'));
        } else {
            session()->forget('_old_input');
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

    public function attendanceupdatednow(Request $request)
    {

        $currentDate = now();
        $currentMonth = $currentDate->format('F');
        $currentYear = $currentDate->format('Y');
        $totalDays = $currentDate->daysInMonth;

        $teammembers = Attendance::join('teammembers', 'teammembers.id', 'attendances.employee_name')
            ->where('attendances.month', $currentMonth)
            ->whereYear('attendances.created_at', $currentYear)
            ->get();

        foreach ($teammembers as $team) {
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

            $days = array_intersect_key($team->toArray(), array_flip($keysToFilter));

            $dayspresent = 0;
            $casualLeaveCount = 0;
            $examLeaveCount = 0;
            $travelCount = 0;
            $offholidaysCount = 0;
            $sundayCount = 0;
            $holidaysCount = 0;

            foreach ($days as $key => $value) {
                if ($value == 'P') {
                    $dayspresent++;
                } else if ($value == 'CL') {
                    $casualLeaveCount++;
                } else if ($value == 'EL') {
                    $examLeaveCount++;
                } else if ($value == 'T') {
                    $travelCount++;
                } else if ($value == 'OH') {
                    $offholidaysCount++;
                } else if ($value == 'W') {
                    $sundayCount++;
                } else if ($value == 'H') {
                    $holidaysCount++;
                }
            }

            $dayspresentcount = $dayspresent;
            $casualLeave = $casualLeaveCount;
            $examLeave =  $examLeaveCount;
            $travel =  $travelCount;
            $offholidays =  $offholidaysCount;
            $sunday =  $sundayCount;
            $holidays =  $holidaysCount;

            $attendanceData = [
                'total_no_of_days' => $totalDays,
                'no_of_days_present' => $dayspresentcount,
                'casual_leave' => $casualLeave,
                'exam_leave' => $examLeave,
                'travel' => $travel,
                'offholidays' => $offholidays,
                'sundaycount' => $sunday,
                'holidays' => $holidays,
            ];

            DB::table('attendances')->where('employee_name', $team->employee_name)
                ->where('month', $currentMonth)
                ->where('year', $currentYear)
                ->update($attendanceData);
        }

        $output = array('msg' => 'Attendance has been successfully updated.');
        return back()->with('success', $output);
    }

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
        // $singleusersearched = DB::table('teammembers')
        //     ->where('id', $teamnid)
        //     ->select('team_member', 'staffcode', 'id', 'leavingdate', 'joining_date')
        //     ->first();

        $singleusersearched = DB::table('teammembers')
            ->where('teammembers.id', $teamnid)
            ->leftJoin(
                'teamrolehistory',
                'teamrolehistory.teammember_id',
                '=',
                'teammembers.id',
            )
            ->leftJoin(
                'rejoiningsamepost',
                'rejoiningsamepost.teammember_id',
                '=',
                'teammembers.id',
            )
            ->select([
                'teammembers.id',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teammembers.joining_date',
                'teammembers.team_member',
                DB::raw(
                    'COALESCE(teamrolehistory.rejoiniedexitdate, rejoiningsamepost.rejoiniedexitdate, teammembers.leavingdate) AS final_leavingdate',
                ),
                DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate,teamrolehistory.promotion_date) AS final_rejoining_date'),
            ])
            ->first();

        // dd($singleusersearched);

        // Check leaving date validation
        if ($singleusersearched && $singleusersearched->final_leavingdate) {
            $final_joiningdate = Carbon::parse($singleusersearched->final_rejoining_date);
            $final_leavingdate = Carbon::parse($singleusersearched->final_leavingdate);
            if ($final_leavingdate->gt($final_joiningdate)) {
                if ($startdate->gt($final_leavingdate)) {
                    $output = ['msg' => 'User left on ' . $final_leavingdate->format('d-m-Y') . ', cannot select beyond this date.'];
                    $request->flash();
                    return redirect()->to('attendance')->with('statuss', $output);
                }
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
        $query = DB::table('attendances')
            ->join('teammembers', 'teammembers.id', '=', 'attendances.employee_name')
            ->leftJoin('teamrolehistory', function ($join) {
                $join->on('teamrolehistory.teammember_id', '=', 'attendances.employee_name')
                    ->whereRaw('DATE(teamrolehistory.created_at) <= attendances.fulldate');
            })
            ->leftJoin('rejoiningsamepost', function ($join) {
                $join->on('rejoiningsamepost.teammember_id', '=', 'attendances.employee_name')
                    ->whereRaw('DATE(rejoiningsamepost.rejoiningdate) <= attendances.fulldate');
            })
            // ->leftJoin('rejoiningsamepost', 'rejoiningsamepost.teammember_id', '=', 'teammembers.id')
            ->leftJoin('roles as current_role', 'current_role.id', '=', 'teammembers.role_id')
            ->leftJoin('roles as roleidold', 'roleidold.id', '=', 'teamrolehistory.roleid_old')
            ->leftJoin('roles as roleidnew', 'roleidnew.id', '=', 'teamrolehistory.roleid_new')
            ->select([
                'attendances.*',
                'teammembers.team_member',
                'teammembers.staffcode',
                'teammembers.employment_status',
                // Role names
                'current_role.rolename as current_role_name',
                'roleidold.rolename as old_role_name',
                'roleidnew.rolename as new_role_name',
                'teamrolehistory.newstaff_code',
                // Combine rejoining dates 
                DB::raw('COALESCE(teamrolehistory.rejoiningdate, rejoiningsamepost.rejoiningdate,teamrolehistory.promotion_date) AS final_rejoining_date'),
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
        $query->where(function ($q) use ($startYear, $endYear, $startMonth, $endMonth) {
            $q->whereBetween(DB::raw('YEAR(STR_TO_DATE(CONCAT(attendances.month, " 1, ", attendances.year), "%M %d, %Y"))'), [$startYear, $endYear]);

            if ($startYear == $endYear) {
                // filter in same year
                $q->whereBetween(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, ", attendances.year), "%M %d, %Y"))'), [$startMonth, $endMonth]);
            } else {
                // if multiple year then exucute this condition
                $q->where(function ($subQ) use ($startYear, $endYear, $startMonth, $endMonth) {
                    $subQ->where(function ($q1) use ($startYear, $startMonth) {
                        $q1->whereYear(DB::raw('STR_TO_DATE(CONCAT(attendances.month, " 1, ", attendances.year), "%M %d, %Y")'), $startYear)
                            ->whereMonth(DB::raw('STR_TO_DATE(CONCAT(attendances.month, " 1, ", attendances.year), "%M %d, %Y")'), '>=', $startMonth);
                    })->orWhere(function ($q2) use ($endYear, $endMonth) {
                        $q2->whereYear(DB::raw('STR_TO_DATE(CONCAT(attendances.month, " 1, ", attendances.year), "%M %d, %Y")'), $endYear)
                            ->whereMonth(DB::raw('STR_TO_DATE(CONCAT(attendances.month, " 1, ", attendances.year), "%M %d, %Y")'), '<=', $endMonth);
                    });
                });
            }
        });

        // ordering using month name like Dec,Nov,Oct etc
        $query->orderBy('attendances.year', 'desc')
            ->orderBy(DB::raw('MONTH(STR_TO_DATE(CONCAT(attendances.month, " 1, 2000"), "%M %d, %Y"))'), 'desc');

        $attendanceDatas = $query->get();

        dd($attendanceDatas);

        $attendanceDatas = $attendanceDatas->map(function ($item) {
            $item->staffcode = $this->getStaffCodeAt($item->teamid, $item->created_at);
            return $item;
        });


        $request->flash();

        if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
            return view('backEnd.attendance.adminattendance', compact('attendanceDatas', 'teammembers'));
        } else {
            return view('backEnd.attendance.teamattendance', compact('attendanceDatas', 'teammembers'));
        }
    }


    public function attendances(Request $request)
    {
        //   dd($request);
        if (auth()->user()->role_id == 11 or auth()->user()->role_id == 17 or auth()->user()->role_id == 18) {
            $attendanceDatas = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                //->where('teammembers.employment_status','CA Article')
                ->where('teammembers.role_id', 15)
                ->where('attendances.month', $request->month)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')->get();

            $attendanceDatass = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                //->where('teammembers.employment_status','Employee')
                ->whereNotIn('role_id', ['11', '12', '13', '15', '19', '20'])
                //->whereNotIn('employee_name', ['170', '169', '307','447','336'])

                ->where('attendances.month', $request->month)



                ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')->get();

            $attendanceDatasss = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                // ->where('teammembers.employment_status','Intern')
                ->where('teammembers.role_id', 19)
                ->where('attendances.month', $request->month)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.employment_status', 'roles.rolename', 'teammembers.joining_date')->get();
            //dd($attendanceData);
            return view('backEnd.attendance.index', compact('attendanceDatas', 'attendanceDatass', 'attendanceDatasss'));
        } elseif (auth()->user()->teammember_id == 406) // access to skultala -- support staff attendance
        {
            $attendanceDatas = DB::table('attendances')
                ->leftjoin('teammembers', 'teammembers.id', 'attendances.employee_name')
                ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                ->WhereIn('teammembers.id', ['558', '418', '645', '549', '318', '660', '647'])   //manual attendance - support staff
                ->where('attendances.month', $request->month)
                ->select('attendances.*', 'teammembers.team_member', 'teammembers.joining_date', 'teammembers.employment_status', 'roles.rolename')->get();

            return view('backEnd.attendance.staff-index', compact('attendanceDatas'));
        }
        abort(403, ' you have no permission to access this page ');
    }

    public function update(Request $request)
    {
        // Retrieve the attendance data
        $attendanceId = $request->attendance_id;

        // Prepare an array of fields to update
        $fieldsToUpdate = [];
        $fields = ['sixteen', 'seventeen', 'eighteen', 'ninghteen', 'twenty', 'twentyone', 'twentytwo', 'twentythree', 'twentyfour', 'twentyfive', 'twentysix', 'twentyseven', 'twentyeight', 'twentynine', 'thirty', 'thirtyone', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'total_no_of_days', 'no_of_days_present', 'casual_leave', 'sick_leave', 'comp_off', 'birthday_religious', 'lwp', 'absent', 'totaldaystobepaid', 'comment'];

        foreach ($fields as $field) {
            $fieldsToUpdate[$field] = $request->input($field);
        }


        // Update the attendance data
        Attendance::where('id', $attendanceId)->update($fieldsToUpdate);

        // Redirect or perform other actions as needed
        return redirect()->back()->with('success', 'Attendance updated successfully');
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
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use Log;
use App\Models\Checkin;
use Carbon\Carbon;


class CheckInController extends Controller
{
    //

    public function store(Request $request)
    {
        // dd('hi');
        $validator = Validator::make($request->all(), [
            'teammember_id' => 'required',
            'checkin_from' => 'required',
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;

            return  response()->json($response);
        }

        try {

            if ($request->teammember_id == 447) {
                return response()->json(["output" => "You do not have permission to Check-In", "status" => "false", "code" => "500"]);
            } else {
                $currentDate = Carbon::now()->format('d-m-Y');
                $currentTime = Carbon::now()->format('H:i:s');

                //dd($currentDate);
                if ($request->has('reason')) {

                    $Date = $request->date;
                    //dd($Date);
                    $Date = Carbon::createFromFormat('d-m-Y', $Date)->format('Y-m-d');
                    //dd($Date);
                    $currentTime = $request->time;

                    DB::table('checkinreqs')->insert([
                        'team_id' => $request->teammember_id,
                        'date' => $Date,
                        'partnerid' => $request->partner,
                        'status' => 0,
                        'remark' => $request->reason,
                        'type' => $request->checkin_status

                    ]);
                    $currentDate = Carbon::createFromFormat('Y-m-d', $Date)->format('d-m-Y');
                    //dd($currentDate);

                }
                $checkintoday = Checkin::where('teammember_id', $request->input('teammember_id'))
                    ->where('date', $currentDate)
                    ->first();
                //	dd($checkintoday);

                if (!$checkintoday) {
                    /*if ($request->checkin_from == "Work From Home") {
        if ($request->has('client_id') != null) {
            $type = "Allocated";
        } else {
            $type = "Unallocated";
        }
    } else {
        $type = $request->input('typeval');
    }*/
                    $currentTime = Carbon::now(); // Convert current time to a Carbon instance
                    // $currentTime = Carbon::createFromTime(14, 30, 0); // Create a Carbon instance for 2:30 PM

                    //dd($currentTime);
                    $closingTime = Carbon::today()->setHour(15)->setMinute(0)->setSecond(0);
                    //dd($closingTime);
                    // Check if the current time is equal to 3 PM
                    if ($currentTime->greaterThanOrEqualTo($closingTime)) {
                        // Return an error response if the current time is 3 PM
                        return response()->json(['error' => 'Check-in not Allowed After 3 PM.'], 400);
                    } else {

                        $checkin = new Checkin();
                        $checkin->teammember_id = $request->input('teammember_id');
                        $checkin->checkin_from = $request->input('checkin_from');
                        $checkin->month = $request->input('month');
                        $checkin->typeval = $request->input('typeval');
                        $checkin->client_id = $request->input('client_id');
                        $checkin->assignment_id = $request->input('assignment_id');
                        $checkin->company_name = $request->input('company_name');
                        $checkin->partner = $request->input('partner');
                        $checkin->place = $request->input('place');
                        $checkin->date = $currentDate;
                        $checkin->time = $currentTime;
                        $checkin->latitude = $request->input('latitude');
                        $checkin->longitude = $request->input('longitude');
                        $checkin->checkout_time = $request->input('checkout_time');
                        $checkin->checkin_status = $request->input('checkin_status');
                        //	dd($checkin);
                        $checkin->save();
                        return response()->json(["output" => "insert successfully", "status" => "true", "code" => "10001"]);
                    }
                } else {
                    $response['result'] = "failed";
                    $response['msg'] = "You have already checked in!";
                    $response['code'] = "10002";
                }
            }
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }

        return response()->json($response);
    }

    public function clientlist()
    {
        try {


            $client =  DB::table('assignmentmappings')
                ->join('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'assignmentmappings.assignmentgenerate_id')
                ->join('clients', 'clients.id', '=', 'assignmentbudgetings.client_id')
                ->select('clients.id', 'clients.client_name')
                ->groupBy('assignmentbudgetings.client_id', 'clients.id', 'clients.client_name')
                ->orderBy('clients.client_name', 'ASC')
                ->get();


            $response['result'] = $client;
            $response['msg'] = "True";
            $response['code'] = "10001";
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }

    public function clientlisttask()
    {
        try {


            $result['client'] = DB::table('clients')->latest()

                ->orderBy('client_name', 'ASC')
                ->select('id', 'client_name', 'gstno')
                ->get();

            $result['dataroomclient'] = DB::table('clientlogins')
                ->join('clients', 'clients.id', 'clientlogins.client_id')
                ->select('clients.client_name', 'clients.id')
                ->distinct('clients.client_name')
                ->orderBy('client_name', 'asc')->get();


            $response['result'] = $result;
            $response['msg'] = "True";
            $response['code'] = "10001";
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }

    public function checkInListold(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'teammember_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
            return  response()->json($response);
        }

        try {
            if ($request->has('role_id')) {
                if ($request->role_id == 18 or $request->role_id == 11) {
                    $checkIn = DB::table('checkins')
                        ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                        ->whereDate('checkins.created_at', '=', now()->toDateString())
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.date', 'DESC')
                        ->get();
                }
                //dd(now()->toDateString());
                elseif ($request->role_id == 13 && $request->teammember_id != null) {
                    $checkIn = DB::table('checkins')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                        ->where('assignmentmappings.leadpartner', $request->teammember_id)
                        ->whereDate('checkins.created_at', '=', now()->toDateString())
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.date', 'DESC')
                        ->get();
                    // dd($checkIn);
                } else {
                    //dd('hi');
                    $checkIn =     DB::table('checkins')
                        ->leftjoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')


                        ->leftjoin('teammembers', 'teammembers.id', 'checkins.teammember_id')
                        ->where('teammember_id', $request->teammember_id)
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.created_at', 'DESC')
                        ->get();
                }
            } else {
                //dd('hi');
                $checkIn = DB::table('checkins')
                    ->leftjoin('clients', 'clients.id', 'checkins.client_id')
                    ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                    ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')


                    ->where('teammember_id', $request->teammember_id)
                    ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name')
                    ->orderBy('checkins.created_at', 'DESC')
                    ->get();
            }
            $response['result'] = $checkIn;
            $response['msg'] = "True";
            $response['code'] = "10001";
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }

    public function checkInList(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'teammember_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
            return  response()->json($response);
        }

        try {
            if ($request->has('role_id')) {
                if ($request->role_id == 18 or $request->role_id == 11) {
                    if ($request->has('date')) {
                        $checkIn = DB::table('checkins')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')

                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'checkins.assignment_id')

                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')

                            ->whereDate('checkins.created_at', '=', $request->date)
                            ->where('checkins.checkin_status', '!=', 'A')

                            ->select([
                                'checkins.*',
                                'clients.client_name',
                                'teammembers.team_member',
                                'assignmentmappings.leadpartner',

                                DB::raw("COALESCE(CONCAT(assignments.assignment_name, ' (', assignmentbudgetings.assignmentname, ')'), assignments.assignment_name) AS assignment_name"),
                                DB::raw(
                                    "(SELECT CASE
    WHEN checkins.checkin_status IS Not NULL THEN
        CASE
            WHEN COUNT(*) > 0 THEN
                CASE
                    WHEN MAX(status) = 0 THEN 'Request Raised'
                    WHEN MAX(status) = 1 THEN 'Approved'
                    WHEN MAX(status) = 2 THEN 'Rejected'
                    ELSE 'unknown'
                END
            ELSE 'not_exists'
        END
    ELSE NULL
    END
    FROM checkinreqs
    WHERE team_id = checkins.teammember_id
    AND DATE_FORMAT(date, '%Y-%m-%d') = DATE_FORMAT(checkins.created_at, '%Y-%m-%d')
) AS is_already_requested"
                                )
                            ])

                            ->orderBy('checkins.date', 'DESC')
                            ->get();
                    } else {
                        //dd('hi');
                        $checkIn = DB::table('checkins')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')

                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'checkins.assignment_id')

                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')

                            ->whereDate('checkins.created_at', '=', now()->toDateString())
                            ->where('checkins.checkin_status', '!=', 'A')

                            ->select([
                                'checkins.*',
                                'clients.client_name',
                                'teammembers.team_member',
                                'assignmentmappings.leadpartner',
                                DB::raw("COALESCE(CONCAT(assignments.assignment_name, ' (', assignmentbudgetings.assignmentname, ')'), assignments.assignment_name) AS assignment_name"),
                                DB::raw(
                                    "(SELECT CASE
    WHEN checkins.checkin_status IS Not NULL THEN
        CASE
            WHEN COUNT(*) > 0 THEN
                CASE
                    WHEN MAX(status) = 0 THEN 'Request Raised'
                    WHEN MAX(status) = 1 THEN 'Approved'
                    WHEN MAX(status) = 2 THEN 'Rejected'
                    ELSE 'unknown'
                END
            ELSE 'not_exists'
        END
    ELSE NULL
    END
    FROM checkinreqs
    WHERE team_id = checkins.teammember_id
    AND DATE_FORMAT(date, '%Y-%m-%d') = DATE_FORMAT(checkins.created_at, '%Y-%m-%d')
) AS is_already_requested"
                                )
                            ])
                            ->orderBy('checkins.date', 'DESC')
                            ->get();
                    }
                }
                //dd(now()->toDateString());
                elseif ($request->role_id == 13 && $request->teammember_id != null) {
                    if ($request->has('date')) {
                        $checkIn = DB::table('checkins')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                            ->where('assignmentmappings.leadpartner', $request->teammember_id)

                            ->whereDate('checkins.created_at', '=', $request->date)
                            ->where('checkins.checkin_status', '!=', 'A')

                            ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member',                        'assignmentmappings.leadpartner')
                            ->orderBy('checkins.date', 'DESC')

                            ->get();
                    } else {
                        // dd(now()->toDateString());
                        $checkIn = DB::table('checkins')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                            ->where('assignmentmappings.leadpartner', $request->teammember_id)
                            ->whereDate('checkins.created_at', '=', now()->toDateString())
                            ->where('checkins.checkin_status', '!=', 'A')

                            ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member',                        'assignmentmappings.leadpartner')
                            ->orderBy('checkins.date', 'DESC')
                            ->get();
                        // dd($checkIn);
                    }
                } else {
                    //dd('else');
                    $checkIn = DB::table('checkins')
                        ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                        ->where('teammember_id', $request->teammember_id)
                        ->where(function ($query) {
                            $query->where('checkin_status', '!=', 'A')
                                ->orWhereNull('checkin_status');
                        })


                        ->select([
                            'checkins.*',
                            'clients.client_name',
                            'teammembers.team_member',
                            'assignmentmappings.leadpartner',
                            DB::raw("COALESCE(CONCAT(assignments.assignment_name, ' (', assignmentbudgetings.assignmentname, ')'), assignments.assignment_name) AS assignment_name"),
                            DB::raw(
                                "(SELECT CASE
    WHEN checkins.checkin_status IS Not NULL THEN
        CASE
            WHEN COUNT(*) > 0 THEN
                CASE
                    WHEN MAX(status) = 0 THEN 'Request Raised'
                    WHEN MAX(status) = 1 THEN 'Approved'
                    WHEN MAX(status) = 2 THEN 'Rejected'
                    ELSE 'unknown'
                END
            ELSE 'not_exists'
        END
    ELSE NULL
    END
    FROM checkinreqs
    WHERE team_id = checkins.teammember_id
    AND DATE_FORMAT(date, '%Y-%m-%d') = DATE_FORMAT(checkins.created_at, '%Y-%m-%d')
) AS is_already_requested"
                            )
                        ])

                        ->orderBy('checkins.created_at', 'DESC')
                        ->get();
                }
            } else {
                $checkIn = DB::table('checkins')
                    ->leftjoin('clients', 'clients.id', 'checkins.client_id')
                    ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                    ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')


                    ->where('teammember_id', $request->teammember_id)
                    ->where('checkins.checkin_status', '!=', 'A')

                    ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'assignmentmappings.leadpartner')
                    ->orderBy('checkins.created_at', 'DESC')
                    ->get();
            }
            $response['result'] = $checkIn;
            $response['msg'] = "True";
            $response['code'] = "10001";
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }


    public function checkInListDateFilter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'teammember_id' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
            return  response()->json($response);
        }

        try {
            if ($request->has('role_id')) {
                if ($request->role_id == 18 or $request->role_id == 11) {
                    //dd(now()->toDateString());
                    $checkIn = DB::table('checkins')
                        ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')

                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('assignmentbudgetings', 'assignmentbudgetings.assignmentgenerate_id', 'checkins.assignment_id')

                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentbudgetings.assignment_id')

                        ->whereDate('checkins.created_at', '=', $request->date)
                        ->select([
                            'checkins.*',
                            'clients.client_name',
                            'teammembers.team_member',
                            DB::raw("COALESCE(CONCAT(assignments.assignment_name, ' (', assignmentbudgetings.assignmentname, ')'), assignments.assignment_name) AS assignment_name")
                        ])

                        ->orderBy('checkins.date', 'DESC')
                        ->get();
                }
                //dd(now()->toDateString());
                elseif ($request->role_id == 13 && $request->teammember_id != null) {
                    $checkIn = DB::table('checkins')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                        ->where('assignmentmappings.leadpartner', $request->teammember_id)
                        ->whereDate('checkins.created_at', '=', $request->date)
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.date', 'DESC')
                        ->get();
                    // dd($checkIn);
                } else {
                }
            }



            $response['result'] = $checkIn;
            $response['msg'] = "True";
            $response['code'] = "10001";
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }

    public function checkInType(Request $request)
    {
        // dd($type);
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'teammember_id' => 'required',
            'type' => 'required',
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
            return  response()->json($response);
        }

        try {
            if ($request->has('role_id')) {
                if ($request->role_id == 18 or $request->role_id == 11) {
                    if ($request->type == "unallocated") {
                        $checkIn = DB::table('checkins')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                            ->whereDate('checkins.created_at', '=', now()->toDateString())
                            ->where('typeval', $request->type)
                            ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                            ->orderBy('checkins.date', 'DESC')
                            ->get();
                    } else {
                        $checkIn = DB::table('checkins')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                            ->whereDate('checkins.created_at', '=', now()->toDateString())
                            ->where('checkin_from', $request->type)
                            ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                            ->orderBy('checkins.date', 'DESC')
                            ->get();
                    }
                }
                //dd(now()->toDateString());
                elseif ($request->role_id == 13 && $request->teammember_id != null) {

                    if ($request->type == "unallocated") {
                        $checkIn = DB::table('checkins')
                            ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                            ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                            ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                            ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                            ->where('assignmentmappings.leadpartner', $request->teammember_id)
                            ->whereDate('checkins.created_at', '=', now()->toDateString())
                            ->where('typeval', $request->type)
                            ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                            ->orderBy('checkins.date', 'DESC')
                            ->get();
                    }
                    $checkIn = DB::table('checkins')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'checkins.teammember_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')
                        ->where('assignmentmappings.leadpartner', $request->teammember_id)
                        ->whereDate('checkins.created_at', '=', now()->toDateString())
                        ->where('checkin_from', $request->type)
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.date', 'DESC')
                        ->get();
                    // dd($checkIn);
                } else {
                    $checkIn =     DB::table('checkins')
                        ->leftjoin('clients', 'clients.id', '=', 'checkins.client_id')
                        ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                        ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')


                        ->leftjoin('teammembers', 'teammembers.id', 'checkins.teammember_id')
                        ->where('teammember_id', $request->teammember_id)
                        ->where('checkin_from', $request->type)
                        ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name', 'teammembers.team_member')
                        ->orderBy('checkins.created_at', 'DESC')
                        ->get();
                }
            } else {
                $checkIn = DB::table('checkins')
                    ->leftjoin('clients', 'clients.id', 'checkins.client_id')
                    ->leftJoin('assignmentmappings', 'assignmentmappings.assignmentgenerate_id', '=', 'checkins.assignment_id')
                    ->leftJoin('assignments', 'assignments.id', '=', 'assignmentmappings.assignment_id')


                    ->where('teammember_id', $request->teammember_id)
                    ->where('checkin_from', $request->type)
                    ->select('checkins.*', 'clients.client_name', 'assignments.assignment_name')
                    ->orderBy('checkins.created_at', 'DESC')
                    ->get();
            }
            $response['result'] = $checkIn;
            $response['msg'] = "True";
            $response['code'] = "10001";
        } catch (\Exception $e) {
            $response['result'] = "failed";
            $response['msg'] = "Something went wrong " . $e->getMessage();
            $response['code'] = "500";
            Log::info(json_encode(["Error in Member Transaction api-----", $e->getMessage()]));
        }
        return response()->json($response);
    }
    public function todayNotCheckin(Request $request)
    {
        try {
            $currentDate = date('d-m-Y');
            $today = date('Y-m-d');

            $checkinCount = DB::table('checkins')
                ->where('date', $currentDate)
                ->pluck('teammember_id')
                ->toArray();

            $leaveMemberIds = DB::table('applyleaves')
                ->where('status', '!=', 2)
                ->whereDate('from', '<=', $today)
                ->whereDate('to', '>=', $today)
                ->pluck('createdby')
                ->toArray();

            // Combine check-in and leave member ids and remove duplicates
            $excludeMemberIds = array_unique(array_merge($checkinCount, $leaveMemberIds));

            // Fetch team members who haven't checked in and haven't taken leave
            $notCheckedInMembersQuery = DB::table('teammembers')
                ->leftJoin('roles', 'roles.id', '=', 'teammembers.role_id')
                ->where('teammembers.status', 1)
                ->whereNotIn('teammembers.id', $excludeMemberIds);

            $notCheckedInMembers = $notCheckedInMembersQuery->select('teammembers.*', 'roles.rolename')->get();
            $count = $notCheckedInMembersQuery->count();

            $responseData = [
                'notCheckedInMembers' => $notCheckedInMembers,
                'count' => $count,
            ];

            if ($count === 0) {
                return response()->json(['message' => 'No members found.'], 404);
            }

            $responseData = [
                'notCheckedInMembers' => $notCheckedInMembers,
                'count' => $count,
            ];

            return response()->json($responseData);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    public function notCheckedinForMonth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'team_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response['msg'] = $validator->errors();
            $response['status'] = 0;
            return response()->json($response);
        }

        // Get the team_id from the request
        $teamId = $request->team_id;

        // Get the start and end dates of the current month in the format 'Y-m-d'
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->now();

        //dd($startDate->format('d-m-Y'));
        // Fetch the dates where the team member has checked in within the current month
        $checkedInDates = DB::table('checkins')
            ->where('teammember_id', $teamId)
            ->whereBetween('date', [$startDate->format('d-m-Y'), $endDate->format('d-m-Y')])
            ->whereMonth('created_at', Carbon::now()->month)
            ->select('date')
            ->get()
            ->pluck('date')
            ->toArray();
        //	dd($checkedInDates);
        $appliedLeaves = DB::table('applyleaves')
            ->whereDate('from', '>=', $startDate)
            ->whereDate('to', '<=', $endDate)
            ->where('status', '!=', 2) // Exclude rejected leaves
            ->where('createdby', $teamId) // Check for team_id
            ->select('from', 'to')
            ->get()
            ->toArray();
        //dd($appliedLeaves);
        $allDates = [];

        foreach ($appliedLeaves as $leave) {
            $allDates[] = $leave->from;
            $allDates[] = $leave->to;
        }

        // Now $allDates contains all the dates within the leave periods in a single array

        //dd($appliedLeaves);
        // Check if the dates are not in the holiday table
        $notInHolidays = DB::table('holidays')
            ->whereYear('startdate', Carbon::now()->year)
            ->whereMonth('startdate', Carbon::now()->month)
            ->select('startdate')
            ->get()
            ->pluck('startdate')
            ->map(function ($date) {
                return Carbon::parse($date)->format('d-m-Y');
            })
            ->toArray();
        //dd($notInHolidays);
        $mergedArray = array_merge($checkedInDates, $allDates, $notInHolidays);
        $desiredFormat = 'd-m-Y';

        // Use array_map to format all dates
        $formattedDates = array_map(function ($date) use ($desiredFormat) {
            return date($desiredFormat, strtotime($date));
        }, $mergedArray);



        //dd($formattedDates);

        // Filter out dates that are in either applyleaves or holidays
        //$datesNotCheckedIn = array_diff($notCheckedInDates, array_merge($notInApplyLeaves, $notInHolidays));
        //$datesNotCheckedIn = array_diff($checkedInDates,  $notInHolidays);



        //dd($datesNotCheckedIn);
        // Get all dates in the current month (October)
        $allDatesInCurrentMonth = [];
        $currentDate = Carbon::now()->startOfMonth();

        while ($currentDate->lte($endDate)) {
            $allDatesInCurrentMonth[] = $currentDate->format('d-m-Y');
            $currentDate->addDay();
        }
        //dd($allDatesInCurrentMonth);
        // Find the dates not checked in by filtering out the checked-in dates
        $datesNotCheckedIn = array_diff($allDatesInCurrentMonth, $formattedDates);
        //dd($datesNotCheckedIn);
        return response()->json([
            'not_checked_in_dates' => $datesNotCheckedIn,
            'not_checked_in_dates_count' => count($datesNotCheckedIn),
        ]);
    }
}

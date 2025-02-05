<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-5 order-sm-last mb-3 mb-sm-0 p-0 ">
            {{-- <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                @php
                    // Get current Date
                    $currentdate = date('Y-m-d');
                    if ($getauth == null) {
                        $getdate = date('Y-m-d');
                    } else {
                        $getdate = $getauth->date;
                    }

                    $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
                    $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                    // Diffrence between latest save timesheet and todays date in count / timesheet gap date count
                    $diff_in_days = $to->diffInDays($from);
                    $getmondaydate = DB::table('timesheetday')->first();

                    $timesheetcount = DB::table('timesheets')
                        ->where('status', '0')
                        ->where('created_by', auth()->user()->teammember_id)
                        ->where('date', '<', $getmondaydate->date)
                        ->count();
                    //! no uses
                    $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');
                    $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                    $diff_in_daysformonday = $too->diffInDays($froms);
                    //! no uses
                    $teamusers = DB::table('teammembers')
                        ->where('id', auth()->user()->teammember_id)
                        ->first();
                @endphp
                @if ($diff_in_days > 14)
                    @if ($timesheetrequest == null)
                        <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                                Request</a> </li>
                    @else
                        @if ($currentdate < $timesheetrequest->validate)
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    href="{{ url('timesheet/create') }}">Add Timesheet</a>
                            </li>
                            @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                                @if ($timesheetcount >= 6)
                                    <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                            onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                            href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                    </li>
                                @endif
                            @endif
                        @elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
                            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet
                                    Request</a>
                            </li>
                        @else
                            @if ($timesheetrequest && $timesheetrequest->status == 0)
                                @php
                                    $latestrequesthour = Carbon\Carbon::parse($timesheetrequest->created_at);
                                    $currentDateTime = Carbon\Carbon::now();
                                @endphp
                                @if ($latestrequesthour->diffInHours($currentDateTime) > 24)
                                    <li class="breadcrumb-item">
                                        <a data-toggle="modal" data-target="#exampleModal21">Add Timesheet Request</a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item"><a>Requested Done</a>
                                    </li>
                                @endif
                            @else
                                <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                        Timesheet Request</a> </li>
                            @endif
                        @endif
                    @endif
                @elseif(15 < 16)
                    <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">Add
                            Timesheet @if ($timesheetcount < 7)
                                for last week
                            @endif
                        </a>
                    </li>

                    @if (now()->isSunday() || now()->isMonday() || now()->isTuesday() || now()->isWednesday() || now()->isThursday() || now()->isFriday() || now()->isSaturday())
                        @if ($timesheetcount >= 6)
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @endif
                @endif
            </ol> --}}
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                @php
                    // Get current Date
                    $currentdate = date('Y-m-d');
                    // $currentdate = '2024-10-08';
                    if ($getauth == null) {
                        $getdate = date('Y-m-d');
                    } else {
                        $getdate = $getauth->date;
                        // $currentdate = '2024-09-17';
                    }

                    $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
                    $nextmonday = $to->copy()->next(Carbon\Carbon::MONDAY);
                    $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                    // Diffrence between latest save timesheet and todays date in count / timesheet gap date count
                    $diff_in_days = $nextmonday->diffInDays($from);

                    $getmondaydate = DB::table('timesheetday')->first();

                    // i have faced some problem hare so i have done new code when current week running and monday not update for current week then submit button not came
                    // $timesheetcount = DB::table('timesheets')
                    //     ->where('status', '0')
                    //     ->where('created_by', auth()->user()->teammember_id)
                    //     ->where('date', '<', $getmondaydate->date)
                    //     ->count();

                    // $timesheetcount = DB::table('timesheets')
                    //     ->where('status', '0')
                    //     ->where('created_by', auth()->user()->teammember_id)
                    //     ->where('date', '<', $currentdate)
                    //     ->count();

                    // $timesheetsaved = DB::table('timesheets')
                    //     ->where('status', '0')
                    //     ->where('created_by', auth()->user()->teammember_id)
                    //     ->orderBy('date', 'asc')
                    //     ->first();

                    $timesheetsaved = DB::table('timesheetusers')
                        ->where('status', '0')
                        ->where('createdby', auth()->user()->teammember_id)
                        ->orderBy('date', 'asc')
                        ->first();

                    $timesheetcount = 0;

                    if ($timesheetsaved) {
                        $startdateofdata = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetsaved->date ?? '');
                        $enddateofdata = $startdateofdata->copy()->next(Carbon\Carbon::SATURDAY);

                        $timesheetcount = DB::table('timesheets')
                            ->where('status', '0')
                            ->where('created_by', auth()->user()->teammember_id)
                            ->whereBetween('date', [$startdateofdata->format('Y-m-d'), $enddateofdata->format('Y-m-d')])
                            ->count();
                    }
                    // dd($timesheetcount);

                    //! no uses
                    $too = Carbon\Carbon::createFromFormat('Y-m-d', $getmondaydate->date ?? '');
                    $froms = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
                    $diff_in_daysformonday = $too->diffInDays($froms);
                    //! no uses
                    $teamusers = DB::table('teammembers')
                        ->where('id', auth()->user()->teammember_id)
                        ->first();
                @endphp

                {{-- <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm" href="{{ url('timesheet/create') }}">Add
                        Timesheet</a>
                </li>
                <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                        Request</a> </li> --}}

                <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                        onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                        href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                </li>

                {{-- Tuesday closed timesheet clent said user can submit timesheet on monday after comming sunday leave --}}
                @if ($diff_in_days >= 15)
                    @if ($timesheetrequest == null)
                        <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add Timesheet
                                Request</a> </li>
                    @else
                        @if ($currentdate < $timesheetrequest->validate)
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    href="{{ url('timesheet/create') }}">Add Timesheet</a>
                            </li>
                            @if (now()->isSunday() ||
                                    now()->isMonday() ||
                                    now()->isTuesday() ||
                                    now()->isWednesday() ||
                                    now()->isThursday() ||
                                    now()->isFriday() ||
                                    now()->isSaturday())
                                @if ($timesheetcount >= 6)
                                    <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                            onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                            href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                                    </li>
                                @endif
                            @endif
                        @elseif ($currentdate > $timesheetrequest->validate && $timesheetrequest->validate != null)
                            <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                    Timesheet
                                    Request</a>
                            </li>
                        @else
                            @if ($timesheetrequest && $timesheetrequest->status == 0)
                                @php
                                    $latestrequesthour = Carbon\Carbon::parse($timesheetrequest->created_at);
                                    $currentDateTime = Carbon\Carbon::now();
                                @endphp
                                @if ($latestrequesthour->diffInHours($currentDateTime) > 24)
                                    <li class="breadcrumb-item">
                                        <a data-toggle="modal" data-target="#exampleModal21">Add Timesheet Request</a>
                                    </li>
                                @else
                                    <li class="breadcrumb-item"><a>Requested Done</a>
                                    </li>
                                @endif
                            @else
                                <li class="breadcrumb-item"><a data-toggle="modal" data-target="#exampleModal21">Add
                                        Timesheet Request</a> </li>
                            @endif
                        @endif
                    @endif
                @elseif(15 < 16)
                    <li class="breadcrumb-item"><a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">Add
                            Timesheet @if ($timesheetcount > 7)
                                for last week
                            @endif
                        </a>
                    </li>

                    @if (now()->isSunday() ||
                            now()->isMonday() ||
                            now()->isTuesday() ||
                            now()->isWednesday() ||
                            now()->isThursday() ||
                            now()->isFriday() ||
                            now()->isSaturday())
                        @if ($timesheetcount >= 6)
                            <li class="breadcrumb-item"><a class="btn btn-primary-soft btn-sm"
                                    onclick="return confirm('Are you sure you want to submit this timesheet for last week?');"
                                    href="{{ url('timesheetsubmission') }}">Submit Timesheet for Week</a>
                            </li>
                        @endif
                    @endif
                @endif
            </ol>
        </nav>




        <div class="col-sm-7 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">My Timesheet</h1>
                    <small>Time sheet List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">

            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <form method="post">
                    @csrf
                    <div class="table-responsive">


                        <table id="examplee" class="display nowrap">
                            <thead>

                                <tr>
                                    <th style="display: none;">id</th>
                                    <!--	@if (
                                        (now()->isSaturday() && now()->hour >= 18) ||
                                            now()->isSunday() ||
                                            now()->isMonday() ||
                                            (now()->isTuesday() && now()->hour <= 18))
    <th><button type="submit"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    onclick="return confirm('Are you sure you want to submit this item?');"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     formaction="timesheetsubmits" class="btn btn-danger-soft btn-sm">Submit</button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <input type="checkbox" id="chkAll">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   <i class="os-icon os-icon-trash"></i></th>
    @endif -->
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Day</th>
                                    <th>Client Name</th>
                                    <th>Client Code</th>
                                    <th>Assignment Name</th>
                                    <th>Assignment Id</th>
                                    <th>Work Item</th>
                                    <th>Location</th>
                                    <th>Partner</th>
                                    <th>Partner Code</th>
                                    <th>Hour</th>
                                    <th>Total Hour</th>
                                    <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($timesheetData as $timesheetDatas)
                                    <tr>
                                        @php

                                            $timeid = DB::table('timesheetusers')
                                                ->where('timesheetusers.id', $timesheetDatas->id)
                                                ->first();

                                            // $client_id = DB::table('timesheetusers')
                                            //     ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                            //     ->leftjoin(
                                            //         'assignmentbudgetings',
                                            //         'assignmentbudgetings.assignment_id',
                                            //         'timesheetusers.assignment_id',
                                            //     )
                                            //     ->leftjoin(
                                            //         'assignments',
                                            //         'assignments.id',
                                            //         'timesheetusers.assignment_id',
                                            //     )
                                            //     ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                            //     ->leftJoin('teamrolehistory', function ($join) {
                                            //         $join
                                            //             ->on('teamrolehistory.teammember_id', '=', 'teammembers.id')
                                            //             ->on(
                                            //                 'teamrolehistory.created_at',
                                            //                 '<',
                                            //                 'timesheetusers.created_at',
                                            //             );
                                            //     })
                                            //     ->where('timesheetusers.id', $timesheetDatas->id)
                                            //     ->select(
                                            //         'clients.client_name',
                                            //         'clients.client_code',
                                            //         'timesheetusers.hour',
                                            //         'timesheetusers.location',
                                            //         'timesheetusers.status',
                                            //         'assignments.assignment_name',
                                            //         'billable_status',
                                            //         'workitem',
                                            //         'teammembers.team_member',
                                            //         'teammembers.staffcode',
                                            //         'teamrolehistory.newstaff_code',
                                            //         'assignmentbudgetings.assignmentname',
                                            //         'assignmentbudgetings.assignmentgenerate_id',
                                            //     )
                                            //     ->first();

                                            $client_id = DB::table('timesheetusers')
                                                ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                                ->leftjoin(
                                                    'assignmentbudgetings',
                                                    'assignmentbudgetings.assignment_id',
                                                    'timesheetusers.assignment_id',
                                                )
                                                ->leftjoin(
                                                    'assignments',
                                                    'assignments.id',
                                                    'timesheetusers.assignment_id',
                                                )
                                                ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                                ->where('timesheetusers.id', $timesheetDatas->id)
                                                ->select(
                                                    'clients.client_name',
                                                    'clients.client_code',
                                                    'timesheetusers.hour',
                                                    'timesheetusers.location',
                                                    'timesheetusers.status',
                                                    'assignments.assignment_name',
                                                    'billable_status',
                                                    'workitem',
                                                    'teammembers.team_member',
                                                    'teammembers.staffcode',
                                                    'assignmentbudgetings.assignmentname',
                                                )
                                                ->first();

                                            $permotioncheck = null;
                                            $datadate = $timesheetDatas->assignmentcreated
                                                ? Carbon\Carbon::createFromFormat(
                                                    'Y-m-d H:i:s',
                                                    $timesheetDatas->assignmentcreated,
                                                )
                                                : null;
                                            $permotiondate = null;

                                            if (
                                                auth()->user()->role_id == 13 ||
                                                auth()->user()->role_id == 11 ||
                                                auth()->user()->role_id == 14
                                            ) {
                                                $permotioncheck = DB::table('teamrolehistory')
                                                    ->where('teammember_id', auth()->user()->teammember_id)
                                                    ->first();

                                                if ($permotioncheck) {
                                                    $permotiondate = Carbon\Carbon::createFromFormat(
                                                        'Y-m-d H:i:s',
                                                        $permotioncheck->created_at,
                                                    );
                                                }
                                            }

                                            $total = DB::table('timesheetusers')

                                                ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                                ->sum('hour');
                                            //	dd($total);
                                            $dates = date('l', strtotime($timesheetDatas->date));

                                        @endphp
                                        <td style="display: none;">{{ $timesheetDatas->id }}</td>
                                        <td>
                                            @if ($client_id->status == 0)
                                                <span class="badge badge-pill badge-warning">saved</span>
                                            @else
                                                <span class="badge badge-pill badge-danger">submit</span>
                                            @endif
                                        </td>

                                        @php

                                            $date = $timesheetDatas->date;

                                            $leaves = DB::table('applyleaves')
                                                ->where('applyleaves.createdby', auth()->user()->teammember_id)
                                                ->where('status', '!=', 2)
                                                ->select('applyleaves.from', 'applyleaves.to')
                                                ->get();

                                            $leavesWithinRange = $leaves->filter(function ($leave) use ($date) {
                                                return $leave->from <= $date && $leave->to >= $date;
                                            });

                                            //dd($leavesWithinRange);

                                        @endphp

                                        <td> <span style="display: none;">
                                                {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                        </td>

                                        <td>
                                            @if ($timesheetDatas->date != null)
                                                {{ $dates ?? '' }}
                                            @endif
                                        </td>


                                        <td>
                                            {{ $client_id->client_name ?? '' }}
                                            @if (count((array) $client_id->client_name) > 1)
                                                ,
                                            @endif
                                        </td>
                                        <td>
                                            {{ $client_id->client_code ?? '' }}
                                            @if (count((array) $client_id->client_code) > 1)
                                                ,
                                            @endif
                                        </td>

                                        <td>
                                            {{ $client_id->assignment_name ?? '' }}
                                            @if ($timesheetDatas->assignmentname != null)
                                                ({{ $timesheetDatas->assignmentname ?? '' }})
                                            @endif
                                            @if (count((array) $client_id->assignment_name) > 1)
                                                ,
                                            @endif
                                        </td>
                                        <td>
                                            {{ $timesheetDatas->assignmentgenerate_id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $client_id->workitem ?? '' }}
                                            @if (count((array) $client_id->workitem) > 1)
                                                ,
                                            @endif
                                        </td>

                                        <td>
                                            {{ $client_id->location ?? '' }}
                                            @if (count((array) $client_id->location) > 1)
                                                ,
                                            @endif
                                        </td>

                                        {{-- <td>
                                        {{ $client_id->team_member ?? '' }} (
                                        {{ $client_id->newstaff_code ?? ($client_id->staffcode ?? '') }})
                                        @if (count((array) $client_id->team_member) > 1)
                                            ,
                                        @endif
                                    </td> --}}





                                        <td>
                                            {{ $client_id->team_member ?? '' }}
                                            @if (count((array) $client_id->team_member) > 1)
                                                ,
                                            @endif
                                        </td>

                                        <td>
                                            @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                                {{ $permotioncheck->newstaff_code }}
                                            @else
                                                {{ $client_id->staffcode ?? '' }}
                                            @endif
                                            @if (count((array) $client_id->team_member) > 1)
                                                ,
                                            @endif
                                        </td>
                                        <td>
                                            {{ $client_id->hour ?? '' }}
                                            @if (count((array) $client_id->hour) > 1)
                                                ,
                                            @endif
                                        </td>
                                        <td>{{ $total }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </form>
            </div>
        </div>

    </div>
    <!--/.body content-->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('timesheetexcel/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Excel</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Upload Excel:</label>
                            <div class="col-sm-9">
                                <input id="name" class="form-control" name="file" type="file">
                                <input hidden value="{{ $clientid->client_id ?? '' }}" class="form-control"
                                    name="client_id" type="text">
                                <input hidden value="{{ $id ?? '' }}" class="form-control" name="ilrfolder_id"
                                    type="text">
                            </div>

                        </div>

                        <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Sample Excel:</label>
                            <div class="col-sm-9">
                                <a href="{{ url('backEnd/timesheetformats.xlsx') }}"
                                    class="btn btn-success btn">Download<i class="fas fa-file-excel"
                                        style="margin-left: 3px;font-size: 20px;"></i></a>

                            </div>
                        </div>
                        <div class="details-form-field form-group row">
                            <label for="address" class="col-sm-3 col-form-label font-weight-600">Instruction <span
                                    style="color:red;">*</span></label>
                            <div class="col-sm-9" style="  margin-top: 10px; ">

                                <span>
                                    Please note the Client Name (click <a target="blank"
                                        href="{{ url('clientassignmentlist') }}"> here</a> to see clients), Assignment
                                    Name (click <a target="blank" href="{{ url('clientassignmentlist') }}"> here</a> to
                                    see assignments) and Partner Name (click <a target="blank"
                                        href="{{ url('clientassignmentlist') }}"> here</a> to
                                    see Partner) should be as same as it is updated on Portal (KGS Capitall). Date (M/D/Y) ,
                                    Hour
                                    format should be as same as mentioned
                                    in the Timesheet Format. If you have not worked on non working day (holiday/2nd or 4th
                                    Sat/Sunday, please skip/do not mention those dates in your excel sheet when uploading
                                    the
                                    excel sheet. </span>


                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal21" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="timesheetrequest" method="post" action="{{ url('timesheetrequest/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Request
                        </h5>
                        {{-- <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li style="color:red;">{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="error-container1 text-center">
                        </div>
                        <div class="success-container1 text-center" style="background-color: #dcecf5">
                        </div>
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Admin : <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="language form-control" required id="category" name="partner">
                                    <option value="">Please Select One</option>
                                    @foreach ($partner as $teammemberData)
                                        <option value="{{ $teammemberData->id }}">
                                            {{ $teammemberData->team_member }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Reason : <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <textarea rows="4" name="reason" required class="form-control" placeholder="Enter Reason"></textarea>

                            </div>

                        </div>

                        <div class="details-form-field form-group row">
                            <label for="file" class="col-sm-3 col-form-label font-weight-600">Attachment :</label>
                            <div class="col-sm-9">
                                <input type="file" name="file" id="file-1" class="custom-input-file">
                                <label for="file-1" id="file-label">
                                    <i class="fa fa-upload"></i>
                                    <span>Choose a file…</span>
                                </label>
                                <span class="text-danger" style="font-weight: 300">File types: png, pdf, jpeg, jpg. Max
                                    size: 5
                                    MB</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('/timesheet/submit') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background:#37A000;color:white;">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Update Timesheet</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button style="color: white" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row row-sm">
                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                            <div class="col-sm-12">
                                <input type="text" readonly id="teamname" class="form-control"
                                    placeholder="Enter Name">
                                <input hidden class="form-control" id="timesheetid" name="timesheetid" type="text">


                            </div>
                        </div>

                        <br>
                        @php
                            $clientlist = DB::table('clients')->select('clients.client_name', 'clients.id')->get();
                            $partner = DB::table('teammembers')
                                ->select('teammembers.team_member', 'teammembers.id')
                                ->get();
                            $assignmentlist = DB::table('assignments')
                                ->select('assignments.assignment_name', 'assignments.id')
                                ->get();
                        @endphp
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <input required type="date" name="date" id="date" class="form-control"
                                    placeholder="Enter Name">


                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                            <div class="col-sm-12">
                                <select class="form-control" name="client_id" id="client_id">
                                    <option value="">Select Client</option>
                                    @foreach ($clientlist as $city)
                                        <option value="{{ $city->id }}">{{ $city->client_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <br>
                        <div class="row row-sm">
                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                            <div class="col-sm-12">
                                <select class="form-control" name="assignment_id" id="assignment_id">
                                    <option value="">Select Assignment</option>
                                    @foreach ($assignmentlist as $assignmentlistData)
                                        <option value="{{ $assignmentlistData->id }}">
                                            {{ $assignmentlistData->assignment_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                            <div class="col-sm-12">
                                <select class="form-control" name="partner" id="partner">
                                    <option value="">Select Partner</option>
                                    @foreach ($partner as $partnerData)
                                        <option value="{{ $partnerData->id }}">{{ $partnerData->team_member }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <input required type="text" name="workitem" id="workitem" class="form-control"
                                    placeholder="Enter Name">


                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <input required type="text" name="location" id="location" class="form-control"
                                    placeholder="Enter Location">


                            </div>
                        </div>
                        <br>
                        <div class="row row-sm">
                            <div class="col-sm-12">
                                <input required type="text" name="totalhour" id="totalhour" class="form-control"
                                    placeholder="Enter Name">


                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#client').on('change', function() {
                var cid = $(this).val();
                // alert(category_id);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: "cid=" + cid,
                    success: function(res) {
                        $('#assignment').html(res);
                    },
                    error: function() {},
                });
            });
        });
    </script>



    <script type="text/javascript">
        $(function() {
            $("#chkAll").click(function() {
                $("input[name='ids[]']").attr("checked", this.checked);
            });
            $('#example11').DataTable({});
        });
    </script>
    <script type="text/javascript">
        $.('.selectall').click(function() {
            $.('selecselectboxtbox').prop('checked', $(this).prop('checked'));
        })
        $('.selectbox').change(function() {
            var total = $.('.selectbox').length;
            var number = $.('.selecbox:checked').length;
            if (total == number) {
                $('.selectall').prop('checked', true);
            } else
                $('.selectall').prop('checked', false);

        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                //        debugger;
                var id = $(this).data('id');
                debugger;
                $.ajax({
                    type: "GET",

                    url: "{{ url('timesheetupdatesubmit') }}",
                    data: "id=" + id,
                    success: function(response) {
                        debugger;
                        $("#timesheetid").val(response.id);
                        $("#date").val(response.date);
                        $("#teamname").val(response.team_member);
                        $("#workitem").val(response.workitem);
                        $("#location").val(response.location);
                        $("#client_id").val(response.client_id);
                        $("#assignment_id").val(response.assignment_id);
                        $("#partner").val(response.partner);
                        $("#totalhour").val(response.totalhour);
                        debugger;

                    },
                    error: function() {

                    },
                });
            });
        });
    </script>
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 14,
            dom: 'Bfrtip',
            "order": [
                // [2, "desc"]
            ],

            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Timesheet Save',
                    // remove extra date from column
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 1) {
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0 || column === 10 || column === 13) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },

                    //  Remove extra space 
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        // remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ')
                                .trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('file-1').addEventListener('change', function() {
            var fileLabel = document.getElementById('file-label').querySelector('span');
            if (this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
            } else {
                fileLabel.textContent = "Choose a file…";
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#timesheetrequest').on('submit', function(e) {
            e.preventDefault();
            // Create a FormData object
            var formData = new FormData(this);

            $.ajax({
                type: 'POST',
                url: "{{ url('timesheetrequest/store') }}",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        $('.success-container1').html(
                            '<p style="color:green;">Request Successfully Done</p>');
                        setTimeout(function() {
                            location.reload();
                        }, 1000); // 10 seconds delay i second = 1000
                    } else {
                        $('.error-container1').html('<p style="color:red;margin: 0px;">' +
                            response
                            .msg + '</p>');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    $('.error-container1').html('');
                    if (errors) {
                        $.each(errors, function(key, value) {
                            $('.error-container1').append(
                                '<p style="color:red;margin: 0px;">' +
                                value + '</p>');
                        });
                    }
                }
            });
        });
    });
</script>

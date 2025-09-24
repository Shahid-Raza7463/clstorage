{{-- library  --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">

        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Team Workbook List</small>
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
                <div class="table-responsive">

                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Employee Name</th>
                                <th class="textfixed">Staff Code</th>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Client Name</th>
                                <th class="textfixed">Client Code</th>
                                <th>Assignment Name</th>
                                <th class="textfixed">Assignment Id</th>

                                <th>Work Item</th>
                                <th>Location</th>
                                <th>Partner</th>
                                <th class="textfixed">Partner Code</th>
                                {{-- <th>Hour</th> --}}
                                <th class="textfixed">Total Hour</th>
                                <th>Status</th>

                                @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
                                    <th>Action</th>
                                @endif


                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($timesheetData as $timesheetDatas)
                                <tr>

                                    @php
                                        $timeid = DB::table('timesheetusers')
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->first();

                                        $client_id = DB::table('timesheetusers')
                                            ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                            ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                            ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                            ->leftJoin(
                                                'teamrolehistory',
                                                'teamrolehistory.teammember_id',
                                                '=',
                                                'teammembers.id',
                                            )
                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->select(
                                                'clients.client_name',
                                                'clients.client_code',
                                                'timesheetusers.hour',
                                                'timesheetusers.location',
                                                'timesheetusers.*',
                                                'assignments.assignment_name',
                                                'billable_status',
                                                'workitem',
                                                'teammembers.team_member',
                                                'teammembers.staffcode',
                                                'timesheetusers.timesheetid',
                                                'teamrolehistory.newstaff_code',
                                            )
                                            ->get();
                                        // dd($client_id);
                                        $total = DB::table('timesheetusers')

                                            ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                            ->sum('hour');

                                        $dates = date('l', strtotime($timesheetDatas->date));

                                        $assignmentcheck = DB::table('assignmentbudgetings')
                                            ->where('assignmentgenerate_id', $timesheetDatas->assignmentgenerate_id)
                                            ->first();

                                        $permotioncheck = DB::table('teamrolehistory')
                                            ->where('teammember_id', $timesheetDatas->createdby)
                                            ->first();

                                        //shshid client
                                        // $datadate = Carbon\Carbon::createFromFormat('Y-m-d', $timesheetDatas->date);
                                        $datadate = $assignmentcheck
                                            ? Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $assignmentcheck->created_at,
                                            )
                                            : null;

                                        $permotiondate = null;
                                        if ($permotioncheck) {
                                            $permotiondate = Carbon\Carbon::createFromFormat(
                                                'Y-m-d H:i:s',
                                                $permotioncheck->created_at,
                                            );
                                        }
                                    @endphp
                                    <td style="display: none;">{{ $timesheetDatas->id }}</td>

                                    <td class="textfixed"> {{ $timesheetDatas->team_member ?? '' }} </td>
                                    @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                        <td>{{ $permotioncheck->newstaff_code }}</td>
                                    @else
                                        <td>{{ $timesheetDatas->staffcode }}</td>
                                    @endif
                                    {{-- <td class="textfixed">{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                    </td> --}}
                                    <td class="textfixed">
                                        <span style="display: none;">
                                            {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}
                                        </span>
                                        {{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                    </td>

                                    <td class="textfixed">
                                        @if ($timesheetDatas->date != null)
                                            {{ $dates ?? '' }}
                                        @endif
                                    </td>
                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->client_name ?? '' }}
                                            @if ($item->client_name != 0)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->client_code ?? '' }}
                                            @if ($item->client_name != 0)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->assignment_name ?? '' }}
                                            @if ($item->assignment_name != null)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->assignmentgenerate_id ?? '' }}
                                            @if ($item->assignment_name != null)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->workitem ?? '' }}@if ($item->workitem != null)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>

                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->location ?? '' }}@if ($item->location != null)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            {{ $item->team_member ?? '' }}
                                            @if ($item->team_member != null)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="textfixed">
                                        @foreach ($client_id as $item)
                                            @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                                {{ $item->newstaff_code }}
                                            @else
                                                {{ $item->staffcode ?? '' }}
                                            @endif
                                            @if ($item->team_member != null)
                                                ,
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $total }}</td>
                                    <td class="textfixed">
                                        {{-- @php
                                            dd($client_id);
                                        @endphp --}}
                                        @foreach ($client_id as $item)
                                            @if ($item->status == 0)
                                                <span class="badge badge-pill badge-warning">saved</span>
                                            @elseif ($item->status == 1)
                                                <span class="badge badge-pill badge-danger">submit</span>
                                            @elseif ($item->status == 3)
                                                <span class="badge badge-pill badge-info">Submitted</span>
                                            @else
                                                <span class="badge badge-pill badge-secondary">Rejected</span>
                                            @endif
                                        @endforeach
                                    </td>

                                    @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || Auth::user()->role_id == 15)
                                        <td>
                                            @foreach ($client_id as $item)
                                                @if ($item->status == 2)
                                                    <a href="{{ url('/timesheetreject/edit/' . $item->timesheetid) }}"
                                                        class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                @endif
                                            @endforeach
                                        </td>
                                    @endif

                                </tr>
                                <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="detailsForm" method="post" action="{{ url('/timesheet/submit') }}"
                                                enctype="multipart/form-data" style="margin-bottom: 0px;">
                                                @csrf
                                                <div class="modal-header" style="background:#37A000;color:white; m-5">
                                                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Update
                                                        Timesheet</h5>
                                                    <div>
                                                        <ul>
                                                            @foreach ($errors->all() as $e)
                                                                <li style="color:red;">{{ $e }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <button style="color: white" type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="row row-sm">
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-12">
                                                            <input type="text" readonly id="teamname"
                                                                class="form-control" placeholder="Enter Name">
                                                            <input hidden class="form-control" id="timesheetid"
                                                                name="timesheetid" type="text">
                                                        </div>
                                                    </div>

                                                    <br>
                                                    @php

                                                        $clientlist = DB::table('clients')
                                                            ->select('clients.client_name', 'clients.id')
                                                            ->get();
                                                        $partner = DB::table('teammembers')
                                                            ->select('teammembers.team_member', 'teammembers.id')
                                                            ->get();
                                                        // dd($partner);
                                                        $assignmentlist = DB::table('assignments')
                                                            ->select('assignments.assignment_name', 'assignments.id')
                                                            ->get();
                                                    @endphp
                                                    <br>

                                                    <div class="row row-sm">
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-6">
                                                            <label for="">Select Client</label>
                                                            <select class="form-control" name="client_id" id="client_id">
                                                                <option value="">Select Client</option>
                                                                @foreach ($clientlist as $city)
                                                                    <option value="{{ $city->id }}">
                                                                        {{ $city->client_name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                                        <div class="col-sm-6">
                                                            <label for="">Select Assignment</label>
                                                            <select class="form-control" name="assignment_id"
                                                                id="assignment_id">
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
                                                        <div class="col-sm-6">
                                                            <label for="">Select Partner</label>
                                                            <select class="form-control" name="partner" id="partner">
                                                                <option value="">Select Partner</option>
                                                                @foreach ($partner as $partnerData)
                                                                    <option value="{{ $partnerData->id }}">
                                                                        {{ $partnerData->team_member }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Employee Name</label>
                                                            <input required type="text" name="workitem" id="workitem"
                                                                class="form-control" placeholder="Enter Employee Name">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row row-sm">
                                                        <div class="col-sm-6">
                                                            <label for="">Location</label>
                                                            <input required type="text" name="location" id="location"
                                                                class="form-control" placeholder="Enter Location">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="">Work Item</label>
                                                            <input required type="text" name="totalhour"
                                                                id="totalhour" class="form-control"
                                                                placeholder="Enter Name">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row row-sm">
                                                        <div class="col-sm-6">
                                                            <label for="">Total Hour</label>
                                                            <input required type="text" name="location" id="location"
                                                                class="form-control" placeholder="Enter Location">
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                                {{-- 2222222222222222222 --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Add this script to the end of your HTML body or in a script section -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script>
            $(document).ready(function() {
                // Add a click event listener to the edit button
                $('.btn-success').on('click', function() {
                    // Get the corresponding row data
                    var rowData = $(this).closest('tr').find('td').map(function() {
                        return $(this).text();
                    }).get();

                    // Populate the form fields in the modal with the retrieved data
                    $('#teamname').val(rowData[0]); // Assuming the team name is in the first column
                    // ... Populate other fields as needed

                    // Show the modal
                    $('#exampleModal12').modal('show');
                });
            });
        </script>


    </div>
    <!--/.body content-->
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
            "order": [
                [3, "desc"]
            ],
            //   searching: false,
            columnDefs: [{

                @if (Auth::user()->role_id == 11)
                    targets: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                @else
                    targets: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                @endif
                orderable: false
            }],
            buttons: []
        });
    });
</script>

{{-- filter on weekly list --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function() {
        //   all partner
        $('#filter1').change(function() {
            var search1 = $(this).val();
            var search2 = $('#filter2').val();
            // console.log(search1);

            var urlParams = new URLSearchParams(window.location.search);
            // Access values from the URL
            var id = urlParams.get('id');
            var teamid = urlParams.get('teamid');
            var partnerid = urlParams.get('partnerid');
            var startdate = urlParams.get('startdate');
            var enddate = urlParams.get('enddate');



            $.ajax({
                type: 'GET',
                url: '/filter-weeklist',
                data: {
                    clientname: search1,
                    assignmentname: search2,
                    id: id,
                    teamid: teamid,
                    partnerid: partnerid
                },
                success: function(data) {
                    // Clear the table body
                    $('table tbody').html("");

                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {
                            var dayOfWeek = moment(item.date).format('dddd');
                            var formattedDate = moment(item.date).format(
                                'DD-MM-YYYY');
                            var statusBadge = item.status == 0 ?
                                '<span class="badge badge-pill badge-warning">saved</span>' :
                                '<span class="badge badge-pill badge-danger">submit</span>';
                            // Add the rows to the table


                            $('table tbody').append('<tr>' +
                                '<td>' + item.team_member + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + dayOfWeek + '</td>' +
                                '<td>' + item.client_name + '</td>' +
                                '<td>' + item.assignment_name + '</td>' +
                                '<td>' + item.workitem + '</td>' +
                                '<td>' + item.location + '</td>' +
                                '<td>' + item.partnername_name + '</td>' +
                                '<td>' + item.hour + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                // Add more columns here
                                '</tr>');
                        });

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });



        //** start date
        $('#filter2').change(function() {
            var search2 = $(this).val();
            var search1 = $('#filter1').val();
            console.log(search2);
            var urlParams = new URLSearchParams(window.location.search);
            // Access values from the URL
            var id = urlParams.get('id');
            var teamid = urlParams.get('teamid');
            var partnerid = urlParams.get('partnerid');
            var startdate = urlParams.get('startdate');
            var enddate = urlParams.get('enddate');
            $.ajax({
                type: 'GET',
                url: '/filter-weeklist',
                data: {
                    assignmentname: search2,
                    clientname: search1,
                    id: id,
                    teamid: teamid,
                    partnerid: partnerid
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html(""); // Clear the table body

                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {
                            var dayOfWeek = moment(item.date).format('dddd');
                            var formattedDate = moment(item.date).format(
                                'DD-MM-YYYY');
                            var statusBadge = item.status == 0 ?
                                '<span class="badge badge-pill badge-warning">saved</span>' :
                                '<span class="badge badge-pill badge-danger">submit</span>';
                            // Add the rows to the table


                            $('table tbody').append('<tr>' +
                                '<td>' + item.team_member + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + dayOfWeek + '</td>' +
                                '<td>' + item.client_name + '</td>' +
                                '<td>' + item.assignment_name + '</td>' +
                                '<td>' + item.workitem + '</td>' +
                                '<td>' + item.location + '</td>' +
                                '<td>' + item.partnername_name + '</td>' +
                                '<td>' + item.hour + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                // Add more columns here
                                '</tr>');
                        });
                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });
        //shahid
    });
</script>

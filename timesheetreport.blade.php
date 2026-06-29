<!-- <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet"> -->

<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <!-- <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-green mb-0 float-sm-right">
                                <li class="breadcrumb-item"><a href="" style="color:white;" onClick="window.location.reload();">Reset Filters</a>
                                </li>
                              
                            </ol>
                        </nav> -->
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Report Section </small>

                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-header">
                <form id="filterform" method="GET" action="{{ url('timesheetreportsection') }}">
                    <div class="row row-sm" style="border: 2px solid gray;">
                        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-6">
                            <div class="card card-stats statistic-box mb-4 mt-3">
                                <div
                                    class="card-header card-header-warning card-header-icon position-relative border-0 text-right px-3 py-0">
                                    <p class="card-category text-uppercase fs-18 font-weight-bold" style="float:left;">
                                        Filters</p>
                                    <!-- <h3 class="card-title fs-18 font-weight-bold">Total Check-In : <span id="totalcount"></span></h3>                       -->
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Employee Name</label>
                                <select class="language form-control" id="employee" name="employeeid">
                                    <option value="">Please Select One</option>
                                    @foreach ($employeename as $employeeData)
                                        <option value="{{ $employeeData->id }}">
                                            {{ $employeeData->team_member }} ({{ $employeeData->rolename ?? '' }})</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>




                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Client</label>
                                <select class="language form-control" id="client_id" name="client_id">
                                    <option></option>
                                    <option value="">Please Select One</option>
                                    @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}">
                                            {{ $clientData->client_name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Assignment</label>
                                <select class="language form-control" id="assignment_id" name="assignment_id">

                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Select Year</label>
                                <select class="language form-control" id="yearly" name="yearly">

                                    <option value="">Please Select Year</option>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Month </label>
                                <select class="form-control key" id="month" name="month">
                                    <option value=''>Please Select Month</option>
                                    <option value='1'>Janaury</option>
                                    <option value='2'>February</option>
                                    <option value='3'>March</option>
                                    <option value='4'>April</option>
                                    <option value='5'>May</option>
                                    <option value='6'>June</option>
                                    <option value='7'>July</option>
                                    <option value='8'>August</option>
                                    <option value='9'>September</option>
                                    <option value='10'>October</option>
                                    <option value='11'>November</option>
                                    <option value='12'>December</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">From</label>
                                <input type="date" class="form-control" id="fromdate" name="fromdate">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">To</label>
                                <input type="date" class="form-control" id="todate" name="todate">
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label class="font-weight-600">Hour</label>
                                <select class="form-control key" id="hour" name="hour">
                                    <option value="">Please Select One</option>
                                    <option value="4">Less than 4 Hours</option>
                                    <option value="5">Less than 5 Hours</option>
                                    <option value="6">Less than 6 Hours</option>
                                    <option value="7">Less than 7 Hours</option>
                                    <option value="8">Less than 8 Hours</option>
                                    <option value="10">Less than 10 Hours</option>
                                    <option value="12">Less than 12 Hours</option>
                                    <option value="14">Less than 14 Hours</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 form-group" style="text-align:center;">
                            <button type="submit" class="btn btn-primary">Apply Filters</button>
                            <a class="btn btn-success" style="color:white; margin-left:10px;"
                                href="{{ url('timesheetreportsection') }}">Reset Filters</a>
                        </div>
                    </div>
                </form>


                <div class="card-body">

                    @component('backEnd.components.alert')
                    @endcomponent

                    <div class="table-responsive">
                        <div id="Saarni">
                            <table
                                class="table key-buttons text-md-nowrap  table-bordered table-striped display dt-datatable">
                                <thead>
                                    <tr>
                                        <th data-column="team_member">Employee Name</th>
                                        <th data-column="emailid">Email Id</th>
                                        <th data-column="rolename">Role</th>
                                        <th data-column="date">Date</th>
                                        <th data-column="month">Month</th>
                                        <th data-column="client_name">Client</th>
                                        <th data-column="assignment_name">Assignment Name</th>
                                        <th data-column="assignmentgenerate_id">Assignment Id</th>
                                        <th data-column="workitem">Work Item</th>
                                        <th data-column="teampartner">Partner</th>
                                        <th data-column="hour">Total Hour</th>
                                        <th data-column="billable_status">Billable Status</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
    <style>
        .addCol {
            position: absolute;
            left: -17px;
        }

        .fix-table table {
            position: relative;
            table-layout: fixed;
            overflow: hidden;
            border-collapse: collapse;
        }

        .fix-table thead {
            position: relative;
            display: block;
            overflow: visible;
        }

        .fix-table thead th {
            min-width: 220px;
            height: 32px;
            white-space: normal;
        }


        .fix-table tbody {
            position: relative;
            display: block;
            overflow: scroll;
            max-height: 500px;
        }

        .fix-table tbody td {
            min-width: 220px;
            white-space: normal;
        }


        .fix-table table.dataTable tbody td {
            padding: 8px 10px;
            padding-right: 30px;
        }
    </style>

    @php
        $datatableUrl = url('timesheetfiltersection');
        $queryString = http_build_query(
            request()->only([
                'employeeid',
                'client_id',
                'assignment_id',
                'month',
                'fromdate',
                'todate',
                'hour',
                'yearly',
            ]),
        );
        if (!empty($queryString)) {
            $datatableUrl .= '?' . $queryString;
        }
        $options = ['selector' => 'Saarni', 'url' => $datatableUrl, 'moduleName' => 'Timesheet Report'];
    @endphp
    @include('backEnd.layouts.includes.saarnijs', ['options' => $options])
@endsection

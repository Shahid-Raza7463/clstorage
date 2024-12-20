@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Timesheet Request List</h1>
                    <small>Team Workbook List</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">My Timesheet Request</a>
                    </li>

                    @if (Auth::user()->role_id == 13)
                        <li class="nav-item">
                            <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                                aria-controls="pills-user" aria-selected="false">Team Timesheet Request</a>
                        </li>
                    @endif
                </ul>

                <br>
                <hr>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">

                            @if (session('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table id="myTimesheetTable" class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Created By</th>
                                            <th>Approver</th>
                                            <th>Reason</th>
                                            <th>Reason for Reject</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($mytimesheetrequest as $timesheetrequestsData)
                                            <tr>
                                                <td>
                                                    @if ($timesheetrequestsData->status == 0)
                                                        <span class="badge badge-pill badge-warning">Created</span>
                                                    @elseif($timesheetrequestsData->status == 1)
                                                        <span class="badge badge-pill badge-success">Approved</span>
                                                    @else
                                                        <span class="badge badge-pill badge-danger">Rejected</span>
                                                    @endif
                                                </td>
                                                <td> <span style="display: none;">
                                                        {{ date('Y-m-d', strtotime($timesheetrequestsData->created_at)) }}</span>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}
                                                </td>
                                                <td>{{ date('g:i A', strtotime($timesheetrequestsData->created_at)) }}
                                                </td>
                                                <td><a
                                                        href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                                        {{ $timesheetrequestsData->createdbyauth }}</a></td>
                                                <td>{{ $timesheetrequestsData->team_member }}</td>
                                                <td>{{ $timesheetrequestsData->reason }}</td>
                                                <td>{{ $timesheetrequestsData->remark }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                        <div class="table-responsive">
                            <table id="teamTimesheetTable" class="table display table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Created By</th>
                                        <th>Approver</th>
                                        <th>Reason</th>
                                        <th>Reason for Reject</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($teamtimesheetrequest as $timesheetrequestsData)
                                        <tr>
                                            <td>
                                                @if ($timesheetrequestsData->status == 0)
                                                    <span class="badge badge-pill badge-warning">Created</span>
                                                @elseif($timesheetrequestsData->status == 1)
                                                    <span class="badge badge-pill badge-success">Approved</span>
                                                @else
                                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td> <span style="display: none;">
                                                    {{ date('Y-m-d', strtotime($timesheetrequestsData->created_at)) }}</span>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}
                                            </td>
                                            <td>{{ date('g:i A', strtotime($timesheetrequestsData->created_at)) }}</td>
                                            <td><a href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                                                    {{ $timesheetrequestsData->createdbyauth }}</a></td>
                                            <td>{{ $timesheetrequestsData->team_member }}</td>
                                            <td>{{ $timesheetrequestsData->reason }}</td>
                                            <td>{{ $timesheetrequestsData->remark }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                    </div>
                </div>
            </div>
        </div>

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
<style>
    .dt-buttons {
        margin-bottom: -34px;
    }

    #teamTimesheetTable {
        width: 100% !important;

    }
</style>

<script>
    $(document).ready(function() {
        $('#myTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'My timesheet Request',
                    //   remove extra date from column
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
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },
                },
                'colvis'
            ]
        });

        $('#teamTimesheetTable').DataTable({
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Team timesheet Request',

                    //   remove extra date from column
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
                                if (column === 0 || column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },

                },
                'colvis'
            ]
        });
    });
</script>

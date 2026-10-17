<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout')
<style>
    button[class*="filter"],
    button[class*="sort"] {
        display: none !important;
    }

    .filter-card {
        border: none !important;
        border-radius: 10px;
        overflow: hidden;
    }

    .filter-card .card-header {
        background: #1c1f22;
        color: #fff;
        padding: 14px 20px;
    }

    /* .filter-card .card-body {
        background: #f8fafc;
        padding: 20px;
    } */

    .filter-card label {
        font-size: 13px;
        color: #495057;
    }

    .filter-card .form-control {
        height: 42px;
        border-radius: 8px;
        border: 1px solid #dce1e7;
        font-size: 14px;
    }

    .filter-card .form-control:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 0.1rem rgba(78, 115, 223, 0.15);
    }

    .filter-card .btn {
        margin-bottom: 6px;
        height: 34px;
        border-radius: 8px;
        font-weight: 600;
        min-width: 75px;
        padding: 0px !important;
    }

    .gap-2 {
        gap: 10px;
    }

    #Saarni .team-members-cell {
        max-width: fit-content !important;
    }

    /* #Saarni .team-members-cell .badge {
        display: inline-block !important;
        white-space: nowrap !important;
        word-break: normal !important;
        overflow-wrap: normal !important;
        line-height: 1.2 !important;
        vertical-align: middle;
    } */

    .dt-cell-tooltip {
        display: none !important;
    }
</style>
@section('backEnd_content')
    <div class="content-header row align-items-center mb-4">
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment List</small>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow filter-card">
        <div class="card-body">
            <form id="filterform" method="GET" action="{{ route('assignment.list') }}" enctype="multipart/form-data">

                <div class="row align-items-end">

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label for="clientid" class="font-weight-600 mb-1">
                            Client
                        </label>

                        <select class="language form-control shadow-sm" multiple id="clientid" name="clientId[]">

                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}"
                                    {{ collect(request('clientId', []))->contains((string) $clientData->id) ? 'selected' : '' }}>
                                    {{ $clientData->client_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label class="font-weight-600 mb-1">
                            Assignment
                        </label>

                        <select class="language form-control shadow-sm" multiple name="assignment[]" id="assignment">
                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label for="partnerId" class="font-weight-600 mb-1">
                            Partner Name
                        </label>

                        <select class="language form-control shadow-sm" multiple id="partnerId" name="partnerId[]">

                            @foreach ($partners as $partnerData)
                                <option value="{{ $partnerData->id }}"
                                    {{ collect(request('partnerId', []))->contains((string) $partnerData->id) ? 'selected' : '' }}>
                                    {{ $partnerData->team_member }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label class="font-weight-600 mb-1">
                            Teammember
                        </label>

                        <select class="language form-control shadow-sm" multiple id="teammemberid" name="teammemberId[]">

                            @foreach ($staff as $staffData)
                                <option value="{{ $staffData->id }}"
                                    {{ collect(request('teammemberId', []))->contains((string) $staffData->id) ? 'selected' : '' }}>
                                    {{ $staffData->team_member }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                        <label for="startdate" class="font-weight-600 mb-1">
                            Start Date
                        </label>

                        <input type="date" class="form-control shadow-sm" id="startdate" name="startdate"
                            value="{{ request('startdate') }}">
                    </div>

                    <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                        <label for="enddate" class="font-weight-600 mb-1">
                            End Date
                        </label>

                        <input type="date" class="form-control shadow-sm" id="enddate" name="enddate"
                            value="{{ request('enddate') }}">
                    </div>

                    <div class="col-xl-3 col-lg-12 mb-3">
                        <div class="d-flex flex-wrap gap-2">

                            <button type="submit" class="btn btn-success px-4">
                                Apply
                            </button>


                            <button type="button" class="btn btn-secondary px-4"
                                onclick="window.location.href='{{ route('assignment.list') }}'">
                                Reset
                            </button>

                        </div>
                    </div>

                </div>

            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body" id="Saarni">
            <div class="table-responsive">
                <table class="table table-bordered w-100 dt-datatable">
                    <thead>
                        <tr>
                            <th class="d-none">ID</th>
                            <th data-column="assignmentgenerate_id">Assignment Generate ID</th>
                            <th data-column="client_name">Client</th>
                            <th data-column="assignment_name">Checklist</th>
                            <th data-column="assignmentname">Assignment Name</th>
                            <th data-column="billingfrequency">Billing Frequency</th>
                            <th data-column="location">Location</th>
                            <th data-column="auditassignment">Audit Assignment</th>
                            <th data-column="total_hours">Total hours</th>
                            <th data-column="natureofassignment">Nature of Assignment</th>
                            <th data-column="audittypecag">Audit Type for CAG</th>
                            <th data-column="eqcrapplicability">Type of Review/Checklist</th>
                            <th data-column="reviewer_partner">Name of Reviewer</th>
                            <th data-column="eqcresthour">Reviewer Est Hour</th>
                            <th data-column="eqcrestcost">Reviewer Est Cost</th>
                            <th data-column="engagementfee">Engagement Fee</th>
                            <th data-column="duedate">Due Date</th>
                            <th data-column="finalreportdate">Final Report Date</th>
                            <th data-column="draftreportdate">Draft Report Date</th>
                            <th data-column="moneyreceiveddate">Money Received Date</th>
                            <th data-column="tentativetimeline">Tentative Timeline Change</th>
                            <th data-column="actualstartdate">Actual Start Date</th>
                            <th data-column="actualenddate">Actual End Date</th>
                            <th data-column="tentativestartdate">Tentative Start Date</th>
                            <th data-column="tentativeenddate">Tentative End Date</th>
                            <th data-column="periodstartdate">Audit Period Start Date</th>
                            <th data-column="periodenddate">Audit Period End Date</th>
                            <th data-column="revenuefy">Revenue Financial Year</th>
                            <th data-column="revenuefromoperations">Revenue from Operations</th>
                            <th data-column="otherrevenue">Other Revenue</th>
                            <th data-column="totalturnover">Total Revenue</th>
                            <th data-column="networthfy">Net Worth Financial Year</th>
                            <th data-column="networth">Net Rosworth</th>
                            <th data-column="borrowingsfy">Borrowings Financial Year</th>
                            <th data-column="borrowingsamt">Borrowings Public Exposure</th>
                            <th data-column="borrowingsotherfy">Borrowings Others Financial Year</th>
                            <th data-column="borrowingsother">Borrowings Others</th>
                            <th data-column="paidupfy">Paid-up Capital Financial Year</th>
                            <th data-column="paidupcapitall">Paid-up Capital</th>
                            <th data-column="cmpnystatusname">Company Status</th>
                            <th data-column="sectorcompany">Sector of Company</th>
                            <th data-column="roleassignment">Is Roll Over Assignment</th>
                            <th data-column="esthours">Est Hours</th>
                            <th data-column="teamestcost">Team Est Cost</th>
                            <th data-column="pocketexpenses">Out of Pocket Expense Reimbursable</th>
                            <th data-column="profit">Profit</th>
                            <th data-column="lead_partner">Engagement Partner</th>
                            <th data-column="partneresthour">Partner Est Hour</th>
                            <th data-column="partnerestcost">Partner Est Cost</th>
                            <th data-column="other_partner">Other Partner</th>
                            <th data-column="otherpartneresthour">Other Partner Est Hour</th>
                            <th data-column="otherpartnerestcost">Other Partner Est Cost</th>
                            <th data-column="totalstaffcount">Total Staff Count (Excluding Partner)</th>
                            <th data-column="reasonforstaffcount">Reason for Increase Staff Count</th>
                            <th data-column="assignment_team_mappings">Team Members</th>
                            <th data-column="teamesthour">Team Est Hour</th>
                            <th data-column="teamestcost">Team Est cost</th>
                            <th data-column="created_at">Created At</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@php
    $datatableUrl = route('assignment.list');
    $queryString = http_build_query(
        request()->only(['clientId', 'assignment', 'partnerId', 'teammemberId', 'startdate', 'enddate']),
    );
    if (!empty($queryString)) {
        $datatableUrl .= '?' . $queryString;
    }
    $options = ['selector' => 'Saarni', 'url' => $datatableUrl, 'moduleName' => 'Assignment List'];
@endphp
@include('backEnd.layouts.includes.saarnijs', ['options' => $options])

<script>
    $(function() {
        function loadAssignments() {
            const cid = $('#clientid').val();
            const selectedAssignments = @json((array) request('assignment', []));
            $('#assignment').html('');
            if (cid && cid.length) {
                $.ajax({
                    type: 'get',
                    url: "{{ url('getassignment') }}",
                    data: {
                        cid: cid
                    },
                    success: function(assignments) {
                        let options = '';
                        assignments.forEach(function(sub) {
                            const isSelected = selectedAssignments.includes(String(sub
                                .assignmentgenerate_id)) ? 'selected' : '';
                            options +=
                                `<option value="${sub.assignmentgenerate_id}" ${isSelected}>${sub.assignment_name} (${sub.assignmentname}) (${sub.assignmentgenerate_id})</option>`;
                        });
                        $('#assignment').html(options);
                    },
                    error: function() {
                        $('#assignment').html('');
                    }
                });
            }
        }

        $('#clientid').on('change', loadAssignments);
        loadAssignments();
    });
</script>

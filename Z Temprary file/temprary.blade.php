<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
href="{{ $teammemberData->getFileUrl($teammemberData->appointment_letter, 'backEnd/image/teammember/addressupload') }}"


, 'backEnd/image/teammember/appointmentletter'

        @if (Request::is('teammember/*/edit') && ($teammember->passport ?? null))
        <div class="col-1">
            <div class="form-group">
                <br>
                <a style="margin-top: 10px;" href="{{ $teammember->getFileUrl($teammember->passport) }}"
                    target="blank" data-toggle="tooltip" title="{{ $teammember->passport ?? '' }}"
                    class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a>
            </div>
        </div>
    @endif


{{-- 
no changes added to commit (use "git add" and/or "git commit -a")

C:\xampp\htdocs\npci-dev>git diff resources/views/auditengagement.blade.php
warning: in the working copy of 'resources/views/auditengagement.blade.php', LF will be replaced by CRLF the next time Git touches it
diff --git a/resources/views/auditengagement.blade.php b/resources/views/auditengagement.blade.php
index 51698b82..b7db7c43 100644
--- a/resources/views/auditengagement.blade.php
+++ b/resources/views/auditengagement.blade.php
@@ -1977,7 +1977,7 @@ function handleTrackerClick(status) {
         function showTrackerDetails(status, data, fromChart = false) {
                  const titleElement = document.getElementById('EngagementStageTrackerLabel');
                  const statusLabel = formatTrackerStatusLabel(status);
-                 titleElement.textContent = `${statusLabel} Engagements`;
+                 titleElement.textContent = 'Engagement Stage Details';

                  document.getElementById('trackerSummaryView').style.display = 'none';
                  document.getElementById('trackerDetailsView').style.display = 'block';
@@ -2448,8 +2448,7 @@ function handleObservationClick(status) {

         function showObsDetails(status, data, fromChart = false) {
             const titleElement = document.getElementById('ObservationbyStatuspanelLabel');
-            const capitalizedStatus = status.charAt(0).toUpperCase() + status.slice(1);
-            titleElement.textContent = `${capitalizedStatus} Observations`;
+            titleElement.textContent = 'Observation By Status Details';

             document.getElementById('obsSummaryView').style.display = 'none';
             document.getElementById('obsDetailsView').style.display = 'block';

C:\xampp\htdocs\npci-dev> --}}

13 files changed
+28
-28



resources/views/group/vendormanagement/invoice-recordings/datatable.blade.php
Full file content failed to load
Retry
        $ribbonDate = match ($record->approval_status) {
            'approved' => $record->approved_at?->format('d M Y, g:i A') ?? $latestApprovalHistory?->created_at?->format('d M Y, g:i A') ?? '--',
            'rejected' => $latestApprovalHistory?->created_at?->format('d M Y, g:i A') ?? '--',
            default => $record->created_at?->format('d M Y, g:i A') ?? '--',
            'approved' => $record->approved_at?->format('jS F Y h:i A') ?? $latestApprovalHistory?->created_at?->format('jS F Y h:i A') ?? '--',
            'rejected' => $latestApprovalHistory?->created_at?->format('jS F Y h:i A') ?? '--',
            default => $record->created_at?->format('jS F Y h:i A') ?? '--',
        };
                data-date-raw="{{ $record->invoice_date?->format('Y-m-d') ?? '' }}"
                data-date-label="{{ $record->invoice_date?->format('d M Y') ?? '--' }}"
            data-date-label="{{ $record->invoice_date?->format('jS F Y') ?? '--' }}"
                data-dept="{{ $record->department?->name ?? '--' }}"
        <td>{{ $record->invoice_no }}</td>
        <td>{{ $record->invoice_date?->format('d M Y') ?? '--' }}</td>
        <td>{{ $record->invoice_date?->format('jS F Y') ?? '--' }}</td>
        <td><strong>{{ $record->formatted_total_amount }}</strong></td>
resources/views/group/vendormanagement/invoice-recordings/form.blade.php
Full file content failed to load
Retry
                        data-vendor-id="{{ $po->vendor_id }}"
                        data-po-date="{{ $po->po_date?->format('d M Y') }}"
                                                data-po-date="{{ $po->po_date?->format('jS F Y') }}"
                        data-po-date-raw="{{ $po->po_date?->format('Y-m-d') }}"
        <input type="text" class="form-control bg-light" id="form-inv-po-date" readonly
               value="{{ isset($record) && $record->purchaseOrder?->po_date ? \Carbon\Carbon::parse($record->purchaseOrder->po_date)->format('d M Y') : '' }}">
                                        value="{{ isset($record) && $record->purchaseOrder?->po_date ? \Carbon\Carbon::parse($record->purchaseOrder->po_date)->format('jS F Y') : '' }}">
    </div>
resources/views/group/vendormanagement/invoice-recordings/review.blade.php
Full file content failed to load
Retry
                                            <span class="text-muted d-block" style="font-size:11px; text-transform:uppercase; font-weight:700;">Invoice Date</span>
                                            <span class="fw-semibold">{{ $record->invoice_date?->format('d M Y') ?? '—' }}</span>
                                            <span class="fw-semibold">{{ $record->invoice_date?->format('jS F Y') ?? '—' }}</span>
                                        </div>
                                                <p class="text-muted fs-11 mb-1">
                                                    {{ $history->created_at->format('jS F Y, g:i A') }}
                                    {{ $history->created_at->format('jS F Y h:i A') }}
                                                </p>
resources/views/group/vendormanagement/purchase-orders/datatable.blade.php
Full file content failed to load
Retry
        <td>{{ $po->financial_year }}</td>
        <td>{{ \Carbon\Carbon::parse($po->po_date)->format('d M Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($po->po_date)->format('jS F Y') }}</td>
        <td>{{ $po->description_of_service ?? '—' }}</td>
resources/views/group/vendormanagement/purchase-orders/other-charges-nested.blade.php
Full file content failed to load
Retry
        <td>{{ $oc->financial_year }}</td>
        <td>{{ \Carbon\Carbon::parse($oc->po_date)->format('d M Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($oc->po_date)->format('jS F Y') }}</td>
        <td>{{ $oc->description_of_service ?? '—' }}</td>
resources/views/group/vendormanagement/purchase-orders/review.blade.php
Full file content failed to load
Retry
                                            <span class="text-muted d-block" style="font-size:11px; text-transform:uppercase; font-weight:700;">PO Date</span>
                                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($po->po_date)->format('d M Y') }}</span>
                                            <span class="fw-semibold">{{ \Carbon\Carbon::parse($po->po_date)->format('jS F Y') }}</span>
                                        </div>
                                                <p class="text-muted fs-11 mb-1">
                                                    {{ $history->created_at->format('jS F Y, g:i A') }}
                                    {{ $history->created_at->format('jS F Y h:i A') }}
                                                </p>
resources/views/group/vendormanagement/purchase-orders/short-closure-form.blade.php
Full file content failed to load
Retry
                            <div class="text-muted text-uppercase fw-bold" style="font-size:10px;letter-spacing:.3px;">PO Date</div>
                            <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($po->po_date)->format('d M Y') }}</div>
                                <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($po->po_date)->format('jS F Y') }}</div>
                        </div>
resources/views/group/vendormanagement/purchase-orders/show.blade.php
Full file content failed to load
Retry
    $actionedByName = ($po->approval_status === 'approved' ? $lastApproval : $lastRejection)?->actionedBy?->name ?? null;
    $actionedAt     = ($po->approval_status === 'approved' ? $lastApproval : $lastRejection)?->created_at?->format('d M Y, g:i A') ?? null;
    $actionedAt     = ($po->approval_status === 'approved' ? $lastApproval : $lastRejection)?->created_at?->format('jS F Y h:i A') ?? null;
    $canDeletePo    = (isSuperAdmin() || $isCreator) && $po->approval_status === 'rejected';
                        <span style="color:#92400e;"><i class="ri-user-line me-1"></i>Submitted by {{ $po->creator->name ?? '—' }}</span>
                        <span class="text-muted">&bull; {{ $po->created_at->format('d M Y, g:i A') }}</span>
                                        <span class="text-muted">&bull; {{ $po->created_at->format('jS F Y h:i A') }}</span>
                    @endif
                        <div class="po-meta-label"><i class="ri-calendar-line me-1"></i>PO / Agr. Date</div>
                        <div class="po-meta-value">{{ \Carbon\Carbon::parse($po->po_date)->format('d M Y') }}</div>
                                                <div class="po-meta-value">{{ \Carbon\Carbon::parse($po->po_date)->format('jS F Y') }}</div>
                    </div>
                        <div class="po-meta-value">
                            {{ $po->period_from ? $po->period_from->format('d M Y') : '—' }}
                                                                {{ $po->period_from ? $po->period_from->format('jS F Y') : '—' }}
                            @if($po->period_from && $po->period_to) → @endif
                            {{ $po->period_to ? $po->period_to->format('d M Y') : '' }}
                                                                {{ $po->period_to ? $po->period_to->format('jS F Y') : '' }}
                        </div>
                            <td class="fw-semibold">{{ $oc->formatted_amount }}</td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($oc->po_date)->format('d M Y') }}</td>
                                                                        <td class="text-muted">{{ \Carbon\Carbon::parse($oc->po_date)->format('jS F Y') }}</td>
                            <td><span class="badge rounded-pill px-2" style="background:{{ $ocTone['bg'] }};color:{{ $ocTone['color'] }};font-size:10px;">{{ ucfirst(str_replace('_',' ',$oc->approval_status)) }}</span></td>
                                <div class="mt-1" style="font-size:11px;color:#64748b;">
                                    By {{ $sc->creator->name ?? '—' }} &bull; {{ $sc->created_at->format('d M Y') }}
                                                                                By {{ $sc->creator->name ?? '—' }} &bull; {{ $sc->created_at->format('jS F Y') }}
                                </div>
        <div class="modal-footer bg-white border-top-0 px-4 py-3">
            <span class="text-muted me-auto" style="font-size:11px;">Created by <strong>{{ $po->creator->name ?? '—' }}</strong> &bull; {{ $po->created_at->format('d M Y') }}</span>
                                <span class="text-muted me-auto" style="font-size:11px;">Created by <strong>{{ $po->creator->name ?? '—' }}</strong> &bull; {{ $po->created_at->format('jS F Y') }}</span>
            <button type="button" class="btn btn-light border rounded-pill px-4" data-bs-dismiss="modal">Close</button>
resources/views/group/vendormanagement/invoice-recordings/rejection-remark.blade.php
Full file content failed to load
Retry
                            <i class="ri-calendar-event-line me-1"></i>
                            {{ $lastRejection->created_at->format('jS F Y, g:i A') }}
                        {{ $lastRejection->created_at->format('jS F Y h:i A') }}
                        </p>
resources/views/group/vendormanagement/invoice-recordings/revision-history.blade.php
Full file content failed to load
Retry
                            <p class="text-muted fs-11 mb-2">
                                <i class="ri-calendar-line me-1"></i>{{ $history->created_at->format('jS F Y, g:i A') }}
                                <i class="ri-calendar-line me-1"></i>{{ $history->created_at->format('jS F Y h:i A') }}
                            </p>
resources/views/group/vendormanagement/purchase-orders/rejection-remark.blade.php
Full file content failed to load
Retry
                            <i class="ri-calendar-event-line me-1"></i>
                            {{ $lastRejection->created_at->format('jS F Y, g:i A') }}
                        {{ $lastRejection->created_at->format('jS F Y h:i A') }}
                        </p>
resources/views/group/vendormanagement/purchase-orders/revision-history.blade.php
Full file content failed to load
Retry
                            <p class="text-muted fs-11 mb-2">
                                <i class="ri-calendar-line me-1"></i>{{ $history->created_at->format('jS F Y, g:i A') }}
                                <i class="ri-calendar-line me-1"></i>{{ $history->created_at->format('jS F Y h:i A') }}
                            </p>
resources/views/group/vendormanagement/purchase-orders/short-closure-history.blade.php
Full file content failed to load
Retry
                            <p class="text-muted fs-11 mb-2">
                                <i class="ri-calendar-line me-1"></i>{{ $sc->created_at->format('jS F Y, g:i A') }}
                            <i class="ri-calendar-line me-1"></i>{{ $sc->created_at->format('jS F Y h:i A') }}
                            </p>
                                    <p class="text-muted fs-11 mb-2">
                                        <i class="ri-calendar-line me-1"></i>{{ \Carbon\Carbon::parse($actionedAt)->format('jS F Y, g:i A') }}
                                    <i class="ri-calendar-line me-1"></i>{{ \Carbon\Carbon::parse($actionedAt)->format('jS F Y h:i A') }}
                                    </p>

    {{-- jdjd --}}
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
        <div class="col-sm-6 header-title p-0">
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


    <td>
            @if (!empty($row->assignment_team_mappings))
                @foreach (explode('~~', $row->assignment_team_mappings) as $member)
                    @php
                        $parts = explode('|', $member);
                        $title = trim($parts[0] ?? '');
                        $name = trim($parts[1] ?? '');
                        $type = trim($parts[2] ?? '');
                        $label = '(Staff)';
                        if ($type === '0') {
                            $label = '(Team Leader)';
                        } elseif ($type === '1') {
                            $label = '(EQCR Team)';
                        }
                    @endphp
                    <span class="badge badge-primary m-1">{{ trim(($title ? $title . '. ' : '') . $name) }}
                        {{ $label }}</span>
                @endforeach
            @else
                N/A
            @endif
        </td>


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

    .filter-card .card-body {
        background: #f8fafc;
        padding: 20px;
    }

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
        height: 40px;
        border-radius: 8px;
        font-weight: 600;
        min-width: 100px;
    }

    .gap-2 {
        gap: 10px;
    }
</style>
@section('backEnd_content')
    {{-- <div class="card shadow filter-card">
        <div class="card-header">
            <h5 class="mb-0">Filter Report</h5>
        </div>
        <div class="card-body p-3">
            <form id="filterform" method="GET" action="{{ url('vendorreportlist') }}" enctype="multipart/form-data">
                <div class="filter-row">
                    <div class="filter-field">
                        <label for="clientid" class="font-weight-600">Client</label>
                        <select class="language form-control" id="clientid" name="clientId[]" multiple>
                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}"
                                    {{ collect(request('clientId', []))->contains((string) $clientData->id) ? 'selected' : '' }}>
                                    {{ $clientData->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="assignment" class="font-weight-600">Assignment</label>
                        <select class="language form-control" id="assignment" name="assignment[]" multiple></select>
                    </div>
                    <div class="filter-field">
                        <label for="startdate" class="font-weight-600">Start Date</label>
                        <input type="date" class="form-control" id="startdate" name="startdate"
                            value="{{ request('startdate') }}">
                    </div>
                    <div class="filter-field">
                        <label for="enddate" class="font-weight-600">End Date</label>
                        <input type="date" class="form-control" id="enddate" name="enddate"
                            value="{{ request('enddate') }}">
                    </div>
                    <div class="filter-field">
                        <label for="status" class="font-weight-600">Status</label>
                        <select class="language form-control" id="status" name="vendorstatus[]" multiple>
                            <option value="0"
                                {{ collect(request('vendorstatus', []))->contains('0') ? 'selected' : '' }}>Created</option>
                            <option value="1"
                                {{ collect(request('vendorstatus', []))->contains('1') ? 'selected' : '' }}>Approved
                            </option>
                            <option value="2"
                                {{ collect(request('vendorstatus', []))->contains('2') ? 'selected' : '' }}>Submit</option>
                            <option value="3"
                                {{ collect(request('vendorstatus', []))->contains('3') ? 'selected' : '' }}>Reject</option>
                            <option value="4"
                                {{ collect(request('vendorstatus', []))->contains('4') ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div class="filter-buttons">
                        <button type="submit" class="btn btn-apply text-white">Apply</button>
                        <button type="button" class="btn btn-reset text-white"
                            onclick="window.location.href='{{ url('vendorreportlist') }}'">Reset</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <div class="card shadow filter-card">
        <div class="card-header">
            <h5 class="mb-0">Filter Report</h5>
        </div>

        <div class="card-body">
            <form id="filterform" method="GET" action="{{ url('vendorreportlist') }}" enctype="multipart/form-data">

                <div class="row align-items-end">

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label for="clientid" class="font-weight-600 mb-1">Client</label>

                        <select class="language form-control shadow-sm" id="clientid" name="clientId[]" multiple>
                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}"
                                    {{ collect(request('clientId', []))->contains((string) $clientData->id) ? 'selected' : '' }}>
                                    {{ $clientData->client_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                        <label for="assignment" class="font-weight-600 mb-1">Assignment</label>

                        <select class="language form-control shadow-sm" id="assignment" name="assignment[]" multiple>
                        </select>
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                        <label for="startdate" class="font-weight-600 mb-1">Start Date</label>

                        <input type="date" class="form-control shadow-sm" id="startdate" name="startdate"
                            value="{{ request('startdate') }}" style="height: 32px;">
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                        <label for="enddate" class="font-weight-600 mb-1">End Date</label>

                        <input type="date" class="form-control shadow-sm" id="enddate" name="enddate"
                            value="{{ request('enddate') }}" style="height: 32px;">
                    </div>

                    <div class="col-xl-2 col-lg-4 col-md-6 mb-3">
                        <label for="status" class="font-weight-600 mb-1">Status</label>

                        <select class="language form-control shadow-sm" id="status" name="vendorstatus[]" multiple>

                            <option value="0"
                                {{ collect(request('vendorstatus', []))->contains('0') ? 'selected' : '' }}>
                                Created
                            </option>

                            <option value="1"
                                {{ collect(request('vendorstatus', []))->contains('1') ? 'selected' : '' }}>
                                Approved
                            </option>

                            <option value="2"
                                {{ collect(request('vendorstatus', []))->contains('2') ? 'selected' : '' }}>
                                Submit
                            </option>

                            <option value="3"
                                {{ collect(request('vendorstatus', []))->contains('3') ? 'selected' : '' }}>
                                Reject
                            </option>

                            <option value="4"
                                {{ collect(request('vendorstatus', []))->contains('4') ? 'selected' : '' }}>
                                Paid
                            </option>

                        </select>
                    </div>

                    <div class="col-xl-3 col-lg-12 mb-3">
                        <div class="d-flex flex-wrap gap-2">

                            <button type="submit" class="btn btn-success px-4">
                                Apply
                            </button>

                            <button type="button" class="btn btn-secondary px-4"
                                onclick="window.location.href='{{ url('vendorreportlist') }}'">
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
                            <th data-column="status">Status</th>
                            <th data-column="created_at">Created Date</th>
                            <th data-column="paymentdate">NEFT/Cheque Date</th>
                            <th data-column="paiddate">Paid Date</th>
                            <th data-column="payment">NEFT/Cheque Details</th>
                            <th data-column="team_member">Created By</th>
                            <th data-column="approver">Approver</th>
                            <th data-column="vendorname">Vendor Name</th>
                            <th data-column="email">Email</th>
                            <th data-column="phoneno">Phone No</th>
                            <th data-column="itemname">Item Name</th>
                            <th data-column="amount">Amount</th>
                            <th>Recoverable From Client</th>
                            <th data-column="clientname">Client Name</th>
                            <th data-column="assignmentgenerate_id">Assignment Id</th>
                            <th data-column="assignment_name">Assignment Name</th>
                            <th>Bill</th>
                            <th>Benificiary Name</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>IFSC Code</th>
                            <th data-column="type">Type</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@php
    $datatableUrl = url('vendorreportlist');
    $queryString = http_build_query(
        request()->only(['clientId', 'assignment', 'startdate', 'enddate', 'vendorstatus']),
    );
    if (!empty($queryString)) {
        $datatableUrl .= '?' . $queryString;
    }

    $options = [
        'selector' => 'Saarni',
        'url' => $datatableUrl,
        'moduleName' => 'Vendor Report List',
    ];
@endphp

@include('backEnd.layouts.includes.saarnijs', ['options' => $options])

<script>
    $(function() {
        function loadAssignments() {
            var cid = $('#clientid').val();
            var selectedAssignments = @json((array) request('assignment', []));
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


<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout')
<style>
    button[class*="filter"],
    button[class*="sort"] {
        display: none !important;
    }

    .filter-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border: none !important;
    }

    .filter-card .card-header {
        background: #1c1f22;
        color: white;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .filter-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .filter-field {
        width: 240px;
        min-width: 240px;
    }

    .filter-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 0 0 auto;
    }

    .btn-apply {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        background-color: #27ae60 !important;
        color: #ffffff !important;
        border: 1px solid #27ae60 !important;
        font-weight: 600;
        padding: 0.55rem 1.5rem;
        font-size: 0.9rem;
        min-width: 100px;
    }

    .btn-reset {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        background-color: #95a5a6 !important;
        color: #ffffff !important;
        border: 1px solid #95a5a6 !important;
        font-weight: 600;
        padding: 0.55rem 1.5rem;
        font-size: 0.9rem;
        min-width: 100px;
    }
</style>
@section('backEnd_content')
    <div class="card shadow filter-card">
        <div class="card-header">
            <h5 class="mb-0">Filter Report</h5>
        </div>
        <div class="card-body p-3">
            <form id="filterform" method="GET" action="{{ url('vendorreportlist') }}" enctype="multipart/form-data">
                <div class="filter-row">
                    <div class="filter-field">
                        <label for="clientid" class="font-weight-600">Client</label>
                        <select class="language form-control" id="clientid" name="clientId[]" multiple>
                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}"
                                    {{ collect(request('clientId', []))->contains((string) $clientData->id) ? 'selected' : '' }}>
                                    {{ $clientData->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="assignment" class="font-weight-600">Assignment</label>
                        <select class="language form-control" id="assignment" name="assignment[]" multiple></select>
                    </div>
                    <div class="filter-field">
                        <label for="startdate" class="font-weight-600">Start Date</label>
                        <input type="date" class="form-control" id="startdate" name="startdate"
                            value="{{ request('startdate') }}">
                    </div>
                    <div class="filter-field">
                        <label for="enddate" class="font-weight-600">End Date</label>
                        <input type="date" class="form-control" id="enddate" name="enddate"
                            value="{{ request('enddate') }}">
                    </div>
                    <div class="filter-field">
                        <label for="status" class="font-weight-600">Status</label>
                        <select class="language form-control" id="status" name="vendorstatus[]" multiple>
                            <option value="0"
                                {{ collect(request('vendorstatus', []))->contains('0') ? 'selected' : '' }}>Created</option>
                            <option value="1"
                                {{ collect(request('vendorstatus', []))->contains('1') ? 'selected' : '' }}>Approved
                            </option>
                            <option value="2"
                                {{ collect(request('vendorstatus', []))->contains('2') ? 'selected' : '' }}>Submit</option>
                            <option value="3"
                                {{ collect(request('vendorstatus', []))->contains('3') ? 'selected' : '' }}>Reject</option>
                            <option value="4"
                                {{ collect(request('vendorstatus', []))->contains('4') ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div class="filter-buttons">
                        <button type="submit" class="btn btn-apply text-white">Apply</button>
                        <button type="button" class="btn btn-reset text-white"
                            onclick="window.location.href='{{ url('vendorreportlist') }}'">Reset</button>
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
                            <th data-column="status">Status</th>
                            <th data-column="created_at">Created Date</th>
                            <th data-column="paymentdate">NEFT/Cheque Date</th>
                            <th data-column="paiddate">Paid Date</th>
                            <th data-column="payment">NEFT/Cheque Details</th>
                            <th data-column="team_member">Created By</th>
                            <th data-column="approver">Approver</th>
                            <th data-column="vendorname">Vendor Name</th>
                            <th data-column="email">Email</th>
                            <th data-column="phoneno">Phone No</th>
                            <th data-column="itemname">Item Name</th>
                            <th data-column="amount">Amount</th>
                            <th>Recoverable From Client</th>
                            <th data-column="clientname">Client Name</th>
                            <th data-column="assignmentgenerate_id">Assignment Id</th>
                            <th data-column="assignment_name">Assignment Name</th>
                            <th>Bill</th>
                            <th>Benificiary Name</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>IFSC Code</th>
                            <th data-column="type">Type</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@php
    $datatableUrl = url('vendorreportlist');
    $queryString = http_build_query(
        request()->only(['clientId', 'assignment', 'startdate', 'enddate', 'vendorstatus']),
    );
    if (!empty($queryString)) {
        $datatableUrl .= '?' . $queryString;
    }

    $options = [
        'selector' => 'Saarni',
        'url' => $datatableUrl,
        'moduleName' => 'Vendor Report List',
    ];
@endphp

@include('backEnd.layouts.includes.saarnijs', ['options' => $options])

<script>
    $(function() {
        function loadAssignments() {
            var cid = $('#clientid').val();
            var selectedAssignments = @json((array) request('assignment', []));
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
                            const isSelected = selectedAssignments.includes(String(sub.assignmentgenerate_id)) ? 'selected' : '';
                            options += `<option value="${sub.assignmentgenerate_id}" ${isSelected}>${sub.assignment_name} (${sub.assignmentname}) (${sub.assignmentgenerate_id})</option>`;
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


222222222222222222222222222222222222222222222222

<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout')
<style>
    button[class*="filter"],
    button[class*="sort"] {
        display: none !important;
    }

    .filter-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border: none !important;
    }

    .filter-card .card-header {
        background: #1c1f22;
        color: white;
        border-radius: 0.5rem 0.5rem 0 0;
    }

    .filter-row {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: nowrap;
        overflow-x: auto;
    }

    .filter-field {
        width: 240px;
        min-width: 240px;
    }

    .filter-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex: 0 0 auto;
    }

    .btn-apply {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        background-color: #27ae60 !important;
        color: #ffffff !important;
        border: 1px solid #27ae60 !important;
        font-weight: 600;
        padding: 0.55rem 1.5rem;
        font-size: 0.9rem;
        min-width: 100px;
    }

    .btn-reset {
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        background-color: #95a5a6 !important;
        color: #ffffff !important;
        border: 1px solid #95a5a6 !important;
        font-weight: 600;
        padding: 0.55rem 1.5rem;
        font-size: 0.9rem;
        min-width: 100px;
    }
</style>
@section('backEnd_content')
    <div class="card shadow filter-card">
        <div class="card-header">
            <h5 class="mb-0">Filter Report</h5>
        </div>
        <div class="card-body p-3">
            <form id="filterform" method="GET" action="{{ url('vendorreportlist') }}" enctype="multipart/form-data">
                <div class="filter-row">
                    <div class="filter-field">
                        <label for="clientid" class="font-weight-600">Client</label>
                        <select class="language form-control" id="clientid" name="clientId[]" multiple>
                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}"
                                    {{ collect(request('clientId', []))->contains((string) $clientData->id) ? 'selected' : '' }}>
                                    {{ $clientData->client_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-field">
                        <label for="assignment" class="font-weight-600">Assignment</label>
                        <select class="language form-control" id="assignment" name="assignment[]" multiple></select>
                    </div>
                    <div class="filter-field">
                        <label for="startdate" class="font-weight-600">Start Date</label>
                        <input type="date" class="form-control" id="startdate" name="startdate"
                            value="{{ request('startdate') }}">
                    </div>
                    <div class="filter-field">
                        <label for="enddate" class="font-weight-600">End Date</label>
                        <input type="date" class="form-control" id="enddate" name="enddate"
                            value="{{ request('enddate') }}">
                    </div>
                    <div class="filter-field">
                        <label for="status" class="font-weight-600">Status</label>
                        <select class="language form-control" id="status" name="vendorstatus[]" multiple>
                            <option value="0"
                                {{ collect(request('vendorstatus', []))->contains('0') ? 'selected' : '' }}>Created</option>
                            <option value="1"
                                {{ collect(request('vendorstatus', []))->contains('1') ? 'selected' : '' }}>Approved
                            </option>
                            <option value="2"
                                {{ collect(request('vendorstatus', []))->contains('2') ? 'selected' : '' }}>Submit</option>
                            <option value="3"
                                {{ collect(request('vendorstatus', []))->contains('3') ? 'selected' : '' }}>Reject</option>
                            <option value="4"
                                {{ collect(request('vendorstatus', []))->contains('4') ? 'selected' : '' }}>Paid</option>
                        </select>
                    </div>
                    <div class="filter-buttons">
                        <button type="submit" class="btn btn-apply text-white">Apply</button>
                        <button type="button" class="btn btn-reset text-white"
                            onclick="window.location.href='{{ url('vendorreportlist') }}'">Reset</button>
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
                            <th data-column="status">Status</th>
                            <th data-column="created_at">Created Date</th>
                            <th data-column="paymentdate">NEFT/Cheque Date</th>
                            <th data-column="paiddate">Paid Date</th>
                            <th data-column="payment">NEFT/Cheque Details</th>
                            <th data-column="team_member">Created By</th>
                            <th data-column="approver">Approver</th>
                            <th data-column="vendorname">Vendor Name</th>
                            <th data-column="email">Email</th>
                            <th data-column="phoneno">Phone No</th>
                            <th data-column="itemname">Item Name</th>
                            <th data-column="amount">Amount</th>
                            <th>Recoverable From Client</th>
                            <th data-column="clientname">Client Name</th>
                            <th data-column="assignmentgenerate_id">Assignment Id</th>
                            <th data-column="assignment_name">Assignment Name</th>
                            <th>Bill</th>
                            <th>Benificiary Name</th>
                            <th>Bank Name</th>
                            <th>Account Number</th>
                            <th>IFSC Code</th>
                            <th data-column="type">Type</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@php
    $datatableUrl = url('vendorreportlist');
    $queryString = http_build_query(
        request()->only(['clientId', 'assignment', 'startdate', 'enddate', 'vendorstatus']),
    );
    if (!empty($queryString)) {
        $datatableUrl .= '?' . $queryString;
    }

    $options = [
        'selector' => 'Saarni',
        'url' => $datatableUrl,
        'moduleName' => 'Vendor Report List',
    ];
@endphp

@include('backEnd.layouts.includes.saarnijs', ['options' => $options])

<script>
    $(function() {
        $('#clientid').on('change', function() {
            var cid = $(this).val();
            $('#assignment').html('');

            if (cid) {
                $.ajax({
                    type: 'get',
                    url: "{{ url('getassignment') }}",
                    data: {
                        cid: cid
                    },
                    success: function(assignments) {
                        let options = '';
                        assignments.forEach(function(sub) {
                            options +=
                                `<option value="${sub.assignmentgenerate_id}">${sub.assignment_name} (${sub.assignmentname}) (${sub.assignmentgenerate_id})</option>`;
                        });
                        $('#assignment').html(options);
                    },
                    error: function() {
                        $('#assignment').html('');
                    }
                });
            }
        });
    });
</script>


    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('vendor/create') }}">Add Vendor</a></li>
            <li class="breadcrumb-item active">+</li>
        </ol>
    </nav>

    @extends('backEnd.layouts.layout')
    <style>
        .filter-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border: none !important;
        }

        .filter-card .card-header {
            background: #1c1f22;
            color: white;
            border-radius: 0.5rem 0.5rem 0 0;
        }

        .btn-apply {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background-color: #27ae60 !important;
            color: #ffffff !important;
            border: 1px solid #27ae60 !important;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.4rem 0.75rem;
            border-radius: 0.4rem;
            white-space: nowrap;
        }

        .btn-apply:hover {
            background-color: #219150 !important;
            border-color: #219150 !important;
        }

        .btn-reset {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            background-color: #95a5a6 !important;
            color: #ffffff !important;
            border: 1px solid #95a5a6 !important;
            font-weight: 600;
            font-size: 0.82rem;
            padding: 0.4rem 0.75rem;
            border-radius: 0.4rem;
            white-space: nowrap;
        }

        .btn-reset:hover {
            background-color: #7f8c8d !important;
            border-color: #7f8c8d !important;
        }

        .form-label {
            letter-spacing: 0.02em;
        }

        .form-control-sm {
            border-radius: 0.4rem;
            border: 1px solid #ced4da;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control-sm:focus {
            border-color: #27ae60;
            box-shadow: 0 0 0 0.15rem rgba(39, 174, 96, 0.2);
        }
    </style>
    @section('backEnd_content')
        <div class="card shadow filter-card">
            <div class="card-header">
                <h5 class="mb-0">Filter Report</h5>
            </div>
            <div class="card-body p-3">
                <form id="filterform" method="GET" action="{{ route('client.list') }}" enctype="multipart/form-data">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3 col-sm-6">
                            <label for="startdate" class="form-label fw-semibold text-secondary small mb-1">
                                <i class="fas fa-calendar-alt me-1"></i> Start Date
                            </label>
                            <input type="date" class="form-control form-control-sm shadow-sm" id="startdate"
                                name="startdate" value="{{ request('startdate') }}">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label for="enddate" class="form-label fw-semibold text-secondary small mb-1">
                                <i class="fas fa-calendar-check me-1"></i> End Date
                            </label>
                            <input type="date" class="form-control form-control-sm shadow-sm" id="enddate"
                                name="enddate" value="{{ request('enddate') }}">
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label for="status" class="form-label fw-semibold text-secondary small mb-1">
                                <i class="fas fa-toggle-on me-1"></i> Status
                            </label>
                            <select class="form-control form-control-sm shadow-sm" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label for="review" class="form-label fw-semibold text-secondary small mb-1">
                                <i class="fas fa-clipboard-check me-1"></i> Review
                            </label>
                            <select class="form-control form-control-sm shadow-sm" id="review" name="review">
                                <option value="">All Reviews</option>
                                <option value="1" {{ request('review') === '1' ? 'selected' : '' }}>NFRA</option>
                                <option value="2" {{ request('review') === '2' ? 'selected' : '' }}>Quality Review
                                </option>
                                <option value="3" {{ request('review') === '3' ? 'selected' : '' }}>Peer Review
                                </option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-apply btn-sm flex-fill">
                                    <i class="fas fa-search me-1"></i> Apply
                                </button>
                                <button type="button" class="btn btn-reset btn-sm flex-fill"
                                    onclick="window.location.href='{{ route('client.list') }}'">
                                    <i class="fas fa-undo me-1"></i> Reset
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
                                <th data-column="name">Name</th>
                                <th data-column="client_name">Client Name</th>
                                <th data-column="mobileno">Mobile No</th>
                                <th data-column="emailid">Email ID</th>
                                <th>Address</th>
                                <th>Associated From</th>
                                <th data-column="kind_attention">Kind Attention</th>
                                <th>Client Designation</th>
                                <th data-column="statename">State</th>
                                <th>Legal Status</th>
                                <th>Date of Incorporation</th>
                                <th>Client DOB</th>
                                <th>PAN No</th>
                                <th>TAN No</th>
                                <th>GST No</th>
                                <th>Revenue FY</th>
                                <th>Revenue From Operations</th>
                                <th>Other Revenue</th>
                                <th>Total Turnover</th>
                                <th>Net Worth FY</th>
                                <th>Net Worth</th>
                                <th>Borrowings FY</th>
                                <th>Borrowings Amount</th>
                                <th>Borrowings Other FY</th>
                                <th>Borrowings Other</th>
                                <th>Paid Up FY</th>
                                <th>Paid Up Capital</th>
                                <th data-column="classification">Classification</th>
                                <th>Other Classification</th>
                                <th data-column="created_at">Created Date</th>
                                <th data-column="status">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @php
        $datatableUrl = route('client.list');
        $queryString = http_build_query(request()->only(['startdate', 'enddate', 'status', 'review']));
        if (!empty($queryString)) {
            $datatableUrl .= '?' . $queryString;
        }

        $options = [
            'selector' => 'Saarni',
            'url' => $datatableUrl,
            'moduleName' => 'Client List',
        ];
    @endphp

    @include('backEnd.layouts.includes.saarnijs', ['options' => $options])






    22222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222

    @extends('backEnd.layouts.layout')
    <style>
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

        .filter-card .card-body {
            background: #f8fafc;
            padding: 20px;
        }

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
            height: 42px;
            border-radius: 8px;
            font-weight: 600;
            min-width: 110px;
        }

        .gap-2 {
            gap: 10px;
        }
    </style>
    @section('backEnd_content')
        <div class="card shadow filter-card">
            <div class="card-header">
                <h5 class="mb-0">Filter Report</h5>
            </div>
            <div class="card-body ">
                <form id="filterform" method="GET" action="{{ route('client.list') }}" enctype="multipart/form-data">
                    <div class="row align-items-end">

                        <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                            <label for="startdate" class="font-weight-600 mb-1">Start Date</label>
                            <input type="date" class="form-control shadow-sm" id="startdate" name="startdate"
                                value="{{ request('startdate') }}">
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                            <label for="enddate" class="font-weight-600 mb-1">End Date</label>
                            <input type="date" class="form-control shadow-sm" id="enddate" name="enddate"
                                value="{{ request('enddate') }}">
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6 mb-3">
                            <label for="status" class="font-weight-600 mb-1">Status</label>
                            <select class="form-control shadow-sm" id="status" name="status">
                                <option value="">Select Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6 mb-3">
                            <label for="review" class="font-weight-600 mb-1">Review Type</label>
                            <select class="form-control shadow-sm" id="review" name="review">
                                <option value="">Select Review</option>
                                <option value="1" {{ request('review') === '1' ? 'selected' : '' }}>NFRA</option>
                                <option value="2" {{ request('review') === '2' ? 'selected' : '' }}>Quality Review
                                </option>
                                <option value="3" {{ request('review') === '3' ? 'selected' : '' }}>Peer Review
                                </option>
                            </select>
                        </div>

                        <div class="col-xl-3 col-lg-12 mb-3">
                            <div class="d-flex flex-wrap gap-2">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-filter mr-1"></i> Apply
                                </button>

                                <button type="button" class="btn btn-secondary px-4"
                                    onclick="window.location.href='{{ route('client.list') }}'">
                                    <i class="fas fa-undo mr-1"></i> Reset
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
                                <th data-column="name">Name</th>
                                <th data-column="client_name">Client Name</th>
                                <th data-column="mobileno">Mobile No</th>
                                <th data-column="emailid">Email ID</th>
                                <th>Address</th>
                                <th>Associated From</th>
                                <th data-column="kind_attention">Kind Attention</th>
                                <th>Client Designation</th>
                                <th data-column="statename">State</th>
                                <th>Legal Status</th>
                                <th>Date of Incorporation</th>
                                <th>Client DOB</th>
                                <th>PAN No</th>
                                <th>TAN No</th>
                                <th>GST No</th>
                                <th>Revenue FY</th>
                                <th>Revenue From Operations</th>
                                <th>Other Revenue</th>
                                <th>Total Turnover</th>
                                <th>Net Worth FY</th>
                                <th>Net Worth</th>
                                <th>Borrowings FY</th>
                                <th>Borrowings Amount</th>
                                <th>Borrowings Other FY</th>
                                <th>Borrowings Other</th>
                                <th>Paid Up FY</th>
                                <th>Paid Up Capital</th>
                                <th data-column="classification">Classification</th>
                                <th>Other Classification</th>
                                <th data-column="created_at">Created Date</th>
                                <th data-column="status">Status</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @php
        $datatableUrl = route('client.list');
        $queryString = http_build_query(request()->only(['startdate', 'enddate', 'status', 'review']));
        if (!empty($queryString)) {
            $datatableUrl .= '?' . $queryString;
        }

        $options = [
            'selector' => 'Saarni',
            'url' => $datatableUrl,
            'moduleName' => 'Client List',
        ];
    @endphp

    @include('backEnd.layouts.includes.saarnijs', ['options' => $options])


</body>

</html>

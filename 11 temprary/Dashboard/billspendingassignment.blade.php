<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <div class="col-sm-6 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Invoice List</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                <br>
                <div class="table-responsive">

                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Assignment Generate ID</th>
                                <th>Client</th>
                                <th>Checklist</th>
                                <th>Assignment Name</th>
                                <th>Billing Frequency</th>
                                <th>Location</th>
                                <th>Audit Assignment</th>
                                <th>Total hours</th>
                                <th>Nature of Assignment</th>
                                <th>Audit Type for CAG</th>
                                <th>Type of Review/Checklist</th>
                                <th>Name of Reviewer</th>
                                <th>Reviewer Est Hour</th>
                                <th>Reviewer Est Cost</th>
                                <th>Engagement Fee</th>
                                <th>Due Date</th>
                                <th>Final Report Date</th>
                                <th>Draft Report Date</th>
                                <th>Money Received Date</th>
                                <th>Tentative Timeline Change</th>
                                <th>Actual Start Date</th>
                                <th>Actual End Date</th>
                                <th>Tentative Start Date</th>
                                <th>Tentative End Date</th>
                                <th>Audit Period Start Date</th>
                                <th>Audit Period End Date</th>
                                <th>Revenue Financial Year</th>
                                <th>Revenue from Operations</th>
                                <th>Other Revenue</th>
                                <th>Total Revenue</th>
                                <th>Net Worth Financial Year</th>
                                <th>Net Rosworth</th>
                                <th>Borrowings Financial Year</th>
                                <th>Borrowings Public Exposure</th>
                                <th>Borrowings Others Financial Year</th>
                                <th>Borrowings Others</th>
                                <th>Paid-up Capital Financial Year</th>
                                <th>Paid-up Capital</th>
                                <th>Company Status</th>
                                <th>Sector of Company</th>
                                <th>Is Roll Over Assignment</th>
                                <th>Est Hours</th>
                                <th>Team Est Cost</th>
                                <th>Out of Pocket Expense Reimbursable</th>
                                <th>Profit</th>
                                <th>Engagement Partner</th>
                                <th>Partner Est Hour</th>
                                <th>Partner Est Cost</th>
                                <th>Other Partner</th>
                                <th>Other Partner Est Hour</th>
                                <th>Other Partner Est Cost</th>
                                <th>Total Staff Count (Excluding Partner)</th>
                                <th>Reason for Increase Staff Count</th>
                                <th>Team Members</th>
                                <th>Team Est Hour</th>
                                <th>Team Est cost</th>
                                <th>Created At</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($assignments as $row)
                                <tr>
                                    <td style="display: none;">{{ $row->id }}</td>
                                    <td>{{ $row->assignmentgenerate_id }}</td>
                                    <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting->assignment)->assignment_name ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}</td>
                                    <td>
                                        @switch(optional($row->assignmentBudgeting)->billingfrequency)
                                            @case(0)
                                                Monthly
                                            @break

                                            @case(1)
                                                Quarterly
                                            @break

                                            @case(2)
                                                Half Yearly
                                            @break

                                            @case(3)
                                                Yearly
                                            @break

                                            @default
                                                One Time
                                        @endswitch
                                    </td>
                                    <td>{{ $row->location ?? 'N/A' }}</td>
                                    <td>
                                        @if ($row->auditassignment == 2)
                                            Yes
                                        @elseif($row->auditassignment == 3)
                                            {{-- No --}}
                                            N/A
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $row->total_hours ?? 'N/A' }}</td>
                                    <td>
                                        @switch($row->natureofassignment)
                                            @case(1)
                                                Internal Audit
                                            @break

                                            @case(2)
                                                Tax Audit
                                            @break

                                            @case(3)
                                                Statutory Audit - AS (Listed and Unlisted/Private)
                                            @break

                                            @case(4)
                                                Statutory Audit - Ind AS (Listed and Unlisted/Private)
                                            @break

                                            @case(5)
                                                GST Audit
                                            @break

                                            @case(6)
                                                GST Consulting
                                            @break

                                            @case(7)
                                                Accounting Consulting
                                            @break

                                            @case(8)
                                                Direct Tax Consulting
                                            @break

                                            @case(9)
                                                ASM
                                            @break

                                            @case(10)
                                                Valuation
                                            @break

                                            @case(11)
                                                Due Diligence
                                            @break

                                            @case(12)
                                                Forensic
                                            @break

                                            @case(13)
                                                Special Purpose Audit
                                            @break

                                            @case(14)
                                                S P Consulting
                                            @break

                                            @case(15)
                                                Others
                                            @break

                                            @default
                                                N/A
                                        @endswitch
                                    </td>

                                    <td>{{ $row->audittypecag ?? 'N/A' }}</td>
                                    <td>
                                        @switch($row->eqcrapplicability)
                                            @case(1)
                                                NFRA
                                            @break

                                            @case(2)
                                                Quality Review
                                            @break

                                            @case(3)
                                                Peer Review
                                            @break

                                            @case(4)
                                                Others
                                            @break

                                            @case(5)
                                                PCAOB
                                            @break

                                            @default
                                                N/A
                                        @endswitch
                                    </td>

                                    <td>{{ optional($row->reviewerPartner)->team_member ?? 'N/A' }}</td>
                                    <td>{{ $row->eqcresthour ?? 'N/A' }}</td>
                                    <td>{{ $row->eqcrestcost ?? 'N/A' }}</td>
                                    <td>{{ $row->engagementfee ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->duedate }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->finalreportdate }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->draftreportdate }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->moneyreceiveddate }}</td>
                                    <td>
                                        {{ optional($row->assignmentBudgeting)->tentativetimeline === '0'
                                            ? 'Yes'
                                            : (optional($row->assignmentBudgeting)->tentativetimeline === '1'
                                                ? 'No'
                                                : 'N/A') }}
                                    </td>
                                    <td>{{ optional($row->assignmentBudgeting)->actualstartdate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->actualenddate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->tentativestartdate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->tentativeenddate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->periodstartdate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->periodenddate ?? 'N/A' }}</td>
                                    <td>{{ $row->revenuefy ?? 'N/A' }}</td>
                                    <td>{{ $row->revenuefromoperations ?? 'N/A' }}</td>
                                    <td>{{ $row->otherrevenue ?? 'N/A' }}</td>
                                    <td>{{ $row->totalturnover ?? 'N/A' }}</td>
                                    <td>{{ $row->networthfy ?? 'N/A' }}</td>
                                    <td>{{ $row->networth ?? 'N/A' }}</td>
                                    <td>{{ $row->borrowingsfy ?? 'N/A' }}</td>
                                    <td>{{ $row->borrowingsamt ?? 'N/A' }}</td>
                                    <td>{{ $row->borrowingsotherfy ?? 'N/A' }}</td>
                                    <td>{{ $row->borrowingsother ?? 'N/A' }}</td>
                                    <td>{{ $row->paidupfy ?? 'N/A' }}</td>
                                    <td>{{ $row->paidupcapitall ?? 'N/A' }}</td>
                                    <td>{{ $row->cmpnystatusname ?? 'N/A' }}</td>
                                    <td>
                                        @switch($row->sectorcompany)
                                            @case(2)
                                                Aviation
                                            @break

                                            @case(3)
                                                Banking
                                            @break

                                            @case(4)
                                                Chemicals, Petrochemicals
                                            @break

                                            @case(5)
                                                Coal
                                            @break

                                            @case(6)
                                                Construction
                                            @break

                                            @case(7)
                                                Consultancy Services
                                            @break

                                            @case(8)
                                                Education
                                            @break

                                            @case(9)
                                                Engineering
                                            @break

                                            @case(10)
                                                Fertilizers
                                            @break

                                            @case(11)
                                                Information Technology
                                            @break

                                            @case(12)
                                                Manufacturing/Mining/Non Banking Financials Companies/Non Government
                                                Organisation/Oil &
                                                Gas/Power/Shipping/Steel/Tele-communication/Tourism/Trading/Transport other than
                                                shipping & aviation
                                            @break

                                            @default
                                                N/A
                                        @endswitch
                                    </td>
                                    <td>
                                        {{ $row->roleassignment === '2' ? 'Yes' : ($row->roleassignment === '1' ? 'No' : 'N/A') }}
                                    </td>

                                    <td>{{ $row->esthours ?? 'N/A' }}</td>
                                    <td>{{ $row->teamestcost ?? 'N/A' }}</td>
                                    <td>
                                        {{ $row->pocketexpenses === '2' ? 'Yes' : ($row->pocketexpenses === '3' ? 'No' : 'N/A') }}
                                    </td>
                                    <td>{{ $row->profit ?? 'N/A' }}</td>
                                    <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}</td>
                                    <td>{{ $row->partneresthour ?? 'N/A' }}</td>
                                    <td>{{ $row->partnerestcost ?? 'N/A' }}</td>
                                    <td>{{ optional($row->otherPartner)->team_member ?? 'N/A' }}</td>
                                    <td>{{ $row->otherpartneresthour ?? 'N/A' }}</td>
                                    <td>{{ $row->otherpartnerestcost ?? 'N/A' }}</td>
                                    <td>{{ $row->totalstaffcount ?? 'N/A' }}</td>
                                    <td>{{ $row->reasonforstaffcount ?? 'N/A' }}</td>
                                    <td>
                                        @foreach ($row->assignmentTeamMappings as $mapping)
                                            {{-- <span class="badge badge-primary m-1">
                                                {{ optional($mapping->teamMember)->team_member }}
                                            </span> --}}
                                            <span class="badge badge-primary m-1">
                                                {{ optional($mapping->teamMember)->team_member }}
                                                @if ($mapping->type == 0)
                                                    (Team Leader)
                                                @elseif($mapping->type == 1)
                                                    (EQCR Team)
                                                @else
                                                    (Staff)
                                                @endif
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>{{ $row->teamesthour ?? 'N/A' }}</td>
                                    <td>{{ $row->teamestcost ?? 'N/A' }}</td>
                                    <td>{{ $row->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
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
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>

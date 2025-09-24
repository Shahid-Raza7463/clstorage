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
                                <th>Assignment Code</th>
                                <th>Client Name</th>
                                <th>Assignment Name</th>
                                <th>Partner Name</th>
                                <th>Actual Start Date</th>
                                <th>Tentative Start Date</th>
                                <th>tentative End Date</th>
                                <th>Draft report Date</th>
                                <th>Documentation Completed Date</th>
                                <th>Total esthour</th>
                                <th>Total Worked Hour</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($assignments as $row)
                                <tr>
                                    <td style="display: none;">{{ $row->id }}</td>
                                    <td>{{ $row->assignmentgenerate_id }}</td>
                                    <td>{{ $row->client_name }}</td>
                                    <td>{{ $row->assignmentname }}</td>
                                    <td>{{ $row->leadpartner }}</td>
                                    {{-- <td>{{ optional($row->assignmentBudgeting->client)->client_name ?? 'N/A' }}</td> --}}
                                    {{-- <td>{{ optional($row->assignmentBudgeting)->assignmentname ?? 'N/A' }}</td>
                                    <td>{{ optional($row->leadPartner)->team_member ?? 'N/A' }}</td> --}}
                                    {{-- <td>{{ optional($row->assignmentBudgeting)->actualstartdate ?? 'N/A' }}</td> --}}
                                    <td>{{ App\Models\Timesheetuser::select('date')->where('assignmentgenerate_id', $row->assignmentgenerate_id)->first()->date ?? 'N/A' }}
                                    </td>
                                    {{-- <td>{{ optional($row->assignmentBudgeting)->tentativestartdate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->tentativeenddate ?? 'N/A' }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->draftreportdate }}</td>
                                    <td>{{ optional($row->assignmentBudgeting)->percentclosedate }}</td> --}}
                                    <td>{{ $row->tentativestartdate }}</td>
                                    <td>{{ $row->tentativeenddate }}</td>
                                    <td>{{ $row->draftreportdate }}</td>
                                    <td>{{ $row->percentclosedate }}</td>
                                    <td>{{ $row->esthours ?? '0' }}</td>
                                    <td>{{ $row->workedhour ?? '0' }}</td>
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

{{-- selec input box style --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
{{-- selec input box style end hare --}}

{{-- Datatable style --}}
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
{{-- Datatable style end --}}

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold" style="color:black;">Activity Logs</h1>
                    <small>Activity Logs List</small>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <div class="table-responsive">
                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>
                                <th>Module</th>
                                <th>Action</th>
                                <th>Record ID</th>
                                <th>Changes</th>
                                <th>Old Data</th>
                                <th>New Data</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activitylogs as $key => $log)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $log->user_name ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($log->module) }}</td>
                                    <td>
                                        <span
                                            class="badge 
                    @if ($log->action == 'created') bg-success
                    @elseif($log->action == 'updated') bg-warning
                    @elseif($log->action == 'deleted') bg-danger @endif">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td>{{ $log->record_id }}</td>



                                    <td>
                                        @if (!empty($log->formatted_changes))
                                            @foreach ($log->formatted_changes as $change)
                                                <div>
                                                    <strong>{{ $change['field'] }}</strong>:
                                                    <span style="color:red;">{{ $change['old'] }}</span>
                                                    →
                                                    <span style="color:green;">{{ $change['new'] }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>No Changes</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-primary"
                                            onclick="showOldData({{ json_encode($log->formatted_old) }})">
                                            View
                                        </button>
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-success"
                                            onclick="showNewData({{ json_encode($log->formatted_new) }})">
                                            View
                                        </button>
                                    </td>

                                    <td>{{ $log->formatted_date }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- 
<div class="modal fade" id="dataModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="modalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody id="modalTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div> --}}

{{-- <script>
    function renderTable(data, title) {
        let tbody = document.getElementById('modalTableBody');
        let modalTitle = document.getElementById('modalTitle');

        tbody.innerHTML = '';
        modalTitle.innerText = title;

        if (data && Object.keys(data).length > 0) {
            for (let key in data) {
                let row = `<tr>
                <td><strong>${key}</strong></td>
                <td>${data[key]}</td>
            </tr>`;
                tbody.innerHTML += row;
            }
        } else {
            tbody.innerHTML = '<tr><td colspan="2">No Data</td></tr>';
        }

        let modal = new bootstrap.Modal(document.getElementById('dataModal'));
        modal.show();
    }

    function showOldData(data) {
        renderTable(data, 'Old Data');
    }

    function showNewData(data) {
        renderTable(data, 'New Data');
    }
</script> --}}


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
            "pageLength": 100,
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [0, 1, 2, 3, 4, 5, 6],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Activity Logs',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ]
        });
    });
</script>

<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="{{ url('home') }}">
                        <h1 class="font-weight-bold" style="color:black;">Home</h1>
                    </a>
                    <small>Client Specific Independence Declaration List</small>
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
                                <th>Name of Employee</th>
                                <th>Assignment Code</th>
                                <th>Client Name</th>
                                <th>Assignment Name</th>
                                <th>Partner Name</th>
                                <th>Filled/Not Filled</th>
                                <th>Independent/Not Independent</th>
                                <th>Independence Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clientspecificindependencedeclaration as $independenceData)
                                @php
                                    $independences = DB::table('annual_independence_declarations')
                                        ->where('assignmentgenerateid', $independenceData->assignmentgenerate_id)
                                        ->where('createdby', $independenceData->id)
                                        ->first();

                                    if (!$independences) {
                                        $independences = DB::table('independences')
                                            ->where('assignmentgenerate_id', $independenceData->assignmentgenerate_id)
                                            ->where('createdby', $independenceData->id)
                                            ->first();
                                    }
                                @endphp

                                @if (Request::is('İndependence/pending') && $independences != null)
                                    @continue
                                @endif

                                <tr>
                                    <td style="display: none;">{{ $independenceData->id }}</td>
                                    <td>
                                        @if ($independences != null)
                                            <a href="{{ route('clientspecificindependence.show', $independences->id) }}">
                                                {{ $independenceData->team_member }}
                                            </a>
                                        @else
                                            {{ $independenceData->team_member }}
                                        @endif
                                    </td>

                                    <td>{{ $independenceData->assignmentgenerate_id ?? 'N/A' }}</td>
                                    <td>{{ $independenceData->client_name ?? 'N/A' }}</td>

                                    <td>
                                        {{ $independenceData->assignment_name ?? 'N/A' }}
                                        @if ($independenceData->assignmentname != null)
                                            ({{ $independenceData->assignmentname }})
                                        @endif
                                    </td>

                                    <td>{{ $independenceData->partnername ?? 'N/A' }}</td>

                                    <td>
                                        @if ($independences == null)
                                            Not Filled
                                        @else
                                            Filled
                                        @endif
                                    </td>

                                    <td>
                                        @if ($independences)
                                            @php $independencesArray = (array) $independences; @endphp
                                            @if (in_array(2, $independencesArray))
                                                Need Review
                                            @else
                                                Independent
                                            @endif
                                        @else
                                            Not Filled
                                        @endif
                                    </td>

                                    <td>{{ date('d-m-Y', strtotime($independenceData->created_at)) }}</td>
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

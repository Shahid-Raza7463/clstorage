<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-6 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-6 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>List</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="card mb-4">

            <div class="card-body">
                <br>
                @component('backEnd.components.alert')
                @endcomponent

                <div class="table-responsive">
                    {{-- filter functionality --}}
                    <div class="container">
                        <form method="get" action="{{ url('totaltimeshow/filter') }}" enctype="multipart/form-data"
                            class="form-inline">
                            @csrf
                            @php
                                $teamselect = DB::table('assignmentteammappings')
                                    ->leftjoin(
                                        'assignmentmappings',
                                        'assignmentmappings.id',
                                        'assignmentteammappings.assignmentmapping_id',
                                    )
                                    ->leftjoin(
                                        'assignmentbudgetings',
                                        'assignmentbudgetings.assignmentgenerate_id',
                                        'assignmentmappings.assignmentgenerate_id',
                                    )
                                    ->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')
                                    ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
                                    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                                    // ->where('assignmentbudgetings.status', 1)
                                    ->whereNotIn('teammembers.team_member', ['NA', 'null', 'test staff'])
                                    ->select(
                                        'assignmentmappings.id',
                                        'teammembers.id as teamid',
                                        'teammembers.team_member',
                                        'teammembers.role_id',
                                        'teammembers.staffcode',
                                        'titles.title',
                                        'assignmentmappings.assignmentgenerate_id',
                                        'assignmentbudgetings.assignmentname',
                                        'assignmentteammappings.teamhour',
                                    )
                                    // ->take(10)
                                    ->get();

                                // dd($teammemberDatas);

                                $partnerselect = DB::table('assignmentmappings')
                                    ->leftjoin(
                                        'assignmentbudgetings',
                                        'assignmentbudgetings.assignmentgenerate_id',
                                        'assignmentmappings.assignmentgenerate_id',
                                    )
                                    ->leftjoin('teammembers', function ($join) {
                                        $join
                                            ->on('teammembers.id', 'assignmentmappings.otherpartner')
                                            ->orOn('teammembers.id', 'assignmentmappings.leadpartner');
                                    })
                                    ->leftjoin('titles', 'titles.id', 'teammembers.title_id')
                                    ->leftjoin('roles', 'roles.id', 'teammembers.role_id')
                                    // ->where('assignmentbudgetings.status', 1)
                                    ->whereNotIn('teammembers.team_member', ['NA', 'test staff'])
                                    ->select(
                                        'assignmentmappings.id',
                                        'teammembers.id as teamid',
                                        'teammembers.team_member',
                                        'teammembers.staffcode',
                                        'teammembers.role_id',
                                        'titles.title',
                                        'assignmentmappings.assignmentgenerate_id',
                                        'assignmentbudgetings.assignmentname',
                                        'assignmentmappings.otherpartner',
                                        'assignmentmappings.leadpartner',
                                        'assignmentmappings.leadpartnerhour',
                                        'assignmentmappings.otherpartnerhour',
                                    )
                                    // ->take(10)
                                    ->get();
                                $allselect = $teamselect->merge($partnerselect);

                                $distinctteammember = $allselect->unique('staffcode')->sortBy('team_member');
                                $distinctassignmentid = $allselect
                                    ->unique('assignmentgenerate_id')
                                    ->sortBy('assignmentgenerate_id');
                            @endphp
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <strong><label for="employee">Teammember</label></strong>
                                        <select class="language form-control" id="employee" name="employee">
                                            <option value="">Please Select One</option>
                                            @foreach ($distinctteammember as $teammemberData)
                                                <option
                                                    value="{{ $teammemberData->teamid }}/{{ $teammemberData->role_id }}"{{ old('employee') == $teammemberData->teamid . '/' . $teammemberData->role_id ? 'selected' : '' }}>
                                                    {{ $teammemberData->team_member }}({{ $teammemberData->staffcode }})
                                                </option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group">
                                        <strong><label for="assignmentgenerateid">Assignment Id</label></strong>
                                        <select class="language form-control" id="assignmentgenerateid"
                                            name="assignmentgenerateid">
                                            <option value="">Please Select One</option>
                                            @foreach ($distinctassignmentid as $teammemberData)
                                                <option
                                                    value="{{ $teammemberData->assignmentgenerate_id }}"{{ old('assignmentgenerateid') == $teammemberData->assignmentgenerate_id ? 'selected' : '' }}>
                                                    {{ $teammemberData->assignmentgenerate_id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <div class="form-group">
                                        <strong><label for="search">&nbsp;</label></strong>
                                        <button type="submit" class="btn btn-success btn-block">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>


                    <table id="examplee" class="display nowrap">
                        <thead>
                            <tr>
                                <th>Teammember</th>
                                <th>Assignment Id</th>
                                <th>Assignment</th>
                                <th>Total Hour</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teammemberDatas as $teammemberData)
                                <tr>
                                    <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}
                                        ({{ $teammemberData->staffcode }})
                                    </td>
                                    <td>{{ $teammemberData->assignmentgenerate_id }}</td>
                                    <td>{{ $teammemberData->assignmentname }}</td>
                                    @if (property_exists($teammemberData, 'leadpartner') && $teammemberData->teamid == $teammemberData->leadpartner)
                                        <td>{{ $teammemberData->leadpartnerhour ?? 0 }}</td>
                                    @elseif (property_exists($teammemberData, 'otherpartner') && $teammemberData->teamid == $teammemberData->otherpartner)
                                        <td>{{ $teammemberData->otherpartnerhour ?? 0 }}</td>
                                    @else
                                        <td>{{ $teammemberData->teamhour ?? 0 }}</td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        \
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
                // [1, "asc"]
            ],
            columnDefs: [{
                targets: [0, 1, 2, 3],
                orderable: false
            }],
            searching: false,

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'All Client List',
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

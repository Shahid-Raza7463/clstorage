<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
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
                    <small>Assignment Report List</small>
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
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                            aria-controls="pills-home" aria-selected="true">Open</a>
                    </li>


                    <li class="nav-item">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab"
                            aria-controls="pills-user" aria-selected="false">Close</a>
                    </li>

                </ul>

                <br>
                <hr>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="table-responsive example">

                            <div class="table-responsive">
                                <table id="examplee" class="display nowrap">
                                    <thead>
                                        <tr>
                                            <th style="display: none;">id</th>
                                            @if (auth()->user()->role_id == 13 || Auth::user()->role_id == 11 || Auth::user()->role_id == 14)
                                                <th>Edit</th>
                                            @endif
                                            <th>Assignment Id</th>
                                            <th>Assignment</th>
                                            <th>Client</th>
                                            <th>Client Code</th>
                                            <th>Period Start</th>
                                            <th>Period End</th>
                                            <th>Deadline</th>
                                            <th>Assigned Status</th>
                                            <th>Assigned Partner</th>
                                            <th>Assigned Partner Code</th>
                                            <th>Other Partner</th>
                                            <th>Other Partner Code</th>
                                            <th>Team Leader </th>
                                            <th>Teammember</th>
                                            <th>Total Hour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach ($assignmentmappingData as $assignmentmappingDatas)
                                            <tr>
                                                @php
                                                    if (auth()->user()->role_id == 11) {
                                                        $teamhourteams = DB::table('assignmentteammappings')
                                                            ->where('assignmentmapping_id', $assignmentmappingDatas->id)
                                                            ->select(DB::raw('SUM(teamhour) as teamhourteam'))
                                                            ->first();

                                                        $partnerhour =
                                                            $assignmentmappingDatas->leadpartnerhour +
                                                            $assignmentmappingDatas->otherpartnerhour;

                                                        $totalhour = $partnerhour + $teamhourteams->teamhourteam;
                                                        // dd($totalhour);
                                                    }
                                                @endphp
                                                <td style="display: none;">{{ $assignmentmappingDatas->id }}</td>
                                                @if (auth()->user()->role_id == 13 || Auth::user()->role_id == 11 || Auth::user()->role_id == 14)
                                                    <td>
                                                        <a href="{{ url('/assignmentlist/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                    </td>
                                                @endif
                                                <td> <a
                                                        href="{{ url('/viewassignment/' . $assignmentmappingDatas->assignmentgenerate_id) }}">{{ $assignmentmappingDatas->assignmentgenerate_id }}</a>
                                                </td>
                                                <td>
                                                    {{ $assignmentmappingDatas->assignment_name }} @if ($assignmentmappingDatas->assignmentname != null)
                                                        ({{ $assignmentmappingDatas->assignmentname }})
                                                    @endif
                                                </td>
                                                <td> {{ $assignmentmappingDatas->client_name }}
                                                </td>
                                                <td> {{ $assignmentmappingDatas->client_code }}
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->periodstart != null)
                                                        {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodstart)) }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($assignmentmappingDatas->periodend != null)
                                                        {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->duedate != null)
                                                        {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->status == 1)
                                                        <span class="badge badge-primary">OPEN</span>
                                                    @elseif($assignmentmappingDatas->status == 0)
                                                        <span class="badge badge-danger">CLOSED</span>
                                                    @endif

                                                </td>

                                                @php
                                                    $leadpartner = DB::table('teammembers')
                                                        ->leftJoin(
                                                            'teamrolehistory',
                                                            'teamrolehistory.teammember_id',
                                                            '=',
                                                            'teammembers.id',
                                                        )
                                                        ->where('teammembers.id', $assignmentmappingDatas->leadpartner)
                                                        ->select(
                                                            'teammembers.team_member',
                                                            'teammembers.staffcode',
                                                            'teamrolehistory.newstaff_code',
                                                        )
                                                        ->first();

                                                    $otherPartner = DB::table('teammembers')
                                                        ->leftJoin(
                                                            'teamrolehistory',
                                                            'teamrolehistory.teammember_id',
                                                            '=',
                                                            'teammembers.id',
                                                        )
                                                        ->where('teammembers.id', $assignmentmappingDatas->otherpartner)
                                                        ->select(
                                                            'teammembers.team_member',
                                                            'teammembers.staffcode',
                                                            'teamrolehistory.newstaff_code',
                                                        )
                                                        ->first();

                                                @endphp
                                                <td>
                                                    {{ $leadpartner->team_member ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($leadpartner && $leadpartner->team_member)
                                                        {{ $leadpartner->newstaff_code ?? ($leadpartner->staffcode ?? '') }}
                                                    @endif
                                                </td>

                                                <td>
                                                    {{ $otherPartner->team_member ?? '' }}
                                                </td>
                                                <td>
                                                    @if ($otherPartner && $otherPartner->team_member)
                                                        {{ $otherPartner->newstaff_code ?? ($otherPartner->staffcode ?? '') }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 0)->get() as $sub)
                                                        {{ $sub->team_member }} ,
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingDatas->id)->where('assignmentteammappings.type', 2)->get() as $sub)
                                                        {{ $sub->team_member }} ,
                                                    @endforeach
                                                </td>

                                                @if (auth()->user()->role_id == 11)
                                                    <td> {{ $totalhour ?? '0' }}</td>
                                                @elseif (auth()->user()->role_id == 13)
                                                    <td>{{ $assignmentmappingDatas->leadpartnerhour ?? ($assignmentmappingDatas->otherpartnerhour ?? 0) }}
                                                    </td>
                                                @else
                                                    <td>{{ $assignmentmappingDatas->teamhour ?? '0' }} </td>
                                                @endif
                                            </tr>
                                        @endforeach --}}

                                        @foreach ($assignmentmappingData as $assignmentmappingDatas)
                                            <tr>

                                                <td style="display: none;">{{ $assignmentmappingDatas->id }}</td>
                                                @if (auth()->user()->role_id == 13 || Auth::user()->role_id == 11 || Auth::user()->role_id == 14)
                                                    <td>
                                                        <a href="{{ url('/assignmentlist/' . $assignmentmappingDatas->assignmentgenerate_id) }}"
                                                            class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                    </td>
                                                @endif
                                                <td> <a
                                                        href="{{ url('/viewassignment/' . $assignmentmappingDatas->assignmentgenerate_id) }}">{{ $assignmentmappingDatas->assignmentgenerate_id }}</a>
                                                </td>
                                                <td>
                                                    {{ $assignmentmappingDatas->assignment_name }} @if ($assignmentmappingDatas->assignmentname != null)
                                                        ({{ $assignmentmappingDatas->assignmentname }})
                                                    @endif
                                                </td>
                                                <td> {{ $assignmentmappingDatas->client_name }}
                                                </td>
                                                <td> {{ $assignmentmappingDatas->client_code }}
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->periodstart != null)
                                                        {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodstart)) }}
                                                    @endif
                                                </td>

                                                <td>
                                                    @if ($assignmentmappingDatas->periodend != null)
                                                        {{ date('d-m-Y', strtotime($assignmentmappingDatas->periodend)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->duedate != null)
                                                        {{ date('d-m-Y', strtotime($assignmentmappingDatas->duedate)) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($assignmentmappingDatas->status == 1)
                                                        <span class="badge badge-primary">OPEN</span>
                                                    @elseif($assignmentmappingDatas->status == 0)
                                                        <span class="badge badge-danger">CLOSED</span>
                                                    @endif

                                                </td>

                                                <td>{{ $assignmentmappingDatas->lead_team_member ?? '' }}</td>
                                                <td>{{ $assignmentmappingDatas->lead_newstaff_code ?? ($assignmentmappingDatas->lead_staffcode ?? '') }}
                                                </td>

                                                <td>{{ $assignmentmappingDatas->other_team_member ?? '' }}</td>
                                                <td>{{ $assignmentmappingDatas->other_newstaff_code ?? ($assignmentmappingDatas->other_staffcode ?? '') }}
                                                </td>

                                                <td>
                                                    @foreach ($teamMembersByType[$assignmentmappingDatas->id][0] ?? [] as $sub)
                                                        {{ $sub->team_member }},
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($teamMembersByType[$assignmentmappingDatas->id][2] ?? [] as $sub)
                                                        {{ $sub->team_member }},
                                                    @endforeach
                                                </td>

                                                @if (auth()->user()->role_id == 11)
                                                    <td>{{ ($assignmentmappingDatas->leadpartnerhour ?? 0) + ($assignmentmappingDatas->otherpartnerhour ?? 0) + ($assignmentmappingDatas->teamhour ?? 0) }}
                                                    </td>
                                                @elseif (auth()->user()->role_id == 13)
                                                    <td>{{ $assignmentmappingDatas->leadpartnerhour ?? ($assignmentmappingDatas->otherpartnerhour ?? 0) }}
                                                    </td>
                                                @else
                                                    <td>{{ $assignmentmappingDatas->teamhour ?? 0 }}</td>
                                                @endif
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
                            <table id="exampleee" class="display nowrap">
                                <thead>
                                    <tr>
                                        <th style="display: none;">id</th>
                                        @if (auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                            <th>Edit</th>
                                        @endif
                                        <th>Assignment Id</th>
                                        <th>Assignment</th>
                                        <th>Client</th>
                                        <th>Client Code</th>
                                        <th>Period Start</th>
                                        <th>Period End</th>
                                        <th>Deadline</th>
                                        <th>Assigned Status</th>
                                        <th>Assigned Partner</th>
                                        <th>Assigned Partner Code</th>
                                        <th>Other Partner</th>
                                        <th>Other Partner Code</th>
                                        <th>Team Leader </th>
                                        <th>Teammember</th>
                                        <th>Total Hour</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($assignmentmappingcloseData as $assignmentmappingcloseDatas)
                                        <tr>
                                            @php
                                                if (auth()->user()->role_id == 11) {
                                                    $teamhourteamsclosed = DB::table('assignmentteammappings')
                                                        ->where(
                                                            'assignmentmapping_id',
                                                            $assignmentmappingcloseDatas->id,
                                                        )
                                                        ->select(DB::raw('SUM(teamhour) as teamhourteam'))
                                                        ->first();

                                                    $partnerhourclosed =
                                                        $assignmentmappingcloseDatas->leadpartnerhour +
                                                        $assignmentmappingcloseDatas->otherpartnerhour;

                                                    $totalhourclosed =
                                                        $partnerhourclosed + $teamhourteamsclosed->teamhourteam;
                                                }
                                            @endphp



                                            <td style="display: none;">{{ $assignmentmappingcloseDatas->id }}</td>

                                            @if (auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                                <td>
                                                    <a href="{{ url('/assignmentlist/' . $assignmentmappingcloseDatas->assignmentgenerate_id) }}"
                                                        class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                </td>
                                            @endif
                                            <td> <a
                                                    href="{{ url('/viewassignment/' . $assignmentmappingcloseDatas->assignmentgenerate_id) }}">{{ $assignmentmappingcloseDatas->assignmentgenerate_id }}</a>
                                            </td>
                                            <td>
                                                {{ $assignmentmappingcloseDatas->assignment_name }} @if ($assignmentmappingcloseDatas->assignmentname != null)
                                                    ({{ $assignmentmappingcloseDatas->assignmentname }})
                                                @endif
                                            </td>
                                            <td> {{ $assignmentmappingcloseDatas->client_name }}</td>
                                            <td> {{ $assignmentmappingcloseDatas->client_code }}</td>

                                            <td>
                                                @if ($assignmentmappingcloseDatas->periodstart != null)
                                                    {{ date('d-m-Y', strtotime($assignmentmappingcloseDatas->periodstart)) }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($assignmentmappingcloseDatas->periodend != null)
                                                    {{ date('d-m-Y', strtotime($assignmentmappingcloseDatas->periodend)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($assignmentmappingcloseDatas->duedate != null)
                                                    {{ date('d-m-Y', strtotime($assignmentmappingcloseDatas->duedate)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($assignmentmappingcloseDatas->status == 1)
                                                    <span class="badge badge-primary">OPEN</span>
                                                @elseif($assignmentmappingcloseDatas->status == 0)
                                                    <span class="badge badge-danger">CLOSED</span>
                                                @endif

                                            </td>

                                            @php
                                                $leadpartner = DB::table('teammembers')
                                                    ->leftJoin(
                                                        'teamrolehistory',
                                                        'teamrolehistory.teammember_id',
                                                        '=',
                                                        'teammembers.id',
                                                    )
                                                    ->where('teammembers.id', $assignmentmappingcloseDatas->leadpartner)
                                                    ->select(
                                                        'teammembers.team_member',
                                                        'teammembers.staffcode',
                                                        'teamrolehistory.newstaff_code',
                                                    )
                                                    ->first();

                                                $otherPartner = DB::table('teammembers')
                                                    ->leftJoin(
                                                        'teamrolehistory',
                                                        'teamrolehistory.teammember_id',
                                                        '=',
                                                        'teammembers.id',
                                                    )
                                                    ->where(
                                                        'teammembers.id',
                                                        $assignmentmappingcloseDatas->otherpartner,
                                                    )
                                                    ->select(
                                                        'teammembers.team_member',
                                                        'teammembers.staffcode',
                                                        'teamrolehistory.newstaff_code',
                                                    )
                                                    ->first();

                                            @endphp
                                            <td>
                                                {{ $leadpartner->team_member ?? '' }}
                                            </td>
                                            <td>
                                                @if ($leadpartner && $leadpartner->team_member)
                                                    {{ $leadpartner->newstaff_code ?? ($leadpartner->staffcode ?? '') }}
                                                @endif
                                            </td>

                                            <td>
                                                {{ $otherPartner->team_member ?? '' }}
                                            </td>
                                            <td>
                                                @if ($otherPartner && $otherPartner->team_member)
                                                    {{ $otherPartner->newstaff_code ?? ($otherPartner->staffcode ?? '') }}
                                                @endif
                                            </td>
                                            <td>
                                                @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingcloseDatas->id)->where('assignmentteammappings.type', 0)->get() as $sub)
                                                    {{ $sub->team_member }} ,
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach (DB::table('assignmentmappings')->leftjoin('assignmentteammappings', 'assignmentteammappings.assignmentmapping_id', 'assignmentmappings.id')->leftjoin('teammembers', 'teammembers.id', 'assignmentteammappings.teammember_id')->where('assignmentmappings.id', $assignmentmappingcloseDatas->id)->where('assignmentteammappings.type', 2)->get() as $sub)
                                                    {{ $sub->team_member }} ,
                                                @endforeach
                                            </td>

                                            @if (auth()->user()->role_id == 11)
                                                <td> {{ $totalhourclosed ?? '0' }}</td>
                                            @elseif (auth()->user()->role_id == 13)
                                                <td>{{ $assignmentmappingcloseDatas->leadpartnerhour ?? ($assignmentmappingcloseDatas->otherpartnerhour ?? 0) }}
                                                </td>
                                            @else
                                                <td>{{ $assignmentmappingcloseDatas->teamhour ?? '0' }} </td>
                                            @endif
                                        </tr>
                                    @endforeach --}}

                                    {{-- @foreach ($assignmentmappingcloseData as $assignmentmappingcloseDatas)
                                        <tr>
                                            <td style="display: none;">{{ $assignmentmappingcloseDatas->id }}</td>

                                            @if (auth()->user()->role_id != 15 && Auth::user()->role_id != 11)
                                                <td>
                                                    <a href="{{ url('/assignmentlist/' . $assignmentmappingcloseDatas->assignmentgenerate_id) }}"
                                                        class="btn btn-info-soft btn-sm"><i class="far fa-edit"></i></a>
                                                </td>
                                            @endif
                                            <td> <a
                                                    href="{{ url('/viewassignment/' . $assignmentmappingcloseDatas->assignmentgenerate_id) }}">{{ $assignmentmappingcloseDatas->assignmentgenerate_id }}</a>
                                            </td>
                                            <td>
                                                {{ $assignmentmappingcloseDatas->assignment_name }} @if ($assignmentmappingcloseDatas->assignmentname != null)
                                                    ({{ $assignmentmappingcloseDatas->assignmentname }})
                                                @endif
                                            </td>
                                            <td> {{ $assignmentmappingcloseDatas->client_name }}</td>
                                            <td> {{ $assignmentmappingcloseDatas->client_code }}</td>

                                            <td>
                                                @if ($assignmentmappingcloseDatas->periodstart != null)
                                                    {{ date('d-m-Y', strtotime($assignmentmappingcloseDatas->periodstart)) }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($assignmentmappingcloseDatas->periodend != null)
                                                    {{ date('d-m-Y', strtotime($assignmentmappingcloseDatas->periodend)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($assignmentmappingcloseDatas->duedate != null)
                                                    {{ date('d-m-Y', strtotime($assignmentmappingcloseDatas->duedate)) }}
                                                @endif
                                            </td>
                                            <td>
                                                @if ($assignmentmappingcloseDatas->status == 1)
                                                    <span class="badge badge-primary">OPEN</span>
                                                @elseif($assignmentmappingcloseDatas->status == 0)
                                                    <span class="badge badge-danger">CLOSED</span>
                                                @endif

                                            </td>


                                            <td>{{ $assignmentmappingcloseDatas->lead_team_member ?? '' }}</td>
                                            <td>{{ $assignmentmappingcloseDatas->lead_newstaff_code ?? $assignmentmappingcloseDatas->lead_staffcode }}
                                            </td>
                                            <td>{{ $assignmentmappingcloseDatas->other_team_member ?? '' }}</td>
                                            <td>{{ $assignmentmappingcloseDatas->other_newstaff_code ?? $assignmentmappingcloseDatas->other_staffcode }}
                                            </td>

                                            <td>
                                                @foreach ($subteamMembers[$assignmentmappingcloseDatas->id][0] ?? [] as $sub)
                                                    {{ $sub->team_member }},
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach ($subteamMembers[$assignmentmappingcloseDatas->id][2] ?? [] as $sub)
                                                    {{ $sub->team_member }},
                                                @endforeach
                                            </td>

                                            @if (auth()->user()->role_id == 11)
                                                <td>{{ ($assignmentmappingcloseDatas->leadpartnerhour ?? 0) + ($assignmentmappingcloseDatas->otherpartnerhour ?? 0) + ($assignmentmappingcloseDatas->teamhour ?? 0) }}
                                                </td>
                                            @elseif (auth()->user()->role_id == 13)
                                                <td>{{ $assignmentmappingcloseDatas->leadpartnerhour ?? ($assignmentmappingcloseDatas->otherpartnerhour ?? 0) }}
                                                </td>
                                            @else
                                                <td>{{ $assignmentmappingcloseDatas->teamhour ?? 0 }}</td>
                                            @endif
                                        </tr>
                                    @endforeach --}}
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

{{-- <script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 50,
            dom: 'Bfrtip',
            "order": [
                [2, "asc"]
            ],

            columnDefs: [{
                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                    targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                @else
                    targets: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                @endif
                orderable: false
            }],
            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Open Assignment Report List',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
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


<script>
    $(document).ready(function() {
        $('#exampleee').DataTable({
            "pageLength": 50,
            dom: 'Bfrtip',
            "order": [
                [1, "asc"]
            ],
            columnDefs: [{
                targets: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
                orderable: false
            }],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Close Assignment Report List',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
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
</script> --}}


<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 50,
            dom: 'Bfrtip',

            @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                "order": [
                    [2, "asc"]
                ],
            @else
                "order": [
                    [1, "asc"]
                ],
            @endif

            columnDefs: [{
                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                    targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                @else
                    targets: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                @endif
                orderable: false
            }],
            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Open Assignment Report List',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
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


<script>
    $(document).ready(function() {
        $('#exampleee').DataTable({
            "pageLength": 50,
            dom: 'Bfrtip',
            // "order": [
            //     [2, "asc"]
            // ],
            @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                "order": [
                    [2, "asc"]
                ],
            @else
                "order": [
                    [1, "asc"]
                ],
            @endif
            columnDefs: [{
                // targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                    targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16],
                @else
                    targets: [0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                @endif
                orderable: false
            }],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Close Assignment Report List',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
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

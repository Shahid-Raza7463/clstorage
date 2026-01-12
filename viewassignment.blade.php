<!--Third party Styles(used by this page)-->
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <style>
        .example:hover {
            overflow-y: scroll;
            /* Add the ability to scroll */

        }


        /* Hide scrollbar for IE, Edge and Firefox */
        .example {
            height: 157px;
            margin: 0 auto;
            overflow: hidden;
        }
    </style>
    <style>
        .examplee:hover {
            overflow-y: scroll;
            /* Add the ability to scroll */

        }


        /* Hide scrollbar for IE, Edge and Firefox */
        .examplee {
            height: 175px;
            margin: 0 auto;
            overflow: hidden;
        }
    </style>
    <!--Content Header (Page header)-->
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-8 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right"
                style="flex-wrap: nowrap; white-space: nowrap;">
                @if ($assignmentbudgetingDatas->independenceform == 2)
                    <li class="d-inline-block">
                        @if (in_array(Auth::user()->role_id, [11, 13]) || $assignmentbudgetingDatas->type == 0)
                            <a class="btn btn-danger"
                                href="{{ url('/independencelist/' . $assignmentbudgetingDatas->assignmentgenerate_id) }}">
                                Independence
                            </a>
                        @elseif (in_array(Auth::user()->role_id, [14, 15]) || $assignmentbudgetingDatas->type == 0)
                            <a class="btn btn-success"
                                href="{{ url('independence/create/' . $assignmentbudgetingDatas->assignmentgenerate_id) }}"
                                style="color: white">
                                Submit Independence Form
                            </a>
                        @endif
                    </li>
                @endif

                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13 || Auth::user()->role_id == 14)
                    <li class="d-inline-block" style="margin-left: 13px;">
                        <a class="btn btn-success"
                            href="{{ url('/assignmentconfirmation/' . $assignmentbudgetingDatas->assignmentgenerate_id) }}">Confirmation
                        </a>
                    </li>
                @endif
                <li class="d-inline-block" style="margin-left: 13px;">
                    <a class="btn btn-info"
                        href="{{ url('/yearwise?' . 'year=' . $assignmentbudgetingDatas->year . '&&' . 'clientid=' . $assignmentbudgetingDatas->client_id) }}">Back</a>
                </li>

                <li class="d-inline-block" style="margin-left: 13px;">
                    <a class="btn btn-primary"
                        href="{{ url('assignmentfolders/' . $assignmentbudgetingDatas->assignmentgenerate_id) }}">
                        All Files And Folders</a>
                </li>

                @if (auth()->user()->role_id == 11)
                    <!--   <li class="breadcrumb-item"><a href="{{ url('assignmentcosting/' . $assignmentbudgetingDatas->assignmentgenerate_id) }}">Assignment Costing Data</a></li> -->
                @endif
            </ol>
        </nav>

        <div class="col-sm-4 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Assignment Details</h1>
                    <small>Assignment List</small>
                </div>
            </div>
        </div>
    </div>
    <!--/.Content Header (Page header)-->
    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:260px;">
                    <div class="card-body">
                        @component('backEnd.components.alert')
                        @endcomponent
                        <fieldset class="form-group">

                            <table class="table display table-bordered table-striped table-hover">

                                <tbody>

                                    <tr>
                                        <td><b>Assignment Name : </b></td>
                                        <td>{{ $assignmentbudgetingDatas->assignment_name }}
                                            ({{ $assignmentbudgetingDatas->assignmentname }})
                                        </td>

                                        <td><b>Assignment Code :</b></td>
                                        <td>{{ $assignmentbudgetingDatas->assignmentgenerate_id }}</td>

                                    </tr>
                                    <tr>
                                        <td><b>Client Name : </b></td>
                                        <td>{{ $assignmentbudgetingDatas->client_name }}
                                            ({{ $assignmentbudgetingDatas->client_code }})
                                        </td>
                                        <td><b>Period End : </b></td>
                                        <td style="color: cornflowerblue;">
                                            {{ date('d-m-Y', strtotime($assignmentbudgetingDatas->periodend)) }}
                                        </td>
                                    </tr>
                                    <!--
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td><b>File Creation Date : </b></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @if (!empty($assignmentbudgetingDatas->filecreationdate))
    {{ date('F d,Y', strtotime($assignmentbudgetingDatas->filecreationdate)) }}
    @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td><b>Modified Date :</b></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @if (!empty($assignmentbudgetingDatas->modifieddate))
    {{ date('F d,Y', strtotime($assignmentbudgetingDatas->modifieddate)) }}
    @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <tr>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td><b>Audit Completion Date : </b></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @if (!empty($assignmentbudgetingDatas->auditcompletiondate))
    {{ date('F d,Y', strtotime($assignmentbudgetingDatas->auditcompletiondate)) }}
    @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td><b>Documentaion Date :</b></td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <td>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @if (!empty($assignmentbudgetingDatas->documentationdate))
    {{ date('F d,Y', strtotime($assignmentbudgetingDatas->documentationdate)) }}
    @endif
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </td>

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    </tr> -->
                                    <tr>
                                        <td><b>Status : </b></td>
                                        <td>
                                            @if (Auth::user()->role_id == 13)
                                                {{-- @if ($assignmentbudgetingDatas->status != 0) --}}
                                                @if (
                                                    $assignmentbudgetingDatas->status != 0 &&
                                                        ($assignmentbudgetingDatas->leadpartner == Auth::user()->teammember_id ||
                                                            $assignmentbudgetingDatas->otherpartner == Auth::user()->teammember_id))
                                                    <a id="editCompanys"
                                                        data-id="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}">
                                                        @if ($assignmentbudgetingDatas->status == 1)
                                                            <span class="badge badge-primary">OPEN</span>
                                                        @else
                                                            <span class="badge badge-danger">CLOSED</span>
                                                        @endif
                                                    </a>
                                                @else
                                                    @if ($assignmentbudgetingDatas->status == 1)
                                                        <span class="badge badge-primary">OPEN</span>
                                                    @else
                                                        <span class="badge badge-danger">CLOSED</span>
                                                    @endif
                                                @endif
                                            @else
                                                @if ($assignmentbudgetingDatas->status == 1)
                                                    <span class="badge badge-primary">OPEN</span>
                                                @else
                                                    <span class="badge badge-danger">CLOSED</span>
                                                @endif

                                            @endif
                                        </td>
                                        <td><b>Billing Frequency : </b></td>
                                        <td>
                                            @if ($assignmentbudgetingDatas->billingfrequency == 0)
                                                <span>Monthly</span>
                                            @elseif($assignmentbudgetingDatas->billingfrequency == 1)
                                                <span>Quarterly</span>
                                            @elseif($assignmentbudgetingDatas->billingfrequency == 2)
                                                <span>Half Yearly</span>
                                            @else
                                                <span>Yearly</span>
                                            @endif
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </fieldset>
                    </div>
                </div>
                </br>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                            <div class="card-body">
                                <div class="card-head">
                                    <b>Teammember List:</b>
                                    @if (auth()->user()->role_id != 15)
                                        <b><a data-toggle="modal" data-target="#exampleModal14"
                                                class="btn btn-info-soft btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </b>
                                    @endif
                                </div>

                                <hr>
                                <div class="table-responsive example">
                                    <table class="table display table-bordered table-striped table-hover ">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th class="textfixed">Staff Code</th>
                                                <th>Role</th>
                                                <th>Mobile No</th>
                                                <th class="textfixed">Total Hour</th>
                                                <th>Patner</th>
                                                @if (auth()->user()->role_id == 13 || auth()->user()->role_id == 11)
                                                    <th>Status</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $hasData = false;
                                            @endphp
                                            @foreach ($teammemberDatas as $teammemberData)
                                                @if ($teammemberData->viewerteam == 0)
                                                    @php
                                                        $hasData = true;
                                                    @endphp
                                                    <tr>
                                                        {{-- @php
                                                            dd($teammemberData);
                                                            $totalhour = DB::table('timesheetusers')
                                                                ->leftJoin(
                                                                    'teammembers',
                                                                    'teammembers.id',
                                                                    'timesheetusers.createdby',
                                                                )
                                                                ->where(
                                                                    'timesheetusers.assignmentgenerate_id',
                                                                    $teammemberData->assignmentgenerateid,
                                                                )
                                                                ->where('timesheetusers.createdby', $teammemberData->id)
                                                                ->select(DB::raw('SUM(totalhour) as total_hours'))
                                                                ->first();
                                
                                                            $patnername = DB::table('assignmentmappings')
                                                                ->leftJoin(
                                                                    'teammembers',
                                                                    'teammembers.id',
                                                                    'assignmentmappings.leadpartner',
                                                                )
                                                                ->where(
                                                                    'assignmentgenerate_id',
                                                                    $teammemberData->assignmentgenerateid,
                                                                )
                                                                ->select('teammembers.team_member')
                                                                ->first();
                                                        @endphp --}}
                                                        <td class="textfixed">{{ $teammemberData->title }}
                                                            {{ $teammemberData->team_member }}

                                                        </td>
                                                        <td>{{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }}
                                                        </td>
                                                        <td class="textfixed">
                                                            @if ($teammemberData->type == 0)
                                                                <span>Team Leader</span>
                                                            @else
                                                                <span>Staff</span>
                                                            @endif
                                                        </td>
                                                        <td class="textfixed"><a
                                                                href="tel:={{ $teammemberData->mobile_no }}">{{ $teammemberData->mobile_no }}</a>
                                                        </td>
                                                        {{-- <td>{{ $totalhour->total_hours ?? 0 }}</td> --}}
                                                        {{-- <td>{{ $patnername->team_member }}</td> --}}
                                                        <td>{{ $teammemberData->teamhour ?? 0 }}</td>
                                                        </td>
                                                        <td class="textfixed">
                                                            {{ App\Models\Teammember::select('team_member')->where('id', $teammemberData->leadpartner)->first()->team_member ?? '' }}
                                                        </td>
                                                        @if (auth()->user()->role_id == 13 || auth()->user()->role_id == 11)
                                                            <td>
                                                                @if ($teammemberData->assignmentteammappingsStatus == 0)
                                                                    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/1/' . $teammemberData->id) }}"
                                                                        onclick="return confirm('Are you sure you want to Active this teammember?');">
                                                                        <button class="btn btn-danger" data-toggle="modal"
                                                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                            data-target="#requestModal">Inactive</button>
                                                                    </a>
                                                                @else
                                                                    <a href="{{ url('/assignment/reject/' . $teammemberData->assignmentteammappingsId . '/0/' . $teammemberData->id) }}"
                                                                        onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                                                                        <button class="btn btn-primary" data-toggle="modal"
                                                                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                            data-target="#requestModal">Active</button>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @if (!$hasData)
                                                <tr>
                                                    <td colspan="7" style="text-align: center;">Data not available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>


                                </div>

                                <div class="modal fade" id="exampleModal14" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="detailsForm" method="post" action="{{ url('teammapping/update') }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add
                                                        Team
                                                        Member</h5>
                                                    <div>
                                                        <ul>
                                                            @foreach ($errors->all() as $e)
                                                                <li style="color:red;">{{ $e }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="details-form-field form-group row">
                                                        <div
                                                            class="col-{{ $assignmentbudgetingDatas->status == 1 ? '6' : '12' }}">
                                                            <div class="form-group">
                                                                <label class="font-weight-600">Name</label>
                                                                <select class="language form-control"
                                                                    id="exampleFormControlSelect" name="teammember_id">
                                                                    <option value="">Please Select One</option>
                                                                    @foreach ($teammemberall as $teammemberData)
                                                                        <option value="{{ $teammemberData->id }}">
                                                                            {{ $teammemberData->team_member }}
                                                                            ({{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="hidden" name="assignmentmapping_id"
                                                                    value="{{ $assignmentbudgetingDatas->id }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>

                                                        @if ($assignmentbudgetingDatas->status == 1)
                                                            <div class="col-5">
                                                                <div class="form-group">
                                                                    <label class="font-weight-600">Type</label>
                                                                    <select class="language form-control key"
                                                                        id="key" name="type">
                                                                        <option value="">Please Select One</option>
                                                                        <option value="0">Team Leader</option>
                                                                        <option value="2">Staff</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <input type="hidden" name="type" value="2"
                                                                class="form-control">
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                @if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13)
                                    <div class="modal fade" id="exampleModal120" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel120" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background:#37A000;color:white;">
                                                    <h5 class="modal-title font-weight-600" id="exampleModalLabel120">Add
                                                        Partner</h5>
                                                    <div>
                                                        <ul>
                                                            @foreach ($errors->all() as $e)
                                                                <li style="color:red;">{{ $e }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <button style="color: white" type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="partnerForm" method="post"
                                                    action="{{ url('otherpatner/update') }}"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="details-form-field form-group row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-600">Partner Name : <span
                                                                            class="text-danger">*</span></label>
                                                                    <select required class="language form-control"
                                                                        id="exampleFormControlSelect1"
                                                                        name="otherpatnerid">
                                                                        <option value="">Please Select One</option>
                                                                        @foreach ($addonpartner as $teammemberData)
                                                                            <option value="{{ $teammemberData->id }}">
                                                                                {{ $teammemberData->team_member }} (
                                                                                {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <input type="hidden" name="assignmentgenerate_id"
                                                                        value="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}"
                                                                        class=" form-control">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label class="font-weight-600">Type : <span
                                                                            class="text-danger">*</span></label>
                                                                    <select required class="language form-control"
                                                                        name="typeid">
                                                                        <option value="">Please Select One</option>
                                                                        {{-- <option value="0">Lead Partner</option> --}}
                                                                        <option value="1">Other Partner</option>
                                                                        <option value="2">Additional Partner</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        {{-- <button type="button" class="btn btn-danger"
                                                            data-dismiss="modal">Close</button> --}}
                                                        <button type="submit" class="btn btn-success"
                                                            id="otherPartnerBtn">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">

                            <div class="card-body">
                                <div class="card-head">
                                    <b>Assignment Viewer:</b>
                                    {{-- @if (auth()->user()->role_id != 15)
                                        <b><a data-toggle="modal" data-target="#exampleModal14"
                                                class="btn btn-info-soft btn-sm">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </b>
                                    @endif --}}
                                </div>

                                <hr>
                                <div class="table-responsive example">
                                    <table class="table display table-bordered table-striped table-hover">
                                        <thead>
                                            {{-- <tr>
                                                <th>Name</th>
                                                <th class="textfixed">Staff Code</th>
                                                <th>Role</th>
                                                <th>Mobile No</th>
                                                <th>Patner</th>
                                            </tr> --}}
                                            <tr>
                                                <th>Name</th>
                                                <th class="textfixed">Staff Code</th>
                                                <th>Mobile No</th>
                                                <th>Patner</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $hasData = false;
                                            @endphp
                                            @foreach ($teammemberDatas as $teammemberData)
                                                @if ($teammemberData->viewerteam == 1)
                                                    @php
                                                        $hasData = true;
                                                    @endphp
                                                    <tr>
                                                        <td class="textfixed">{{ $teammemberData->title }}
                                                            {{ $teammemberData->team_member }}</td>
                                                        <td>{{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }}
                                                        </td>
                                                        {{-- <td class="textfixed">
                                                            @if ($teammemberData->type == 0)
                                                                <span>Team Leader</span>
                                                            @else
                                                                <span>Staff</span>
                                                            @endif
                                                        </td> --}}
                                                        <td class="textfixed">
                                                            <a
                                                                href="tel:={{ $teammemberData->mobile_no }}">{{ $teammemberData->mobile_no }}</a>
                                                        </td>
                                                        <td class="textfixed">
                                                            {{ App\Models\Teammember::select('team_member')->where('id', $teammemberData->leadpartner)->first()->team_member ?? '' }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @if (!$hasData)
                                                <tr>
                                                    <td colspan="7" style="text-align: center;">Data not available</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>

                @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 11)
                    <div class="row">
                        <div class="col-md-10">
                            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                                <div class="card-body">
                                    <div class="card-head">
                                        <b>Partner List:</b>
                                        <b>
                                            <a data-toggle="modal" data-target="#exampleModal120"
                                                class="btn btn-info-soft btn-sm ml-1"><i class="fa fa-plus"></i></a>
                                        </b>
                                    </div>
                                    <hr>
                                    <div class="table-responsive example">
                                        <table class="table display table-bordered table-striped table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="textfixed">Staff Code</th>
                                                    <th>Role</th>
                                                    <th>Mobile No</th>
                                                    <th class="textfixed">Total Hour</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($partner as $partnerData)
                                                    <tr>
                                                        <td class="textfixed">{{ $partnerData->title }}
                                                            {{ $partnerData->team_member }}
                                                        </td>
                                                        {{-- <td>{{ $partnerData->staffcode }}
                                                    </td> --}}
                                                        <td>
                                                            {{ $partnerData->newstaff_code ?? ($partnerData->staffcode ?? '') }}
                                                        </td>
                                                        <td class="textfixed">
                                                            @if ($partnerData->role_id == 13)
                                                                @if (!empty($partnerData->additionalpartner))
                                                                    <span>Additional Partner</span>
                                                                @elseif(!empty($partnerData->otherpartner))
                                                                    <span>Other Partner</span>
                                                                @elseif(!empty($partnerData->leadpartner))
                                                                    <span>Lead Partner</span>
                                                                @endif
                                                            @else
                                                                <span>NA</span>
                                                            @endif
                                                        </td>
                                                        <td class="textfixed"><a
                                                                href="tel:={{ $partnerData->mobile_no }}">{{ $partnerData->mobile_no }}</a>
                                                        </td>
                                                        <td>{{ $partnerData->assignmenthour ?? 0 }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                @endif



                <div class="row">
                    <div class="col-md-12">
                        <div class="card " style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                            <div class="card-body">

                                <div class="card-head">
                                    <b>Client Contact</b>
                                    <a data-toggle="modal" data-target="#exampleModal1"
                                        style="float:right;width:20px;"><img
                                            src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                </div>
                                <hr>
                                <div class="table-responsive example">
                                    <table class="table display table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Designation</th>
                                                <th>Phone</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($contactDatas as $contactData)
                                                <tr>
                                                    <td>{{ $contactData->clientname }}</td>
                                                    <td>{{ $contactData->clientemail }}</td>
                                                    <td>{{ $contactData->clientdesignation }}</td>
                                                    <td><a
                                                            href="tel:={{ $contactData->clientphone }}">{{ $contactData->clientphone }}</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>

                @if (Auth::user()->role_id == 13 ||
                        $assignmentbudgetingDatas->type == 0 ||
                        $assignmentbudgetingDatas->status == 1 ||
                        ($assignmentbudgetingDatas->type != 0 && $assignmentbudgetingDatas->status == 0))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                                <div class="card-body">

                                    <div class="card-head">
                                        <b>UDIN List</b>
                                        @if (Auth::user()->role_id == 13 ||
                                                $assignmentbudgetingDatas->type == 0 ||
                                                $assignmentbudgetingDatas->status == 1 ||
                                                ($assignmentbudgetingDatas->type != 0 && $assignmentbudgetingDatas->status == 0))
                                            <a data-toggle="modal" data-target="#exampleModal12"
                                                style="float:right;width:20px;"><img
                                                    src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                        @endif
                                    </div>
                                    <!-- Display success massage for user-->
                                    @if (session('message'))
                                        <div class="alert alert-success">
                                            {{ session('message') }}
                                        </div>
                                    @endif
                                    <hr>

                                    <div class="table-responsive example">
                                        <table class="table display table-bordered table-striped table-hover ">
                                            <thead>
                                                <tr>
                                                    <th>UDIN</th>
                                                    <th>Partner</th>
                                                    <th>Created by</th>
                                                    <th>Udin Date</th>
                                                    @if (
                                                        (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                                            (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                                        <th>Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($udinDatas as $udinData)
                                                    <tr>

                                                        <td>{{ $udinData->udin }}</td>
                                                        <td>{{ App\Models\Teammember::where('id', $udinData->partner)->select('team_member')->pluck('team_member')->first() }}
                                                        </td>
                                                        <td>{{ $udinData->team_member }} ( {{ $udinData->rolename ?? '' }}
                                                            )</td>
                                                        {{-- <td>{{ date('d-m-Y', strtotime($udinData->created)) }},
                                                            {{ date('H:i A', strtotime($udinData->created)) }}</td> --}}
                                                        <td>{{ $udinData->udindate ? date('d-m-Y', strtotime($udinData->udindate)) : 'NA' }}
                                                        </td>
                                                        @if (
                                                            (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                                                (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                                            <td>
                                                                <form
                                                                    action="{{ route('uidindata.delete', ['id' => $udinData->assignmentbudgetingudinsid]) }}"
                                                                    method="post" class="form1">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="deleteButton btn btn-sm btn-danger mx-2"
                                                                        style="height: 21px; width: 3rem; font-size: 8px;">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <!--Success message on Deleted -->
                <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
                <script>
                    $(document).ready(function() {
                        // Display success message for user
                        @if (session('message'))
                            // Use JavaScript to display the success message in the modal
                            $('#successMessage').text("{{ session('message') }}");
                            $('#successModal').modal('show');
                        @endif
                    });
                </script>
                <br>
            </div>
        </div>
        @foreach ($assignmentcheckDatas as $assignmentcheckData)
            <div class="card mb-4">
                <div class="card-body">

                    <div class="card-head">
                        <b>{{ $assignmentcheckData->financial_name }}</b>
                    </div>
                    <hr>
                    <div class="row">
                        @php
                            $assignmentcheckk = DB::table('subfinancialclassfications')
                                ->where('assignmentgenerate_id', $assignmentbudgetingDatas->assignmentgenerate_id)
                                ->select('assignmentgenerate_id')
                                ->first();
                            // dd($assignmentcheckk); die;
                            if ($assignmentcheckk == null) {
                                $ssub = App\Models\Subfinancialclassfication::where(
                                    'financialstatemantclassfication_id',
                                    $assignmentcheckData->id,
                                )
                                    ->where('assignmentgenerate_id', null)
                                    ->get();
                            } else {
                                $ssub = App\Models\Subfinancialclassfication::where(
                                    'financialstatemantclassfication_id',
                                    $assignmentcheckData->id,
                                )->get();
                            }

                        @endphp
                        @foreach ($ssub as $ssub)
                            <div class="col-md-3" style="
    padding: 10px;
">
                                <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:292px;">
                                    <form>
                                        <div class="card-body">
                                            <div class="card-head">
                                                <b>{{ $ssub->subclassficationname }}</b>
                                            </div>
                                            <hr>
                                            <ul class="todo-list examplee">
                                                @php
                                                    $auditquestionscheck = DB::table('auditquestions')
                                                        ->where(
                                                            'assignmentgenerate_id',
                                                            $assignmentbudgetingDatas->assignmentgenerate_id,
                                                        )
                                                        ->select('assignmentgenerate_id')
                                                        ->first();
                                                    // dd($auditquestionscheck);
                                                    if ($auditquestionscheck == null) {
                                                        $subb = App\Models\Auditquestion::leftJoin(
                                                            'subfinancialclassfications',
                                                            function ($join) {
                                                                $join->on(
                                                                    'auditquestions.subclassfied_id',
                                                                    'subfinancialclassfications.id',
                                                                );
                                                            },
                                                        )
                                                            ->leftJoin('steplists', function ($join) {
                                                                $join->on('auditquestions.steplist_id', 'steplists.id');
                                                            })
                                                            ->where('auditquestions.subclassfied_id', $ssub->id)
                                                            ->where(
                                                                'auditquestions.financialstatemantclassfication_id',
                                                                $assignmentcheckData->id,
                                                            )
                                                            ->where('auditquestions.assignmentgenerate_id', null)
                                                            ->select('stepname', 'steplists.id')
                                                            ->distinct()
                                                            ->get();
                                                    } else {
                                                        $subb = App\Models\Auditquestion::leftJoin(
                                                            'subfinancialclassfications',
                                                            function ($join) {
                                                                $join->on(
                                                                    'auditquestions.subclassfied_id',
                                                                    'subfinancialclassfications.id',
                                                                );
                                                            },
                                                        )
                                                            ->leftJoin('steplists', function ($join) {
                                                                $join->on('auditquestions.steplist_id', 'steplists.id');
                                                            })
                                                            ->where('auditquestions.subclassfied_id', $ssub->id)
                                                            ->where(
                                                                'auditquestions.financialstatemantclassfication_id',
                                                                $assignmentcheckData->id,
                                                            )
                                                            ->select('stepname', 'steplists.id')
                                                            ->distinct()
                                                            ->get();
                                                    }
                                                @endphp
                                                @foreach ($subb as $sub)
                                                    <li>
                                                        <label for="todo1"> <a
                                                                href="{{ url('/auditchecklist?' . 'steplist=' . $sub->id . '&&' . 'subclassfied=' . $ssub->id . '&&' . 'assignmentid=' . $assignmentbudgetingDatas->assignmentgenerate_id . '&&' . 'financialid=' . $ssub->financialstatemantclassfication_id) }}">{{ $sub->stepname }}</a>


                                                            @php
                                                                $status = App\Models\Checklistanswer::leftJoin(
                                                                    'statuses',
                                                                    function ($join) {
                                                                        $join->on(
                                                                            'checklistanswers.status',
                                                                            'statuses.id',
                                                                        );
                                                                    },
                                                                )
                                                                    ->where('steplist_id', $sub->id)
                                                                    ->where(
                                                                        'financialstatemantclassfication_id',
                                                                        $ssub->financialstatemantclassfication_id,
                                                                    )
                                                                    ->where('subclassfied_id', $ssub->id)
                                                                    ->where(
                                                                        'assignment_id',
                                                                        $assignmentbudgetingDatas->assignmentgenerate_id,
                                                                    )
                                                                    ->select('statuses.*')
                                                                    ->orderBy('id', 'asc')
                                                                    ->first();

                                                                $count = App\Models\Auditquestion::where(
                                                                    'steplist_id',
                                                                    $sub->id,
                                                                )
                                                                    ->where(
                                                                        'financialstatemantclassfication_id',
                                                                        $ssub->financialstatemantclassfication_id,
                                                                    )
                                                                    ->where('subclassfied_id', $ssub->id)
                                                                    ->select('id')
                                                                    ->get();
                                                                $countauditqstn = count($count);

                                                                $countan = App\Models\Checklistanswer::leftJoin(
                                                                    'statuses',
                                                                    function ($join) {
                                                                        $join->on(
                                                                            'checklistanswers.status',
                                                                            'statuses.id',
                                                                        );
                                                                    },
                                                                )
                                                                    ->where('steplist_id', $sub->id)
                                                                    ->where(
                                                                        'financialstatemantclassfication_id',
                                                                        $ssub->financialstatemantclassfication_id,
                                                                    )
                                                                    ->where('subclassfied_id', $ssub->id)
                                                                    ->where(
                                                                        'assignment_id',
                                                                        $assignmentbudgetingDatas->assignmentgenerate_id,
                                                                    )
                                                                    ->select('statuses.*')
                                                                    ->get();
                                                                $countauditanswer = count($countan);

                                                            @endphp
                                                            @if ($countauditanswer == $countauditqstn)
                                                                @if ($status)
                                                                    <span
                                                                        class="{{ $status->color ?? '' }}">{{ $status->name ?? '' }}</span>
                                                                @else
                                                                    <span class="badge badge-primary">OPEN</span>
                                                                @endif
                                                            @else
                                                                <span class="badge badge-primary">OPEN</span>
                                                            @endif
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <br>
                        @endforeach


                    </div>
                    <br>
                </div>
            </div>
        @endforeach
    </div>
    <!--/.body content-->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('viewassignment/contactupdate') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Client Contact</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600"> Name</label>
                                    <input type="text" name="clientname" value="" class=" form-control"
                                        placeholder="Enter Client Name">
                                    <input type="text" name="client_id" hidden
                                        value="{{ $assignmentbudgetingDatas->client_id }}" class=" form-control"
                                        placeholder="Enter Client Name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600"> Email</label>
                                    <input type="text" name="clientemail" value="" class=" form-control"
                                        placeholder="Enter Client Email">
                                </div>
                            </div>
                        </div>

                        <div class="details-form-field form-group row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600"> Phone</label>
                                    <input type="text" name="clientphone" value="" class=" form-control"
                                        placeholder="Enter Client Phone">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-600"> Designation</label>
                                    <input type="text" name="clientdesignation" value="" class=" form-control"
                                        placeholder="Enter Client Designation">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsFormudin" method="post" action="{{ url('assignmentudin/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background:#37A000;color:white;">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add UDIN</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <button style="color: white" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="field_wrapper">
                            <div class="row row-sm ">
                                <div class="col-10">
                                    <div class="form-group">
                                        <label class="font-weight-600">UDIN</label>
                                        <input type="text" name="udin[]" value="" class=" form-control"
                                            placeholder="Enter Udin">
                                        <input type="text" name="assignment_generate_id" hidden
                                            value="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}"
                                            class=" form-control">
                                    </div>
                                </div>
                                <a href="javascript:void(0);" style="margin-top: 36px;" class="add_button"
                                    title="Add field"><img src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                            </div>
                        </div>

                        <div class="row row-sm ">
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="font-weight-600">Partner </label>
                                    <select class="form-control" name="partner">
                                        <option value="">Please Select One</option>
                                        @foreach ($partner as $teammemberData)
                                            <option value="{{ $teammemberData->id }}">
                                                {{ $teammemberData->team_member }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="font-weight-600">UDIN Documentation Date</label>
                                    <input type="date" name="udindate" id="datevalid" value=""
                                        class=" form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML =
                '<div class="row row-sm "><div class="col-10"><div class="form-group"><input type="text" class="form-control key" name="udin[]" id="key" value=""  placeholder="Enter Udin"></div></div><a style="margin-top:9px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a></div></div>'; //New input field html 
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>
@endsection
<div class="modal fade" id="exampleModal134" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('assignmentotp/store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Enter
                        Verification OTP</h5>
                    <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li style="color:red;">{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="details-form-field form-group row">

                        <div class="col-sm-12">
                            <div style="text-align: center;color: #37A000" id="otp-message"></div>
                            <br>
                            <input type="number" required name="otp" class="form-control"
                                placeholder="Enter OTP">
                            <input hidden type="text" name="assignmentgenerateid" id="assignmentgenerateid"
                                class="form-control">
                            {{-- <div style="text-align: center;"><a href="{{url('assignmentotp')}}"  class="font-weight-500">Resend Otp</a></div> --}}
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
    $(function() {
        $('body').on('click', '#editCompanys', function(event) {
            event.preventDefault(); // Prevent default action

            var id = $(this).data('id');

            // First check the status
            $.ajax({
                type: "GET",
                url: "{{ url('assignmentotp/check-status') }}",
                data: "id=" + id,
                success: function(response) {
                    if (response.canProceed) {
                        // Show modal immediately with a "Sending OTP..." message
                        $('#otp-message').html('Sending OTP to your email...');
                        $('#assignmentgenerateid').val(id); // Set the ID immediately
                        $('#exampleModal134').modal('show');

                        // Then send the OTP request asynchronously
                        $.ajax({
                            type: "GET",
                            url: "{{ url('assignmentotp') }}",
                            data: "id=" + id,
                            success: function(response) {
                                if (response !== null) {
                                    // Update message once OTP is sent
                                    $('#otp-message').html(
                                        'OTP sent to your email, please check'
                                    );
                                    $("#assignmentgenerateid").val(response
                                        .assignmentgenerate_id);
                                } else {
                                    $('#otp-message').html(
                                        'Error sending OTP, please try again'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#otp-message').html(
                                    'Error occurred while sending OTP: ' +
                                    error);
                            }
                        });
                    } else {
                        // Show alert and do NOT show modal
                        if (response.reason === 'independence') {
                            alert(
                                'Your Independence Confirmation is still open. You can close the assignment once all Confirmations are submitted.'
                            );
                        } else if (response.reason === 'balance') {
                            alert(
                                'Your Confirmation task is still open. You can close the assignment once all tasks are closed.'
                            );
                        }
                        $('#exampleModal134').modal('hide'); // Ensure modal stays hidden
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error checking assignment status: ' + error);
                }
            });
        });
    });
</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#exampleModal12').on('hidden.bs.modal', function() {
            $('#detailsFormudin')[0].reset();
        });

        $('#exampleModal120').on('hidden.bs.modal', function() {
            var formElement = $(this).find('form')[0];
            if (formElement) {
                formElement.reset();
            }
            // Reset Select2 dropdowns
            $(this).find('select').val(null).trigger('change');
            // $(this).find('input[type="hidden"]').val(''); 
            $(this).find('input[name="assignmentgenerate_id"]').val('');
            // $(this).find('input[type="hidden"]').not('[name="_token"]').val('');
            console.log('Form Reset Done');
        });

        $('#exampleModal14').on('hidden.bs.modal', function() {
            $(this).find('select').val(null).trigger('change');
        });
    });
</script>

{{-- 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('partnerForm');
        const btn = document.getElementById('otherPartnerBtn');

        if (form) {
            form.addEventListener('submit', function() {
                btn.disabled = true;
                btn.innerText = 'Please wait...';
            });
        }
    });
</script> --}}

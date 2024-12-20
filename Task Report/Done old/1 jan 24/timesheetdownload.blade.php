  <!--Third party Styles(used by this page)-->
  <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
  <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

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
                      <small>Team Workbook List</small>
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
                  <div class="table-responsive">
                      {{-- filtering functionality --}}
                      <form method="post" action="{{ url('searchingtimesheet') }}" enctype="multipart/form-data"
                          class="form-inline">
                          @csrf
                          <table class="table table-bordered table-striped">
                              <thead>
                                  <tr>
                                      <th>Year</th>
                                      <th>Start Date</th>
                                      <th>End Date</th>
                                      {{-- <th>Teamid</th> --}}
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr style=" background-color: white;">
                                      <td>

                                          <div class="form-group">
                                              <select class="language form-control" id="year" name="year">
                                                  <option value="">Please Select One</option>
                                                  <option value="2024">2024</option>
                                                  <option value="2023">2023</option>
                                                  <option value="2022">2022</option>
                                                  <option value="2021">2021</option>
                                              </select>
                                          </div>
                                      </td>
                                      <td>
                                          <div class="form-group">
                                              <input type="date" class="form-control" id="startdate" name="startdate">
                                          </div>
                                      </td>
                                      <td>
                                          <div class="form-group">
                                              <input type="date" class="form-control" id="enddate" name="enddate">
                                          </div>
                                      </td>
                                      <td style="display: none">
                                          <div class="form-group">
                                              @php

                                                  $displayedValues = [];
                                              @endphp
                                              @foreach ($timesheetData as $timesheetDatas)
                                                  @if (!in_array($timesheetDatas->createdby, $displayedValues))
                                                      <input type="hidden" class="form-control" id="teamid"
                                                          name="teamid" value="{{ $timesheetDatas->createdby }}">
                                                      @php
                                                          $displayedValues[] = $timesheetDatas->createdby;
                                                      @endphp
                                                  @endif
                                              @endforeach
                                          </div>
                                      </td>
                                      <td>
                                          <button type="submit" class="btn btn-success">Search</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>
                      </form>

                      <table id="examplee" class="table display table-bordered table-striped table-hover">
                          <thead>

                              <tr>
                                  <th style="display: none;">id</th>

                                  <th>Employee Name</th>
                                  <th>Date</th>
                                  <th>Day</th>
                                  <th>Client Name</th>
                                  <th>Assignment Name</th>

                                  <th>Work Item</th>
                                  <th>Location</th>
                                  <th>Partner</th>
                                  {{-- <th>Hour</th> --}}
                                  <th> Hour</th>
                                  <th>Status</th>

                                  {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                                    <th>Action</th>
                                @endif --}}
                              </tr>
                          </thead>
                          <tbody>
                              {{-- @php
                                  dd($timesheetData);
                              @endphp --}}
                              @foreach ($timesheetData as $timesheetDatas)
                                  <tr>
                                      @php
                                          $timeid = DB::table('timesheetusers')
                                              ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                              ->first();

                                          $client_id = DB::table('timesheetusers')
                                              ->leftjoin('clients', 'clients.id', 'timesheetusers.client_id')
                                              ->leftjoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
                                              ->leftjoin('teammembers', 'teammembers.id', 'timesheetusers.partner')
                                              ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                              ->select('clients.client_name', 'timesheetusers.hour', 'timesheetusers.location', 'timesheetusers.*', 'assignments.assignment_name', 'billable_status', 'workitem', 'teammembers.team_member', 'timesheetusers.timesheetid')
                                              ->get();
                                          // dd($client_id);

                                          $total = DB::table('timesheetusers')

                                              ->where('timesheetusers.timesheetid', $timesheetDatas->timesheetid)
                                              ->sum('hour');

                                          $dates = date('l', strtotime($timesheetDatas->date));
                                      @endphp
                                      <td style="display: none;">{{ $timesheetDatas->id }}</td>

                                      <td>
                                          {{ $timesheetDatas->team_member ?? '' }} </td>
                                      <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                      </td>
                                      <td>
                                          @if ($timesheetDatas->date != null)
                                              {{ $dates ?? '' }}
                                          @endif
                                      </td>

                                      <span style="font-size: 13px;">


                                          <td>

                                              @foreach ($client_id as $item)
                                                  {{ $item->client_name ?? '' }} @if ($item->client_name != 0)
                                                      ,
                                                  @endif
                                              @endforeach
                                          </td>
                                          <td>
                                              @foreach ($client_id as $item)
                                                  {{ $item->assignment_name ?? '' }}@if ($item->assignment_name != null)
                                                      ,
                                                  @endif
                                              @endforeach
                                          </td>

                                          <td>
                                              @foreach ($client_id as $item)
                                                  {{ $item->workitem ?? '' }}@if ($item->workitem != null)
                                                      ,
                                                  @endif
                                              @endforeach
                                          </td>

                                          <td>
                                              @foreach ($client_id as $item)
                                                  {{ $item->location ?? '' }}@if ($item->location != null)
                                                      ,
                                                  @endif
                                              @endforeach
                                          </td>
                                          <td>
                                              @foreach ($client_id as $item)
                                                  {{ $item->team_member ?? '' }} @if ($item->team_member != null)
                                                      ,
                                                  @endif
                                              @endforeach
                                          </td>

                                          <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                          <td>
                                              @foreach ($client_id as $item)
                                                  @if ($item->status == 0)
                                                      <span class="badge badge-pill badge-warning">saved</span>
                                                  @elseif ($item->status == 1 || $item->status == 3)
                                                      <span class="badge badge-pill badge-danger">submit</span>
                                                  @else
                                                      <span class="badge badge-pill badge-secondary">Rejected</span>
                                                  @endif
                                              @endforeach
                                          </td>

                                          @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
                                              <td>
                                                  @foreach ($client_id as $item)
                                                      @if ($item->status == 2)
                                                          <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                                              onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                              <button class="btn btn-danger" data-toggle="modal"
                                                                  style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                  data-target="#requestModal" disabled>Reject</button>
                                                          </a>
                                                      @else
                                                          <a href="  {{ url('/timesheet/reject/' . $item->id) }}"
                                                              onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                              <button class="btn btn-danger" data-toggle="modal"
                                                                  style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                                  data-target="#requestModal">Reject</button>
                                                          </a>
                                                      @endif
                                                  @endforeach
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
  </style>
  <script>
      $(document).ready(function() {
          $('#examplee').DataTable({
              dom: 'Bfrtip',
              "order": [
                  //   [0, "DESC"]
                  //   [2, "DESC"]
              ],
              buttons: [{
                      extend: 'copyHtml5',
                      exportOptions: {
                          columns: [0, ':visible']
                      }
                  },
                  {
                      extend: 'excelHtml5',
                      filename: 'Timesheet Download',
                      exportOptions: {
                          columns: ':visible'
                      }
                  },
                  {
                      extend: 'pdfHtml5',
                      filename: 'Timesheet Download',
                      exportOptions: {
                          columns: [1, 2, 3, 4, 5]
                      }
                  },
                  'colvis'
              ]
          });
      });
  </script>

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
                      {{-- it is for admin and and team of patners --}}
                      @if (Auth::user()->role_id == 11 ||
                              Request::is('adminsearchtimesheet') ||
                              (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                          <form method="post" action="{{ url('adminsearchtimesheet') }}" enctype="multipart/form-data"
                              class="form-inline">
                          @else
                              <form method="post" action="{{ url('searchingtimesheet') }}" enctype="multipart/form-data"
                                  class="form-inline">
                      @endif
                      @csrf
                      <table class="table table-bordered table-striped">
                          <thead>
                              <tr>
                                  {{-- it is for admin and and team of patners --}}
                                  @if (Auth::user()->role_id == 11 ||
                                          Request::is('adminsearchtimesheet') ||
                                          (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                      <th>Employee Name</th>
                                  @endif
                                  <th>Year <span class="text-danger">*</span></th>
                                  <th>Start Date <span class="text-danger">*</span></th>
                                  <th>End Date <span class="text-danger">*</span></th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr style=" background-color: white;">
                                  {{-- it is for admin and and team of patners --}}
                                  @if (Auth::user()->role_id == 11 ||
                                          Request::is('adminsearchtimesheet') ||
                                          (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                      <td>
                                          <div class="form-group">

                                              <select class="language form-control" id="teammemberId" name="teammemberId">
                                                  <option value="">Please Select One</option>
                                                  @php
                                                      $displayedValues = [];
                                                  @endphp
                                                  @foreach ($teammembers as $teammember)
                                                      @if (!in_array($teammember->team_member, $displayedValues))
                                                          <option value="{{ $teammember->id }}">
                                                              {{ $teammember->team_member }}
                                                          </option>
                                                          @php
                                                              $displayedValues[] = $teammember->team_member;
                                                          @endphp
                                                      @endif
                                                  @endforeach
                                              </select>
                                          </div>
                                      </td>
                                  @endif
                                  <td>
                                      <div class="form-group">
                                          <select required class="language form-control" id="year" name="year">
                                              <option value="">Please Select One</option>
                                              <option value="2024" {{ old('year') == '2024' ? 'selected' : '' }}>2024
                                              </option>
                                              <option value="2023" {{ old('year') == '2023' ? 'selected' : '' }}>2023
                                              </option>
                                          </select>
                                      </div>
                                  </td>
                                  <td>
                                      <div class="form-group">
                                          <input required type="date" class="form-control" id="startdate"
                                              name="startdate" value="{{ old('startdate') }}">
                                      </div>
                                  </td>
                                  <td>
                                      <div class="form-group">
                                          <input type="date" class="form-control" id="enddate" name="enddate"
                                              value="{{ old('enddate') }}">
                                      </div>
                                  </td>
                                  <td style="display: none">
                                      <div class="form-group">
                                          @php

                                              $displayedValues = [];
                                          @endphp
                                          @foreach ($timesheetData as $timesheetDatas)
                                              @if (!in_array($timesheetDatas->createdby, $displayedValues))
                                                  <input type="hidden" class="form-control" id="teamid" name="teamid"
                                                      value="{{ $timesheetDatas->createdby }}">
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
                                  <th> Hour</th>
                                  <th>Status</th>
                              </tr>
                          </thead>
                          <tbody>
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

                                          {{-- @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $client_id[0]->createdby)
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
                                          @endif --}}

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
  <style>
      .dt-buttons {
          margin-bottom: -34px;
      }
  </style>
  {{-- ! 29-01-24 --}}
  {{-- <script>
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
                      filename: 'Timesheet_Download',
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
  </script> --}}


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
                      filename: 'Timesheet_Download',
                      exportOptions: {
                          columns: ':visible'
                      },

                      customize: function(xlsx) {
                          var sheet = xlsx.xl.worksheets['sheet1.xml'];

                          //   set column width
                          $('col', sheet).eq(0).attr('width', 15);
                          $('col', sheet).eq(1).attr('width', 15);
                          $('col', sheet).eq(3).attr('width', 30);
                          $('col', sheet).eq(4).attr('width', 30);
                          $('col', sheet).eq(5).attr('width', 30);
                          $('col', sheet).eq(6).attr('width', 30);
                          $('col', sheet).eq(7).attr('width', 30);
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


  {{-- validation for comparision date and block year for 4 disit --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          var startDateInput = $('#startdate');
          var endDateInput = $('#enddate');

          function compareDates() {
              var startDate = new Date(startDateInput.val());
              var endDate = new Date(endDateInput.val());

              if (startDate > endDate) {
                  alert('End date should be greater than or equal to the Start date');
                  // Clear the end date input
                  endDateInput.val('');
              }
          }

          startDateInput.on('input', compareDates);
          endDateInput.on('blur', compareDates);
      });
  </script>

  {{-- validation for block 4 digit to  year --}}
  <script>
      $(document).ready(function() {
          $('#startdate').on('change', function() {
              var startclear = $('#startdate');
              var startDateInput1 = $('#startdate').val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();
              var yearLength = startyear.toString().length;
              if (yearLength > 4) {
                  alert('Enter four digits for the year');
                  startclear.val('');
              }
          });

          $('#enddate').on('change', function() {
              var endclear = $('#enddate');
              var endDateInput1 = $('#enddate').val();
              var endtDate = new Date(endDateInput1);
              var endyear = endtDate.getFullYear();
              var endyearLength = endyear.toString().length;
              if (endyearLength > 4) {
                  alert('Enter four digits for the year');
                  endclear.val('');
              }
          });

          //   condition on submit
          $('form').submit(function(event) {
              var year = $('#year').val();
              var startdate = $('#startdate').val();
              var enddate = $('#enddate').val();

              var startclear = $('#startdate');
              var startDateInput1 = $('#startdate').val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();
              var yearvalue = $('#year').val();
              if (year && startdate) {
                  if (yearvalue != startyear) {
                      alert('Enter Start Date According Year');
                      startclear.val('');
                      // Prevent form submission
                      event.preventDefault();
                      // Exit the function
                      return;
                  }
              }

              var endclear = $('#enddate');
              var endDateInput1 = $('#enddate').val();
              var endtDate = new Date(endDateInput1);
              var endyear = endtDate.getFullYear();
              var yearvalue = $('#year').val();
              if (year && enddate) {
                  if (yearvalue != endyear) {
                      alert('Enter End Date According Year');
                      endclear.val('');
                      // Prevent form submission
                      event.preventDefault();
                      // Exit the function
                      return;
                  }
              }

              if (year === "" && startdate === "" && enddate === "") {
                  alert("Please select year.");
                  event.preventDefault();
                  return;
              }
              if (startdate !== "" && enddate === "") {
                  alert("Please select End date.");
                  event.preventDefault();
                  return;
              }
              //   if (year !== "" && startdate !== "" && enddate === "") {
              //       alert("Please select End date.");
              //       event.preventDefault();
              //       return;
              //   }
              //   if (startdate !== "" && enddate !== "" && year === "") {
              //       alert("Please select Year.");
              //       event.preventDefault();
              //       return;
              //   }
          });
      });
  </script>

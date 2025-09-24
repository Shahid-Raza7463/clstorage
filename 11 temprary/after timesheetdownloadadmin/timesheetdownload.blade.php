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
                      <h1 class="font-weight-bold">Timesheet Report</h1>
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
                                      <th>Start Date <span class="text-danger">*</span></th>
                                      <th>End Date <span class="text-danger">*</span></th>
                                      <th>Action</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr style=" background-color: white;">
                                      {{-- it is for admin and and team of patners --}}
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
                                              <input type="text" class="form-control" id="teamid" name="teamid"
                                                  value="{{ auth()->user()->teammember_id }}">
                                          </div>
                                      </td>

                                      <td>
                                          <button type="submit" class="btn btn-success">Search</button>
                                      </td>
                                  </tr>
                              </tbody>
                          </table>


                      </form>
                      @if (Request::is('adminsearchtimesheet') || Request::is('mytimesheetlist/*') || Request::is('searchingtimesheet'))
                          <table id="examplee" class="table display table-bordered table-striped table-hover">
                              <thead>
                                  <tr>
                                      <th style="display: none;">id</th>
                                      <th>Date</th>
                                      <th>Day</th>
                                      <th>Client Name</th>
                                      <th class="textfixed">Client Code</th>
                                      <th>Assignment Name</th>
                                      <th class="textfixed">Assignment Id</th>
                                      <th>Work Item</th>
                                      <th>Location</th>
                                      <th>Partner</th>
                                      <th class="textfixed">Partner Code</th>
                                      <th>Hour</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($timesheetData as $timesheetDatas)
                                      <tr>
                                          {{-- @if (Request::is('adminsearchtimesheet')) --}}
                                          @php

                                              $permotioncheck = DB::table('teamrolehistory')
                                                  ->where('teammember_id', $timesheetDatas->createdby)
                                                  ->first();
                                              //shshid client
                                              $datadate = $timesheetDatas->assignmentcreateddate
                                                  ? Carbon\Carbon::createFromFormat(
                                                      'Y-m-d H:i:s',
                                                      $timesheetDatas->assignmentcreateddate,
                                                  )
                                                  : null;

                                              $permotiondate = null;
                                              if ($permotioncheck) {
                                                  $permotiondate = Carbon\Carbon::createFromFormat(
                                                      'Y-m-d H:i:s',
                                                      $permotioncheck->created_at,
                                                  );
                                              }
                                          @endphp

                                          <td style="display: none;">{{ $timesheetDatas->id }}</td>
                                          <td class="textfixed"> <span style="display: none;">
                                                  {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                                          </td>
                                          <td class="textfixed">
                                              @if ($timesheetDatas->date != null)
                                                  {{ date('l', strtotime($timesheetDatas->date)) }}
                                              @endif
                                          </td>
                                          <td class="textfixed">{{ $timesheetDatas->client_name ?? '' }}
                                          </td>
                                          <td>{{ $timesheetDatas->client_code ?? '' }}
                                          </td>
                                          <td class="textfixed">
                                              {{ $timesheetDatas->assignment_name ?? '' }}
                                              @if ($timesheetDatas->assignmentname != null)
                                                  ({{ $timesheetDatas->assignmentname ?? '' }})
                                              @endif
                                          </td>
                                          <td>
                                              {{ $timesheetDatas->assignmentgenerate_id ?? '' }}
                                          </td>
                                          <td class="textfixed"> {{ $timesheetDatas->workitem ?? '' }}</td>
                                          <td class="textfixed">{{ $timesheetDatas->location ?? '' }} </td>
                                          <td class="textfixed"> {{ $timesheetDatas->patnername ?? '' }}
                                          </td>
                                          <td>
                                              @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                                  {{ $timesheetDatas->newstaff_code ?? '' }}
                                              @else
                                                  {{ $timesheetDatas->patnerstaffcode ?? '' }}
                                              @endif
                                          </td>
                                          <td>{{ $timesheetDatas->hour ?? '' }}</td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      @endif
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
  {{-- <style>
      .dt-buttons {
          margin-bottom: -34px;
      }
  </style> --}}
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

  {{-- <script>
      $(document).ready(function() {
                  $('#examplee').DataTable({
                          dom: 'Bfrtip',
                          "order": [],
                          searching: false,
                          @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                              columnDefs: [{
                                  targets: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                                  orderable: false
                              }],
                          @else
                              columnDefs: [{
                                  targets: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                                  orderable: false
                              }],
                          @endif
                          buttons: [{
                                  extend: 'excelHtml5',
                                  filename: 'Timesheet_Download',

                                  //   remove extra date from column
                                  exportOptions: {
                                      columns: ':visible',
                                      format: {
                                          body: function(data, row, column, node) {
                                              // it should be column number 2
                                              @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                                  if (column === 2) {
                                                  @else
                                                      if (column === 2) {
                                                      @endif
                                                      // If the data is a date, extract the date without HTML tags
                                                      var cleanedText = $(data).text().trim();
                                                      var dateParts = cleanedText.split(
                                                          '-');
                                                      // Assuming the date format is yyyy-mm-dd
                                                      if (dateParts.length === 3) {
                                                          return dateParts[2] + '-' + dateParts[1] + '-' +
                                                              dateParts[0];
                                                      }
                                                  }
                                                  return data;
                                              }
                                          }
                                      },

                                      //   set width in excell
                                      customize: function(xlsx) {
                                          var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                          // set column width
                                          $('col', sheet).eq(0).attr('width', 15);
                                          $('col', sheet).eq(1).attr('width', 15);
                                          $('col', sheet).eq(3).attr('width', 30);
                                          $('col', sheet).eq(4).attr('width', 30);
                                          $('col', sheet).eq(5).attr('width', 30);
                                          $('col', sheet).eq(6).attr('width', 30);
                                          $('col', sheet).eq(7).attr('width', 30);

                                          // remove extra spaces
                                          $('c', sheet).each(function() {
                                              var originalText = $(this).find('is t').text();
                                              var cleanedText = originalText.replace(/\s+/g, ' ')
                                                  .trim();
                                              $(this).find('is t').text(cleanedText);
                                          });
                                      }
                                  },
                                  'colvis'
                              ]
                          });
                  });
  </script> --}}

  {{-- <script>
      $(document).ready(function() {
                  $('#examplee').DataTable({
                          dom: 'Bfrtip',
                          "order": [],
                          searching: false,
                          @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                              columnDefs: [{
                                  targets: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                                  orderable: false
                              }],
                          @else
                              columnDefs: [{
                                  targets: [1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13],
                                  orderable: false
                              }],
                          @endif
                          buttons: [{
                                  extend: 'excelHtml5',
                                  filename: 'Timesheet_Download',

                                  //   remove extra date from column
                                  exportOptions: {
                                      columns: ':visible',
                                      format: {
                                          body: function(data, row, column, node) {
                                              // it should be column number 2
                                              @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                                  if (column === 2) {
                                                  @else
                                                      if (column === 2) {
                                                      @endif
                                                      // If the data is a date, extract the date without HTML tags
                                                      var cleanedText = $(data).text().trim();
                                                      var dateParts = cleanedText.split(
                                                          '-');
                                                      // Assuming the date format is yyyy-mm-dd
                                                      if (dateParts.length === 3) {
                                                          return dateParts[2] + '-' + dateParts[1] + '-' +
                                                              dateParts[0];
                                                      }
                                                  }
                                                  return data;
                                              }
                                          }
                                      },

                                      //   set width in excell
                                      customize: function(xlsx) {
                                          var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                          // set column width
                                          $('col', sheet).eq(0).attr('width', 15);
                                          $('col', sheet).eq(1).attr('width', 14);




                                          $('col', sheet).eq(3).attr('width', 12);
                                          //   qq

                                          $('col', sheet).eq(4).attr('width', 30);
                                          $('col', sheet).eq(5).attr('width', 11);
                                          //   qq
                                          $('col', sheet).eq(6).attr('width', 30);
                                          $('col', sheet).eq(7).attr('width', 13);
                                          //   qq

                                          $('col', sheet).eq(11).attr('width', 12);
                                          //   qq

                                          // remove extra spaces
                                          $('c', sheet).each(function() {
                                              var originalText = $(this).find('is t').text();
                                              var cleanedText = originalText.replace(/\s+/g, ' ')
                                                  .trim();
                                              $(this).find('is t').text(cleanedText);
                                          });
                                      }
                                  },
                                  'colvis'
                              ]
                          });
                  });
  </script> --}}

  {{-- <script>
      $(document).ready(function() {
                  $('#examplee').DataTable({
                          dom: 'Bfrtip',
                          "order": [],
                          searching: false,
                          @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                              columnDefs: [{
                                  targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                                  orderable: false
                              }],
                          @else
                              columnDefs: [{
                                  targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                                  orderable: false
                              }],
                          @endif
                          buttons: [{
                                  extend: 'excelHtml5',
                                  filename: 'Timesheet_Download',

                                  //   remove extra date from column
                                  exportOptions: {
                                      columns: ':visible',
                                      format: {
                                          body: function(data, row, column, node) {
                                              // it should be column number 2
                                              @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                                  if (column === 0) {
                                                  @else
                                                      if (column === 0) {
                                                      @endif
                                                      // If the data is a date, extract the date without HTML tags
                                                      var cleanedText = $(data).text().trim();
                                                      var dateParts = cleanedText.split(
                                                          '-');
                                                      // Assuming the date format is yyyy-mm-dd
                                                      if (dateParts.length === 3) {
                                                          return dateParts[2] + '-' + dateParts[1] + '-' +
                                                              dateParts[0];
                                                      }
                                                  }
                                                  return data;
                                              }
                                          }
                                      },

                                      //   set width in excell
                                      customize: function(xlsx) {
                                          var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                          // set column width
                                          $('col', sheet).eq(0).attr('width', 11);
                                          $('col', sheet).eq(1).attr('width', 12);
                                          $('col', sheet).eq(2).attr('width', 30);
                                          $('col', sheet).eq(3).attr('width', 11);
                                          $('col', sheet).eq(4).attr('width', 30);
                                          $('col', sheet).eq(5).attr('width', 13);
                                          $('col', sheet).eq(9).attr('width', 12);

                                          $('c', sheet).each(function() {
                                              var originalText = $(this).find('is t').text();
                                              var cleanedText = originalText.replace(/\s+/g, ' ')
                                                  .trim();
                                              $(this).find('is t').text(cleanedText);
                                          });
                                      }
                                  },
                                  'colvis'
                              ]
                          });
                  });
  </script> --}}

  {{-- <script>
      $(document).ready(function() {
          $('#examplee').DataTable({
              dom: 'Bfrtip',
              "order": [], // Default ordering is disabled

              searching: false, // Disable searching

              columnDefs: [{
                  targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                  orderable: false // Disable ordering for specified columns
              }],

              buttons: [{
                      extend: 'excelHtml5',
                      filename: 'Timesheet_Download',

                      exportOptions: {
                          columns: ':visible',
                          format: {
                              body: function(data, row, column, node) {
                                  // Check column index
                                  if (column === 0) {
                                      // Remove HTML tags and format date if needed
                                      var cleanedText = $(data).text().trim();
                                      var dateParts = cleanedText.split('-');
                                      // Assuming the date format is yyyy-mm-dd
                                      if (dateParts.length === 3) {
                                          return dateParts[2] + '-' + dateParts[1] + '-' +
                                              dateParts[0];
                                      }
                                  }
                                  return data;
                              }
                          }
                      },

                      customize: function(xlsx) {
                          var sheet = xlsx.xl.worksheets['sheet1.xml'];

                          // Set column widths
                          $('col', sheet).eq(0).attr('width', 11);
                          $('col', sheet).eq(1).attr('width', 12);
                          $('col', sheet).eq(2).attr('width', 30);
                          $('col', sheet).eq(3).attr('width', 11);
                          $('col', sheet).eq(4).attr('width', 30);
                          $('col', sheet).eq(5).attr('width', 13);
                          $('col', sheet).eq(9).attr('width', 12);

                          // Clean up cell text
                          $('c', sheet).each(function() {
                              var originalText = $(this).find('is t').text();
                              var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                              $(this).find('is t').text(cleanedText);
                          });
                      }
                  },
                  'colvis' // Column visibility button
              ]
          });
      });
  </script> --}}


  {{-- <script>
      $(document).ready(function() {
          $('#examplee').DataTable({
              dom: 'Bfrtip',
              "order": [],
              searching: false,

              columnDefs: [{
                  @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                      targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                  @else
                      targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                  @endif
                  orderable: false
              }],

              buttons: [{
                      extend: 'excelHtml5',
                      filename: 'Timesheet_Download',

                      //   remove extra date from column
                      exportOptions: {
                          columns: ':visible',
                          format: {
                              body: function(data, row, column, node) {
                                  // it should be column number 2

                                  @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                      if (column === 0)
                                  @else
                                      if (column === 0)
                                  @endif {
                                      // If the data is a date, extract the date without HTML tags
                                      var cleanedText = $(data).text().trim();
                                      var dateParts = cleanedText.split(
                                          '-');
                                      // Assuming the date format is yyyy-mm-dd
                                      if (dateParts.length === 3) {
                                          return dateParts[2] + '-' + dateParts[1] + '-' +
                                              dateParts[0];
                                      }
                                  }
                                  return data;
                              }
                          }
                      },

                      //   set width in excell
                      customize: function(xlsx) {
                          var sheet = xlsx.xl.worksheets['sheet1.xml'];

                          // set column width
                          $('col', sheet).eq(0).attr('width', 11);
                          $('col', sheet).eq(1).attr('width', 12);
                          $('col', sheet).eq(2).attr('width', 30);
                          $('col', sheet).eq(3).attr('width', 11);
                          $('col', sheet).eq(4).attr('width', 30);
                          $('col', sheet).eq(5).attr('width', 13);
                          $('col', sheet).eq(9).attr('width', 12);

                          $('c', sheet).each(function() {
                              var originalText = $(this).find('is t').text();
                              var cleanedText = originalText.replace(/\s+/g, ' ')
                                  .trim();
                              $(this).find('is t').text(cleanedText);
                          });
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
              "order": [], // Default ordering is disabled
              searching: false, // Disable searching

              columnDefs: [{
                  targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                  orderable: false // Disable ordering for specified columns
              }],

              buttons: [{
                      extend: 'excelHtml5',
                      filename: 'Timesheet_Download',

                      exportOptions: {
                          columns: ':visible',
                          format: {
                              body: function(data, row, column, node) {
                                  // Format date only for column index 0
                                  if (column === 0) {
                                      // Remove HTML tags and format date if needed
                                      var cleanedText = $(node).text().trim();
                                      var dateParts = cleanedText.split('-');
                                      // Assuming the date format is yyyy-mm-dd
                                      if (dateParts.length === 3) {
                                          return dateParts[2] + '-' + dateParts[1] + '-' +
                                              dateParts[0];
                                      }
                                  }
                                  return data; // Return data as is for other columns
                              }
                          }
                      },

                      customize: function(xlsx) {
                          var sheet = xlsx.xl.worksheets['sheet1.xml'];
                          // Set column widths
                          $('col', sheet).eq(0).attr('width', 11);
                          $('col', sheet).eq(1).attr('width', 12);
                          $('col', sheet).eq(2).attr('width', 30);
                          $('col', sheet).eq(3).attr('width', 11);
                          $('col', sheet).eq(4).attr('width', 30);
                          $('col', sheet).eq(5).attr('width', 13);
                          $('col', sheet).eq(9).attr('width', 12);

                          // Clean up cell text
                          $('c', sheet).each(function() {
                              var originalText = $(this).find('is t').text();
                              var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                              $(this).find('is t').text(cleanedText);
                          });
                      }
                  },
                  'colvis' // Column visibility button
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

              var teammemberId = $('#teammemberId').val();
              var clientId = $('#clientId').val();
              var assignmentId = $('#assignmentId').val();

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
              @if (Auth::user()->role_id == 11 ||
                      Request::is('adminsearchtimesheet') ||
                      (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))

                  //   if (clientId !== "" && assignmentId !== "" && teammemberId !== "") {
                  //       alert("Please select only Employee name/ Client name/ Assignment name.");
                  //       event.preventDefault();
                  //       return;
                  //   }

                  //   if (teammemberId !== "" && clientId !== "") {
                  //       alert("Please select only Employee name/ Client name.");
                  //       event.preventDefault();
                  //       return;
                  //   }
                  //   if (teammemberId !== "" && assignmentId !== "") {
                  //       alert("Please select only Employee name/ Assignment name.");
                  //       event.preventDefault();
                  //       return;
                  //   }
              @endif
          });
      });
  </script>
  <script>
      $(function() {
          $('#clientId').on('change', function() {
              var cid = $(this).val();
              $.ajax({
                  type: "get",
                  url: "{{ url('adminsearchtimesheet') }}",
                  data: {
                      cid: cid,
                  },
                  success: function(res) {
                      $('#assignmentId').html(res);
                  },
                  error: function() {},
              });

          });
      });
  </script>

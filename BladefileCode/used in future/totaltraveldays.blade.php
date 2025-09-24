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
                      <h1 class="font-weight-bold">Total Travel Days</h1>
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
                      @if (Request::is('adminsearchtimesheet') || Request::is('totaltraveldays/*') || Request::is('searchingtimesheet'))
                          {{-- <table id="examplee" class="table display table-bordered table-striped table-hover">
                              <thead>
                                  <tr>
                                      <th style="display: none;">id</th>
                                      @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                          <th class="textfixed">Employee Name</th>
                                          <th class="textfixed">Employee Code</th>
                                      @endif
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
                                          @php
                                              $permotioncheck = DB::table('teamrolehistory')
                                                  ->where('teammember_id', $timesheetDatas->createdby)
                                                  ->first();
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
                                          @if (Auth::user()->role_id == 11 || Request::is('adminsearchtimesheet') || (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                              <td> {{ $timesheetDatas->team_member ?? '' }} </td>
                                              @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                                  <td>{{ $permotioncheck->newstaff_code }}</td>
                                              @else
                                                  <td>{{ $timesheetDatas->staffcode }}</td>
                                              @endif
                                          @endif

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
                          </table> --}}

                          <table id="examplee" class="table display table-bordered table-striped table-hover">
                              <thead>
                                  <tr>
                                      <th style="display: none;">id</th>
                                      @if (Auth::user()->role_id == 11 ||
                                              Request::is('adminsearchtimesheet') ||
                                              (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                          <th class="textfixed">Employee Name</th>
                                          <th class="textfixed">Employee Code</th>
                                      @endif
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
                                  @php
                                      $hasData = false;
                                  @endphp
                                  @foreach ($timesheetData as $timesheetDatas)
                                      @php
                                          $timesheetanotherdata = DB::table('timesheetusers')
                                              ->where('timesheetid', $timesheetDatas->timesheetid)
                                              ->count();
                                      @endphp
                                      @if ($timesheetanotherdata <= 1)
                                          @php
                                              $hasData = true;
                                          @endphp
                                          <tr>
                                              @php
                                                  $permotioncheck = DB::table('teamrolehistory')
                                                      ->where('teammember_id', $timesheetDatas->createdby)
                                                      ->first();
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
                                              @if (Auth::user()->role_id == 11 ||
                                                      Request::is('adminsearchtimesheet') ||
                                                      (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                                                  <td> {{ $timesheetDatas->team_member ?? '' }} </td>
                                                  @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                                                      <td>{{ $permotioncheck->newstaff_code }}</td>
                                                  @else
                                                      <td>{{ $timesheetDatas->staffcode }}</td>
                                                  @endif
                                              @endif

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
                                      @endif
                                  @endforeach
                                  @if (!$hasData)
                                      <tr>
                                          <td colspan="7" style="text-align: center;">Data not available
                                          </td>
                                      </tr>
                                  @endif
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
  <script>
      $(document).ready(function() {
          $('#examplee').DataTable({
              dom: 'Bfrtip',
              "order": [],
              searching: false,

              columnDefs: [{
                  targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
                  orderable: false
              }],

              buttons: [{
                      extend: 'excelHtml5',
                      filename: 'Total_Travel_days',

                      //   remove extra date from column
                      exportOptions: {
                          columns: ':visible',
                          format: {
                              body: function(data, row, column, node) {
                                  // it should be column number 2
                                  if (column === 0) {
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
  </script>

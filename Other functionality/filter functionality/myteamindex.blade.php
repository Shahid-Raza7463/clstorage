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
                      <div class="row row-sm">
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">All Partner</label>
                                  <select class="language form-control" id="category1" name="partnersearch">
                                      <option value="">Please Select One</option>
                                      @foreach ($partner as $teammemberData)
                                          <option value="{{ $teammemberData->id }}">
                                              {{ $teammemberData->team_member }}
                                          </option>
                                      @endforeach
                                  </select>
                                  {{-- <select class="language form-control" id="category" name="partnersearch">
                                      <option value="">Please Select One</option>
                                      @foreach ($partner as $teammemberData)
                                          <option value="{{ $teammemberData->team_member }}">
                                              {{ $teammemberData->team_member }}
                                          </option>
                                      @endforeach
                                  </select> --}}
                              </div>
                          </div>
                          {{-- <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Period Date ( Monday To Saturday )</label>
                                  <select class="language form-control" id="category2" name="searchdate">
                                      <option value="">Please Select One</option>
                                      @foreach ($get_date as $jobDatas)
                                          <option value="{{ $jobDatas->week }}">
                                              {{ $jobDatas->week }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div> --}}
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Period Date ( Monday To Saturday )</label>
                                  <select class="language form-control" id="category2" name="searchdate">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->week, $displayedValues))
                                              <option value="{{ $jobDatas->week }}">
                                                  {{ $jobDatas->week }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->week;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Timesheet Filled Day</label>
                                  <select class="language form-control" id="category3" name="totaldays">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobDatas)
                                          @if (!in_array($jobDatas->totaldays, $displayedValues))
                                              <option value="{{ $jobDatas->totaldays }}">
                                                  {{ $jobDatas->totaldays }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobDatas->totaldays;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>
                          {{-- <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Hour</label>
                                  <select class="language form-control" id="category4" name="totalhours">
                                      <option value="">Please Select One</option>
                                      @foreach ($get_date as $jobDatas)
                                          <option value="{{ $jobDatas->totaltime }}">
                                              {{ $jobDatas->totaltime }}
                                          </option>
                                      @endforeach
                                  </select>
                              </div>
                          </div> --}}
                          <div class="col-3">
                              <div class="form-group">
                                  <label class="font-weight-600">Total Hour</label>
                                  <select class="language form-control" id="category4" name="totalhours">
                                      <option value="">Please Select One</option>
                                      @php
                                          $displayedValues = [];
                                      @endphp
                                      @foreach ($get_date as $jobData)
                                          @if (!in_array($jobData->totaltime, $displayedValues))
                                              <option value="{{ $jobData->totaltime }}">
                                                  {{ $jobData->totaltime }}
                                              </option>
                                              @php
                                                  $displayedValues[] = $jobData->totaltime;
                                              @endphp
                                          @endif
                                      @endforeach
                                  </select>
                              </div>
                          </div>

                      </div>
                      <table class="table display table-bordered table-striped table-hover basic">
                          <thead>
                              <tr>
                                  <th>Team Name</th>
                                  <th>Period Date ( Monday To Saturday )</th>
                                  <th>Total Timesheet Filled Day</th>
                                  <th>Total Hour</th>
                                  <th>Partner</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach ($get_date as $jobDatas)
                                  <tr>
                                      <td><a
                                              href="{{ url(
                                                  '/weeklylist?' .
                                                      'id=' .
                                                      $jobDatas->id .
                                                      '&&' .
                                                      'teamid=' .
                                                      $jobDatas->teamid .
                                                      '&&' .
                                                      'partnerid=' .
                                                      $jobDatas->partnerid .
                                                      '&&' .
                                                      'startdate=' .
                                                      $jobDatas->startdate .
                                                      '&&' .
                                                      'enddate=' .
                                                      $jobDatas->enddate,
                                              ) }}">{{ $jobDatas->team_member }}</a>
                                      </td>
                                      <td>{{ $jobDatas->week }}</td>
                                      <td>{{ $jobDatas->totaldays }}</td>
                                      <td>{{ $jobDatas->totaltime }}</td>
                                      <td>{{ $jobDatas->partnername }}</td>
                              @endforeach
                          </tbody>
                      </table>
                  </div>

              </div>
          </div>

      </div>
      <!--/.body content-->
  @endsection

  {{-- filter on timesheet submitted --}}
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      $(document).ready(function() {
          //   all partner
          //   $('#category1').change(function() {
          //       var search1 = $(this).val();
          //       // Send an AJAX request to fetch filtered data based on the selected partner
          //       $.ajax({
          //           type: 'GET',
          //           url: '/filter-data',
          //           data: {
          //               partnersearch: search1
          //           },
          //           success: function(data) {
          //               // Replace the table body with the filtered data
          //               $('table tbody').html(""); // Clear the table body
          //               $.each(data, function(index, item) {

          //                   // Create the URL dynamically
          //                   var url = '/weeklylist?id=' + item.id +
          //                       '&teamid=' + item.teamid +
          //                       '&partnerid=' + item.partnerid +
          //                       '&startdate=' + item.startdate +
          //                       '&enddate=' + item.enddate;

          //                   // Add the rows to the table
          //                   $('table tbody').append('<tr>' +
          //                       '<td><a href="' + url + '">' + item.team_member +
          //                       '</a></td>' +
          //                       '<td>' + item.week + '</td>' +
          //                       '<td>' + item.totaldays + '</td>' +
          //                       '<td>' + item.totaltime + '</td>' +
          //                       '<td>' + item.partnername + '</td>' +
          //                       '</tr>');
          //               });
          //           }
          //       });
          //   });

          //   all partner
          $('#category1').change(function() {
              var search1 = $(this).val();
              console.log(search1);
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-data',
                  data: {
                      partnersearch: search1
                  },
                  success: function(data) {
                      // Clear the table body
                      $('table tbody').html("");

                      if (data.length === 0) {
                          // If no data is found, display a "No data found" message
                          $('table tbody').append(
                              '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                          );
                      } else {
                          $.each(data, function(index, item) {

                              // Create the URL dynamically
                              var url = '/weeklylist?id=' + item.id +
                                  '&teamid=' + item.teamid +
                                  '&partnerid=' + item.partnerid +
                                  '&startdate=' + item.startdate +
                                  '&enddate=' + item.enddate;

                              // Add the rows to the table
                              $('table tbody').append('<tr>' +
                                  '<td><a href="' + url + '">' + item
                                  .team_member +
                                  '</a></td>' +
                                  '<td>' + item.week + '</td>' +
                                  '<td>' + item.totaldays + '</td>' +
                                  '<td>' + item.totaltime + '</td>' +
                                  '<td>' + item.partnername + '</td>' +
                                  '</tr>');
                          });
                      }
                  }
              });
          });
          //   date wise 
          $('#category2').change(function() {
              var search2 = $(this).val();

              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-data',
                  data: {
                      searchdate: search2
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body
                      $.each(data, function(index, item) {

                          // Create the URL dynamically
                          var url = '/weeklylist?id=' + item.id +
                              '&teamid=' + item.teamid +
                              '&partnerid=' + item.partnerid +
                              '&startdate=' + item.startdate +
                              '&enddate=' + item.enddate;

                          // Add the rows to the table
                          $('table tbody').append('<tr>' +
                              '<td><a href="' + url + '">' + item.team_member +
                              '</a></td>' +
                              '<td>' + item.week + '</td>' +
                              '<td>' + item.totaldays + '</td>' +
                              '<td>' + item.totaltime + '</td>' +
                              '<td>' + item.partnername + '</td>' +
                              '</tr>');
                      });
                  }
              });
          });
          //   days wise
          $('#category3').change(function() {
              var search3 = $(this).val();
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-data',
                  data: {
                      totaldays: search3
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body
                      $.each(data, function(index, item) {

                          // Create the URL dynamically
                          var url = '/weeklylist?id=' + item.id +
                              '&teamid=' + item.teamid +
                              '&partnerid=' + item.partnerid +
                              '&startdate=' + item.startdate +
                              '&enddate=' + item.enddate;

                          // Add the rows to the table
                          $('table tbody').append('<tr>' +
                              '<td><a href="' + url + '">' + item.team_member +
                              '</a></td>' +
                              '<td>' + item.week + '</td>' +
                              '<td>' + item.totaldays + '</td>' +
                              '<td>' + item.totaltime + '</td>' +
                              '<td>' + item.partnername + '</td>' +
                              '</tr>');
                      });
                  }
              });
          });
          //   total hour wise
          $('#category4').change(function() {
              var search4 = $(this).val();
              // Send an AJAX request to fetch filtered data based on the selected partner
              $.ajax({
                  type: 'GET',
                  url: '/filter-data',
                  data: {
                      totalhours: search4
                  },
                  success: function(data) {
                      // Replace the table body with the filtered data
                      $('table tbody').html(""); // Clear the table body
                      $.each(data, function(index, item) {

                          // Create the URL dynamically
                          var url = '/weeklylist?id=' + item.id +
                              '&teamid=' + item.teamid +
                              '&partnerid=' + item.partnerid +
                              '&startdate=' + item.startdate +
                              '&enddate=' + item.enddate;

                          // Add the rows to the table
                          $('table tbody').append('<tr>' +
                              '<td><a href="' + url + '">' + item.team_member +
                              '</a></td>' +
                              '<td>' + item.week + '</td>' +
                              '<td>' + item.totaldays + '</td>' +
                              '<td>' + item.totaltime + '</td>' +
                              '<td>' + item.partnername + '</td>' +
                              '</tr>');
                      });
                  }
              });
          });
          //shahid
      });
  </script>

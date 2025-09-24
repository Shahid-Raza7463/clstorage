 <!--Third party Styles(used by this page)-->
 <link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
 <link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
 <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
 <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
 @extends('backEnd.layouts.layout') @section('backEnd_content')

     <!--Content Header (Page header)-->
     <div class="content-header row align-items-center m-0">
         <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
             @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 18)
                 @if (Request::is('teamapplication/store'))
                     <a href="{{ url('applyleave') }}" style="float: right" class="btn btn-success ml-2">Back</a>
                 @endif
                 @if (Request::is('applyleave'))
                     <a href="{{ url('applyleave/create/') }}" style="float: right;" class="btn btn-success ml-2">Apply
                         Leave</a>
                 @endif
             @endif
         </nav>
         <div class="col-sm-8 header-title p-0">
             <div class="media">
                 <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                 <div class="media-body">
                     <h1 class="font-weight-bold">Home</h1>
                     <small>From now on you will start your activities.</small>
                 </div>
             </div>
         </div>
     </div>
     <div class="body-content">
     </div>
     <!--/.Content Header (Page header)-->
     <div class="body-content">
         <div class="card mb-4">
             <div class="card-header" style="background:#37A000">

                 <div class="d-flex justify-content-between align-items-center">

                     <div>
                         <h6 class="fs-17 font-weight-600 mb-0">
                             <span style="color:white;">Apply Leave List</span>

                         </h6>
                     </div>

                 </div>
             </div>
             <div class="card-body">
                 @component('backEnd.components.alert')
                 @endcomponent
                 <div class="table-responsive">
                     {{-- filtering functionality --}}
                     <form id="filterform" method="POST" action="{{ url('/filtering-applyleve') }}"
                         enctype="multipart/form-data">
                         @csrf

                         <div class="row">
                             <div class="col-3">
                                 <div class="form-group">
                                     <strong><label for="employee">Employee</label></strong>
                                     <select class="language form-control" id="employee1" name="employee">
                                         <option value="">Please Select One</option>
                                         @php
                                             $displayedValues = [];
                                         @endphp
                                         @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                                             @if (!in_array($applyleaveDatas->emailid, $displayedValues))
                                                 <option value="{{ $applyleaveDatas->createdby }}"
                                                     {{ old('employee') == $applyleaveDatas->createdby ? 'selected' : '' }}>
                                                     {{ $applyleaveDatas->team_member }}
                                                     ({{ $applyleaveDatas->newstaff_code ?? ($applyleaveDatas->staffcode ?? '') }})
                                                 </option>
                                                 @php
                                                     $displayedValues[] = $applyleaveDatas->emailid;
                                                 @endphp
                                             @endif
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                             <div class="col-3">
                                 <div class="form-group">
                                     <strong> <label for="leave">Leave Type</label></strong>
                                     <select class="language form-control" id="leave1" name="leave">
                                         <option value="">Please Select One</option>
                                         @php
                                             $displayedValues = [];
                                         @endphp
                                         @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                                             @if (!in_array($applyleaveDatas->name, $displayedValues))
                                                 <option value="{{ $applyleaveDatas->leavetype }}"
                                                     {{ old('leave') == $applyleaveDatas->leavetype ? 'selected' : '' }}>
                                                     {{ $applyleaveDatas->name }}
                                                 </option>
                                                 @php
                                                     $displayedValues[] = $applyleaveDatas->name;
                                                 @endphp
                                             @endif
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                             <div class="col-3">
                                 <div class="form-group">
                                     <strong><label for="status">Status</label></strong>
                                     <select class="language form-control" id="status1" name="status">
                                         <option value="">Please Select One</option>
                                         @php
                                             $displayedValues = [];
                                         @endphp
                                         @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                                             @if (!in_array($applyleaveDatas->status, $displayedValues))
                                                 <option value="{{ $applyleaveDatas->status }}">
                                                     @if ($applyleaveDatas->status == 0)
                                                         Created
                                                     @elseif($applyleaveDatas->status == 1)
                                                         Approved
                                                     @else
                                                         Rejected
                                                     @endif
                                                 </option>
                                                 @php
                                                     $displayedValues[] = $applyleaveDatas->status;
                                                 @endphp
                                             @endif
                                         @endforeach
                                     </select>
                                 </div>
                             </div>
                             <div class="col-3">
                                 <div class="form-group">
                                     <strong> <label for="start">Start Request Date</label></strong>
                                     <input type="date" class="form-control startclass" id="start1" name="start"
                                         value="{{ old('start') }}">
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-3">
                                 <div class="form-group">
                                     <strong> <label class="font-weight-600">End Request Date <span id="endDateAsterisk"
                                                 class="text-danger d-none">*</span></label></strong>
                                     <input type="date" class="form-control endclass" id="end1" name="end"
                                         value="{{ old('end') }}">
                                 </div>
                             </div>
                             <div class="col-3">
                                 <div class="form-group">
                                     <strong><label class="font-weight-600">Start Leave Period</label></strong>
                                     <input type="date" class="form-control startclass" id="startperiod1"
                                         name="startperiod" value="{{ old('startperiod') }}">
                                 </div>
                             </div>
                             <div class="col-4">
                                 <div class="form-group">
                                     <strong> <label class="font-weight-600">End Leave Period <span id="endPeriodAsterisk"
                                                 class="text-danger d-none">*</span></label></strong>
                                     <input type="date" class="form-control endclass" id="endperiod1" name="endperiod"
                                         value="{{ old('endperiod') }}">
                                 </div>
                             </div>
                             {{-- <div class="col-2" id="clickExcell">
                                    <div class="form-group" style="position: relative; top: 29px;">
                                        <button class="btn btn-success">Download</button>
                                    </div>
                                </div> --}}

                             <!-- Search Button -->
                             <div class="col-md-2 col-sm-6 mb-3">
                                 <div class="form-group">
                                     <label for="search">&nbsp;</label>
                                     <button type="submit" class="btn btn-success btn-block">Search</button>
                                 </div>
                             </div>
                         </div>
                     </form>
                     <table id="examplee" class="display nowrap">
                         <thead>
                             <tr>
                                 <div class="refresh-btn-container"
                                     style="position: relative; left: 305px; top: 34px; z-index: 1;">
                                     <a href="{{ url('/applyleave') }}" class="btn btn-success">Refresh</a>
                                 </div>
                             </tr>
                             <tr>
                                 <th style="display: none;">id</th>
                                 <th>Employee</th>
                                 <th class="textfixed">Staff Code</th>
                                 <th class="textfixed">Date of Request</th>
                                 <th>Status</th>
                                 <th class="textfixed">Leave Type</th>
                                 <th>Leave Period</th>
                                 <th>Days</th>
                                 <th>Approver</th>
                                 <th class="textfixed">Approver Code</th>
                                 <th>Reason for Leave</th>
                                 @if ($hasPendingRequests)
                                     <th>Approved</th>
                                     <th>Reject</th>
                                 @endif
                             </tr>
                         </thead>
                         <tbody>

                             @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                 <tr>
                                     <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                                     <td class="textfixed"> <a
                                             href="{{ route('applyleave.show', $applyleaveDatas->id) }}">
                                             {{ $applyleaveDatas->team_member ?? '' }}</a>
                                     </td>
                                     {{-- <td>{{ $applyleaveDatas->staffcode }}</td> --}}
                                     <td>{{ $applyleaveDatas->newstaff_code ?? ($applyleaveDatas->staffcode ?? '') }}</td>
                                     {{-- <td class="textfixed">
                                         {{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) ?? '' }}</td> --}}

                                     <td class="textfixed">
                                         <span style="display: none;">
                                             {{ date('Y-m-d', strtotime($applyleaveDatas->created_at)) }}
                                         </span>
                                         {{ date('d-m-Y', strtotime($applyleaveDatas->created_at)) }}
                                     </td>
                                     <td class="columnSize">
                                         @if ($applyleaveDatas->status == 0)
                                             <span class="badge badge-pill badge-warning"><span
                                                     style="display: none;">A</span>Created</span>
                                         @elseif($applyleaveDatas->status == 1)
                                             <span class="badge badge-success"><span
                                                     style="display: none;">B</span>Approved</span>
                                         @elseif($applyleaveDatas->status == 2)
                                             <span class="badge badge-danger">Rejected</span>
                                         @endif
                                     </td>

                                     <td class="textfixed">

                                         {{ $applyleaveDatas->name ?? '' }}
                                         @if ($applyleaveDatas->type == '0')
                                             <b>Type :</b> <span>Birthday</span><br>
                                             <span><b>Birthday Date :
                                                 </b>{{ date(
                                                     'F d,Y',
                                                     strtotime(
                                                         App\Models\Teammember::select('dateofbirth')->where('id', $applyleaveDatas->createdby)->first()->dateofbirth,
                                                     ),
                                                 ) ?? '' }}</span>
                                         @elseif($applyleaveDatas->type == '1')
                                             <span>Religious Festival</span>
                                         @endif
                                     </td>
                                     <td class="textfixed">{{ date('d-m-Y', strtotime($applyleaveDatas->from)) ?? '' }} -
                                         {{ date('d-m-Y', strtotime($applyleaveDatas->to)) ?? '' }}</td>
                                     @php
                                         $to = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->to ?? '');
                                         $from = Carbon\Carbon::createFromFormat('Y-m-d', $applyleaveDatas->from);
                                         $diff_in_days = $to->diffInDays($from) + 1;
                                         $holidaycount = DB::table('holidays')
                                             ->where('startdate', '>=', $applyleaveDatas->from)
                                             ->where('enddate', '<=', $applyleaveDatas->to)
                                             ->count();
                                     @endphp
                                     <td>{{ $diff_in_days - $holidaycount ?? '' }}</td>

                                     @php
                                         $approvelpartner = DB::table('teammembers')
                                             ->leftJoin(
                                                 'teamrolehistory',
                                                 'teamrolehistory.teammember_id',
                                                 '=',
                                                 'teammembers.id',
                                             )
                                             ->where('teammembers.id', $applyleaveDatas->approver)
                                             ->select(
                                                 'teammembers.team_member',
                                                 'teammembers.staffcode',
                                                 'teamrolehistory.newstaff_code',
                                                 'teamrolehistory.created_at',
                                             )
                                             ->first();

                                         $datadate = Carbon\Carbon::createFromFormat(
                                             'Y-m-d H:i:s',
                                             $applyleaveDatas->created_at,
                                         );

                                         $permotiondate = null;
                                         if ($approvelpartner->created_at) {
                                             $permotiondate = Carbon\Carbon::createFromFormat(
                                                 'Y-m-d H:i:s',
                                                 $approvelpartner->created_at,
                                             );
                                         }
                                     @endphp


                                     <td class="textfixed">
                                         {{ $approvelpartner->team_member ?? '' }}
                                     </td>
                                     <td>
                                         @if ($permotiondate && $datadate->greaterThan($permotiondate))
                                             {{ $approvelpartner->newstaff_code }}
                                         @else
                                             {{ $approvelpartner->staffcode }}
                                         @endif
                                     </td>
                                     {{-- <td class="textfixed">
                                         {{ $applyleaveDatas->reasonleave ?? '' }}
                                     </td> --}}
                                     {{-- <td class="textfixed">
                                         @if (strlen($applyleaveDatas->reasonleave) > 25)
                                             <span class="reasonleave-truncated" data-toggle="tooltip"
                                                 title="{{ $applyleaveDatas->reasonleave }}">
                                                 {{ substr($applyleaveDatas->reasonleave, 0, 25) }}...
                                             </span>
                                         @else
                                             {{ $applyleaveDatas->reasonleave ?? '' }}
                                         @endif
                                     </td> --}}
                                     {{-- examplee --}}
                                     <td class="textfixed">
                                         @if (strlen($applyleaveDatas->reasonleave) > 30)
                                             <span id="reasonleave-{{ $applyleaveDatas->id }}"
                                                 class="reasonleave-truncated"
                                                 title="{{ $applyleaveDatas->reasonleave }}">
                                                 {{ substr($applyleaveDatas->reasonleave, 0, 30) }}.....
                                                 <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                                     title="Show full text"
                                                     onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                                                     Detail</span>
                                             </span>
                                         @else
                                             {{ $applyleaveDatas->reasonleave ?? '' }}
                                         @endif
                                     </td>
                                     @if ($hasPendingRequests)
                                         <td style="align-content: center;">
                                             @if ($applyleaveDatas->status == 0)
                                                 <form method="post"
                                                     action="{{ route('applyleave.update', $applyleaveDatas->id) }}"
                                                     enctype="multipart/form-data"
                                                     style="text-align: center;margin: 0px;">
                                                     @method('PATCH')
                                                     @csrf
                                                     <input type="text" hidden id="example-date-input" name="status"
                                                         value="1" class="form-control"
                                                         placeholder="Enter Location">
                                                     <button type="submit" class="btn btn-success"
                                                         style="border-radius: 7px; font-size: 10px; padding: 5px;"
                                                         onclick="return confirm('Are you sure you want to approve this ?');">
                                                         Approve</button>
                                                 </form>
                                             @else
                                                 {{-- <p style="text-align: center;">N/A</p> --}}
                                                 {{-- <span style="display: block; text-align: center;">N/A</span> --}}
                                                 <span
                                                     style="display: inline-block; width: 100%; text-align: center;">N/A</span>
                                             @endif
                                         </td>
                                     @endif
                                     @if ($hasPendingRequests)
                                         <td style="align-content: center;">
                                             @if ($applyleaveDatas->status == 0)
                                                 <button data-toggle="modal"
                                                     data-target="#exampleModal12{{ $loop->index }}"
                                                     class="btn btn-danger"
                                                     style="border-radius: 7px; font-size: 10px; padding: 5px;">
                                                     Reject</button>
                                             @else
                                                 {{-- <p style="text-align: center;">N/A</p> --}}
                                                 {{-- <span style="display: block; text-align: center;">N/A</span> --}}
                                                 <span
                                                     style="display: inline-block; width: 70%; text-align: center;">N/A</span>
                                             @endif
                                         </td>
                                     @endif

                                     {{-- model box --}}
                                     @if ($applyleaveDatas->status == 0)
                                         <div class="modal fade" id="exampleModal12{{ $loop->index }}" tabindex="-1"
                                             role="dialog" aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                             <div class="modal-dialog" role="document">
                                                 <div class="modal-content">
                                                     <div class="modal-header" style="background:#37A000">
                                                         <h5 style="color: white" class="modal-title font-weight-600"
                                                             id="exampleModalLabel1">Reason For
                                                             Rejection</h5>
                                                         <button type="button" class="close" data-dismiss="modal"
                                                             aria-label="Close">
                                                             <span aria-hidden="true">&times;</span>
                                                         </button>
                                                     </div>
                                                     <form method="post"
                                                         action="{{ url('applyleave/update', $applyleaveDatas->id) }}"
                                                         enctype="multipart/form-data" id="formdata">
                                                         @csrf
                                                         <div class="modal-body">
                                                             <div class="row row-sm">
                                                                 <div class="col-12">
                                                                     <label for="">Reason : <span
                                                                             class="text-danger">*</span> </label>
                                                                 </div>
                                                                 <div class="col-12">
                                                                     <div class="form-group">
                                                                         <textarea rows="6" name="remark" class="form-control" placeholder="" id="reasoninput-{{ $loop->index }}"></textarea>
                                                                         <input hidden type="text"
                                                                             id="example-date-input" name="status"
                                                                             value="2" class="form-control"
                                                                             placeholder="Enter Reason">
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <button type="button" class="btn btn-danger"
                                                                 data-dismiss="modal">Close</button>
                                                             <button type="submit" style="float: right"
                                                                 class="btn btn-success saveform"
                                                                 id="saveform-{{ $loop->index }}">Save</button>
                                                         </div>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                         <script>
                                             $(document).ready(function() {
                                                 $('#exampleModal12{{ $loop->index }}').on('hidden.bs.modal', function() {
                                                     $(this).find('form')[0].reset();
                                                 });
                                             });
                                         </script>
                                     @endif
                                 </tr>


                                 <script>
                                     $(function() {
                                         $('[data-toggle="tooltip"]').tooltip({
                                             html: true,
                                             placement: 'top',
                                             container: 'body'
                                         });
                                     });
                                 </script>
                                 <style>
                                     .reasonleave-truncated {
                                         overflow: hidden;
                                         text-overflow: ellipsis;
                                         white-space: nowrap;
                                     }

                                     .textfixed {
                                         overflow: hidden;
                                         text-overflow: ellipsis;
                                         white-space: nowrap;
                                     }
                                 </style>
                             @endforeach
                         </tbody>
                     </table>

                 </div>
             </div>
         </div>

     </div>
     <!--/.body content-->
 @endsection


 {{-- Model box for tooltip --}}
 <div class="modal fade" id="fullTextModal" tabindex="-1" role="dialog" aria-labelledby="fullTextModalLabel"
     aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="fullTextModalLabel">Full Detail
                 </h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <p id="fullTextContent"></p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
         </div>
     </div>
 </div>

 <script>
     function showFullText(fullText) {
         // Set the full text content in the modal
         document.getElementById('fullTextContent').textContent = fullText;
         // Show the modal
         $('#fullTextModal').modal('show');
     }
     // Initialize tooltips
     $(function() {
         $('[data-toggle="tooltip"]').tooltip();
     });
 </script>

 <style>
     .reasonleave-truncated {
         display: inline;
     }

     .textfixed {
         overflow: hidden;
         text-overflow: ellipsis;
         white-space: nowrap;
     }
 </style>

 {{-- Model box for tooltip end hare --}}
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
             pageLength: 50,
             dom: 'Bfrtip',
             "order": [
                 [4, "asc"]
             ],
             columnDefs: [{
                 //  targets: [1, 2, 5, 6, 7, 8, 9, 10, 11, 12],
                 @if ($hasPendingRequests)
                     targets: [1, 2, 5, 6, 7, 8, 9, 10, 11, 12],
                 @else
                     targets: [1, 2, 5, 6, 7, 8, 9, 10],
                 @endif
                 orderable: false
             }],
             buttons: [{
                     extend: 'copyHtml5',
                     exportOptions: {
                         columns: [0, ':visible']
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     filename: 'Apply Report List',
                     //  Change value Acreated to created and AApproved to Approved
                     customizeData: function(data) {
                         for (var i = 0; i < data.body.length; i++) {
                             for (var j = 0; j < data.body[i].length; j++) {
                                 if (data.body[i][j] === 'ACreated') {
                                     data.body[i][j] = 'Created';
                                 } else if (data.body[i][j] === 'BApproved') {
                                     data.body[i][j] = 'Approved';
                                 } else if (data.body[i][j] === 'Rejected') {
                                     data.body[i][j] = 'Rejected';
                                 }
                             }
                         }
                     },
                     //  exportOptions: {
                     //      columns: ':visible'
                     //  }
                     exportOptions: {
                         columns: ':visible',
                         format: {
                             body: function(data, row, column, node) {
                                 // it should be column number 2
                                 if (column === 2) {
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
                                 if (column === 0 || column === 3 || column === 10 || column ===
                                     11) {
                                     var cleanedText = $(data).text().trim();
                                     return cleanedText;
                                 }
                                 if (column === 9) {
                                     var fullText = $(node).find('span').attr('title') || $(node)
                                         .text().trim();
                                     return fullText;
                                 }
                                 return data;
                             }
                         }
                     },

                     //   set width in excell
                     customize: function(xlsx) {
                         var sheet = xlsx.xl.worksheets['sheet1.xml'];
                         // set column width
                         $('col', sheet).eq(0).attr('width', 20);
                         $('col', sheet).eq(1).attr('width', 10);
                         $('col', sheet).eq(2).attr('width', 15);
                         $('col', sheet).eq(4).attr('width', 15);
                         //  leave periode column number 5
                         $('col', sheet).eq(5).attr('width', 23);
                         $('col', sheet).eq(6).attr('width', 8);
                         $('col', sheet).eq(7).attr('width', 25);
                         $('col', sheet).eq(8).attr('width', 14);
                         $('col', sheet).eq(9).attr('width', 40);
                         // remove extra spaces
                         $('c', sheet).each(function() {
                             var originalText = $(this).find('is t').text();
                             var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                             $(this).find('is t').text(cleanedText);
                         });
                     }

                 },
                 {
                     extend: 'pdfHtml5',
                     filename: 'Apply Report List',
                     //  Change value Acreated to created and AApproved to Approved
                     customize: function(doc) {
                         // Assuming the status column is at index 3, adjust as needed
                         for (var i = 0; i < doc.content[1].table.body.length; i++) {
                             var originalValue = doc.content[1].table.body[i][3].text;
                             if (originalValue === 'ACreated') {
                                 doc.content[1].table.body[i][3].text = 'Created';
                             } else if (originalValue === 'BApproved') {
                                 doc.content[1].table.body[i][3].text = 'Approved';
                             } else if (originalValue === 'CRejected') {
                                 doc.content[1].table.body[i][3].text = 'Rejected';
                             }
                         }
                     },
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
         function validateDateRange(startSelector, endSelector, errorMessage) {
             var startDateInput = $(startSelector);
             var endDateInput = $(endSelector);

             function compareDates() {
                 var startDate = new Date(startDateInput.val());
                 var endDate = new Date(endDateInput.val());

                 if (startDate > endDate) {
                     alert(errorMessage);
                     endDateInput.val('');
                 }
             }

             startDateInput.on('input', compareDates);
             endDateInput.on('blur', compareDates);
         }

         function validateYearInput(inputSelector) {
             $(inputSelector).on('change', function() {
                 var input = $(this);
                 var dateValue = new Date(input.val());
                 var year = dateValue.getFullYear();
                 if (year.toString().length > 4) {
                     alert('Enter four digits for the year');
                     input.val('');
                 }
             });
         }

         // Apply date range validation
         validateDateRange('#start1', '#end1',
             "'End Request Date' should be greater than or equal to the 'Start Request Date'");
         validateDateRange('#startperiod1', '#endperiod1',
             "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

         // Apply year validation
         validateYearInput('#start1');
         validateYearInput('#end1');
         validateYearInput('#startperiod1');
         validateYearInput('#endperiod1');


         // Validation on submit button click 
         //  $('form').submit(function(event) {
         $('#filterform').submit(function(event) {
             var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                 '#endperiod1'
             ];

             var allEmpty = fields.every(function(selector) {
                 return $(selector).val() === "";
             });

             if (allEmpty) {
                 alert("Please select data for filter");
                 event.preventDefault(); // Prevent form submission if all fields are empty
             }

             // Validate date pairs
             var startDate = $('#start1').val();
             var endDate = $('#end1').val();
             var startPeriod = $('#startperiod1').val();
             var endPeriod = $('#endperiod1').val();

             function validateDatePair(start, end, asteriskId, message) {
                 if (start && !end) {
                     alert(message);
                     $(asteriskId).removeClass("d-none"); // Show the asterisk
                     event.preventDefault();
                     return false;
                 }
                 $(asteriskId).addClass("d-none"); // Hide the asterisk if validation passes
                 return true;
             }

             // Validate both date ranges and show the corresponding asterisk
             if (!validateDatePair(startDate, endDate, "#endDateAsterisk",
                     "Please select an 'End Request Date'.") ||
                 !validateDatePair(startPeriod, endPeriod, "#endPeriodAsterisk",
                     "Please select an 'End Leave Period'.")) {
                 return; // Stop if any validation fails
             }
             // Validate date pairs end hare 

         });
     });
 </script>

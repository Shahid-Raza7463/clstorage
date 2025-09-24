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


                     {{-- 22222222222222222222222222222222222222222222222222222 --}}
                     <form method="POST" action="{{ url('/filtering-applyleve') }}" enctype="multipart/form-data">
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
                                     <strong> <label class="font-weight-600">End Request Date</label></strong>
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
                                     <strong> <label class="font-weight-600">End Leave Period</label></strong>
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
                     {{-- 22222222222222222222222222222222222222222222222222222 --}}



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
                                         @if (strlen($applyleaveDatas->reasonleave) > 25)
                                             <span id="reasonleave-{{ $applyleaveDatas->id }}"
                                                 class="reasonleave-truncated"
                                                 title="{{ $applyleaveDatas->reasonleave }}">
                                                 {{ substr($applyleaveDatas->reasonleave, 0, 25) }}.....
                                                 <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip"
                                                     title="Show full text"
                                                     onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                                                     Detail</span>
                                             </span>
                                         @else
                                             {{ $applyleaveDatas->reasonleave ?? '' }}
                                         @endif
                                     </td>
                                     <td style="align-content: center;">
                                         @if ($applyleaveDatas->status == 0)
                                             <form method="post"
                                                 action="{{ route('applyleave.update', $applyleaveDatas->id) }}"
                                                 enctype="multipart/form-data" style="text-align: center;margin: 0px;">
                                                 @method('PATCH')
                                                 @csrf
                                                 <input type="text" hidden id="example-date-input" name="status"
                                                     value="1" class="form-control" placeholder="Enter Location">
                                                 <button type="submit" class="btn btn-success"
                                                     style="border-radius: 7px; font-size: 10px; padding: 5px;"
                                                     onclick="return confirm('Are you sure you want to approve this ?');">
                                                     Approve</button>
                                             </form>
                                         @endif
                                     </td>
                                     <td style="align-content: center;">
                                         @if ($applyleaveDatas->status == 0)
                                             <button data-toggle="modal" data-target="#exampleModal12{{ $loop->index }}"
                                                 class="btn btn-danger"
                                                 style="border-radius: 7px; font-size: 10px; padding: 5px;">
                                                 Reject</button>
                                         @endif
                                     </td>

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
                 targets: [1, 2, 5, 6, 7, 8, 9, 10, 11, 12],
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



 {{-- add library for excell download after filter  --}}
 {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> --}}

 {{-- filter on apply leave --}}
 {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

 {{-- <script>
     $(document).ready(function() {
         // Common function to render table rows
         function renderTableRows(data) {
             $('table tbody').html("");
             $('#clickExcell').show();

             if (data.length === 0) {
                 $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
             } else {
                 $.each(data, function(index, item) {
                     var url = '/applyleave/' + item.id;
                     var createdAt = formatDate(item.created_at);
                     var fromDate = formatDate(item.from);
                     var toDate = formatDate(item.to);
                     var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                         60 * 1000)) + 1;

                     $('table tbody').append('<tr>' +
                         '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                         //  '<td>' + item.staffcode + '</td>' +
                         '<td>' + (item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode) +
                         '</td>' +
                         '<td>' + createdAt + '</td>' +
                         '<td>' + getStatusBadge(item.status) + '</td>' +
                         '<td>' + item.name + '</td>' +
                         '<td>' + fromDate + ' to ' + toDate + '</td>' +
                         '<td>' + holidays + '</td>' +
                         '<td>' + item.approvernames + '</td>' +
                         //  '<td>' + item.approvernames + '</td>' +
                         '<td>' + (item.newstaff_code ? item.newstaff_code : item
                             .approverstaffcode) + '</td>' +
                         '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                         '</tr>');
                 });
             }
         }

         // Common function to export data to Excel
         function exportToExcel(data) {
             const filteredData = data.map(item => {
                 const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                     1000)) + 1;
                 const createdAt = formatDate(item.created_at);
                 const fromDate = formatDate(item.from);
                 const toDate = formatDate(item.to);

                 return {
                     Employee: item.team_member,
                     Staff_code: item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode,
                     Date_of_Request: createdAt,
                     status: getStatusText(item.status),
                     Leave_Type: item.name,
                     from: fromDate,
                     to: toDate,
                     Days: holidays,
                     Approver: item.approvernames,
                     Approver_Code: item.newstaff_code ? item.newstaff_code : item.approverstaffcode,
                     Reason_for_Leave: item.reasonleave
                 };
             });

             const ws = XLSX.utils.json_to_sheet(filteredData);
             const headerCellStyle = {
                 font: {
                     bold: true
                 }
             };

             ws['!cols'] = [{
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 30
                 }
             ];

             Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                 ws[key].s = headerCellStyle;
             });

             const wb = XLSX.utils.book_new();
             XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
             const excelBuffer = XLSX.write(wb, {
                 bookType: "xlsx",
                 type: "array"
             });
             const dataBlob = new Blob([excelBuffer], {
                 type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
             });
             saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
         }

         // Common function to format date
         function formatDate(dateString) {
             return new Date(dateString).toLocaleDateString('en-GB', {
                 day: '2-digit',
                 month: '2-digit',
                 year: 'numeric'
             });
         }

         // Common function to get status text
         function getStatusText(status) {
             return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
         }

         // Common function to get status badge
         function getStatusBadge(status) {
             if (status === 0) {
                 return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
             } else if (status === 1) {
                 return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
             } else if (status === 2) {
                 return '<span class="badge badge-danger">Rejected</span>';
             } else {
                 return '';
             }
         }

         // Function to handle status change
         function handleStatusChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();

                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');

                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave type change
         function handleLeaveTypeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle employee change
         function handleEmployeeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     console.log(data)
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave period end date change
         function handleleaveperiodendChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         //  end Request Date end date wise
         function handleEndRequestDateChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Event handlers
         $('#employee1').change(handleEmployeeChange);
         $('#leave1').change(handleLeaveTypeChange);
         $('#status1').change(handleStatusChange);
         $('#end1').change(handleEndRequestDateChange);
         $('#endperiod1').change(handleleaveperiodendChange);
     });
 </script> --}}

 {{-- 
 <script>
     $(document).ready(function() {
         function renderTableRows(data) {
             $('table tbody').html(""); // Clear the existing rows
             $('#clickExcell').show();

             if (data.length === 0) {
                 $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
             } else {
                 $.each(data, function(index, item) {
                     var url = '/applyleave/' + item.id;
                     var createdAt = formatDate(item.created_at);
                     var fromDate = formatDate(item.from);
                     var toDate = formatDate(item.to);
                     var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                         60 * 1000)) + 1;

                     var approverCode = item.newstaff_code ? item.newstaff_code : item.approverstaffcode;

                     // Append each row to the table
                     $('table tbody').append('<tr>' +
                         '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                         '<td>' + (item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode) +
                         '</td>' +
                         '<td>' + createdAt + '</td>' +
                         '<td>' + getStatusBadge(item.status) + '</td>' +
                         '<td>' + item.name + '</td>' +
                         '<td>' + fromDate + ' to ' + toDate + '</td>' +
                         '<td>' + holidays + '</td>' +
                         '<td>' + item.approvernames + '</td>' +
                         '<td>' + approverCode + '</td>' +
                         '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                         '<td>' +
                         '<button class="btn btn-success approve-btn" data-id="' + item.id +
                         '">Approve</button> ' +
                         '<button class="btn btn-danger reject-btn" data-id="' + item.id +
                         '">Reject</button>' +
                         '</td>' +
                         '</tr>');
                 });
             }
         }

         // Function to handle approve action
         function handleApprove(id) {
             $.ajax({
                 type: 'POST',
                 url: '/approve-leave/' + id,
                 success: function(response) {
                     alert('Leave approved successfully');
                     handleStatusChange(); // Re-filter the data to refresh the table
                 }
             });
         }

         // Function to handle reject action
         function handleReject(id) {
             $.ajax({
                 type: 'POST',
                 url: '/reject-leave/' + id,
                 success: function(response) {
                     alert('Leave rejected successfully');
                     handleStatusChange(); // Re-filter the data to refresh the table
                 }
             });
         }

         // Delegate event listeners to dynamically created buttons
         $('table tbody').on('click', '.approve-btn', function() {
             var id = $(this).data('id');
             handleApprove(id);
         });

         $('table tbody').on('click', '.reject-btn', function() {
             var id = $(this).data('id');
             handleReject(id);
         });

         // Common function to export data to Excel
         function exportToExcel(data) {
             const filteredData = data.map(item => {
                 const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                     1000)) + 1;
                 const createdAt = formatDate(item.created_at);
                 const fromDate = formatDate(item.from);
                 const toDate = formatDate(item.to);

                 return {
                     Employee: item.team_member,
                     Staff_code: item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode,
                     Date_of_Request: createdAt,
                     status: getStatusText(item.status),
                     Leave_Type: item.name,
                     from: fromDate,
                     to: toDate,
                     Days: holidays,
                     Approver: item.approvernames,
                     Approver_Code: item.newstaff_code ? item.newstaff_code : item.approverstaffcode,
                     Reason_for_Leave: item.reasonleave
                 };
             });

             const ws = XLSX.utils.json_to_sheet(filteredData);
             const headerCellStyle = {
                 font: {
                     bold: true
                 }
             };

             ws['!cols'] = [{
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 30
                 }
             ];

             Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                 ws[key].s = headerCellStyle;
             });

             const wb = XLSX.utils.book_new();
             XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
             const excelBuffer = XLSX.write(wb, {
                 bookType: "xlsx",
                 type: "array"
             });
             const dataBlob = new Blob([excelBuffer], {
                 type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
             });
             saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
         }

         // Common function to format date
         function formatDate(dateString) {
             return new Date(dateString).toLocaleDateString('en-GB', {
                 day: '2-digit',
                 month: '2-digit',
                 year: 'numeric'
             });
         }

         // Common function to get status text
         function getStatusText(status) {
             return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
         }

         // Common function to get status badge
         function getStatusBadge(status) {
             if (status === 0) {
                 return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
             } else if (status === 1) {
                 return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
             } else if (status === 2) {
                 return '<span class="badge badge-danger">Rejected</span>';
             } else {
                 return '';
             }
         }

         // Function to handle status change
         function handleStatusChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();

                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');

                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave type change
         function handleLeaveTypeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle employee change
         function handleEmployeeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     console.log(data)
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave period end date change
         function handleleaveperiodendChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         //  end Request Date end date wise
         function handleEndRequestDateChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Event handlers
         $('#employee1').change(handleEmployeeChange);
         $('#leave1').change(handleLeaveTypeChange);
         $('#status1').change(handleStatusChange);
         $('#end1').change(handleEndRequestDateChange);
         $('#endperiod1').change(handleleaveperiodendChange);
     });
 </script> --}}

 {{-- Start Request Date and End Request Date validation --}}
 <script>
     $(document).ready(function() {
         var startDateInput = $('#start1');
         var endDateInput = $('#end1');

         function compareDates() {
             var startDate = new Date(startDateInput.val());
             var endDate = new Date(endDateInput.val());

             if (startDate > endDate) {
                 alert("'End Request Date' should be greater than or equal to the 'Start Request Date'");
                 endDateInput.val(''); // Clear the end date input
             }
         }

         startDateInput.on('input', compareDates);
         endDateInput.on('blur', compareDates);
     });
 </script>

 <script>
     $(document).ready(function() {
         $('#start1').on('change', function() {
             var startclear = $('#start1');
             var startDateInput1 = $('#start1').val();
             var startDate = new Date(startDateInput1);
             var startyear = startDate.getFullYear();
             var yearLength = startyear.toString().length;
             if (yearLength > 4) {
                 alert('Enter four digits for the year');
                 startclear.val('');
             }
         });
         $('#end1').on('change', function() {
             var endclear = $('#end1');
             var endDateInput1 = $('#end1').val();
             var endtDate = new Date(endDateInput1);
             var endyear = endtDate.getFullYear();
             var endyearLength = endyear.toString().length;
             if (endyearLength > 4) {
                 alert('Enter four digits for the year');
                 endclear.val('');
             }
         });
     });
 </script>

 {{-- End leave period date and Start Leave Period date validation --}}
 <script>
     $(document).ready(function() {
         var startDateInput = $('#startperiod1');
         var endDateInput = $('#endperiod1');

         function compareDates() {
             var startDate = new Date(startDateInput.val());
             var endDate = new Date(endDateInput.val());

             if (startDate > endDate) {
                 alert(
                     "'End leave period date' should be greater than or equal to the 'Start Leave Period date'"
                 );
                 endDateInput.val('');
             }
         }

         startDateInput.on('input', compareDates);
         endDateInput.on('blur', compareDates);
     });
 </script>
 <script>
     $(document).ready(function() {
         $('#startperiod1').on('change', function() {
             var startclear = $('#startperiod1');
             var startDateInput1 = $('#startperiod1').val();
             var startDate = new Date(startDateInput1);
             var startyear = startDate.getFullYear();
             var yearLength = startyear.toString().length;
             if (yearLength > 4) {
                 alert('Enter four digits for the year');
                 startclear.val('');
             }
         });
         $('#endperiod1').on('change', function() {
             var endclear = $('#endperiod1');
             var endDateInput1 = $('#endperiod1').val();
             var endtDate = new Date(endDateInput1);
             var endyear = endtDate.getFullYear();
             var endyearLength = endyear.toString().length;
             if (endyearLength > 4) {
                 alert('Enter four digits for the year');
                 endclear.val('');
             }
         });
     });
 </script>

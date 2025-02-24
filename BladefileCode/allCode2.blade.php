<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>



{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
    @if (isset($myapplyleaveDatas) && count($myapplyleaveDatas) > 0)
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab"
                aria-controls="pills-home" aria-selected="true">My Application</a>
        </li>
    @endif

    @if (Auth::user()->role_id == 13)
        <li class="nav-item">
            <a class="nav-link {{ !isset($myapplyleaveDatas) || count($myapplyleaveDatas) == 0 ? 'active' : '' }}"
                id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user"
                aria-selected="false">Team Application</a>
        </li>
    @endif
</ul>

{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding console   --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
//* regarding console
console.log("lasttimesheetsubmiteddata:", lasttimesheetsubmiteddata);
console.log("timesheetmaxDateRecord:", timesheetmaxDateRecord);
console.log("leavedataforcalander1:", leavedataforcalander1);
console.log("differenceInDays:", differenceInDays);
console.log("newteammember:", newteammember);
console.log("rejoiningdate:", rejoiningdate);
console.log("totalleaveCount:", totalleaveCount);
console.log("leavebreakdateassign:", leavebreakdateassign);
{{-- ! End hare --}}
{{-- * regarding csrf  --}}
{{--  Start Hare --}}
<input type="hidden" name="_token" value="{{ csrf_token() }}">

{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding summernote --}}
{{--  Start Hare --}}

<div class="row">
    <div class="col-12 d-flex flex-column  mb-2">
        <label for="">Description:</label>
        <textarea class="form-control summernote" name="description">{{ $data->descreption }}</textarea>
    </div>
</div>

<div class="row">
    <div class="col-12 d-flex flex-column  mb-2">
        <label for="">listdescreption:</label>
        <textarea class="form-control summernote" name="description1">{{ $data->listdescreption }}</textarea>
    </div>
</div>

<script>
    $('#summernote').summernote({
        placeholder: 'Enter Description ',
        tabsize: 2,
        height: 200
    });
</script>
{{-- <script>
                $('.summernote').summernote({
                    placeholder: 'Enter Description ',
                    tabsize: 2,
                    height: 200
                });
            </script> --}}

<!-- Include Summernote JS -->
<script>
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200, // Set height
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });
</script>
{{--  Start Hare --}}

{{-- ! End hare --}}
{{-- * regarding file and folder download --}}
{{--  Start Hare --}}


<li><strong>Download11</strong>:
    <a href="{{ asset('img/logo.png') }}" class="btn btn-success">Download</a>
</li>
<li>
    <strong>Download22:</strong>
    <a href="{{ asset('img/logo.png') }}" class="btn btn-success" download="logo.png">Download</a>
</li>
<li>
    <strong>Download33:</strong>
    <a href="{{ asset('img\creater.xlsx') }}" class="btn btn-success">Download</a>
</li>
<li>
    <strong>Download44:</strong>
    <a href="{{ asset('img/' . 'creater.xlsx') }}" class="btn btn-success">Download2</a>
</li>
<li>
    <strong>Download55:</strong>
    <a href="{{ url('img/' . 'creater.xlsx') }}" class="btn btn-success">Download2</a>
</li>

{{-- Route::get('img/{name}', [ContactUsWebController::class, 'download']);

public function download(Request $request, $name)
{
    $path = public_path('assets/img/' . $name);
    if (!file_exists($path)) {
        abort(404, 'File not found.');
    }
    return response()->download($path);
} --}}

{{--  Start Hare --}}
{{-- 
2222222222222222222222222222
resources\views\backEnd\assignmentconfirmation\index.blade.php

                              <div class="col-sm-9">
                                  <a href="{{ url('backEnd/balanceconfirmation.xlsx') }}"
                                      class="btn btn-success btn">Download<i class="fas fa-file-excel"
                                          style="margin-left: 3px;font-size: 20px;"></i></a>

                              </div>
							  
							  
222222222222222222222222222222222222222222222222222
resources\views\backEnd\article\index.blade.php

                                    <td>
                                        <a target="blank" href="{{ asset('backEnd/image/article/' . $articleData->file) }}">
                                            {{ $articleData->subject }}
                                        </a>
                                    </td>
									
									
22222222222222222222222222222222222222222222222
resources\views\backEnd\teammember\form.blade.php

                    <a href="{{ url('backEnd/image/teammember/aadharupload/', $teammember->aadharupload) }}"
                        target="blank" data-toggle="tooltip" title="{{ $teammember->aadharupload ?? '' }}"
                        class="btn btn-success-soft ml-2"><i class="fas fa-file"></i> View</a> --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding year  --}}
{{--  Start Hare --}}
<div class="btn-group mb-2 mr-1">

    @php
        $selectedYear = Request::query('year');
        if ($selectedYear == null) {
            $selectedYear = $currentYear;
        } else {
            $selectedYear = Request::query('year');
        }
    @endphp
    <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">

        {{-- @if (Request::query('year') == '2024')
            2024
        @elseif (Request::query('year') == '2023')
            2023
        @elseif (Request::query('year') == '2025')
            2025
        @else
            Choose Year
        @endif --}}

        @if (in_array($selectedYear, $years))
            {{ $selectedYear }}
        @else
            Choose Year
        @endif
    </button>
    {{-- <div class="dropdown-menu">
        <a style="color: #37A000" class="dropdown-item"
            href="{{ url('/holidays?' . 'year=' . '2025') }}">2025</a>
        <a style="color: #37A000" class="dropdown-item"
            href="{{ url('/holidays?' . 'year=' . '2024') }}">2024</a>

        <a style="color: #37A000" class="dropdown-item"
            href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
    </div> --}}
    <div class="dropdown-menu">
        @foreach ($years as $year)
            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?year=' . $year) }}">{{ $year }}</a>
        @endforeach
    </div>
</div>
{{--  Start Hare --}}
@php
    $currentDate = Carbon::now();

    $tillyearend = $currentDate->year;
    $oldyearstart = 2023;
    $years = range($tillyearend, $oldyearstart);

    $holidayDatas = DB::table('holidays')
        ->where('status', 1)
        ->where('year', $request->year)
        ->select('holidays.*')
        ->orderBy('startdate', 'asc')
        ->get();
@endphp
<li class="breadcrumb-item">
    <div class="btn-group mb-2 mr-1">

        @php
            $selectedYear = Request::query('year');
        @endphp
        <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            {{-- @if (Request::query('year') == '2024')
                2024
            @elseif (Request::query('year') == '2023')
                2023
            @elseif (Request::query('year') == '2025')
                2025
            @else
                Choose Year
            @endif --}}

            @if (in_array($selectedYear, $years))
                {{ $selectedYear }}
            @else
                Choose Year
            @endif
        </button>
        {{-- <div class="dropdown-menu">
            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?' . 'year=' . '2025') }}">2025</a>
            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?' . 'year=' . '2024') }}">2024</a>

            <a style="color: #37A000" class="dropdown-item"
                href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
        </div> --}}
        <div class="dropdown-menu">
            @foreach ($years as $year)
                <a style="color: #37A000" class="dropdown-item"
                    href="{{ url('/holidays?year=' . $year) }}">{{ $year }}</a>
            @endforeach
        </div>
    </div>
</li>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<tbody>
    @php $hasData = false; @endphp
    @foreach ($timesheetData as $timesheetDatas)
        @php
            $timesheetanotherdata = $timesheetCounts[$timesheetDatas->timesheetid] ?? 0;
            $datadate = isset($timesheetDatas->date) ? Carbon\Carbon::parse($timesheetDatas->date) : null;
        @endphp
        @if ($timesheetanotherdata <= 1)
            @php $hasData = true; @endphp
            <tr>
                <td style="display: none;">{{ $timesheetDatas->id }}</td>
                @if (Auth::user()->role_id == 11 ||
                        Request::is('adminsearchtimesheet') ||
                        (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                    <td>{{ $timesheetDatas->team_member ?? '' }}</td>
                    <td>
                        @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                            {{ $permotioncheck->newstaff_code }}
                        @else
                            {{ $timesheetDatas->staffcode }}
                        @endif
                    </td>
                @endif
                <td>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}</td>
                <td>{{ date('l', strtotime($timesheetDatas->date)) }}</td>
                <td>{{ $timesheetDatas->client_name ?? '' }}</td>
                <td>{{ $timesheetDatas->client_code ?? '' }}</td>
                <td>
                    {{ $timesheetDatas->assignment_name ?? '' }}
                    @if ($timesheetDatas->assignmentname)
                        ({{ $timesheetDatas->assignmentname ?? '' }})
                    @endif
                </td>
                <td>{{ $timesheetDatas->assignmentgenerate_id ?? '' }}</td>
                <td>{{ $timesheetDatas->workitem ?? '' }}</td>
                <td>{{ $timesheetDatas->location ?? '' }}</td>
                <td>{{ $timesheetDatas->patnername ?? '' }}</td>
                <td>
                    @if ($permotioncheck && $datadate && $datadate->greaterThan($permotiondate))
                        {{ $timesheetDatas->newstaff_code }}
                    @else
                        {{ $timesheetDatas->patnerstaffcode }}
                    @endif
                </td>
                <td>{{ $timesheetDatas->hour ?? '' }}</td>
            </tr>
        @endif
    @endforeach
    @if (!$hasData)
        <tr>
            <td colspan="7" style="text-align: center;">Data not available</td>
        </tr>
    @endif
</tbody>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding total travel count  --}}
{{--  Start Hare --}}
@php
    // public function totaltraveldays(Request $request, $teamid)
    //   {
    // Define the financial year start and end dates
    $currentDate = Carbon::now();
    $startDate =
        $currentDate->month >= 4
            ? Carbon::create($currentDate->year, 4, 1)
            : Carbon::create($currentDate->year - 1, 4, 1);
    $endDate =
        $currentDate->month >= 4
            ? Carbon::create($currentDate->year + 1, 3, 31)
            : Carbon::create($currentDate->year, 3, 31);

    // Fetch necessary data
    $timesheetData = DB::table('timesheetusers')
        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
        ->leftJoin('clients', 'clients.id', 'timesheetusers.client_id')
        ->leftJoin('assignments', 'assignments.id', 'timesheetusers.assignment_id')
        ->leftJoin('teammembers as partner', 'partner.id', 'timesheetusers.partner')
        ->leftJoin('teamrolehistory', 'teamrolehistory.teammember_id', 'partner.id')
        ->leftJoin(
            'assignmentbudgetings',
            'assignmentbudgetings.assignmentgenerate_id',
            'timesheetusers.assignmentgenerate_id',
        )
        ->select(
            'timesheetusers.*',
            'assignments.assignment_name',
            'clients.client_name',
            'clients.client_code',
            'teammembers.team_member',
            'teammembers.staffcode',
            'partner.team_member as partner_name',
            'partner.staffcode as partner_staffcode',
            'assignmentbudgetings.assignmentname',
            'teamrolehistory.newstaff_code',
            'assignmentbudgetings.created_at as assignment_created_date',
        )
        ->where('timesheetusers.createdby', $teamid)
        ->whereIn('timesheetusers.status', [1, 2, 3])
        ->whereBetween('timesheetusers.date', [$startDate->toDateString(), $endDate->toDateString()])
        ->where('timesheetusers.assignmentgenerate_id', 'OFF100003')
        ->orderBy('timesheetusers.date', 'DESC')
        ->get()

        ->map(function ($timesheet) {
            $promotionCheck = DB::table('teamrolehistory')->where('teammember_id', $timesheet->createdby)->first();

            $assignmentDate = $timesheet->assignment_created_date
                ? Carbon::parse($timesheet->assignment_created_date)
                : null;

            $promotionDate = $promotionCheck ? Carbon::parse($promotionCheck->created_at) : null;

            // Add computed fields to the object
            $timesheet->display_staffcode =
                $promotionCheck && $assignmentDate && $assignmentDate->greaterThan($promotionDate)
                    ? $promotionCheck->newstaff_code
                    : $timesheet->staffcode;

            $timesheet->display_partner_code =
                $promotionCheck && $assignmentDate && $assignmentDate->greaterThan($promotionDate)
                    ? $timesheet->newstaff_code
                    : $timesheet->partner_staffcode;

            $timesheet->formatted_date = Carbon::parse($timesheet->date)->format('d-m-Y');
            $timesheet->day_of_week = Carbon::parse($timesheet->date)->format('l');

            return $timesheet;
        });

    return view('backEnd.timesheet.totaltraveldays', compact('timesheetData'));
    //   }
@endphp

<div class="card-body">
    @component('backEnd.components.alert')
    @endcomponent
    <div class="table-responsive">
        <table id="examplee" class="table display table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th style="display: none;">ID</th>
                    @if (Auth::user()->role_id == 11 ||
                            Request::is('adminsearchtimesheet') ||
                            (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                        <th>Employee Name</th>
                        <th>Employee Code</th>
                    @endif
                    <th>Date</th>
                    <th>Day</th>
                    <th>Client Name</th>
                    <th>Client Code</th>
                    <th>Assignment Name</th>
                    <th>Assignment ID</th>
                    <th>Work Item</th>
                    <th>Location</th>
                    <th>Partner</th>
                    <th>Partner Code</th>
                    <th>Hour</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($timesheetData as $timesheet)
                    <tr>
                        <td style="display: none;">{{ $timesheet->id }}</td>
                        @if (Auth::user()->role_id == 11 ||
                                Request::is('adminsearchtimesheet') ||
                                (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                            <td>{{ $timesheet->team_member ?? '' }}</td>
                            <td>{{ $timesheet->display_staffcode ?? '' }}</td>
                        @endif
                        <td>{{ $timesheet->formatted_date }}</td>
                        <td>{{ $timesheet->day_of_week }}</td>
                        <td>{{ $timesheet->client_name ?? '' }}</td>
                        <td>{{ $timesheet->client_code ?? '' }}</td>
                        <td>
                            {{ $timesheet->assignment_name ?? '' }}
                            @if ($timesheet->assignmentname)
                                ({{ $timesheet->assignmentname }})
                            @endif
                        </td>
                        <td>{{ $timesheet->assignmentgenerate_id ?? '' }}</td>
                        <td>{{ $timesheet->workitem ?? '' }}</td>
                        <td>{{ $timesheet->location ?? '' }}</td>
                        <td>{{ $timesheet->partner_name ?? '' }}</td>
                        <td>{{ $timesheet->display_partner_code ?? '' }}</td>
                        <td>{{ $timesheet->hour ?? '' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="text-center">Data not available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}

<pre>
    
</pre>
{{--  Start Hare --}}

@php
    // $request->validate([
    //     'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg|max:4120',
    // ], [
    //     'attachment.max' => 'The file may not be greater than 5 MB.',
    // ]);
    $request->validate(
        [
            'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg,xls,xlsx|max:5120',
        ],
        [
            'attachment.max' => 'The file may not be greater than 5 MB.',
            'attachment.mimes' => 'The file must be a type of: png, pdf, jpeg, jpg, xls, xlsx.',
        ],
    );
@endphp
{{-- ! End hare --}}
{{-- * regarding requared attribute --}}
{{--  Start Hare --}}
<div class="col-6">
    <div class="form-group">
        <label class="font-weight-600">Target *</label>

        <select required class="form-control basic-multiple" multiple="multiple" id="exampleFormControlSelect111"
            name="targettype[]">
            <option value="" disabled> Please Select One</option>
            <option value="1">Individual</option>
            <option value="2">All Member</option>
            <option value="3">Partner</option>
            <option value="4">Manager</option>
            <option value="5">Staff</option>
            <option value="6">IT Department</option>
            <option value="7">Accountant</option>
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#exampleFormControlSelect111').on('change', function() {
            if (this.value == '1') {
                $("#designation").show();
                document.getElementById("designationinput").required = true;
            } else {
                $("#designation").hide();
                document.getElementById("designationinput").required = false;
            }
        });
    });
</script>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding summernote  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Announcement Content *</label>
            <textarea rows="4" name="mail_content" class="centered form-control" id="summernote"
                placeholder="Enter Description" id="editors" style="height:500px;"></textarea>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Add required validation
        $('form').on('submit', function(e) {
            // Check if Summernote content is empty
            var summernoteContent = $('#summernote').summernote('isEmpty');
            if (summernoteContent) {
                alert('Announcement Content is required.');
                e.preventDefault(); // Prevent form submission
                return false;
            }
        });
    });
</script>
{{-- ! End hare --}}



{{-- ########################################################################### --}}
{{-- 17-12-2024 --}}




</html>

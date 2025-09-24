<html lang="en">
{{-- ########################################################################### --}}
{{-- 17-12-2024 closed --}}

@if ($notificationData->duplicate != 0)
    @foreach ($targettypedatas as $key => $targettypedata)
        @if ($targettypedata == 1)
            <span>Individual</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @elseif($targettypedata == 2)
            <span>All Member</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @elseif($targettypedata == 3)
            <span>Partner</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @elseif($targettypedata == 4)
            <span>Manager</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @elseif($targettypedata == 5)
            <span>Staff</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @elseif($targettypedata == 6)
            <span>IT Department</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @elseif($targettypedata == 7)
            <span>Accountant</span>
            @if ($key < count($targettypedatas) - 1)
                ,
            @endif
        @else
            <span>Partner</span>
        @endif
    @endforeach
@else
    @if ($notificationData->targettype == 1)
        <span>Individual</span>
    @elseif($notificationData->targettype == 2)
        <span>All Member</span>
    @else
        <span>Partner</span>
    @endif
@endif



@php
    if ($notificationData->duplicate != 0) {
        $multipletarget = DB::table('notifications')
            ->where('duplicate', 1001)
            // ->where('createdby', auth()->user()->teammember_id)
            // ->orderBy('date', 'asc')
            ->get();

        $targettypedatas = [];
        foreach ($multipletarget as $multipletargetdata) {
            $targettypedatas[] = $multipletargetdata->targettype;
        }

        // foreach ($targettypedatas as $targettypedata) {
        //     dd($targettypedata == 3);
        // }
    }
@endphp


@foreach ($notificationDatas as $notificationData)
    @php
        // if ($notificationData->duplicate != 0) {
        dd($notificationData);
        if ($notificationData->duplicate > 1000) {
            $multipletarget = DB::table('notifications')
                ->where('duplicate', 1001)
                // ->where('createdby', auth()->user()->teammember_id)
                // ->orderBy('date', 'asc')
                ->get();

            $targettypedatas = [];
            foreach ($multipletarget as $multipletargetdata) {
                $targettypedatas[] = $multipletargetdata->targettype;
            }

            // foreach ($targettypedatas as $targettypedata) {
            //     dd($targettypedata == 3);
            // }
        }
    @endphp
    <tr>
        <td style="display: none;">{{ $notificationData->id }}</td>
        <td>
            <a href="{{ url('/notification/' . $notificationData->id) }}"
                style="color: {{ $notificationData->readstatus == 1 ? 'Black' : 'red' }}">
                {{ $notificationData->title }}
            </a>
        </td>
        {{-- <td>{{ date('d-m-Y', strtotime($notificationData->created_at)) }}</td> --}}
        <td>
            <span style="display: none;">
                {{ date('Y-m-d', strtotime($notificationData->created_at)) }}
            </span>
            {{ date('d-m-Y', strtotime($notificationData->created_at)) }}
        </td>
        @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
            <td>
                {{-- @if ($notificationData->targettype == 1)
<span>Individual</span>
@elseif($notificationData->targettype == 2)
<span>All Member</span>
@else
<span>Partner</span>
@endif --}}
                @if ($notificationData->duplicate > 1000)
                    @foreach ($targettypedatas as $key => $targettypedata)
                        @if ($targettypedata == 1)
                            <span>Individual</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @elseif($targettypedata == 2)
                            <span>All Member</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @elseif($targettypedata == 3)
                            <span>Partner</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @elseif($targettypedata == 4)
                            <span>Manager</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @elseif($targettypedata == 5)
                            <span>Staff</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @elseif($targettypedata == 6)
                            <span>IT Department</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @elseif($targettypedata == 7)
                            <span>Accountant</span>
                            @if ($key < count($targettypedatas) - 1)
                                ,
                            @endif
                        @else
                            <span>Partner</span>
                        @endif
                    @endforeach
                @else
                    @if ($notificationData->targettype == 1)
                        <span>Individual</span>
                    @elseif($notificationData->targettype == 2)
                        <span>All Member</span>
                    @elseif($notificationData->targettype == 3)
                        <span>Partner</span>
                    @elseif($notificationData->targettype == 4)
                        <span>Partner</span>
                    @elseif($notificationData->targettype == 5)
                        <span>Partner</span>
                    @elseif($notificationData->targettype == 6)
                        <span>Partner</span>
                    @elseif($notificationData->targettype == 7)
                        <span>All Member</span>
                    @else
                        <span>Partner</span>
                    @endif
                @endif
            </td>
        @endif
    </tr>
@endforeach



<table id="examplee" class="display nowrap">
    <thead>
        <tr>
            <th style="display: none;">id</th>
            <th>Title</th>
            <th>Date</th>
            @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                <th>Target</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($notificationDatas as $notificationData)
            @php
                $multipletarget = DB::table('notifications')->where('duplicate', $notificationData->duplicate)->get();

                $targettypedatas = [];
                foreach ($multipletarget as $multipletargetdata) {
                    $targettypedatas[] = $multipletargetdata->targettype;
                }
            @endphp
            <tr>
                <td style="display: none;">{{ $notificationData->id }}</td>
                <td>
                    <a href="{{ url('/notification/' . $notificationData->id) }}"
                        style="color: {{ $notificationData->readstatus == 1 ? 'Black' : 'red' }}">
                        {{ $notificationData->title }}
                    </a>
                </td>
                <td>
                    <span style="display: none;">
                        {{ date('Y-m-d', strtotime($notificationData->created_at)) }}
                    </span>
                    {{ date('d-m-Y', strtotime($notificationData->created_at)) }}
                </td>
                @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                    <td>
                        @foreach ($targettypedatas as $key => $targettypedata)
                            @if ($targettypedata == 1)
                                <span>Individual</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @elseif($targettypedata == 2)
                                <span>All Member</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @elseif($targettypedata == 3)
                                <span>Partner</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @elseif($targettypedata == 4)
                                <span>Manager</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @elseif($targettypedata == 5)
                                <span>Staff</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @elseif($targettypedata == 6)
                                <span>IT Department</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @elseif($targettypedata == 7)
                                <span>Accountant</span>
                                @if ($key < count($targettypedatas) - 1)
                                    ,
                                @endif
                            @else
                                <span>Partner</span>
                            @endif
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}

{{--  regarding input group / button group --}}
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">Timesheet Access</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Status</span>
            </div>
            @if ($teammember->status == 0)
                <a href="{{ url('/changeteamStatus/' . $teammember->status . '/1/' . $teammember->status) }}"
                    onclick="return confirm('Are you sure you want to Active this teammember?');">
                    <button class="btn btn-danger" data-toggle="modal"
                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                        data-target="#requestModal">Inactive</button>
                </a>
            @else
                <a href="{{ url('/changeteamStatus/' . $teammember->status . '/0/' . $teammember->status) }}"
                    onclick="return confirm('Are you sure you want to Inactive this teammember?');">
                    <button class="btn btn-primary" data-toggle="modal"
                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                        data-target="#requestModal">Active</button>
                </a>
            @endif
        </div>
    </div>
</div>
{{-- public function changeteamStatus($status, $teamid)
{
    try {

        dd($teamid);
        if ($status == 1) {
            DB::table('teammembers')->where('id', $teamid)->update([
                'timesheet_access'         =>  1,
            ]);
        } else {
            DB::table('teammembers')->where('id', $teamid)->update([
                'timesheet_access'         =>  0,
            ]);
        }
        $output = array('msg' => 'Update Successfully');
        return back()->with('success', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        report($e);
        $output = array('msg' => $e->getMessage());
        return back()->withErrors($output)->withInput();
    }
} --}}
{{-- ! End hare --}}

{{-- * regarding if condition  --}}
<style>
    @media (max-width: 768px) {
        .hello {
            background-color: yellow;
            height: 446px;
            width: 364px;
        }

    }

    @media (max-width: 759px) {
        .hello {
            background-color: rgb(207, 14, 146);
            height: 446px;
            width: 364px;
        }

    }

    @media (max-width: 576px) {
        .hello {
            background-color: rgb(38, 255, 0);
            height: 446px;
            width: 364px;
        }

    }
</style>
{{--  Start Hare --}}
{{-- @if (($assignmentbudgetingDatas->status != 0 && $assignmentbudgetingDatas->leadpartner == Auth::user()->teammember_id) || ($assignmentbudgetingDatas->status != 0 && $assignmentbudgetingDatas->otherpartner == Auth::user()->teammember_id)) --}}
@if (
    $assignmentbudgetingDatas->status != 0 &&
        ($assignmentbudgetingDatas->leadpartner == Auth::user()->teammember_id ||
            $assignmentbudgetingDatas->otherpartner == Auth::user()->teammember_id))
    {{--  Start Hare --}}
    <li class="breadcrumb-item">
        <a class="btn btn-info-soft btn-sm" href="{{ url('timesheet/create') }}">
            Add Timesheet
            @if ($timesheetcount < 7)
                <span>for last week</span>
            @endif
        </a>
    </li>
    {{--  Start Hare --}}
    {{-- ! End hare --}}
    {{-- * regarding remove data   --}}
    {{--  Start Hare --}}
    @foreach ($client as $clientData)
        @if ($clientData->client_name !== 'Official Travel')
            <option value="{{ $clientData->id }}"
                {{ $timesheet->client_id == $clientData->id ? 'selected="selected"' : '' }}>
                {{ $clientData->client_name }}
            </option>
        @endif
    @endforeach
    {{--  Start Hare --}}
    @php
        // Filter out the "Official Travel" client from the collection
        $filteredClients = $client->reject(function ($clientData) {
            return $clientData->client_name === 'Official Travel';
        });
    @endphp

    <select class="language form-control" id="teammemberId" name="teammemberId">
        <option value="">Please Select One</option>

        @foreach ($filteredClients as $clientData)
            <option value="{{ $clientData->id }}"
                {{ $timesheet->client_id == $clientData->id ? 'selected="selected"' : '' }}>
                {{ $clientData->client_name }}
            </option>
        @endforeach
    </select>

    {{--  Start Hare --}}
    {{--  Start Hare --}}
    @if (Request::is('timesheet/*/edit'))
        <option disabled>Select Client</option>
    @else
        <option value="">Select Client</option>
    @endif

    @foreach ($client as $clientData)
        @if ($clientData->client_name !== 'Official Travel')
            <option value="{{ $clientData->id }}">
                {{ $clientData->client_name }} ({{ $clientData->client_code }})
            </option>
        @endif
    @endforeach
@endif
{{-- ! End hare --}}
{{-- * regarding css upload / css not effect / remove cache  --}}
{{--  Start Hare --}}
when css not effect on live or local then go to history and clear only cached then refresh it will be efeect now
{{-- ! End hare --}}

{{-- * Regarding date selection / regarding date blocked  --}}
{{--  Start Hare  --}}

{{-- explanation  --}}
{{-- document.addEventListener('DOMContentLoaded', function() {...});

This line ensures that the script runs after the entire HTML document is loaded.
The DOMContentLoaded event is fired when the initial HTML is fully loaded and parsed. This ensures that the script only runs when the page has completely loaded, so that elements like the date input (#enddate) are available to be accessed.
const endDateField = document.getElementById('enddate');

This line selects the End Date input field in the form, which has the ID "enddate".
document.getElementById('enddate'): This function fetches the HTML element with the ID enddate from the page (the input field for the end date).
The input field is stored in the variable endDateField, which allows us to modify it later.
const today = new Date().toISOString().split('T')[0];

This line gets the current date in the YYYY-MM-DD format.
Let’s break it down:

new Date() creates a new JavaScript Date object representing the current date and time.
.toISOString() converts the Date object into a standardized date format, known as ISO format (YYYY-MM-DDTHH:MM:SSZ). It looks something like this: 2024-10-18T10:05:30.000Z.
.split('T') splits the string at the "T" character, resulting in an array: ['2024-10-18', '10:05:30.000Z']. The first part ('2024-10-18') is the date.
[0] selects the first part of the array, which is the date ('2024-10-18').
So, today will store the current date as 2024-10-18 (or whatever today's date is).
endDateField.setAttribute('max', today);

This line sets the max attribute of the End Date input field to today’s date (today variable).
setAttribute('max', today): This tells the browser that the End Date input field should not accept any dates after the current date (today). The max attribute restricts the maximum allowable value for the date field. --}}
<div class="col-md-3 col-sm-6 mb-3">
    <div class="form-group">
        <strong><label for="enddate">End Date <span class="text-danger">*</span></label></strong>
        <input required type="date" class="form-control" id="enddate" name="enddate" value="{{ old('enddate') }}">
    </div>
</div>

<!-- JavaScript to set the max date for end date -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const endDateField = document.getElementById('enddate');
        const today = new Date().toISOString().split('T')[0];
        endDateField.setAttribute('max', today);
    });
</script>


<!-- JavaScript to set the max date for end date -->
{{-- <script>
      document.addEventListener('DOMContentLoaded', function() {
          const endDateField = document.getElementById('enddate');
          const today = new Date().toISOString().split('T')[0];
          endDateField.setAttribute('max', today);
      });
  </script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0]; // Get today's date once

        // Set max date for the Start Date field
        const startdateField = document.getElementById('startdate');
        startdateField.setAttribute('max', today);

        // Set max date for the End Date field
        const endDateField = document.getElementById('enddate');
        endDateField.setAttribute('max', today);
    });
</script>


{{-- * regarding span tag  --}}
{{--  Start Hare --}}
<td style="align-content: center;">
    @if ($applyleaveDatas->status == 0)
        <button data-toggle="modal" data-target="#exampleModal12{{ $loop->index }}" class="btn btn-danger"
            style="border-radius: 7px; font-size: 10px; padding: 5px;">
            Reject</button>
    @else
        {{-- <p style="text-align: center;">N/A</p> --}}
        {{-- <span style="display: block; text-align: center;">N/A</span> --}}
        <span style="display: inline-block; width: 100%; text-align: center;">N/A</span>
        <span style="display: inline-block; width: 70%; text-align: center;">N/A</span>
    @endif
</td>
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding date validation  --}}
{{--  Start Hare --}}
<form method="POST" action="{{ url('/filtering-applyleve') }}" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <!-- Employee Dropdown -->
        <div class="col-3">
            <div class="form-group">
                <strong><label for="employee">Employee</label></strong>
                <select class="form-control" id="employee1" name="employee">
                    <option value="">Please Select One</option>
                    @php $displayedValues = []; @endphp
                    @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                        @if (!in_array($applyleaveDatas->emailid, $displayedValues))
                            <option value="{{ $applyleaveDatas->createdby }}"
                                {{ old('employee') == $applyleaveDatas->createdby ? 'selected' : '' }}>
                                {{ $applyleaveDatas->team_member }}
                                ({{ $applyleaveDatas->newstaff_code ?? ($applyleaveDatas->staffcode ?? '') }})
                            </option>
                            @php $displayedValues[] = $applyleaveDatas->emailid; @endphp
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Leave Type Dropdown -->
        <div class="col-3">
            <div class="form-group">
                <strong><label for="leave">Leave Type</label></strong>
                <select class="form-control" id="leave1" name="leave">
                    <option value="">Please Select One</option>
                    @php $displayedValues = []; @endphp
                    @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                        @if (!in_array($applyleaveDatas->name, $displayedValues))
                            <option value="{{ $applyleaveDatas->leavetype }}"
                                {{ old('leave') == $applyleaveDatas->leavetype ? 'selected' : '' }}>
                                {{ $applyleaveDatas->name }}
                            </option>
                            @php $displayedValues[] = $applyleaveDatas->name; @endphp
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Status Dropdown -->
        <div class="col-3">
            <div class="form-group">
                <strong><label for="status">Status</label></strong>
                <select class="form-control" id="status1" name="status">
                    <option value="">Please Select One</option>
                    @php $displayedValues = []; @endphp
                    @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                        @if (!in_array($applyleaveDatas->status, $displayedValues))
                            <option value="{{ $applyleaveDatas->status }}">
                                {{ $applyleaveDatas->status == 0 ? 'Created' : ($applyleaveDatas->status == 1 ? 'Approved' : 'Rejected') }}
                            </option>
                            @php $displayedValues[] = $applyleaveDatas->status; @endphp
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Request Date Range -->
        <div class="col-3">
            <div class="form-group">
                <strong><label for="start">Start Request Date</label></strong>
                <input type="date" class="form-control" id="start1" name="start" value="{{ old('start') }}">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <strong><label for="end">End Request Date</label></strong>
                <input type="date" class="form-control" id="end1" name="end"
                    value="{{ old('end') }}">
            </div>
        </div>

        <div class="col-3">
            <div class="form-group">
                <strong><label for="startperiod">Start Leave Period</label></strong>
                <input type="date" class="form-control" id="startperiod1" name="startperiod"
                    value="{{ old('startperiod') }}">
            </div>
        </div>

        <div class="col-4">
            <div class="form-group">
                <strong><label for="endperiod">End Leave Period</label></strong>
                <input type="date" class="form-control" id="endperiod1" name="endperiod"
                    value="{{ old('endperiod') }}">
            </div>
        </div>

        <!-- Search Button -->
        <div class="col-md-2 col-sm-6 mb-3">
            <div class="form-group">
                <label>&nbsp;</label>
                <button type="submit" class="btn btn-success btn-block">Search</button>
            </div>
        </div>
    </div>
</form>


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

        $('form').submit(function(event) {
            var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                '#endperiod1'
            ];
            var allEmpty = fields.every(function(selector) {
                return $(selector).val() === "";
            });

            if (allEmpty) {
                alert("Please select any input");
                event.preventDefault(); // Prevent form submission if all fields are empty
            }
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
                    endDateInput.val(''); // Clear the end date input
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
    });
</script>


<script>
    $(document).ready(function() {
        // Function to validate date range
        function validateDateRange(startSelector, endSelector, errorMessage) {
            var startDateInput = $(startSelector);
            var endDateInput = $(endSelector);

            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert(errorMessage);
                    endDateInput.val(''); // Clear the end date input
                }
            }

            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);
        }

        // Function to validate year input
        function validateYearInput(inputSelector) {
            $(inputSelector).on('change', function() {
                var input = $(this);
                var year = new Date(input.val()).getFullYear();
                if (year.toString().length > 4) {
                    alert('Enter four digits for the year');
                    input.val(''); // Clear the invalid year input
                }
            });
        }

        // Apply date range validation
        validateDateRange('#start1', '#end1',
            "'End Request Date' should be greater than or equal to the 'Start Request Date'");
        validateDateRange('#startperiod1', '#endperiod1',
            "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

        // Apply year validation for all date inputs
        ['#start1', '#end1', '#startperiod1', '#endperiod1'].forEach(validateYearInput);

        // Form submit validation
        $('form').submit(function(event) {
            var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                '#endperiod1'
            ];
            var allEmpty = fields.every(function(selector) {
                return $(selector).val() === "";
            });

            if (allEmpty) {
                alert("Please select any input");
                event.preventDefault(); // Prevent form submission if all fields are empty
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            var employee = $('#employee1').val();
            var leave = $('#leave1').val();
            var status = $('#status1').val();
            var startDate = $('#start1').val();
            var endDate = $('#end1').val();
            var startPeriod = $('#startperiod1').val();
            var endPeriod = $('#endperiod1').val();

            if (employee === "" && leave === "" && status === "" && startDate === "" && endDate ===
                "" &&
                startPeriod === "" && endPeriod === "") {
                alert("Please select Any input ");
                event.preventDefault();
                return;
            }
        });
    });
</script>
{{--  Start Hare --}}


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
{{--  Start Hare --}}
{{-- ! End hare   --}}
{{-- * regarding php in htam   --}}
{{--  Start Hare --}}
<div class="modal-body">
    <div class="details-form-field form-group row">
        <div class="col-{{ $assignmentbudgetingDatas->status == 1 ? '6' : '12' }}">
            <div class="form-group">
                <label class="font-weight-600">Name</label>
                <select class="language form-control" id="exampleFormControlSelect1" name="teammember_id">
                    <option value="">Please Select One</option>
                    @foreach ($teammemberall as $teammemberData)
                        <option value="{{ $teammemberData->id }}">
                            {{ $teammemberData->team_member }}
                            ({{ $teammemberData->staffcode }})
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="assignmentmapping_id" value="{{ $assignmentbudgetingDatas->id }}"
                    class="form-control">
            </div>
        </div>

        @if ($assignmentbudgetingDatas->status == 1)
            <div class="col-5">
                <div class="form-group">
                    <label class="font-weight-600">Type</label>
                    <select class="form-control key" id="key" name="type">
                        <option value="">Please Select One</option>
                        <option value="0">Team Leader</option>
                        <option value="2">Staff</option>
                    </select>
                </div>
            </div>
        @else
            <input type="hidden" name="type" value="2" class="form-control">
        @endif
    </div>
</div>
{{--  Start Hare --}}

{{--  Start Hare --}}
{{-- * regarding html convert to laravel  --}}
{{--  Start Hare --}}

{{-- convert html to laravel --}}

{{-- resources\views\web\pages\portfolio-details.html --}}
{{-- resources\views\web\pages\portfolio-details.blade.php --}}

<a href="portfolio-details.html " title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>

<a href="portfolio-details.blade.php" title="More Details" class="details-link"><i class="bi bi-link-45deg"></i></a>


Route::get('/portfolio-details', function () {
return view('web.pages.portfolio-details');
});

<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('vendor/aos/aos.js') }}"></script>
<script src="{{ asset('vendor/typed.js/typed.umd.js') }}"></script>
<script src="{{ asset('vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('vendor/waypoints/noframework.waypoints.js') }}"></script>
<script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>


<!-- Main JS File -->
<script src="{{ asset('js/main.js') }}"></script>



<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - iPortfolio Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('img/favicon.png') }}" rel="icon">
    <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    {{-- bootstrap icon --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: iPortfolio
  * Template URL: https://bootstrapmade.com/iportfolio-bootstrap-portfolio-websites-template/
  * Updated: Jun 29 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<img src="{{ asset('img/hero-bg.jpg') }}" alt="" data-aos="fade-in" class="">

Route::get('/portfolio-details', function () {
return view('web.pages.portfolio-details');
});
Route::get('/index-page', function () {
return view('web.pages.index');
});
Route::get('/service-details', function () {
return view('web.pages.service-details');
});
Route::get('/starter-page', function () {
return view('web.pages.starter-page');
});
{{-- convert html to laravel end --}}
{{--  Start Hare --}}
{{-- * regarding splite function  --}}
{{--  Start Hare --}}
Scenario:
You have an id attribute value like "saveform-44".

Breakdown of split('-'):
$(this).attr('id'):

This gets the id attribute of the current element, so in this case, it returns the string "saveform-44".
.split('-'):

The split('-') method takes the string "saveform-44" and splits it into an array based on the hyphen (-) delimiter.
The result of this operation is ["saveform", "44"]. This is an array with two elements:
Index 0: "saveform"
Index 1: "44"
[1]:

The [1] accesses the second element of the array, which is "44".
Summary:
split('-')[0] would give you "saveform".
split('-')[1] gives you "44".
{{--  Start Hare --}}
{{-- * regarding approve and reject button   --}}
{{--  Start Hare --}}
@if ($hasPendingRequests)
    <td>
        @if ($timesheetrequestsDatass->status == 0)
            <form method="post" action="{{ route('examleaveapprove', $timesheetrequestsDatass->id) }}"
                enctype="multipart/form-data" style="text-align: center;">
                @method('PATCH')
                @csrf
                <button type="submit" class="btn btn-success"
                    style="border-radius: 7px; font-size: 10px; padding: 5px;">
                    Approve</button>
                <input type="text" hidden id="example-date-input" name="status" value="1"
                    class="form-control">

                <input type="hidden" name="leavetype" value="{{ $timesheetrequestsDatass->leavetype }}"
                    class="form-control" placeholder="">
            </form>
        @endif
    </td>
    <td>
        @if ($timesheetrequestsDatass->status == 0)
            <form method="post" action="{{ route('examleaveapprove', $timesheetrequestsDatass->id) }}"
                enctype="multipart/form-data" style="text-align: center;">
                @method('PATCH')
                @csrf
                <button style="border-radius: 7px; font-size: 10px; padding: 5px;" type="submit"
                    class="btn btn-danger">
                    Reject</button>
                <input hidden type="text" id="example-date-input" name="status" value="2"
                    class="form-control" placeholder="Enter Location">
            </form>
        @endif
    </td>
@endif
{{--  Start Hare --}}
{{-- * regarding check box   --}}
{{--  Start Hare --}}


222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222222

<div class="col-6">
    <div class="form-group">
        <label class="font-weight-600">Name *</label>
        <input type="checkbox" data-toggle="tooltip" id="enablebox" style="margin-left: 10px;"
            title="You want to submit without teammember, please click on check box">
        <select required class="language form-control enablefalse" id="key" name="teammember_id[]">
            <option value="">Please Select One</option>
            @foreach ($teammember as $teammemberData)
                <option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->role->rolename }} ) (
                    {{ $teammemberData->staffcode }} )</option>
            @endforeach
        </select>
    </div>
</div>


<div class="col-5">
    <div class="form-group">
        <label class="font-weight-600">Type *</label>
        <select required class="form-control key enablefalse" id="key" name="type[]">
            <option value="">Please Select One</option>
            <option value="0">Team Leader</option>
            <option value="2">Staff</option>
        </select>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#enablebox').on('change', function() {
            alert('hi');
            $('.enablefalse').prop('disabled', !this.checked);
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#enablebox').on('change', function() {
            // This will disable the dropdown when the checkbox is checked and enable it when unchecked
            $('.enablefalse').prop('disabled', this.checked);
        });
    });
</script>
{{--  Start Hare --}}
{{-- * regarding are you sure  --}}
{{--  Start Hare --}}

<button type="submit" style="float: right" class="btn btn-success" id="saveform">Save
</button>

<script>
    $(document).ready(function() {
        $('#saveform').click(function(event) {
            var reasoninputvalve = $('#reasoninput').val().trim();

            if (reasoninputvalve === "") {
                alert('Please enter a reason. It is mandatory.');
                event.preventDefault();
                return false;
            }

            // Confirmation prompt
            var confirmSubmit = confirm('Are you sure you want to submit ?');
            if (!confirmSubmit) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
{{--  Start Hare --}}
{{-- * regarding long text / long text / substr function /regarding tooltip --}}
{{--  costmize tooltip --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tooltip Example</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tooltip-inner {
            background-color: #000 !important;
            /* Tooltip background color */
            color: #fff !important;
            /* Tooltip text color */
            font-size: 14px;
            max-width: 200px;
            /* Tooltip width */
            text-align: center;
        }

        .tooltip.show {
            opacity: 1 !important;
            /* Ensures tooltip visibility */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
            title="This is a tooltip!">
            Hover Me
        </button>
    </div>

    <script>
        $(document).ready(function() {
            // Initialize Bootstrap Tooltip
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

</body>

</html>


{{--  Start Hare --}}

<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 25)
        span < id="reasonleave-{{ $applyleaveDatas->id }}" class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}...
            {{-- <i class="far fa-eye" data-toggle="tooltip"
                title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')"></i> --}}
            <span style="color: #37A000; cursor: pointer;" data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')">View
                Detail</span>
        </>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>
<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 25)
        <span id="reasonleave-{{ $applyleaveDatas->id }}" class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}...
            <i class="far fa-eye" data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')"></i>
        </span>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>

<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 30)
        <span id="reasonleave-{{ $applyleaveDatas->id }}" class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 30) }}...
            <i class="far fa-eye" data-toggle="tooltip" title="Show full text"
                onclick="showFullText('{{ $applyleaveDatas->reasonleave }}')"></i>
        </span>
    @else
        {{ $applyleaveDatas->reasonleave }}
    @endif
</td>

<!-- Modal HTML Template -->
<div class="modal fade" id="fullTextModal" tabindex="-1" role="dialog" aria-labelledby="fullTextModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fullTextModalLabel">Full Text
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



{{--  Start Hare --}}






<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 25)
        <span class="reasonleave-truncated" data-toggle="tooltip" title="{{ $applyleaveDatas->reasonleave }}">
            {{ substr($applyleaveDatas->reasonleave, 0, 25) }}...
        </span>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>

<td class="textfixed">
    @if (strlen($applyleaveDatas->reasonleave) > 30)
        <span class="reasonleave-truncated" data-toggle="tooltip" title="{{ $applyleaveDatas->reasonleave }}">
            {{ substr($applyleaveDatas->reasonleave, 0, 30) }}...
        </span>
    @else
        {{ $applyleaveDatas->reasonleave ?? '' }}
    @endif
</td>

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
{{--  Start Hare --}}

<td class="textfixed" title="Show full text">
    @if (strlen($applyleaveDatas->reasonleave) > 30)
        <span id="reasonleave-{{ $applyleaveDatas->id }}" class="reasonleave-truncated">
            {{ substr($applyleaveDatas->reasonleave, 0, 30) }}...
            <i class="far fa-eye" data-toggle="tooltip" title="Show full text"
                onclick="toggleFullText({{ $applyleaveDatas->id }})"></i>
        </span>
        <span id="reasonleave-full-{{ $applyleaveDatas->id }}" class="reasonleave-full" style="display:none;">
            {{ $applyleaveDatas->reasonleave }}
        </span>
    @else
        {{ $applyleaveDatas->reasonleave }}
    @endif
</td>



<script>
    function toggleFullText(id) {
        var truncatedText = document.getElementById('reasonleave-' + id);
        var fullText = document.getElementById('reasonleave-full-' + id);

        if (truncatedText.style.display === 'none') {
            truncatedText.style.display = 'inline';
            fullText.style.display = 'none';
        } else {
            truncatedText.style.display = 'none';
            fullText.style.display = 'inline';
        }
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

    .reasonleave-full {
        display: none;
    }

    .textfixed {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>


{{--  Start Hare --}}
{{-- * regarding data table / regarding datatable  --}}
{{--  Start Hare --}}
{{-- add this code on top of page  --}}
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">





{{-- add this code on end  of page  --}}
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
            "pageLength": 10,
            "dom": '1Bfrtip',
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>

<script>
    $(document).ready(function() {
        $('#teamexamplee').DataTable({
            "pageLength": 10,
            "dom": '1Bfrtip',
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>
{{--  Start Hare --}}
//*regarding date formate
// Start Hare
date('d-M-Y', strtotime($udinData->udindate))
{{-- * regarding timesheet request  --}}
{{--  Start Hare --}}
@foreach ($timesheetrequestsDatas as $timesheetrequestsData)
    <tr>
        @php
            if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13) {
                $permotioncheck = DB::table('teamrolehistory')
                    ->where('teammember_id', $timesheetrequestsData->createdby)
                    ->first();

                $datadate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timesheetrequestsData->created_at);

                $permotiondate = null;
                if ($permotioncheck) {
                    $permotiondate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $permotioncheck->created_at);
                }
            }

            $partnerpormotioncheck = DB::table('teamrolehistory')
                ->where('teammember_id', $timesheetrequestsData->partner)
                ->first();

            $partnerdatadate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timesheetrequestsData->created_at);

            $partnerpormotiondateformate = null;
            if ($partnerpormotioncheck) {
                $partnerpormotiondateformate = Carbon\Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $partnerpormotioncheck->created_at,
                );
            }

        @endphp
        <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
        <td>
            @if ($timesheetrequestsData->status == 0)
                <span class="badge badge-pill badge-warning">Created</span>
            @elseif($timesheetrequestsData->status == 1)
                <span class="badge badge-pill badge-success">Approved</span>
            @else
                <span class="badge badge-pill badge-danger">Rejected</span>
            @endif
        </td>
        <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>
        <td>{{ date('h:m:s', strtotime($timesheetrequestsData->created_at)) }}</td>
        <td><a href="{{ url('timesheetrequest/view', $timesheetrequestsData->id) }}">
                {{ $timesheetrequestsData->createdbyauth }}</a></td>

        @if (auth()->user()->role_id == 11 || auth()->user()->role_id == 13)
            @if ($permotioncheck && $datadate->greaterThan($permotiondate))
                <td>{{ $permotioncheck->newstaff_code }}</td>
            @else
                <td>{{ $timesheetrequestsData->staffcodeid }}</td>
            @endif
        @else
            <td>{{ $timesheetrequestsData->newstaff_code ?? $timesheetrequestsData->staffcodeid }}
            </td>
        @endif
        <td>{{ $timesheetrequestsData->team_member }}
        </td>
        {{-- <td>
        {{ $timesheetrequestsData->staffcode }}
    </td> --}}

        @if ($partnerpormotioncheck && $partnerdatadate->greaterThan($partnerpormotiondateformate))
            <td>{{ $partnerpormotioncheck->newstaff_code }}</td>
        @else
            <td>{{ $timesheetrequestsData->staffcode }}</td>
        @endif

        <td style="width: 900px; word-wrap: break-word; white-space: normal;">
            {{ $timesheetrequestsData->reason }}</td>
        <td>
            @if ($timesheetrequestsData && $timesheetrequestsData->attachment)
                <a href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}">
                    {{ $timesheetrequestsData->attachment ?? 'NA' }}
                </a>
            @else
                {{ 'NA' }}
            @endif
        </td>
        <td>{{ $timesheetrequestsData->remark ?? 'NA' }}</td>

    </tr>
@endforeach
{{--  Start Hare --}}
{{-- * regarding title    --}}
{{--  Start Hare --}}
<td style="width: 900px; word-wrap: break-word; white-space: normal;" title="{{ $timesheetrequestsData->reason }}">
    {{ $timesheetrequestsData->reason }}
</td>
{{--  Start Hare --}}
{{-- * regarding check box   --}}
{{--  Start Hare --}}
<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Designation</label>
        <input type="checkbox" id="enableDesignation" style="margin-left: 10px;"
            title="You want to change designation then please click on check box">
        <select required class="language form-control" name="designationtype" id="designationSelect" disabled>
            <option value="">Please Select One</option>
            @foreach ($teamroles as $teamrole)
                <option value="{{ $teamrole->id }}">
                    {{ $teamrole->rolename }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#enableDesignation').on('change', function() {
            $('#designationSelect').prop('disabled', !this.checked);
        });
    });
</script>
{{--  Start Hare --}}
{{-- * regarding data filter in table / regarding table / regarding filter in table    --}}
{{--  Start Hare --}}
<table class="table display table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Name</th>
            <th>Staff Code</th>
            <th>Role</th>
            <th>Mobile No</th>
            <th>Total Hour</th>
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
            @if ($teammemberData->viewerteam == 1)
                @php
                    $hasData = true;
                @endphp
                <tr>
                    <td>{{ $teammemberData->title }}
                        {{ $teammemberData->team_member }}</td>
                    <td>{{ $teammemberData->staffcode }}</td>
                    <td>
                        @if ($teammemberData->type == 0)
                            <span>Team Leader</span>
                        @else
                            <span>Staff</span>
                        @endif
                    </td>
                    <td>
                        <a href="tel:={{ $teammemberData->mobile_no }}">{{ $teammemberData->mobile_no }}</a>
                    </td>
                    <td>{{ $teammemberData->teamhour ?? 0 }}</td>
                    <td>{{ App\Models\Teammember::select('team_member')->where('id', $teammemberData->leadpartner)->first()->team_member ?? '' }}
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
{{--  Start Hare --}}
{{-- * regarding null   --}}
{{--  Start Hare --}}
@if ($permotiondate && $datadate->greaterThan($permotiondate))
    <td>{{ $permotioncheck->newstaff_code }}</td>
@else
    <td>{{ $jobDatas->staffcode }}</td>
@endif
@php
    $permotioncheck = DB::table('teamrolehistory')
        ->where('teammember_id', auth()->user()->teammember_id)
        ->first();

    $datadate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timesheetrequestsData->created_at);
    $permotiondate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $permotioncheck->created_at);
@endphp

@if ($permotiondate && $datadate->greaterThan($permotiondate))
    <td>{{ $timesheetrequestsData->newstaff_code }}</td>
@else
    <td>{{ $timesheetrequestsData->teamstaffcode }}</td>
@endif
{{--  Start Hare --}}

@php
    $permotioncheck = DB::table('teamrolehistory')
        ->where('teammember_id', auth()->user()->teammember_id)
        ->first();

    $datadate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timesheetrequestsData->created_at);
    $permotiondate = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $permotioncheck->created_at);

    // if ($permotiondate->greaterThan($datadate)) {
    //     dd($datadate);
    // }
    // dd($permotiondate);

@endphp
@php
    $permotioncheck = null;
    $datadate = $timesheetDatas->assignmentcreated
        ? Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timesheetDatas->assignmentcreated)
        : null;
    $permotiondate = null;

@endphp
@if ($permotiondate && $permotiondate->greaterThan($datadate))
    <td>{{ $timesheetrequestsData->teamstaffcode }}</td>
@else
    <td>{{ $timesheetrequestsData->newstaff_code }}</td>
@endif
{{--  Start Hare --}}


@php
    $rejectedtimesheetformate = null;
    if ($rejectedtimesheet) {
        $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
    }

    if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {
        $skipaftertrue = true;
    } else {
        $output = ['msg' => 'You cannot apply leave before Submitted timesheet date'];
        return back()->with('statuss', $output);
    }
@endphp
{{--  Start Hare --}}
{{-- * regarding file download   --}}
{{--  Start Hare --}}

@php
    Route::get('download/{filename}', [YourController::class, 'downloadFile'])->name('download.file');
    use Illuminate\Support\Facades\Response;
    use Illuminate\Support\Facades\Storage;

    class YourController extends Controller
    {
        public function downloadFile($filename)
        {
            $path = storage_path('app/backEnd/image/confirmationfile/' . $filename);

            if (!file_exists($path)) {
                abort(404);
            }

            return response()->download($path);
        }
    }

@endphp
<td>
    <a href="{{ route('download.file', ['filename' => $timesheetrequestsData->attachment]) }}">
        {{ $timesheetrequestsData->attachment ?? 'NA' }}
    </a>
</td>

<td>
    <a href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}" target="_blank">
        {{ $timesheetrequestsData->attachment ?? 'NA' }}
    </a>
</td>

{{--  Start Hare --}}

{{--  Start Hare --}}
{{-- * regarding file upload / file    --}}
{{--  Start Hare --}}
@php
    $fileName = '';
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        // public\backEnd\image\confirmationfile
        $destinationPath = 'backEnd/image/confirmationfile';
        $fileName = $file->getClientOriginalName();
        $file->move($destinationPath, $fileName);
    }

    DB::table('debtorconfirmations')->insert([
        'debtor_id' => $request->debitid,
        'assignmentgenerate_id' => $request->assignmentgenerate_id,
        'remark' => null,
        'amount' => null,
        'file' => $fileName,
        'name' => $debtorconfirm->name,
        'created_at' => date('Y-m-d'),
        'updated_at' => date('Y-m-d'),
    ]);
@endphp
<script>
    document.getElementById('file-1').addEventListener('change', function() {
        alert('hi');
        var fileLabel = document.getElementById('file-label').querySelector('span');
        if (this.files.length > 0) {
            fileLabel.textContent = this.files[0].name;
        } else {
            fileLabel.textContent = "Choose a file…";
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('file-1').addEventListener('change', function() {
            alert('hi');
            var fileLabel = document.getElementById('file-label').querySelector('span');
            if (this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
            } else {
                fileLabel.textContent = "Choose a file…";
            }
        });
    });
</script>

<div class="modal fade" id="exampleModal21" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="detailsForm" method="post" action="{{ url('timesheetrequest/store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #37A000">
                    <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add Request
                    </h5>
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
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Admin :</label>
                        <div class="col-sm-9">
                            <select class="language form-control" required id="category" name="partner">
                                <option value="">Please Select One</option>
                                @foreach ($partner as $teammemberData)
                                    <option value="{{ $teammemberData->id }}">
                                        {{ $teammemberData->team_member }}</option>
                                @endforeach
                            </select>

                        </div>

                    </div>
                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Reason :</label>
                        <div class="col-sm-9">
                            <textarea rows="4" name="reason" required class="form-control" placeholder="Enter Reason"></textarea>

                        </div>

                    </div>

                    <div class="details-form-field form-group row">
                        <label for="name" class="col-sm-3 col-form-label font-weight-600">Attachment File
                            :</label>
                        <div class="col-sm-9">
                            <input type="file" name="file" id="file-1" class="custom-input-file">
                            <label for="file-1" id="file-label">
                                <i class="fa fa-upload"></i>
                                <span>Choose a file…</span>
                            </label>
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
{{--  Start Hare --}}
{{-- * regarding null value  --}}
{{--  Start Hare --}}
@php
    $leadpartner = App\Models\Teammember::select('team_member', 'staffcode')
        ->where('id', $assignmentmappingDatas->leadpartner)
        ->first();

    $otherPartner = App\Models\Teammember::select('team_member', 'staffcode')
        ->where('id', $assignmentmappingDatas->otherpartner)
        ->first();
@endphp
<td>
    {{ $leadpartner->team_member ?? '' }}
    @if ($leadpartner && $leadpartner->team_member)
        ({{ $leadpartner->staffcode ?? '' }})
    @endif
</td>
<td>
    {{ $otherPartner->team_member ?? '' }}
    @if ($otherPartner && $otherPartner->team_member)
        ({{ $otherPartner->staffcode ?? '' }})
    @endif
</td>
{{--  Start Hare --}}
<td>
    @if ($timesheetrequestsData && $timesheetrequestsData->attachment)
        <a href="{{ url('backEnd/image/confirmationfile/' . $timesheetrequestsData->attachment) }}">
            {{ $timesheetrequestsData->attachment ?? 'NA' }}
        </a>
    @else
        {{ 'NA' }}
    @endif
</td>
{{--  Start Hare --}}
@php
    $rejectedtimesheetformate = null;
    if ($rejectedtimesheet) {
        $rejectedtimesheetformate = Carbon::createFromFormat('Y-m-d', $rejectedtimesheet->date);
    }

    if ($rejectedtimesheetformate && $rejectedtimesheetformate->isSameDay($from)) {
        $skipaftertrue = true;
    } else {
        $output = ['msg' => 'You cannot apply leave before Submitted timesheet date'];
        return back()->with('statuss', $output);
    }
@endphp
{{--  Start Hare --}}
{{-- * handle error / null value   --}}
{{--  Start Hare --}}
@if ($timesheetrejectData && $timesheetrejectData->status == 2)
    <div class="text-center">
        <p class="text-danger font-weight-bold">Please submit the rejected timesheet</p>
    </div>
@endif
{{--  Start Hare --}}
{{-- *   --}}
{{--  Start Hare --}}
<td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingcloseDatas->leadpartner)->first()->team_member ?? '' }}
</td>
<td>{{ App\Models\Teammember::select('team_member')->where('id', $assignmentmappingcloseDatas->otherpartner)->first()->team_member ?? '' }}
</td>
@php
    $leadpartnercloseed = App\Models\Teammember::select('team_member', 'staffcode')
        ->where('id', $assignmentmappingcloseDatas->leadpartner)
        ->first();

    $otherPartnerclosed = App\Models\Teammember::select('team_member', 'staffcode')
        ->where('id', $assignmentmappingcloseDatas->otherpartner)
        ->first();
@endphp

<td>
    {{ $leadpartnercloseed->team_member ?? '' }}
    @if ($leadpartnercloseed && $leadpartnercloseed->team_member)
        ({{ $leadpartnercloseed->staffcode ?? '' }})
    @endif
</td>
<td>
    {{ $otherPartnerclosed->team_member ?? '' }}
    @if ($otherPartnerclosed && $otherPartnerclosed->team_member)
        ({{ $otherPartnerclosed->staffcode ?? '' }})
    @endif
</td>
{{--  Start Hare --}}
{{-- * regarding td tag / regarding column --}}
{{--  Start Hare --}}
      <style>
          table {
              table-layout: fixed;
              width: 100%;
          }
          
      </style>
      <style>
    .textfixed {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
 <table id="example{{ $loop->iteration }}"
     class="table display table-bordered table-striped table-hover">

     @foreach ($designationData[$roleKey]['headings'] as $heading)
         <th class="textfixed" style="width: 361.094px;">
             {{ ucwords(str_replace('_', ' ', $heading)) }}</th>
     @endforeach

{{--  Start Hare --}}
<td style="width: 900px; word-wrap: break-word; white-space: normal;">
    {{ $timesheetrequestsData->reason }}</td>
{{--  Start Hare --}}
{{-- text dont cut hare  --}}
<style>
    .no-wrap {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
<th class="no-wrap">Client Code</th>
<th class="no-wrap">Deadline</th>
{{--  Start Hare --}}
<style>
    .columsize {
        white-space: normal !important;
        width: 900px;
    }
</style>
<td class="columsize">{{ $timesheetrequestsData->reason }}</td>
{{--  Start Hare --}}
{{-- * regarding zip file / regarding zip file download /regarding zip download  --}}
{{--  Start Hare --}}

@php
    // Start Hare
    // public function zipfile(Request $request, $assignmentfolder_id)
    // {
    if (auth()->user()->role_id == 11) {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();

        $zipFileName = $generateid->assignmentfoldersname . '.zip';

        $zip = new ZipArchive();

        $zip->open($zipFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        foreach ($fileName as $file) {
            // $filePath = Storage::disk('s3')->url($generateid->assignmentgenerateid . '/' . $file->filesname);
            $filePath = storage_path('app/public/image/task/' . $file->filesname);

            $stream = fopen($filePath, 'r');

            if ($stream) {
                $zip->addFile($stream, $file->filesname);
                fclose($stream);
            } else {
                return '<h1>File Not Found</h1>';
            }
        }

        $zip->close();

        $headers = [
            'Content-Type' => 'application/zip',
            'Content-Disposition' => 'attachment; filename="' . $zipFileName . '"',
        ];

        // Delete the local zip file after sending
        return response()->stream(
            function () use ($zipFileName) {
                readfile($zipFileName);
                unlink($zipFileName);
            },
            200,
            $headers,
        );
    } else {
        $generateid = DB::table('assignmentfolders')->where('id', $assignmentfolder_id)->first();
        $fileName = DB::table('assignmentfolderfiles')->where('assignmentfolder_id', $assignmentfolder_id)->get();
        //dd($fileName);

        $zipFileName = $generateid->assignmentfoldersname . '.zip';
        $zip = new ZipArchive();

        if ($zip->open($zipFileName, ZipArchive::CREATE) === true) {
            foreach ($fileName as $file) {
                // Replace storage_path with S3 access method
                // $filePath = Storage::disk('s3')->get($generateid->assignmentgenerateid . '/' . $file->filesname);
                $filePath = storage_path('app/public/image/task/' . $file->filesname);

                if ($filePath) {
                    $zip->addFromString($file->filesname, $filePath);
                } else {
                    return '<h1>File Not Found</h1>';
                }
            }

            $zip->close();
        }

        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
    // }

    // Start Hare
    // public function store(Request $request)
    // {
    //dd($request);
    $request->validate([
        'particular' => 'required',
        'file' => 'required',
    ]);

    try {
        $data = $request->except(['_token']);
        $files = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $realname = $file->getClientOriginalName();
                $name = time() . $realname;
                $path = $file->storeAs('public\image\task', $name);
                $files[] = [
                    'name' => $name,
                    'realname' => $realname,
                    'size' => round($file->getSize() / 1024, 2),
                ];
            }
        }
        foreach ($files as $filess) {
            // dd($files); die;
            $s = DB::table('assignmentfolderfiles')->insert([
                'particular' => $request->particular,
                'assignmentgenerateid' => $request->assignmentgenerateid,
                'assignmentfolder_id' => $request->assignmentfolder_id,
                'createdby' => auth()->user()->teammember_id,
                'filesname' => $filess['name'],
                'realname' => $filess['realname'],
                'filesize' => $filess['size'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
        //dd($data);
        $output = ['msg' => 'Submit Successfully'];
        return back()->with('success', $output);
    } catch (Exception $e) {
        DB::rollBack();
        Log::emergency('File:' . $e->getFile() . 'Line:' . $e->getLine() . 'Message:' . $e->getMessage());
        report($e);
        $output = ['msg' => $e->getMessage()];
        return back()->withErrors($output)->withInput();
    }
    // }
@endphp

{{--  Start Hare --}}
{{-- local --}}
{{-- public\storage\image\task\  yaha file ko copy karke rakhe --}}
<td>
    <a target="_blank" href="{{ asset('storage/image/task/' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->realname ?? '' }}
    </a>
</td>
{{-- <td>
    <a target="_blank"
        href="{{ asset('public\image\task' . $assignmentfolderData->filesname) }}">
        {{ $assignmentfolderData->realname ?? '' }}
    </a>
</td> --}}
{{-- <td><a target="blank"
        href="{{ Storage::disk('s3')->temporaryUrl($foldername->assignmentgenerateid . '/' . $assignmentfolderData->filesname, now()->addMinutes(30)) }}">
        {{ $assignmentfolderData->realname ?? '' }}</a></td> --}}
{{--  Start Hare --}}

{{-- * are you sure   --}}
{{--  Start Hare --}}
@if ($clientdebitdata->mailstatus == 0)
    <a href="{{ url('/entries/destroy/' . $clientdebitdata->id) }}"
        onclick="return confirm('Are you sure you want to delete this confirmation task?\nName: {{ $clientdebitdata->name }}\nEmail: {{ $clientdebitdata->email }}');"
        class="btn btn-danger-soft btn-sm hide-on-closed">
        <i class="far fa-trash-alt"></i>
    </a>
@endif
{{--  Start Hare --}}
{{-- * regarding data from table    --}}
{{--  Start Hare --}}
<td>{{ App\Models\Teammember::select('team_member')->where('id', $clientassignmentDatas->leadpartner)->first()->team_member ?? '' }}
</td>
<td>{{ App\Models\Teammember::select('team_member')->where('id', $clientassignmentDatas->otherpartner)->first()->team_member ?? '' }}
</td>
{{--  Start Hare --}}
{{-- *  all model box   --}}
{{--  Start Hare --}}


<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog"
    aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Enter OTP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="confirmationForm">
                    <div
                        style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                        <div
                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                            <div
                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                {{-- <div style="width: 62px; height: 62px; position: relative">
                          <div
                              style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                          </div>
                          <div
                              style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                              <img src="{{ asset('image/security-safe.svg') }}"
                                  alt="security-safe">
                          </div>
                      </div> --}}
                                <div
                                    style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                    Verification Required</div>

                            </div>
                            <div class="details-form-field  row">

                                <div class="col-sm-12">

                                    <input type="hidden" id="debitid" name="debitid" class="form-control">
                                    <input type="hidden" id="assignmentgenerate_id" name="assignmentgenerate_id"
                                        class="form-control">
                                    <input type="hidden" id="type" name="type" class="form-control">
                                    <input type="hidden" id="status" name="status" class="form-control">
                                </div>
                            </div>

                            <div
                                style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                Please enter the 6-digit OTP sent to your registered
                                email address.
                            </div>
                        </div>



                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li style="color:red;">{{ $e }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                        @endif

                        <div name="otp"
                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                            <div class="container height-100 d-flex justify-content-center align-items-center">
                                <div class="position-relative">
                                    <div class="col-sm-12">
                                        <p class="text-success" id="otpmessage">
                                        </p>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="text-success" id="otpmessage2">
                                        </p>
                                    </div>
                                    <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
                                        <input name="otp1" class="m-2 text-center form-control rounded"
                                            type="text" id="first" maxlength="1" />
                                        <input name="otp2" class="m-2 text-center form-control rounded"
                                            type="text" id="second" maxlength="1" />
                                        <input name="otp3" class="m-2 text-center form-control rounded"
                                            type="text" id="third" maxlength="1" />
                                        <input name="otp4" class="m-2 text-center form-control rounded"
                                            type="text" id="fourth" maxlength="1" />
                                        <input name="otp5" class="m-2 text-center form-control rounded"
                                            type="text" id="fifth" maxlength="1" />
                                        <input name="otp6" class="m-2 text-center form-control rounded"
                                            type="text" id="sixth" maxlength="1" />
                                    </div>

                                </div>
                            </div>
                            <div style="width: 332px; text-align: center" class="resends"><span
                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                    receive the OTP?</span><span
                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                    {{-- <a id="yesid" data-id="{{ $debtorid }}" data-status="1"
                              data-resend="true" class="font-weight-500"
                              style="color:#37a000;"> Resend</a> --}}
                                </span>
                            </div>
                        </div>


                        <div
                            style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                            <button style="background: #37A000;" type="submit" class="btn btn-block" id="verifyBtn"
                                onclick="return confirm('Are you sure ?');">
                                <div
                                    style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                    Verify</div>
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{--  Start Hare --}}
{{-- * Request   --}}
{{--  Start Hare --}}
@if ($clientList->balanceconfirmationstatus == 1)
    @php
        $disabled = '';
    @endphp
@else
    @php
        $disabled = 'disabled';
    @endphp
@endif
<b style="float:left;margin-top: -17px;"> <a id="sendButton" data-toggle="modal"
        data-target=".exampleModal155-modal-lg" class="btn btn-info-soft btn-sm {{ $disabled }}">Send<i
            class="fas fa-envelope"></i></a></b>
{{--  Start Hare --}}
<div class="col-3">
    <div class="form-group">
        @if (Request::is('teammember/*/edit'))
            @php
                $timesheetdata = DB::table('timesheetusers')->where('createdby', $teammember->id)->first();
                // $disabled = $timesheetdata ? 'disabled' : '';
                $disabled = $timesheetdata ? 'readonly' : '';
            @endphp
        @endif
        <label class="font-weight-600">Email Id <span class="tx-danger">*</span></label>
        <input type="email" name="emailid" value="{{ $teammember->emailid ?? '' }}" class="form-control"
            placeholder="Enter Email" @if (Request::is('teammember/*/edit')) {{ $disabled }} @endif>
    </div>
</div>
{{--  Start Hare --}}
{{-- * regarding tag   --}}
{{--  Start Hare --}}
<div class="form-group">
    @php
        $timesheetdata = DB::table('timesheetusers')->where('createdby', $teammember->id)->first();
        $disabled = $timesheetdata ? 'disabled' : '';
    @endphp
    <label class="font-weight-600">Email Id <span class="tx-danger">*</span></label>
    <input type="email" name="emailid" value="{{ $teammember->emailid ?? '' }}" class="form-control"
        placeholder="Enter Email" {{ $disabled }}>
</div>
{{--  Start Hare --}}
{{-- * regarding text / nowrap  --}}
{{--  Start Hare --}}
<th style="white-space: nowrap;">Nature of service</th>
{{--  Start Hare --}}
{{-- *  regarding increament  --}}
{{--  Start Hare --}}
@foreach ($assignmentDatas as $assignmentData => $value)
    <tr>
        <td>{{ $assignmentData + 1 }}</td>
        <td>{{ $value->assignment_name }}</td>
        @if (App\Models\Financialstatementclassification::where('assignment_id', $value->id)->first())
            <td><a href="{{ url('/step/check/' . $value->id) }}" class="btn btn-primary">Checklist</a></td>
            {{--  <td><a href="{{url('/viewassignment/'.$assignmentData->id)}}" class="btn btn-primary">View</a></td> --}}
        @else
            <td></td>
            <td></td>
        @endif
    </tr>
@endforeach
{{--  Start Hare --}}
{{-- * regarding ??   --}}
{{--  Start Hare --}}
<td>{{ $partnerData->leadpartnerhour ?? ($partnerData->otherpartnerhour ?? 0) }}
    {{--  Start Hare --}}
    {{-- * regarding property_exists function    --}}
    {{--  Start Hare --}}
    @php
        $hour = 0;
        $partner = null;

        if (
            property_exists($teammemberData, 'leadpartner') &&
            $teammemberData->teamid == $teammemberData->leadpartner
        ) {
            $hour = $teammemberData->leadpartnerhour ?? 0;
            $partner = 'leadpartner';
        } elseif (
            property_exists($teammemberData, 'otherpartner') &&
            $teammemberData->teamid == $teammemberData->otherpartner
        ) {
            $hour = $teammemberData->otherpartnerhour ?? 0;
            $partner = 'otherpartner';
        } else {
            $hour = $teammemberData->teamhour ?? 0;
        }
    @endphp

<td>{{ $hour }}</td>

@foreach ($teammemberDatas as $teammemberData)
    <tr>
        <td>{{ $teammemberData->title }} {{ $teammemberData->team_member }}
            ({{ $teammemberData->staffcode }})
        </td>
        <td>{{ $teammemberData->assignmentgenerate_id }}</td>
        <td>{{ $teammemberData->assignmentname }}</td>
        @if (property_exists($teammemberData, 'leadpartner') && $teammemberData->teamid == $teammemberData->leadpartner)
            <td>{{ $teammemberData->leadpartnerhour ?? 0 }}</td>
        @elseif (property_exists($teammemberData, 'otherpartner') && $teammemberData->teamid == $teammemberData->otherpartner)
            <td>{{ $teammemberData->otherpartnerhour ?? 0 }}</td>
        @else
            <td>{{ $teammemberData->teamhour ?? 0 }}</td>
        @endif
    </tr>
@endforeach

{{--  Start Hare --}}
{{-- * regarding authorize  --}}
{{--  Start Hare --}}
@if (Auth::user()->can('update', $post))
    <!-- The current user can update the post... -->
@endif

@unless (Auth::user()->can('update', $post))
    <!-- The current user cannot update the post... -->
@endunless
@can('create', App\Models\Post::class)
    <!-- The current user can create posts... -->
@endcan

@cannot('create', App\Models\Post::class)
    <!-- The current user can't create posts... -->
@endcannot
{{--  Start Hare --}}
{{-- * regarding token / regarding @csrf  --}}
{{--  Start Hare --}}
<form method="POST" action="/profile">
    @csrf

    <!-- Equivalent to... -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
</form>
{{--  Start Hare --}}
{{-- * regarding fake data   --}}
{{--  Start Hare --}}
@php
    $faker = \Faker\Factory::create();
@endphp

@for ($i = 0; $i < 10; $i++)
    <dl>
        <dt>Name</dt>
        <dd>{{ $faker->name }}</dd>

        <dt>Email</dt>
        <dd>{{ $faker->unique()->safeEmail }}</dd>
    </dl>
@endfor
{{--  Start Hare --}}

{{-- * Regarding carbon    --}}
{{--  Start Hare --}}
@php
    $to = Carbon\Carbon::createFromFormat('Y-m-d', $getdate ?? '');
    $from = Carbon\Carbon::createFromFormat('Y-m-d', $currentdate);
@endphp
{{--  Start Hare --}}
{{-- *  regarding input type / regarding date / regarding date input type / regarding select box / regarding size increase / regarding select2 / regarding date null --}}
{{--  Start Hare --}}
{{-- date and time --}}
<td>{{ $udinData->udindate ? date('d-m-Y', strtotime($udinData->udindate)) : 'NA' }}</td>
<td>{{ date('d-m-Y', strtotime($udinData->created)) }},
    {{ date('H:i A', strtotime($udinData->created)) }}</td>

<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">Start Request Date</label>
        <input type="datetime-local" class="form-control startclass" id="start1" name="start">
    </div>
</div>
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">End Request Date</label>
        <input type="datetime-local" class="form-control endclass" id="end1" name="end">
    </div>
</div>
{{--  Start Hare --}}

<style>
    .select2-container {
        width: 48% !important;
    }
</style>

<div class="col">
    <div class="form-group">
        <strong><label for="employee">Employee</label></strong>
        <select class="language form-control" id="employee1" name="employee">
            <option value="">Please Select One</option>
            @php
                $displayedValues = [];
            @endphp
            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                @if (!in_array($applyleaveDatas->emailid, $displayedValues))
                    <option value="{{ $applyleaveDatas->createdby }}">
                        {{ $applyleaveDatas->team_member }}
                        ({{ $applyleaveDatas->emailid }})
                    </option>
                    @php
                        $displayedValues[] = $applyleaveDatas->emailid;
                    @endphp
                @endif
            @endforeach
        </select>
    </div>
</div>
{{--  Start Hare --}}
<div class="col-3">
    <div class="form-group">
        <label class="font-weight-600">Date</label>
        @php
            $formattedDate = isset($entrieseditdata->date)
                ? \Carbon\Carbon::createFromFormat('d/m/Y', $entrieseditdata->date)->format('Y-m-d')
                : '';
        @endphp
        <input type="date" name="date" value="{{ $formattedDate }}" class="form-control leaveDate"
            placeholder="Enter date">
    </div>
</div>
{{--  Start Hare --}}
{{-- * regarding mail   --}}
{{--  Start Hare --}}
<h3>Dear Sir/Madam,</h3>
<br>
<p>
    You have received a new request for Timesheet Submission.
</p>
<p>
    <strong>Name:</strong> {{ $teammember->team_member ?? '' }} ({{ $teammember->staffcode ?? '' }})<br>
    <strong>Reason:</strong> {{ $reason ?? '' }}<br>
    <strong>Request Date:</strong> {{ $created_at ?? '' }}
</p>

<p>
    After your approval, the employee will be able to submit his/her timesheet.
</p>
<p>
    To approve or reject the request, please click <a href="{{ url('/timesheetrequest/view/' . $id) }}">here</a>.
</p>
{{--  Start Hare --}}
<td>
    <a href="mailto:{{ $clientdebitdata->email }}">{{ $clientdebitdata->email }}</a>
</td>
{{-- * regarding form url / regarding url  --}}
{{--  Start Hare --}}
<form method="post" action="{{ route('teammember.update', $teammember->id) }}" enctype="multipart/form-data">
    {{--  Start Hare --}}
    <form method="POST" action="{{ url('authnewpassowrd/store/' . $id) }}">
        {{--  Start Hare --}}
        <form method="POST"
            action="{{ url('confirmation?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $status) }}"
            enctype="multipart/form-data">
            Route::post('confirmation/', [AssignmentconfirmController::class, 'confirmationConfirm']);
            {{--  Start Hare --}}
            {{-- * regarding folder delete  --}}
            {{--  Start Hare --}}
            @if ($assignmentfolderpermission->status == 1)
                {{-- @php
    dd($assignmentfolderData->createdby);
@endphp --}}
                @if (
                    $assignmentfolderData->createdby == Auth::user()->teammember_id ||
                        Auth::user()->role_id == 13 ||
                        Auth::user()->role_id == 14 ||
                        Auth::user()->role_id == 15)
                    <ul class="navbar-nav flex-row align-items-center ml-auto">
                        <li class="nav-item dropdown user-menus">
                            <a class="foldertoggle" style=" color:white" href="#" data-toggle="dropdown">

                                <i class="ti-more-alt"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-left">
                                @if ($assignmentfolderData->createdby == Auth::user()->teammember_id || Auth::user()->role_id == 13)
                                    <a style="margin-left: 10px;color:#7a7a7a;" id="editCompany" data-toggle="modal"
                                        data-id="{{ $assignmentfolderData->id }}" data-target="#modaldemo1"
                                        class="dropdown-item">Edit Name</a>
                                @endif

                                @if (DB::table('assignmentfolderfiles')->where('assignmentfolderfiles.assignmentfolder_id', $assignmentfolderData->id)->where('status', '1')->count() == 0)
                                    @if (
                                        $assignmentfolderData->createdby == Auth::user()->teammember_id ||
                                            Auth::user()->role_id == 13 ||
                                            Auth::user()->role_id == 14 ||
                                            Auth::user()->role_id == 15)
                                        <a style="margin-left: 10px;color:#7a7a7a;"
                                            onclick="return confirm('Are you sure you want to delete this folder?');"
                                            href="{{ url('assignmentfolderdelete', $assignmentfolderData->id) }}"
                                            class="dropdown-item">Delete</a>
                                    @endif
                                @endif
                            </div>

                        </li>
                    </ul>
                @endif
            @endif
            {{-- * regarding sum  --}}
            {{--  Start Hare --}}
            <div>

                @php
                    $totalHourSum = DB::table('timesheetusers')
                        ->leftJoin('teammembers', 'teammembers.id', '=', 'timesheetusers.createdby')
                        ->where('timesheetusers.assignmentgenerate_id', $teammemberData->assignmentgenerateid)
                        ->where('timesheetusers.createdby', $teammemberData->id)
                        ->sum('timesheetusers.totalhour');

                    $totalhour = DB::table('timesheetusers')
                        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                        ->where('timesheetusers.assignmentgenerate_id', $teammemberData->assignmentgenerateid)
                        ->where('timesheetusers.createdby', $teammemberData->id)
                        ->select(DB::raw('SUM(totalhour) as total_hours'))
                        ->get();

                    dd($totalHourSum);

                    $totalhour = DB::table('timesheetusers')
                        ->leftJoin('teammembers', 'teammembers.id', 'timesheetusers.createdby')
                        ->where('timesheetusers.assignmentgenerate_id', $teammemberData->assignmentgenerateid)
                        ->where('timesheetusers.createdby', $teammemberData->id)
                        ->select(DB::raw('SUM(totalhour) as total_hours'))
                        ->first();

                @endphp
            </div>

            {{-- * regarding comma / regarding key/ regarding foreach /regarding count  --}}

            <td>
                {{ $client_id->client_name ?? '' }}
                @if (count((array) $client_id->client_name) > 1)
                    ,
                @endif
            </td>

            <td>
                @foreach ($client_id as $key => $item)
                    {{ $item->client_name ?? '' }}
                    @if ($key < count($client_id) - 1 && $item->client_name != null)
                        ,
                    @endif
                @endforeach
            </td>

            <td>
                @foreach ($client_id as $key => $item)
                    {{ $item->assignment_name ?? '' }}
                    @if ($key < count($client_id) - 1 && $item->assignment_name != null)
                        ,
                    @endif
                @endforeach
            </td>

            <td>
                @foreach ($client_id as $key => $item)
                    {{ $item->workitem ?? '' }}
                    @if ($key < count($client_id) - 1 && $item->workitem != null)
                        ,
                    @endif
                @endforeach
            </td>

            <td>
                @foreach ($client_id as $key => $item)
                    {{ $item->location ?? '' }}
                    @if ($key < count($client_id) - 1 && $item->location != null)
                        ,
                    @endif
                @endforeach
            </td>

            <td>
                @foreach ($client_id as $key => $item)
                    {{ $item->team_member ?? '' }}
                    @if ($key < count($client_id) - 1 && $item->team_member != null)
                        ,
                    @endif
                @endforeach
            </td>


            {{-- * regarding Ascending / regarding Descending / regarding order /regarding ordering   --}}

            <table>
                <tr>
                    <td> <span style="display: none;">
                            {{ date('Y-m-d', strtotime($jobDatas->created_at)) }}</span>{{ $jobDatas->week }}
                    </td>
                    <td>
                        <span style="display: none;">
                            {{ $jobDatas->created_at }}</span>
                        {{ date('d-m-Y', strtotime($jobDatas->created_at)) }}
                        {{ date('h:i A', strtotime($jobDatas->created_at)) }}
                    </td>

                    <td><span></span>
                        {{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
                    </td>
                </tr>
            </table>

            {{-- *   --}}
            <table class="table display table-bordered table-striped table-hover" style = "width:100%">

            </table>
            {{-- * email fotrmate / regarding email  --}}
            {{-- resources\views\backEnd\layouts\includes\leftsidebar.blade.php --}}
            <h3>Dear {{ $name ?? '' }} ,</h3>
            <br>
            <p>This email is to inform you that your assignment has been closed by OTP.</p>
            <p>The OTP is <b>{{ $otp }}</b>. Please enter this OTP in the assignment submission form to close
                your
                assignment.
            </p>

            <table>
                <tbody>
                    <tr>
                        <td><b>Assignment Name : </b></td>
                        <td>{{ $assignmentname }}</td>
                    </tr>
                    <tr>
                        <td><b>Client Name :</b></td>
                        <td>{{ $client_name }}</td>
                    </tr>
                    <tr>
                        <td><b>Team Members :</b></td>
                        @foreach ($assignmentteammember as $teammembers)
                            <td>{{ $teammembers->team_member }},</td>
                        @endforeach
                    </tr>
                <tbody>
            </table>

            <tr>
                <td><b>Team Leaders :</b></td>
                @foreach ($assignmentteammember as $teammembers)
                    @if ($teammembers->type == 0)
                        <td>{{ $teammembers->team_member }},</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <td><b>Staff:</b></td>
                @foreach ($assignmentteammember as $teammembers)
                    @if ($teammembers->type == 2)
                        <td>{{ $teammembers->team_member }},</td>
                    @endif
                @endforeach
            </tr>

            {{-- * regarding button / open / onclick / on click   --}}

            <td><b>Status : </b></td>
            <td>
                @if (Auth::user()->role_id == 13)
                    @if ($assignmentbudgetingDatas->status != 0)
                        <a id="editCompanys" data-id="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}"
                            data-toggle="modal" data-target="#exampleModal134">
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



            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
            <script>
                $(function() {
                    $('body').on('click', '#editCompanys', function(event) {
                        //        debugger;
                        var id = $(this).data('id');
                        alert(id);
                        debugger;
                        $.ajax({
                            type: "GET",

                            url: "{{ url('assignmentotp') }}",
                            data: "id=" + id,
                            success: function(response) {
                                // alert(res);
                                debugger;
                                $("#assignmentgenerateid").val(response.assignmentgenerate_id);


                                if (response !== null) {
                                    // Show the message that the OTP has been sent to the email
                                    $('#otp-message').html('OTP send to your email please check');
                                }
                            },
                            error: function() {

                            },
                        });
                    });
                });
            </script>



            {{-- * regarding stucture / stucture --}}
            {{-- start hare  --}}
            {{-- start hare  --}}
            {{-- start hare  --}}
            <pre>
htdocs/
├── assets/
│   └── web/
│       └── css/
│           └── index.css
│           └── responsive.css
├── laravel/
│   └── App/
│   └── resources/
│   └── route/
├── .htaccess
├── favicon.ico
├── index.php
├── robots.txt
└── ...

</pre>
            {{-- start hare  --}}
            <pre>
                htdocs/
                ├── assets/
                │   └── web/
                │       └── css/
                │           └── index.css
                │           └── responsive.css
                ├── laravel/
                │   └── App/
                │   └── resources/
                │   └── route/
                ├── .htaccess
                ├── favicon.ico
                ├── index.php
                ├── robots.txt
                └── ...

</pre>
            {{-- start hare  --}}
            <pre>
------------------------------------------------------------------------------------------------------------------------------------
#                              Query                             #                  Description                                    #
------------------------------------------------------------------------------------------------------------------------------------
#  1. select                                                     #                                                                 #
#  2. select                                                     #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
#                                                                #                                                                 #
------------------------------------------------------------------------------------------------------------------------------------



</pre>

            <pre>
...........................................................
.      name      .      email   .    location     .  work .                                                       .
...........................................................
.      Shahid    .abc@gmail.com.        delhi   .timesheet.
...........................................................
.      Shahid    .abc@gmail.com.   delhi,mumbai   .Gst,Gst2.
...........................................................
.      Shahid    .abc@gmail.com.   delhi,mumbai   .Gst,Gst2.
...........................................................
.      Shahid    .abc@gmail.com.        patna    .Submitted.
...........................................................



...........................................................
.      name      .      email   .    location     .  work .                                                       .
...........................................................
.      Shahid    .abc@gmail.com.        delhi   .timesheet.
...........................................................
.      Shahid    .abc@gmail.com.         delhi   .  Gst   .
...........................................................
.      Shahid    .abc@gmail.com.       mumbai   .    Gst2.
...........................................................
.      Shahid    .abc@gmail.com.        patna    .Submitted.
...........................................................




</pre>






            <pre>
.....................  ..........................................
.    assin=nment    .  . ....................  ..............   .
.                   .  . .  notifiction     .  . Birthday   .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . . .................   .. .......... .
.                   .  .                                        .
.                   .  . ....................  ..............   .
.                   .  . .Upcoming Holidays .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . .                  .  .            .   .
.                   .  . . .................   .. ...........   .
.....................  ..........................................
</pre>
            {{-- file stucture on download  --}}
            <pre>
- NEW100212.zip
----Shahid f
------Shahid f
--------image1.zip
--------laravel.zip
----sultan 2
------sultan 2

- NEW100212.zip
--- Shahid f
------image1.zip
------laravel.zip
---sultan 2
--- Shahid f
------screenshot.png
------larave2.zip
</pre>

            <pre>
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #                              Query                             #                  Description                                                                     #
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    #  1. `SELECT * FROM table WHERE column LIKE 'pattern';`         #  Selects all rows from the specified table where the specified column matches the given pattern  #
    #  2. `SELECT * FROM table WHERE column LIKE 'pattern';`         #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    #                                                                #                                                                                                  #
    ---------------------------------------------------------------------------------------------------------------------------------------------------------------------
    
    
    
    </pre>

            {{-- * filter according email / accrording mail   --}}
            {{-- <div class="col-4">
                             <div class="form-group">
                                 <label class="font-weight-600">Employee</label>
                                 <select class="language form-control" id="employee1" name="employee">
                                     <option value="">Please Select One</option>
                                     @php
                                         $displayedValues = [];
                                     @endphp
                                     @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                         @if (!in_array($applyleaveDatas->team_member, $displayedValues))
                                             <option value="{{ $applyleaveDatas->createdby }}">
                                                 {{ $applyleaveDatas->team_member }}
                                             </option>
                                             @php
                                                 $displayedValues[] = $applyleaveDatas->team_member;
                                             @endphp
                                         @endif
                                     @endforeach
                                 </select>
                             </div>
                         </div> --}}
            <div class="col-4">
                <div class="form-group">
                    <label class="font-weight-600">Employee</label>
                    <select class="language form-control" id="employee1" name="employee">
                        <option value="">Please Select One</option>
                        @php
                            $displayedValues = [];
                        @endphp
                        @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                            @if (!in_array($applyleaveDatas->emailid, $displayedValues))
                                <option value="{{ $applyleaveDatas->createdby }}">
                                    {{ $applyleaveDatas->team_member }} ({{ $applyleaveDatas->emailid }})
                                </option>
                                @php
                                    $displayedValues[] = $applyleaveDatas->emailid;
                                @endphp
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- * regarding isset  --}}

            @if (isset($message))
                <div>
                    {{ $message }}
                </div>
            @endif

            {{-- Start hare --}}
            @foreach ($notificationDatas as $notificationData)
                @php
                    $userId = auth()->user()->teammember_id;
                    $checkread = DB::table('notificationreadorunread')
                        ->where('notifications_id', $notificationData->id)
                        ->where('readedby', $userId)
                        ->first();
                @endphp
                <div class="card-body" style="height: 86px;">
                    <div class="media new">
                        <div class="media-body">
                            <a href="{{ url('notification/' . $notificationData->id) }}"
                                style="color: {{ isset($checkread) && $checkread->status == 1 ? 'black' : 'red' }}">
                                <h6>{{ $notificationData->title }}</h6>
                            </a>
                            <span>
                                <small class="text-muted"><i
                                        class="far fa-clock mr-1"></i>{{ date('F jS', strtotime($notificationData->created_at)) }}</small>
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- Start hare --}}
            {{-- * regarding button / regarding style   --}}
            <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
            {{-- * date on pdf / regarding pdf/ regarding excell   --}}

            <td>
                <span>{{ $timesheetDatas->team_member ?? '' }}</span>
                <span style="display: none;">{{ $timesheetDatas->staffcode ?? '' }}</span>
            </td>

            <script>
                $(document).ready(function() {
                    $('#examplee').DataTable({
                        dom: 'Bfrtip',
                        "order": [
                            [1, "asc"]
                        ],

                        buttons: [

                            {
                                extend: 'copyHtml5',
                                exportOptions: {
                                    columns: [0, ':visible']
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                filename: 'Assignment Report List',
                                exportOptions: {
                                    columns: ':visible'
                                }
                            },

                            {
                                extend: 'pdfHtml5',
                                filename: 'Assignment Report List',
                                // which column do you want to on pdf page
                                exportOptions: {
                                    columns: [0, 1, 2, 4, 10]
                                },
                                // add date on pdf page
                                // customize: function(doc) {
                                //     var now = new Date();
                                //     var formattedDate = now.toLocaleString();
                                //     doc.content.splice(1, 0, {
                                //         text: 'Generated on: ' + formattedDate,
                                //         // alignment: 'center',
                                //         margin: [0, 0, 0, 10]

                                //     });
                                // }

                            },
                            // column visibility
                            'colvis'
                        ]
                    });
                });
            </script>
            {{-- * old value / regarding old value / regarding option tag    --}}
            {{-- start hare  --}}
            @php
                if ($duplicatecheck != null) {
                    $output = [
                        'msg' => "This data already exists with the name: $duplicatecheck->name and email: $duplicatecheck->email.",
                    ];
                    $request->flash();
                    return back()->with('statuss', $output);
                }
            @endphp
            <div class="col-3">
                <div class="form-group">
                    <label class="font-weight-600">Primary email <span id="required">*</span></label>
                    {{-- <input type="email" name="email" value="{{ $entrieseditdata->email ?? '' }}"
                    class=" form-control" placeholder="Enter Primary email"> --}}
                    <input type="email" name="email" value="{{ old('email', $entrieseditdata->email ?? '') }}"
                        class=" form-control" placeholder="Enter Primary email">
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <label class="font-weight-600">Name <span id="required">*</span></label>
                    {{-- <input type="text" name="name" value="{{ $entrieseditdata->name ?? '' }}"
                    class=" form-control" placeholder="Enter  name"> --}}

                    <input type="text" name="name" value="{{ old('name', $entrieseditdata->name ?? '') }}"
                        class=" form-control" placeholder="Enter  name">
                </div>
            </div>
            {{-- start hare  --}}
            {{-- add this code before return view blade file in controller --}}
            $request->flash();
            <td>
                <div class="form-group">
                    <input type="date" class="form-control" id="startdate" name="startdate"
                        value="{{ old('startdate') }}">
                </div>
            </td>
            <td>
                <div class="form-group">
                    <input type="date" class="form-control" id="enddate" name="enddate"
                        value="{{ old('enddate') }}">
                </div>
            </td>
            <td>
                {{-- <div class="form-group">
        <select class="language form-control" id="year" name="year">
            <option value="">Please Select One</option>
            <option value="2024">2024</option>
            <option value="2023">2023</option>
        </select>
    </div> --}}
                <div class="form-group">
                    <select class="language form-control" id="year" name="year">
                        <option value="">Please Select One</option>
                        <option value="2024" {{ old('year') == '2024' ? 'selected' : '' }}>2024
                        </option>
                        <option value="2023" {{ old('year') == '2023' ? 'selected' : '' }}>2023
                        </option>
                    </select>
                </div>
            </td>

            @foreach ($teammembers as $teammember)
                @if (!in_array($teammember->staffcode, $displayedValues))
                    {{-- <option value="{{ $teammember->id }}"> --}}
                    <option value="{{ $teammember->id }}"
                        {{ old('teammemberId') == $teammember->id ? 'selected' : '' }}>
                        {{ $teammember->team_member }} ({{ $teammember->staffcode }})
                    </option>
                    @php
                        $displayedValues[] = $teammember->staffcode;
                    @endphp
                @endif
            @endforeach

            {{-- *   --}}
            <div class="form-group">
                <select class="language form-control" id="year" name="year">
                    <option value="">Please Select One</option>
                    @for ($year = 2023; $year <= 2027; $year++)
                        <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>
                            {{ $year }}</option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <select class="language form-control" id="year" name="year">
                    <option value="">Please Select One</option>
                    @for ($year = date('Y'); $year <= 2027; $year++)
                        <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="form-group">
                <select class="language form-control" id="year" name="year">
                    <option value="">Please Select One</option>
                    @for ($year = date('Y'); $year <= 2025; $year++)
                        <option value="{{ $year }}" @if ($year == date('Y')) selected @endif>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>



            {{-- * basic class/ regarding basic class/ regarding table/ regarding ordering /regarding heading / regarding table /regarding th tag   --}}
            {{-- start --}}

            {{-- i have already basic class on this table  --}}
            <table class="table display table-bordered table-striped table-hover basic">
                <thead>
                    <tr>
                        <th style="display: none;">id</th>
                        <th>Employee Name</th>
                        <th class="textfixed">Staff Code</th>
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
                        <th>Status</th>
                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
            </table>

            {{-- remove basic class from table and add id  --}}
            <table id="examplee" class="table display table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="display: none;">id</th>
                        <th>Employee Name</th>
                        <th class="textfixed">Staff Code</th>
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
                        <th>Status</th>
                        @if (Auth::user()->role_id == 11 || Auth::user()->teammember_id != $timesheetData[0]->createdby)
                            <th>Action</th>
                        @endif
                    </tr>
                </thead>
            </table>

            {{-- add this below script  --}}

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
                        "order": [
                            //   [2, "desc"]
                        ],
                        searching: false,
                        columnDefs: [{
                            targets: [0, 1, 2, 4, 5],
                            orderable: false
                        }],
                        buttons: []
                    });
                });
            </script>




            {{-- start --}}
            {{-- start --}}
            @php
                $timesheetrequestsDatas = DB::table('leaverequest')
                    ->leftjoin('teammembers', 'teammembers.id', 'leaverequest.approver')
                    ->leftjoin('teammembers as createdby', 'createdby.id', 'leaverequest.createdby')
                    ->leftjoin('applyleaves', 'applyleaves.id', 'leaverequest.applyleaveid')
                    ->leftjoin('leavetypes', 'leavetypes.id', 'applyleaves.leavetype')
                    // ->where('createdby.id', auth()->user()->teammember_id)
                    ->select(
                        'leaverequest.*',
                        'teammembers.team_member',
                        'applyleaves.leavetype',
                        'leavetypes.name',
                        'createdby.team_member as createdbyauth',
                    )
                    ->get();

                $hasPendingRequests = $timesheetrequestsDatas->contains('status', 0);

                return view(
                    'backEnd.applyleave.adminrevertleave',
                    compact('timesheetrequestsDatas', 'hasPendingRequests'),
                );
            @endphp
            <table id="examplee" class="table display table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th style="display: none;">id</th>
                        <th>Employee</th>
                        <th>Status</th>
                        <th>Leave Type</th>
                        <th>Date</th>
                        <th>Approver</th>
                        <th>Reason</th>
                        @if ($hasPendingRequests)
                            <th>Approved</th>
                            <th>Reject</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{-- @php
                    dd($timesheetrequestsDatas);
                @endphp --}}
                    @foreach ($timesheetrequestsDatas as $timesheetrequestsData)
                        <tr>

                            <td style="display: none;">{{ $timesheetrequestsData->id }}</td>
                            {{-- <td>{{ $timesheetrequestsData->createdbyauth }}</td> --}}
                            @if (auth()->user()->role_id == 11)
                                <td>
                                    {{-- <a href="{{ route('applyleave.show', $applyleaveDatas->id) }}"> --}}
                                    <a href="{{ url('examleaverequest', $timesheetrequestsData->id) }}">
                                        {{ $timesheetrequestsData->createdbyauth ?? '' }}</a>
                                </td>
                            @else
                                <td>{{ $timesheetrequestsData->createdbyauth }}</td>
                            @endif
                            <td>
                                @if ($timesheetrequestsData->status == 0)
                                    <span class="badge badge-pill badge-warning">Created</span>
                                @elseif($timesheetrequestsData->status == 1)
                                    <span class="badge badge-pill badge-success">Approved</span>
                                @else
                                    <span class="badge badge-pill badge-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $timesheetrequestsData->name }}</td>

                            <td>{{ date('d-m-Y', strtotime($timesheetrequestsData->created_at)) }}</td>

                            <td>{{ $timesheetrequestsData->team_member }}</td>
                            <td>{{ $timesheetrequestsData->reason }}</td>
                            {{-- <td>{{ $timesheetrequestsData->remark }}</td> --}}
                            @if ($timesheetrequestsData->status == 0)
                                <td>
                                    <form method="post"
                                        action="{{ route('examleaveapprove', $timesheetrequestsData->id) }}"
                                        enctype="multipart/form-data" style="text-align: center;">
                                        @method('PATCH')
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            style="border-radius: 11px; font-size: 12px; padding: 5px;">
                                            Approve</button>
                                        <input type="text" hidden id="example-date-input" name="status"
                                            value="1" class="form-control">

                                        <input type="hidden" name="leavetype"
                                            value="{{ $timesheetrequestsData->leavetype }}" class="form-control"
                                            placeholder="">
                                    </form>
                                </td>
                            @endif
                            @if ($timesheetrequestsData->status == 0)
                                <td>
                                    <form method="post"
                                        action="{{ route('examleaveapprove', $timesheetrequestsData->id) }}"
                                        enctype="multipart/form-data" style="text-align: center;">
                                        @method('PATCH')
                                        @csrf
                                        <button style="border-radius: 11px; font-size: 12px; padding: 5px;"
                                            type="submit" class="btn btn-danger">
                                            Reject</button>
                                        <input hidden type="text" id="example-date-input" name="status"
                                            value="2" class="form-control" placeholder="Enter Location">
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- start --}}
            <!--Page Active Scripts(used by this page)-->
            {{-- <script src="{{ url('backEnd/plugins/datatables/dataTables.min.js') }}"></script> --}}
            <script src="{{ url('backEnd/plugins/datatables/data-basic.active.js') }}"></script>
            above code exist in
            resources\views\backEnd\layouts\includes\js.blade.php

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
            </table>

            <script>
                $(document).ready(function() {
                    // Initialize DataTables with default sorting on the "Date" column
                    $('#examplee').DataTable({
                        "order": [
                            [2, "asc"]
                        ], // 2 is the index of the "Date" column, "asc" for ascending order
                        "columnDefs": [{
                            "targets": [0],
                            "orderable": false
                        }, ]
                    });
                });
            </script>

            @foreach ($myapplyleaveDatas as $applyleaveDatas)
                @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
                    <th>Action</th>
                @endif
            @endforeach

            @foreach ($client_id as $item)
                @if ($loop->iteration == 1)
                    {{ $item->client_name ?? '' }}
                @endif
            @endforeach

            @foreach ($client_id as $item)
                @if ($loop->first)
                    {{ $item->client_name ?? '' }}a
                @elseif ($loop->last)
                    {{ $item->client_name ?? '' }}b
                @endif
            @endforeach

            @foreach ($client_id as $item)
                @if ($loop->iteration == 1)
                    @if ($loop->first)
                        {{ $item->client_name ?? '' }}
                    @endif
                @endif
                @if ($loop->iteration == 2)
                    @if ($loop->first)
                        {{ $item->client_name ?? '' }}b
                    @endif
                @endif
            @endforeach


            {{-- * Permission / regarding permission / 0 error     --}}



            @if ($permissiontimesheet)
                <li>
                    <a class="btn btn-info"
                        href="{{ url('mytimesheetlist', $permissiontimesheet->teamid) }}">Download</a>
                </li>
            @endif

            @if ($permissiontimesheet && $permissiontimesheet->teamid !== null)
                <li>
                    <a class="btn btn-info"
                        href="{{ url('mytimesheetlist', $permissiontimesheet->teamid) }}">Download</a>
                </li>
            @endif


            public function indexlist($id)
            {
            //dd($id);
            $assignmentfolder = Assignmentfolder::where('assignmentgenerateid', $id)->get();

            $assignmentfolderpermission = DB::table('assignmentbudgetings')->where('assignmentgenerate_id',
            $id)->first();
            return view('backEnd.assignmentfolder.index', compact('assignmentfolder', 'id',
            'assignmentfolderpermission'));
            }

            @if ($assignmentfolderpermission->status == 1)
                <li style="margin-left: 13px;"><a class="btn btn-success" style="color:white;" data-toggle="modal"
                        data-target="#exampleModal1">Add Folder</a></li>
            @endif

            {{-- * empty /regarding empty   --}}

            @if (!empty($permissiontimesheet->teamid))
                <li><a href="{{ url('mytimesheetlist', $permissiontimesheet->teamid) }}">Timesheet
                        Report</a></li>
            @endif


            @if ($assignmentfolder->isNotEmpty())
                <li style="margin-left: 13px;">
                    <a href="{{ route('zipfolder', ['assignmentgenerateid' => $assignmentfolder[0]->assignmentgenerateid]) }}"
                        class="btn btn-secondary" style="color:white;">Download Folder</a>
                </li>
            @endif


            {{-- @if ($assignmentfolder)
    <li style="margin-left: 13px;">
        <a href="{{ route('zipfolder', ['assignmentgenerateid' => $assignmentfolder[0]->assignmentgenerateid]) }}"
            class="btn btn-secondary" style="color:white;">Download Folder</a>
    </li>
@endif --}}
            {{-- @forelse ($assignmentfolder as $folder)
    <li style="margin-left: 13px;">
        <a href="{{ route('zipfolder', ['assignmentgenerateid' => $folder->assignmentgenerateid]) }}"
            class="btn btn-secondary" style="color:white;">Download Folder</a>
    </li>
@empty

    <p>No folders available.</p>
@endforelse --}}




            {{-- * progress bar / persentage/  --}}
            <div class="details-form-field form-group row">
                <label for="name" class="col-sm-3 col-form-label font-weight-600">File upload:</label>
                <div class="col-sm-9 d-flex justify-content-center align-items-center">
                    <div class="progress">
                        <div class="bar"></div>
                        <div class="percent">0%</div>
                    </div>
                    <div id="status"></div>
                </div>
            </div>

            <!-- jQuery CDN -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- jQuery Form Plugin CDN -->
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script> --}}

            {{-- for dd karne ke liye is script ko comment kar de tabhi dd kar payenge function me --}}
            <script type="text/javascript">
                var bar = $('.bar');
                var percent = $('.percent');

                $('form').ajaxForm({
                    beforeSend: function() {
                        var percentVal = '0%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                    },
                    uploadProgress: function(event, position, total, percentComplete) {
                        console.log(percentComplete);
                        var percentVal = percentComplete + '%';
                        bar.width(percentVal);
                        percent.html(percentVal);
                        console.log(percentVal);
                    },
                    complete: function(xhr) {
                        var folderId = "{{ $foldername->id }}";
                        window.location = "{{ url('assignmentfolderfiles') }}/" + folderId;
                        // window.location = "{{ url('/') }}/test";
                    }
                });
            </script>
            {{-- * regarding request/ regarding url / regarding route / regarding permission   --}}

            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                @if (
                    !(Auth::user()->role_id == 13 && Request::is('timesheet/teamlist')) &&
                        (Auth::user()->role_id == 14 || Auth::user()->role_id == 15 || Auth::user()->role_id == 13))
                    <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                        @if ($permissiontimesheet && $permissiontimesheet->teamid !== null)
                            <li>
                                <a class="btn btn-info"
                                    href="{{ url('mytimesheetlist', $permissiontimesheet->teamid) }}">Download</a>
                            </li>
                        @endif
                    </ol>
                @endif
                @if (Auth::user()->role_id == 11 || (Auth::user()->role_id == 13 && Request::is('timesheet/teamlist')))
                    <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                        <li>
                            <a class="btn btn-info" href="{{ url('admintimesheetlist') }}">Download</a>
                        </li>
                    </ol>
                @endif
            </nav>

            @if (Request::is('adminsearchtimesheet') || Request::is('mytimesheetlist/*') || Request::is('searchingtimesheet'))
                <button type="submit" class="btn btn-success">Search</button>
            @endif
                                @if (Request::is('İndependence/pending'))
                                @endif

            <div class="media-body">
                @if (Request::is('admintimesheetlist') || Request::is('adminsearchtimesheet'))
                    <h1 class="font-weight-bold">Team Timesheet Report</h1>
                @elseif(Request::is('mytimesheetlist/*') || Request::is('searchingtimesheet'))
                    <h1 class="font-weight-bold">Timesheet Report</h1>
                @endif
                <small>Team Workbook List</small>
            </div>
            <div>
                @if (Request::is('mytimesheetlist/*'))
                    <button type="submit" class="btn btn-success">Search</button>
                @endif
                @if (Request::is('searchingtimesheet'))
                    <button type="submit" class="btn btn-success">Searchaa</button>
                @endif
            </div>

            <div>

                <form method="post" action="{{ url('timesheetrequest/update', $applyleave->id) }}"
                    enctype="multipart/form-data">

                    <form method="post" action="{{ route('applyleave.update', $applyleave->id) }}"
                        enctype="multipart/form-data">


                        <select class="language form-control" name="client_id[]" id="client{{ $i }}"
                            @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
Client
</option>
@if (Request::is('timesheet/edit/*'))
    >
    @if ($item->billable_status == 'Billable')
        <option value="Billable">Billable</option>
        <option value="Non Billable">Non Billable</option>
    @else
        <option value="Non Billable">Non Billable</option>
        <option value="Billable">Billable</option> @endif
                            @endif
                            @endif
                            @if (Request::is('timesheet/*/edit')) >
        @if ($timesheet->billable_status == 'Billable')
            <option value="Billable">Billable</option>
            <option value="Non Billable">Non Billable</option>
        @else
            <option value="Non Billable">Non Billable</option>
            <option value="Billable">Billable</option> @endif
                            @endif
                            @endif
            </div>
            {{-- * regarding date and time    --}}
            <small class="text-muted">
                {{ \Carbon\Carbon::parse($birthday->dateofbirth)->format('d M') }}
                {{-- 14 jan output --}}
            </small>

            <td>{{ date('d-m-Y', strtotime($jobDatas->created_at)) }}
                {{ date('h:i A', strtotime($jobDatas->created_at)) }}</td>

            {{-- 25-11-2023 12:00 AM --}}



            {{-- * regarding ajax / table heading replace    --}}
            <script>
                //** status wise
                $('#status1').change(function() {
                    var status1 = $(this).val();
                    var employee1 = $('#employee1').val();
                    var leave1 = $('#leave1').val();
                    $.ajax({
                        type: 'GET',
                        url: '/filtering-applyleve',
                        data: {
                            status: status1,
                            employee: employee1,
                            leave: leave1
                        },
                        success: function(data) {
                            // Replace the table body with the filtered data
                            //  $('table tbody').html("");
                            $('table thead, table tbody').html("");
                            // Clear the table body
                            if (data.length === 0) {
                                // If no data is found, display a "No data found" message
                                $('table tbody').append(
                                    '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                                );
                            } else {

                                // Add existing table heading
                                $('table thead').append(
                                    '<tr>' +
                                    '<th style="display: none;">id</th>' +
                                    '<th>Employee</th>' +
                                    '<th>Date of Requestaaaaa</th>' +
                                    '<th>Status</th>' +
                                    '<th>Leave Type</th>' +
                                    '<th>Leave Period</th>' +
                                    '<th>Days</th>' +
                                    '<th>Approver</th>' +
                                    '<th>Reason for Leave</th>' +
                                    '</tr>'
                                );

                                $.each(data, function(index, item) {

                                    // Create the URL dynamically
                                    var url = '/applyleave/' + item.id;

                                    var createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    var fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    var toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    var holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 * 60 *
                                        1000)) + 1;

                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + createdAt + '</td>' +
                                        '<td>' + getStatusBadge(item.status) + '</td>' +
                                        '<td>' + item.name + '</td>' +
                                        '<td>' + fromDate + ' to ' + toDate +
                                        '</td>' +
                                        '<td>' + holidays + '</td>' +
                                        '<td>' + item.approvernames + '</td>' +
                                        '<td style="width: 7rem;text-wrap: wrap;">' +
                                        item.reasonleave + '</td>' +
                                        '</tr>');
                                });



                                // Function to handle the status badge
                                function getStatusBadge(status) {
                                    if (status == 0) {
                                        return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                                    } else if (status == 1) {
                                        return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                                    } else if (status == 2) {
                                        return '<span class="badge badge-danger">Rejected</span>';
                                    } else {
                                        return '';
                                    }
                                }

                                //   remove pagination after filter
                                $('.paging_simple_numbers').remove();
                                $('.dataTables_info').remove();
                                // Change id aatribute dynamically in ajax
                                $('#examplee').attr('id', 'examplee1');
                                $('#examplee').removeAttr('id');
                            }
                        }
                    });
                });
            </script>
            {{-- * regarding anchor tag   --}}
            {{-- Start hare --}}
            {{-- Start hare --}}

            {{-- @if ($timesheetDatas->status == 2)
                                                <a href="  {{ url('/timesheet/reject/' . $timesheetDatas->id) }}"
                                                    onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                        data-target="#requestModal" disabled>Reject</button>
                                                </a>
                                            @else
                                                <a href="{{ url('/timesheet/reject/' . $timesheetDatas->id) }}"
                                                    onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                                                    <button class="btn btn-danger" data-toggle="modal"
                                                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                                                        data-target="#requestModal">Reject</button>
                                                </a>
                                            @endif --}}

            <a href="{{ url('/timesheet/reject/' . $timesheetDatas->id) }}"
                onclick="return confirm('Are you sure you want to Reject this timesheet?');">
                <button class="btn btn-danger"
                    style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 11px;"
                    {{ $timesheetDatas->status == 2 ? 'disabled' : '' }}>
                    Reject
                </button>
            </a>
            {{-- Start hare --}}

            <a
                href="{{ url('/assignmentconfirmationotp?' . 'type=' . $debtors->type . '&&' . 'status=' . 1 . '&&' . 'assignmentgenerate_id=' . $debtors->assignmentgenerate_id . '&&' . 'debitid=' . $debtors->id) }}">Accept
            </a>
            <a
                href="{{ url('/assignmentconfirmationotp?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}">refuse
            </a>

            <a href="{{ url('/assignmentconfirmationotp?' . 'type=' . $debtors->type . '&&' . 'status=' . 1 . '&&' . 'assignmentgenerate_id=' . $debtors->assignmentgenerate_id . '&&' . 'debitid=' . $debtors->id) }}"
                style="padding: 8px 16px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; color: white; font-size: 20px; font-family: Inter; font-weight: 500; text-decoration: none; margin-right: 10px;">
                Accept
            </a>

            <a href="{{ url('/assignmentconfirmationotp?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}"
                style="padding: 8px 16px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; color: white; font-size: 20px; font-family: Inter; font-weight: 500; text-decoration: none;">
                Refuse
            </a>

            <a style="margin-left: 10px;color:#7a7a7a;"
                onclick="return confirm('Are you sure you want to delete this folder?');"
                href="{{ url('assignmentfolderdelete', $assignmentfolderData->id) }}"
                class="dropdown-item">Delete</a>

            <a href="{{ route('zipfolder', ['assignmentgenerateid' => $assignmentfolder[0]->assignmentgenerateid]) }}"
                class="btn btn-secondary"
                onclick="return confirm('Are you sure you want to download all folders totaling {{ $totalFileSizeMB > 1024 ? round($totalFileSizeMB / 1024, 2) . ' GB' : $totalFileSizeMB . ' MB' }}?');"
                style="color:white;">Download</a>

            <tbody>
                @foreach ($assignmentmappingData as $assignmentmappingDatas)
                    <tr>
                        <td> <a
                                href="{{ url('/yearwise?' . 'year=' . $assignmentmappingDatas->year . '&&' . 'clientid=' . $id) }}"><i
                                    class="far fa-calendar"></i> <b>FY
                                    {{ $assignmentmappingDatas->year }}</b>
                            </a>
                        </td>
                    </tr>
                    <td> <a href="{{ url('holiday/delete', $holidayDatas->id) }}"
                            class="btn btn-info-soft btn-sm"><i class="fa fa-trash"></i></a>
                    </td>
                    <a href="{{ route('holiday.edit', $holidayDatas->id) }}">
                        {{ $holidayDatas->holidayname }}</a>
                @endforeach
            </tbody>



            <tbody>
                @foreach ($assignmentmappingData as $assignmentmappingDatas)
                    <tr>
                        <td> <a
                                href="{{ url('/yearwise?' . 'year=' . $assignmentmappingDatas->year . '&&' . 'clientid=' . $id) }}"><i
                                    class="far fa-calendar"></i> <b>FY
                                    {{ $assignmentmappingDatas->year }}</b></a></td>
                    </tr>
                @endforeach
            </tbody>
            {{-- * redirection in javascript / setTimeout function   --}}

            if (!shouldContinue) {
            // Redirect to a specific URL when the user clicks Cancel
            window.location.href = "{{ url('/teammember') }}";
            window.location.href = '{{ route('home') }}';

            setTimeout(function() {
            // Redirect to the desired route
            window.location.href = "{{ url('/teammember') }}";
            }, 1000);
            return;
            }
            {{-- * serial number /S.N / sereal number /  sereal number    --}}

            @php
                $serialNumber = 1;
            @endphp

            @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                <tr>
                    <td style="display: none;">{{ $applyleaveDatas->id }}</td>
                    <td>{{ $serialNumber++ }}</td>
                    {{-- * td width increase ior decrease   --}}
                    <td>
                        <div style="width: 11rem;">{{ $applyleaveDatas->reasonleave ?? '' }}
                        </div>
                    </td>
                </tr>
            @endforeach
            {{-- * filtering functionality / regarding filter / filter functionality   --}}

            {{-- filtering functionality using div layout with search 28-08-24 --}}
            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent

                {{-- filtering functionality --}}
                <form method="get" action="{{ url('adminsearchtimesheet') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Teammember Filter -->
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="form-group">
                                <strong><label for="teammemberId">Employee Name</label></strong>
                                <select class="language form-control" id="teammemberId" name="teammemberId">
                                    <option value="">Please Select One</option>
                                    @php
                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($teammembers as $teammember)
                                        @if (!in_array($teammember->staffcode, $displayedValues))
                                            <option value="{{ $teammember->id }}"
                                                {{ old('teammemberId') == $teammember->id ? 'selected' : '' }}>
                                                {{ $teammember->team_member }}
                                                ({{ $teammember->newstaff_code ?? ($teammember->staffcode ?? '') }})
                                            </option>
                                            @php
                                                $displayedValues[] = $teammember->staffcode;
                                            @endphp
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Start Date Filter -->
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="form-group">
                                <strong><label for="startdate">Start Date <span
                                            class="text-danger">*</span></label></strong>
                                <input required type="date" class="form-control" id="startdate" name="startdate"
                                    value="{{ old('startdate') }}">
                            </div>
                        </div>

                        <!-- End Date Filter -->
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="form-group">
                                <strong><label for="enddate">End Date <span
                                            class="text-danger">*</span></label></strong>
                                <input type="date" class="form-control" id="enddate" name="enddate"
                                    value="{{ old('enddate') }}">
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="form-group">
                                <label for="search">&nbsp;</label>
                                <button type="submit" class="btn btn-success btn-block">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- filtering functionality using div layout with search  --}}
            <div class="container">
                <form method="get" action="{{ url('totaltimeshow/filter') }}" enctype="multipart/form-data"
                    class="form-inline">
                    @csrf
                    @php
                        $distinctteammember = $teammemberDatas->unique('team_member')->sortBy('team_member');
                        // dd($distinctteammember);
                        $distinctassignmentid = $teammemberDatas
                            ->unique('assignmentgenerate_id')
                            ->sortBy('assignmentgenerate_id');
                        $distinctAssignmentNames = $teammemberDatas->unique('assignmentname')->sortBy('assignmentname');
                    @endphp
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <strong><label for="employee">Teammember</label></strong>
                                <select class="language form-control" id="employee" name="employee">
                                    <option value="">Please Select One</option>
                                    @foreach ($distinctteammember as $teammemberData)
                                        <option value="{{ $teammemberData->teamid }}">
                                            {{ $teammemberData->team_member }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <strong><label for="assignmentgenerateid">Assignment Id</label></strong>
                                <select class="language form-control" id="assignmentgenerateid"
                                    name="assignmentgenerateid">
                                    <option value="">Please Select One</option>
                                    @foreach ($distinctassignmentid as $teammemberData)
                                        <option value="{{ $teammemberData->assignmentgenerate_id }}">
                                            {{ $teammemberData->assignmentgenerate_id }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <strong><label for="assignmentname">Assignment</label></strong>
                                <select class="language form-control" id="assignmentname" name="assignmentname">
                                    <option value="">Please Select One</option>
                                    @foreach ($distinctAssignmentNames as $teammemberData)
                                        <option value="{{ $teammemberData->assignmentname }}">
                                            {{ $teammemberData->assignmentname }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <strong><label for="search">&nbsp;</label></strong>
                                {{-- <strong><label for="search">Action</label></strong> --}}
                                <button type="submit" class="btn btn-success btn-block">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- filtering functionality using div layout --}}

            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <strong><label for="employee">Employee</label></strong>
                            <select class="language form-control" id="employee1" name="employee">
                                <option value="">Please Select One</option>
                                @php
                                    $displayedValues = [];
                                @endphp
                                @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                    @if (!in_array($applyleaveDatas->emailid, $displayedValues))
                                        <option value="{{ $applyleaveDatas->createdby }}">
                                            {{ $applyleaveDatas->team_member }}
                                            ({{ $applyleaveDatas->emailid }})
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
                                @foreach ($teamapplyleaveDatas as $applyleaveDatas)
                                    @if (!in_array($applyleaveDatas->name, $displayedValues))
                                        <option value="{{ $applyleaveDatas->leavetype }}">
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
                                @foreach ($teamapplyleaveDatas as $applyleaveDatas)
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
                            <input type="date" class="form-control startclass" id="start1" name="start">
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <strong> <label class="font-weight-600">End Request Date</label></strong>
                            <input type="date" class="form-control endclass" id="end1" name="end">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <strong><label class="font-weight-600">Start Leave Period</label></strong>
                            <input type="date" class="form-control startclass" id="startperiod1"
                                name="startperiod">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <strong> <label class="font-weight-600">End Leave Period</label></strong>
                            <input type="date" class="form-control endclass" id="endperiod1" name="endperiod">
                        </div>
                    </div>
                    <div class="col-2" id="clickExcell" style="display: none;">
                        <div class="form-group" style="position: relative; top: 29px;">
                            <button class="btn btn-success">Download</button>
                        </div>
                    </div>

                    {{-- style="display: none; float:right;position: relative; top: -42px;" --}}
                </div>
            </div>

            <script>
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
                                    '<td>' + createdAt + '</td>' +
                                    '<td>' + getStatusBadge(item.status) + '</td>' +
                                    '<td>' + item.name + '</td>' +
                                    '<td>' + fromDate + ' to ' + toDate + '</td>' +
                                    '<td>' + holidays + '</td>' +
                                    '<td>' + item.approvernames + '</td>' +
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
                                Date_of_Request: createdAt,
                                status: getStatusText(item.status),
                                Leave_Type: item.name,
                                from: fromDate,
                                to: toDate,
                                Days: holidays,
                                Approver: item.approvernames,
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
            </script>

            {{-- filtering functionality using table layout --}}
            <form method="post" action="{{ url('searchingtimesheet') }}" enctype="multipart/form-data"
                class="form-inline">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Teamid</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style=" background-color: white;">
                            <td>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="start" name="start">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="date" class="form-control" id="end" name="end">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    @php

                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($timesheetData as $timesheetDatas)
                                        @if (!in_array($timesheetDatas->createdby, $displayedValues))
                                            <input type="text" class="form-control" id="teamid"
                                                name="teamid" value="{{ $timesheetDatas->createdby }}">
                                            @php
                                                $displayedValues[] = $timesheetDatas->createdby;
                                            @endphp
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                {{-- ! get year digit only  --}}
                                <div class="form-group">
                                    <select class="language form-control" id="category7" name="year">
                                        <option value="">Please Select One</option>
                                        @php
                                            $displayedYears = [];
                                        @endphp
                                        @foreach ($timesheetData as $timesheetDatas)
                                            @php
                                                $year = \Carbon\Carbon::parse($timesheetDatas->date)->year;
                                            @endphp
                                            @if (!in_array($year, $displayedYears))
                                                <option value="{{ $year }}">
                                                    {{ $year }}
                                                </option>
                                                @php
                                                    $displayedYears[] = $year;
                                                @endphp
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success">Search</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

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
                                {{-- <div class="form-group">
                                              <select class="language form-control" id="year" name="year">
                                                  <option value="">Please Select One</option>
                                                  <option value="2024">2024</option>
                                                  <option value="2023">2023</option>
                                              </select>
                                          </div> --}}
                                <div class="form-group">
                                    <select class="language form-control" id="year" name="year">
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
                                    <input type="date" class="form-control" id="startdate" name="startdate"
                                        value="{{ old('startdate') }}">
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



            {{-- filtering functionality --}}

            {{-- ! runnig for patner --}}
            {{-- <div class="row row-sm">
                          <div class="col-2">
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

                              </div>
                          </div>

                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">Start Date</label>
                                  <input type="date" class="form-control" id="start" name="start">

                              </div>
                          </div>
                          <div class="col-2">
                              <div class="form-group">
                                  <label class="font-weight-600">End Date</label>
                                  <input type="date" class="form-control" name="end" id="end">
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
                      </div> --}}
            <div class="row row-sm">
                <div class="col-3">
                    <div class="form-group">
                        <label class="font-weight-600">Team Name</label>
                        <select class="language form-control" id="category7" name="teamname">
                            <option value="">Please Select One</option>
                            @php

                                $displayedValues = [];
                            @endphp
                            @foreach ($get_date as $jobDatas)
                                @if (!in_array($jobDatas->team_member, $displayedValues))
                                    <option value="{{ $jobDatas->teamid }}">
                                        {{ $jobDatas->team_member }}
                                    </option>
                                    @php
                                        $displayedValues[] = $jobDatas->team_member;
                                    @endphp
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="col-3">
                    <div class="form-group">
                        <label class="font-weight-600">Start Date</label>
                        <input type="date" class="form-control" id="start" name="start">

                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label class="font-weight-600">End Date</label>
                        <input type="date" class="form-control" name="end" id="end">
                    </div>
                </div>
                {{-- <div class="col-3">
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
                {{-- <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Partner</label>
                                <select class="language form-control" id="category1" name="partnersearch">
                                    <option value="">Please Select One</option>
                                    @php
                                        $displayedValues = [];
                                    @endphp
                                    @foreach ($get_date as $jobDatas)
                                        @if (!in_array($jobDatas->partnername, $displayedValues))
                                            <option value="{{ $jobDatas->partnerid }}">
                                                {{ $jobDatas->partnername }}
                                            </option>
                                            @php
                                                $displayedValues[] = $jobDatas->partnername;
                                            @endphp
                                        @endif
                                    @endforeach
                                </select> --}}

                {{-- <select class="language form-control" id="category1" name="partnersearch">
                                  <option value="">Please Select One</option>
                                  @foreach ($partner as $teammemberData)
                                      <option value="{{ $teammemberData->id }}">
                                          {{ $teammemberData->team_member }}
                                      </option>
                                  @endforeach
                              </select> --}}
                {{-- 
                            </div>
                        </div> --}}
            </div>




            {{-- * condition on foreach loop / outside of foreach loop / notification / message   --}}

            @php
                $hasUnreadNotification = false;
                foreach ($clientnotification as $clientnotificationdata) {
                    if ($clientnotificationdata->readstatus == 0) {
                        $hasUnreadNotification = true;
                        break;
                    }
                }
            @endphp

            <li class="nav-item dropdown notification">
                <a class="nav-link dropdown-toggle {{ $hasUnreadNotification ? 'badge-dot' : '' }}" href="#"
                    data-toggle="dropdown">
                    <i class="typcn typcn-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <h6 class="notification-title">Notifications</h6>
                    <p class="notification-text">You have {{ count($clientnotification) }} unread notification</p>
                    <div class="notification-list">
                        @foreach ($clientnotification as $clientnotificationdata)
                            <div class="media new">
                                <a href="{{ url('notification/' . $clientnotificationdata->id) }}"
                                    style="color: {{ $clientnotificationdata->readstatus == 1 ? 'Black' : 'red' }}">
                                </a>
                            </div>
                            <!--/.media -->
                        @endforeach

            </li>


            {{-- * table heading hide / action hide / any column hide according condition    --}}

            <thead>
                <tr>
                    <th>Date of Request</th>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Approver</th>
                    <th>Reason for Leave</th>
                    <th> Leave Period</th>
                    <th>Days</th>
                    <th>Status</th>
                    @foreach ($myapplyleaveDatas as $applyleaveDatas)
                        @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
                            <th>Action</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            @foreach ($myapplyleaveDatas as $applyleaveDatas)
                <td>
                    @if ($applyleaveDatas->status == 0)
                        <span class="badge badge-pill badge-warning">Created</span>
                    @elseif($applyleaveDatas->status == 1)
                        <span class="badge badge-success">Approved</span>
                    @elseif($applyleaveDatas->status == 2)
                        <span class="badge badge-danger">Rejected</span>
                    @endif
                </td>
                <td>
                    @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
                        <button class="btn btn-danger" data-toggle="modal"
                            style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                            data-target="#requestModal{{ $applyleaveDatas->id }}">Request</button>
                    @endif
                </td>
            @endforeach



            {{-- * excell and pdf download / table asc and desc order   --}}

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
                            [2, "desc"]
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

            <script>
                $(document).ready(function() {
                    $('#examplee').DataTable({
                        "pageLength": 30,
                        dom: 'Bfrtip',
                        "order": [
                            [1, "asc"]
                        ],

                        buttons: [

                            {
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
                                exportOptions: {
                                    columns: [0, 1, 2, 5]
                                }
                            },
                            'colvis'
                        ]
                    });
                });
            </script>
            {{-- hide excell button ya othser button --}}
            <script>
                $(document).ready(function() {
                    $('#examplee').DataTable({
                        "pageLength": 10,
                        "dom": 'Bfrtip',
                        "order": [
                            [1, "desc"]
                        ],

                        buttons: [{
                            extend: 'excelHtml5',
                            exportOptions: {
                                columns: ':visible'
                            },
                            text: 'Export to Excel',
                            className: 'btn-excel',
                        }, ]
                    });

                    $('.btn-excel').hide();
                });
            </script>
            {{-- * first element   --}}
            <td>
                @if ($applyleaveDatas->leavetype == 11 && $applyleaveDatas->status == 1 && $loop->first)
                    <button class="btn btn-danger" data-toggle="modal"
                        style="height: 16px; width: auto; border-radius: 7px; display: flex; align-items: center; justify-content: center;font-size: 11px;"
                        data-target="#requestModal{{ $applyleaveDatas->id }}">Request</button>
                @endif
            </td>
            {{-- * 2 column in one row  --}}

            <tr>
                <td><b>Leave : </b></td>
                <td>{{ $applyleave->name }}</td>
                <td><b>Raised By :</b></td>
                <td>{{ $applyleave->team_member }}</td>
            </tr>
            {{-- * persentage display   --}}

            <td>

                @php
                    $totalFields = 26; // 30 column
                    $filledFields = 0;

                    $filledFields += !empty($teammemberData->id) ? 1 : 0;
                    $filledFields += !empty($teammemberData->team_member) ? 1 : 0;
                    $filledFields += !empty($teammemberData->profilepic) ? 1 : 0;
                    $filledFields += !empty($teammemberData->staffcode) ? 1 : 0;
                    $filledFields += !empty($teammemberData->role->rolename) ? 1 : 0;
                    $filledFields += !empty($teammemberData->designation) ? 1 : 0;
                    $filledFields += !empty($teammemberData->mobile_no) ? 1 : 0;
                    $filledFields += !empty($teammemberData->dateofbirth) ? 1 : 0;
                    $filledFields += !empty($teammemberData->joining_date) ? 1 : 0;
                    $filledFields += !empty($teammemberData->department) ? 1 : 0;
                    $filledFields += !empty($teammemberData->emailid) ? 1 : 0;
                    $filledFields += !empty($teammemberData->personalemail) ? 1 : 0;
                    $filledFields += !empty($teammemberData->communicationaddress) ? 1 : 0;
                    $filledFields += !empty($teammemberData->permanentaddress) ? 1 : 0;
                    $filledFields += !empty($teammemberData->adharcardnumber) ? 1 : 0;
                    $filledFields += !empty($teammemberData->aadharupload) ? 1 : 0;
                    $filledFields += !empty($teammemberData->pancardno) ? 1 : 0;
                    $filledFields += !empty($teammemberData->panupload) ? 1 : 0;
                    $filledFields += !empty($teammemberData->emergencycontactnumber) ? 1 : 0;
                    $filledFields += !empty($teammemberData->nameofbank) ? 1 : 0;
                    $filledFields += !empty($teammemberData->bankaccountnumber) ? 1 : 0;
                    $filledFields += !empty($teammemberData->ifsccode) ? 1 : 0;
                    $filledFields += !empty($teammemberData->mothername) ? 1 : 0;
                    $filledFields += !empty($teammemberData->mothernumber) ? 1 : 0;
                    $filledFields += !empty($teammemberData->cancelcheque) ? 1 : 0;
                    $filledFields += !empty($teammemberData->fathername) ? 1 : 0;
                    $filledFields += !empty($teammemberData->fathernumber) ? 1 : 0;

                    $profileCompletionPercentage = ($filledFields / $totalFields) * 100;
                    $formattedProfileCompletion = number_format($profileCompletionPercentage, 2);
                @endphp
                @if ($formattedProfileCompletion == 100)
                    <span class="badge badge-pill badge-success"
                        style="width: 71px;
            height: 26px;
            font-size: 17px;">{{ $formattedProfileCompletion }}</span>
                @else
                    <span class="badge badge-pill badge-danger"
                        style="width: 71px;
            height: 26px;
            font-size: 17px;">{{ $formattedProfileCompletion }}</span>
                @endif
            </td>
            {{-- * badge  --}}
            <td>
                @if ($timesheetrequestsData->status == 0)
                    <span class="badge badge-pill badge-warning">Created</span>
                @elseif($timesheetrequestsData->status == 1)
                    <span class="badge badge-pill badge-success">Approved</span>
                @else
                    <span class="badge badge-pill badge-danger">Rejected</span>
                @endif
            </td>
            {{-- * direct mail    --}}

            <td><a href="mailto:{{ $teammemberData->emailid }}">{{ $teammemberData->emailid ?? '' }}</a>
            </td>
            {{-- * get data from database   --}}

            <td>{{ App\Models\Teammember::select('team_member')->where('id', $applyleave->approver)->first()->team_member ?? '' }}
            </td>
            {{-- * holiday routes   --}}
            {{-- Route::resource('/holiday', HolidayController::class);
    
    above route related it and this anchor tag hit edit function in resource route
    <a href="{{ route('holiday.edit', $holidayDatas->id) }}">{{ $holidayDatas->holidayname }}</a> --}}


            {{--
        Route::get('/holidays', [HolidayController::class, 'holidays']);
        Route::get('holiday/delete/{id}', [HolidayController::class, 'destroy']); --}}
            <tbody>
                @foreach ($holidayDatas as $holidayDatas)
                    <tr>
                        <td style="display: none;">{{ $holidayDatas->id }}</td>
                        <td>
                            @if (Auth::user()->role_id == 18 || Auth::user()->role_id == 11)
                                <a href="{{ route('holiday.edit', $holidayDatas->id) }}">
                                    {{ $holidayDatas->holidayname }}</a>
                            @else
                                {{ $holidayDatas->holidayname }}
                            @endif
                        </td>
                        <td>{{ date('F d,Y', strtotime($holidayDatas->startdate)) }}</td>

                        @if (Auth::user()->role_id == 18)
                            <td> <a href="{{ url('holiday/delete', $holidayDatas->id) }}"
                                    class="btn btn-info-soft btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                        @endif

                    </tr>
                @endforeach
            </tbody>

            {{-- * button in select box/ select box button /   --}}
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item">
                    <div class="btn-group mb-2 mr-1">
                        <button type="button" class="btn btn-info-soft btn-sm dropdown-toggle"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Choose Year
                        </button>
                        <div class="dropdown-menu">
                            <a style="color: #37A000" class="dropdown-item"
                                href="{{ url('/holidays?' . 'year=' . '2023') }}">2023</a>
                            <a style="color: #37A000" class="dropdown-item"
                                href="{{ url('/holidays?' . 'year=' . '2022') }}">2022</a>


                        </div>
                    </div>
                </li>
                {{-- For hr  --}}
                @if (Auth::user()->role_id == 18)
                    <li class="breadcrumb-item"><a href="{{ url('holiday/create') }}">Add Holidays</a></li>
                    <li class="breadcrumb-item active">+</li>
                @endif
            </ol>

            {{-- * check days ant time  --}}

            @if (
                (now()->isSunday() && now()->hour >= 18) ||
                    now()->isMonday() ||
                    now()->isTuesday() ||
                    now()->isWednesday() ||
                    now()->isThursday() ||
                    now()->isFriday() ||
                    (now()->isSaturday() && now()->hour <= 18))
            @endif
            {{-- *   --}}

            {{-- * dd with mesaage/ check dd output    --}}
            dd('hi', $previoussavechck);

            {{-- *  regarding warning message/ regarding message/ regarding success message --}}
            {{-- start hare --}}
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            {{-- start hare --}}
            if ($request->status == $usermail->status) {
            return back()->withErrors(['error' => 'You have allready Submitted'])->withInput();
            }

            @if ($errors->any())
                <div class="alert alert-danger">
                    {{-- <ul> --}}
                    @foreach ($errors->all() as $error)
                        {{-- <li>{{ $error }}</li> --}}
                        <p>{{ $error }}</p>
                    @endforeach
                    {{-- </ul> --}}
                </div>
            @endif
            {{-- start hare --}}
            @if ($errors->any())
                {{-- <div class="alert alert-danger"> --}}
                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach
                {{-- </div> --}}
            @endif
            d-flex align-items-center justify-content-center text-center h-100vh
            bg-white
            backEnd/image/unnamed.jpg'
            {{-- * model rule / $fillable  --}}
            model
            protected $table = "assignmentteammappings";
            protected $fillable = [
            'status',
            ];

            {{-- * mailtrap config  --}}

            MAIL_MAILER=smtp
            MAIL_HOST=smtp.mailtrap.io
            MAIL_PORT=2525
            MAIL_USERNAME=2250e92771fcb7
            MAIL_PASSWORD=ac27bd097eacaa
            MAIL_ENCRYPTION=tls
            MAIL_FROM_ADDRESS=kgsomani@gmail.com
            MAIL_FROM_NAME="${APP_NAME}"


            {{-- * name route / route name --}}
            Route::resource('form', RegisterController::class)->names([
            'index' => 'addUser.index',
            'create' => 'addUser.create',
            'store' => 'addUser.store',
            'show' => 'addUser.show',
            'edit' => 'addUser.edit',
            'update' => 'addUser.update',
            'destroy' => 'addUser.destroy',
            ]);

            {{-- * modal box / regarding model box / regarding popup box / regarding pop up box    --}}
            {{-- ? model box 1 --}}

            <button style="margin-left:11px;height: 35px;" data-toggle="modal" data-target="#exampleModal14"
                class="btn btn-danger">
                Reject</button>

            <div class="modal fade" id="exampleModal14" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel4" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form id="detailsForm" method="post" action="" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add Team
                                    Member</h5>
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
                                            <label class="font-weight-600">Name</label>
                                            <select class="language form-control" id="exampleFormControlSelect1"
                                                name="teammember_id">
                                                {{-- <option value="">Please Select One</option>
                                        @foreach ($teammemberall as $teammemberData)
                                            <option value="{{ $teammemberData->id }}">
                                                {{ $teammemberData->team_member }}
                                                ({{ $teammemberData->staffcode }})
                                            </option>
                                        @endforeach --}}
                                            </select>
                                            <input type="text" hidden name="assignmentmapping_id"
                                                value="" class=" form-control"
                                                placeholder="Enter Client Name">
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label class="font-weight-600">Type</label>
                                            <select class="form-control key" id="key" name="type">
                                                <option value="">Please Select One</option>
                                                <option value="0">Team Leader</option>
                                                <option value="2">Staff</option>
                                            </select>
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
            {{-- ? model box 1 --}}

            <button style="margin-left:11px;height: 35px;" data-toggle="modal" data-target="#exampleModal12"
                class="btn btn-danger">
                Reject</button>

            <!-- Small modal -->
            <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel4" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background:#37A000">
                            <h5 style="color: white" class="modal-title font-weight-600" id="exampleModalLabel1">
                                Reason
                                For
                                Rejection</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form method="post" action="{{ url('applyleave/update', $applyleave->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row row-sm">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <textarea rows="6" name="remark" class="form-control" placeholder=""></textarea>
                                            <input hidden type="text" id="example-date-input" name="status"
                                                value="2" class="form-control" placeholder="Enter Location">
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <button type="submit" style="float: right" class="btn btn-success">Save </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ? model box 2 --}}
            <div class="row">
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal">
                        Launch demo modal
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                {{-- modal-body --}}
                                <div class="modal-body">

                                    <div>
                                        <label for="">Name</label>
                                        <input type="text" class="form-control">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ? model box 3 --}}
            <a id="editCompanyyyy" data-toggle="modal" data-id="{{ $timesheetrequestsData->id }}"
                data-target="#exampleModal112" title="Send Reminder">
                <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
            </a>

            {{-- request reminder modal --}}
            <div class="modal fade" id="exampleModal112" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel4" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">

                        <div class="modal-header" style="background: #218838;">
                            <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">
                                Request
                                Reminder
                                list</h5>
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
                            <div class="table-responsive">
                                <table id="reminderTable"
                                    class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Reminder Count</th>
                                            <th>Last Reminder Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="timesheetTableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a class="btn btn-success sendReminderBtn"> Send Reminder</a>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ? model box 4 --}}

            <td>
                @if ($clientdebitdata->status == 0)
                    <span class="badge badge-pill badge-danger">Not Confirmed</span>
                @elseif($clientdebitdata->status == 2)
                    <span class="badge badge-pill badge-Warning">Draft</span>
                @elseif($clientdebitdata->status == 3)
                    <a href="{{ url('pending/mail', $clientdebitdata->id) }}"
                        onclick="return confirm('Are you sure you want to send notification?');">
                        <span class="badge badge-pill badge-info">Pending</span></a>
                @else
                    <span class="badge badge-pill badge-success">Confirmed</span>
                @endif
            <td>
                <a class="editCompanyyyy" data-toggle="modal" data-id="{{ $clientdebitdata->id }}"
                    data-target="#exampleModal112{{ $loop->index }}" title="Send Reminder">
                    <span class="typcn typcn-bell" style="font-size: large;color: green;"></span>
                </a>
            </td>

            {{-- asa request reminder modal --}}
            <div class="modal fade" id="exampleModal112{{ $loop->index }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLabel4" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" style="background: #218838;">
                            <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">
                                Send
                                Reminder
                                list</h5>
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $e)
                                        <li style="color:red;">{{ $e }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="reminderTable"
                                    class="table display table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="background-color: #b6acae;">
                                            <th>Reminder Count</th>
                                            <th>Last Reminder Date</th>
                                        </tr>
                                    </thead>
                                    <tbody id="timesheetTableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url('pending/mail', $clientdebitdata->id) }}"
                                class="btn btn-success sendReminderBtn"> Send
                                Reminder</a>
                        </div>

                    </div>
                </div>
            </div>
            </td>

            {{-- ? model box 3 --}}
            {{-- ? model box 3 --}}
            {{-- ? model box 3 --}}
            {{-- ? model box 3 --}}

            {{-- * remove dublication / reapet data / dublicate data --}}

            1.use ->distinct()->get();
            2. below code
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









            {{-- * <!-- image open through link / storage image --> --}}
            // !runnig code download image
            // public function downloadAll(Request $request)
            // {

            // $articlefiles = DB::table('assignmentfolderfiles')->where('createdby', auth()->user()->id)->first();

            // return response()->download(('backEnd/image/articlefiles/' . $articlefiles->filesname));
            // }


            {{-- * <!-- image open through link / storage image --> --}}
            zip download in laravel
            {{-- public function download()
    {
        $zip = new ZipArchive();
        $file_name = 'shahid.zip';

        if ($zip->open(storage_path($file_name), ZipArchive::CREATE) == true) {
            // Adjust the path to your storage folder
            $files = File::files(storage_path('app\public\image\task'));
            if (count($files) > 0) {
                foreach ($files as $key => $value) {
                    $relativeName = basename($value);
                    $zip->addFile($value, $relativeName);
                }
                $zip->close();
                return response()->download(storage_path($file_name));
            }
        }
    } --}}



            {{-- * <!-- image open through link / storage image --> --}}
            <div class="table-responsive">
                <table id="examplee" class="table display table-bordered table-striped table-hover basic">
                    <thead>
                        <tr>
                            <th>Particular</th>
                            <th>File</th>
                            <th>Created By</th>
                            <th>Date</th>
                            @if ($assignmentbudgeting->status == 1)
                                <th>Action</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignmentfolderfile as $assignmentfolderData)
                            <tr>

                                <td>{{ $assignmentfolderData->particular }}</td>
                                <td>
                                    <a target="_blank"
                                        href="{{ asset('storage/image/task/' . $assignmentfolderData->filesname) }}">
                                        {{ $assignmentfolderData->filesname ?? '' }}
                                    </a>
                                </td>
                                <td>{{ $assignmentfolderData->team_member }} (
                                    {{ $assignmentfolderData->staffcode }}
                                    )</td>
                                <td>{{ date('F d,Y', strtotime($assignmentfolderData->created_at)) }}
                                    {{ date('h:i A', strtotime($assignmentfolderData->created_at)) }} </td>
                                @if ($assignmentbudgeting->status == 1)
                                    <td> <a href="{{ url('/bulkfile/delete/' . $assignmentfolderData->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                            class="btn btn-danger-soft btn-sm"><i class="far fa-trash-alt"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- * <!-- Modal for success message --> --}}
            <div class="modal fade" id="successModal" tabindex="-1" role="dialog"
                aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="successModalLabel">Success</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Display success message here -->
                            <p id="successMessage"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Display success message for user -->
            @if (session('message'))
                <script>
                    // Set the success message to the modal content
                    document.getElementById('successMessage').innerText = "{{ session('message') }}";

                    // Show the modal
                    $('#successModal').modal('show');
                </script>
            @endif


            {{-- * <!-- Modal for success message --> --}}
            @if (Auth::user()->role_id == 13 ||
                    $assignmentbudgetingDatas->type == 0 ||
                    $assignmentbudgetingDatas->status == 1 ||
                    ($assignmentbudgetingDatas->type != 0 && $assignmentbudgetingDatas->status == 0))
                <div class="row">

                    {{-- sucess message --}}
                    <div id="successModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                {{-- <div class="modal-header">
                <h5 class="modal-title">Success Message</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div> --}}
                                <div class="modal-body">
                                    <p id="successMessage"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2);height:250px;">
                            <div class="card-body">

                                <div class="card-head">
                                    <b>UDIN List</b>
                                    @if (
                                        (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                            (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                        <a data-toggle="modal" data-target="#exampleModal12"
                                            style="float:right;width:20px;"><img
                                                src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                                    @endif
                                </div>
                                <hr>
                                <div class="table-responsive example">
                                    <table class="table display table-bordered table-striped table-hover ">
                                        <thead>
                                            <tr>
                                                <th>UDIN</th>
                                                <th>Partner</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
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
                                                    <td>{{ $udinData->team_member }} (
                                                        {{ $udinData->rolename ?? '' }}
                                                        )</td>
                                                    <td>{{ date('d-m-Y', strtotime($udinData->created)) }},
                                                        {{ date('H:i A', strtotime($udinData->created)) }}</td>

                                                    @if (
                                                        (Auth::user()->role_id != 11 && $assignmentbudgetingDatas->type == 0 && $assignmentbudgetingDatas->status == 1) ||
                                                            (Auth::user()->role_id == 14 && $assignmentbudgetingDatas->status == 1))
                                                        <td>
                                                            <form
                                                                action="{{ route('uidindata.delete', ['id' => $udinData->udin]) }}"
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
            <!--Success message on Deleted end-->


            {{-- ###################################################################### --}}
            {{-- * get data from database in blade file --}}
            <div class="row">
                @foreach ($assignmentfolder as $assignmentfolderData)
                    {{-- three dot like .... --}}
                    <div class="col-md-6 col-lg-3">
                        @if ($assignmentfolderpermission->status == 1)
                            @if ($assignmentfolderData->createdby == Auth::user()->teammember_id || Auth::user()->role_id == 13)
                                <ul class="navbar-nav flex-row align-items-center ml-auto">
                                    <li class="nav-item dropdown user-menus">
                                        <a class="foldertoggle" style=" color:white" href="#"
                                            data-toggle="dropdown">
                                            <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                                            <i class="ti-more-alt"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a style="margin-left: 10px;color:#7a7a7a;" id="editCompany"
                                                data-toggle="modal" data-id="{{ $assignmentfolderData->id }}"
                                                data-target="#modaldemo1" class="dropdown-item">Edit Name</a>

                                            @if (DB::table('assignmentfolderfiles')->where('assignmentfolderfiles.assignmentfolder_id', $assignmentfolderData->id)->where('status', '1')->count() == 0)
                                                <a style="margin-left: 10px;color:#7a7a7a;"
                                                    onclick="return confirm('Are you sure you want to delete this folder?');"
                                                    href="{{ url('assignmentfolderdelete', $assignmentfolderData->id) }}"
                                                    class="dropdown-item">Delete</a>
                                            @endif
                                        </div>
                                        <!--/.dropdown-menu -->
                                    </li>
                                </ul>
                            @endif
                        @endif
                        <a href="{{ url('assignmentfolderfiles', $assignmentfolderData->id) }}">

                            <div class="p-2  text-white rounded mb-3 p-3 shadow-sm text-center"
                                style="background: @if ($loop->iteration % 2 == 0) #37A000; @else #06386A; @endif">
                                <div class="header-pretitle fs-11 font-weight-bold text-uppercase"
                                    style="color: white;font-size: 11px!important;">
                                    {{ strlen($assignmentfolderData->assignmentfoldersname) > 26 ? substr($assignmentfolderData->assignmentfoldersname, 0, 26) : $assignmentfolderData->assignmentfoldersname }}
                                </div>

                                <div class="fs-32 text-monospace">
                                    {{ DB::table('assignmentfolderfiles')->where('assignmentfolderfiles.assignmentfolder_id', $assignmentfolderData->id)->where('status', '1')->count() }}
                                </div>
                                <small>Data</small>

                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            {{-- ###################################################################### --}}
            {{-- * regarding excel --}}
            alt + enter to new line
            {{-- ###################################################################### --}}
            {{--  --------------------- 29 sep 2023 joining date--------------- --}}

</html>

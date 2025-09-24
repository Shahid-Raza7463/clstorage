{{-- selec input box style --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">
{{-- selec input box style end hare --}}

{{-- Datatable style --}}
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">
{{-- Datatable style end --}}

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Attendance Report</h1>
                    <small>Team Workbook List</small>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="card mb-4">
            <div class="card-body">
                @component('backEnd.components.alert')
                @endcomponent
                <div class="table-responsive">
                    <form method="post" action="{{ url('attendance-filter') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Teammember Filter -->
                            <div class="col-md-4 col-sm-6 mb-3">
                                <div class="form-group">
                                    <strong><label for="teammemberId">Employee Name <span
                                                class="text-danger">*</span></label></strong>
                                    <select required class="language form-control" id="teammemberId" name="teammemberId">
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
                                    <input required type="date" class="form-control" id="enddate" name="enddate"
                                        value="{{ old('enddate') }}">
                                </div>
                            </div>

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
                                <th style="display: none;">id</th>
                                <th>Employee Name</th>
                                <th>Staff Code</th>
                                <th>Role</th>
                                <th>Joinig Date</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>01</th>
                                <th>02</th>
                                <th>03</th>
                                <th>04</th>
                                <th>05</th>
                                <th>06</th>
                                <th>07</th>
                                <th>08</th>
                                <th>09</th>
                                <th>10</th>
                                <th>11</th>
                                <th>12</th>
                                <th>13</th>
                                <th>14</th>
                                <th>15</th>
                                <th>16</th>
                                <th>17</th>
                                <th>18</th>
                                <th>19</th>
                                <th>20</th>
                                <th>21</th>
                                <th>22</th>
                                <th>23</th>
                                <th>24</th>
                                <th>25</th>
                                <th>26</th>
                                <th>27</th>
                                <th>28</th>
                                <th>29</th>
                                <th>30</th>
                                <th>31</th>
                                <th>Total Number of days</th>
                                <th>Total Working days</th>
                                <th>Total Casual Leave</th>
                                <th>Total Exam Leave</th>
                                <th>Total Travel</th>
                                <th>Total Offholidays</th>
                                <th>Total Weekend</th>
                                <th>Total Holidays</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendanceDatas as $attendanceData)
                                <tr>
                                    {{-- @php
                                        dd($attendanceData);
                                    @endphp --}}
                                    <td style="display: none;">{{ $attendanceData->id }}</td>
                                    <td>{{ $attendanceData->team_member }}</td>
                                    {{-- <td class="text-center">
                                        {{ $attendanceData->newstaff_code ?? ($attendanceData->staffcode ?? '') }}</td> --}}
                                    <td class="text-center">{{ $attendanceData->final_staff_code }}</td>
                                    <td>{{ $attendanceData->rolename }}</td>
                                    {{-- <td> {{ $attendanceData->joining_date ? date('d-m-Y', strtotime($attendanceData->joining_date)) : 'NA' }}
                                    </td> --}}
                                    <td> {{ $attendanceData->final_rejoining_date ? date('d-m-Y', strtotime($attendanceData->final_rejoining_date)) : date('d-m-Y', strtotime($attendanceData->joining_date)) }}
                                    </td>
                                    <td> {{ $attendanceData->month }}</td>
                                    <td> {{ $attendanceData->year }}</td>
                                    <td> {{ $attendanceData->one ?? '…....' }}</td>
                                    <td> {{ $attendanceData->two ?? '…....' }}</td>
                                    <td> {{ $attendanceData->three ?? '…....' }}</td>
                                    <td> {{ $attendanceData->four ?? '…....' }}</td>
                                    <td> {{ $attendanceData->five ?? '…....' }}</td>
                                    <td> {{ $attendanceData->six ?? '…....' }}</td>
                                    <td> {{ $attendanceData->seven ?? '…....' }}</td>
                                    <td> {{ $attendanceData->eight ?? '…....' }}</td>
                                    <td> {{ $attendanceData->nine ?? '…....' }}</td>
                                    <td> {{ $attendanceData->ten ?? '…....' }}</td>
                                    <td> {{ $attendanceData->eleven ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twelve ?? '…....' }}</td>
                                    <td> {{ $attendanceData->thirteen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->fourteen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->fifteen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->sixteen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->seventeen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->eighteen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->ninghteen ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twenty ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentyone ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentytwo ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentythree ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentyfour ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentyfive ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentysix ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentyseven ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentyeight ?? '…....' }}</td>
                                    <td> {{ $attendanceData->twentynine ?? '…....' }}</td>
                                    <td> {{ $attendanceData->thirty ?? '…....' }}</td>
                                    <td> {{ $attendanceData->thirtyone ?? '…....' }}</td>

                                    <td class="text-center"> {{ $attendanceData->total_no_of_days ?? '0' }}</td>
                                    <td class="text-center"> {{ $attendanceData->no_of_days_present ?? '0' }}</td>
                                    <td class="text-center"> {{ $attendanceData->casual_leave ?? '0' }}</td>
                                    {{-- <td> {{ $attendanceData->sick_leave ?? '0' }}</td> --}}
                                    <td class="text-center"> {{ $attendanceData->exam_leave ?? '0' }}</td>
                                    <td class="text-center"> {{ $attendanceData->travel ?? '0' }}</td>
                                    <td class="text-center"> {{ $attendanceData->offholidays ?? '0' }}</td>
                                    <td class="text-center"> {{ $attendanceData->sundaycount ?? '0' }}</td>
                                    <td class="text-center"> {{ $attendanceData->holidays ?? '0' }}</td>
                                    {{-- <td> {{ $attendanceData->absent ?? '' }}</td> --}}
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

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            "order": [
                // [0, "desc"]
            ],
            columnDefs: [{
                targets: [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
                    21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38,
                    39, 40, 41, 42, 43
                ],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Attendance Report',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
            ]
        });
    });
</script>


{{-- Include jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var startDateInput = $('#startdate');
        var endDateInput = $('#enddate');

        // Function to compare start and end dates
        function compareDates() {
            var startDate = new Date(startDateInput.val());
            var endDate = new Date(endDateInput.val());

            if (startDate > endDate) {
                alert('End date should be greater than or equal to the Start date');
                endDateInput.val(''); // Clear the end date input
            }
        }

        // Function to validate the year length
        function validateYear(input) {
            var date = new Date(input.val());
            var year = date.getFullYear();

            if (year.toString().length > 4) {
                alert('Enter four digits for the year');
                input.val(''); // Clear the invalid date
            }
        }

        //   // Attach event listeners
        startDateInput.on('input', compareDates);
        endDateInput.on('blur', compareDates);

        startDateInput.on('change', function() {
            validateYear(startDateInput);
        });

        endDateInput.on('change', function() {
            validateYear(endDateInput);
        });
    });
</script>

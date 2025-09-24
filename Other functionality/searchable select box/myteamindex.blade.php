{{-- library  --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

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


<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $(this);
            var leaveDateValue = leaveDate.val();

            // Use a regular expression to match a four-digit year
            var yearPattern = /^\d{4}$/;

            if (!yearPattern.test(leaveDateValue)) {
                alert('Please enter a valid four-digit year');
                leaveDate.val('');
            }
        });
    });
</script>
{{-- multiple date ho ager ek hi page me tab --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $(this);
            var leaveDateValue = leaveDate.val();
            var leaveDateGet = new Date(leaveDateValue);
            var leaveyear = leaveDateGet.getFullYear();
            // console.log(startyear);
            var leaveyearLength = leaveyear.toString().length;
            if (leaveyearLength > 4) {
                alert('Enter four digits for the year');
                leaveDate.val('');
            }
        });
    });
</script>

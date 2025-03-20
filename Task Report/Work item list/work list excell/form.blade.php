{{-- Assignment budgetting start --}}
<div class="row row-sm">
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Client <span class="text-danger">*</span></label>
            <select required class="language form-control" id="exampleFormControlSelect1" name="client_id"
                @if (Request::is('assignmentmapping/*/edit')) > <option disabled style="display:block">Please Select One
                </option>
                @foreach ($clientss as $clientData)
                <option value="{{ $clientData->id }}"
                    {{ $assignmentbudgeting->client->id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                    {{ $clientData->client_name }}</option>
                @endforeach
                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($clientss as $clientData)
                <option value="{{ $clientData->id }}">
                    {{ $clientData->client_name }} </option>

                @endforeach @endif
                </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment <span class="text-danger">*</span></label>
            <select required class="form-control" id="exampleFormControlSelect1" name="assignment_id"
                @if (Request::is('assignmentmapping/*/edit')) > <option disabled style="display:block">Please Select One
                </option>

                @foreach ($assignment as $assignmentData)
                <option value="{{ $assignmentData->id }}"
                    {{ $assignmentbudgeting->assignment->id == $assignmentData->id ?? '' ? 'selected="selected"' : '' }}>
                    {{ $assignmentData->assignment_name }}</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($assignment as $assignmentData)
                <option value="{{ $assignmentData->id }}">
                    {{ $assignmentData->assignment_name }}</option>

                @endforeach @endif
                </select>
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Assignment Name <span class="text-danger">*</span></label>
            <input required type="text" name="assignmentname"
                value="{{ $assignmentbudgeting->assignmentname ?? '' }}" class=" form-control"
                placeholder="Enter Assignment Name">
        </div>
    </div>
    <div class="col-3">
        <div class="form-group">
            <label class="font-weight-600">Due Date <span class="text-danger">*</span></label>
            <input type="date" required id="example-date-input" name="duedate"
                value="{{ $assignmentbudgeting->date ?? '' }}" class=" form-control leaveDate" placeholder="Enter Date"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    {{-- <button type="submit" class="btn btn-success" style="float:right"> Submit</button> --}}
    {{-- <a class="btn btn-secondary" href="{{ url('assignmentbudgeting') }}">
        Back</a> --}}

</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600"> Period Start <span class="text-danger">*</span></label>
            <input type="date" required name="periodstart" id="startDate"
                value="{{ $assignmentmapping->periodstart ?? '' }}" class=" form-control"
                placeholder="Enter Period start">
        </div>
    </div>

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Period End <span class="text-danger">*</span></label>
            <input type="date" required name="periodend" id="endDate"
                value="{{ $assignmentmapping->periodend ?? '' }}" class=" form-control" placeholder="Enter Perio End">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Is Role Over Assignment</label>
            <select class="form-control" id="exampleFormControlSelect1" name="roleassignment">
                <option value="1">No</option>
                <option value="2">Yes</option>

            </select>
        </div>
    </div>
</div>
<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Est Hours <span class="text-danger">*</span></label>
            <input type="number" required name="esthours" value="{{ $assignmentmapping->esthours ?? '' }}"
                class=" form-control" placeholder="Enter Est Hours">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Std Cost <span class="text-danger">*</span></label>
            <input type="number" required name="stdcost" value="{{ $assignmentmapping->stdcost ?? '' }}"
                class=" form-control" placeholder="Enter Std Cost">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Est Cost <span class="text-danger">*</span></label>
            <input type="number" required name="estcost" value="{{ $assignmentmapping->estcost ?? '' }}"
                class=" form-control" placeholder="Enter Est Cost">
        </div>
    </div>

</div>
<div class="row row-sm">

    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Fees of The Asignment <span class="text-danger">*</span></label>
            <input type="number" required name="fees" value="{{ $assignmentmapping->fees ?? '' }}"
                class=" form-control" placeholder="Enter Fees of The Asignment">
        </div>
    </div>
</div>
<div class="field_wrapperpartner">
    <div class="row row-sm">
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Lead Partner <span class="text-danger">*</span></label>
                <select required class="language form-control" id="category" name="leadpartner"
                    @if (Request::is('client/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($partner as $teammemberData)
            <option value="{{ $teammemberData->id }}"
            @if ($client->leadpartner == $teammemberData->id) selected @endif>
                    {{ $teammemberData->team_member }}</option>
                    @endforeach
                @else
                    <option></option>
                    <option value="">Please Select One</option>
                    @foreach ($partner as $teammemberData)
                        <option value="{{ $teammemberData->id }}">
                            {{ $teammemberData->team_member }} (
                            {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }} )</option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-5">
            <div class="form-group">
                <label class="font-weight-600">Other Partner </label>
                <select class="language form-control" name="otherpartner"
                    @if (Request::is('client/*/edit')) > <option disabled
            style="display:block">Please Select One</option>

            @foreach ($partner as $teammemberData)
            <option value="{{ $teammemberData->id }}"
            @if ($client->leadpartner == $teammemberData->id) selected @endif>
                    {{ $teammemberData->team_member }}</option>
                    @endforeach
                @else
                    <option></option>
                    <option value="">Please Select One</option>
                    @foreach ($partner as $teammemberData)
                        <option value="{{ $teammemberData->id }}">
                            {{ $teammemberData->team_member }}
                            ({{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }})
                        </option>

                    @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_buttonnpartner" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>
</div>

<div class="field_wrapper">
    <div class="row row-sm">

        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-600">Name <span class="text-danger">*</span></label>
                <input type="checkbox" data-toggle="tooltip" id="enablebox" style="margin-left: 10px;"
                    title="You want to submit without teammember, please click on check box">
                <select required class="language form-control enablefalse" id="key" name="teammember_id[]">
                    <option value="">Please Select One</option>
                    @foreach ($teammember as $teammemberData)
                        <option value="{{ $teammemberData->id }}" @if (!empty($store->financial) && $store->financial == $teammemberData->id) selected @endif>
                            {{ $teammemberData->team_member }} ( {{ $teammemberData->rolename }} ) (
                            {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }} )</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="col-5">
            <div class="form-group">
                <label class="font-weight-600">Type <span class="text-danger">*</span></label>
                <select required class="form-control key enablefalse" id="key" name="type[]">
                    <option value="">Please Select One</option>
                    <option value="0">Team Leader</option>
                    <option value="2">Staff</option>
                </select>
            </div>
        </div>

        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_buttonn" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <button type="submit" id="submitButton" class="btn btn-success" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('assignmentmapping') }}">
        Back</a>

</div>

{{-- validation for date --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var startDateInput = $('#startDate');
        var endDateInput = $('#endDate');

        function compareDates() {
            var startDate = new Date(startDateInput.val());
            var endDate = new Date(endDateInput.val());

            if (startDate > endDate) {
                alert('End date should be greater than or equal to the Start date');
                endDateInput.val(''); // Clear the end date input
            }
        }

        startDateInput.on('input', compareDates);
        endDateInput.on('blur', compareDates);
    });
</script>

{{-- validation for year --}}
<script>
    $(document).ready(function() {
        $('#startDate').on('change', function() {
            var startclear = $('#startDate');
            var startDateInput1 = $('#startDate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearLength = startyear.toString().length;
            if (yearLength > 4) {
                alert('Enter four digits for the year');
                startclear.val('');
            }
        });
        $('#endDate').on('change', function() {
            var endclear = $('#endDate');
            var endDateInput1 = $('#endDate').val();
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

<script>
    $(document).ready(function() {
        $('.leaveDate').on('change', function() {
            var leaveDate = $('.leaveDate');
            var leaveDateValue = $('.leaveDate').val();
            console.log(leaveDateValue);
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
<script>
    const dateInput = document.querySelector('.dateInput'); // Select the element with the class 'dateInput'
    dateInput.addEventListener('change', function() {
        const selectedDate = new Date(this.value);
        const formattedDate =
            `${selectedDate.getDate()}-${selectedDate.getMonth() + 1}-${selectedDate.getFullYear()}`;
        this.value = formattedDate;
    });
</script>


{{-- <script>
    $(document).ready(function() {
        $('#enablebox').on('change', function() {
            $('.enablefalse').prop('disabled', this.checked);
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        $('#enablebox').on('change', function() {
            $('.enablefalse').prop('disabled', this.checked);
            if (this.checked) {
                $('.add_buttonn, .remove_button, .hidedive').addClass('d-none');
            } else {
                $('.add_buttonn, .remove_button, .hidedive').removeClass('d-none');
            }
        });
    });
</script>

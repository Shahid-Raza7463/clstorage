@if ($status == 0)
    <h3>Dear {{ $name ?? '' }} ,</h3>
    <br>
    <p>This email is to inform you that your Balance confirmation has been closed by OTP.</p>
    <p>The OTP is <b>{{ $otp }}</b>. Please enter this OTP in the Balance confirmation form to close your
        Balance confirmation.
    </p>

    <div>
        <span><b>Client Name :</b> </span><span>{{ $client_name }} ({{ $client_code }})</span>
    </div>
    <div>
        <span><b>Assignment Name :</b></span> <span>{{ $assignmentname }} ({{ $asassignmentsignmentid }})</span>
    </div>
@else
    <h3>Dear {{ $name ?? '' }} ,</h3>
    <br>
    <p>This email is to inform you that your Balance confirmation has been opend by OTP.</p>
    <p>The OTP is <b>{{ $otp }}</b>. Please enter this OTP in the Balance confirmation form to open your
        Balance confirmation.
    </p>

    <div>
        <span><b>Client Name :</b> </span><span>{{ $client_name }} ({{ $client_code }})</span>
    </div>
    <div>
        <span><b>Assignment Name :</b></span> <span>{{ $assignmentname }} ({{ $asassignmentsignmentid }})</span>
    </div>
@endif

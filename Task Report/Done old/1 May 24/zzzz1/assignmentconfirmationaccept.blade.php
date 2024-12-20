<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>K.G.Somani</title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            background-image: url('{{ asset('backEnd/image/unnamed.jpg') }}');
            /* Corrected URL and added missing closing parenthesis */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .otp-container {
            justify-content: flex-start;
            align-items: flex-start;
            gap: 12px;
            display: inline-flex;
        }


        /* .card {
            width: 400px;
            border: none;
            height: 300px;
            box-shadow: 0px 5px 20px 0px #d2dae3;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center
        } */

        .inputs input {
            width: 40px;
            height: 40px
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }
    </style> --}}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .custom-input-file {
            display: none;
        }

        .custom-input-file+label {
            display: inline-block;
            cursor: pointer;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    <style>
        body {
            background-image: url('{{ asset('backEnd/image/unnamed.jpg') }}');
            /* Corrected URL and added missing closing parenthesis */
            background-size: cover;
            background-repeat: no-repeat;
        }

        .otp-container {
            justify-content: flex-start;
            align-items: flex-start;
            gap: 12px;
            display: inline-flex;
        }

        /* zzz */
        .inputs input {
            width: 40px;
            height: 40px
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0
        }

        /* refuse page */
        .custom-file-upload {
            display: inline-block;
            cursor: pointer;
            color: white;
            border-radius: 15px;
        }

        /* Hide the default file input */
        #file-upload {
            display: none;
        }

        /* 2222222222222 */
        .custom-input-file {
            width: .1px;
            height: .1px;
            opacity: 0;
            outline: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .custom-input-file+label {
            text-overflow: ellipsis;
            white-space: nowrap;
            cursor: pointer;
            display: block;
            overflow: hidden;
            padding: 10px 20px;
            padding: .625rem 1.25rem;
            border: 1px solid #e0e6ed;
            border-radius: .25rem;
            color: #8492a6;
            background-color: #fff;
            outline: 0;
            margin: 0;
        }

        .custom-input-file+label i {
            width: 1em;
            height: 1em;
            vertical-align: middle;
            fill: currentColor;
            margin-top: -.25em;
            margin-right: .5em;
        }

        .disable {
            pointer-events: none;
            /* Prevent click events */
            opacity: 0.5;
            /* Make it look disabled */
        }
    </style>
</head>

<body>

    <div class="content-wrapper">
        <div class="main-content pt-1" id="contentdiv">
            <div style="float: right; margin-right:80px; margin-top: 4px;" class=" align-items-center">
                @php
                    $otpsettingstatus = 0;
                @endphp
                @if ($otpsettingstatus == 0)
                    <button class="btn btn-success" onclick="updateConfirmationStatus()">Accept</button>
                    {{-- <button class="btn btn-danger" data-toggle="modal" data-target="#rejectModalFinal">Refuse</button> --}}
                    <a href="{{ url('/otpskipconfirmation?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}"
                        class="btn btn-danger">
                        Refuse
                    </a>
                @else
                    <button class="btn btn-success" id="yesid" data-id="{{ $debtorid }}" data-status="1"
                        data-toggle="modal" data-target="#exampleModal1">Accept</button>

                    <button class="btn btn-danger" id="noid" data-id="{{ $debtorid }}" data-status="0"
                        data-toggle="modal" data-target="#exampleModal12">Refuse</button>
                @endif
            </div>
            <div id="printableArea">
                <div class="container py-5 h-100">
                    <div class="row justify-content-center align-items-center h-100">
                        <div class="col-12 col-lg-12 col-xl-12">
                            <div class="card shadow-2-strong card-registration">
                                <div class="card-body p-md-5">
                                    <div class="row">
                                        <div class="col-12  d-flex align-items-center justify-content-center">
                                            <span>
                                                <h2>Balance confirmation</h2>
                                            </span>
                                        </div>
                                        <div
                                            class="error-container col-12  d-flex align-items-center justify-content-center">
                                        </div>
                                        <div class="col-12  d-flex align-items-center justify-content-center">
                                            @if ($errors->any())
                                                <div>
                                                    @foreach ($errors->all() as $e)
                                                        <p style="color:red;">{{ $e }}
                                                        </p>
                                                    @endforeach
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            {!! $description ?? '' !!}
                                            {{-- @php
                                                dd($debtors);
                                            @endphp --}}
                                            <p><br /> <span
                                                    style="text-decoration: underline;"><strong>Confirmation</strong></span><br />
                                                <br />
                                                {{-- @if ($debtors->amounthidestatus == 1)
                                                    We confirm that in our books of account, the outstanding balance as
                                                    on {{ date('F d,Y', strtotime($debtors->date)) }} is
                                                    <span style="color: #ff6600;">Rs {{ $debtors->amount ?? '' }}</span>
                                                @else
                                                    We request you to provide the
                                                    @if ($debtors->type == 1)
                                                        <span>Debtor</span>
                                                    @elseif($debtors->type == 2)
                                                        <span>Creditor</span>
                                                    @else
                                                        <span>Bank</span>
                                                    @endif
                                                    Balance Confirmation as on
                                                    {{ date('F d,Y', strtotime($debtors->date)) }} at the earliest.
                                                @endif --}}
                                                @if ($debtors->amounthidestatus == 1)
                                                    We confirm that in our books of account, the outstanding balance as
                                                    on
                                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $debtors->date)->format('F d, Y') }}
                                                    is
                                                    <span style="color: #ff6600;">Rs {{ $debtors->amount ?? '' }}</span>
                                                @else
                                                    We request you to provide the
                                                    @if ($debtors->type == 1)
                                                        <span>Debtor</span>
                                                    @elseif($debtors->type == 2)
                                                        <span>Creditor</span>
                                                    @else
                                                        <span>Bank</span>
                                                    @endif
                                                    Balance Confirmation as on
                                                    {{ \Carbon\Carbon::createFromFormat('d/m/Y', $debtors->date)->format('F d, Y') }}
                                                    at the earliest.
                                                @endif
                                                <br />
                                                To Accept or Refuse, please click Accept and Refuse button
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal14" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" id="fileUploadForm" action="{{ url('acceptstatus') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">File Upload</h5>
                        {{-- <div>
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li style="color:red;">{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div> --}}
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="details-form-field form-group row">
                            <div class="error-container1 col-12  d-flex align-items-center justify-content-center">
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div
                                        style="text-align: left; color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                        Upload File
                                    </div>
                                    <div>
                                        <input type="hidden" id="type" name="type" class="form-control"
                                            value="{{ $debtors->type }}">
                                        <input type="hidden" id="status" name="status" class="form-control"
                                            value="1">
                                        <input type="hidden" id="assignmentgenerate_id" name="assignmentgenerate_id"
                                            class="form-control" value="{{ $debtors->assignmentgenerate_id }}">
                                        <input type="hidden" id="debitid" name="debitid" class="form-control"
                                            value="{{ $debtors->id }}">

                                        {{-- <input type="file" name="file1" id="file-1"
                                    class="custom-input-file"> --}}
                                        <input type="file" name="file" id="file-1" class="custom-input-file">
                                        <label for="file-1" id="file-label">
                                            <i class="fa fa-upload"></i>
                                            <span>Choose a file…</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="submitbtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#acceptButton').click(function(e) {
                e.preventDefault();

                if (confirm('Are you sure?')) {
                    var type = "{{ $debtors->type }}";
                    var status = 1;
                    var assignmentgenerate_id = "{{ $debtors->assignmentgenerate_id }}";
                    var debitid = "{{ $debtors->id }}";

                    // Construct URL with data
                    var url = "/otpskipconfirmation?type=" + type + "&status=" + status +
                        "&assignmentgenerate_id=" + assignmentgenerate_id + "&debitid=" + debitid;

                    // Send Ajax request
                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            if (response.success) {
                                $('#contentdiv').empty();
                                $('#contentdiv').html(`
                            <div class="content-wrapper" style="display: grid; height: 560px; justify-content: center; align-items: center;">
                                <div class="card-body text-center" style="background-color: white; width: 373px; height: 158px;">
                                    <h2>Your response has been submitted. Thank you</h2>
                                </div>
                            </div>
                        `);
                            } else {
                                $('.error-container').html('<p style="color:red;">' + response
                                    .error + '</p>');
                            }
                        },
                        error: function(xhr, status, error) {
                            var errorMessage = JSON.parse(xhr.responseText).error;
                            $('.error-container').html('<p style="color:red;">' + errorMessage +
                                '</p>');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    </script>

    <!-- js bar start-->
    @include('backEnd.layouts.includes.js')
    <!-- js bar end -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#yesid', function(event) {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var isResend = $(this).data('resend'); // Capture the resend flag
                $.ajax({
                    type: "GET",
                    url: "{{ url('assignmentconfirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        if (isResend) {
                            // If it is a resend action, show the specific message and hide the resend link
                            $("#otpmessage").text("We have resent your OTP.");
                            $(event.currentTarget).closest('span')
                                .hide(); // Hide the resend link
                        } else {
                            $("#otpmessage").text(response.otpsuccessmessage);
                        }
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm input[name="otp"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                            $('.resends').css('display', 'none');
                        } else {
                            $('#detailsForm input[name="otp"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });

            $('body').on('click', '#noid', function(event) {
                var id = $(this).data('id');
                var status = $(this).data('status');
                var isResend = $(this).data('resend'); // Capture the resend flag
                $.ajax({
                    type: "GET",
                    url: "{{ url('assignmentconfirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        if (isResend) {
                            // If it is a resend action, show the specific message and hide the resend link
                            $("#otpmessage1").text("We have resent your OTP.");
                            $(event.currentTarget).closest('span')
                                .hide(); // Hide the resend link
                        } else {
                            $("#otpmessage1").text(response.otpsuccessmessage1);
                        }
                        $("#otpmessage3").text(response.otpsuccessmessage3);
                        $("#debitid1").val(response.debitid1);
                        $("#assignmentgenerate_id1").val(response.assignmentgenerate_id1);
                        $("#type1").val(response.type1);
                        $("#status1").val(response.status1);

                        var otpMessage2 = $("#otpmessage3").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp1"]').prop('disabled', true);
                            $('#detailsForm input[name="otp1"]').val('');
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
                            $('.resends').css('display', 'none');
                        } else {
                            $('#detailsForm input[name="otp1"]').prop('disabled', false);
                            $('#detailsForm button[type="submit"]').prop('disabled', false);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {

            function OTPInput() {
                const inputs = document.querySelectorAll('#otp > *[id]');
                for (let i = 0; i < inputs.length; i++) {
                    inputs[i].addEventListener('keydown', function(event) {
                        if (event.key === "Backspace") {
                            inputs[i].value = '';
                            if (i !== 0) inputs[i - 1].focus();
                        } else {
                            if (i === inputs.length - 1 && inputs[i].value !== '') {
                                return true;
                            } else if (event.keyCode > 47 && event.keyCode < 58) {
                                inputs[i].value = event.key;
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            } else if (event.keyCode > 64 && event.keyCode < 91) {
                                inputs[i].value = String.fromCharCode(event.keyCode);
                                if (i !== inputs.length - 1) inputs[i + 1].focus();
                                event.preventDefault();
                            }
                        }
                    });
                }
            }
            OTPInput();


        });
    </script>

    <script>
        document.getElementById('file-1').addEventListener('change', function() {
            var fileLabel = document.getElementById('file-label').querySelector('span');
            if (this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
            } else {
                fileLabel.textContent = "Choose a file…";
            }
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function updateConfirmationStatus() {
            var type = "{{ $debtors->type }}";
            var status = 1;
            var assignmentgenerate_id = "{{ $debtors->assignmentgenerate_id }}";
            var debitid = "{{ $debtors->id }}";

            if (status == 1) {
                // Show modal
                $('#exampleModal14').modal('show');

                // Make AJAX request
                $.ajax({
                    url: "{{ url('/otpskipconfirmation') }}",
                    type: 'GET',
                    data: {
                        type: type,
                        status: status,
                        assignmentgenerate_id: assignmentgenerate_id,
                        debitid: debitid
                    },
                    success: function(response) {
                        // console.log(response);
                        if (response.success) {
                            console.log(response);
                        } else {
                            $('.error-container1').html('<p style="color:red;">' + response
                                .error + '</p>');
                            $("#submitbtn").addClass('disable');
                            $('#file-1').prop('disabled', true);
                        }
                    },
                    error: function(xhr, status, error) {
                        // console.error(xhr.responseText);
                        var errorMessage = JSON.parse(xhr.responseText).error;
                        $('.error-container1').html('<p style="color:red;">' + errorMessage +
                            '</p>');

                        $("#submitbtn").addClass('disable');
                        $('#file-1').prop('disabled', true);
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#fileUploadForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#exampleModal14').modal('hide');
                        console.log(response.msg);
                        $('#contentdiv').empty();
                        $('#contentdiv').html(`
                        <div class="content-wrapper" style="display: grid; height: 560px; justify-content: center; align-items: center;">
                            <div class="card-body text-center" style="background-color: white; width: 373px; height: 158px;">
                                <h2>Your response has been submitted. Thank you</h2>
                            </div>
                        </div>
                    `);
                    },
                    error: function(response) {
                        // Handle error
                        alert('An error occurred');
                        var errors = response.responseJSON.errors;
                        $('.error-container1').html('');
                        if (errors) {
                            $.each(errors, function(key, value) {
                                $('.error-container1').append('<p style="color:red;">' +
                                    value + '</p>');
                            });
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>

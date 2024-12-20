<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>K.G.Somani</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
                    <button class="btn btn-success" id="acceptButton">Accept</button>
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
                                                @if ($debtors->amounthidestatus == 1)
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
</body>

</html>

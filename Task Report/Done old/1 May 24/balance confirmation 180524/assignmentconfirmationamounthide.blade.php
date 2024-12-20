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

<body class="bg-white">

    <div class="content-wrapper">
        <div class="main-content pt-1">
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
                                            <p>&nbsp;</p>
                                            <br>
                                            <hr>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 d-flex align-items-center justify-content-center">
                                            @php
                                                $otpsettingstatus = 0;
                                            @endphp

                                            @if ($otpsettingstatus == 0)
                                                <a href="{{ url('/otpskipconfirmation?' . 'type=' . $debtors->type . '&&' . 'status=' . 1 . '&&' . 'assignmentgenerate_id=' . $debtors->assignmentgenerate_id . '&&' . 'debitid=' . $debtors->id) }}"
                                                    style="padding: 8px 16px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; color: white; font-size: 20px; font-family: Inter; font-weight: 500; text-decoration: none; margin-right: 10px;">
                                                    Accept
                                                </a>

                                                <a href="{{ url('/otpskipconfirmation?' . 'type1=' . $debtors->type . '&&' . 'status1=' . 0 . '&&' . 'assignmentgenerate_id1=' . $debtors->assignmentgenerate_id . '&&' . 'debitid1=' . $debtors->id) }}"
                                                    style="padding: 8px 16px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; color: white; font-size: 20px; font-family: Inter; font-weight: 500; text-decoration: none;">
                                                    Refuse
                                                </a>
                                            @else
                                                <div style="padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #28A745; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                                                    id="yesid" data-id="{{ $debtorid }}" data-status="1"
                                                    data-toggle="modal" data-target="#exampleModal1">
                                                    <div
                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                        Accept</div>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div style="padding-left: 16px; padding-right: 16px; padding-top: 8px; padding-bottom: 8px; background: #DC3545; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex"
                                                    id="noid" data-id="{{ $debtorid }}" data-status="0"
                                                    data-toggle="modal" data-target="#exampleModal12">
                                                    <div
                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                        Refuse</div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- model box --}}
                                        <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content " style="border-radius: 3rem;">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"
                                                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>

                                                    <form id="detailsForm" method="post"
                                                        action="{{ url('assignmentconfirmationotp') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf


                                                        <div
                                                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                                            <div
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                                    <div
                                                                        style="width: 62px; height: 62px; position: relative">
                                                                        <div
                                                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                                        </div>
                                                                        <div
                                                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                                                alt="security-safe">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verification Required</div>

                                                                </div>

                                                                <div class="details-form-field  row">

                                                                    <div class="col-sm-12">

                                                                        <input type="hidden" id="debitid"
                                                                            name="debitid" class="form-control">
                                                                        <input type="hidden" id="assignmentgenerate_id"
                                                                            name="assignmentgenerate_id"
                                                                            class="form-control">
                                                                        <input type="hidden" id="type"
                                                                            name="type" class="form-control">
                                                                        <input type="hidden" id="status"
                                                                            name="status" class="form-control">
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
                                                                <div
                                                                    class="container height-100 d-flex justify-content-center align-items-center">
                                                                    <div class="position-relative">
                                                                        <div class="col-sm-12">
                                                                            <p class="text-success" id="otpmessage">
                                                                            </p>
                                                                        </div>
                                                                        <div class="col-sm-12">
                                                                            <p class="text-success" id="otpmessage2">
                                                                            </p>
                                                                        </div>
                                                                        <div id="otp"
                                                                            class="inputs d-flex flex-row justify-content-center mt-2">
                                                                            <input name="otp1"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="first"
                                                                                maxlength="1" />
                                                                            <input name="otp2"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="second"
                                                                                maxlength="1" />
                                                                            <input name="otp3"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="third"
                                                                                maxlength="1" />
                                                                            <input name="otp4"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="fourth"
                                                                                maxlength="1" />
                                                                            <input name="otp5"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="fifth"
                                                                                maxlength="1" />
                                                                            <input name="otp6"
                                                                                class="m-2 text-center form-control rounded"
                                                                                type="text" id="sixth"
                                                                                maxlength="1" />
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                                <div style="width: 332px; text-align: center"
                                                                    class="resends"><span
                                                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                                        receive the OTP?</span><span
                                                                        style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        <a id="yesid"
                                                                            data-id="{{ $debtorid }}"
                                                                            data-status="1" data-resend="true"
                                                                            class="font-weight-500"
                                                                            style="color:#37a000;"> Resend</a>
                                                                    </span>
                                                                </div>
                                                            </div>


                                                            <div
                                                                style="width: 100%; height: 100%;    background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                                                <button style="background: #37A000;" type="submit"
                                                                    class="btn btn-block" id="verifyBtn"
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

                                        {{-- model box --}}
                                        <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog"
                                            aria-labelledby="exampleModalLabel4" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"
                                                        style="position: absolute; top: 10px; right: 10px; background-color: rgba(0,0,0,0.1); border-radius: 50%; border: none; padding: 5px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <form id="detailsForm" method="post"
                                                        action="{{ url('assignmentconfirmationotp') }}"
                                                        enctype="multipart/form-data">
                                                        @csrf
                                                        <div
                                                            style="width: 100%; border-radius: 10px; height: 100%; padding: 16px; background: white; box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.25);  flex-direction: column; justify-content: flex-start; align-items: center; gap: 24px; display: inline-flex ">
                                                            <div
                                                                style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                <div
                                                                    style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: flex">
                                                                    <div
                                                                        style="width: 62px; height: 62px; position: relative">
                                                                        <div
                                                                            style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                                                        </div>
                                                                        <div
                                                                            style="width: 46.03px; height: 51.64px; left: 7.98px; top: 5.19px; position: absolute; ">
                                                                            <img src="{{ asset('image/security-safe.svg') }}"
                                                                                alt="security-safe">
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verification Required</div>
                                                                    @if ($errors->any())
                                                                        <div>
                                                                            <ul>
                                                                                @foreach ($errors->all() as $e)
                                                                                    <li style="color:red;">
                                                                                        {{ $e }}</li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    @else
                                                                    @endif
                                                                </div>
                                                                <div
                                                                    style="width: 332px; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                                                                    Please enter the 6-digit OTP sent to your registered
                                                                    email address.
                                                                </div>
                                                                {{-- </div> --}}


                                                                <div class="details-form-field form-group row">
                                                                    <div class="col-sm-12" style="margin-left: 5rem">
                                                                        <p class="text-success" id="otpmessage1"></p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <p class="text-success" id="otpmessage3"></p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                        <div name="otp"
                                                                            style="flex-direction: column; justify-content: flex-start; align-items: center; gap: 16px; display: flex">
                                                                            <div
                                                                                class="container height-100 d-flex justify-content-center align-items-center">
                                                                                <div class="position-relative">
                                                                                    <div id="otp"
                                                                                        class="inputs d-flex flex-row justify-content-center mt-2">
                                                                                        <input name="otp11"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="first"
                                                                                            maxlength="1" />
                                                                                        <input name="otp12"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="second"
                                                                                            maxlength="1" />
                                                                                        <input name="otp13"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="third"
                                                                                            maxlength="1" />
                                                                                        <input name="otp14"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="fourth"
                                                                                            maxlength="1" />
                                                                                        <input name="otp15"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="fifth"
                                                                                            maxlength="1" />
                                                                                        <input name="otp16"
                                                                                            class="m-2 text-center form-control rounded"
                                                                                            type="text"
                                                                                            id="sixth"
                                                                                            maxlength="1" />
                                                                                    </div>

                                                                                </div>
                                                                            </div>
                                                                            <div style="width: 332px; text-align: center"
                                                                                class="resends">
                                                                                <span
                                                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 300; word-wrap: break-word">Didn’t
                                                                                    receive the OTP?</span><span
                                                                                    style="color: rgba(41, 45, 50, 0.85); font-size: 16px; font-family: Inter; font-weight: 500; text-decoration: underline; word-wrap: break-word">
                                                                                    <a id="noid"
                                                                                        data-id="{{ $debtorid }}"
                                                                                        data-status="0"
                                                                                        data-resend="true"
                                                                                        class="font-weight-500"
                                                                                        style="color:#37a000;">
                                                                                        Resend</a></span>
                                                                            </div>
                                                                        </div>
                                                                        <input type="hidden" id="debitid1"
                                                                            name="debitid1" class="form-control">
                                                                        <input type="hidden"
                                                                            id="assignmentgenerate_id1"
                                                                            name="assignmentgenerate_id1"
                                                                            class="form-control">
                                                                        <input type="hidden" id="type1"
                                                                            name="type1" class="form-control">
                                                                        <input type="hidden" id="status1"
                                                                            name="status1" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div
                                                                style="width: 100%; height: 100%;  background: #4071F4; box-shadow: 0px 1px 4px rgba(0, 0, 0, 0.25); border-radius: 4px; justify-content: center; align-items: center; display: inline-flex">
                                                                <button style="background: #37a000;" type="submit"
                                                                    class="btn btn-block" id="verifyBtn">
                                                                    <div
                                                                        style="color: white; font-size: 20px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                                                        Verify</div>
                                                                </button>
                                                            </div>

                                                            {{-- </div> --}}
                                                    </form>
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
        </div>
    </div>

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

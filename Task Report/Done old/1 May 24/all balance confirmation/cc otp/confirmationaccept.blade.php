<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>K.G.Somani</title>

    <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!-- stylesheet end -->
</head>

<body class="bg-white">
    <div class="d-flex align-items-center justify-content-center text-center h-100vh"
        style="background-image:url('backEnd/image/unnamed.jpg');">
        <div class="form-wrapper m-auto">
            <div class="form-container my-4">
                <div class="register-logo text-center mb-4">
                </div>
                <div class="panel">
                    @if ($errors->any())
                        {{-- <div class="alert alert-danger"> --}}
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                        {{-- </div> --}}
                    @endif
                    @if (session('success_message'))
                        <p class="text-danger">{{ session('success_message') }}</p>
                    @endif
                    <div style="display: flex">
                        <div class="panel-header text-center" style=" margin-right: 22px;">
                            <a style="color: white" class="btn btn-success" id="editCompany"
                                data-id="{{ $debtorid }}" data-status="1" data-toggle="modal"
                                data-target="#exampleModal1" onclick="return confirm('Are you sure ?');">
                                Accept </a>
                        </div>

                        <div class="panel-header text-center">
                            <a style="color: white" class="btn btn-danger" id="editCompany2"
                                data-id="{{ $debtorid }}" data-status="0" data-toggle="modal"
                                data-target="#exampleModal12" onclick="return confirm('Are you sure ?');">
                                Refuse
                            </a>
                        </div>
                    </div>

                    {{-- model box --}}
                    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalLabel4" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form id="detailsForm" method="post" action="{{ url('confirmationotp') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header" style="background: #37A000">
                                        <h5 style="color:white;" class="modal-title font-weight-600"
                                            id="exampleModalLabel4">Enter
                                            Verification OTP</h5>
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
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage2"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name="otp" class="form-control"
                                                    placeholder="Enter OTP">

                                                <input type="hidden" id="debitid" name="debitid"
                                                    class="form-control">
                                                <input type="hidden" id="assignmentgenerate_id"
                                                    name="assignmentgenerate_id" class="form-control">
                                                <input type="hidden" id="type" name="type"
                                                    class="form-control">
                                                <input type="hidden" id="status" name="status"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Save</button>
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
                                <form id="detailsForm" method="post" action="{{ url('confirmationotp') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header" style="background: #37A000">
                                        <h5 style="color:white;" class="modal-title font-weight-600"
                                            id="exampleModalLabel4">Enter
                                            Verification OTP</h5>
                                        <div>
                                            <ul>
                                                @foreach ($errors->all() as $e)
                                                    <li style="color:red;">{{ $e }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="details-form-field form-group row">
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage1"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <p class="text-success" id="otpmessage3"></p>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" name="otp1" class="form-control"
                                                    placeholder="Enter OTP">


                                                <input type="hidden" id="debitid1" name="debitid1"
                                                    class="form-control">
                                                <input type="hidden" id="assignmentgenerate_id1"
                                                    name="assignmentgenerate_id1" class="form-control">
                                                <input type="hidden" id="type1" name="type1"
                                                    class="form-control">
                                                <input type="hidden" id="status1" name="status1"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.main content-->

    <!-- js bar start-->
    @include('backEnd.layouts.includes.js')
    <!-- js bar end -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage2").text(response.otpsuccessmessage2);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                        var otpMessage2 = $("#otpmessage2").text().trim();
                        if (otpMessage2) {
                            $('#detailsForm input[name="otp"]').prop('disabled', true);
                            $('#detailsForm button[type="submit"]').prop('disabled', true);
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

            $('body').on('click', '#editCompany2', function(event) {
                var id = $(this).data('id');
                var status = $(this).data('status');
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    // data: "id=" + id,
                    data: {
                        id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response);
                        $("#otpmessage1").text(response.otpsuccessmessage1);
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

</body>

</html>

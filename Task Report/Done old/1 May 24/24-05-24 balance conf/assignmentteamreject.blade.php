<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>K. G. Somani</title>

    <!-- stylesheet start -->
    @include('backEnd.layouts.includes.stylesheet')
    <!-- stylesheet end -->
    <style>
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
    </style>
</head>

<body class="bg-white">

    <div id="contentdiv" class="d-flex align-items-center justify-content-center text-center h-100vh"
        style="background-image:url('backEnd/image/unnamed.jpg');">
        <div class="form-wrapper m-auto">
            <div class="form-container my-4">

                <div class="panel">
                    <div
                        style="width: 100%; height: 100%; flex-direction: column; justify-content: flex-start; align-items: center; gap: 8px; display: inline-flex">
                        <div
                            style="width: 62px; height: 62px; justify-content: center; align-items: center; display: inline-flex">
                            <div style="width: 62px; height: 62px; position: relative">
                                <div
                                    style="width: 43.63px; height: 51.94px; left: 9.17px; top: 4.91px; position: absolute; ">
                                    <img src="{{ asset('image/shield-tick.svg') }}" alt="security-safe">
                                </div>
                                <div
                                    style="width: 62px; height: 62px; left: 62px; top: 62px; position: absolute; transform: rotate(-180deg); transform-origin: 0 0; opacity: 0">
                                </div>
                            </div>
                        </div>
                        <div
                            style="color: #292D32; font-size: 24px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                            Correct Information Required</div>
                    </div>
                    <div
                        style="width: 100%; text-align: center; color: rgba(41, 45, 50, 0.65); font-size: 18px; font-family: Inter; font-weight: 400; word-wrap: break-word">
                        We understand your reason for refusing. Please provide us with the correct information. </div>
                    <div>
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                @if (is_array(session()->get('success')))
                                    @foreach (session()->get('success') as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                @else
                                    <p>{{ session()->get('success') }}</p>
                                @endif
                            </div>
                        @endif
                        @if (session()->has('statuss'))
                            <div class="alert alert-danger">
                                @if (is_array(session()->get('statuss')))
                                    @foreach (session()->get('statuss') as $message)
                                        <p>{{ $message }}</p>
                                    @endforeach
                                @else
                                    <p>{{ session()->get('success') }}</p>
                                @endif
                            </div>
                        @endif
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <form id="confirmationForm" method="POST" action="{{ url('assignmentconfirmation') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="">
                            <div style="text-align: left;"><span class="text-align-left"
                                    style="color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">Enter
                                    Amount </span><span
                                    style="color: #DC3545; font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">*</span>
                            </div>
                            <input type="number" required name="amount"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Eg. ₹ 90,000"><br>
                            <div
                                style=" text-align: left; color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                Remarks</div>
                            <input type="hidden" name="clientid"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $clientid }}">
                            <input type="hidden" name="debtorid"
                                class="form-control @error('email') is-invalid @enderror" value="{{ $debtorid }}">
                            <input type="hidden" name="status"
                                class="form-control @error('email') is-invalid @enderror" value="0">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="invalid-feedback text-left">Enter your
                                valid email</div>
                        </div>
                        <div class="form-group">
                            <textarea name="remark" rows="3" class="form-control" placeholder="Add your remarks here"></textarea>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="invalid-feedback text-left">Enter your
                                valid email</div>
                        </div>
                        <div class="form-group">
                            <div
                                style="text-align: left; color: rgba(41, 45, 50, 0.85); font-size: 14px; font-family: Inter; font-weight: 500; word-wrap: break-word">
                                Upload File</div>

                            <div>
                                <input type="file" name="file" id="file-1" class="custom-input-file">
                                <label for="file-1">
                                    <i class="fa fa-upload"></i>
                                    <span>Choose a file…</span>
                                </label>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @if ($debtorconfirm == null)
                            <button type="submit" class="btn btn-success btn-block">Submit</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#confirmationForm').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission

                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            $('#contentdiv').empty();
                            $('#contentdiv').html(`
                            <div class="content-wrapper" style="display: grid; justify-content: center; align-items: center;">
            <div class="card-body text-center" style="background-color: white; width: 373px; height: 158px;">
                <h2><b>Your response has been submitted. Thank you</b></h2>
            </div>
        </div>
                        `);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(xhr) {
                        // Display error message
                        var errorMessage = JSON.parse(xhr.responseText).error;
                        $('.error-container').html('<p style="color:red;">' + errorMessage +
                            '</p>');
                    }
                });
            });
        });
    </script>



    <!--/.main content-->

    <!-- js bar start-->
    @include('backEnd.layouts.includes.js')
    <!--Page Active Scripts(used by this page)-->
    <script src="{{ url('backEnd/dist/js/pages/forms-basic.active.js') }}"></script>
    <!-- js bar end -->
</body>

</html>

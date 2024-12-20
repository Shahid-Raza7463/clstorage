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
                    <div style="display: flex">
                        <div class="panel-header text-center" style=" margin-right: 22px;">
                            <a href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $yes) }}"
                                onclick="return confirm('Are you sure ?');">
                                <button type="submit" style="background: #218838"
                                    class="btn btn-success btn-block">Accept</button>
                            </a>
                        </div>

                        <div class="panel-header text-center">
                            <a href="{{ url('/debtorconfirm?' . 'clientid=' . $clientid . '&&' . 'debtorid=' . $debtorid . '&&' . 'status=' . $no) }}"
                                onclick="return confirm('Are you sure ?');">
                                <button type="submit" style="background: #d3400a"
                                    class="btn btn-success btn-block">Refuse</button>
                            </a>
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
</body>

</html>

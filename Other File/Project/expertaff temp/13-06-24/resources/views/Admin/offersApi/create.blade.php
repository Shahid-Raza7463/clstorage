<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Offers Api</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/offers-api') }}" class="btn btn-sm btn-success">
                        All
                    </a>
                </div>
            </div>
            <!-- display error massage for user-->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Display success massage for user-->
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!--data store by this form in database-->
            <div class="form-Container m-3">
                <form action="{{ url('/') }}/admin/offers-api" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Api Url:</label>
                            <input class="form-control" type="text" name="api_url" placeholder="Enter title">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Tracking Software:</label>
                            <select class="form-select" name="tracking_software" style="height: 36px;">
                                <option value=""selected>Select Tracking Software</option>
                                @foreach ($software as $s)
                                    <option value="{{ $s->name }}">
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Frequency:</label>
                            <select class="form-select" name="frequency" style="height: 36px;">
                                <option value=""selected>Select Frequency</option>
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Status:</label>
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Adspace</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/adspaces') }}" class="btn btn-sm btn-success">
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
                <form action="{{ url('/') }}/admin/adspaces" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Position:</label>
                            <select name="position" class="form-select" aria-label="Default select example">
                                <option value="top_left">Network Of the Months</option>
                                <option value="top_right">Home carousel</option>
                                <option value="offers_top_right">Offers carousel</option>
                                <option value="reviews_top_right">Reviews carousel</option>
                                <option value="top_middle_1">In Page Ads</option>
                                <option value="right_side_1">Sponsored Ads</option>
                                <option value="right_side_2">Sponsored Small Ads</option>
                                <option value="right_side_4">Featured Networks Ads</option>
                            </select>
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Image Url:</label>
                            <input type="file" name="image_url" id="image-input" accept="image/*">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Link:</label>
                            <input class="form-control" type="text" name="link" placeholder="Enter link">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Status:</label>
                            <select name="status" class="form-select" aria-label="Default select example">
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network:</label>
                            <select class="form-select" name="network_id" style="height: 36px;">
                                <option value=""selected>Select Network Name</option>
                                @foreach ($networks as $network)
                                    <option value=" {{ $network->network_id }}">
                                        {{ $network->network_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Expired At:</label>
                            <input class="form-control" type="date" name="expired_at" placeholder="Enter expire date">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="submit">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

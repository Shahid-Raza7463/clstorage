<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Offers</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/offers') }}" class="btn btn-sm btn-success"> All </a>
                </div>
            </div>
            <!--display error massage for user -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!--  Display success massage for user -->

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <!--update existing data to the user by this form -->

            <div class="form-container m-3">
                <form action="{{ url('/') }}/admin/offers/{{ $id }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')

                    <div class="field-container">
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Icon:</label>
                                <input class="form-control" type="text" name="icon" placeholder="Enter title"
                                    value="{{ $offers->icon }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Title:</label>
                                <input class="form-control" type="text" name="title" placeholder=" Enter update user"
                                    value="{{ $offers->title }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Payout:</label>
                                <input class="form-control" type="text" name="payout" placeholder="Enter tags"
                                    value="{{ $offers->payout }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Status: </label>
                                <select name="status" class="form-control">
                                    <option {{ $offers->status == 0 ? 'selected' : '' }} value="0">Inactive
                                    </option>
                                    <option {{ $offers->status == 1 ? 'selected' : '' }} value="1">Active
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Countries:</label>
                                <input class="form-control" type="text" name="countries" placeholder="Enter tags"
                                    value="{{ $offers->countries }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Is featured:</label>
                                <input class="form-control" type="text" name="is_featured" placeholder="Enter tags"
                                    value="{{ $offers->is_featured }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Offer image:</label>
                                <input type="file" name="offer_image" id="image-input" accept="image/*">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6">
                                <input type="submit" class="btn btn-success btn-md" name="submit" value="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

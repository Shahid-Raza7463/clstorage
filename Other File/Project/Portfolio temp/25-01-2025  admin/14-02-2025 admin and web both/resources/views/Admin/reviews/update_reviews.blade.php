<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Reviews</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/reviewslist') }}" class="btn btn-sm btn-success"> All </a>
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
                <form action="{{ url('/') }}/admin/reviewslist/{{ $review_id }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network Id: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->network_id }}"
                                name="network_id" placeholder="Enter Name">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">User Id: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->user_id }}" name="user_id"
                                placeholder="Enter Name">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">All Rating: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->all_rating }}"
                                name="all_rating" placeholder="Enter Name">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Offer Rating: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->offer_rating }}"
                                name="offer_rating" placeholder="Enter Name">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Payout Rating: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->payout_rating }}"
                                name="payout_rating" placeholder="Enter Name">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Tracking Rating: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->tracking_rating }}"
                                name="tracking_rating" placeholder="Enter Name">
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Support Rating: </label>
                            <input class="form-control" type="text" value="{{ $reviewslist->support_rating }}"
                                name="support_rating" placeholder="Enter Name">
                        </div>

                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Status: </label>
                            <select name="status" class="form-control">
                                <option {{ $reviewslist->status == 0 ? 'selected' : '' }} value="0">Pending
                                </option>
                                <option {{ $reviewslist->status == 1 ? 'selected' : '' }} value="1">Approved
                                </option>
                                <option {{ $reviewslist->status == 2 ? 'selected' : '' }} value="2">Rejected
                                </option>
                            </select>
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Review Text: </label>
                            <textarea class="form-control" type="text"cols="10" rows="6"name="review_text" placeholder="Enter Name">{{ $reviewslist->review_text }}</textarea>
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

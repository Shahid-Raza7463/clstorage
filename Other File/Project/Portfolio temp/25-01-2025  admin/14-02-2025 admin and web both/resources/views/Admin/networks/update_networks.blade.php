<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Networks</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/networks-list') }}" class="btn btn-sm btn-success">
                        All
                    </a>
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

            <!-- Display success massage for use-->

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <!--update existing data to the user by this form -->
            <div class="form-container m-3">
                <form action="{{ url('/') }}/admin/networks-list/{{ $network_id }}" method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network Name:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->network_name }}"
                                name="network_name" placeholder="Enter Network Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network Type:<span class="required">*</span></label>

                            <select class="form-select" name="network_type" aria-label="Default select example">

                                <option value="0" {{ $network->network_type == '0' ? 'selected' : '' }}>
                                    Affiliate Network
                                </option>
                                <option value="1" {{ $network->network_type == '1' ? 'selected' : '' }}>
                                    Affiliate Program
                                </option>
                                <option value="2" {{ $network->network_type == '2' ? 'selected' : '' }}>
                                    Advertising
                                </option>
                            </select>
                            <span style="font-size: 12px;">Affiliate Program,Advertising</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network Url:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->network_url }}"
                                name="network_url" placeholder="Enter Network Url"> <span style="font-size: 12px;">Such as:
                                https://www.example.com</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network description:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->network_description }}"
                                name="network_description" placeholder="Enter Network description">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Offer Count:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->offer_count }}"
                                name="offer_count" placeholder="Enter Offer Count"> <span style="font-size: 12px;">(How many
                                offers in your network? (50, 100, etc))</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Min payout:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->min_payout }}" name="min_payout"
                                placeholder="Enter Min payout"> <span style="font-size: 12px;">(Minimum Payment ($50, $100,
                                etc))</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Referral Commission:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->referral_commission }}"
                                name="referral_commission" placeholder="Enter Referral Commission:"> <span
                                style="font-size: 12px;">(2%, 5%, etc)</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Affiliate tracking software:<span class="required">*</span></label>

                            <select name="affiliate_tracking_software" id="affiliate_tracking_software"
                                class="form-control p-1">
                                @foreach ($network_softwares as $key => $val)
                                    <option value="{{ $val }}" @if ($network->affiliate_tracking_software == $val) selected @endif>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>


                            <span style="font-size: 12px;">Affiliate Tracking Software (HasOffers, Trakaff, Affise,
                                In-house, etc)</span>
                        </div>
                    </div>
                    <div class="col-6 d-flex flex-column  mb-2">
                        <label for="">Status: </label>
                        <select name="status" class="form-control">
                            <option {{ $network->status == 0 ? 'selected' : '' }} value="0">Pending
                            </option>
                            <option {{ $network->status == 1 ? 'selected' : '' }} value="1">Approved
                            </option>
                            <option {{ $network->status == 2 ? 'selected' : '' }} value="2">Rejected
                            </option>
                        </select>
                    </div>
                    <div class="col-6 d-flex flex-column  mb-2">
                        <label for="">Sponsored: </label>
                        <select name="is_sponsored" class="form-control">
                            <option {{ $network->is_sponsored == 0 ? 'selected' : '' }} value="0">Not Sponsored
                            </option>
                            <option {{ $network->is_sponsored == 1 ? 'selected' : '' }} value="1">Sponsored
                            </option>
                        </select>
                    </div>
                    <div class="col-6 d-flex flex-column  mb-2">
                        <label for="">Top Network: </label>
                        <select name="is_top_network" class="form-control">
                            <option {{ $network->is_top_network == 0 ? 'selected' : '' }} value="0">Not Top Network
                            </option>
                            <option {{ $network->is_top_network == 1 ? 'selected' : '' }} value="1">Top Network
                            </option>
                        </select>
                    </div>
                    <div class="col-6 d-flex flex-column  mb-2">
                        <label for="">Featured Net: </label>
                        <select name="is_featured" class="form-control">
                            <option {{ $network->is_featured == 0 ? 'selected' : '' }} value="0">Not Featuered
                            </option>
                            <option {{ $network->is_featured == 1 ? 'selected' : '' }} value="1">Featuered
                            </option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Resion for Rejected:</label>
                            <input class="form-control" type="text" name="reject_resion"
                                placeholder="Enter Resion for Reject">
                        </div>
                    </div>


                    {{-- <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Logo:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $network->logo }}" name="image">
                        </div>
                    </div> --}}
                    <div class="row">
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

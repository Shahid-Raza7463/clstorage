<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Network Software</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/networksoftware') }}" class="btn btn-sm btn-success">
                        All
                    </a>
                </div>
            </div>
            <!--
                                                                                    display error massage for user
                                                                                     -->

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!--Display success massage for user-->

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <!-- update existing data to the user by this form-->
            <div class="form-container m-3">
                <form action="{{ url('/') }}/admin/networksoftware/{{ $id }}" method="post">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Name:<span class="required">*</span></label>
                            <input class="form-control" type="text" value="{{ $networkSoftware->name }}" name="name"
                                placeholder="Enter Name"> <span style="font-size: 12px;">Affiliate Tracking Software
                                (HasOffers, Trakaff, Affise,
                                In-house, etc)</span>
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

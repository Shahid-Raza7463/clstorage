<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Seo Meta</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/seo-meta') }}" class="btn btn-sm btn-success"> All </a>
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
                <form action="{{ url('/') }}/admin/seo-meta/{{ $id }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="field-container">
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Name:</label>
                                <input class="form-control" type="text" name="name" placeholder="Enter name"
                                    value="{{ $seo_meta->name }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Meta Title:</label>
                                <input class="form-control" type="text" name="meta_title" placeholder="Enter meta title"
                                    value="{{ $seo_meta->meta_title }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Meta Description:</label>
                                <input class="form-control" type="text" name="meta_description"
                                    placeholder="Enter meta description" value="{{ $seo_meta->meta_description }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Meta Keywords:</label>
                                <input class="form-control" type="text" name="meta_keywords"
                                    placeholder="Enter meta keywords" value="{{ $seo_meta->meta_keywords }}">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <input type="submit" class="btn btn-success btn-md" name="submit" value="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

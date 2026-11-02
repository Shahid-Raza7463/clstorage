<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Create Blogs</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/blog') }}" class="btn btn-sm btn-success">
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
                <form action="{{ url('/') }}/admin/blog" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 d-flex flex-column  mb-2">
                            <label for="">Title:</label>
                            <input class="form-control" type="text" name="title" placeholder="Enter title">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Tags:</label>
                            <input class="form-control" type="text" name="tags" placeholder="Enter tags">
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
                            <label for="">Category:</label>
                            <select class="form-select" name="category" style="height: 36px;">
                                <option value=""selected>Select Categories</option>
                                @foreach ($network_categories as $title)
                                    <option value="{{ $title->title }}">
                                        {{ $title->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Network:</label>
                            <select class="form-select" name="network_id" style="height: 36px;">
                                <option value=""selected>Select Network</option>
                                @foreach ($networks as $network)
                                    <option value=" {{ $network->network_id }}">
                                        {{ $network->network_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Meta Description:</label>
                            <textarea class="form-control" type="text"cols="10" rows="3"name="meta_description"
                                placeholder="Enter meta description"></textarea>
                        </div>
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Meta Title:</label>
                            <textarea class="form-control" type="text"cols="10" rows="3"name="meta_title"
                                placeholder="Enter meta title"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex flex-column  mb-2">
                            <label for="">Description:</label>
                            <textarea class="form-control" name="description" id="summernote"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Preview_image:</label>
                            <input type="file" name="preview_image" id="image-input" accept="image/*">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="submit">
                        </div>
                    </div>
                </form>
            </div>
            <script>
                $('#summernote').summernote({
                    placeholder: 'Enter Description ',
                    tabsize: 2,
                    height: 100
                });
            </script>
        </div>
    </div>
@endsection

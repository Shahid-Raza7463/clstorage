<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Blog</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/blog') }}" class="btn btn-sm btn-success"> All </a>
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
                <form action="{{ url('/') }}/admin/blog/{{ $id }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="field-container">


                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Title:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $blog->title }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Update User:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $blog->update_user }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Tags:</label>
                                <input class="form-control" type="text" name="tags" placeholder="Enter tags"
                                    value="{{ $blog->tags }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Status: </label>
                                <select name="status" class="form-control">
                                    <option {{ $blog->status == 0 ? 'selected' : '' }} value="0">Inactive
                                    </option>
                                    <option {{ $blog->status == 1 ? 'selected' : '' }} value="1">Active
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Network: </label>
                                <select name="network_id" class="form-control">
                                    @foreach ($networks as $network)
                                        <option {{ $blog->network_id == $network->network_id ? 'selected' : '' }}
                                            value=" {{ $network->network_id }}">
                                            {{ $network->network_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Category: </label>
                                <select name="category" class="form-control">
                                    @foreach ($network_categories as $title)
                                        <option {{ $blog->category == $title->title ? 'selected' : '' }}
                                            value="{{ $title->title }}">
                                            {{ $title->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Meta Description:</label>
                                <textarea class="form-control" type="text"cols="10" rows="3"name="meta_description"
                                    placeholder="Enter meta description">{{ $blog->meta_description }}</textarea>
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Meta Title:</label>
                                <textarea class="form-control" type="text"cols="10" rows="3"name="meta_title"
                                    placeholder="Enter meta title">{{ $blog->meta_title }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex flex-column  mb-2">
                                <label for="">Description:</label>
                                <textarea class="form-control" name="description" id="summernote">{{ $blog->description }}</textarea>
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

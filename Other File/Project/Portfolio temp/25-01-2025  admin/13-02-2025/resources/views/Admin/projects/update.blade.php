<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Projects</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/projects') }}" class="btn btn-sm btn-success"> All </a>
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
            <div class="form-container m-3 ">
                <form action="{{ url('/') }}/admin/projects/{{ $id }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="field-container">
                        {{-- <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">category_id:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->category_id }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">projectname:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $data->projectname }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">projectlurl:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->projectlurl }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">projectmage:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $data->projectmage }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">projectimagezoom:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->projectimagezoom }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">categoryname:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $data->categoryname }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">companyname:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->companyname }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">projectenddate:</label>
                                <input class="form-control" type="date" name="expired_at" placeholder="Enter expire date"
                                    value="{{ $data->projectenddate }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">toolsandtechnologies:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->toolsandtechnologies }}">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">highlightnote1:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->highlightnote1 }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">highlightnote2:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $data->highlightnote2 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">listdescreption:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->listdescreption }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">listheading:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $data->listheading }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">listdescreption2:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->listdescreption2 }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">listheading2:</label>
                                <input class="form-control" type="text" name="update_user"
                                    placeholder=" Enter update user" value="{{ $data->listheading2 }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">anotherdescreption:</label>
                                <input class="form-control" type="text" name="title" placeholder="Enter title"
                                    value="{{ $data->anotherdescreption }}">
                            </div>
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Status: </label>
                                <select name="status" class="form-control">
                                    <option {{ $data->status == 0 ? 'selected' : '' }} value="0">Inactive
                                    </option>
                                    <option {{ $data->status == 1 ? 'selected' : '' }} value="1">Active
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex flex-column  mb-2">
                                <label for="">Description:</label>
                                <textarea class="form-control summernote" name="description">{{ $data->descreption }}</textarea>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-12 d-flex flex-column  mb-2">
                                <label for="">listdescreption:</label>
                                <textarea class="form-control summernote" name="listdescreption">{{ $data->listdescreption }}</textarea>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <div class="col-12 d-flex flex-column  mb-2">
                                <label for="">listdescreption2:</label>
                                <textarea class="form-control" name="description" id="summernote">{{ $data->listdescreption2 }}</textarea>
                            </div>
                        </div> --}}

                        {{-- <div class="row">
                            <div class="col-12 d-flex flex-column  mb-2">
                                <label for="">Description:</label>
                                <textarea class="form-control" name="description" id="summernote">{{ $data->description }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 d-flex flex-column  mb-2">
                                <label for="">Preview_image:</label>
                                <input type="file" name="preview_image" id="image-input" accept="image/*">
                            </div>
                        </div> --}}
                        <div class="row mt-3">
                            <div class="col-6">
                                <input type="submit" class="btn btn-success btn-md" name="submit" value="submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <script>
                $('.summernote').summernote({
                    placeholder: 'Enter Description ',
                    tabsize: 2,
                    height: 200
                });
            </script>
        </div>
    </div>
@endsection

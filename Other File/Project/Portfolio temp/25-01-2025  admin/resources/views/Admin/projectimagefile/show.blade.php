<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Views Projectimagefile</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/projectimagefile') }}" class="btn btn-sm btn-success">
                        All
                    </a>
                </div>
            </div>
            {{-- <th>projects_id</th>
            <th>image</th> --}}
            <div class="card-body">
                <div class="container">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Id:</strong>{{ $data->id }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Title:</strong>{{ $data->projects_id }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Description:</strong>{{ $data->image }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Created_at:</strong>{{ $data->created_at }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Updated_at:</strong>{{ $data->updated_at }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

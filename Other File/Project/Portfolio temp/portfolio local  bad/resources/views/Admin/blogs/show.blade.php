@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Blogs</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/blog') }}" class="btn btn-sm btn-success">
                        All
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="container">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Id:</strong>{{ $data->id }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Title:</strong>{{ $data->title }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">Description:</strong>{!! $data->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

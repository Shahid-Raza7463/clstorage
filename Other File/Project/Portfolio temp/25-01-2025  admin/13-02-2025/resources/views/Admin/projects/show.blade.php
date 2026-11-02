<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Views Projects</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/projects') }}" class="btn btn-sm btn-success">
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
                            <strong class="mr-2">category_id:</strong>{{ $data->category_id }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">projectname:</strong>{{ $data->projectname }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">projectlurl:</strong>{{ $data->projectlurl }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">projectmage Id:</strong>{{ $data->projectmage }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">projectimagezoom User:</strong>{{ $data->projectimagezoom }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">categoryname User:</strong>{{ $data->categoryname }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">companyname Title:</strong>{{ $data->companyname }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">projectenddate Description:</strong>{{ $data->projectenddate }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">toolsandtechnologies:</strong>{{ $data->toolsandtechnologies }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">descreption:</strong>{{ $data->descreption }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">highlightnote1:</strong>{{ $data->highlightnote1 }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">highlightnote2:</strong>{{ $data->highlightnote2 }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">listdescreption:</strong>{{ $data->listdescreption }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">listheading:</strong>{{ $data->listheading }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">listdescreption2:</strong>{{ $data->listdescreption2 }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">listheading2:</strong>{{ $data->listheading2 }}
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">anotherdescreption:</strong>{{ $data->anotherdescreption }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong class="mr-2">status:</strong>{{ $data->status }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

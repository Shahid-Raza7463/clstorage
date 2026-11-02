@extends('Admin.template')
@section('content')
    <div class="card card-default">
        <div class="card-header" style="margin-top: 10px;">
            <h1 class="card-title" style="font-size: 23px !important;">Create New Role</h1>
            <div class="card-tools">
                <a href="{{ route('roles.index') }}" class="btn btn-sm btn-success">Back
                </a>
            </div>
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
        <div class="row" style="margin-left: 20px">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Permission:</strong>
                    <br />
                    @foreach ($permission as $value)
                        <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                            {{ $value->name }}</label>
                        <br />
                    @endforeach
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary  mb-5">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

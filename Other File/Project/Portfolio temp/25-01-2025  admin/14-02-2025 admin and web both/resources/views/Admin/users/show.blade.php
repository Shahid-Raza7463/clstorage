@extends('Admin.template')
@section('content')
    <div class="card card-default">
        <div class="card-header" style="margin-top: 10px;">
            <h1 class="card-title" style="font-size: 23px !important;">Show User</h1>
            <div class="card-tools">
                <a href="{{ route('users.index') }}" class="btn btn-sm btn-success">Back
                </a>
            </div>
        </div>
        <div class="row" style="margin-left: 20px">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {{ $user->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    {{ $user->email }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Roles:</strong>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <span class="badge rounded-pill bg-dark">{{ $v }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

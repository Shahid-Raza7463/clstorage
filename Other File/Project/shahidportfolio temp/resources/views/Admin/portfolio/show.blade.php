@extends('Admin.template')

@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">{{ $config['title'] }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.portfolio.index', $resource) }}" class="btn btn-sm btn-success">All</a>
                </div>
            </div>
            <div class="card-body">
                @foreach ($config['fields'] as $field)
                    <div class="mb-2">
                        <strong>{{ ucwords(str_replace('_', ' ', $field)) }}:</strong>
                        <div>{{ is_array($item->{$field}) ? implode(', ', $item->{$field}) : $item->{$field} }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

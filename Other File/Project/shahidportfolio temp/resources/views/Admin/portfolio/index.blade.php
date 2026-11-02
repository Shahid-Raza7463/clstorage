@extends('Admin.template')

@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">{{ $config['title'] }}</h3>
                <div class="card-tools">
                    <a href="{{ route('admin.portfolio.create', $resource) }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if (session('message'))
                    <div class="alert alert-success">{{ session('message') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                @foreach (array_slice($config['fields'], 0, 4) as $field)
                                    <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                                @endforeach
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    @foreach (array_slice($config['fields'], 0, 4) as $field)
                                        <td>{{ is_array($item->{$field}) ? implode(', ', $item->{$field}) : Str::limit((string) $item->{$field}, 80) }}</td>
                                    @endforeach
                                    <td>
                                        <div class="d-flex">
                                            <a href="{{ route('admin.portfolio.show', [$resource, $item->id]) }}"
                                                class="btn btn-sm btn-success mr-2">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('admin.portfolio.edit', [$resource, $item->id]) }}"
                                                class="btn btn-sm btn-primary mr-2">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.portfolio.destroy', [$resource, $item->id]) }}"
                                                method="post" onsubmit="return confirm('Delete this record?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection

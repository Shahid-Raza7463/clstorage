@extends('Admin.template')
@section('content')
    <div class="card card-default">
        <div class="card-header" style="margin-top: 10px;">
            <h1 class="card-title" style="font-size: 23px !important;">All Products</h1>
            <div class="card-tools">
                @can('role-create')
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
                @endcan
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered" style="margin-left: 20px">
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Details</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->detail }}</td>
                    <td>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('products.show', $product->id) }}">Show</a>
                            @can('product-edit')
                                <a class="btn btn-primary" href="{{ route('products.edit', $product->id) }}">Edit</a>
                            @endcan
                            @csrf
                            @method('DELETE')
                            @can('product-delete')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            @endcan
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {!! $products->links() !!}
    </div>
@endsection

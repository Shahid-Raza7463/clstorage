@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Blogs</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/blog/create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>

            <div class="card-body">
                @csrf
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks">
                        <tr class="text-center">
                            <th>Id</th>
                            <th>Title</th>
                            <th>Preview image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($data as $d)
                            <tr>
                                <td class="text-center">{{ $d['id'] }}</td>
                                <td>{{ $d['title'] }}</td>
                                <td class="text-center">
                                    <img src="{{ asset($d['preview_image']) }}" alt="Preview Image"
                                        style="max-width: 50px; max-height: 25px;">
                                </td>
                                <td>
                                    <div class="d-flex"
                                        style="
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;">
                                        <div class="card-tools  mx-2">
                                            <a href="{{ url('admin/blog/' . $d['id']) }}" class="btn btn-sm"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;    background-color: #5d9531cc; color:white">
                                                <i class="fa fa-eye"></i> View
                                            </a>
                                        </div>
                                        <div class="card-tools">
                                            <a href="{{ url('admin/blog/' . $d['id']) . '/edit' }}"
                                                class="btn btn-sm btn-primary"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>

                                        <form action="{{ url('admin/blog/' . $d['id']) }}" method="post" class="form1"
                                            style="margin:0px;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="deleteButton btn btn-sm btn-danger mx-2"
                                                onclick="showConfirmation(event)"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

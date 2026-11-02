<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Latest Offers</h3>
                <div class="card-tools">
                    {{-- <a href="{{ url('admin/blog/create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a> --}}
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


                            <th>Title</th>
                            <th>Payout</th>
                            <th>Countries</th>
                            <th>Images</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($data as $d)
                            <tr>
                                <td> {{ $d->title }}</td>
                                <td> {{ $d->payout }}</td>
                                <td>
                                    <div style="width: 58px; overflow: hidden; height: 56px;">
                                        {{ $d->countries }}
                                    </div>
                                </td>
                                <td> {{ $d->offer_image }}</td>
                                <td>
                                    @if ($d->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="card-tools">
                                            <a href="{{ url('admin/offers/' . $d->id) . '/edit' }}"
                                                class="btn btn-sm btn-primary"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>

                                        <form action="{{ url('admin/offers/' . $d->id) }}" method="post" class="form1">
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

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Home Page Carousel</h3>

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
                        <tr>
                            <th class="text-center">Image Url</th>
                            <th>Network Name</th>
                            <th>Expired At</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($data as $d)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset($d->image_url) }}" alt="Preview Image"
                                        style="max-width: 100px; max-height: 50px;">
                                </td>
                                <td>{{ $d->network_name }}</td>
                                {{-- expired functionality --}}
                                <td>
                                    @php
                                        // Get Expire date from database
                                        $expiredDate = new DateTime($d->expired_at);
                                        // Get current date from database
                                        $currentDate = new DateTime();
                                    @endphp

                                    {{ $d->expired_at }}
                                    {{-- check expired date is coming or already passed --}}
                                    @if ($currentDate < $expiredDate)
                                        @php
                                            // Get days in form of array
                                            $interval = $currentDate->diff($expiredDate);
                                            // Get remainig days
                                            $daysRemaining = $interval->days;
                                            //    here days; coming from $interval array
                                        @endphp
                                        <span class="badge bg-success" style="    font-size: 9px;">{{ $daysRemaining }} days
                                            left</span>
                                    @else
                                        <span class="badge bg-danger" style="    font-size: 9px;">Expired</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($d->status == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="card-tools">
                                            <a href="{{ url('admin/adspaces/' . $d->id) . '/edit' }}"
                                                class="btn btn-sm btn-primary"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>

                                        <form action="{{ url('admin/adspaces/' . $d->id) }}" method="post" class="form1">
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

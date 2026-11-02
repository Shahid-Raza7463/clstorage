<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3" style="width:1136px">
        <div class="card card-default" style="width: fit-content">
            <div class="card-header">
                <h3 class="card-title mt-3">All Top Network</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/networks-list/create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
            {{-- search input and button,for searching networks --}}



            <div class="card-body">
                <!--Display success massage for user -->
                @csrf
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- data display on the page from the database -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks">
                        <tr>
                            <th>Name</th>
                            <th>Url</th>
                            <th>Description</th>
                            <th>Offer Count</th>
                            <th>Min Payout</th>
                            <th>Referral Commission</th>
                            <th>Software</th>
                            <th>Status</th>
                            <th>Top</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($data as $d)
                            <tr>

                                <td> {{ $d->network_name }}</td>

                                <td>
                                    <div style="width: 58px;
                                        overflow: hidden;">
                                        {{ $d->network_url }}
                                    </div>
                                </td>
                                <td>
                                    <div style="height: 58px;
                                        overflow: hidden;">
                                        {{ $d->network_description }}
                                    </div>
                                </td>
                                <td> {{ $d->offer_count }}</td>
                                <td> {{ $d->min_payout }}</td>
                                <td> {{ $d->referral_commission }}</td>
                                <td> {{ $d->affiliate_tracking_software }}</td>
                                {{-- status --}}
                                <td>
                                    @if ($d->status == 0)
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif ($d->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                {{-- top_network --}}
                                <td>
                                    @if ($d->is_top_network == 0)
                                        <p>0</p>
                                    @else
                                        <span class="badge bg-success">Top</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="card-tools">
                                            <a href="{{ url('admin/networks-list/' . $d->network_id) . '/edit' }}"
                                                class="btn btn-sm btn-primary"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>
                                        <form action="{{ url('admin/networks-list/' . $d->network_id) }}" method="post"
                                            class="form1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="deleteButton btn btn-sm btn-danger mx-2"
                                                onclick="showConfirmation(event)"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;"><i
                                                    class="fa fa-trash"></i> Delete</button>
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

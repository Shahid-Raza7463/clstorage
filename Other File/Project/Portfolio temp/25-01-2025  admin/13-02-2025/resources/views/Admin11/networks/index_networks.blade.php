<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3" style="width:1136px">
        <div class="card card-default" style="width: fit-content">
            <div class="card-header">
                <h3 class="card-title mt-3">Networks</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/networks-list/create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
            {{-- search input and button,for searching networks --}}

            <div class="col-md-6 mt-3">
                <form action="" class="d-flex col-9">
                    <input type="search" name="search" placeholder="Search Network" class="form-control p-1 b_link"
                        value="{{ $search }}">
                    <button class="mx-1 btn btn-sm btn-primary">Search</button>
                </form>
            </div>

            <div class="card-body">
                <!--Display success massage for user -->
                @csrf
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Get Bulk Action -->
                <form action="{{ route('networks-list.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
                    @csrf
                    <div class="btn-group mb-3">
                        <input type="hidden" name="selected_items" id="selected_items_input" value="">
                        <select name="action" class="form-select form-select-sm">
                            <option value="delete">Delete Selected</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-danger">Apply</button>
                    </div>
                </form>
                {{-- this Script for Get bulk action --}}
                <script>
                    function collectSelectedItems() {
                        const selectedItems = [];
                        const checkboxes = document.querySelectorAll('input[name="selected_items[]"]:checked');

                        checkboxes.forEach(checkbox => {
                            selectedItems.push(checkbox.value);
                        });

                        // Set the collected selected items in a hidden input field
                        document.getElementById('selected_items_input').value = JSON.stringify(selectedItems);
                    }
                </script>
                <!-- Get Bulk Action -->
                <!-- data display on the page from the database -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks">
                        <tr>
                            <th>Select</th>
                            <th>Network ID </th>
                            <th>Network Name</th>
                            <th>Network Type </th>
                            <th>Network Url</th>
                            <th>Network Description</th>
                            <th>Offer Count</th>
                            <th>Min Payout</th>
                            <th>Referral Commission</th>
                            <th>Affiliate Tracking Software</th>
                            <th>Status</th>
                            <th>Sponsored</th>
                            <th>Top Network</th>
                            <th>Featured</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($data as $d)
                            <tr>
                                {{-- Get Check box for bulk action --}}
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selected_items[]"
                                            value="{{ $d['network_id'] }}" style="    border: 1px #00000080 solid;">
                                    </div>
                                </td>
                                <td>{{ $d['network_id'] }}</td>
                                <td>{{ $d['network_name'] }}</td>
                                <td>{{ $d['network_type'] }}</td>
                                <td>
                                    <div style="width: 58px;
                                        overflow: hidden;">
                                        {{ $d['network_url'] }}
                                    </div>
                                </td>
                                <td>
                                    <div style="height: 58px;
                                        overflow: hidden;">
                                        {{ $d['network_description'] }}
                                    </div>
                                </td>
                                <td>{{ $d['offer_count'] }}</td>
                                <td>{{ $d['min_payout'] }}</td>
                                <td>{{ $d['referral_commission'] }}</td>
                                <td>{{ $d['affiliate_tracking_software'] }}</td>
                                {{-- status --}}
                                <td>
                                    @if ($d['status'] == 0)
                                        <span class="badge bg-secondary">Pending</span>
                                    @elseif ($d['status'] == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @else
                                        <span class="badge bg-danger">Rejected</span>
                                    @endif
                                </td>
                                {{-- sponsored --}}
                                <td>
                                    @if ($d['is_sponsored'] == 0)
                                        <p>0</p>
                                    @else
                                        <span class="badge bg-success">Sponsored</span>
                                    @endif
                                </td>
                                {{-- top_network --}}
                                <td>
                                    @if ($d['is_top_network'] == 0)
                                        <p>0</p>
                                    @else
                                        <span class="badge bg-success">Top</span>
                                    @endif
                                </td>
                                {{-- is_featured --}}
                                <td>
                                    @if ($d['is_featured'] == 0)
                                        <p>0</p>
                                    @else
                                        <span class="badge bg-success">Featured</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="card-tools">
                                            <a href="{{ url('admin/networks-list/' . $d['network_id']) . '/edit' }}"
                                                class="btn btn-sm btn-primary"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>
                                        <form action="{{ url('admin/networks-list/' . $d['network_id']) }}" method="post"
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
                {{-- add pagination after table --}}
                <div class="pagination justify-content-center">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

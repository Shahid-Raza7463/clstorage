<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Offers Api</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/offers-api/create') }}" class="btn btn-sm btn-success">
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
                <!-- Get Bulk Action -->
                <form action="{{ route('offers-api.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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

                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks">
                        <tr>
                            <th>Select</th>
                            <th>Id</th>
                            <th>Api Url</th>
                            <th>Tracking Software</th>
                            <th>Frequency</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($data as $d)
                            <tr>
                                {{-- Get Check box for bulk action --}}
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="selected_items[]"
                                            value="{{ $d['id'] }}" style="    border: 1px #00000080 solid;">
                                    </div>
                                </td>
                                <td>{{ $d['id'] }}</td>
                                <td>
                                    <div style="width: 550px;
                                    overflow: hidden;">
                                        {{ $d['api_url'] }}
                                    </div>
                                </td>
                                <td>{{ $d['tracking_software'] }}</td>
                                <td>{{ $d['frequency'] }}</td>
                                <td>
                                    @if ($d['status'] == 0)
                                        <span class="badge bg-danger">Inactive</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="card-tools">
                                            <a href="{{ url('admin/offers-api/' . $d['id']) . '/edit' }}"
                                                class="btn btn-sm btn-primary"
                                                style="height: 21px;
                                                    width: 3rem; font-size: 8px;">
                                                <i class="fa fa-pen"></i> Edit
                                            </a>
                                        </div>
                                        <form action="{{ url('admin/offers-api/' . $d['id']) }}" method="post"
                                            class="form1">
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

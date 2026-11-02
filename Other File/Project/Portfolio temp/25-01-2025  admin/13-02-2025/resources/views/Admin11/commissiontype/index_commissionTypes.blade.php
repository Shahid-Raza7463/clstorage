@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Commission Type</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/commissiontype/create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>

            <div class="card-body">
                <!-- Display success message for user -->
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Get Bulk Action -->
                <form action="{{ route('commissiontype.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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

                <!-- Data display from database -->
                <div class="row">
                    <div class="col-6">
                        <table class="table table-bordered table-hover table-darks">
                            <tr>
                                <th>Select</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($data as $d)
                                <tr>
                                    {{-- Get Check box for bulk action --}}
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="selected_items[]"
                                                value="{{ $d['id'] }}">

                                        </div>
                                    </td>
                                    <td>{{ $d['id'] }}</td>
                                    <td>{{ $d['name'] }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="card-tools">
                                                <a href="{{ url('admin/commissiontype/' . $d['id']) . '/edit' }}"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="fa fa-pen"></i> Edit
                                                </a>
                                            </div>
                                            <form action="{{ url('admin/commissiontype/' . $d['id']) }}" method="post"
                                                class="form1">
                                                @csrf
                                                @method('DELETE')
                                                @can('network-software-delete')
                                                    <button type="submit" class=" deleteButton btn btn-sm btn-danger mx-2"
                                                        onclick="showConfirmation(event)"><i class="fa fa-trash"></i>
                                                        Delete</button>
                                                @endcan
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
    </div>
@endsection

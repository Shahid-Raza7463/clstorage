<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">All Network Software</h3>
                <div class="card-tools">
                    {{-- permission  --}}
                    @can('network-software-create')
                        <a href="{{ url('admin/networksoftware/create') }}" class="btn btn-sm btn-success">
                            <i class="fa fa-plus"></i>Add
                        </a>
                    @endcan
                </div>
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
                <form action="{{ route('networksoftware.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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
                <!-- Get Bulk Action end hare -->
                {{-- yajra datatable --}}
                <div class="container">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <style>
                    .action-td {
                        display: flex;
                        margin-left: 5px;
                    }
                </style>
                <script>
                    $(function() {
                        $('#table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: '{{ route('networksoftware.index') }}',
                            columns: [{
                                    data: 'select',
                                    name: 'select',
                                    orderable: false,
                                    searchable: false,
                                    render: function(data, type, full, meta) {
                                        return '<div class="form-check">' +
                                            '<input class="form-check-input" type="checkbox" name="selected_items[]" ' +
                                            'value="' + full.id + '" style="border: 1px #00000080 solid;">' +
                                            '</div>';
                                    }
                                },
                                {
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    className: 'action-td',
                                    orderable: false,
                                    searchable: false
                                },
                            ]
                        });
                    });
                </script>

            </div>
        </div>
    </div>
@endsection

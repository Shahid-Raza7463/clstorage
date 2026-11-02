{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous"> --}}
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">All Projects</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/projects/create') }}" class="btn btn-sm btn-success">
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
                <form action="{{ route('projects.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks" id="table">
                        <thead>
                            <th>Select</th>
                            <th>category_id</th>
                            <th>projectname</th>
                            <th>projectlurl</th>
                            <th>projectmage</th>
                            <th>projectimagezoom</th>
                            <th>categoryname</th>
                            <th>companyname</th>
                            <th>projectenddate</th>
                            <th>toolsandtechnologies</th>
                            <th>descreption</th>
                            <th>highlightnote1</th>
                            <th>highlightnote2</th>
                            <th>listdescreption</th>
                            <th>listheading</th>
                            <th>listdescreption2</th>
                            <th>listheading2</th>
                            <th>anotherdescreption</th>
                            <th>status</th>
                            <th>Action</th>
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
                            ajax: '{{ route('projects.index') }}',
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
                                    data: 'category_id',
                                    name: 'category_id'
                                },
                                {
                                    data: 'projectname',
                                    name: 'projectname'
                                },
                                {
                                    data: 'projectlurl',
                                    name: 'projectlurl'
                                },
                                {
                                    data: 'projectmage',
                                    name: 'projectmage',
                                    render: function(data, type, full, meta) {
                                        var imagePath = '{{ asset('') }}/' +
                                            data;
                                        return '<img src="' + imagePath +
                                            '" alt="Image" style="max-width: 50px; max-height: 25px;">';
                                    }
                                },
                                {
                                    data: 'projectimagezoom',
                                    name: 'projectimagezoom',
                                    render: function(data, type, full, meta) {
                                        var imagePath = '{{ asset('') }}/' +
                                            data;
                                        return '<img src="' + imagePath +
                                            '" alt="Image" style="max-width: 50px; max-height: 25px;">';
                                    }
                                },
                                {
                                    data: 'categoryname',
                                    name: 'categoryname'
                                },
                                {
                                    data: 'companyname',
                                    name: 'companyname'
                                },
                                {
                                    data: 'projectenddate',
                                    name: 'projectenddate'
                                },
                                {
                                    data: 'toolsandtechnologies',
                                    name: 'toolsandtechnologies'
                                },
                                {
                                    data: 'descreption',
                                    name: 'descreption'
                                },
                                {
                                    data: 'highlightnote1',
                                    name: 'highlightnote1'
                                },
                                {
                                    data: 'highlightnote2',
                                    name: 'highlightnote2'
                                },
                                {
                                    data: 'listdescreption',
                                    name: 'listdescreption'
                                },
                                {
                                    data: 'listheading',
                                    name: 'listheading'
                                },
                                {
                                    data: 'listdescreption2',
                                    name: 'listdescreption2'
                                },
                                {
                                    data: 'listheading2',
                                    name: 'listheading2'
                                },
                                {
                                    data: 'anotherdescreption',
                                    name: 'anotherdescreption'
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                    render: function(data, type, full, meta) {
                                        if (data == 0) {
                                            return '<span class="badge bg-danger">Inactive</span>';
                                        } else {
                                            return '<span class="badge bg-success">Active</span>';
                                        }
                                    }
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

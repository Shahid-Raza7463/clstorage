@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">All About</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/about/create') }}" class="btn btn-sm btn-success">
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
                <form action="{{ route('about.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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

                {{-- yajra datatable --}}
                {{-- <div class="container"> --}}
                <div class="table-responsive">
                    <table class="table table-bordered" id="table">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>teammember_id</th>
                                <th>description</th>
                                <th>image</th>
                                <th>skillheading</th>
                                <th>skilldescription1</th>
                                <th>skilldescription2</th>
                                <th>websitelink</th>
                                <th>cityname</th>
                                <th>degree</th>
                                <th>freelance</th>
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
                            ajax: '{{ route('about.index') }}',
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
                                    data: 'teammember_id',
                                    name: 'teammember_id'
                                },
                                {
                                    data: 'description',
                                    name: 'description'
                                },
                                {
                                    data: 'image',
                                    name: 'image',
                                    render: function(data, type, full, meta) {
                                        var imagePath = '{{ asset('') }}/' +
                                            data;
                                        return '<img src="' + imagePath +
                                            '" alt="Image" style="max-width: 50px; max-height: 25px;">';
                                    }
                                },
                                {
                                    data: 'skillheading',
                                    name: 'skillheading'
                                },
                                {
                                    data: 'skilldescription1',
                                    name: 'skilldescription1'
                                },
                                {
                                    data: 'skilldescription2',
                                    name: 'skilldescription2'
                                },
                                {
                                    data: 'websitelink',
                                    name: 'websitelink'
                                },
                                {
                                    data: 'cityname',
                                    name: 'cityname'
                                },
                                {
                                    data: 'degree',
                                    name: 'degree'
                                },
                                {
                                    data: 'freelance',
                                    name: 'freelance'
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

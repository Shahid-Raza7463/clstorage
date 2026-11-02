<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">All Adspaces</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/adspaces/create') }}" class="btn btn-sm btn-success">
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
                <form action="{{ route('adspaces.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks" id="table">
                        <thead>
                            <th>Select</th>
                            <th>Network</th>
                            <th>Position</th>
                            <th>Image Url</th>
                            <th>Link</th>
                            <th>Status</th>
                            <th>Expired At</th>
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
                            ajax: '{{ route('adspaces.index') }}',
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
                                    data: 'network_name',
                                    name: 'network_name'
                                },
                                {
                                    data: 'position',
                                    name: 'position',
                                    render: function(data, type, full, meta) {
                                        if (data == 'top_left') {
                                            return 'Network Of The Months';
                                        } else if (data == 'top_right') {
                                            return 'Carousel';
                                        } else if (data == 'top_middle_1') {
                                            return 'In Page Ads';
                                        } else if (data == 'right_side_1') {
                                            return 'Sponsored';
                                        } else if (data == 'right_side_2') {
                                            return 'Sponsored Small';
                                        } else if (data == 'right_side_4') {
                                            return 'Featured Networks';
                                        } else if (data == 'offers_top_right') {
                                            return 'offers crausel';
                                        } else if (data == 'reviews_top_right') {
                                            return 'reviews crausel';
                                        }
                                    }
                                },
                                {
                                    data: 'image_url',
                                    name: 'image_url',
                                    render: function(data, type, full, meta) {
                                        var imagePath = '{{ asset('') }}/' +
                                            data;
                                        return '<img src="' + imagePath +
                                            '" alt="Image" style="max-width: 100px; max-height: 50px;">';
                                    }
                                },
                                {
                                    data: 'link',
                                    name: 'link'
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
                                // expired functionality
                                {
                                    data: 'expired_at',
                                    name: 'expired_at',
                                    render: function(data, type, full, meta) {
                                        // Get expired at data from database
                                        var expiredDate = new Date(data);
                                        // Get the current date
                                        var currentDate = new Date();
                                        // check expired date is coming or already passed 
                                        if (currentDate < expiredDate) {
                                            // Calculate the difference in days
                                            var timeDifference = expiredDate.getTime() - currentDate.getTime();
                                            var daysRemaining = Math.ceil(timeDifference / (1000 * 3600 * 24));

                                            // Display the remaining days
                                            return data +
                                                ' <span class="badge bg-success" style="font-size: 9px;">' +
                                                daysRemaining + ' days left</span>';
                                        } else {
                                            return data +
                                                ' <span class="badge bg-danger" style="font-size: 9px;">Expired</span>';
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

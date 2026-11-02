<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">All Reviews</h3>
            </div>

            <div class="card-body">
                <!-- Display success massage for user -->
                @csrf
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <!-- Get Bulk Action -->
                <form action="{{ route('reviewslist.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()">
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
                <!-- Get Bulk Action end -->

                {{-- yajra datatable --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks" id="table">
                        <thead>
                            <th>Select</th>
                            <th>Network Name</th>
                            <th>User Name</th>
                            <th>All Rating</th>
                            <th>Offer Rating</th>
                            <th>Payout Rating</th>
                            <th>Tracking Rating</th>
                            <th>Support Rating</th>
                            <th>Review Text</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>

                <script>
                    $(function() {
                        $('#table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: '{{ route('reviewslist.index') }}',
                            columns: [{
                                    data: 'select',
                                    name: 'select',
                                    orderable: false,
                                    searchable: false,
                                    render: function(data, type, full, meta) {
                                        return '<div class="form-check">' +
                                            '<input class="form-check-input" type="checkbox" name="selected_items[]" ' +
                                            'value="' + full.review_id +
                                            '" style="border: 1px #00000080 solid;">' +
                                            '</div>';
                                    }
                                },
                                {
                                    data: 'network_name',
                                    name: 'network_name'
                                },
                                {
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'all_rating',
                                    name: 'all_rating'
                                },
                                {
                                    data: 'offer_rating',
                                    name: 'offer_rating'
                                },
                                {
                                    data: 'payout_rating',
                                    name: 'payout_rating'
                                },
                                {
                                    data: 'tracking_rating',
                                    name: 'tracking_rating'
                                },
                                {
                                    data: 'support_rating',
                                    name: 'support_rating'
                                },
                                {
                                    data: 'review_text',
                                    name: 'review_text',
                                    render: function(data, type, full, meta) {
                                        return '<div style="height: 58px; overflow: hidden;">' +
                                            data +
                                            '</div>';
                                    }
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                    render: function(data, type, full, meta) {
                                        if (data == 0) {
                                            return '<span class="badge bg-secondary">Pending</span>';
                                        } else if (data == 1) {
                                            return ' <span class="badge bg-success">Approved</span>';
                                        } else {
                                            return '<span class="badge bg-danger">Rejected</span>';
                                        }
                                    }
                                },
                                {
                                    data: 'action',
                                    name: 'action',
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

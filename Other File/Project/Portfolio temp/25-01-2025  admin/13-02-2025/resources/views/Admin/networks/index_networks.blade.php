@extends('Admin.template')
@section('content')
    <div class="container mt-3" style="width:1136px">
        <div class="card card-default" style="width: fit-content">
            <div class="card-header">
                <h3 class="card-title mt-3">All Networks</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/networks-list/create') }}" class="btn btn-sm btn-success">
                        <i class="fa fa-plus"></i> Add
                    </a>
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
                <!-- Get Bulk Action end hare -->

                {{-- yajra datatable --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-darks" id="table">
                        <thead>
                            <th>Select</th>
                            <th>Name</th>
                            <th>Type </th>
                            <th>Url</th>
                            <th>Description</th>
                            <th>Offer Count</th>
                            <th>Min Payout</th>
                            <th>Referral Commission</th>
                            <th>Software</th>
                            <th>Status</th>
                            <th>Sponsored</th>
                            <th>Top</th>
                            <th>Featured</th>
                            <th>Action</th>
                        </thead>
                    </table>
                </div>

                <script>
                    $(function() {
                        $('#table').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: '{{ route('networks-list.index') }}',
                            columns: [{
                                    data: 'select',
                                    name: 'select',
                                    orderable: false,
                                    searchable: false,
                                    render: function(data, type, full, meta) {
                                        return '<div class="form-check">' +
                                            '<input class="form-check-input" type="checkbox" name="selected_items[]" ' +
                                            'value="' + full.network_id +
                                            '" style="border: 1px #00000080 solid;">' +
                                            '</div>';
                                    }
                                },
                                {
                                    data: 'network_name',
                                    name: 'network_name'
                                },
                                {
                                    data: 'network_type',
                                    name: 'network_type',
                                    render: function(data, type, full, meta) {
                                        if (data == 0) {
                                            return '<p>Affiliate Network</p>';
                                        } else if (data == 1) {
                                            return '<p>Affiliate Program</p>';
                                        } else {
                                            return '<p>Advertising</p>';
                                        }
                                    }
                                },
                                {
                                    data: 'network_url',
                                    name: 'network_url',
                                    render: function(data, type, full, meta) {
                                        return '<div style="width: 58px; overflow: hidden;">' +
                                            data +
                                            '</div>';
                                    }
                                },
                                {
                                    data: 'network_description',
                                    name: 'network_description',
                                    render: function(data, type, full, meta) {
                                        return '<div style="height: 58px;overflow: hidden;">' +
                                            data +
                                            '</div>';
                                    }
                                },
                                {
                                    data: 'offer_count',
                                    name: 'offer_count'
                                },
                                {
                                    data: 'min_payout',
                                    name: 'min_payout'
                                },
                                {
                                    data: 'referral_commission',
                                    name: 'referral_commission'
                                },
                                {
                                    data: 'affiliate_tracking_software',
                                    name: 'affiliate_tracking_software'
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
                                //   sponsored 
                                {
                                    data: 'is_sponsored',
                                    name: 'is_sponsored',
                                    render: function(data, type, full, meta) {
                                        if (data == 0) {
                                            return ' <p>0</p>';
                                        } else {
                                            return ' <span class="badge bg-success">Sponsored</span>';
                                        }
                                    }
                                },
                                //    top_network
                                {
                                    data: 'is_top_network',
                                    name: 'is_top_network',
                                    render: function(data, type, full, meta) {
                                        if (data == 0) {
                                            return ' <p>0</p>';
                                        } else {
                                            return ' <span class="badge bg-success">Top</span>';
                                        }
                                    }
                                },
                                //    is_featured
                                {
                                    data: 'is_featured',
                                    name: 'is_featured',
                                    render: function(data, type, full, meta) {
                                        if (data == 0) {
                                            return ' <p>0</p>';
                                        } else {
                                            return ' <span class="badge bg-success">Featured</span>';
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

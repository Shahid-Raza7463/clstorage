@extends('Admin.template')
@section('content')
    <div class="card card-default">
        <div class="card-header" style="margin-top: 10px;">
            <h1 class="card-title" style="font-size: 23px !important;">Users Management</h1>
            <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">
                    <i class="fa fa-plus"></i> Add
                </a>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        {{-- Get message for bulk action deleted action perform --}}
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        <!-- Get Bulk Action -->
        <form action="{{ route('users.bulk-action') }}" method="POST" onsubmit="collectSelectedItems()"
            style="margin-left: 20px">
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
                    <th>id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Action</th>
                </thead>
            </table>
        </div>

        <script>
            $(function() {
                $('#table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('users.index') }}',
                    columns: [{
                            data: 'select',
                            name: 'select',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                return '<div class="form-check">' +
                                    '<input class="form-check-input" type="checkbox" name="selected_items[]" ' +
                                    'value="' + full.id +
                                    '" style="border: 1px #00000080 solid;">' +
                                    '</div>';
                            }
                        },
                        {
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        // Get roles functionality
                        {
                            data: 'roles',
                            name: 'roles',
                            render: function(data, type, full, meta) {
                                // Split roles into an array
                                var rolesArray = data.split(', ');
                                var badgesHtml = '';
                                // Get roles from rolesarray
                                rolesArray.forEach(function(role) {
                                    badgesHtml += '<span class="badge rounded-pill bg-dark">' +
                                        role +
                                        '</span> ';
                                });
                                return badgesHtml;
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



        {{-- <table class="table table-bordered" style="margin-left: 20px">
            <tr>
                <th>Select</th>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Roles</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($data as $key => $user)
                <tr>
           
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selected_items[]"
                                value="{{ $user->id }}" style="    border: 1px #00000080 solid;">
                        </div>
                    </td>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if (!empty($user->getRoleNames()))
                            @foreach ($user->getRoleNames() as $v)
                                <span class="badge rounded-pill bg-dark">{{ $v }}</span>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </table> --}}
        {{-- {!! $data->render() !!} --}}
    </div>
@endsection

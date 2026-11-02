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
        <!-- Get Bulk Action -->
        <table class="table table-bordered" style="margin-left: 20px">
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            @foreach ($data as $key => $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('users.show', $user->id) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('users.edit', $user->id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

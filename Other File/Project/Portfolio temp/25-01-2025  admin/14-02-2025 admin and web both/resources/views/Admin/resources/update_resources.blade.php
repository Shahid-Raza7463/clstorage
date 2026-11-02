<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
@extends('Admin.template')
@section('content')
    <div class="container mt-3">
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title mt-3">Edit Resources</h3>
                <div class="card-tools">
                    <a href="{{ url('admin/resourcelist') }}" class="btn btn-sm btn-success"> All </a>
                </div>
            </div>
            <!--display error massage for user -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!--  Display success massage for user -->
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <!--update existing data to the user by this form -->

            <div class="form-container m-3">
                <form action="{{ url('/') }}/admin/resourcelist/{{ $id }}" method="post">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-6 d-flex flex-column mb-2">
                            <label for="">Categories Title:</label>
                            <select class="form-control" name="" id="categories_select">
                                @foreach ($categoriesTitle as $d)
                                    <option value="{{ $d['id'] }}">
                                        {{ $d['id'] }} -
                                        {{ $d['categories_title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row" id="hide-div">
                        <div class="col-6 d-flex flex-column mb-2">
                            <label for="">Sub Title:</label>
                            <select class="form-control" name="" id="sub_title_select">
                                <!-- Sub-titles will be dynamically populated here -->
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <input class="form-control" type="text" name="parent_id" id="parent_id"
                                placeholder="Enter Parent id">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Title:</label>
                            <input class="form-control" type="text" name="categories_title" placeholder="Enter Title"
                                value="{{ $resourcelist->categories_title }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Link</label>
                            <input class="form-control" type="text" name="link" placeholder="Link"
                                value="{{ $resourcelist->link }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Description</label>
                            <input class="form-control" type="text" name="description" placeholder="Description"
                                value="{{ $resourcelist->description }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 d-flex flex-column  mb-2">
                            <label for="">Status:</label>
                            <select name="status" class="form-control">
                                <option {{ $resourcelist->status == 0 ? 'selected' : '' }} value="0">Inactive
                                </option>
                                <option {{ $resourcelist->status == 1 ? 'selected' : '' }} value="1">Active
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6">
                            <input type="submit" class="btn btn-success btn-md" name="submit" value="Save">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


{{-- get dynamically value in select box when categories_title select   --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Get references to the select boxes and parent_id input
        var categoriesSelect = $("#categories_select");
        var subTitleSelect = $("#sub_title_select");
        var parentIdInput = $("#parent_id");
        var subTitleDiv = $("#hide-div");

        // Define the function to update the sub-title select box
        function updateSubTitleSelectBox() {
            var selectedCategoryID = categoriesSelect.val();
            var subTitles = {!! json_encode($subTitle) !!};

            // Clear the existing options in the sub-title select box
            subTitleSelect.empty();

            // Add the relevant sub-titles based on the selected category
            for (var i = 0; i < subTitles.length; i++) {
                if (subTitles[i].parent_id == selectedCategoryID) {
                    subTitleSelect.append($("<option>", {
                        value: subTitles[i].id,
                        text: subTitles[i].categories_title
                    }));
                }
            }

            // Trigger the change event on sub_title select box to update the parent_id input
            // subTitleSelect.change();

            if (subTitleSelect.val() == null || subTitleSelect.val() == '') {
                // subTitleSelect.hide();
                subTitleDiv.hide();

                parentIdInput.val(categoriesSelect.val());
            } else {
                subTitleDiv.show();
                subTitleSelect.prepend($("<option>", {
                    value: '',
                    text: "Non"
                }));

                parentIdInput.val(subTitleSelect.val());
            }


        }

        // Call the function to populate the sub-title select box initially
        updateSubTitleSelectBox();

        // Listen for changes in the categories title select box and update the sub-title select box accordingly
        categoriesSelect.change(function() {
            updateSubTitleSelectBox();
        });

        // Listen for changes in the sub-title select box and update the parent_id input
        subTitleSelect.change(function() {
            if (subTitleSelect.val() == null || subTitleSelect.val() == '') {
                // subTitleSelect.hide();
                parentIdInput.val(categoriesSelect.val());
            } else {
                subTitleSelect.prepend($("<option>", {
                    value: '',
                    text: "Non"
                }));
                subTitleDiv.show();
                parentIdInput.val(subTitleSelect.val());
            }

        });
    });
</script>

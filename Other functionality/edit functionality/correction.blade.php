{{-- library  --}}
<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">


@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="body-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header" style="background:#37A000">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color:white" class="fs-17 font-weight-600 mb-0">Update Time sheet</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <form id="detailsForm" method="post" action="{{ url('/timesheet/submit') }}"
                            enctype="multipart/form-data" style="margin-bottom: 0px;">
                            @csrf

                            <div class="modal-body">

                                <br>

                                <div class="row row-sm">

                                    <div class="col-sm-6">
                                        <label for="">Select Client</label>

                                        <select class="language form-control" name="client_id[]" id="category"
                                            @if (Request::is('timesheet/*/edit')) > <option disabled style="display:block">Select
                                        Client
                                        </option>
                    
                                        @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}"
                                            {{ $timesheet->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                            {{ $clientData->client_name }}</option>
                                        @endforeach
                    
                    
                                        @else
                                        <option></option>

                                        <option value="">Select Client</option>
                                        @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}"
                                            {{ $timesheetedit[0]->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                            {{ $clientData->client_name }}</option>
                    
                                        @endforeach @endif
                                            </select>
                                    </div>
                                    {{-- <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Client *</label>
                                            <select class="language search_test" id="category" name="client_id"
                                                @if (Request::is('assignmentmapping/*/edit')) > <option disabled style="display:block">Please Select One
                                                </option>
                                
                                                @foreach ($client as $clientData)
                                                <option value="{{ $clientData->id }}"
                                                    {{ $assignmentmapping->client->id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                                    {{ $clientData->client_name }} </option>
                                                @endforeach
                                
                                
                                                @else
                                                
                                                <option></option>
                                                <option value="">Please Select One</option>
                                                @foreach ($client as $clientData)
                                                <option value="{{ $clientData->id }}"
                                                    {{ $timesheetedit[0]->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                                    {{ $clientData->client_name }} </option>
                                
                                                @endforeach @endif
                                                </select>
                                        </div>
                                    </div> --}}
                                    {{-- <label for="name" class="col-sm-3 col-form-label font-weight-600">Name :</label> --}}
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Assignment *</label>
                                            <select class="form-control" id="subcategory_id" name="assignment_id">

                                                @if (!empty($timesheetedit[0]->assignment_id))
                                                    @php
                                                        $assignment = app('App\Models\Assignment')
                                                            ->where('id', $timesheetedit[0]->assignment_id)
                                                            ->first();
                                                    @endphp
                                                    @if ($assignment)
                                                        <option value="{{ $timesheetedit[0]->assignment_id }}">
                                                            {{ $assignment->assignment_name }}
                                                        </option>
                                                    @endif
                                                @endif

                                                {{-- <option value="{{ $clientData->id }}"
                                                    {{ $timesheetedit[0]->client_id == $clientData->id ?? '' ? 'selected="selected"' : '' }}>
                                                    {{ $clientData->client_name }}</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row row-sm">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-600">Partner *</label>
                                            <select required class="language form-control" id="partner" name="partner[]">
                                                @if (!empty($timesheetedit[0]->partner))
                                                    @php
                                                        $assignment = app('App\Models\Teammember')
                                                            ->where('id', $timesheetedit[0]->partner)
                                                            ->first();
                                                    @endphp
                                                    @if ($assignment)
                                                        <option value="{{ $timesheetedit[0]->partner }}">
                                                            {{ $assignment->team_member }}
                                                        </option>
                                                    @endif
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Employee Name</label>
                                        <input required type="text" name="workitem" id="workitem" class="form-control"
                                            value="{{ $timesheetedit[0]->team_member }}" placeholder="Enter Employee Name">
                                    </div>
                                </div>
                                <br>

                                <div class="row row-sm">
                                    <div class="col-sm-6">
                                        <label for="">Location</label>
                                        <input required type="text" name="location" id="location"
                                            value="{{ $timesheetedit[0]->location }}" class="form-control"
                                            placeholder="Enter Location">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="">Work Item</label>
                                        <input required type="text" name="totalhour" id="totalhour"
                                            value="{{ $timesheetedit[0]->workitem }}" class="form-control"
                                            placeholder="Enter Name">
                                    </div>
                                </div>
                                <br>
                                <div class="row row-sm">
                                    <div class="col-sm-6">
                                        <label for="">Total Hour</label>
                                        <input required type="text" name="location" id="location"
                                            value="{{ $timesheetedit[0]->hour }}" class="form-control"
                                            placeholder="Enter Location">
                                    </div>
                                </div>
                                <br>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                        </form>
                        <hr class="my-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(function() {
        $('#category').on('change', function() {
            var category_id = $(this).val();
            console.log(category_id);
            $.ajax({
                type: "GET",
                url: "{{ url('assignmentmapping/create') }}",
                data: "category_id=" + category_id,
                success: function(res) {
                    $('#subcategory_id').html(res);
                },
                error: function() {

                },
            });
        });

        // 22222222222
        $('#subcategory_id').on('change', function() {
            var assignment = $(this).val();
            // alert(assignment);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: "assignment=" + assignment,
                success: function(res) {
                    $('#partner').html(res);
                },
                error: function() {},
            });
        });

        // $('#subcategory_id').on('change', function() {
        //     var assignment = $(this).val();
        //     // alert(assignment);
        //     $.ajax({
        //         type: "get",
        //         url: "{{ url('assignmentmapping/create') }}",
        //         data: "assignment=" + assignment,
        //         success: function(res) {
        //             $('#partner').html(res);
        //         },
        //         error: function() {},
        //     });
        // });
        // 22222222222
    });
</script>

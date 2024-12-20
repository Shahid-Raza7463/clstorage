@extends('backEnd.layouts.layout') @section('backEnd_content')
    <div class="body-content">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card mb-4">
                    <div class="card-header" style="background: #37A000">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 style="color:white;" class="fs-17 font-weight-600 mb-0">Edit Confirmation</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ url('entriesupdated') }}" enctype="multipart/form-data">
                            @csrf
                            @component('backEnd.components.alert')
                            @endcomponent
                            <div class="row row-sm">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Unique</label>
                                        <input type="text" name="unique" value="{{ $entrieseditdata->unique ?? '' }}"
                                            class=" form-control" placeholder="Enter unique id">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Name</label>
                                        <input type="text" name="name" value="{{ $entrieseditdata->name ?? '' }}"
                                            class=" form-control" placeholder="Enter  name">
                                        <input type="hidden" name="id" value="{{ $entrieseditdata->id ?? '' }}"
                                            class=" form-control">
                                        <input type="hidden" name="assignmentgenerate_id"
                                            value="{{ $entrieseditdata->assignmentgenerate_id ?? '' }}"
                                            class=" form-control">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Entity Name</label>
                                        <input type="text" name="entityname"
                                            value="{{ $entrieseditdata->entityname ?? '' }}" class=" form-control"
                                            placeholder="Enter entityname">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Amount</label>
                                        <input type="text" name="amount" value="{{ $entrieseditdata->amount ?? '' }}"
                                            class=" form-control" placeholder="Enter amount">
                                    </div>
                                </div>
                            </div>

                            <div class="row row-sm">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Show/Hide</label>
                                        <select name="showorhide" class="form-control">
                                            @if ($entrieseditdata->amounthidestatus == '0')
                                                <option value="0">Hide</option>
                                                <option value="1">Show</option>
                                            @else
                                                <option value="1">Show</option>
                                                <option value="0">Hide</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Primary email</label>
                                        <input type="email" name="email" value="{{ $entrieseditdata->email ?? '' }}"
                                            class=" form-control" placeholder="Enter Primary email">
                                    </div>
                                </div>

                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Secondary email</label>
                                        <input type="email" name="secondaryemail"
                                            value="{{ $entrieseditdata->secondaryemail ?? '' }}" class=" form-control"
                                            placeholder="Enter Secondary Email">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Address</label>
                                        <input type="text" name="address" value="{{ $entrieseditdata->address ?? '' }}"
                                            class=" form-control" placeholder="Enter address">
                                    </div>
                                </div>
                            </div>
                            <div class="row row-sm">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Date</label>
                                        <input type="text" name="date" value="{{ $entrieseditdata->date ?? '' }}"
                                            class=" form-control" placeholder="Enter Date">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="font-weight-600">Year</label>
                                        <input type="text" name="year" value="{{ $entrieseditdata->year ?? '' }}"
                                            class=" form-control" placeholder="Enter year">
                                    </div>
                                </div>

                            </div>

                            <hr class="my-4">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success" style="float:right"> Submit</button>
                                <a class="btn btn-secondary"
                                    href="{{ url('/assignmentconfirmation/' . $entrieseditdata->assignmentgenerate_id) }}">
                                    Back</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/.body content-->
@endsection

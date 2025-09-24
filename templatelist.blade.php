{{-- <link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">

<link href="{{ url('backEnd/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/select2-bootstrap4/dist/select2-bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ url('backEnd/plugins/jquery.sumoselect/sumoselect.min.css') }}" rel="stylesheet">

@extends('backEnd.layouts.layout') @section('backEnd_content')
    <style>
        .dataTables_length {
            /* background-color: pink; */
            width: 300px;
            position: absolute;
        }
    </style>
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('kras') }}">Back</a></li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-user-add-outline"></i></div>
                <div class="media-body">
                    <a href="#">
                        <h1 class="font-weight-bold" style="color:black;">KRA Template Management Dashboard</h1>
                    </a>
                    <small>Manage Key Responsibility Areas</small>
                </div>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="card mb-4">
            @component('backEnd.components.alert')
            @endcomponent
            <div class="card-body">
                <div class="table-responsive">
                    <table id="examplee" class="table display table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="display: none;">id</th>
                                <th>Designation Name</th>
                                <th>Created By</th>
                                <th>Template Name</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kratemplates as $kratemplate)
                                <tr>
                                    <td style="display: none;">{{ $kratemplate->id }}</td>
                                    <td>{{ $kratemplate->designation_name }}</td>
                                    <td>{{ $kratemplate->team_member }}</td>
                                    <td>{{ $kratemplate->template_name }}</td>
                                    <td>{{ date('d-m-Y', strtotime($kratemplate->created_at)) }}</td>
                                    <td>{{ date('d-m-Y', strtotime($kratemplate->updated_at)) }}</td>
                                    <td>
                                        <a data-toggle="modal" data-id="{{ $kratemplate->id }}"
                                            data-template="{{ $kratemplate->template_name }}" data-target=".modalColumn"
                                            class="btn btn-info-soft btn-sm modificationColumn">
                                            <i class="far fa-edit"></i>
                                        </a>

                                        <a href="{{ url('kratemplatelist/delete/' . $kratemplate->id) }}"
                                            onclick="return confirm('Are you sure you want to delete this item?');"
                                            class="btn btn-danger-soft btn-sm">
                                            <i class="far fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Upload Modal -->
    <div class="modal modal-danger fade modalColumn" id="modalColumnId" tabindex="-1" role="dialog"
        aria-labelledby="modificationColumn" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="modalColumnForm" method="post" action="{{ url('kratemplatelist/edit') }}">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="modalLabel1">
                            KRAs Template Name Edit
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <label><b>Template Name: *</b></label>
                            <input type="text" required name="templatename" class="form-control"
                                placeholder="Enter new template name">

                            {{-- <input type="text" required name="templatename" class="form-control"
                                placeholder="Enter new template name"> --}}
                            <span id="template-error" class="text-danger"></span>

                            <input type="hidden" class="form-control" name="templateid" id="templateid">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success"
                            onclick="return confirm('Are you sure you want to update this template name?');">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
{{-- date sorting  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'lfrtip',
            columnDefs: [{
                targets: [0],
                orderable: false
            }],

            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Kras',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('c', sheet).each(function() {
                            var originalText = $(this).find('is t').text();
                            var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                            $(this).find('is t').text(cleanedText);
                        });
                    }
                },
                'colvis'
            ]
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.alert-success, .alert-danger, .statusss').delay(4000).fadeOut(400);
    });

    $(document).on('click', '.modificationColumn', function() {
        let id = $(this).data('id');
        let templatename = $(this).data('template');
        $('#modalColumnId input[name="templateid"]').val(id);
        $('#modalColumnId input[name="templatename"]').val(templatename);
    });
</script>


<script>
    $(document).ready(function() {
        // Form submit ke time validation
        $('#modalColumnForm').on('submit', function(e) {
            e.preventDefault(); // normal submit stop

            let form = $(this);
            let url = form.attr('action');
            let formData = form.serialize();

            $.ajax({
                type: "POST",
                url: "{{ route('validate.kra.template') }}", // validation route
                data: formData,
                success: function(response) {
                    $('#template-error').remove(); // purana error hatao

                    if (response.exists) {
                        // Error show karega input ke niche
                        $('input[name="templatename"]').after(
                            '<span id="template-error" class="text-danger">Template name already exists.</span>'
                        );
                    } else {
                        // Agar unique hai to confirm aur actual form submit
                        if (confirm(
                                'Are you sure you want to update this template name?')) {
                            form.off('submit').submit(); // normal submit allow karega
                        }
                    }
                },
                error: function(xhr) {
                    alert("Validation request failed!");
                }
            });
        });
    });
</script>

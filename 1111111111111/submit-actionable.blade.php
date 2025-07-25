<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Submit Actionable</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('admin.task.submit', ['uuid' => $actionable->uuid]) }}" novalidate class=""
            enctype="multipart/form-data" method="POST">
            <div class="modal-body" style="max-height: 400px;" data-simplebar>
                <div class="row">
                    <div class="col-12">

                        <div class="card-body">
                            <div class="card-">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <label for="design_gap" class="form-label flex-grow-1 required me-2">Design
                                                Gap</label>
                                            <select name="design_gap" class="form-select remarkDropdown w-50"
                                                id="">
                                                <option value="yes">Yes</option>
                                                <option value="no">no</option>
                                            </select>
                                        </div>
                                        <div class="card-body">
                                            <textarea name="design_gap_comment" id="" cols="30" rows="3" required
                                                placeholder="Design gap remark" class="form-control" style="max-height:300px"></textarea>

                                        </div>

                                    </div>
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <label for="operational_gap"
                                                class="form-label flex-grow-1 required me-2">Operating Effective Gap
                                                Gap</label>
                                            <select name="operational_gap" class="form-select w-50 remarkDropdown"
                                                id="">
                                                <option value="yes">Yes</option>
                                                <option value="no">no</option>
                                            </select>
                                        </div>
                                        <div class="card-body">
                                            <textarea name="operational_gap_comment" id="" cols="30" rows="3" required
                                                placeholder="Operating effective gap remark" class="form-control" style="max-height:300px"></textarea>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header align-items-center d-flex border-bottom-dashed">
                                    <h4 class="card-title mb-0 flex-grow-1">Upload proof list</h4>
                                </div>

                                <div class="card-body" data-simplebar style="max-height: 300px;min-height:150px">

                                    {{-- @foreach (json_decode($actionable->proof_list, false) as $index => $file)
                                                <label for="{{ $file }}">{{ $file }}</label>
                                                <input class="form-control form-control-sm" name="{{ $file }}"
                                                    data-max-size="104800" type="file"
                                                    accept=".doc, .docx, .xls, .xlsx, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"
                                                    data-file-types="doc,docx,xls,xlsx,pdf"
                                                    @if ($index === 0) id="fileInput" @endif>
                                            @endforeach --}}

                                    {{--                                            
                                            <input type="text" class="form-control form-control-sm"
                                                name="closure_date" placeholder="enter data"> --}}
                                    <div class="row">
                                        <div class="col-md-8">

                                            <label for="">Sample</label>
                                            <input class="form-control form-control-sm" name="file"
                                                data-max-size="104800" type="file"
                                                accept=".doc, .docx, .xls, .xlsx, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/pdf"
                                                data-file-types="doc,docx,xls,xlsx,pdf" id="fileInput">

                                            <input type="text" class="form-control form-control-sm"
                                                name="disbursement_column" placeholder="enter data">
                                            <input type="text" class="form-control form-control-sm"
                                                name="closure_date" placeholder="enter data">

                                        </div>

                                        <div class="col-md-2 d-none" id="aibtn" style=" margin-top: 20px;">
                                            <button type="button" class="btn btn-outline-primary w-100">AI</button>
                                        </div>

                                        <div class="col-md-2 d-none" id="generatebtn" style=" margin-top: 20px;">
                                            <button type="button" class="btn btn-outline-secondary w-100">Re
                                                Generate</button>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-2">
                                            <a id="file-name-display" href="" download class="d-none"></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- <script>
    $(document).ready(function() {
        let choosefile = '';

        // file choose
        $('#fileInput').on('change', function(e) {
            if (e.target.files.length > 0) {
                choosefile = e.target.files[0].name;
                $('#aibtn').removeClass('d-none');
            } else {
                choosefile = '';
                $('#aibtn, #generatebtn').addClass('d-none');
                $('#file-name-display').text('');
            }
        });

        // Ai button click
        $('.btn-outline-primary').on('click', function() {
            if (choosefile) {
                const filePath = '/uploads/' + choosefile;

                $('#file-name-display')
                    .removeClass('d-none')
                    .attr('href', filePath)
                    .attr('download', choosefile)
                    .text('File Genrated: ' + choosefile);

                $('#generatebtn').removeClass('d-none');
            } else {
                alert('Please select a file.');
            }
        });

        // re genrate button click
        $('.btn-outline-secondary').on('click', function() {
            $('#fileInput').val('');
            $('#file-name-display').addClass('d-none').text('');
            choosefile = '';
            $('#aibtn, #generatebtn').addClass('d-none');
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        let choosefile = '';
        let selectedFile = null;

        // file choose
        $('#fileInput').on('change', function(e) {
            if (e.target.files.length > 0) {
                selectedFile = e.target.files[0];
                choosefile = selectedFile.name;
                $('#aibtn').removeClass('d-none');
            } else {
                selectedFile = null;
                choosefile = '';
                $('#aibtn, #generatebtn').addClass('d-none');
                $('#file-name-display').text('');
            }
        });

        // Ai button click
        // $('.btn-outline-primary').on('click', function() {
        //     if (selectedFile) {
        //         const formData = new FormData();
        //         formData.append('file', selectedFile);

        //         $.ajax({
        //             url: 'https://fastapi-production-338f1.up.railway.app/same_day_closure_disbursement',
        //             type: 'POST',
        //             data: formData,
        //             processData: false,
        //             contentType: false,
        //             success: function(response) {
        //                 console.log(response);

        //                 $('#file-name-display')
        //                     .removeClass('d-none')
        //                     .attr('href', '/uploads/' +
        //                         choosefile)
        //                     .attr('download', choosefile)
        //                     .text('File Generated: ' + choosefile);

        //                 $('#generatebtn').removeClass('d-none');
        //             },
        //             error: function(xhr, status, error) {
        //                 console.error('API Error:', error);
        //                 alert('wrong with the API call.');
        //             }
        //         });
        //     } else {
        //         alert('Please select a file.');
        //     }
        // });

        $('.btn-outline-primary').on('click', function() {
            const selectedFile = $('#fileInput')[0].files[0];
            const disbursementColumn = $('input[name="disbursement_column"]').val();
            const closureDate = $('input[name="closure_date"]').val();

            console.log('selectedFile', selectedFile);
            console.log('disbursementColumn', disbursementColumn);
            console.log('closureDate', closureDate);

            if (selectedFile && disbursementColumn && closureDate) {
                const formData = new FormData();
                formData.append('file', selectedFile);
                formData.append('disbursement_column', disbursementColumn);
                formData.append('closure_date', closureDate);

                $.ajax({
                    url: 'https://fastapi-production-338f1.up.railway.app/same_day_closure_disbursement/',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log('Success Response:', response);
                    },
                    error: function(xhr, status, error) {
                        console.error('API Error:', error);
                        alert('Something went wrong with the API call.');
                    }
                });
            } else {
                alert('Please select a file and fill both fields.');
            }
        });



        // re genrate button click
        $('.btn-outline-secondary').on('click', function() {
            $('#fileInput').val('');
            $('#file-name-display').addClass('d-none').text('');
            selectedFile = null;
            choosefile = '';
            $('#aibtn, #generatebtn').addClass('d-none');
        });
    });
</script>

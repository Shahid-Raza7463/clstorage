{{-- resources\views\backEnd\layouts\includes\js.blade.php --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'frtip',
            // searching: true, // optional, default true hota hai
            columnDefs: [{
                targets: [0, 1, 2, 4, 5],
                orderable: false
            }],
            buttons: []
        });
    });
</script>
{{--  Start Hare  --}}
<script>
    $('#' + tableId).DataTable({
        "pageLength": 50,
        "lengthMenu": [
            [10, 25, 50, 100, 500],
            [10, 25, 50, 100, 500]
        ],
        dom: 'lfrtip',
        "order": [
            [1, "asc"]
        ],
        columnDefs: [{
            targets: [0],
            orderable: false
        }]
    });


    $('#' + tableId).DataTable({
        "pageLength": 50,
        "lengthMenu": [
            [10, 25, 50, 100, 500, -1],
            [10, 25, 50, 100, 500, "All"]
        ],
        dom: 'lfrtip',
        "order": [
            [1, "asc"]
        ],
        columnDefs: [{
            targets: [0],
            orderable: false
        }]
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding tr create dynamic --}}
<script>
    $(document).ready(function() {
        $('.editCompanyyyy').click(function(e) {
            // Prevent default anchor behavior
            e.preventDefault();
            // Get the data-id attribute value
            var id = $(this).data('id');
            //   alert(id);
            $.ajax({
                type: 'GET',

                url: "{{ url('balanceconfirmationreminderlist') }}",
                data: {
                    id: id,
                },
                success: function(response) {

                    var balanceconfirmationreminderlist = response
                        .balanceconfirmationreminderlist;

                    $('#reminderTable tbody').empty();
                    $.each(balanceconfirmationreminderlist, function(index, reminder) {
                        // Append a new row to the table
                        $('#reminderTable tbody').append('<tr>' +
                            '<td>' + reminder.remindercount + '</td>' +
                            '<td>' + reminder.reminderdatecount + '</td>' +
                            '</tr>');
                    });
                },
                error: function(error) {
                    console.error('Error fetching data:', error);
                }
            });
        });
    });
</script>
{{--  Start Hare  --}}
// $('#kratemplatesdata').on('change', function() {
// var kratemplatesdataId = $(this).val();
// var templates = JSON.parse($('#krasupload input[name="templatejson"]').val());

// alert(kratemplatesdataId);
// if (kratemplatesdataId == '106') {
// $('#input-excel').prop('disabled', true).removeAttr('required');
// $('#table-header').empty();
// } else {
// $('#input-excel').prop('disabled', false).attr('required', true);
// }
// });
// if (kraexist) {
// // $('#mapped-section').show();
// $('#template-section').hide();
// $('#kratemplate').removeAttr('required');
// } else {
// // $('#template-section').show();
// $('#mapped-section').hide();
// $('#mappedId').removeAttr('required');
// }
{{--  Start Hare  --}}
<!-- JavaScript for Modal Data -->
{{-- <script>
          document.querySelectorAll('[data-target=".exampleModalDelete-modal-lg"]').forEach(button => {
              button.addEventListener('click', function() {
                  const designationId = this.getAttribute('data-designation-id');
                  document.getElementById('delete-designation-id').value = designationId;
              });
          });
      </script> --}}

{{-- <script>
          document.getElementById("refreshButtonexcels").addEventListener("click", function() {
              location.reload();
          });

          document.getElementById("refreshButtonexcel").addEventListener("click", function() {
              location.reload();
          });
      </script> --}}
{{-- ! End hare --}}
{{-- * regarding  --}}

<script>
    $(document).ready(function() {
        $("table[id^='example']").each(function() {
            let tableId = $(this).attr('id');
            let tableNumber = tableId.replace('example', '');
            let filename = 'KRAs Report' + tableNumber;
            //   console.log(filename);

            $('#' + tableId).DataTable({
                "pageLength": 50,
                //   dom: 'Bfrtip',
                dom: 'rtip',
                //   columnDefs: [{
                //       targets: [1, 2, 3, 4, 5],
                //       orderable: false
                //   }],

                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        filename: filename,
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            //   remove extra spaces
                            $('c', sheet).each(function() {
                                var originalText = $(this).find('is t').text();
                                var cleanedText = originalText.replace(/\s+/g,
                                    ' ').trim();
                                $(this).find('is t').text(cleanedText);
                            });
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [2, 3]
                        }
                    },
                    {
                        extend: 'colvis',
                        text: 'Column Visibility',
                        columns: ':not(:nth-child(2)):not(:nth-child(6))'
                    }
                ]
            });
        });

    });
</script>

<script>
    $(document).ready(function() {
        $('#deletemodel').on('hidden.bs.modal', function() {
            $('#deleteForm')[0].reset();
        });
        $('#modalColumnId3').on('hidden.bs.modal', function() {
            $('#modalColumnForm3')[0].reset();
        });
        $('#krasupload').on('hidden.bs.modal', function() {
            $('#detailsForm')[0].reset();
            $('#table-header').empty();
            $('#table-body').empty();
            $('#pagination').empty();
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.alert-success, .alert-danger').delay(5000).fadeOut(400);
    });
</script>

<script>
    $(document).on('click', '.modificationColumn1', function() {
        let columnName = $(this).data('column');
        let id = $(this).data('id');
        $('#modalColumnId1 input[name="newcolumnName"]').val(columnName);
        $('#oldcolumnName').val(columnName);
        $('#kraId1').val(id);
    });
</script>

<script>
    $(document).on('click', '.modificationColumn2', function() {
        let columnName = $(this).data('column');
        let id = $(this).data('id');
        $('#modalColumnId2 input[name="columnnameDelete"]').val(columnName);
        $('#kraId2').val(id);
    });
</script>

<script>
    $(document).on('click', '.modificationColumn3', function() {
        let id = $(this).data('id');
        $('#kraId3').val(id);
    });
</script>
{{--  Start Hare  --}}
<script>
    $(document).on('click', '.deleteColumn', function() {
        const column = $(this).data('column');
        const id = $(this).data('id');

        if (confirm('Are you sure you want to delete this column?')) {
            $.ajax({
                url: '{{ route('delete.column') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    column: column,
                    id: id
                },
                success: function(response) {
                    alert(response.message);
                    location.reload(); // reload table to reflect changes
                },
                error: function() {
                    alert('Something went wrong!');
                }
            });
        }
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
<script>
    function validateFileType(input) {
        const allowedExtensions = [".csv", ".xlsx", ".xls"];
        const fileName = input.value.toLowerCase();
        const extension = fileName.substring(fileName.lastIndexOf("."));

        if (!allowedExtensions.includes(extension)) {
            alert("Please select an Excel (.csv, .xlsx, or .xls) file.");
            input.value = ""; // Clear the file selection
            return false; // Prevent form submission if file type is invalid
        }
        //   const tableHeader = document.getElementById('excelpreview');
        //   tableHeader.classList.remove('d-none');
        return true; // Allow form submission if file type is valid
    }
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding dynamic field   --}}
{{--  Start Hare  --}}

{{-- <script>
    $(document).ready(function() {
        let date1Str = document.getElementById("datepickers1").value;
        let date2Str = document.getElementById("datepickers2").value;

        let date1Parts = date1Str.split("-");
        let date2Parts = date2Str.split("-");

        let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
        let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

        let timeDifference = formattedDate2 - formattedDate1;
        // let differenceDays = timeDifference / (1000 * 60 * 60 * 24);
        let differenceDays = 0;

        console.log("originalDate captured:", formattedDate1);
        console.log("endDate captured:", formattedDate2);
        console.log("differenceDays:", differenceDays);

        let fieldContainer = $("#fieldContainer");
        fieldContainer.empty();

        for (let i = 0; i <= differenceDays; i++) {
            let currentDate = new Date(formattedDate1);
            currentDate.setDate(currentDate.getDate() + i);

            let formattedDate =
                ('0' + currentDate.getDate()).slice(-2) + '-' +
                ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                currentDate.getFullYear();


            // ${i+1}
            // value="${formattedDate}" readonly>

            let fieldHtml = `
                <div class="field_wrapper${i+1}">
                    <div class="row row-sm mb-2">
                        <div class="col-2">
                            <input required type="text" name="date${i+1}" class="form-control"
                                value="${formattedDate}" readonly>
                        </div>
                    </div>
                    <div class="row row-sm showdiv${i+1}" id="additionalFields${i+1}">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Client Name</label>
                                <select required class="language form-control refresh" name="client_id[]" id="client${i+1}">
                                    <option value="">Select Client</option>
                                    @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}">
                                            {{ $clientData->client_name }} ({{ $clientData->client_code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Assignment Name</label>
                                <select class="form-control key refreshoption assignmentvalue${i+1}" name="assignment_id[]" id="assignment${i+1}">
                                    @if (!empty($timesheet->assignment_id))
                                        <option value="{{ $timesheet->assignment_id }}">
                                            {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Partner</label>
                                <select class="language form-control refreshoption partnervalue${i+1}" id="partner${i+1}" name="partner[]"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600" style="width:100px;">Work Item</label>
                                <textarea type="text" name="workitem[]" class="form-control key workItem${i+1} refresh workitemnvalue${i+1}"></textarea>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600" style="width:100px;">Location</label>
                                <input type="text" name="location[]" class="form-control key location${i+1} refresh locationvalue${i+1}">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label class="font-weight-600">Hour</label>
                                <input type="text" class="form-control hour${i+1} refresh" name="hour[]" oninput="calculateTotal(this)" value="0" step="1">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group" style="margin-top: 36px;">
                                <a href="javascript:void(0);" id="add_button${i+1}" title="Add field">
                                    <img src="{{ url('backEnd/image/add-icon.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            fieldContainer.append(fieldHtml);
        }
    });
</script> --}}

{{-- default created field will be show --}}
{{-- <script>
    $(document).ready(function() {
        let date1Str = $("#datepickers1").val();
        let date2Str = $("#datepickers2").val();


        let date1Parts = date1Str.split("-");
        let date2Parts = date2Str.split("-");

        let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
        let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

        let timeDifference = formattedDate2 - formattedDate1;
        let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

        let fieldContainer = $("#fieldContainer");
        fieldContainer.empty();

        for (let i = 0; i <= differenceDays; i++) {
            let currentDate = new Date(formattedDate1);
            currentDate.setDate(currentDate.getDate() + i);

            let formattedDate =
                ('0' + currentDate.getDate()).slice(-2) + '-' +
                ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                currentDate.getFullYear();

            let fieldHtml = `
            <div class="field_wrapper" data-index="${i+1}">
                <div class="row row-sm mb-2">
                    <div class="col-2">
                        <input required type="text" id="day${i+1}" name="day${i+1}" class="form-control"
                            value="${formattedDate}" readonly>
                    </div>
                    <div class="col-2">
                         <input type="text" class="time form-control" id="totalhours${i+1}" name="totalhour${i+1}"
                            value="{{ $timesheet->hour ?? '0' }}" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="row row-sm showdiv${i+1}" id="additionalFields${i+1}">
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Client Name</label>
                            <select required class="language form-control refresh" name="client_id${i+1}[]" id="client${i+1}">
                                <option value="">Select Client</option>
                                @foreach ($client as $clientData)
                                    <option value="{{ $clientData->id }}">
                                        {{ $clientData->client_name }} ({{ $clientData->client_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Assignment Name</label>
                            <select class="form-control key refreshoption assignmentvalue${i+1}" name="assignment_id${i+1}[]" id="assignment${i+1}"></select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Partner</label>
                            <select class="language form-control refreshoption partnervalue${i+1}" id="partner${i+1}" name="partner${i+1}[]"></select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600" style="width:100px;">Work Item</label>
                            <textarea type="text" name="workitem${i+1}[]" class="form-control key workItem${i+1} refresh workitemnvalue${i+1}"></textarea>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600" style="width:100px;">Location</label>
                            <input type="text" name="location${i+1}[]" class="form-control key location${i+1} refresh locationvalue${i+1}">
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label class="font-weight-600">Hour</label>
                            <input type="text" class="form-control hour${i+1} refresh" id="hour${i+1}" name="hour${i+1}[]" oninput="calculateTotal(this)" value="0" step="1">
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group" style="margin-top: 36px;">
                            <a href="javascript:void(0);" class="add_button" id="plusbuttion${i+1}" data-index="${i+1}" title="Add field">
                                <img src="{{ url('backEnd/image/add-icon.png') }}" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
            fieldContainer.append(fieldHtml);
        }
    });
</script> --}}

{{-- leave features implement hare --}}

<script>
    $(document).ready(function() {
        let date1Str = $("#datepickers1").val();
        let date2Str = $("#datepickers2").val();


        let date1Parts = date1Str.split("-");
        let date2Parts = date2Str.split("-");

        let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
        let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

        let timeDifference = formattedDate2 - formattedDate1;
        let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

        $.ajax({
            url: "{{ url('filterleavedata') }}",
            type: "GET",
            data: {
                start_date: date1Str,
                end_date: date2Str
            },
            success: function(existingDates) {
                let fieldContainer = $("#fieldContainer");
                fieldContainer.empty();

                for (let i = 0; i <= differenceDays; i++) {
                    let currentDate = new Date(formattedDate1);
                    currentDate.setDate(currentDate.getDate() + i);

                    let formattedDate =
                        ('0' + currentDate.getDate()).slice(-2) + '-' +
                        ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                        currentDate.getFullYear();

                    if (existingDates.includes(formattedDate)) {
                        continue;
                    }


                    let fieldHtml = `
            <div class="field_wrapper p-3 mb-4" data-index="${i+1}" id="mainfields${i+1}" style="border: 1px solid #ddd; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px;">
                <div class="row row-sm mb-2">
                    <div class="col-2">
                        <input type="text" id="day${i+1}" name="day${i+1}" class="form-control"
                            value="${formattedDate}" readonly>
                    </div>
                    <div class="col-2">
                         <input type="text" class="time form-control" id="totalhours${i+1}" name="totalhour${i+1}"
                            value="{{ $timesheet->hour ?? '0' }}" autocomplete="off" readonly>
                    </div>
                </div>
                <div class="row row-sm showdiv${i+1}" id="additionalFields${i+1}">
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Client Name <span class="text-danger">*</span></label>
                            <select class="language form-control refresh" name="client_id${i+1}[]" id="client${i+1}">
                                <option value="">Select Client</option>
                                @foreach ($client as $clientData)
                                    <option value="{{ $clientData->id }}">
                                        {{ $clientData->client_name }} ({{ $clientData->client_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Assignment Name <span class="text-danger">*</span></label>
                            <select class="form-control key refreshoption assignmentvalue${i+1}" name="assignment_id${i+1}[]" id="assignment${i+1}"></select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600">Partner <span class="text-danger">*</span></label>
                            <select class="language form-control refreshoption partnervalue${i+1}" id="partner${i+1}" name="partner${i+1}[]"></select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600" style="width:100px;">Work Item <span class="text-danger">*</span></label>
                            <textarea type="text" name="workitem${i+1}[]" class="form-control key workItem${i+1} refresh workitemnvalue${i+1}" style="height: 40px;"></textarea>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="font-weight-600" style="width:100px;">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location${i+1}[]" class="form-control key location${i+1} refresh locationvalue${i+1}">
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group">
                            <label class="font-weight-600">Hour <span class="text-danger">*</span></label>
                            <input type="number" class="form-control hour${i+1} refresh" id="hour${i+1}" name="hour${i+1}[]" oninput="calculateTotal(this)" value="0" step="1">
                        </div>
                    </div>
                    <div class="col-1">
                        <div class="form-group" style="margin-top: 36px;">
                            <a href="javascript:void(0);" class="add_button" id="plusbuttion${i+1}" data-index="${i+1}" title="Add field">
                                <img src="{{ url('backEnd/image/add-icon.png') }}" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
        `;
                    fieldContainer.append(fieldHtml);
                }
            }
        });
    });
</script>

{{-- after date change,  field will be show --}}
{{-- <script>
    $(document).ready(function() {
        $('#datepickers2').on('change', function() {
            let date1Str = $("#datepickers1").val();
            var date2Str = $(this).val();


            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            let fieldCount = $('.field_wrapper').length;

            let removablesection = fieldCount - differenceDays;

            console.log("date1Str", date1Str);
            console.log("date2Str", date2Str);
            console.log("date1Parts", date1Parts);
            console.log("date2Parts", date2Parts);
            console.log("formattedDate1", formattedDate1);
            console.log("formattedDate2", formattedDate2);
            console.log("timeDifference", timeDifference);
            console.log("differenceDays", differenceDays);
            // console.log("index", index);
            // console.log("wrapper", wrapper);
            console.log("fieldCount", fieldCount);
            console.log("removablesection", removablesection);

 


        });

    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        $('#datepickers2').on('change', function() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $(this).val();

            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            let fieldCount = $('.field_wrapper').length;
            let removablesection = fieldCount - differenceDays;

            console.log("removablesection", removablesection);

            if (removablesection > 0) {
                // Aakhri ke n elements hatao
                $('.field_wrapper').slice(-removablesection).remove();
            }
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        $('#datepickers2').on('change', function() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $(this).val();

            // Calculate days difference
            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            // Get all field wrappers
            let fieldWrappers = $('.field_wrapper');
            let fieldCount = fieldWrappers.length;

            // Calculate how many to remove from the end
            let removeCount = fieldCount - (differenceDays + 1); // +1 because differenceDays is 0-based

            // Remove the excess fields from the end
            if (removeCount > 0) {
                fieldWrappers.slice(-removeCount).remove();
            }

            // Debug logs
            console.log("Days difference:", differenceDays);
            console.log("Current fields:", fieldCount);
            console.log("Removing last", removeCount, "fields");
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        // Store removed fields
        let removedFields = [];

        $('#datepickers2').on('change', function() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $(this).val();

            // Calculate days difference
            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            // Get all field wrappers
            let fieldWrappers = $('.field_wrapper');
            let fieldCount = fieldWrappers.length;

            // Calculate how many fields should exist
            let requiredFields = differenceDays + 1;

            if (fieldCount > requiredFields) {
                // Need to remove fields
                let removeCount = fieldCount - requiredFields;
                removedFields = fieldWrappers.slice(-removeCount).detach(); // Store removed fields
            } else if (fieldCount < requiredFields) {
                // Need to add fields back
                let addCount = requiredFields - fieldCount;
                if (removedFields.length >= addCount) {
                    // Restore from stored fields
                    $('#fieldContainer').append(removedFields.slice(0, addCount));
                    removedFields = removedFields.slice(addCount);
                }
            }
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        // Store removed fields
        let removedFields = [];

        $('#datepickers2').on('change', function() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $(this).val();

            // Calculate days difference
            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            // Get all field wrappers
            let fieldWrappers = $('.field_wrapper');
            let fieldCount = fieldWrappers.length;

            // Calculate how many fields should exist
            let requiredFields = differenceDays + 1;

            if (fieldCount > requiredFields) {
                // Need to remove fields
                let removeCount = fieldCount - requiredFields;
                // alert(removeCount);
                removedFields = fieldWrappers.slice(-removeCount).detach(); // Store removed fields
            } else if (fieldCount < requiredFields) {
                // Need to add fields back
                let addCount = requiredFields - fieldCount;
                if (removedFields.length >= addCount) {
                    // Restore from stored fields
                    $('#fieldContainer').append(removedFields.slice(0, addCount));
                    // removedFields = removedFields.slice(addCount);
                }
            }

            console.log("date1Str", date1Str);
            console.log("date2Str", date2Str);
            console.log("date1Parts", date1Parts);
            console.log("date2Parts", date2Parts);
            console.log("formattedDate1", formattedDate1);
            console.log("formattedDate2", formattedDate2);
            console.log("timeDifference", timeDifference);
            console.log("differenceDays", differenceDays);
            console.log("fieldWrappers", fieldWrappers);
            console.log("fieldCount", fieldCount);
            console.log("requiredFields", requiredFields);
            console.log("removeCount", removeCount);
            console.log("removedFields", removedFields);
            // console.log("addCount", addCount);
            // console.log("removedFields.length", removedFields.length);
            // console.log("removedFields", removedFields);
        });
    });
</script> --}}

{{-- final done hare  --}}
{{-- <script>
    $(document).ready(function() {
        // Store removed fields
        let removedFields = [];

        $('#datepickers2').on('change', function() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $(this).val();

            // Calculate days difference
            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            // Get all field wrappers
            let fieldWrappers = $('.field_wrapper');
            let fieldCount = fieldWrappers.length;

            // Calculate how many fields should exist
            let requiredFields = differenceDays + 1;

            if (fieldCount > requiredFields) {
                // Need to remove fields - add to removedFields array instead of replacing
                let removeCount = fieldCount - requiredFields;
                removedFields = removedFields.concat(fieldWrappers.slice(-removeCount).detach().get());
            } else if (fieldCount < requiredFields) {
                // Need to add fields back
                let addCount = requiredFields - fieldCount;

                // Filter only fields that fit in the current date range
                let fieldsToAdd = removedFields.filter(field => {
                    let fieldDate = new Date($(field).find('input[name^="day"]').val().split(
                        '-').reverse().join('-'));
                    return fieldDate <= formattedDate2;
                }).slice(0, addCount);

                $('#fieldContainer').append(fieldsToAdd);

                // Update removedFields array
                removedFields = removedFields.filter(field => !fieldsToAdd.includes(field));
            }

            console.log("Stored fields:", removedFields.length);
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        let storedFields = {}; // Object to store fields by date

        $('#datepickers2').on('change', function() {
            const startDate = new Date($("#datepickers1").val().split('-').reverse().join('-'));
            const endDate = new Date($(this).val().split('-').reverse().join('-'));

            // Calculate all dates in the range
            const allDates = [];
            for (let d = new Date(startDate); d <= endDate; d.setDate(d.getDate() + 1)) {
                allDates.push(new Date(d));
            }

            // Process existing fields
            $('.field_wrapper').each(function() {
                const fieldDate = new Date($(this).find('input[name^="day"]').val().split('-')
                    .reverse().join('-'));

                if (fieldDate > endDate) {
                    // Store field if it's beyond the new end date
                    const dateKey = $(this).find('input[name^="day"]').val();
                    storedFields[dateKey] = $(this).detach();
                }
            });

            // Add back fields that are now within range
            allDates.forEach(date => {
                const dateStr = formatDate(date);
                if (storedFields[dateStr]) {
                    $('#fieldContainer').append(storedFields[dateStr]);
                    delete storedFields[dateStr];
                }
            });
        });

        // Helper function to format date as dd-mm-yyyy
        function formatDate(date) {
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            return `${day}-${month}-${date.getFullYear()}`;
        }
    });
</script>

{{-- <script>
    $(document).ready(function() {
        $('#datepickers2').on('change', function() {
            let date1Str = $('#datepickers1').val();
            let date2Str = $(this).val();

            if (!date1Str || !date2Str) {
                return; // Do nothing if either date is empty
            }

            // Convert "dd-mm-yyyy" to Date objects
            let [d1, m1, y1] = date1Str.split("-");
            let [d2, m2, y2] = date2Str.split("-");

            let start = new Date(`${y1}-${m1}-${d1}`);
            let end = new Date(`${y2}-${m2}-${d2}`);

            if (start > end) {
                alert("End date must be after start date.");
                return;
            }

            let container = $('#fieldContainer');
            container.empty(); // Remove all current fields

            while (start <= end) {
                let day = String(start.getDate()).padStart(2, '0');
                let month = String(start.getMonth() + 1).padStart(2, '0');
                let year = start.getFullYear();
                let dateStr = `${day}-${month}-${year}`;

                let fieldHTML = `<div class="field_wrapper">
                    <input type="text" name="day[]" value="${dateStr}" />
                </div>`;

                container.append(fieldHTML);

                // Move to next day
                start.setDate(start.getDate() + 1);
            }
        });
    });
</script> --}}

{{-- <script>
    $(document).ready(function() {
        $('#datepickers2').on('change', function() {
            let date1Str = $('#datepickers1').val();
            let date2Str = $(this).val();

            if (!date1Str || !date2Str) return;

            let [d1, m1, y1] = date1Str.split("-");
            let [d2, m2, y2] = date2Str.split("-");

            let start = new Date(`${y1}-${m1}-${d1}`);
            let end = new Date(`${y2}-${m2}-${d2}`);

            if (start > end) {
                alert("End date must be after start date.");
                return;
            }

            let container = $('#fieldContainer');
            container.empty();

            let i = 0;

            while (start <= end) {
                i++;

                let day = String(start.getDate()).padStart(2, '0');
                let month = String(start.getMonth() + 1).padStart(2, '0');
                let year = start.getFullYear();
                let formattedDate = `${day}-${month}-${year}`;

                let fieldHTML = `
                <div class="field_wrapper p-3 mb-4" data-index="${i}" style="border: 1px solid #ddd; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px;">
                    <div class="row row-sm mb-2">
                        <div class="col-2">
                            <input type="text" id="day${i}" name="day${i}" class="form-control" value="${formattedDate}" readonly>
                        </div>
                        <div class="col-2">
                            <input type="text" class="time form-control" id="totalhours${i}" name="totalhour${i}" value="0" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="row row-sm showdiv${i}" id="additionalFields${i}">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Client Name <span class="text-danger">*</span></label>
                                <select class="language form-control refresh" name="client_id${i}[]" id="client${i}">
                                    <option value="">Select Client</option>
                                    <!-- You can render options via AJAX or Blade injection -->
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Assignment Name <span class="text-danger">*</span></label>
                                <select class="form-control key refreshoption assignmentvalue${i}" name="assignment_id${i}[]" id="assignment${i}"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Partner <span class="text-danger">*</span></label>
                                <select class="language form-control refreshoption partnervalue${i}" id="partner${i}" name="partner${i}[]"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Work Item <span class="text-danger">*</span></label>
                                <textarea name="workitem${i}[]" class="form-control key workItem${i} refresh workitemnvalue${i}" style="height: 40px;"></textarea>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location${i}[]" class="form-control key location${i} refresh locationvalue${i}">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label class="font-weight-600">Hour <span class="text-danger">*</span></label>
                                <input type="number" class="form-control hour${i} refresh" id="hour${i}" name="hour${i}[]" oninput="calculateTotal(this)" value="0" step="1">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group" style="margin-top: 36px;">
                                <a href="javascript:void(0);" class="add_button" id="plusbuttion${i}" data-index="${i}" title="Add field">
                                    <img src="/backEnd/image/add-icon.png" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;

                container.append(fieldHTML);

                start.setDate(start.getDate() + 1);
            }
        });
    });
</script> --}}




{{-- <script>
    $(document).ready(function() {
        function generateFields(date1Str, date2Str, existingDates = []) {
            let date1Parts = date1Str.split("-");
            let date2Parts = date2Str.split("-");

            let formattedDate1 = new Date(`${date1Parts[2]}-${date1Parts[1]}-${date1Parts[0]}`);
            let formattedDate2 = new Date(`${date2Parts[2]}-${date2Parts[1]}-${date2Parts[0]}`);

            let timeDifference = formattedDate2 - formattedDate1;
            let differenceDays = timeDifference / (1000 * 60 * 60 * 24);

            let fieldContainer = $("#fieldContainer");
            fieldContainer.empty();

            for (let i = 0; i <= differenceDays; i++) {
                let currentDate = new Date(formattedDate1);
                currentDate.setDate(currentDate.getDate() + i);

                let formattedDate = ('0' + currentDate.getDate()).slice(-2) + '-' +
                    ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                    currentDate.getFullYear();

                if (existingDates.includes(formattedDate)) {
                    continue;
                }

                let fieldHtml = `
                <div class="field_wrapper p-3 mb-4" data-index="${i+1}" style="border: 1px solid #ddd; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-radius: 8px;">
                    <div class="row row-sm mb-2">
                        <div class="col-2">
                            <input type="text" id="day${i+1}" name="day${i+1}" class="form-control" value="${formattedDate}" readonly>
                        </div>
                        <div class="col-2">
                            <input type="text" class="time form-control" id="totalhours${i+1}" name="totalhour${i+1}" value="{{ $timesheet->hour ?? '0' }}" autocomplete="off" readonly>
                        </div>
                    </div>
                    <div class="row row-sm showdiv${i+1}" id="additionalFields${i+1}">
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Client Name <span class="text-danger">*</span></label>
                                <select class="language form-control refresh" name="client_id${i+1}[]" id="client${i+1}">
                                    <option value="">Select Client</option>
                                    @foreach ($client as $clientData)
                                        <option value="{{ $clientData->id }}">{{ $clientData->client_name }} ({{ $clientData->client_code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Assignment Name <span class="text-danger">*</span></label>
                                <select class="form-control key refreshoption assignmentvalue${i+1}" name="assignment_id${i+1}[]" id="assignment${i+1}"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Partner <span class="text-danger">*</span></label>
                                <select class="language form-control refreshoption partnervalue${i+1}" id="partner${i+1}" name="partner${i+1}[]"></select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Work Item <span class="text-danger">*</span></label>
                                <textarea name="workitem${i+1}[]" class="form-control key workItem${i+1} refresh workitemnvalue${i+1}" style="height: 40px;"></textarea>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label class="font-weight-600">Location <span class="text-danger">*</span></label>
                                <input type="text" name="location${i+1}[]" class="form-control key location${i+1} refresh locationvalue${i+1}">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group">
                                <label class="font-weight-600">Hour <span class="text-danger">*</span></label>
                                <input type="number" class="form-control hour${i+1} refresh" id="hour${i+1}" name="hour${i+1}[]" oninput="calculateTotal(this)" value="0" step="1">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="form-group" style="margin-top: 36px;">
                                <a href="javascript:void(0);" class="add_button" id="plusbuttion${i+1}" data-index="${i+1}" title="Add field">
                                    <img src="{{ url('backEnd/image/add-icon.png') }}" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>`;
                fieldContainer.append(fieldHtml);
            }
        }

        function fetchAndRender() {
            let date1Str = $("#datepickers1").val();
            let date2Str = $("#datepickers2").val();

            if (!date1Str || !date2Str) return;

            $.ajax({
                url: "{{ url('filterleavedata') }}",
                type: "GET",
                data: {
                    start_date: date1Str,
                    end_date: date2Str
                },
                success: function(existingDates) {
                    generateFields(date1Str, date2Str, existingDates);
                },
                error: function() {
                    alert("Something went wrong while fetching leave data.");
                }
            });
        }

        // Trigger on page load (if both dates are already filled)
        fetchAndRender();

        // Trigger on end date change
        $('#datepickers2').on('change', fetchAndRender);
    });
</script> --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding date sorting / date sorting / regarding sorting   --}}
{{--  Start Hare  --}}
<td data-order="{{ $independenceItem ? $independenceItem->created_at : '' }}">
    @if ($independenceItem)
        {{ date('d-m-Y', strtotime($independenceItem->created_at)) }}
        {{ date('h:i A', strtotime($independenceItem->created_at)) }}
    @endif
</td>


<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            // 'l' for the length menu
            dom: 'lBfrtip',
            columnDefs: [{
                targets: [1, 2, 3, 4],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Independence Confirmation',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
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
{{--  Start Hare  --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

{{-- <script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            // 'l' for the length menu
            dom: 'lBfrtip',
            columnDefs: [{
                targets: [1, 2, 3, 4],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Independence Confirmation',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(xlsx) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        //   remove extra spaces
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
</script> --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'lBfrtip',
            columnDefs: [{
                    targets: [0, 1, 2, 3, 4], // Only make these columns non-orderable (0-indexed)
                    orderable: false
                },
                {
                    targets: 5, // Submitted Date column (0-indexed as 5)
                    type: 'date', // Tell DataTables this is a date column
                    render: function(data, type, row) {
                        // For proper sorting, return raw date value when sorting/filtering
                        if (type === 'sort' || type === 'type') {
                            return data ? moment(data, 'DD-MM-YYYY hh:mm A').format(
                                'YYYY-MM-DD HH:mm') : '';
                        }
                        return data; // Display original formatted value
                    }
                }
            ],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Independence Confirmation',
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
        $('#examplee').DataTable({
            dom: 'lBfrtip',
            columnDefs: [{
                    targets: [0, 1, 2, 3], // Only disable sorting for these columns
                    orderable: false
                },
                {
                    targets: 5, // Submitted Date column
                    type: 'date-eu', // Use European date format (DD-MM-YYYY)
                    render: function(data, type, row) {
                        if (type === 'sort') {
                            // Convert to sortable format (YYYYMMDD)
                            if (data) {
                                var parts = data.split(' ');
                                var dateParts = parts[0].split('-');
                                return dateParts[2] + dateParts[1] + dateParts[0] + (parts[1] ||
                                    '');
                            }
                            return '';
                        }
                        return data;
                    }
                }
            ],
            // ... rest of your buttons configuration
        });
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare  --}}

{{-- Akshay has worked --}}
<script>
    $('.sunday-field').toggleClass('d-none');
    document.getElementById('Myform').addEventListener('submit', function(event) {
        // Get the submit button
        const submitButton = document.getElementById('submitButton');

        // Disable the submit button to prevent multiple submissions
        submitButton.disabled = true;
        submitButton.textContent = "Submitting..."; // Optional: change the button text

        // Allow the form to submit
        // The form will automatically be submitted due to the 'action' attribute in the form tag
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding  --}}
{{--  Start Hare  --}}

{{-- <script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [2, "desc"]
            ],

            columnDefs: [{
                @if (Auth::user()->role_id == 11)
                    targets: [0, 1, 3, 4],
                @else
                    targets: [0, 1, 3],
                @endif
                orderable: false
            }],

            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Notification',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                // it should be column number 2
                                if (column === 1) {
                                    // If the data is a date, extract the date without HTML tags
                                    var cleanedText = $(data).text().trim();
                                    var dateParts = cleanedText.split(
                                        '-');
                                    // Assuming the date format is yyyy-mm-dd
                                    if (dateParts.length === 3) {
                                        return dateParts[2] + '-' + dateParts[1] + '-' +
                                            dateParts[0];
                                    }
                                }
                                if (column === 0) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 2) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data;
                            }
                        }
                    },
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Notification',
                    exportOptions: {
                        @if (Auth::user()->role_id == 11)
                            columns: [1, 2, 3, 4]
                        @else
                            columns: [1, 2, 3]
                        @endif
                    }
                },
                'colvis'
            ]
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        const isRole11 = {{ Auth::user()->role_id == 11 ? 'true' : 'false' }};

        const nonOrderableColumns = isRole11 ? [0, 1, 3, 4] : [0, 1, 3];
        const exportColumns = isRole11 ? [1, 2, 3, 4] : [1, 2, 3];

        $('#examplee').DataTable({
            dom: 'Bfrtip',
            order: [
                [2, 'desc']
            ],
            columnDefs: [{
                targets: nonOrderableColumns,
                orderable: false
            }],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Notification',
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column) {
                                const cleanedText = $(data).text().trim();

                                // Format date in column 1 (assuming yyyy-mm-dd)
                                if (column === 1) {
                                    const parts = cleanedText.split('-');
                                    return parts.length === 3 ?
                                        `${parts[2]}-${parts[1]}-${parts[0]}` :
                                        cleanedText;
                                }

                                return cleanedText;
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Notification',
                    exportOptions: {
                        columns: exportColumns
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding event   --}}
{{--  Start Hare  --}}
Input Field Events Summary:

Event Name Trigger Condition Use Case Example
input Har character type karte hi Live value update
change Value change ke baad field chhod diya Form submission conditions
blur Field se focus hatt gaya (mouse ya tab se) Validation ya calculation
focus Input field pe cursor aaya Highlight or note activity
keyup Koi key chhoda gaya Detect specific keys like Enter
keydown Koi key dabaya gaya Shortcut ya key combinations
focusout Same as blur, but bubbles (useful in delegation) Rarely used over blur
mouseleave Mouse element se bahar gaya (similar to mouseout) UI highlight effect
mouseout Mouse element se bahar gaya Tooltip close, styling changes
mouseenter Mouse element par aaya Tooltip show, hover info
mouseover Mouse element par hover kiya Similar to mouseenter but bubbles
click Mouse click hua Button action or input click handling
dblclick Double click Special interactions
paste Jab user paste karta hai input me Input sanitization
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding  --}}
{{--  Start Hare  --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
      //   $(document).ready(function() {
      $("#timesheet-form").submit(function(e) {
          // Check if the "Client Name" dropdown is selected
          if ($("#client1").val() != "Select Client" && $("#client1").val() != "") {
              // If a client is selected, make the following fields required
              $("#assignment1").prop("required", true);
              $("#partner1").prop("required", true);
              $("#assignment2").prop("required", true);
          }
      });
      //   });
  </script> --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding validation   --}}
{{--  Start Hare  --}}

<script>
    $(function() {
        $('#timesheet-form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission until validation passes
            alert('try to submit');
            let isValid = true;
            let errorMessage = '';

            // Loop through each field wrapper
            $('.field_wrapper').each(function() {
                let index = $(this).data('index');
                let dayField = $(`#day${index}`).val();
                let clientField = $(`#client${index}`).val();
                let assignmentField = $(`#assignment${index}`).val();
                let partnerField = $(`#partner${index}`).val();
                let workItemField = $(`.workitemnvalue${index}`).val();
                let locationField = $(`.locationvalue${index}`).val();
                let hourField = $(`#hour${index}`).val();

                // Check if any required field is empty
                if (!dayField) {
                    isValid = false;
                    errorMessage += `Day is missing for field set ${index}.\n`;
                }
                if (!clientField) {
                    isValid = false;
                    errorMessage += `Client Name is required for field set ${index}.\n`;
                }
                if (!assignmentField) {
                    isValid = false;
                    errorMessage += `Assignment Name is required for field set ${index}.\n`;
                }
                if (!partnerField) {
                    isValid = false;
                    errorMessage += `Partner is required for field set ${index}.\n`;
                }
                if (!workItemField) {
                    isValid = false;
                    errorMessage += `Work Item is required for field set ${index}.\n`;
                }
                if (!locationField) {
                    isValid = false;
                    errorMessage += `Location is required for field set ${index}.\n`;
                }
                if (!hourField || parseFloat(hourField) <= 0) {
                    isValid = false;
                    errorMessage += `Valid Hour is required for field set ${index}.\n`;
                }
            });

            // Check if datepickers have values
            let toDate = $('#datepickers1').val();
            let fromDate = $('#datepickers2').val();
            if (!toDate) {
                isValid = false;
                errorMessage += 'To Date is required.\n';
            }
            if (!fromDate) {
                isValid = false;
                errorMessage += 'From Date is required.\n';
            }

            // If validation fails, show alert with errors
            if (!isValid) {
                alert('Please fill in all required fields:\n\n' + errorMessage);
                return false;
            }

            // If validation passes, allow form submission
            alert('Form is valid, submitting...');
            this.submit(); // Proceed with form submission
        });
    });
</script>

<script>
    $(function() {
        $('#timesheet-form').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            $('.field_wrapper').each(function() {
                const index = $(this).data('index');

                const client = $(`#client${index}`).val();
                const assignment = $(`#assignment${index}`).val();
                const partner = $(`#partner${index}`).val();
                const workItem = $(`.workItem${index}`).val();
                const location = $(`.location${index}`).val();
                const hour = $(`#hour${index}`).val();

                if (!client) {
                    isValid = false;
                    errorMessage = 'Please select a client.';
                    $(`#client${index}`).focus();
                    return false;
                }
                if (!assignment) {
                    isValid = false;
                    errorMessage = 'Please select an assignment.';
                    $(`#assignment${index}`).focus();
                    return false;
                }
                if (!partner) {
                    isValid = false;
                    errorMessage = 'Please select a partner.';
                    $(`#partner${index}`).focus();
                    return false;
                }
                if (!workItem) {
                    isValid = false;
                    errorMessage = 'Please enter a work item.';
                    $(`.workItem${index}`).focus();
                    return false;
                }
                if (!location) {
                    isValid = false;
                    errorMessage = 'Please enter a location.';
                    $(`.location${index}`).focus();
                    return false;
                }
                if (!hour || isNaN(hour) || hour < 0) {
                    isValid = false;
                    errorMessage = 'Please enter a valid hour.';
                    $(`#hour${index}`).focus();
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>

<script>
    $(function() {
        $('#timesheet-form').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';


            $('.extra_field').each(function() {
                const index = $(this).data('index');

                const client = $(`#client${index}`).val();
                const assignment = $(`#assignment${index}`).val();
                const partner = $(`#partner${index}`).val();
                const workItem = $(`.workItem${index}`).val();
                const location = $(`.location${index}`).val();
                const hour = $(`#hour${index}`).val();

                if (!client) {
                    isValid = false;
                    errorMessage = 'Please select a client.';
                    $(`#client${index}`).focus();
                    return false;
                }
                if (!assignment) {
                    isValid = false;
                    errorMessage = 'Please select an assignment.';
                    $(`#assignment${index}`).focus();
                    return false;
                }
                if (!partner) {
                    isValid = false;
                    errorMessage = 'Please select a partner.';
                    $(`#partner${index}`).focus();
                    return false;
                }
                if (!workItem) {
                    isValid = false;
                    errorMessage = 'Please enter a work item.';
                    $(`.workItem${index}`).focus();
                    return false;
                }
                if (!location) {
                    isValid = false;
                    errorMessage = 'Please enter a location.';
                    $(`.location${index}`).focus();
                    return false;
                }
                if (!hour || isNaN(hour) || hour < 0) {
                    isValid = false;
                    errorMessage = 'Please enter a valid hour.';
                    $(`#hour${index}`).focus();
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>

<script>
    $(function() {
        $('#timesheet-form').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            $('.field_wrapper, .extra_field').each(function() {

                const index = $(this).data('index');
                const client = $(`#client${index}`).val();
                const assignment = $(`#assignment${index}`).val();
                const partner = $(`#partner${index}`).val();
                const workItem = $(`.workItem${index}`).val();
                const location = $(`.location${index}`).val();
                const hour = $(`#hour${index}`).val();

                if (!client) {
                    isValid = false;
                    errorMessage = 'Please select a client.';
                    $(`#client${index}`).focus();
                    return false;
                }
                if (!assignment) {
                    isValid = false;
                    errorMessage = 'Please select an assignment.';
                    $(`#assignment${index}`).focus();
                    return false;
                }
                if (!partner) {
                    isValid = false;
                    errorMessage = 'Please select a partner.';
                    $(`#partner${index}`).focus();
                    return false;
                }
                if (!workItem) {
                    isValid = false;
                    errorMessage = 'Please enter a work item.';
                    $(`.workItem${index}`).focus();
                    return false;
                }
                if (!location) {
                    isValid = false;
                    errorMessage = 'Please enter a location.';
                    $(`.location${index}`).focus();
                    return false;
                }
                if (!hour || isNaN(hour) || hour < 0) {
                    isValid = false;
                    errorMessage = 'Please enter a valid hour.';
                    $(`#hour${index}`).focus();
                    return false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>

<script>
    $(function() {
        $('#timesheet-form').on('submit', function(e) {
            let isValid = true;
            let errorMessage = '';

            // Function to validate each block (field_wrapper or extra_field)
            function validateFields(selector) {
                $(selector).each(function() {
                    const index = $(this).data('index');

                    const client = $(`#client${index}`).val();
                    const assignment = $(`#assignment${index}`).val();
                    const partner = $(`#partner${index}`).val();
                    const workItem = $(`.workItem${index}`).val();
                    const location = $(`.location${index}`).val();
                    const hour = $(`#hour${index}`).val();

                    if (!client) {
                        isValid = false;
                        errorMessage = 'Please select a client.';
                        $(`#client${index}`).focus();
                        return false;
                    }
                    if (!assignment) {
                        isValid = false;
                        errorMessage = 'Please select an assignment.';
                        $(`#assignment${index}`).focus();
                        return false;
                    }
                    if (!partner) {
                        isValid = false;
                        errorMessage = 'Please select a partner.';
                        $(`#partner${index}`).focus();
                        return false;
                    }
                    if (!workItem) {
                        isValid = false;
                        errorMessage = 'Please enter a work item.';
                        $(`.workItem${index}`).focus();
                        return false;
                    }
                    if (!location) {
                        isValid = false;
                        errorMessage = 'Please enter a location.';
                        $(`.location${index}`).focus();
                        return false;
                    }
                    if (!hour || isNaN(hour) || hour < 0) {
                        isValid = false;
                        errorMessage = 'Please enter a valid hour.';
                        $(`#hour${index}`).focus();
                        return false;
                    }
                });
            }

            // Validate both types of field blocks
            validateFields('.field_wrapper');
            if (isValid) {
                validateFields('.extra_field');
            }

            // If any validation failed, stop form submission
            if (!isValid) {
                e.preventDefault();
                alert(errorMessage);
            }
        });
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        function handleClientChange(clientId) {

            var cid = $('#' + clientId).val();
            var datepickers = $('#datepickers1').val();
            var clientNumber = parseInt(clientId.replace('client', ''));

            if (cid == 33) {
                var datepickers = $('#day' + clientNumber).val();

                // convert like  ["01", "01", "1999"]
                var parts = datepickers.split('-');
                // like "1999-01-01"
                var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                var selectedDate = new Date(formattedDate);
                // Get day of week hare  0 = Sunday and 6 = Saturday
                var dayOfWeek = selectedDate.getDay();
                if (dayOfWeek === 6) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('holidaysselect') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(response) {
                            console.log(response);
                            console.log(datepickers);
                            var workitem = (response.holidayName && response.holidayName !==
                                    "null") ?
                                response.holidayName :
                                (response.saturday || 'N/A');

                            var location = 'N/A';
                            var time = 0;

                            $('.assignmentvalue' + clientNumber).html(
                                `<option value="${response.assignmentgenerate_id}">${response.assignment_name} (${response.assignmentname}/${response.assignmentgenerate_id})</option>`
                            );
                            $('.partnervalue' + clientNumber).html(
                                `<option value="${response.team_memberid}">${response.team_member}</option>`
                            );
                            $('.workitemnvalue' + clientNumber).val(workitem).prop(
                                'readonly', true);
                            $('.locationvalue' + clientNumber).val(location).prop(
                                'readonly', true);
                            $('#totalhours' + clientNumber).val(time);
                            //   $('#hour' + (clientNumber + 1)).prop('readonly', true);
                            $('#hour' + clientNumber).val(time).prop('readonly', true);
                            $('#plusbuttion' + clientNumber).addClass('d-none');
                        }
                    });
                } else {
                    alert('You can only select offholidays client on Saturdays');
                    $('#client' + clientNumber).val('');
                }
            } else {
                //   alert('ji');
                //   $('.row.row-sm.showdiv1').removeClass('d-none').find('input,textarea').val('').prop(
                //       'readonly', false);
                //   $('#assignment1, #partner1').empty();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(res) {
                        $('.assignmentvalue' + clientNumber).empty().append(res);
                        $('.partnervalue' + clientNumber).empty();
                        $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                            false);
                        $('.locationvalue' + clientNumber).val('').prop('readonly',
                            false);
                        $('#hour' + clientNumber).prop('readonly', false);
                        $('#plusbuttion' + clientNumber).removeClass('d-none');
                        //   $('#totalhours' + clientNumber).val(0);
                    }
                });
            }
        }

        function handleAssignmentChange(assignmentId) {
            var assignment = $('#' + assignmentId).val();
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: {
                    assignment: assignment
                },
                success: function(res) {
                    $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                }
            });
        }

        function calculateTotal(hourId) {
            var originalhournubmer = parseInt(hourId.replace('hour', ''));
            var newnumber = originalhournubmer >= 10 ? Math.floor(originalhournubmer / 10) : originalhournubmer;


            //   sum of total child filed like hour10, hour11, etc
            var total = 0;
            for (var i = 0; i < 5; i++) {
                var input = $(`#hour${newnumber}${i}`);
                if (input.length) {
                    var val = parseFloat(input.val()) || 0;
                    total += val;
                }
            }

            // Also check the base hour like (hour1)
            var baseHourInput = $(`#hour${newnumber}`);
            var baseVal = parseFloat(baseHourInput.val()) || 0;
            total += baseVal;

            if (total > 12) {
                alert("The total hours cannot be greater than 12.");
                // reset current field
                $(`#${hourId}`).val(0);
                //   calculateTotal(hourId); 
                return;
            }

            // Set value to totalhours
            $(`#totalhours${newnumber}`).val(total);
        }

        //   var maxField = 4;
        //   var x = 1;
        //   $(document).on("click", ".add_button", function() {
        //       let index = $(this).data("index");
        //       let wrapper = $(`#additionalFields${index}`);

        //       console.log('index', index)
        //       console.log('wrapper', wrapper)
        //       //   if (x < maxField) {
        //       //       x++;
        //       let newFieldHtml = `
        //         <div class="row row-sm extra_field">
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Client Name</label>
        //                     <select required class="language form-control refresh" name="client_id1[]" id="client2">
        //                         <option value="">Select Client</option>
        //                         @foreach ($client as $clientData)
        //                             <option value="{{ $clientData->id }}">
        //                                 {{ $clientData->client_name }} ({{ $clientData->client_code }})
        //                             </option>
        //                         @endforeach
        //                     </select>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Assignment Name</label>
        //                     <select class="form-control key refreshoption assignmentvalue2" name="assignment_id1[]" id="assignment2"></select>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Partner</label>
        //                     <select class="language form-control refreshoption partnervalue2" id="partner2" name="partner1[]"></select>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600" style="width:100px;">Work Item</label>
        //                     <textarea type="text" name="workitem1[]" class="form-control key workItem2 refresh workitemnvalue2"></textarea>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600" style="width:100px;">Location</label>
        //                     <input type="text" name="location1[]" class="form-control key location2 refresh locationvalue2">
        //                 </div>
        //             </div>
        //             <div class="col-1">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Hour</label>
        //                     <input type="text" class="form-control hour2 refresh" name="hour1[]" oninput="calculateTotal(this)" value="0" step="1">
        //                 </div>
        //             </div>
        //             <div class="col-1">
        //                 <div class="form-group" style="margin-top: 36px;">
        //                     <a href="javascript:void(0);" class="remove_button" title="Remove field">
        //                         <img src="{{ url('backEnd/image/remove-icon.png') }}" />
        //                     </a>
        //                 </div>
        //             </div>
        //         </div>`;

        //       wrapper.append(newFieldHtml);

        //       //   }
        //   });

        $(document).on("click", ".add_button", function() {
            let index = $(this).data("index"); // Get index of the clicked button
            let wrapper = $(`#additionalFields${index}`); // Get the wrapper div
            let fieldCount = wrapper.find('.extra_field').length; // Count existing fields

            if (fieldCount < 4) { // Allow max 5 fields per wrapper
                let idincreament = `${index}${fieldCount}`;
                //   console.log('index', index);
                //   console.log('fieldCount', fieldCount);
                //   console.log('idincreament', idincreament);
                let newFieldHtml = `
        <div class="row row-sm extra_field">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Client Name</label>
                    <select required class="language form-control refresh" name="client_id${index}[]" id="client${idincreament}">
                        <option value="">Select Client</option>
                        @foreach ($client as $clientData)
                            <option value="{{ $clientData->id }}">
                                {{ $clientData->client_name }} ({{ $clientData->client_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Assignment Name</label>
                    <select class="form-control key refreshoption assignmentvalue${idincreament}" name="assignment_id${index}[]" id="assignment${idincreament}"></select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Partner</label>
                    <select class="language form-control refreshoption partnervalue${idincreament}" name="partner${index}[]" id="partner${idincreament}"></select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Work Item</label>
                    <textarea type="text" name="workitem${index}[]" class="form-control key workItem${idincreament} refresh workitemnvalue${idincreament}"></textarea>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Location</label>
                    <input type="text" name="location${index}[]" class="form-control key location${idincreament} refresh locationvalue${idincreament}">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">Hour</label>
                    <input type="text" class="form-control hour${idincreament} refresh" id="hour${idincreament}" name="hour${index}[]" oninput="calculateTotal(this)" value="0" step="1">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a href="javascript:void(0);" class="remove_button" title="Remove field">
                        <img src="{{ url('backEnd/image/remove-icon.png') }}" />
                    </a>
                </div>
            </div>
        </div>`;

                wrapper.append(newFieldHtml); // Append only if limit is not reached
            } else {
                alert("You can only add up to 5 fields per section.");
            }
        });

        $(document).on("click", ".remove_button", function() {
            $(this).closest(".extra_field").remove();
        });

        //   $(document).on("change", "#client1", function() {
        //       //   alert('hi 1');
        //       handleClientChange($(this).attr("id"));
        //   });
        //   $(document).on("change", "#assignment1", function() {
        //       //   alert('hi');
        //       handleAssignmentChange($(this).attr("id"));
        //   });

        // Optimized event listener for all clients and assignments
        $(document).on("change", "[id^='client']", function() {
            //   alert('hi ');
            handleClientChange($(this).attr("id"));
        });

        $(document).on("change", "[id^='assignment']", function() {
            handleAssignmentChange($(this).attr("id"));
        });

        $(document).on("input", "[class*='hour']", function() {
            calculateTotal($(this).attr("id"));
        });

    });
</script>
{{--  Start Hare  --}}


<script>
    $(document).ready(function() {
        function handleClientChange(clientId) {

            var cid = $('#' + clientId).val();
            var datepickers = $('#datepickers1').val();
            var clientNumber = parseInt(clientId.replace('client', ''));

            if (cid == 33) {
                //   var datepickers = $('#day' + clientNumber).val();
                //   var datepickers = "08-03-2025";
                var datepickers = "22-03-2025";

                $.ajax({
                    type: "get",
                    url: "{{ url('holidaysselect') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },

                    success: function(response) {
                        console.log(response);

                        var parts = datepickers.split('-');
                        var formattedDate = parts[2] + '-' + parts[1] + '-' + parts[0];
                        var selectedDate = new Date(formattedDate);
                        var dayOfWeek = selectedDate.getDay(); // 0 = Sunday, 6 = Saturday

                        var roleId = response.roleId;

                        if (roleId == 13 || roleId == 14) {
                            if (
                                (response.holidayName && response.holidayName !== "null") ||
                                (dayOfWeek === 6 && (response.saturday === '2nd Saturday' ||
                                    response.saturday === '4th Saturday'))
                            ) {
                                applyOffHolidayUI(response, clientNumber);
                            } else {
                                alert(
                                    'You can only select offholidays client on 2nd and 4th Saturdays for this role.'
                                );
                                $('#client' + clientNumber).val('');
                            }

                        } else {
                            if (dayOfWeek === 6) {
                                applyOffHolidayUI(response, clientNumber);
                            } else {
                                alert('You can only select offholidays client on Saturdays.');
                                $('#client' + clientNumber).val('');
                            }
                        }
                    }
                });

                function applyOffHolidayUI(response, clientNumber) {
                    var workitem = (response.holidayName && response.holidayName !== "null") ?
                        response.holidayName : (response.saturday || '');

                    var location = 'N/A';
                    var time = 0;

                    $('.assignmentvalue' + clientNumber).html(
                        `<option value="${response.assignmentgenerate_id}">${response.assignment_name} (${response.assignmentname}/${response.assignmentgenerate_id})</option>`
                    );
                    $('.partnervalue' + clientNumber).html(
                        `<option value="${response.team_memberid}">${response.team_member}</option>`
                    );
                    $('.workitemnvalue' + clientNumber).val(workitem).prop('readonly', true);
                    $('.locationvalue' + clientNumber).val(location).prop('readonly', true);
                    $('#totalhours' + clientNumber).val(time);
                    $('#hour' + clientNumber).val(time).prop('readonly', true);
                    $('#plusbuttion' + clientNumber).addClass('d-none');
                }
            } else {

                //   alert('ji');
                //   $('.row.row-sm.showdiv1').removeClass('d-none').find('input,textarea').val('').prop(
                //       'readonly', false);
                //   $('#assignment1, #partner1').empty();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(res) {
                        $('.assignmentvalue' + clientNumber).empty().append(res);
                        $('.partnervalue' + clientNumber).empty();
                        $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                            false);
                        $('.locationvalue' + clientNumber).val('').prop('readonly',
                            false);
                        $('#hour' + clientNumber).prop('readonly', false);
                        $('#plusbuttion' + clientNumber).removeClass('d-none');
                        //   $('#totalhours' + clientNumber).val(0);
                    }
                });
            }
        }

        function handleAssignmentChange(assignmentId) {
            var assignment = $('#' + assignmentId).val();
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                data: {
                    assignment: assignment
                },
                success: function(res) {
                    $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                }
            });
        }

        function calculateTotal(hourId) {
            var originalhournubmer = parseInt(hourId.replace('hour', ''));
            var newnumber = originalhournubmer >= 10 ? Math.floor(originalhournubmer / 10) :
                originalhournubmer;


            //   sum of total child filed like hour10, hour11, etc
            var total = 0;
            for (var i = 0; i < 5; i++) {
                var input = $(`#hour${newnumber}${i}`);
                if (input.length) {
                    var val = parseFloat(input.val()) || 0;
                    total += val;
                }
            }

            // Also check the base hour like (hour1)
            var baseHourInput = $(`#hour${newnumber}`);
            var baseVal = parseFloat(baseHourInput.val()) || 0;
            total += baseVal;

            if (total > 12) {
                alert("The total hours cannot be greater than 12.");
                // reset current field
                $(`#${hourId}`).val(0);
                //   calculateTotal(hourId); 
                return;
            }

            // Set value to totalhours
            $(`#totalhours${newnumber}`).val(total);
        }

        //   var maxField = 4;
        //   var x = 1;
        //   $(document).on("click", ".add_button", function() {
        //       let index = $(this).data("index");
        //       let wrapper = $(`#additionalFields${index}`);

        //       console.log('index', index)
        //       console.log('wrapper', wrapper)
        //       //   if (x < maxField) {
        //       //       x++;
        //       let newFieldHtml = `
        //         <div class="row row-sm extra_field">
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Client Name</label>
        //                     <select required class="language form-control refresh" name="client_id1[]" id="client2">
        //                         <option value="">Select Client</option>
        //                         @foreach ($client as $clientData)
        //                             <option value="{{ $clientData->id }}">
        //                                 {{ $clientData->client_name }} ({{ $clientData->client_code }})
        //                             </option>
        //                         @endforeach
        //                     </select>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Assignment Name</label>
        //                     <select class="form-control key refreshoption assignmentvalue2" name="assignment_id1[]" id="assignment2"></select>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Partner</label>
        //                     <select class="language form-control refreshoption partnervalue2" id="partner2" name="partner1[]"></select>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600" style="width:100px;">Work Item</label>
        //                     <textarea type="text" name="workitem1[]" class="form-control key workItem2 refresh workitemnvalue2"></textarea>
        //                 </div>
        //             </div>
        //             <div class="col-2">
        //                 <div class="form-group">
        //                     <label class="font-weight-600" style="width:100px;">Location</label>
        //                     <input type="text" name="location1[]" class="form-control key location2 refresh locationvalue2">
        //                 </div>
        //             </div>
        //             <div class="col-1">
        //                 <div class="form-group">
        //                     <label class="font-weight-600">Hour</label>
        //                     <input type="text" class="form-control hour2 refresh" name="hour1[]" oninput="calculateTotal(this)" value="0" step="1">
        //                 </div>
        //             </div>
        //             <div class="col-1">
        //                 <div class="form-group" style="margin-top: 36px;">
        //                     <a href="javascript:void(0);" class="remove_button" title="Remove field">
        //                         <img src="{{ url('backEnd/image/remove-icon.png') }}" />
        //                     </a>
        //                 </div>
        //             </div>
        //         </div>`;

        //       wrapper.append(newFieldHtml);

        //       //   }
        //   });

        $(document).on("click", ".add_button", function() {
            let index = $(this).data("index"); // Get index of the clicked button
            let wrapper = $(`#additionalFields${index}`); // Get the wrapper div
            let fieldCount = wrapper.find('.extra_field').length; // Count existing fields

            if (fieldCount < 4) { // Allow max 5 fields per wrapper
                let idincreament = `${index}${fieldCount}`;
                //   console.log('index', index);
                //   console.log('fieldCount', fieldCount);
                //   console.log('idincreament', idincreament);
                let newFieldHtml = `
        <div class="row row-sm extra_field">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Client Name</label>
                    <select required class="language form-control refresh" name="client_id${index}[]" id="client${idincreament}">
                        <option value="">Select Client</option>
                        @foreach ($client as $clientData)
                            <option value="{{ $clientData->id }}">
                                {{ $clientData->client_name }} ({{ $clientData->client_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Assignment Name</label>
                    <select class="form-control key refreshoption assignmentvalue${idincreament}" name="assignment_id${index}[]" id="assignment${idincreament}"></select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Partner</label>
                    <select class="language form-control refreshoption partnervalue${idincreament}" name="partner${index}[]" id="partner${idincreament}"></select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Work Item</label>
                    <textarea type="text" name="workitem${index}[]" class="form-control key workItem${idincreament} refresh workitemnvalue${idincreament}"></textarea>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Location</label>
                    <input type="text" name="location${index}[]" class="form-control key location${idincreament} refresh locationvalue${idincreament}">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">Hour</label>
                    <input type="text" class="form-control hour${idincreament} refresh" id="hour${idincreament}" name="hour${index}[]" oninput="calculateTotal(this)" value="0" step="1">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a href="javascript:void(0);" class="remove_button" title="Remove field">
                        <img src="{{ url('backEnd/image/remove-icon.png') }}" />
                    </a>
                </div>
            </div>
        </div>`;

                wrapper.append(newFieldHtml); // Append only if limit is not reached
            } else {
                alert("You can only add up to 5 fields per section.");
            }
        });

        $(document).on("click", ".remove_button", function() {
            $(this).closest(".extra_field").remove();
        });

        //   $(document).on("change", "#client1", function() {
        //       //   alert('hi 1');
        //       handleClientChange($(this).attr("id"));
        //   });
        //   $(document).on("change", "#assignment1", function() {
        //       //   alert('hi');
        //       handleAssignmentChange($(this).attr("id"));
        //   });

        // Optimized event listener for all clients and assignments
        $(document).on("change", "[id^='client']", function() {
            //   alert('hi ');
            handleClientChange($(this).attr("id"));
        });

        $(document).on("change", "[id^='assignment']", function() {
            handleAssignmentChange($(this).attr("id"));
        });

        $(document).on("input", "[class*='hour']", function() {
            calculateTotal($(this).attr("id"));
        });

    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding multiple select  --}}
{{--  Start Hare  --}}
<div class="col-sm-12">
    <div class="form-group">
        <label class="font-weight-600">Partner Name : *</label>
        <select required class="language form-control" multiple="" id="exampleFormControlSelect1" name="otherpatnerid[]">
            <option value="">Please Select One</option>
            @foreach ($addonpartner as $teammemberData)
                <option value="{{ $teammemberData->id }}">
                    {{ $teammemberData->team_member }} (
                    {{ $teammemberData->newstaff_code ?? ($teammemberData->staffcode ?? '') }})
                </option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sendOtpBtn').on('click', function(e) {
            e.preventDefault(); // prevent default form submission (if any)

            var assignmentId = "{{ $clientList->assignmentgenerate_id }}";
            var status = $("#statusvalue").val();
            var selectedpartner = $("#exampleFormControlSelect1").val();

            // Debug log (or you can use alert for testing)
            console.log("Assignment ID:", assignmentId);
            console.log("Status:", status);
            console.log("Selected Partner:", selectedpartner);

            //   if (!selectedpartner || selectedpartner.length === 0) {
            //       alert("Please select at least one partner.");
            //       return;
            //   }

            $.ajax({
                url: "{{ url('confirmationotpsend') }}",
                method: "GET",
                //   type: 'GET',
                data: {
                    assignmentid: assignmentId,
                    selectedpartner: selectedpartner,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    //   if (response.status === 0) {
                    //       $('#confirmationModal').modal('show');
                    //       $('#otpmessage').text(response.otpsuccessmessage).addClass(
                    //           'text-success');
                    //   } else {
                    //       alert(response.otpsuccessmessage);
                    //   }
                    console.log(response);
                    if ($('#managervarificationmodal').hasClass('show')) {
                        $('#managervarificationmodal').modal('hide');
                    }
                    $('#confirmationModal').modal('show');

                    if (response.status == 0) {
                        $("#otpmessage").text(response.otpsuccessmessage);
                    } else {
                        $("#errormessage").text(response.otpsuccessmessage);
                        $("#verifyBtn").addClass('disable');
                        $("#yesid").hide();
                    }
                },
                error: function() {
                    alert('An error occurred while sending OTP.');
                }
            });
        });

        //   // Resend OTP logic
        //   $('#resendOtp').on('click', function(e) {
        //       e.preventDefault();
        //       $('#sendOtpBtn').click();
        //   });
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding  --}}
{{--  Start Hare  --}}
$('#yourOtpSendButtonId').on('click', function (e) {
e.preventDefault();

var assignmentid = $(this).data('id');
var selectedpartner = $('#selectedpartner').val(); // if applicable
var status = 0;

$.ajax({
type: "POST",
url: "{{ url('confirmationotpsend') }}",
data: {
_token: "{{ csrf_token() }}",
assignmentid: assignmentid,
selectedpartner: selectedpartner,
status: status
},
success: function (response) {
if (response.status == 0) {
$('#otpmessage').text(response.otpsuccessmessage);
$('#confirmationModal').modal('show'); // 💥 this opens the modal
} else {
$('#errormessage').text(response.otpsuccessmessage);
}
}
});
});

{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding run once / already run --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

        // Check if the script has already run
        if (!sessionStorage.getItem('zipScriptExecuted')) {
            sessionStorage.setItem('zipScriptExecuted', true);

            // Show waiting message
            $('#loadingMessage').show();

            // Redirect user to download the zip
            window.location.href = '/createzipfolder?assignmentgenerateid=' + assignmentgenerateid1;

            // Show afterzipcreated div after 3 seconds
            setTimeout(function() {
                $('#loadingMessage').hide();
                $('#afterzipcreated').show();
            }, 3000);
        } else {
            $('#allreadydownload').show();
        }
    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- <script>
    $(document).ready(function() {
        // Create Zip file button click then
        $('#downloadButton').click(function(e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

            // Show waiting message
            $('#loadingMessage').show();
            // Create Zip file button hide 
            $('#downloadButton').hide();

            $.ajax({
                type: 'GET',
                url: '/createzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid1,
                },
                success: function(data) {
                    // Hide waiting message
                    $('#loadingMessage').hide();
                    // Display created zip file name
                    // $('#createdzipfile').text('Created Zip File: ' + data).show();
                    $('#createdzipfile').text('Created Zip File: ' + data.zipFile).show();
                    $('#downloadzip').show();
                    console.log("No any error occure");

                },
                // handle error
                error: function(error) {
                    console.log("start error message from hare");
                    // Shows basic error message
                    console.error("AJAX Error:", error);
                    // Shows complete response object
                    console.log("Full Response:", xhr);
                    // Shows actual error details
                    console.log("Response Text:", xhr.responseText);
                    // Shows actual error details from backend
                    console.log("Status:", status);
                }
            });
        });
    });
</script> --}}


{{-- <script>
    $(document).ready(function() {
        $('#downloadButton').click(function(e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

            // Show waiting message
            $('#loadingMessage').show();
            $('#downloadButton').hide();

            // Redirect user to download the zip
            window.location.href = '/createzipfolder?assignmentgenerateid=' + assignmentgenerateid1;
            // Show afterzipcreated div after 10 seconds
            setTimeout(function() {
                $('#loadingMessage').hide();
                $('#afterzipcreated').show();
            }, 3000);

            // setTimeout(function() {
            //     window.location.href = '/assignmentfoldercreate/' + assignmentgenerateid1;
            // }, 3000);
        });
    });
</script> --}}


<script>
    $(document).ready(function() {
        var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

        // Show waiting message
        $('#loadingMessage').show();

        // Redirect user to download the zip
        window.location.href = '/createzipfolder?assignmentgenerateid=' + assignmentgenerateid1;

        // Show afterzipcreated div after 3 seconds
        setTimeout(function() {
            $('#loadingMessage').hide();
            $('#afterzipcreated').show();
        }, 3000);

        // setTimeout(function() {
        //     window.location.href = '/assignmentfoldercreate/' + assignmentgenerateid1;
        // }, 3000);
    });
</script>

{{-- <script>
    $(document).ready(function() {
        var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';

        // Check if the script has already run
        if (!sessionStorage.getItem('zipScriptExecuted')) {
            sessionStorage.setItem('zipScriptExecuted', true);

            // Show waiting message
            $('#loadingMessage').show();

            // Redirect user to download the zip
            window.location.href = '/createzipfolder?assignmentgenerateid=' + assignmentgenerateid1;

            // Show afterzipcreated div after 3 seconds
            setTimeout(function() {
                $('#loadingMessage').hide();
                $('#afterzipcreated').show();
            }, 3000);
        } else {
            $('#allreadydownload').show();
        }
    });
</script> --}}

{{-- @if (!isset($message))
                    <div>
                        <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip
                            File</button>
                    </div>
                @endif --}}

{{-- <div class="row">
                    <div>
                        <a href="{{ route('createdzipdownload', ['assignmentgenerateid' => $assignmentgenerateid]) }}"
                            class="btn btn-success" style="color:white; display:none;" id="downloadzip">Download
                            zip file</a>
                    </div>
                </div> --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding pure javascript / regarding javascript --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
<input type="text" name="mobile_no" placeholder="Enter Mobile No">
<button id="submitBtn">Submit</button>

<script>
    document.getElementById("submitBtn").addEventListener("click", function(event) {
        var mobile_no = document.querySelector("[name='mobile_no']").value;

        // Check if input contains only digits
        if (!/^\d+$/.test(mobile_no)) {
            alert("Enter mobile number using only digits!");
            document.querySelector("[name='mobile_no']").value = ''; // Clear input
            event.preventDefault(); // Prevent form submission
        }
    });
</script>

{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding form submit / on submit / onsubmit / regarding validation  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            var teammemberId = $("[name='teammemberId']").val();
            var assignmentId = $("[name='assignmentId']").val();
            var statusId = $("[name='statusId']").val();

            if (!teammemberId && !assignmentId && !statusId) {
                alert("At least choose one field");

                // Sirf pehle field pe focus karwana (optional logic)
                $("[name='teammemberId']").focus();

                event.preventDefault(); // Form submit ko rokna
                return false;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            var teammemberId = $("[name='teammemberId']").val();
            var assignmentId = $("[name='assignmentId']").val();
            var statusId = $("[name='statusId']").val();

            if (!teammemberId && !assignmentId && !statusId) {
                alert("At least choose one field");

                // Focus first empty field
                if (!$("[name='teammemberId']").val()) {
                    $("[name='teammemberId']").focus();
                } else if (!$("[name='assignmentId']").val()) {
                    $("[name='assignmentId']").focus();
                } else if (!$("[name='statusId']").val()) {
                    $("[name='statusId']").focus();
                }

                event.preventDefault();
                return false;
            }
        });
    });
</script>


{{--  Start Hare  --}}
@if (Request::is('teammember/*/edit') || Request::is('teammember/create'))
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            //  alert('hi');
            // Condition on form submit
            $('form').submit(function(event) {
                //  alert('hi');
                var mobile_no = $("[name='mobile_no']").val();
                var emergencycontactnumber = $("[name='emergencycontactnumber']").val();
                var mothernumber = $("[name='mothernumber']").val();
                var fathernumber = $("[name='fathernumber']").val();

                var profilepic = $("[name='profilepic']").val().trim();
                // file extensions
                var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

                var bankaccountnumber = $("[name='bankaccountnumber']").val();

                var adharcardnumber = $("[name='adharcardnumber']").val();

                var pancardno = $("[name='pancardno']").val().trim();
                // PAN Card Pattern AAAAA9999A will be like it
                var panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

                var personalemail = $("[name='personalemail']").val().trim();
                var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                var dateofbirth = $("[name='dateofbirth']").val();
                var joining_date = $("[name='joining_date']").val();
                var leavingdate = $("[name='leavingdate']").val();
                // Get today's date
                var today = new Date();
                today.setHours(0, 0, 0, 0);

                var dob = new Date(dateofbirth);
                var joiningdate = new Date(joining_date);
                var leavingdateformate = new Date(leavingdate);

                // Check digit
                if (!/^\d+$/.test(mobile_no)) {
                    alert('Enter mobile number using only digits');
                    // $("[name='mobile_no']").val('');
                    $("[name='mobile_no']").focus();
                    // Prevent form submission
                    event.preventDefault();
                    return false;
                }
                if (!/^\d+$/.test(emergencycontactnumber)) {
                    alert('Enter emergency mobile number using only digits');
                    // $("[name='emergencycontactnumber']").val('');
                    $("[name='emergencycontactnumber']").focus();
                    // Prevent form submission
                    event.preventDefault();
                    return false;
                }

                if (adharcardnumber && !/^\d+$/.test(adharcardnumber)) {
                    alert('Enter aadhar number using only digits');
                    // $("[name='adharcardnumber']").val('');
                    $("[name='adharcardnumber']").focus();
                    // Prevent form submission
                    event.preventDefault();
                    return false;
                }

                if (mothernumber && !/^\d+$/.test(mothernumber)) {
                    alert('Enter mother mobile number using only digits');
                    // $("[name='mobile_no']").val('');
                    $("[name='mothernumber']").focus();
                    // Prevent form submission
                    event.preventDefault();
                    return false;
                }

                if (fathernumber && !/^\d+$/.test(fathernumber)) {
                    alert('Enter father mobile number using only digits');
                    // $("[name='mobile_no']").val('');
                    $("[name='fathernumber']").focus();
                    // Prevent form submission
                    event.preventDefault();
                    return false;
                }
                if (bankaccountnumber && !/^\d+$/.test(bankaccountnumber)) {
                    alert('Enter bank account number using only digits');
                    // $("[name='mobile_no']").val('');
                    $("[name='bankaccountnumber']").focus();
                    // Prevent form submission
                    event.preventDefault();
                    return false;
                }

                // // Check if email is valid
                if (!emailPattern.test(personalemail)) {
                    alert("Enter a valid email address ");
                    // $("[name='personalemail']").val('');
                    $("[name='personalemail']").focus();
                    event.preventDefault();
                    return false;
                }

                // date of birth is in the future
                if (dob > today) {
                    alert("Date of Birth cannot be in the future");
                    // $("[name='dateofbirth']").val('');
                    $("[name='dateofbirth']").focus();
                    event.preventDefault();
                    return false;
                }

                // date of joining is in the future
                if (joiningdate > today) {
                    alert("Date of joinig cannot be in the future");
                    // $("[name='dateofbirth']").val('');
                    $("[name='joining_date']").focus();
                    event.preventDefault();
                    return false;
                }
                // date of leavingdateformate is in the future
                if (leavingdateformate > today) {
                    alert("Date of leaving cannot be in the future");
                    // $("[name='dateofbirth']").val('');
                    $("[name='leavingdate']").focus();
                    event.preventDefault();
                    return false;
                }

                if (!panPattern.test(pancardno)) {
                    alert("Enter a valid PAN Card number like AAAAA9999A");
                    // $("[name='pancardno']").val('');
                    $("[name='pancardno']").focus();
                    event.preventDefault();
                    return false;
                }

                if (profilepic && !allowedExtensions.test(profilepic)) {
                    // 'filess.*' => 'mimes:png,jpg,jpeg,csv,xlx,xls,pdf,zip,rar',
                    alert("Profile picture must be in JPG, JPEG, or PNG format");
                    $("[name='profilepic']").val('');
                    $("[name='profilepic']").focus();
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endif

{{--  Start Hare optimized  --}}


{{--  Start Hare optimized  --}}
@if (Request::is('teammember/*/edit') || Request::is('teammember/create'))
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                let fields = {
                    mobile_no: "Mobile Number",
                    emergencycontactnumber: "Emergency Contact Number",
                    mothernumber: "Mother's Mobile Number",
                    fathernumber: "Father's Mobile Number",
                    bankaccountnumber: "Bank Account Number",
                    adharcardnumber: "Aadhar Number",
                };

                for (let field in fields) {
                    let value = $("[name='" + field + "']").val();
                    if (value && !/^\d+$/.test(value)) {
                        alert(`Enter ${fields[field]} using only digits`);
                        $("[name='" + field + "']").focus();
                        event.preventDefault();
                        return false;
                    }
                }

                let profilepic = $("[name='profilepic']").val().trim();
                let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (profilepic && !allowedExtensions.test(profilepic)) {
                    alert("Profile picture must be in JPG, JPEG, or PNG format");
                    $("[name='profilepic']").val('').focus();
                    event.preventDefault();
                    return false;
                }

                let pancardno = $("[name='pancardno']").val().trim();
                let panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
                if (!panPattern.test(pancardno)) {
                    alert("Enter a valid PAN Card number like AAAAA9999A");
                    $("[name='pancardno']").focus();
                    event.preventDefault();
                    return false;
                }

                let personalemail = $("[name='personalemail']").val().trim();
                let emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!emailPattern.test(personalemail)) {
                    alert("Enter a valid email address");
                    $("[name='personalemail']").focus();
                    event.preventDefault();
                    return false;
                }

                let today = new Date();
                today.setHours(0, 0, 0, 0);

                let dates = {
                    dateofbirth: "Date of Birth",
                    joining_date: "Date of Joining",
                    leavingdate: "Date of Leaving",
                };

                for (let dateField in dates) {
                    let dateValue = $("[name='" + dateField + "']").val();
                    if (dateValue) {
                        let selectedDate = new Date(dateValue);
                        if (selectedDate > today) {
                            alert(`${dates[dateField]} cannot be in the future`);
                            $("[name='" + dateField + "']").focus();
                            event.preventDefault();
                            return false;
                        }
                    }
                }
            });
        });
    </script>
@endif
{{--  Start Hare optimized  --}}
<script>
    $(document).ready(function() {
        $('form').submit(function(event) {
            // Function to check if input contains only digits
            function isValidNumber(fieldName, fieldLabel) {
                var value = $("[name='" + fieldName + "']").val();
                if (!/^\d+$/.test(value)) {
                    alert(`Enter ${fieldLabel} using only digits`);
                    $("[name='" + fieldName + "']").focus();
                    event.preventDefault();
                    return false;
                }
                return true;
            }

            // Function to check if date is in the future
            function isValidDate(fieldName, fieldLabel) {
                var dateValue = $("[name='" + fieldName + "']").val();
                if (!dateValue) return true; // Skip if the field is empty
                var inputDate = new Date(dateValue);
                var today = new Date();
                today.setHours(0, 0, 0, 0);

                if (inputDate > today) {
                    alert(`${fieldLabel} cannot be in the future`);
                    $("[name='" + fieldName + "']").focus();
                    event.preventDefault();
                    return false;
                }
                return true;
            }

            // Check mobile numbers and other numeric fields
            var numericFields = [{
                    field: "mobile_no",
                    label: "mobile number"
                },
                {
                    field: "emergencycontactnumber",
                    label: "emergency contact number"
                },
                {
                    field: "mothernumber",
                    label: "mother's number"
                },
                {
                    field: "fathernumber",
                    label: "father's number"
                },
                {
                    field: "bankaccountnumber",
                    label: "bank account number"
                },
                {
                    field: "adharcardnumber",
                    label: "Aadhar number"
                }
            ];

            for (var i = 0; i < numericFields.length; i++) {
                if (!isValidNumber(numericFields[i].field, numericFields[i].label)) return false;
            }

            // Validate email format
            var personalemail = $("[name='personalemail']").val().trim();
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(personalemail)) {
                alert("Enter a valid email address!");
                $("[name='personalemail']").focus();
                event.preventDefault();
                return false;
            }

            // Validate date fields (must not be in the future)
            var dateFields = [{
                    field: "dateofbirth",
                    label: "Date of Birth"
                },
                {
                    field: "joining_date",
                    label: "Joining Date"
                },
                {
                    field: "leavingdate",
                    label: "Leaving Date"
                }
            ];

            for (var j = 0; j < dateFields.length; j++) {
                if (!isValidDate(dateFields[j].field, dateFields[j].label)) return false;
            }

            // Validate PAN Card format
            var pancardno = $("[name='pancardno']").val().trim();
            var panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            if (!panPattern.test(pancardno)) {
                alert("Enter a valid PAN Card number (e.g., AAAAA9999A)");
                $("[name='pancardno']").focus();
                event.preventDefault();
                return false;
            }

            // Validate Profile Picture File Type
            var profilepic = $("[name='profilepic']").val().trim();
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
            if (profilepic && !allowedExtensions.test(profilepic)) {
                alert("Profile picture must be in JPG, JPEG, or PNG format");
                $("[name='profilepic']").focus();
                event.preventDefault();
                return false;
            }
        });
    });
</script>
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        // Condition on form submit
        $('form').submit(function(event) {
            var mobile_no = $("[name='mobile_no']").val();
            var emergencycontactnumber = $("[name='emergencycontactnumber']").val();
            var mothernumber = $("[name='mothernumber']").val();
            var fathernumber = $("[name='fathernumber']").val();

            var profilepic = $("[name='profilepic']").val().trim();
            // file extensions
            var allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;

            var bankaccountnumber = $("[name='bankaccountnumber']").val();

            var adharcardnumber = $("[name='adharcardnumber']").val();

            var pancardno = $("[name='pancardno']").val().trim();
            // PAN Card Pattern AAAAA9999A will be like it
            var panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;

            var personalemail = $("[name='personalemail']").val().trim();
            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            var dateofbirth = $("[name='dateofbirth']").val();
            var joining_date = $("[name='joining_date']").val();
            var leavingdate = $("[name='leavingdate']").val();
            // Get today's date
            var today = new Date();
            today.setHours(0, 0, 0, 0);

            var dob = new Date(dateofbirth);
            var joiningdate = new Date(joining_date);
            var leavingdateformate = new Date(leavingdate);

            // Check digit
            if (!/^\d+$/.test(mobile_no)) {
                alert('Enter mobile number using only digits');
                // $("[name='mobile_no']").val('');
                $("[name='mobile_no']").focus();
                // Prevent form submission
                event.preventDefault();
                return false;
            }
            if (!/^\d+$/.test(emergencycontactnumber)) {
                alert('Enter emergencycontactnumber using only digits');
                // $("[name='emergencycontactnumber']").val('');
                $("[name='emergencycontactnumber']").focus();
                // Prevent form submission
                event.preventDefault();
                return false;
            }

            if (!/^\d+$/.test(adharcardnumber)) {
                alert('Enter aadhar number using only digits');
                // $("[name='adharcardnumber']").val('');
                $("[name='adharcardnumber']").focus();
                // Prevent form submission
                event.preventDefault();
                return false;
            }

            if (!/^\d+$/.test(mothernumber)) {
                alert('Enter mobile number using only digits');
                // $("[name='mobile_no']").val('');
                $("[name='mothernumber']").focus();
                // Prevent form submission
                event.preventDefault();
                return false;
            }

            if (fathernumber && !/^\d+$/.test(fathernumber)) {
                alert('Enter mobile number using only digits');
                // $("[name='mobile_no']").val('');
                $("[name='fathernumber']").focus();
                // Prevent form submission
                event.preventDefault();
                return false;
            }
            if (!/^\d+$/.test(bankaccountnumber)) {
                alert('Enter bank account number using only digits');
                // $("[name='mobile_no']").val('');
                $("[name='bankaccountnumber']").focus();
                // Prevent form submission
                event.preventDefault();
                return false;
            }

            // // Check if email is valid
            if (!emailPattern.test(personalemail)) {
                alert("Enter a valid email address!");
                // $("[name='personalemail']").val('');
                $("[name='personalemail']").focus();
                event.preventDefault();
                return false;
            }

            // date of birth is in the future
            if (dob > today) {
                alert("Date of Birth cannot be in the future");
                // $("[name='dateofbirth']").val('');
                $("[name='dateofbirth']").focus();
                event.preventDefault();
                return false;
            }

            // date of joining is in the future
            if (joiningdate > today) {
                alert("Date of Birth cannot be in the future");
                // $("[name='dateofbirth']").val('');
                $("[name='dateofbirth']").focus();
                event.preventDefault();
                return false;
            }
            // date of leavingdateformate is in the future
            if (leavingdateformate > today) {
                alert("Date of leavingdate cannot be in the future");
                // $("[name='dateofbirth']").val('');
                $("[name='leavingdate']").focus();
                event.preventDefault();
                return false;
            }

            if (!panPattern.test(pancardno)) {
                alert("Enter a valid PAN Card number like AAAAA9999A");
                // $("[name='pancardno']").val('');
                $("[name='pancardno']").focus();
                event.preventDefault();
                return false;
            }

            if (profilepic && !allowedExtensions.test(profilepic)) {
                // 'filess.*' => 'mimes:png,jpg,jpeg,csv,xlx,xls,pdf,zip,rar',
                alert("Profile picture must be in JPG, JPEG, or PNG format");
                $("[name='profilepic']").focus();
                event.preventDefault();
                return false;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#startdate').on('change', function() {
            var startclear = $('#startdate');
            var startDateInput1 = $('#startdate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearLength = startyear.toString().length;
            if (yearLength > 4) {
                alert('Enter four digits for the year');
                startclear.val('');
            }
        });

        $('#enddate').on('change', function() {
            var endclear = $('#enddate');
            var endDateInput1 = $('#enddate').val();
            var endtDate = new Date(endDateInput1);
            var endyear = endtDate.getFullYear();
            var endyearLength = endyear.toString().length;
            if (endyearLength > 4) {
                alert('Enter four digits for the year');
                endclear.val('');
            }
        });

        //   condition on submit
        $('form').submit(function(event) {
            var year = $('#year').val();
            var startdate = $('#startdate').val();
            var enddate = $('#enddate').val();

            var teammemberId = $('#teammemberId').val();
            var clientId = $('#clientId').val();
            var assignmentId = $('#assignmentId').val();

            var startclear = $('#startdate');
            var startDateInput1 = $('#startdate').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearvalue = $('#year').val();
            if (year && startdate) {
                if (yearvalue != startyear) {
                    alert('Enter Start Date According Year');
                    startclear.val('');
                    // Prevent form submission
                    event.preventDefault();
                    // Exit the function
                    return;
                }
            }

            var endclear = $('#enddate');
            var endDateInput1 = $('#enddate').val();
            var endtDate = new Date(endDateInput1);
            var endyear = endtDate.getFullYear();
            var yearvalue = $('#year').val();
            if (year && enddate) {
                if (yearvalue != endyear) {
                    alert('Enter End Date According Year');
                    endclear.val('');
                    // Prevent form submission
                    event.preventDefault();
                    // Exit the function
                    return;
                }
            }

            if (year === "" && startdate === "" && enddate === "") {
                alert("Please select year.");
                event.preventDefault();
                return;
            }
            if (startdate !== "" && enddate === "") {
                alert("Please select End date.");
                event.preventDefault();
                return;
            }
            @if (Auth::user()->role_id == 11 ||
                    Request::is('adminsearchtimesheet') ||
                    (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))

                //   if (clientId !== "" && assignmentId !== "" && teammemberId !== "") {
                //       alert("Please select only Employee name/ Client name/ Assignment name.");
                //       event.preventDefault();
                //       return;
                //   }

                //   if (teammemberId !== "" && clientId !== "") {
                //       alert("Please select only Employee name/ Client name.");
                //       event.preventDefault();
                //       return;
                //   }
                //   if (teammemberId !== "" && assignmentId !== "") {
                //       alert("Please select only Employee name/ Assignment name.");
                //       event.preventDefault();
                //       return;
                //   }
            @endif
        });
    });
</script>


<script>
    $(function() {
        // select client 1
        $('#detailsForm').on('submit', function(e) {
            var clientvalue = $('#client').val();
            var assmentvalue = $('#assignment').val();
            var partnervalue = $('#partner').val();

            if (clientvalue != "" || clientvalue != "Select Client") {
                if (assmentvalue == "Select Assignment" || assmentvalue == "") {
                    alert("Please select a assignment");
                    e.preventDefault();
                    $('#assignment1').focus();
                } else if (partnervalue == "Select Partner" || partnervalue == "") {
                    alert("Please select a partner");
                    e.preventDefault();
                    $('#partner1').focus();
                }
            }
        });

    });
</script>


<script>
    $(function() {
        // select client 1
        $('#detailsForm').on('submit', function(e) {
            var clientvalue = $('#client').val();
            var assmentvalue = $('#assignment').val();
            var partnervalue = $('#partner').val();

            if (clientvalue != "" || clientvalue != "Select Client") {
                if (assmentvalue == "Select Assignment" || assmentvalue == "") {
                    alert("Please select a assignment");
                    e.preventDefault();
                    $('#assignment1').focus();
                } else if (partnervalue == "Select Partner" || partnervalue == "") {
                    alert("Please select a partner");
                    e.preventDefault();
                    $('#partner1').focus();
                }
            }
        });

    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding ajax  --}}
{{--  Start Hare  --}}

<script>
    if (newteammember) {
        let timesheetdate = newteammember;
        $.ajax({
            type: "GET",
            url: "{{ url('newteamdata/check') }}",
            data: {
                timesheetdate: timesheetdate
            },
            success: function(res) {
                console.log(res.success); // Debugging ke liye

                // **Response ke andar endDate update karein**
                if (res.success) {
                    endDate = parseDate(dateSelectionresult);
                    if (endDate) endDate.setDate(endDate.getDate() - 1);

                    // **Calendar ko Update karna**
                    updateCalendar(endDate);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", error);
            }
        });
    }


    function updateCalendar(endDate) {
        if (endDate) {
            let formattedDate = ('0' + endDate.getDate()).slice(-2) + '-' +
                ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                endDate.getFullYear();

            document.getElementById('datepickers').value = formattedDate;

            $("#datepickers").datepicker({
                maxDate: endDate,
                minDate: endDate,
                dateFormat: 'dd-mm-yy'
            });

            console.log("Updated Calendar Date:", formattedDate);
        }
    }
</script>


public function newteamdatacheck(Request $request)
{
if ($request->ajax()) {
$authUserId = auth()->user()->teammember_id;

$timesheetRecordcheck = DB::table('timesheetusers')
->where('status', '0')
->where('createdby', $authUserId)
->where('date', $request->timesheetdate)
->exists();

return response()->json(['success' => $timesheetRecordcheck]);
}

return response()->json(['error' => 'Invalid request'], 400);
}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding date enable / regarding calander featurs   --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Declare endDate outside of the conditions
        let endDate = null;

        // Function to parse and validate dates
        function parseDate(date) {
            let parsedDate = new Date(date);
            if (isNaN(parsedDate)) {
                console.error("Invalid date format:", date);
                return null;
            }
            return parsedDate;
        }

        // Helper function to adjust endDate
        function adjustEndDateForWeekend(date) {
            if (date.getDay() === 6) {
                console.log("Incremented date is Sunday, adding another day.");
                date.setDate(date.getDate() + 1); // Increment by one more day
            }
        }

        // Check the conditions for calculating the endDate
        if (timesheetmaxDateRecord && leavedataforcalander1) {
            if (differenceInDays > 1) {
                endDate = parseDate(timesheetmaxDateRecord.date);
            } else {
                // endDate = parseDate(leavedataforcalander1);
                let maxDate = parseDate(timesheetmaxDateRecord.date);
                let leaveDate = parseDate(leavedataforcalander1);
                if (maxDate.getTime() > leaveDate.getTime()) {
                    endDate = maxDate;
                } else {
                    endDate = leaveDate;
                }
            }

            if (!endDate && lasttimesheetsubmiteddata) {
                console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            } else if (leavebreakdateassign) {
                let leavebreakdate = parseDate(leavebreakdateassign);
                let timesheetmaxDate = parseDate(timesheetmaxDateRecord.date);
                let incrementedTimesheetDate = new Date(timesheetmaxDate);

                incrementedTimesheetDate.setDate(incrementedTimesheetDate.getDate() + 1);
                if (leavebreakdate.getTime() > incrementedTimesheetDate.getTime()) {
                    getDate = timesheetmaxDate; // Use original date (not incremented)
                } else {
                    getDate = leavebreakdate;
                }
                console.log("timesheetmaxDate:", timesheetmaxDate);
                console.log("leavebreakdate:", leavebreakdate);
                endDate = parseDate(getDate);
                //  if (endDate) adjustEndDateForWeekend(endDate);
            }
        } else if (lasttimesheetsubmiteddata && !timesheetmaxDateRecord && !leavedataforcalander1 && !
            rejoiningdate) {
            console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
            endDate = parseDate(lasttimesheetsubmiteddata.enddate);
            if (endDate) adjustEndDateForWeekend(endDate);
        } else if (lasttimesheetsubmiteddata && timesheetmaxDateRecord && !leavedataforcalander1) {
            console.log("Using timesheetmaxDateRecord date:", timesheetmaxDateRecord.date);
            endDate = parseDate(timesheetmaxDateRecord.date);
        } else if (newteammember && !lasttimesheetsubmiteddata) {
            //  } else if (newteammember) {

            //  console.log("Using newteammember data:", newteammember);
            //  endDate = timesheetmaxDateRecord ? parseDate(timesheetmaxDateRecord.date) : parseDate(
            //      newteammember);
            //  if (endDate) endDate.setDate(endDate.getDate() - 1);

            if (timesheetmaxDateRecord) {
                endDate = parseDate(timesheetmaxDateRecord.date)
            } else {
                console.log("Using newteammember data:", newteammember);
                endDate = parseDate(newteammember);
                endDate.setDate(endDate.getDate() - 1);
            }
        } else if (rejoiningdate) {
            console.log("Using rejoiningdate data:", rejoiningdate);
            endDate = parseDate(rejoiningdate);
            if (endDate) endDate.setDate(endDate.getDate() - 1);
        } else if (leavedataforcalander1 && lasttimesheetsubmiteddata) {
            if (differenceInDays === 2 || differenceInDays === 1) {
                endDate = parseDate(leavedataforcalander1);
            } else {
                console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            }
        }

        // Set date in the datepicker if endDate is valid
        if (endDate) {
            let today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize today's date to remove time part
            endDate.setHours(0, 0, 0, 0); // Normalize endDate to remove time part

            // Increment endDate if it's not today's date  or  Increment endDate if enddate lesstahn today date and not increamner end date if enddate greater than today date
            //  if (endDate.getTime() !== today.getTime() && endDate.getTime() <= today.getTime()) {
            //      endDate.setDate(endDate.getDate() + 1);
            //  }

            //  if (endDate.getTime() <= today.getTime()) {
            if (endDate.getTime() < today.getTime()) {
                endDate.setDate(endDate.getDate() + 1);
            }


            let formattedDate = ('0' + endDate.getDate()).slice(-2) + '-' +
                ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                endDate.getFullYear();

            // Set the calculated date in the datepicker input field
            document.getElementById('datepickers').value = formattedDate;

            // Initialize the datepicker with the calculated maxDate
            $("#datepickers").datepicker({
                maxDate: endDate,
                minDate: endDate, // Set the same date for minDate if needed
                dateFormat: 'dd-mm-yy'
            });

            //  this code will be refresh data according end date
            if (endDate.getTime() !== today.getTime()) {
                let timesheetdate = formattedDate;
                var refreshpage = $('.refresh');
                refreshpage.val('').prop("readonly", false);
                $('.refreshoption option').remove();
                //   $("#hour1,#hour2,#hour3,#hour4,#hour5").prop("readonly", false);
                $("#hour1,#hour2,#hour3,#hour4,#hour5").val(0);

                //   alert(datepickers);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        timesheetdate: timesheetdate
                    },
                    success: function(res) {
                        $('#client').html(res);
                        $('#client1').html(res);
                        $('#client2').html(res);
                        $('#client3').html(res);
                        $('#client4').html(res);
                    },
                    error: function() {},
                });
            }
            //  this code will be refresh data according end date end hare 

            console.log("Adjusted date set in datepicker:", endDate);
        } else {
            console.log("No valid timesheet or submitted date data found to set datepicker.");
        }
    });
</script>
{{--  Start Hare  --}}
<script>
    // Determine endDate based on available data
    if (timesheetmaxDateRecord && leavedataforcalander1) {
        let maxDate = parseDate(timesheetmaxDateRecord.date);
        let leaveDate = parseDate(leavedataforcalander1);
        endDate = (differenceInDays > 1 || maxDate.getTime() > leaveDate.getTime()) ? maxDate : leaveDate;
    } else if (lasttimesheetsubmiteddata) {
        endDate = parseDate(lasttimesheetsubmiteddata.enddate);
        console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
    } else if (timesheetmaxDateRecord) {
        endDate = parseDate(timesheetmaxDateRecord.date);
        console.log("Using timesheetmaxDateRecord date:", timesheetmaxDateRecord.date);
    } else if (newteammember) {
        endDate = parseDate(timesheetmaxDateRecord ? timesheetmaxDateRecord.date : newteammember);
        if (!timesheetmaxDateRecord) endDate.setDate(endDate.getDate() - 1);
        console.log("Using newteammember data:", newteammember);
    } else if (rejoiningdate) {
        endDate = parseDate(rejoiningdate);
        endDate.setDate(endDate.getDate() - 1);
        console.log("Using rejoiningdate data:", rejoiningdate);
    } else if (leavedataforcalander1 && lasttimesheetsubmiteddata) {
        endDate = (differenceInDays === 1 || differenceInDays === 2) ?
            parseDate(leavedataforcalander1) :
            parseDate(lasttimesheetsubmiteddata.enddate);
        console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
    }
</script>
{{--  Start Hare  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Declare endDate outside of the conditions
        let endDate = null;

        // Function to parse and validate dates
        function parseDate(date) {
            let parsedDate = new Date(date);
            if (isNaN(parsedDate)) {
                console.error("Invalid date format:", date);
                return null;
            }
            return parsedDate;
        }

        // Helper function to adjust endDate
        function adjustEndDateForWeekend(date) {
            if (date.getDay() === 6) {
                console.log("Incremented date is Sunday, adding another day.");
                date.setDate(date.getDate() + 1); // Increment by one more day
            }
        }

        // Check the conditions for calculating the endDate
        if (timesheetmaxDateRecord && leavedataforcalander1) {
            if (differenceInDays > 1) {
                endDate = parseDate(timesheetmaxDateRecord.date);
            } else {
                // endDate = parseDate(leavedataforcalander1);
                let maxDate = parseDate(timesheetmaxDateRecord.date);
                let leaveDate = parseDate(leavedataforcalander1);
                if (maxDate.getTime() > leaveDate.getTime()) {
                    endDate = maxDate;
                } else {
                    endDate = leaveDate;
                }
            }

            if (!endDate && lasttimesheetsubmiteddata) {
                console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            }
        } else if (lasttimesheetsubmiteddata && !timesheetmaxDateRecord && !leavedataforcalander1 && !
            rejoiningdate) {
            console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
            endDate = parseDate(lasttimesheetsubmiteddata.enddate);
            if (endDate) adjustEndDateForWeekend(endDate);
        } else if (lasttimesheetsubmiteddata && timesheetmaxDateRecord && !leavedataforcalander1) {
            console.log("Using timesheetmaxDateRecord date:", timesheetmaxDateRecord.date);
            endDate = parseDate(timesheetmaxDateRecord.date);
        } else if (newteammember && !lasttimesheetsubmiteddata) {
            //  } else if (newteammember) {

            //  console.log("Using newteammember data:", newteammember);
            //  endDate = timesheetmaxDateRecord ? parseDate(timesheetmaxDateRecord.date) : parseDate(
            //      newteammember);
            //  if (endDate) endDate.setDate(endDate.getDate() - 1);

            if (timesheetmaxDateRecord) {
                endDate = parseDate(timesheetmaxDateRecord.date)
            } else {
                console.log("Using newteammember data:", newteammember);
                endDate = parseDate(newteammember);
                endDate.setDate(endDate.getDate() - 1);
            }
        } else if (rejoiningdate) {
            console.log("Using rejoiningdate data:", rejoiningdate);
            endDate = parseDate(rejoiningdate);
            if (endDate) endDate.setDate(endDate.getDate() - 1);
        } else if (leavedataforcalander1 && lasttimesheetsubmiteddata) {
            if (differenceInDays === 2 || differenceInDays === 1) {
                endDate = parseDate(leavedataforcalander1);
            } else {
                console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            }
        }

        // Set date in the datepicker if endDate is valid
        if (endDate) {
            let today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize today's date to remove time part
            endDate.setHours(0, 0, 0, 0); // Normalize endDate to remove time part

            // Increment endDate if it's not today's date  or  Increment endDate if enddate lesstahn today date and not increamner end date if enddate greater than today date
            //  if (endDate.getTime() !== today.getTime() && endDate.getTime() <= today.getTime()) {
            //      endDate.setDate(endDate.getDate() + 1);
            //  }

            //  if (endDate.getTime() <= today.getTime()) {
            if (endDate.getTime() < today.getTime()) {
                endDate.setDate(endDate.getDate() + 1);
            }


            let formattedDate = ('0' + endDate.getDate()).slice(-2) + '-' +
                ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                endDate.getFullYear();

            // Set the calculated date in the datepicker input field
            document.getElementById('datepickers').value = formattedDate;

            // Initialize the datepicker with the calculated maxDate
            $("#datepickers").datepicker({
                maxDate: endDate,
                minDate: endDate, // Set the same date for minDate if needed
                dateFormat: 'dd-mm-yy'
            });

            //  this code will be refresh data according end date
            if (endDate.getTime() !== today.getTime()) {
                let timesheetdate = formattedDate;
                var refreshpage = $('.refresh');
                refreshpage.val('').prop("readonly", false);
                $('.refreshoption option').remove();
                //   $("#hour1,#hour2,#hour3,#hour4,#hour5").prop("readonly", false);
                $("#hour1,#hour2,#hour3,#hour4,#hour5").val(0);

                //   alert(datepickers);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        timesheetdate: timesheetdate
                    },
                    success: function(res) {
                        $('#client').html(res);
                        $('#client1').html(res);
                        $('#client2').html(res);
                        $('#client3').html(res);
                        $('#client4').html(res);
                    },
                    error: function() {},
                });
            }
            //  this code will be refresh data according end date end hare 

            console.log("Adjusted date set in datepicker:", endDate);
        } else {
            console.log("No valid timesheet or submitted date data found to set datepicker.");
        }
    });
</script>
{{--  Start Hare  --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Declare endDate outside of the conditions
        let endDate = null;

        // Function to parse and validate dates
        function parseDate(date) {
            let parsedDate = new Date(date);
            if (isNaN(parsedDate)) {
                console.error("Invalid date format:", date);
                return null;
            }
            return parsedDate;
        }

        // Helper function to adjust endDate
        function adjustEndDateForWeekend(date) {
            if (date.getDay() === 6) {
                console.log("Incremented date is Sunday, adding another day.");
                date.setDate(date.getDate() + 1); // Increment by one more day
            }
        }

        // Check the conditions for calculating the endDate
        if (timesheetmaxDateRecord && leavedataforcalander1) {

            console.log("lasttimesheetsubmiteddata:", lasttimesheetsubmiteddata);
            console.log("timesheetmaxDateRecord:", timesheetmaxDateRecord);
            console.log("leavedataforcalander1:", leavedataforcalander1);
            console.log("leavebreakdateassign:", leavebreakdateassign);
            console.log("differenceInDays:", differenceInDays);
            console.log("newteammember:", newteammember);
            console.log("rejoiningdate:", rejoiningdate);

            if (differenceInDays > 1) {
                endDate = parseDate(timesheetmaxDateRecord.date);
            } else {
                // endDate = parseDate(leavedataforcalander1);
                let maxDate = parseDate(timesheetmaxDateRecord.date);
                let leaveDate = parseDate(leavedataforcalander1);
                if (maxDate.getTime() > leaveDate.getTime()) {
                    endDate = maxDate;
                } else {
                    endDate = leaveDate;
                }
            }

            if (!endDate && lasttimesheetsubmiteddata) {
                console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            } else if (leavebreakdateassign) {
                //  if (differenceInDays !== 1) {
                let leavebreakdate = parseDate(leavebreakdateassign);
                let timesheetmaxDate = parseDate(timesheetmaxDateRecord.date);
                let incrementedTimesheetDate = new Date(timesheetmaxDate);

                incrementedTimesheetDate.setDate(incrementedTimesheetDate.getDate() + 1);
                if (leavebreakdate.getTime() > incrementedTimesheetDate.getTime()) {
                    getDate = timesheetmaxDate; // Use original date (not incremented)
                } else {
                    getDate = leavebreakdate;
                }
                console.log("timesheetmaxDate:", timesheetmaxDate);
                console.log("leavebreakdate:", leavebreakdate);
                endDate = parseDate(getDate);
                //  if (endDate) adjustEndDateForWeekend(endDate);

                //  }
            }
        } else if (lasttimesheetsubmiteddata && !timesheetmaxDateRecord && !leavedataforcalander1 && !
            rejoiningdate) {
            console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
            endDate = parseDate(lasttimesheetsubmiteddata.enddate);
            if (endDate) adjustEndDateForWeekend(endDate);
        } else if (lasttimesheetsubmiteddata && timesheetmaxDateRecord && !leavedataforcalander1) {
            console.log("Using timesheetmaxDateRecord date:", timesheetmaxDateRecord.date);
            endDate = parseDate(timesheetmaxDateRecord.date);
        } else if (newteammember && !lasttimesheetsubmiteddata) {
            //  } else if (newteammember) {

            //  console.log("Using newteammember data:", newteammember);
            //  endDate = timesheetmaxDateRecord ? parseDate(timesheetmaxDateRecord.date) : parseDate(
            //      newteammember);
            //  if (endDate) endDate.setDate(endDate.getDate() - 1);

            if (timesheetmaxDateRecord) {
                endDate = parseDate(timesheetmaxDateRecord.date)
            } else {
                console.log("Using newteammember data:", newteammember);
                endDate = parseDate(newteammember);
                endDate.setDate(endDate.getDate() - 1);
            }
        } else if (rejoiningdate) {
            console.log("Using rejoiningdate data:", rejoiningdate);
            endDate = parseDate(rejoiningdate);
            if (endDate) endDate.setDate(endDate.getDate() - 1);
        } else if (leavedataforcalander1 && lasttimesheetsubmiteddata) {
            if (differenceInDays === 2 || differenceInDays === 1) {
                endDate = parseDate(leavedataforcalander1);
                //  may be in future any bugs occure then, i have fixed bugs when after weakend leave applyed moltiple in that case
                //  if (leavebreakdateassign) {
                //      endDate = parseDate(leavebreakdateassign);
                //  } else {
                //      endDate = parseDate(leavedataforcalander1);
                //  }
            } else {
                console.log("Using lasttimesheetsubmiteddata.enddate:", lasttimesheetsubmiteddata.enddate);
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            }
        }

        // Set date in the datepicker if endDate is valid
        if (endDate) {
            let today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize today's date to remove time part
            endDate.setHours(0, 0, 0, 0); // Normalize endDate to remove time part

            // Increment endDate if it's not today's date  or  Increment endDate if enddate lesstahn today date and not increamner end date if enddate greater than today date
            //  if (endDate.getTime() !== today.getTime() && endDate.getTime() <= today.getTime()) {
            //      endDate.setDate(endDate.getDate() + 1);
            //  }

            //  if (endDate.getTime() <= today.getTime()) {
            if (endDate.getTime() < today.getTime()) {
                endDate.setDate(endDate.getDate() + 1);
            }


            let formattedDate = ('0' + endDate.getDate()).slice(-2) + '-' +
                ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                endDate.getFullYear();

            // Set the calculated date in the datepicker input field
            document.getElementById('datepickers').value = formattedDate;

            // Initialize the datepicker with the calculated maxDate
            $("#datepickers").datepicker({
                maxDate: endDate,
                minDate: endDate, // Set the same date for minDate if needed
                dateFormat: 'dd-mm-yy'
            });

            //  this code will be refresh data according end date
            if (endDate.getTime() !== today.getTime()) {
                let timesheetdate = formattedDate;
                var refreshpage = $('.refresh');
                refreshpage.val('').prop("readonly", false);
                $('.refreshoption option').remove();
                //   $("#hour1,#hour2,#hour3,#hour4,#hour5").prop("readonly", false);
                $("#hour1,#hour2,#hour3,#hour4,#hour5").val(0);

                //   alert(datepickers);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        timesheetdate: timesheetdate
                    },
                    success: function(res) {
                        $('#client').html(res);
                        $('#client1').html(res);
                        $('#client2').html(res);
                        $('#client3').html(res);
                        $('#client4').html(res);
                    },
                    error: function() {},
                });
            }
            //  this code will be refresh data according end date end hare 

            console.log("Adjusted date set in datepicker:", endDate);
        } else {
            console.log("No valid timesheet or submitted date data found to set datepicker.");
        }
    });
</script>
{{--  Start Hare  --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let endDate = null;

        function parseDate(date) {
            let parsedDate = new Date(date);
            return isNaN(parsedDate) ? null : parsedDate;
        }

        function adjustEndDateForWeekend(date) {
            if (!date) return;
            let day = date.getDay();
            if (day === 6) { // Saturday
                date.setDate(date.getDate() + 2); // Move to Monday
            } else if (day === 0) { // Sunday
                date.setDate(date.getDate() + 1); // Move to Monday
            }
        }

        if (timesheetmaxDateRecord && leavedataforcalander1) {
            let maxDate = parseDate(timesheetmaxDateRecord.date);
            let leaveDate = parseDate(leavedataforcalander1);

            if (differenceInDays > 1) {
                endDate = maxDate;
            } else {
                endDate = (maxDate && leaveDate && maxDate.getTime() > leaveDate.getTime()) ? maxDate :
                    leaveDate;
            }

            if (!endDate && lasttimesheetsubmiteddata) {
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
                if (endDate) adjustEndDateForWeekend(endDate);
            } else if (leavebreakdateassign) {
                let leavebreakdate = parseDate(leavebreakdateassign);
                let timesheetmaxDate = parseDate(timesheetmaxDateRecord.date);
                let incrementedTimesheetDate = new Date(timesheetmaxDate);

                incrementedTimesheetDate.setDate(incrementedTimesheetDate.getDate() + 1);
                let getDate = (leavebreakdate && leavebreakdate.getTime() > incrementedTimesheetDate
                        .getTime()) ?
                    timesheetmaxDate :
                    leavebreakdate;

                endDate = parseDate(getDate);
            }
        } else if (lasttimesheetsubmiteddata && !timesheetmaxDateRecord && !leavedataforcalander1 && !
            rejoiningdate) {
            endDate = parseDate(lasttimesheetsubmiteddata.enddate);
            if (endDate) adjustEndDateForWeekend(endDate);
        } else if (rejoiningdate) {
            endDate = parseDate(rejoiningdate);
            if (endDate) endDate.setDate(endDate.getDate() - 1);
        } else if (newteammember && !lasttimesheetsubmiteddata) {
            endDate = timesheetmaxDateRecord ? parseDate(timesheetmaxDateRecord.date) : parseDate(
                newteammember);
            if (endDate) endDate.setDate(endDate.getDate() - 1);
        }

        if (endDate && !isNaN(endDate.getTime())) {
            let today = new Date();
            today.setHours(0, 0, 0, 0);
            endDate.setHours(0, 0, 0, 0);

            if (endDate.getTime() < today.getTime()) {
                endDate.setDate(endDate.getDate() + 1);
            }

            let formattedDate = ('0' + endDate.getDate()).slice(-2) + '-' +
                ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                endDate.getFullYear();

            document.getElementById('datepickers').value = formattedDate;

            $("#datepickers").datepicker({
                maxDate: endDate,
                minDate: endDate,
                dateFormat: 'dd-mm-yy'
            });

            if (endDate.getTime() !== today.getTime()) {
                let timesheetdate = formattedDate;
                $('.refresh').val('').prop("readonly", false);
                $('.refreshoption option').remove();
                $("#hour1,#hour2,#hour3,#hour4,#hour5").val(0);

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        timesheetdate: timesheetdate
                    },
                    success: function(res) {
                        $('#client, #client1, #client2, #client3, #client4').html(res);
                    }
                });
            }
            console.log("Adjusted date set in datepicker:", endDate);
        } else {
            console.log("No valid timesheet or submitted date data found to set datepicker.");
        }
    });
</script>
{{--  Start Hare  --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let endDate = null;

        // Convert Laravel data to usable JavaScript dates
        function parseDate(dateStr) {
            if (!dateStr) return null;
            let parsedDate = new Date(dateStr);
            return isNaN(parsedDate) ? null : parsedDate;
        }

        // Adjust endDate to avoid weekends (Saturday/Sunday)
        function adjustForWeekend(date) {
            if (!date) return;
            let day = date.getDay();
            if (day === 6) date.setDate(date.getDate() + 2); // Saturday → Monday
            else if (day === 0) date.setDate(date.getDate() + 1); // Sunday → Monday
        }

        // If endDate is in the past, move it to today
        function ensureFutureDate(date) {
            let today = new Date();
            today.setHours(0, 0, 0, 0);
            date.setHours(0, 0, 0, 0);
            if (date < today) date.setDate(today.getDate() + 1);
        }

        // Determine the correct `endDate` based on conditions
        function calculateEndDate() {
            if (timesheetmaxDateRecord && leavedataforcalander1) {
                console.log("Using timesheet and leave data.");
                let maxDate = parseDate(timesheetmaxDateRecord.date);
                let leaveDate = parseDate(leavedataforcalander1);
                if (differenceInDays > 1) {
                    endDate = maxDate;
                } else {
                    endDate = maxDate > leaveDate ? maxDate : leaveDate;
                }
            } else if (lasttimesheetsubmiteddata) {
                console.log("Using last submitted timesheet.");
                endDate = parseDate(lasttimesheetsubmiteddata.enddate);
            } else if (newteammember) {
                console.log("Using new team member joining date.");
                endDate = parseDate(newteammember);
                if (endDate) endDate.setDate(endDate.getDate() - 1);
            } else if (rejoiningdate) {
                console.log("Using rejoining date.");
                endDate = parseDate(rejoiningdate);
                if (endDate) endDate.setDate(endDate.getDate() - 1);
            }
        }

        // Set the date in the datepicker
        function setDatepicker(endDate) {
            if (!endDate) {
                console.error("No valid endDate found.");
                return;
            }

            ensureFutureDate(endDate);
            adjustForWeekend(endDate);

            let formattedDate =
                ('0' + endDate.getDate()).slice(-2) + '-' +
                ('0' + (endDate.getMonth() + 1)).slice(-2) + '-' +
                endDate.getFullYear();

            document.getElementById('datepickers').value = formattedDate;

            $("#datepickers").datepicker({
                maxDate: endDate,
                minDate: endDate,
                dateFormat: "dd-mm-yy"
            });

            // Fetch data if endDate is not today
            let today = new Date();
            today.setHours(0, 0, 0, 0);
            if (endDate.getTime() !== today.getTime()) {
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        timesheetdate: formattedDate
                    },
                    success: function(res) {
                        ['#client', '#client1', '#client2', '#client3', '#client4'].forEach(
                            selector => {
                                $(selector).html(res);
                            });
                    },
                    error: function() {
                        console.error("Failed to refresh data.");
                    }
                });
            }
        }

        // Execute functions
        calculateEndDate();
        setDatepicker(endDate);
    });
</script>
{{-- ! End hare --}}

{{-- * regarding  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "order": [],
            columnDefs: [{
                targets: [
                    0, 1, 2, 3
                    @if (Auth::user()->role_id == 13 || Auth::user()->role_id == 14 || $teamleader == Auth::user()->teammember_id)
                        @if ($assignmentbudgeting->status == 1)
                            , 5
                        @endif
                    @endif
                ],
                orderable: false
            }],
            buttons: []
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "order": [
                // [4, "desc"] // Set default order on the Date column (index 4)
            ],
            columnDefs: [{
                    targets: [0, 1, 2, 3, 5], // Disable ordering for specific columns
                    orderable: false
                },
                {
                    targets: 4, // Target the Date column
                    render: function(data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            return data; // Display the formatted date (d-m-Y h:i A)
                        }
                        if (type === 'sort') {
                            // Convert to sortable format (Y-m-d H:i:s)
                            const parts = data.split(' '); // Split date and time
                            const dateParts = parts[0].split('-'); // Split d-m-Y
                            const time = parts[1] + ' ' + parts[2]; // Add time with AM/PM
                            return `${dateParts[2]}-${dateParts[1]}-${dateParts[0]} ${time}`;
                        }
                        return data;
                    }
                }
            ],
            buttons: [] // Additional buttons if needed
        });
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding date validation  --}}
{{--  Start Hare  --}}

{{-- validation for block 4 digit to  year --}}
{{-- <script>
     $(document).ready(function() {
         $('#udindate').on('change', function() {
             alert('hi');
             var startclear = $(this);
             var startDateInput1 = startclear.val();
             var startDate = new Date(startDateInput1);
             var startyear = startDate.getFullYear();
             var yearLength = startyear.toString().length;
             if (yearLength > 4) {
                 alert('Enter four digits for the year');
                 startclear.val('');
             }
         });
     });
 </script> --}}
{{-- <script>
     $(document).ready(function() {
         $('#udindate').on('change', function() {
             //  alert('hi');
             const dateInput = $(this); // Input element
             const dateValue = dateInput.val(); // Date string
             const today = new Date(); // Today's date
             const selectedDate = new Date(dateValue); // Selected date

             // Validation: Check if the field is empty
             if (!dateValue) {
                 alert('Please select a date.');
                 dateInput.val('');
                 return;
             }

             // Validation: Ensure the year has exactly 4 digits
             const year = selectedDate.getFullYear();
             if (year.toString().length !== 4) {
                 alert('Enter a valid year with four digits.');
                 dateInput.val('');
                 return;
             }

             // Validation: Ensure the date is not in the future
             if (selectedDate > today) {
                 alert('Future dates are not allowed.');
                 dateInput.val('');
                 return;
             }

             // Validation: Ensure the date is valid
             if (isNaN(selectedDate.getTime())) {
                 alert('The selected date is invalid.');
                 dateInput.val('');
                 return;
             }

             // Optional Validation: Check if the date is within a custom range (e.g., last 10 years)
             const tenYearsAgo = new Date();
             tenYearsAgo.setFullYear(today.getFullYear() - 10);

             if (selectedDate < tenYearsAgo) {
                 alert('The date must be within the last 10 years.');
                 dateInput.val('');
                 return;
             }

             // If all validations pass
             alert('Date is valid!');
         });
     });
 </script> --}}

{{-- <script>
     $(document).ready(function() {
         $('#udindate').on('input', function(event) {
             event.preventDefault(); // Prevent form submission or refresh if used in a form
             const dateInput = $(this); // Input element
             const dateValue = dateInput.val(); // Date string
             const today = new Date(); // Today's date

             // Validation: Check if the field is empty
             if (!dateValue) {
                 alert('Please select a date.');
                 dateInput.val('');
                 return;
             }

             const selectedDate = new Date(dateValue); // Selected date

             // Validation: Ensure the date is valid
             if (isNaN(selectedDate.getTime())) {
                 alert('The selected date is invalid.');
                 dateInput.val('');
                 return;
             }

             // Validation: Ensure the year has exactly 4 digits
             const year = selectedDate.getFullYear();
             if (year.toString().length !== 4) {
                 return; // Wait for the user to finish typing the full year
             }

             // Validation: Ensure the date is not in the future
             if (selectedDate > today) {
                 alert('Future dates are not allowed.');
                 dateInput.val('');
                 return;
             }

             // Optional Validation: Check if the date is within a custom range (e.g., last 10 years)
             const tenYearsAgo = new Date();
             tenYearsAgo.setFullYear(today.getFullYear() - 10);

             if (selectedDate < tenYearsAgo) {
                 alert('The date must be within the last 10 years.');
                 dateInput.val('');
                 return;
             }

             // If all validations pass
             console.log('Date is valid:', dateValue);
         });
     });
 </script> --}}

{{-- <script>
     $(document).ready(function() {
         $('#udindate').on('input', function(event) {
             event.preventDefault(); // Prevent any default behavior
             const dateInput = $(this); // Input element
             const dateValue = dateInput.val(); // Date string
             const today = new Date(); // Today's date

             // Validation: Check if the field is empty
             if (!dateValue) {
                 alert('Please select a date.');
                 dateInput.val('');
                 return;
             }

             // Validation: Ensure the input matches the format YYYY-MM-DD
             const dateRegex = /^\d{4}-\d{2}-\d{2}$/; // Regular expression for YYYY-MM-DD format
             if (!dateRegex.test(dateValue)) {
                 alert('Enter a valid date in the format YYYY-MM-DD.');
                 dateInput.val('');
                 return;
             }

             const selectedDate = new Date(dateValue); // Parse the selected date

             // Validation: Ensure the date is valid
             if (isNaN(selectedDate.getTime())) {
                 alert('The selected date is invalid.');
                 dateInput.val('');
                 return;
             }

             // Validation: Ensure the date is not in the future
             if (selectedDate > today) {
                 alert('Future dates are not allowed.');
                 dateInput.val('');
                 return;
             }

             // Optional Validation: Check if the date is within a custom range (e.g., last 10 years)
             const tenYearsAgo = new Date();
             tenYearsAgo.setFullYear(today.getFullYear() - 10);

             if (selectedDate < tenYearsAgo) {
                 alert('The date must be within the last 10 years.');
                 dateInput.val('');
                 return;
             }

             // If all validations pass
             console.log('Date is valid:', dateValue);
         });
     });
 </script> --}}


<script>
    $(document).ready(function() {
        $('#datevalid').on('change', function() {
            var startclear = $('#datevalid');
            var startDateInput1 = $('#datevalid').val();
            var startDate = new Date(startDateInput1);
            var startyear = startDate.getFullYear();
            var yearLength = startyear.toString().length;
            if (yearLength > 4) {
                alert('Enter four digits for the year');
                startclear.val('');
            }
        });
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}

{{-- * regarding date  --}}
{{--  Start Hare  --}}
<script>
    $("#datepickers").datepicker({
        maxDate: endDate, // Maximum date allowed
        minDate: null, // Minimum date allowed (null means no restriction)
        dateFormat: 'dd-mm-yy', // Date format
        onSelect: function(dateText) {
            console.log("Selected date: " + dateText);
        }
    });

    // Start Date Picker
    $("#startDate").datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function(selectedDate) {
            var startDate = $(this).datepicker('getDate');
            var maxDate = new Date(startDate);
            maxDate.setDate(maxDate.getDate() + 7); // 7 din ka range
            $("#endDate").datepicker("option", "minDate", startDate);
            $("#endDate").datepicker("option", "maxDate", maxDate);
        }
    });

    // End Date Picker
    $("#endDate").datepicker({
        dateFormat: 'dd-mm-yy',
        onSelect: function(dateText) {
            console.log("End date selected: " + dateText);
        }
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- *regarding date --}}
{{--  Start Hare  --}}
@if (Request::is('assignmentmapping/create'))
    <script>
        $(document).ready(function() {
            //     alert('hi');
            $("#EndDate").change(function() {
                var startDate = document.getElementById("StartDate").value;
                var endDate = document.getElementById("EndDate").value;
                //alert(startDate);

                if ((Date.parse(startDate) >= Date.parse(endDate))) {
                    alert("End date should be greater than Start date");
                    document.getElementById("EndDate").value = "";
                }

            });
        });
    </script>
@endif
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * regarding week in javascript  --}}
{{--  Start Hare  --}}
{{-- 
 Sunday=0
 Monday=1
 Tuesday=2
 Wednesday=3
 Thursday=4
 Friday=5
 Saturday=6
 --}}
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- *  --}}
{{--  Start Hare  --}}
@php
    $user = DB::table('users')->latest()->first();
@endphp

<script>
    // Safely encode PHP data to JSON for use in JavaScript
    var user = @json($user);
    console.log("users data:", user);
</script>
{{--  Start Hare  --}}
<script>
    $(function() {
        $('#datepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });
    //  $(function() {
    //      $("#datepickers").datepicker({
    //          maxDate: new Date,
    //          dateFormat: 'dd-mm-yy'
    //      });
    //  });
    //  console.log("Client datea:", lasttimesheetsubmiteddata);
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lasttimesheetsubmiteddata !== 'undefined' && lasttimesheetsubmiteddata) {
            console.log("End date:", lasttimesheetsubmiteddata.enddate);

            // Parse enddate from latestTimesheetSubmitted to a valid Date object
            var endDate = new Date(lasttimesheetsubmiteddata.enddate);

            if (!isNaN(endDate)) { // Ensure the date is valid
                $("#datepickers").datepicker({
                    maxDate: endDate, // Use the parsed Date object
                    minDate: endDate, // Set the same date for minDate if needed
                    dateFormat: 'dd-mm-yy'
                });
            } else {
                console.error("Invalid date format for enddate:", latestTimesheetSubmitted.enddate);
            }
        } else {
            console.log("No latest timesheet data found.");
        }
    });
</script>
{{--  Start Hare  --}}
@if (Request::is('invoice/create') || Request::is('invoice/*/edit'))
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(function() {
            $('#datepicker').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
        $(function() {
            $("#datepickers").datepicker({
                maxDate: new Date,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof latestTimesheetSubmitted !== 'undefined' && latestTimesheetSubmitted) {
            console.log("End date:", latestTimesheetSubmitted.enddate);

            // Parse enddate from latestTimesheetSubmitted to a valid Date object
            var endDate = new Date(latestTimesheetSubmitted.enddate);

            if (!isNaN(endDate)) { // Ensure the date is valid
                $("#datepickers").datepicker({
                    maxDate: endDate, // Use the parsed Date object
                    minDate: endDate, // Set the same date for minDate if needed
                    dateFormat: 'dd-mm-yy'
                });
            } else {
                console.error("Invalid date format for enddate:", latestTimesheetSubmitted.enddate);
            }
        } else {
            console.log("No latest timesheet data found.");
        }
    });
</script> --}}

    <script>
        // Pass the PHP data to JavaScript
        var latestTimesheetSubmitted = @json($latesttimesheetsubmitted);

        console.log("Latest Timesheet Submitted:", latestTimesheetSubmitted);
    </script>
    936
    775 dev khurana
    {{-- @include('backEnd.layouts.includes.js') --}}
    {{-- @include('backEnd.layouts.includes.jstest') --}}

    $latesttimesheetsubmitted = DB::table('timesheetreport')
    ->where('teamid', auth()->user()->teammember_id)
    ->latest()
    ->first();

    return view('backEnd.timesheet.create', compact('client', 'teammember', 'assignment', 'partner',
    'timesheetrejectData', 'latesttimesheetsubmitted'));

    @php
        $latesttimesheetsubmittedq = DB::table('timesheetreport')
            ->where('teamid', auth()->user()->teammember_id)
            ->latest()
            ->first();
    @endphp
    <script>
        // Pass the PHP data to JavaScript
        var latestTimesheetSubmittedq = @json($latesttimesheetsubmittedq);

        console.log("Latest Timesheet Submitted:", latesttimesheetsubmittedq);
    </script>
@endif





@if (Request::is('invoice/create') || Request::is('invoice/*/edit') || Request::is('timesheet/create'))
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(function() {
            $('#datepicker').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
        //  $(function() {
        //      $("#datepickers").datepicker({
        //          maxDate: new Date,
        //          dateFormat: 'dd-mm-yy'
        //      });
        //  });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof latestTimesheetSubmittedq !== 'undefined' && latestTimesheetSubmittedq) {
                console.log("End date:", latestTimesheetSubmittedq.enddate);

                // Parse enddate from latestTimesheetSubmitted to a valid Date object
                var endDate = new Date(latestTimesheetSubmittedq.enddate);

                if (!isNaN(endDate)) { // Ensure the date is valid
                    $("#datepickers").datepicker({
                        maxDate: endDate, // Use the parsed Date object
                        minDate: endDate, // Set the same date for minDate if needed
                        dateFormat: 'dd-mm-yy'
                    });
                } else {
                    console.error("Invalid date format for enddate:", latestTimesheetSubmittedq.enddate);
                }
            } else {
                console.log("No latest timesheet data found.");
            }
        });
    </script>
@endif

{{-- ! End hare --}}
{{-- * regarding summernote --}}
{{--  Start Hare  --}}
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Announcement Content *</label>
            <textarea rows="4" name="mail_content" class="centered form-control" id="summernote"
                placeholder="Enter Description" id="editors" style="height:500px;"></textarea>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 100, // Sets the editor height to 100px
        });
        // Add required validation
        $('form').on('submit', function(e) {
            // Check if Summernote content is empty
            var summernoteContent = $('#summernote').summernote('isEmpty');
            if (summernoteContent) {
                alert('Announcement Content is required.');
                e.preventDefault(); // Prevent form submission
                return false;
            }
        });
    });
</script>
{{--  Start Hare  --}}

<script>
    $(document).ready(function() {
        $('#exampleFormControlSelect111').on('change', function() {
            if (this.value == '1') {
                $("#designation").show();
                document.getElementById("designationinput").required = true;
            } else {
                $("#designation").hide();
                document.getElementById("designationinput").required = false;
            }
        });
    });
</script>
{{-- ! End hare --}}
{{-- * regarding disable / regarding checkbox --}}
{{--  Start Hare  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $('#enablebox').on('change', function() {
            $('.enablefalse').prop('disabled', this.checked);
            if (this.checked) {
                $('.add_buttonn, .remove_button, .hidedive').addClass('d-none');
            } else {
                $('.add_buttonn, .remove_button, .hidedive').removeClass('d-none');
            }
        });
    });
</script>
{{-- ! End hare --}}
{{-- *  --}}
{{--  Start Hare  --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "order": [
                [3, "desc"]
            ],
            //   searching: false,
            columnDefs: [{

                @if (Auth::user()->role_id == 11)
                    targets: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                @else
                    targets: [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15],
                @endif
                orderable: false
            }],
            buttons: []
        });
    });
</script>

{{-- filter on weekly list --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
    $(document).ready(function() {
        //   all partner
        $('#filter1').change(function() {
            var search1 = $(this).val();
            var search2 = $('#filter2').val();
            // console.log(search1);

            var urlParams = new URLSearchParams(window.location.search);
            // Access values from the URL
            var id = urlParams.get('id');
            var teamid = urlParams.get('teamid');
            var partnerid = urlParams.get('partnerid');
            var startdate = urlParams.get('startdate');
            var enddate = urlParams.get('enddate');



            $.ajax({
                type: 'GET',
                url: '/filter-weeklist',
                data: {
                    clientname: search1,
                    assignmentname: search2,
                    id: id,
                    teamid: teamid,
                    partnerid: partnerid
                },
                success: function(data) {
                    // Clear the table body
                    $('table tbody').html("");

                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {
                            var dayOfWeek = moment(item.date).format('dddd');
                            var formattedDate = moment(item.date).format(
                                'DD-MM-YYYY');
                            var statusBadge = item.status == 0 ?
                                '<span class="badge badge-pill badge-warning">saved</span>' :
                                '<span class="badge badge-pill badge-danger">submit</span>';
                            // Add the rows to the table


                            $('table tbody').append('<tr>' +
                                '<td>' + item.team_member + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + dayOfWeek + '</td>' +
                                '<td>' + item.client_name + '</td>' +
                                '<td>' + item.assignment_name + '</td>' +
                                '<td>' + item.workitem + '</td>' +
                                '<td>' + item.location + '</td>' +
                                '<td>' + item.partnername_name + '</td>' +
                                '<td>' + item.hour + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                // Add more columns here
                                '</tr>');
                        });

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });



        //** start date
        $('#filter2').change(function() {
            var search2 = $(this).val();
            var search1 = $('#filter1').val();
            console.log(search2);
            var urlParams = new URLSearchParams(window.location.search);
            // Access values from the URL
            var id = urlParams.get('id');
            var teamid = urlParams.get('teamid');
            var partnerid = urlParams.get('partnerid');
            var startdate = urlParams.get('startdate');
            var enddate = urlParams.get('enddate');
            $.ajax({
                type: 'GET',
                url: '/filter-weeklist',
                data: {
                    assignmentname: search2,
                    clientname: search1,
                    id: id,
                    teamid: teamid,
                    partnerid: partnerid
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html(""); // Clear the table body

                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {
                            var dayOfWeek = moment(item.date).format('dddd');
                            var formattedDate = moment(item.date).format(
                                'DD-MM-YYYY');
                            var statusBadge = item.status == 0 ?
                                '<span class="badge badge-pill badge-warning">saved</span>' :
                                '<span class="badge badge-pill badge-danger">submit</span>';
                            // Add the rows to the table


                            $('table tbody').append('<tr>' +
                                '<td>' + item.team_member + '</td>' +
                                '<td>' + formattedDate + '</td>' +
                                '<td>' + dayOfWeek + '</td>' +
                                '<td>' + item.client_name + '</td>' +
                                '<td>' + item.assignment_name + '</td>' +
                                '<td>' + item.workitem + '</td>' +
                                '<td>' + item.location + '</td>' +
                                '<td>' + item.partnername_name + '</td>' +
                                '<td>' + item.hour + '</td>' +
                                '<td>' + statusBadge + '</td>' +
                                // Add more columns here
                                '</tr>');
                        });
                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });
        //shahid
    });
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- *  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            // 'l' for the length menu
            dom: 'lBfrtip',
            columnDefs: [{
                targets: [1, 2, 3, 4, 5],
                orderable: false
            }],
            buttons: [{
                    extend: 'excelHtml5',
                    filename: 'Assignment Viewer List',
                    exportOptions: {
                        columns: ':visible'
                    },
                    //   remove extra spaces
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
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- *  --}}
{{--  Start Hare  --}}

<script>
    $(document).ready(function() {
        // Function to handle change event for client select

        // function handleClientChange(clientId) {
        //     $('#' + clientId).on('change', function() {
        //         var cid = $(this).val();
        //         var datepickers = $('#datepickers').val();
        //         var clientNumber = parseInt(clientId.replace('client', ''));

        //         if (cid == 33) {
        //             $.ajax({
        //                 type: "get",
        //                 url: "{{ url('holidaysselect') }}",
        //                 data: {
        //                     cid: cid,
        //                     datepickers: datepickers
        //                 },
        //                 success: function(response) {
        //                     $('.row.row-sm.showdiv').addClass('d-none');
        //                     var location = 'N/A';
        //                     var time = 0;
        //                     var holidayName = response.holidayName;
        //                     var saturday = response.saturday;
        //                     if (holidayName == 'null') {
        //                         var workitem = saturday;
        //                     } else if (saturday == 'null') {
        //                         var workitem = holidayName;
        //                     } else {
        //                         var workitem = holidayName;
        //                     }

        //                     if (!isNaN(clientNumber)) {
        //                         var assignmentSelect = $('.assignmentvalue' + clientNumber);
        //                         assignmentSelect.empty();
        //                         assignmentSelect.append($('<option>', {
        //                             value: response.assignmentgenerate_id,
        //                             text: response.assignment_name + ' (' +
        //                                 response
        //                                 .assignmentname + '/' + response
        //                                 .assignmentgenerate_id + ')'
        //                         }));

        //                         var assignmentSelect = $('.partnervalue' + clientNumber);
        //                         assignmentSelect.empty();
        //                         assignmentSelect.append($('<option>', {
        //                             value: response.team_memberid,
        //                             text: response.team_member
        //                         }));

        //                         $('.workitemnvalue' + clientNumber).val(workitem).prop(
        //                             'readonly', true);
        //                         $('.locationvalue' + clientNumber).val(location).prop(
        //                             'readonly', true);
        //                         $('#totalhours').val(time);
        //                         $('#hour' + (clientNumber + 1)).prop('readonly', true);
        //                     } else {

        //                         var assignmentSelect = $('.assignmentvalue');
        //                         assignmentSelect.empty();
        //                         assignmentSelect.append($('<option>', {
        //                             value: response.assignmentgenerate_id,
        //                             text: response.assignment_name + ' (' +
        //                                 response
        //                                 .assignmentname + '/' + response
        //                                 .assignmentgenerate_id + ')'
        //                         }));

        //                         var assignmentSelect = $('.partnervalue');
        //                         assignmentSelect.empty();
        //                         assignmentSelect.append($('<option>', {
        //                             value: response.team_memberid,
        //                             text: response.team_member
        //                         }));


        //                         $('.workitemnvalue').val(workitem).prop('readonly', true);
        //                         $('.locationvalue').val(location).prop('readonly', true);
        //                         $('#totalhours').val(time);
        //                         $("#hour1").prop("readonly", true);
        //                     }

        //                 },
        //                 error: function() {
        //                     // Handle error if AJAX request fails
        //                 }
        //             });
        //         } else {
        //             $.ajax({
        //                 type: "get",
        //                 url: "{{ url('timesheet/create') }}",
        //                 data: {
        //                     cid: cid,
        //                     datepickers: datepickers
        //                 },
        //                 success: function(res) {
        //                     $('.row.row-sm.d-none').removeClass('d-none');
        //                     // clear previous data 
        //                     if (!isNaN(clientNumber)) {
        //                         $('.assignmentvalue' + clientNumber).empty();
        //                         $('.partnervalue' + clientNumber).empty();
        //                         $('.workitemnvalue' + clientNumber).val('').prop('readonly',
        //                             false);
        //                         $('.locationvalue' + clientNumber).val('').prop('readonly',
        //                             false);
        //                         $("#hour" + (clientNumber + 1)).prop("readonly", false);

        //                     } else {
        //                         $('.assignmentvalue').empty();
        //                         $('.partnervalue').empty();
        //                         $('.workitemnvalue').val('').prop('readonly', false);
        //                         $('.locationvalue').val('').prop('readonly', false);
        //                         $("#hour1").prop("readonly", false);
        //                     }

        //                     $('#' + clientId.replace('client', 'assignment')).html(res);

        //                 },
        //                 error: function() {
        //                     // Handle error if AJAX request fails
        //                 },
        //             });
        //         }
        //     });
        // }


        //   function handleClientChange(clientId) {
        //       $('#' + clientId).on('change', function() {
        //           var cid = $(this).val();
        //           var datepickers = $('#datepickers').val();
        //           var clientNumber = parseInt(clientId.replace('client', ''));

        //           if (cid == 33) {
        //               $.ajax({
        //                   type: "get",
        //                   url: "{{ url('holidaysselect') }}",
        //                   data: {
        //                       cid: cid,
        //                       datepickers: datepickers
        //                   },
        //                   success: function(response) {

        //                       $('.row.row-sm.showdiv').addClass('d-none').find(
        //                           'input,textarea, select').val('').prop(
        //                           'readonly', false);

        //                       var location = 'N/A';
        //                       var time = 0;
        //                       var holidayName = response.holidayName;
        //                       var saturday = response.saturday;
        //                       if (holidayName == 'null') {
        //                           var workitem = saturday;
        //                       } else if (saturday == 'null') {
        //                           var workitem = holidayName;
        //                       } else {
        //                           var workitem = holidayName;
        //                       }

        //                       if (!isNaN(clientNumber)) {
        //                           var assignmentSelect = $('.assignmentvalue' + clientNumber);
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.assignmentgenerate_id,
        //                               text: response.assignment_name + ' (' +
        //                                   response
        //                                   .assignmentname + '/' + response
        //                                   .assignmentgenerate_id + ')'
        //                           }));

        //                           var assignmentSelect = $('.partnervalue' + clientNumber);
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.team_memberid,
        //                               text: response.team_member
        //                           }));

        //                           $('.workitemnvalue' + clientNumber).val(workitem).prop(
        //                               'readonly', true);
        //                           $('.locationvalue' + clientNumber).val(location).prop(
        //                               'readonly', true);
        //                           $('#totalhours').val(time);
        //                           $('#hour' + (clientNumber + 1)).prop('readonly', true);
        //                       } else {

        //                           var assignmentSelect = $('.assignmentvalue');
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.assignmentgenerate_id,
        //                               text: response.assignment_name + ' (' +
        //                                   response
        //                                   .assignmentname + '/' + response
        //                                   .assignmentgenerate_id + ')'
        //                           }));

        //                           var assignmentSelect = $('.partnervalue');
        //                           assignmentSelect.empty();
        //                           assignmentSelect.append($('<option>', {
        //                               value: response.team_memberid,
        //                               text: response.team_member
        //                           }));


        //                           $('.workitemnvalue').val(workitem).prop('readonly', true);
        //                           $('.locationvalue').val(location).prop('readonly', true);
        //                           $('#totalhours').val(time);
        //                           $("#hour1").prop("readonly", true);
        //                       }

        //                   },
        //                   error: function() {
        //                       // Handle error if AJAX request fails
        //                   }
        //               });
        //           } else {
        //               $.ajax({
        //                   type: "get",
        //                   url: "{{ url('timesheet/create') }}",
        //                   data: {
        //                       cid: cid,
        //                       datepickers: datepickers
        //                   },
        //                   success: function(res) {
        //                       $('.row.row-sm.d-none').removeClass('d-none');
        //                       // clear previous data 
        //                       if (!isNaN(clientNumber)) {
        //                           $('.assignmentvalue' + clientNumber).empty();
        //                           $('.partnervalue' + clientNumber).empty();
        //                           $('.workitemnvalue' + clientNumber).val('').prop('readonly',
        //                               false);
        //                           $('.locationvalue' + clientNumber).val('').prop('readonly',
        //                               false);
        //                           $("#hour" + (clientNumber + 1)).prop("readonly", false);

        //                       } else {
        //                           $('.assignmentvalue').empty();
        //                           $('.partnervalue').empty();
        //                           $('.workitemnvalue').val('').prop('readonly', false);
        //                           $('.locationvalue').val('').prop('readonly', false);
        //                           $("#hour1").prop("readonly", false);
        //                       }

        //                       $('#' + clientId.replace('client', 'assignment')).html(res);

        //                   },
        //                   error: function() {
        //                       // Handle error if AJAX request fails
        //                   },
        //               });
        //           }
        //       });
        //   }


        function handleClientChange(clientId) {
            $('#' + clientId).on('change', function() {
                var cid = $(this).val();
                var datepickers = $('#datepickers').val();
                var clientNumber = parseInt(clientId.replace('client', ''));

                if (cid == 33) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('holidaysselect') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(response) {
                            // Hide div and clear all form fields
                            $('.row.row-sm.showdiv').addClass('d-none').find(
                                'input, textarea, select').val('').prop('readonly',
                                false);

                            var location = 'N/A';
                            var time = 0;
                            var holidayName = response.holidayName;
                            var saturday = response.saturday;
                            var workitem = holidayName === 'null' ? saturday : holidayName;

                            if (!isNaN(clientNumber)) {
                                var assignmentSelect = $('.assignmentvalue' + clientNumber);
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.assignmentgenerate_id,
                                    text: response.assignment_name + ' (' +
                                        response.assignmentname + '/' + response
                                        .assignmentgenerate_id + ')'
                                }));

                                var partnerSelect = $('.partnervalue' + clientNumber);
                                partnerSelect.empty();
                                partnerSelect.append($('<option>', {
                                    value: response.team_memberid,
                                    text: response.team_member
                                }));

                                $('.workitemnvalue' + clientNumber).val(workitem).prop(
                                    'readonly', true);
                                $('.locationvalue' + clientNumber).val(location).prop(
                                    'readonly', true);
                                $('#totalhours').val(time);
                                $('#hour' + (clientNumber + 1)).prop('readonly', true);
                            } else {
                                var assignmentSelect = $('.assignmentvalue');
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.assignmentgenerate_id,
                                    text: response.assignment_name + ' (' +
                                        response.assignmentname + '/' + response
                                        .assignmentgenerate_id + ')'
                                }));

                                var partnerSelect = $('.partnervalue');
                                partnerSelect.empty();
                                partnerSelect.append($('<option>', {
                                    value: response.team_memberid,
                                    text: response.team_member
                                }));

                                $('.workitemnvalue').val(workitem).prop('readonly', true);
                                $('.locationvalue').val(location).prop('readonly', true);
                                $('#totalhours').val(time);
                                $("#hour1").prop('readonly', true);
                            }
                        },
                        error: function() {
                            // Handle error if AJAX request fails
                        }
                    });
                } else {
                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(res) {
                            // Show div and clear all form fields
                            $('.row.row-sm.d-none').removeClass('d-none').find(
                                'input, textarea, select').val('').prop('readonly',
                                false);

                            if (!isNaN(clientNumber)) {
                                $('.assignmentvalue' + clientNumber).empty();
                                $('.partnervalue' + clientNumber).empty();
                                $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                                    false);
                                $('.locationvalue' + clientNumber).val('').prop('readonly',
                                    false);
                                $("#hour" + (clientNumber + 1)).prop('readonly', false);
                            } else {
                                $('.assignmentvalue').empty();
                                $('.partnervalue').empty();
                                $('.workitemnvalue').val('').prop('readonly', false);
                                $('.locationvalue').val('').prop('readonly', false);
                                $("#hour1").prop('readonly', false);
                            }

                            $('#' + clientId.replace('client', 'assignment')).html(res);
                        },
                        error: function() {
                            // Handle error if AJAX request fails
                        }
                    });
                }
            });
        }




        // Function to handle change event for assignment select
        function handleAssignmentChange(assignmentId) {
            $('#' + assignmentId).on('change', function() {
                var assignment = $(this).val();

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: "assignment=" + assignment,
                    success: function(res) {
                        $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                    },
                    error: function() {},
                });
            });
        }

        // Dynamically add client fields
        var maxField = 4;
        var addButton = $('.add_button');
        var wrapper = $('.field_wrapper');
        var x = 1;
        var h = 2;

        $(addButton).click(function() {
            if (x < maxField) {
                x++;
                h++;
                var fieldHTML = `<div class="row row-sm">
          <div class="col-2">
              <div class="form-group">
                  <label class="font-weight-600">Client Name</label>
                  <select class="language form-control refresh" name="client_id[]" id="client${x}">
                      <option value="">Select Client</option>
                      @foreach ($client as $clientData)
                          <option value="{{ $clientData->id }}">
                              {{ $clientData->client_name }} ({{ $clientData->client_code }})
                          </option>
                      @endforeach
                  </select>
              </div>
          </div>
          <div class="col-2">
              <div class="form-group">
                  <label class="font-weight-600">Assignment Name</label>
                  <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                  </select>
              </div>
          </div>
          <div class="col-2">
              <div class="form-group">
                  <label class="font-weight-600">Partner</label>
                  <select class="language form-control refreshoption" id="partner${x}" name="partner[]">
                  </select>
              </div>
          </div>
          <div class="col-2">
              <div class="form-group">
                  <label class="font-weight-600" style="width:100px;">Work Item</label>
                  <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh workitemnvalue${x}" rows="2"></textarea>
              </div>
          </div>
          <div class="col-2">
              <div class="form-group">
                  <label class="font-weight-600" style="width:100px;">Location</label>
                  <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh locationvalue${x}">
              </div>
          </div>
          <div class="col-1">
              <div class="form-group">
                  <label class="font-weight-600">Hour</label>
                  <input type="text" class="form-control refresh" id="hour${h}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                  <span style="font-size: 10px;margin-left: 10px;"></span>
              </div>
          </div>
          <div class="col-1">
              <div class="form-group" style="margin-top: 36px;">
                  <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
              </div>
          </div>
      </div>`;

                $(wrapper).append(fieldHTML);

                var clientId = 'client' + x;
                var assignmentId = 'assignment' + x;

                handleClientChange(clientId);
                handleAssignmentChange(assignmentId);
            }
        });

        handleClientChange('client');
        handleClientChange('client1');
        handleAssignmentChange('assignment');
        handleAssignmentChange('assignment1');

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).closest('.row-sm').remove();
            x--;
        });
    });

    function calculateTotal() {
        var totalSum = 0;
        $('input[name^="hour"]').each(function() {
            totalSum += parseInt($(this).val()) || 0;
        });

        document.getElementById("totalhours").value = totalSum;
    }
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- *  --}}

{{--  Start Hare  --}}
<script>
    if (valueofIdattribute == 'client' || valueofIdattribute == 'client1') {
        $('.row.row-sm.showdiv').addClass('d-none').find(
            'input,textarea').val('').prop(
            'readonly', false);
        $('#assignment1, #partner1').empty();
        //   $('#client1').val('');
        //   $('#client1').val('Select Client');
        // Select the "Select Client" option by text
        $('#client1 option').filter(function() {
            return $(this).text() ===
                'Select Client'; // Find the option with the text 'Select Client'
        }).prop('selected', true); // Set it as selected
    }
</script>
{{--  Start Hare  --}}

<script>
    $('.row.row-sm.showdiv').removeClass('d-none').find('input, textarea').val('').prop('readonly', false);

    // Clear only the select boxes with specific IDs
    $('#assignment1, #partner1').empty().prop('readonly', false);

    // Set the default option for the client dropdown
    $('#client1').html('<option value="">Select Client</option>').val('');
    $('.row.row-sm.showdiv').addClass('d-none').find('input, select').val('').prop(
        'readonly', false);


    $('.row.row-sm.d-none').removeClass('d-none').find('input, select,textarea').val('').prop(
        'readonly', false);

    $('.row.row-sm.d-none').removeClass('d-none');
    $('.row.row-sm.showdiv').addClass('d-none');
    var valueofIdattribute = $(this).attr('id');

    var valueofIdattribute = $(this).attr('id');

    if (valueofIdattribute == 'client' || valueofIdattribute == 'client1') {
        $('.row.row-sm.showdiv').addClass('d-none').find(
            'input,textarea').val('').prop(
            'readonly', false);
        $('#assignment1, #partner1').empty();
        //   $('#client1').val('');
        $('#client1').val('Select Client');
    }

    //   if (valueofIdattribute == 'client' || valueofIdattribute == 'client1') {
    //       //   $('.row.row-sm.d-none').removeClass('d-none');
    //       $('.row.row-sm.showdiv').removeClass('d-none').find(
    //           'input,textarea').val('').prop(
    //           'readonly', false);
    //       $('#assignment1, #partner1').empty();
    //       //   $('#client1').val('');
    //   }
</script>
{{--  Start Hare  --}}
{{-- ! End hare --}}
{{-- * dynamic target  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        const nonOrderableColumns = [2, 3, 4, 5, 6, 7, 8, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20,
            21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35,
            36, 37, 38, 39, 40, 41, 42
        ];

        const exportColumns = [0, ':visible'];

        $('#examplee').DataTable({
            pageLength: 100,
            dom: 'Bfrtip',
            order: [
                [0, 'desc']
            ],
            columnDefs: [{
                targets: nonOrderableColumns,
                orderable: false
            }],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: exportColumns
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{--  Start Hare  --}}

<script>
    $(document).ready(function() {
        const exportColumns = [0, ':visible'];
        const nonOrderableColumns = Array.from({
            length: 41
        }, (_, i) => i + 2);

        $('#examplee').DataTable({
            pageLength: 100,
            dom: 'Bfrtip',
            order: [
                [0, "desc"]
            ],
            columnDefs: [{
                targets: nonOrderableColumns,
                orderable: false
            }],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: exportColumns
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{--  Start Hare  --}}
{{-- * regarding fresh datatable  --}}
{{--  Start Hare  --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{--  Start Hare  --}}
{{-- * regarding model box validation --}}
{{--  Start Hare  --}}

{{-- ###################################################################################################### --}}
{{-- shahid script start hare  --}}

<script>
    $(document).ready(function() {
        $('#exampleModal12').on('hidden.bs.modal', function() {
            $('#detailsFormudin')[0].reset();
        });
        $('#exampleModal120').on('hidden.bs.modal', function() {
            var formElement = $(this).find('form')[0];
            if (formElement) {
                formElement.reset();
            }
            // Reset Select2 dropdowns
            $(this).find('select').val(null).trigger('change');
            $(this).find('input[type="hidden"]').val('');
            console.log('Form Reset Done');
        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#exampleModal12').on('hidden.bs.modal', function() {
            $('#detailsFormudin')[0].reset();
        });
        $('#exampleModal120').on('hidden.bs.modal', function() {
            var formElement1 = $(this).find('form');
            var formElement = $(this).find('form')[0];
            console.log('Form Element:', formElement1);
            console.log('Form Element:', formElement);
            $(this).find('form')[0].reset();
        });
        $('#exampleModal120').on('hidden.bs.modal', function() {
            setTimeout(() => {
                var formElement = $(this).find('form')[0];
                if (formElement) {
                    formElement.reset();
                }

                // Reset Select2 dropdowns
                $(this).find('select').val(null).trigger('change');

                // Reset hidden fields
                $(this).find('input[type="hidden"]').val('');

                console.log('Form Reset Done');
            }, 200);
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#exampleModal12').on('hidden.bs.modal', function() {
            $('#detailsFormudin')[0].reset();
        });
        $('#exampleModal120').on('hidden.bs.modal', function() {
            var formElement = $(this).find('form')[0];
            if (formElement) {
                formElement.reset();
            }
            // Reset Select2 dropdowns
            $(this).find('select').val(null).trigger('change');
            $(this).find('input[type="hidden"]').val('');
            console.log('Form Reset Done');
        });

    });
</script>
{{-- shahid script start hare  --}}
<script>
    $(document).ready(function() {
        $('.saveform').each(function() {
            $(this).click(function(event) {
                //  return button tag
                //  console.log(this);
                // Get the index from the button's ID
                //  return value of id ;
                //  var index = $(this).attr('id');

                //  ['saveform', '45']
                //  var index = $(this).attr('id').split('-');

                // Get the index from the button's ID
                var index = $(this).attr('id').split('-')[
                    1];
                // Use the dynamic ID
                var reasonInputVal = $('#reasoninput-' + index).val()
                    .trim();

                if (reasonInputVal === "") {
                    alert('Please enter a reason.');
                    event.preventDefault();
                    return false;
                }

                // Confirmation prompt
                var confirmSubmit = confirm('Are you sure you want to submit?');
                if (!confirmSubmit) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#timesheetrequest').click(function(event) {
            var reasoninputvalve = $('#timesheetrequestinput').val().trim();

            if (reasoninputvalve === "") {
                alert('Please enter a reason.');
                event.preventDefault();
                return false;
            }

            // return true and false in confirmSubmit vairable 
            var confirmSubmit = confirm('Are you sure you want to submit ?');
            if (!confirmSubmit) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#exampleModal12').on('hidden.bs.modal', function() {
            //  var formElement1 = $(this).find('form');
            //  var formElement = $(this).find('form')[0];
            //  console.log('Form Element:', formElement);
            //  console.log('Form Element:', formElement1);
            $(this).find('form')[0].reset();
        });
    });
</script>

{{-- <script>
   $(document).ready(function() {
       $('#exampleModal12').on('hidden.bs.modal', function() {
           console.log('Modal is closing'); // Check if the event is triggered
           var formElement = $(this).find('form');
           console.log('Form Element:', formElement); // Log the form element

           if (formElement.length > 0) {
               console.log('Form found, resetting now...');
               formElement[0].reset(); // Reset the form
           } else {
               console.log('Form not found');
           }
       });
   });
</script> --}}


{{--  Start Hare  --}}
{{-- * regarding split function / regarding split() --}}
{{--  Start Hare --}}
Scenario:
You have an id attribute value like "saveform-44".

Breakdown of split('-'):
$(this).attr('id'):

This gets the id attribute of the current element, so in this case, it returns the string "saveform-44".
.split('-'):

The split('-') method takes the string "saveform-44" and splits it into an array based on the hyphen (-) delimiter.
The result of this operation is ["saveform", "44"]. This is an array with two elements:
Index 0: "saveform"
Index 1: "44"
[1]:

The [1] accesses the second element of the array, which is "44".
Summary:
split('-')[0] would give you "saveform".
split('-')[1] gives you "44".
{{--  Start Hare --}}
<script>
    // 1. Basic Use: Split a String into an Array
    let str1 = "apple,banana,orange";
    let fruits1 = str1.split(",");
    console.log(fruits1); // Output: ["apple", "banana", "orange"]

    // 2. Splitting by Space
    let sentence = "Hello world! How are you?";
    let words = sentence.split(" ");
    console.log(words); // Output: ["Hello", "world!", "How", "are", "you?"]

    // 3. Splitting by Each Character
    let str2 = "hello";
    let chars = str2.split("");
    console.log(chars); // Output: ["h", "e", "l", "l", "o"]

    // 4. Limit the Number of Splits
    let str3 = "apple,banana,orange,grape";
    let fruits2 = str3.split(",", 2);
    console.log(fruits2); // Output: ["apple", "banana"]

    // 5. Splitting with a Regular Expression
    let str4 = "Hello123World456";
    let parts = str4.split(/\d+/); // Splits by one or more digits
    console.log(parts); // Output: ["Hello", "World", ""]

    // 6. Using Split with No Delimiter
    let str5 = "Hello World";
    let result = str5.split();
    console.log(result); // Output: ["Hello World"]

    // 7. Removing Unwanted Characters
    let str6 = "1-800-123-4567";
    let digits = str6.split("-").join(""); // Split by "-" and join the result
    console.log(digits); // Output: "18001234567"

    // 8. Extracting a Specific Part
    let url = "https://www.example.com/path/page";
    let domain = url.split("/")[2];
    console.log(domain); // Output: "www.example.com"

    // 9. Splitting by Multiple Delimiters
    let str7 = "apple, banana; orange:grape";
    let fruits3 = str7.split(/[,;:]/);
    console.log(fruits3); // Output: ["apple", " banana", " orange", "grape"]

    // 10. Splitting HTML Content
    let htmlString = "<div>Hello</div><div>World</div>";
    let parts2 = htmlString.split(/<\/?div>/);
    console.log(parts2); // Output: ["", "Hello", "", "World", ""]

    // 11. Extracting the Extension from a Filename
    let filename = "document.pdf";
    let extension = filename.split(".").pop();
    console.log(extension); // Output: "pdf"

    // 12. Handling Multiple Delimiters with Empty Results
    let str8 = "apple--banana,,orange";
    let fruits4 = str8.split(/[-,]/);
    console.log(fruits4); // Output: ["apple", "", "banana", "", "orange"]

    // 13. Using split() for String Reversal
    let str9 = "Hello";
    let reversed = str9.split("").reverse().join("");
    console.log(reversed); // Output: "olleH"

    // 14. Handling Leading and Trailing Delimiters
    let str10 = ",apple,banana,orange,";
    let fruits5 = str10.split(",");
    console.log(fruits5); // Output: ["", "apple", "banana", "orange", ""]
</script>



{{-- * regarding are you sure  --}}
{{--  Start Hare --}}

<button type="submit" style="float: right" class="btn btn-success" id="saveform">Save
</button>

<script>
    $(document).ready(function() {
        $('#saveform').click(function(event) {
            var reasoninputvalve = $('#reasoninput').val().trim();

            if (reasoninputvalve === "") {
                alert('Please enter a reason. It is mandatory.');
                event.preventDefault();
                return false;
            }

            // Confirmation prompt
            var confirmSubmit = confirm('Are you sure you want to submit ?');
            if (!confirmSubmit) {
                event.preventDefault();
                return false;
            }
        });
    });
</script>
{{--  Start Hare --}}
{{-- *  --}}
{{--  Start Hare  --}}

<script>
    $(document).ready(function() {
        var createdBy = @json($timesheetData[0]->createdby);
        var userRoleId = @json(Auth::user()->role_id);
        var userTeammemberId = @json(Auth::user()->teammember_id);

        // Determine if the column 15 should be included
        var includeColumn15 = (userRoleId != 11 && userTeammemberId == createdBy);

        $('#examplee').DataTable({
            "order": [
                [3, "desc"]
            ],
            searching: false,
            columnDefs: [{
                targets: includeColumn15 ? [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] :
                    [0, 1, 2, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14],
                orderable: false
            }],
            buttons: []
        });
    });
</script>
{{--  Start Hare  --}}
{{-- *  --}}
{{--  Start Hare  --}}
<script>
    $('#examplee').DataTable({
        "pageLength": 10,
        "dom": 'Bfrtip',
        "order": [
            [0, "desc"]
        ],

        columnDefs: [{
            targets: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
            orderable: false
        }],

        buttons: [{
            extend: 'excelHtml5',
            exportOptions: {
                columns: ':visible',
                format: {
                    body: function(data, row, column, node) {
                        // it should be column number 2
                        if (column === 0) {
                            // If the data is a date, extract the date without HTML tags
                            var cleanedText = $(data).text().trim();
                            var dateParts = cleanedText.split(
                                '-');
                            // Assuming the date format is yyyy-mm-dd
                            if (dateParts.length === 3) {
                                return dateParts[2] + '-' + dateParts[1] + '-' +
                                    dateParts[0];
                            }
                        }
                        if (column === 1) {
                            var cleanedText = $(data).text().trim();
                            return cleanedText;
                        }
                        if (column === 9) {
                            var cleanedText = $(data).text().trim();
                            return cleanedText;
                        }
                        return data;
                    }
                }
            },
            text: 'Export to Excel',
            className: 'btn-excel',
        }, ]
    });
</script>
{{--  Start Hare  --}}
{{-- * regarding data table / regarding datatable / regarding excell  --}}
{{--  Start Hare --}}
<!-- validation on excel file  -->
<script>
    function validateFileType(input) {
        const allowedExtensions = [".csv", ".xlsx", ".xls"];
        const fileName = input.value.toLowerCase();
        const extension = fileName.substring(fileName.lastIndexOf("."));

        if (!allowedExtensions.includes(extension)) {
            alert("Please select an Excel (.csv, .xlsx, or .xls) file.");
            input.value = ""; // Clear the file selection
            return false; // Prevent form submission if file type is invalid
        }
        return true; // Allow form submission if file type is valid
    }
</script>

{{-- for preview of an Excel fil  --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script>
    //   Global Variables:
    let excelData = [];
    let currentPage = 1;
    const rowsPerPage = 10;

    //   Excel Serial Date Conversion Function
    function excelSerialToDate(serial) {
        const utc_days = Math.floor(serial - 25569);
        const utc_value = utc_days * 86400;
        return new Date(utc_value * 1000);
    }

    //   File Selection Handler
    function handleFileSelect(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        console.log("file:", file);
        console.log("reader:", reader);


        reader.onload = function(e) {
            const data = new Uint8Array(e.target.result);
            const workbook = XLSX.read(data, {
                type: 'array'
            });
            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            excelData = XLSX.utils.sheet_to_json(sheet, {
                header: 1,
                raw: false,
                dateNF: 'yyyy-mm-dd'
            });
            displayHeaderRow(excelData[0]);
            displayData(currentPage);
        };

        reader.readAsArrayBuffer(file);
    }

    //   Header Capitalize Function
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1).toLowerCase();
    }

    //   Display Header Row in Table
    function displayHeaderRow(headerRow) {
        const tableHeader = document.getElementById('table-header');
        tableHeader.innerHTML = '';
        const tr = document.createElement('tr');
        headerRow.forEach(header => {
            const th = document.createElement('th');
            // Capitalize the first letter of each header
            th.textContent = capitalizeFirstLetter(header);
            tr.appendChild(th);
        });
        tableHeader.appendChild(tr);
    }

    //   Display Paginated Data
    function displayData(page) {
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const totalPages = Math.ceil((excelData.length - 1) / rowsPerPage);

        const tableBody = document.getElementById('table-body');
        tableBody.innerHTML = '';

        for (let i = startIndex + 1; i < endIndex + 1 && i < excelData.length; i++) {
            const row = excelData[i];
            const tr = document.createElement('tr');
            for (let j = 0; j < excelData[0].length; j++) {
                const td = document.createElement('td');
                if (j < row.length) {
                    let cellValue = row[j];
                    //   date 
                    if (j === 3 && !isNaN(cellValue)) {
                        const date = excelSerialToDate(cellValue);
                        cellValue = date.toLocaleDateString();
                    }
                    td.textContent = cellValue;
                } else {
                    td.textContent = ""; // For blank cells
                }
                tr.appendChild(td);
            }
            tableBody.appendChild(tr);
        }

        displayPagination(totalPages);
    }

    //   Pagination Display Function
    function displayPagination(totalPages) {
        const pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement('li');
            li.className = 'page-item';
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = i;
            a.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                displayData(currentPage);
            });
            li.appendChild(a);
            pagination.appendChild(li);
        }
    }

    document.getElementById('input-excel').addEventListener('change', handleFileSelect);
</script>
{{--  Start Hare --}}

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 100,
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            buttons: [

                {
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>
{{--  Start Hare --}}
{{-- add this code on top of page  --}}
<link href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet">





{{-- add this code on end  of page  --}}
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>

<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            "pageLength": 10,
            "dom": '1Bfrtip',
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>

<script>
    $(document).ready(function() {
        $('#teamexamplee').DataTable({
            "pageLength": 10,
            "dom": '1Bfrtip',
            "order": [
                [5, "desc"]
            ],
            columnDefs: [{
                targets: [1, 2, 3, 4, 6, 7, 8, 9, 10],
                orderable: false
            }],
            buttons: [{
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                },
                text: 'Export to Excel',
                className: 'btn-excel',
            }, ]
        });

        $('.btn-excel').hide();
    });
</script>
{{-- *regarding date formate   --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                [0, "desc"]
            ],

            columnDefs: [{
                targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10],
                orderable: false
            }],

            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                    filename: 'Timesheet Request List',
                    // exportOptions: {
                    //     columns: ':visible'
                    // }
                    exportOptions: {
                        columns: ':visible',
                        format: {
                            body: function(data, row, column, node) {
                                if (column === 0) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                if (column === 1) {
                                    var dateParts = data.split('-');
                                    var monthNumbers = {
                                        'Jan': '01',
                                        'Feb': '02',
                                        'Mar': '03',
                                        'Apr': '04',
                                        'May': '05',
                                        'Jun': '06',
                                        'Jul': '07',
                                        'Aug': '08',
                                        'Sep': '09',
                                        'Oct': '10',
                                        'Nov': '11',
                                        'Dec': '12'
                                    };
                                    var day = dateParts[0];
                                    var month = monthNumbers[dateParts[1]];
                                    var year = dateParts[2];
                                    return day + '-' + month + '-' + year;
                                }
                                if (column === 3) {
                                    var cleanedText = $(data).text().trim();
                                    return cleanedText;
                                }
                                return data; // Return other data unchanged
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Request List',
                    exportOptions: {
                        columns: [0, 1, 2, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script>

{{--  Start Hare  --}}
{{-- * regarding value / ajax  --}}
{{--  Start Hare  --}}
<script>
    $(document).ready(function() {
        $("#aircraft_name").change(function() {
            var air_id = $(this).val();
            alert(air_id);
            $("#aircraft_id").val(air_id);
        });
    });
</script>

<div class="col-4">
    <div class="form-group">
        <label class="font-weight-600">Login Name</label>
        <input type="text" readonly name="email" id="aircraft_id" value="{{ $teammember->email ?? '' }}"
            class="form-control" placeholder="Enter Email">
    </div>
</div>

<select class="language form-control" id="aircraft_name" name="teammember_id"
    @if (Request::is('teamlogin/*/edit')) > <option disabled
style="display:block">Please Select One</option>

@foreach ($teammemberlist as $teammemberlistData)
<option value="{{ $teammemberlistData->id }}"
    {{ $teammember->teammemberlist->id == $teammemberlistData->id ?? '' ? 'selected="selected"' : '' }}>
    {{ $teammemberlistData->teammemberlist }}</option>
@endforeach


@else
<option></option>
<option value="">Please Select One</option>
@foreach ($teammemberlist as $teammemberlistData)
<option value="{{ $teammemberlistData->emailid }}">
    {{ $teammemberlistData->team_member }} ({{ $teammemberlistData->staffcode }})</option>

@endforeach @endif
    </select>
    {{--  Start Hare  --}}
    {{-- *  --}}
    {{--  Start Hare  --}}

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script type="text/javascript">
        //jQuery.noConflict();
        function readURL(input) {
            if (input.files && input.files[0]) {

                var reader = new FileReader();

                reader.onload = function(e) {
                    jQuery('#profile-img-tag').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        jQuery("#profile-img").change(function() {
            readURL(this);
        });
    </script>

    <script>
        // Add event listener for 'To' date input
        document.getElementById('to').addEventListener('change', function() {
            var fromDate = new Date(document.getElementById('from').value);
            var toDate = new Date(this.value);

            // Compare the dates
            if (toDate < fromDate) {
                alert('The "To" date must be greater than the "From" date.');
                this.value = '';
            }
        });
    </script>
    <script>
        // Function to count the number of words in a string
        function countWords(str) {
            str = str.trim();
            if (str === '') {
                return 0;
            }
            return str.split(/\s+/).length;
        }

        // Add event listener for form submission
        document.getElementById('formLeaveCreate').addEventListener('submit', function(event) {
            var reasonInput = document.getElementById('reasonleave');
            var reasonValue = reasonInput.value;
            var wordCount = countWords(reasonValue);

            // Check if word count exceeds the limit
            if (wordCount > 10) {
                alert('The reason for leave should not exceed 10 words.');
                event.preventDefault(); // Prevent form submission
            }
        });

        // Add event listener for reason input
        document.getElementById('reasonleave').addEventListener('input', function() {
            var reasonValue = this.value;
            var wordCount = countWords(reasonValue);

            // Update word count display
            document.getElementById('wordCount').textContent = wordCount;

            // Check if word count exceeds the limit and show a warning if needed
            if (wordCount > 10) {
                document.getElementById('wordCount').classList.add('text-danger');
            } else {
                document.getElementById('wordCount').classList.remove('text-danger');
            }
        });
    </script>
    {{--  Start Hare  --}}
    {{-- * regarding model box closed / regarding udin  --}}
    {{--  Start Hare  regarding model box closed  --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#exampleModal12').on('hidden.bs.modal', function() {
                $('#detailsFormudin')[0].reset();
            });
        });
    </script>
    <div class="modal fade" id="exampleModal12" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsFormudin" method="post" action="{{ url('assignmentudin/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background:#37A000;color:white;">
                        <h5 class="modal-title font-weight-600" id="exampleModalLabel4">Add UDIN</h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <button style="color: white" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="field_wrapper">
                            <div class="row row-sm ">
                                <div class="col-10">
                                    <div class="form-group">
                                        <label class="font-weight-600">UDIN</label>
                                        <input type="text" name="udin[]" value="" class=" form-control"
                                            placeholder="Enter Udin">
                                        <input type="text" name="assignment_generate_id" hidden
                                            value="{{ $assignmentbudgetingDatas->assignmentgenerate_id }}"
                                            class=" form-control">
                                    </div>
                                </div>
                                <a href="javascript:void(0);" style="margin-top: 36px;" class="add_button"
                                    title="Add field"><img src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                            </div>
                        </div>

                        <div class="row row-sm ">
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="font-weight-600">Partner </label>
                                    <select class="form-control" name="partner">
                                        <option value="">Please Select One</option>
                                        @foreach ($partner as $teammemberData)
                                            <option value="{{ $teammemberData->id }}">
                                                {{ $teammemberData->team_member }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row row-sm ">
                            <div class="col-10">
                                <div class="form-group">
                                    <label class="font-weight-600">UDIN Documentation Date</label>
                                    <input type="date" name="udindate" value="" class=" form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                </form>

            </div>
        </div>
    </div>
    {{--  Start Hare  --}}
    {{-- *  --}}
    {{--  Start Hare  --}}
    <script>
        $(function() {
            $('#client').on('change', function() {
                var cid = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheetreject/edit') }}",
                    data: {
                        cid: cid
                    },
                    success: function(res) {
                        $('#assignment').html(res.html);
                    },
                    error: function() {
                        alert('Error occurred while fetching assignments');
                    },
                });
            });


            $('#assignment').on('change', function() {
                var assignment = $(this).val();
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheetreject/edit') }}",
                    data: {
                        assignment: assignment
                    },
                    success: function(res) {
                        $('#partner').html(res.html);
                    },
                    error: function() {
                        alert('Error occurred while fetching partners');
                    },
                });
            });
        });
    </script>
    {{--  Start Hare  --}}
    {{-- * regarding file upload / file    --}}
    {{--  Start Hare --}}
    @php
        $fileName = '';
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $destinationPath = 'backEnd/image/confirmationfile';
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);
        }

        DB::table('debtorconfirmations')->insert([
            'debtor_id' => $request->debitid,
            'assignmentgenerate_id' => $request->assignmentgenerate_id,
            'remark' => null,
            'amount' => null,
            'file' => $fileName,
            'name' => $debtorconfirm->name,
            'created_at' => date('Y-m-d'),
            'updated_at' => date('Y-m-d'),
        ]);
    @endphp
    <script>
        document.getElementById('file-1').addEventListener('change', function() {
            alert('hi');
            var fileLabel = document.getElementById('file-label').querySelector('span');
            if (this.files.length > 0) {
                fileLabel.textContent = this.files[0].name;
            } else {
                fileLabel.textContent = "Choose a file…";
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('file-1').addEventListener('change', function() {
                alert('hi');
                var fileLabel = document.getElementById('file-label').querySelector('span');
                if (this.files.length > 0) {
                    fileLabel.textContent = this.files[0].name;
                } else {
                    fileLabel.textContent = "Choose a file…";
                }
            });
        });
    </script>

    <div class="modal fade" id="exampleModal21" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel4"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="detailsForm" method="post" action="{{ url('timesheetrequest/store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header" style="background: #37A000">
                        <h5 style="color:white;" class="modal-title font-weight-600" id="exampleModalLabel4">Add
                            Request
                        </h5>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $e)
                                    <li style="color:red;">{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Admin :</label>
                            <div class="col-sm-9">
                                <select class="language form-control" required id="category" name="partner">
                                    <option value="">Please Select One</option>
                                    @foreach ($partner as $teammemberData)
                                        <option value="{{ $teammemberData->id }}">
                                            {{ $teammemberData->team_member }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>
                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Reason :</label>
                            <div class="col-sm-9">
                                <textarea rows="4" name="reason" required class="form-control" placeholder="Enter Reason"></textarea>

                            </div>

                        </div>

                        <div class="details-form-field form-group row">
                            <label for="name" class="col-sm-3 col-form-label font-weight-600">Attachment File
                                :</label>
                            <div class="col-sm-9">
                                <input type="file" name="file" id="file-1" class="custom-input-file">
                                <label for="file-1" id="file-label">
                                    <i class="fa fa-upload"></i>
                                    <span>Choose a file…</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  Start Hare --}}
    {{-- * regarding page load / reload page / page refresh  --}}
    {{--  Start Hare  --}}

    <script>
        // {{--  Start Hare  --}}
        document.addEventListener('DOMContentLoaded', function() {
            var refreshBtn = document.getElementById('refreshbtn');
            var refreshBtn1 = document.getElementById('refreshbtn1');

            if (refreshBtn) {
                refreshBtn.addEventListener('click', function() {
                    location.reload();
                });
            }

            if (refreshBtn1) {
                refreshBtn1.addEventListener('click', function() {
                    location.reload();
                });
            }
        });
        // {{--  Start Hare  --}}
        document.addEventListener('click', function(event) {
            if (event.target && event.target.id === 'refreshbtn') {
                location.reload();
            }
            if (event.target && event.target.id === 'refreshbtn1') {
                location.reload();
            }
        });
        // {{--  Start Hare  --}}
        $(document).ready(function() {
            var refreshBtn = $('#refreshbtn');
            var refreshBtn1 = $('#refreshbtn1');

            if (refreshBtn.length) {
                refreshBtn.on('click', function() {
                    location.reload();
                });
            }

            if (refreshBtn1.length) {
                refreshBtn1.on('click', function() {
                    location.reload();
                });
            }
        });
        // {{--  Start Hare  --}}
        $('body').on('click', '#refreshbtn', function(event) {
            location.reload();

        });
        $('body').on('click', '#refreshbtn1', function(event) {
            location.reload();

        });
        // {{--  Start Hare  --}}
    </script>
    {{-- * regarding are you sure / regarding form submit  --}}
    {{--  Start Hare  --}}

    <div class="modal-footer">
        <button id="refreshButton" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info" onclick="saveForm()">Save Draft</button>
        <button type="submit" class="btn btn-primary" onclick="saveForm2()">Save</button>
        <button type="submit" class="btn btn-success" onclick="return validateSubject();">Send</button>
    </div>
    <script>
        function validateSubject() {
            var subjectInput = document.getElementsByName('subject')[0].value.trim();
            if (subjectInput === '') {
                alert('Please enter a subject.');
                return false; // Prevent form submission
            }
            return confirm('Are you sure?'); // Proceed with form submission
        }
    </script>


    {{--  Start Hare  --}}
    {{-- * regarding condition   --}}
    {{--  Start Hare  --}}
    <input required type="text" oninput="validateNumber(this)" name="withdrawalpurpose" id="key"
        value="{{ $withdrawal->purposeofwithdrawl ?? '' }}" class="form-control key">

    <script>
        function validateNumber(input) {
            var regex = /^\d*$/; // Regular expression to match only digits
            if (!regex.test(input.value)) {
                input.setCustomValidity("Please enter numbers only, without commas or letters");
            } else {
                input.setCustomValidity("");
            }
        }
    </script>
    {{--  Start Hare  --}}
    <input type="number" required name="noofdays" class="form-control" placeholder="Enter days" min="1"
        max="100" id="noofdays">
    <input type="number" required name="maxremider" class="form-control" placeholder="" id="maxremider">

    <script>
        $(document).ready(function() {
            $('#noofdays, #maxremider').on('change', function() {
                var value = $(this).val();
                if (value > 100 || value < 1) {
                    alert('Enter a value between 1 and 100');
                    $(this).val('');
                }
                if (value % 1 !== 0) {
                    alert('You cannot insert a decimal value.');
                    $(this).val('');
                }
            });
        });
    </script>
    {{--  Start Hare  --}}
    {{-- *  --}}

    {{--  Start Hare  --}}
    {{-- <div style="display: none" class="alert alert-success" id="successmessage">
    <p>Your balance confirmation open</p>
</div>
<div style="display: none" class="alert alert-success" id="successmessageclosed">
    <p>Your balance confirmation closed</p>
</div> --}}


    <script>
        function updateConfirmationStatus(checkbox) {
            var assignmentId = "{{ $clientList->assignmentgenerate_id }}";
            var status = checkbox.checked ? 1 : 0;

            $.ajax({
                url: "{{ url('/confirmationstatus') }}",
                type: 'GET',
                data: {
                    assignmentid: assignmentId,
                    status: status
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == 1) {
                        $('#successmessage').find('p').text('Your balance confirmation open');
                        $('#successmessage').show();
                        $('#successmessageclosed').hide();
                    } else {
                        $('#successmessageclosed').find('p').text('Your balance confirmation closed');
                        $('#successmessageclosed').show();
                        $('#successmessage').hide();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    {{--  Start Hare  --}}
    {{-- <div class="alert alert-success" id="successmessage" style="display: none;">
    <p></p>
</div> --}}
    <script>
        function updateConfirmationStatus(checkbox) {
            var assignmentId = "{{ $clientList->assignmentgenerate_id }}";
            var status = checkbox.checked ? 1 : 0;

            $.ajax({
                url: "{{ url('/confirmationstatus') }}",
                type: 'GET',
                data: {
                    assignmentid: assignmentId,
                    status: status
                },
                success: function(response) {
                    console.log(response);
                    var message = response.status == 1 ? 'Your balance confirmation open' :
                        'Your balance confirmation closed';
                    $('#successmessage').find('p').text(message);
                    $('#successmessage').show();
                },
                error: function(xhr, status, error) {
                    // Handle error response if needed
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
    {{--  Start Hare regarding delay --}}
    {{-- $('#successmessage').delay(5000).fadeOut(400); --}}
    {{-- <script>
      // Use jQuery to add a temporary display to the flash message
      $(document).ready(function() {
          $('#successmessage').delay(5000).fadeOut(400);
      });
  </script> --}}
    {{--  Start Hare  --}}

    {{-- * regarding column number know / regarding column / regarding exce download  --}}
    {{--  Start Hare  --}}
    <script>
        {
            extend: 'excelHtml5',
            filename: 'Timesheet_Download',
            exportOptions: {
                columns: ':visible',
                format: {
                    body: function(data, row, column, node) {
                        // If the data is a date, extract the date without HTML tags
                        if (column === 2) {
                            // var cleanedText = $(data).text().trim();
                            // var dateParts = cleanedText.split(
                            //     '-');
                            // Assuming the date format is yyyy-mm-dd
                            // if (dateParts.length === 3) {
                            //     return dateParts[2] + '-' + dateParts[1] + '-' +
                            //         dateParts[0];
                            // }
                        }
                        return column;
                    }
                }
            },
        },
    </script>
    {{--  Start Hare  --}}
    {{-- * regarding console  --}}
    {{--  Start Hare  --}}
    <script>
        const d = new Date(datepickers);
        const dayOfWeek = d.getDay();
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
            "Saturday"
        ];
        const dayString = days[dayOfWeek];
        console.log(d, 0);
        console.log(dayOfWeek, 1);
        console.log(days, 2);
        console.log(dayString, 3);
    </script>

    <script>
        console.log("lasttimesheetsubmiteddata:", lasttimesheetsubmiteddata);
        console.log("timesheetmaxDateRecord:", timesheetmaxDateRecord);
        console.log("leavedataforcalander1:", leavedataforcalander1);
        console.log("differenceInDays:", differenceInDays);
        console.log("newteammember:", newteammember);
        console.log("rejoiningdate:", rejoiningdate);
        console.log("totalleaveCount:", totalleaveCount);
        console.log("leavebreakdateassign:", leavebreakdateassign);
    </script>
    {{--  Start Hare  --}}
    {{-- * regarding alert  --}}
    {{--  Start Hare  --}}
    alert("Value of workitem: " + workitem);
    {{--  Start Hare  --}}
    {{-- *  --}}
    {{--  Start Hare  --}}
    <script>
        $(document).ready(function() {
            var status = @json(Request::query('status'));

            var filename = 'All Team Member List';
            if (status == '1') {
                filename = 'Active Team Members';
            } else if (status == '0') {
                filename = 'Inactive Team Members';
            }

            $('#examplee').DataTable({
                "pageLength": 130,
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        filename: filename,
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 5]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    {{--  Start Hare  --}}
    {{-- *  --}}
    {{--  Start Hare  --}}
    {{--  Start Hare  --}}
    {{-- * regarding filter functionality   --}}
    {{--  Start Hare  --}}
    <script>
        $(document).ready(function() {
            // Common function to render table rows
            function renderTableRows(data) {
                $('table tbody').html("");
                $('#clickExcell').show();

                if (data.length === 0) {
                    $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
                } else {
                    $.each(data, function(index, item) {
                        var url = '/applyleave/' + item.id;
                        var createdAt = formatDate(item.created_at);
                        var fromDate = formatDate(item.from);
                        var toDate = formatDate(item.to);
                        var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                            60 * 1000)) + 1;

                        $('table tbody').append('<tr>' +
                            '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                            '<td>' + createdAt + '</td>' +
                            '<td>' + getStatusBadge(item.status) + '</td>' +
                            '<td>' + item.name + '</td>' +
                            '<td>' + fromDate + ' to ' + toDate + '</td>' +
                            '<td>' + holidays + '</td>' +
                            '<td>' + item.approvernames + '</td>' +
                            '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                            '</tr>');
                    });
                }
            }

            // Common function to export data to Excel
            function exportToExcel(data) {
                const filteredData = data.map(item => {
                    const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                        1000)) + 1;
                    const createdAt = formatDate(item.created_at);
                    const fromDate = formatDate(item.from);
                    const toDate = formatDate(item.to);

                    return {
                        Employee: item.team_member,
                        Date_of_Request: createdAt,
                        status: getStatusText(item.status),
                        Leave_Type: item.name,
                        from: fromDate,
                        to: toDate,
                        Days: holidays,
                        Approver: item.approvernames,
                        Reason_for_Leave: item.reasonleave
                    };
                });

                const ws = XLSX.utils.json_to_sheet(filteredData);
                const headerCellStyle = {
                    font: {
                        bold: true
                    }
                };

                ws['!cols'] = [{
                        wch: 15
                    },
                    {
                        wch: 20
                    },
                    {
                        wch: 15
                    },
                    {
                        wch: 20
                    },
                    {
                        wch: 15
                    },
                    {
                        wch: 15
                    },
                    {
                        wch: 20
                    },
                    {
                        wch: 30
                    }
                ];

                Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                    ws[key].s = headerCellStyle;
                });

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                const excelBuffer = XLSX.write(wb, {
                    bookType: "xlsx",
                    type: "array"
                });
                const dataBlob = new Blob([excelBuffer], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                });
                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
            }

            // Common function to format date
            function formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }

            // Common function to get status text
            function getStatusText(status) {
                return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
            }

            // Common function to get status badge
            function getStatusBadge(status) {
                if (status === 0) {
                    return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                } else if (status === 1) {
                    return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                } else if (status === 2) {
                    return '<span class="badge badge-danger">Rejected</span>';
                } else {
                    return '';
                }
            }

            // Function to handle status change
            function handleStatusChange() {
                var endperiod1 = $('#endperiod1').val();
                var startperiod1 = $('#startperiod1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();
                var end1 = $('#end1').val();
                var start1 = $('#start1').val();
                $('#clickExcell').hide();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        startperiod: startperiod1,
                        endperiod: endperiod1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Remove previus attachment on download button 
                        $('#clickExcell').off('click');

                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                        $('#clickExcell').show();
                    }
                });
            }

            // Function to handle leave type change
            function handleLeaveTypeChange() {
                var endperiod1 = $('#endperiod1').val();
                var startperiod1 = $('#startperiod1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();
                var end1 = $('#end1').val();
                var start1 = $('#start1').val();
                $('#clickExcell').hide();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        startperiod: startperiod1,
                        endperiod: endperiod1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        // Remove previus attachment on download button 
                        $('#clickExcell').off('click');
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                        $('#clickExcell').show();
                    }
                });
            }

            // Function to handle employee change
            function handleEmployeeChange() {
                var endperiod1 = $('#endperiod1').val();
                var startperiod1 = $('#startperiod1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();
                var end1 = $('#end1').val();
                var start1 = $('#start1').val();
                $('#clickExcell').hide();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        startperiod: startperiod1,
                        endperiod: endperiod1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        // Remove previus attachment on download button 
                        $('#clickExcell').off('click');
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                        $('#clickExcell').show();
                    }
                });
            }

            // Function to handle leave period end date change
            function handleleaveperiodendChange() {
                var endperiod1 = $('#endperiod1').val();
                var startperiod1 = $('#startperiod1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();
                var end1 = $('#end1').val();
                var start1 = $('#start1').val();
                $('#clickExcell').hide();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        startperiod: startperiod1,
                        endperiod: endperiod1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        // Remove previus attachment on download button 
                        $('#clickExcell').off('click');
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                        $('#clickExcell').show();
                    }
                });
            }

            //  end Request Date end date wise
            function handleEndRequestDateChange() {
                var endperiod1 = $('#endperiod1').val();
                var startperiod1 = $('#startperiod1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();
                var end1 = $('#end1').val();
                var start1 = $('#start1').val();
                $('#clickExcell').hide();


                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        startperiod: startperiod1,
                        endperiod: endperiod1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        $('#clickExcell').off('click');
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                        $('#clickExcell').show();
                    }
                });
            }

            // Event handlers
            $('#employee1').change(handleEmployeeChange);
            $('#leave1').change(handleLeaveTypeChange);
            $('#status1').change(handleStatusChange);
            $('#end1').change(handleEndRequestDateChange);
            $('#endperiod1').change(handleleaveperiodendChange);
        });
    </script>

    <script>
        $(document).ready(function() {
            //   all partner
            $('#category1').change(function() {
                var search1 = $(this).val();
                var search4 = $('#category4').val();
                var search7 = $('#category7').val();
                //   console.log(search1);
                // Send an AJAX request to fetch filtered data based on the selected partner
                $.ajax({
                    type: 'GET',
                    url: '/filter-dataadmin',
                    data: {
                        partnersearch: search1,
                        totalhours: search4,
                        teamname: search7
                    },
                    success: function(data) {
                        // Clear the table body
                        $('table tbody').html("");

                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                // Format created_at date
                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format(
                                    'hh:mm A');

                                @if (Auth::user()->role_id == 11)
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + (item.dayscount != 0 ? item
                                            .dayscount :
                                            item.totaldays) + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @else
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + item.totaldays + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @endif
                            });
                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });

            //** start date
            $('#start').change(function() {
                var search8 = $(this).val();
                var search9 = $('#end').val();
                var search7 = $('#category7').val();
                var search4 = $('#category4').val();
                var search1 = $('#category1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filter-dataadmin',
                    data: {
                        end: search9,
                        start: search8,
                        totalhours: search4,
                        teamname: search7,
                        partnersearch: search1
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html(""); // Clear the table body

                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                // Format created_at date
                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format(
                                    'hh:mm A');

                                @if (Auth::user()->role_id == 11)
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + (item.dayscount != 0 ? item
                                            .dayscount :
                                            item.totaldays) + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @else
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + item.totaldays + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @endif
                            });
                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });

            //** end date
            $('#end').change(function() {
                var search9 = $(this).val();
                var search8 = $('#start').val();
                var search7 = $('#category7').val();
                var search4 = $('#category4').val();
                var search1 = $('#category1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filter-dataadmin',
                    data: {
                        end: search9,
                        start: search8,
                        totalhours: search4,
                        teamname: search7,
                        partnersearch: search1
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html(""); // Clear the table body

                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                // Format created_at date
                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format(
                                    'hh:mm A');

                                @if (Auth::user()->role_id == 11)
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + (item.dayscount != 0 ? item
                                            .dayscount :
                                            item.totaldays) + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @else
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + item.totaldays + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @endif
                            });
                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });
            //   total hour wise
            $('#category4').change(function() {
                var search4 = $(this).val();
                var search7 = $('#category7').val();
                var search1 = $('#category1').val();
                // Send an AJAX request to fetch filtered data based on the selected partner
                $.ajax({
                    type: 'GET',
                    url: '/filter-dataadmin',
                    data: {
                        totalhours: search4,
                        teamname: search7,
                        partnersearch: search1
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html(""); // Clear the table body
                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                // Format created_at date
                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format(
                                    'hh:mm A');

                                @if (Auth::user()->role_id == 11)
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + (item.dayscount != 0 ? item
                                            .dayscount :
                                            item.totaldays) + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @else
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + item.totaldays + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @endif
                            });
                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });

            //   team name wise
            $('#category7').change(function() {
                var search7 = $(this).val();
                var search4 = $('#category4').val();
                var search1 = $('#category1').val();

                // Send an AJAX request to fetch filtered data based on the selected partner
                $.ajax({
                    type: 'GET',
                    url: '/filter-dataadmin',
                    data: {
                        teamname: search7,
                        partnersearch: search1,
                        totalhours: search4
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html(""); // Clear the table body
                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                // Format created_at date
                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format(
                                    'hh:mm A');


                                @if (Auth::user()->role_id == 11)
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + (item.dayscount != 0 ? item
                                            .dayscount :
                                            item.totaldays) + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @else
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + item.totaldays + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +

                                        '</tr>');
                                @endif

                            });
                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });
            //shahid
        });
    </script>


    <script>
        $(document).ready(function() {
            // Define a function for handling filter changes
            function handleFilterChange() {
                var search1 = $('#category1').val();
                var search4 = $('#category4').val();
                var search7 = $('#category7').val();
                var search8 = $('#start').val();
                var search9 = $('#end').val();

                $.ajax({
                    type: 'GET',
                    url: '/filter-dataadmin',
                    data: {
                        partnersearch: search1,
                        totalhours: search4,
                        teamname: search7,
                        start: search8,
                        end: search9
                    },
                    success: function(data) {
                        $('table tbody').html(""); // Clear the table body

                        if (data.length === 0) {
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>');
                        } else {
                            $.each(data, function(index, item) {
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format('hh:mm A');

                                @if (Auth::user()->role_id == 11)
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + (item.dayscount != 0 ? item
                                            .dayscount :
                                            item.totaldays) + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +
                                        '</tr>');
                                @else
                                    // Add the rows to the table
                                    $('table tbody').append('<tr>' +
                                        '<td><a href="' + url + '">' + item
                                        .team_member +
                                        '</a></td>' +
                                        '<td>' + item.week + '</td>' +
                                        '<td>' + formattedDate + ' ' +
                                        formattedTime +
                                        '</td>' +
                                        '<td>' + item.totaldays + '</td>' +
                                        '<td>' + item.totaltime + '</td>' +
                                        '</tr>');
                                @endif
                            });

                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            }

            // Handle change events for all filters
            $('#category1, #category4, #category7').change(handleFilterChange);
            $('#start, #end').change(handleFilterChange);
        });
    </script>
    {{--  Start Hare  --}}



    {{-- *  --}}
    {{--  Start Hare  --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-info" onclick="saveForm()">Save Draft</button>
        <button type="submit" class="btn btn-primary" onclick="saveForm2()">Save</button>
        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?');">Send</button>
    </div>


    <script>
        function saveForm() {
            document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
        }

        function saveForm2() {
            var template = $('#template').val();
            if (template == '') {
                alert('Please Select Confirmation Type');
            } else {
                //   document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
                var url = "{{ url('/maildraft') }}";

                // Perform the URL hit
                window.location.href = url;

            }
        }
    </script>

    <script>
        function saveForm() {
            document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
        }

        function saveForm2() {
            var type = $('#template').val();
            //   var clientid = $("[name='clientid']").val();
            if (type == '') {
                alert('Please Select Confirmation Type');
            } else {
                var url = "{{ url('/mailsave') }}";
                // Append type and clientid to the URL
                //   url += "?type=" + type + "&clientid=" + clientid;
                url += "?type=" + type;
                window.location.href = url;

            }
        }

        function saveForm2() {
            document.getElementById('detailsForm').action = "{{ url('/finalsave') }}";
        }
    </script>
    {{-- * regarding form  --}}
    {{--  Start Hare  --}}

    <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" onclick="saveForm()">Save</button>
        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure?');">Send</button>
    </div>
    <script>
        function saveForm() {
            document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
        }

        //   function sendMail() {
        //       document.getElementById('detailsForm').action = "{{ url('/confirmation/mail') }}";
        //   }
    </script>
    {{-- *  --}}
    {{--  Start Hare  --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#template').on('change', function() {
                var template_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationtem') }}",
                    data: "template_id=" + template_id,
                    success: function(response) {
                        var desc = response.description;

                        // Check if "desc" exists in the response and is not empty before setting
                        if (desc && desc.trim() !== "") {
                            $('#summernote').summernote('code',
                                desc); // Update Summernote content
                        }
                    },
                    error: function() {

                    },
                });
                $('#subcentre_id').html('');
            });
        });
    </script>
    {{-- *  --}}
    {{--  Start Hare  --}}
    <script>
        function saveForm() {
            if (confirm('Are you sure?')) {
                document.getElementById('detailsForm').action = "{{ url('/maildraft') }}";
                return true; // Form will be submitted
            }
            return false; // Form submission canceled
        }
        //   function sendMail() {
        //       document.getElementById('detailsForm').action = "{{ url('/confirmation/mail') }}";
        //   }
    </script>

    <script>
        $(document).on('change', '[id^=partner]', function() {
            var partnerValue = $(this).val();
            var index = $(this).attr('id').slice(-1);
            if (partnerValue != "" && partnerValue != "Select Partner") {
                $('.workItem' + index).attr('required', true);
                $('.location' + index).attr('required', true);
                $('.hour' + index).attr('required', true);
            } else {
                $('.workItem' + index).attr('required', false);
                $('.location' + index).attr('required', false);
                $('.hour' + index).attr('required', false);
            }
        });
    </script>
    {{-- * regarding replace function /regarding text replace function --}}
    {{--  Start Hare  --}}

    <script>
        function handleClientChange(clientId) {
            $('#' + clientId).on('change', function() {
                var cid = $(this).val();
                var datepickers = $('#datepickers').val();

                if (cid == 33) {
                    var location = 'N/A';
                    var workitem = 'N/A';
                    var time = 0;

                    // clientId me hai client,client1,client2,client3,client4
                    // Extract the number from the client ID like 1,2,3,4
                    //   var clientNumber = parseInt(clientId.replace('client', ''));
                    var clientNumber = clientId.replace('clien', '');
                    alert(clientNumber);
                    if (!isNaN(clientNumber)) {
                        // Check if clientNumber is a valid number
                        $('.workitemnvalue' + clientNumber).val(workitem);
                        $('.locationvalue' + clientNumber).val(location);
                        $('#totalhours').val(time);
                        $('#hour' + (clientNumber + 1)).prop('readonly', true);
                    } else {
                        // Default behavior for clientId 'client'
                        $('.workitemnvalue').val(workitem);
                        $('.locationvalue').val(location);
                        $('#totalhours').val(time);
                        $("#hour1").prop("readonly", true);
                    }
                }

                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: {
                        cid: cid,
                        datepickers: datepickers
                    },
                    success: function(res) {
                        $('#' + clientId.replace('client', 'assignment')).html(res);
                    },
                    error: function() {},
                });
            });
        }
    </script>
    {{-- * sweech case  --}}
    {{--  Start Hare  --}}
    <script>
        switch (clientId) {
            case 'client':
                $('.workitemnvalue').val(workitem);
                $('.locationvalue').val(location);
                $("#hour1").prop("readonly", true);
                break;
            case 'client1':
                $('.workitemnvalue1').val(workitem);
                $('.locationvalue1').val(location);
                $("#hour2").prop("readonly", true);
                break;
            case 'client2':
            case 'client3':
            case 'client4':
                $('.workitemnvalue1').val(workitem);
                $('.locationvalue1').val(location);
                $("#hour1").prop("readonly", true);
                break;
            default:
                break;
        }
    </script>
    {{-- * selecteor / regarding selector/ regarding selecter / regarding jquery selector / regarding jquery selecter / regarding target --}}
    {{--  Start Hare  --}}
    const test1 = $("#datepickers1").val();
    const test2 = $("#datepickers1").val().split('-');
    const test3 = $("#datepickers1").val().split('-').reverse();
    const test4 = $("#datepickers1").val().split('-').reverse().join('-');

    // test1 10-04-2025
    // create:1111 test2 (3) ['10', '04', '2025']0: "10"1: "04"2: "2025"length: 3[[Prototype]]: Array(0)
    // create:1112 test3 (3) ['2025', '04', '10']
    // create:1113 test4 2025-04-10
    {{--  Start Hare  --}}
    {{-- for testing 
https://www.w3schools.com/jquery/trysel.asp?password=password&rr=on --}}
    <script>
        if (cid == 33) {
            var location = 'N/A';
            var workitem = 'N/A';
            var time = 0;

            $('.workitemnvalue1').val(workitem);
            $('.locationvalue1').val(location);
            $('#totalhours').val(time);
            $("#hour1").prop("readonly", true);
        }

        if (cid == 33) {
            var location = 'leaave';
            var workitem = 'leaaveq';
            $("p").hide();
            $("[name='workitem']").val(workitem);
            $("[name='location']").val(workitem);
            $("#Lastname")
            $(".intro")
            $(".intro, #Lastname")
            $("h1")
            $("h1, p")
            $("p:first")
            $("p:last")
            $("tr:even")
            $("tr:odd")
            $("p:first-child")
            $("p:first-of-type")
            $("p:last-child")
            $("p:last-of-type")
            $("li:nth-child(1)")
            $("li:nth-last-child(1)")
            $("li:nth-of-type(2)")
            $("li:nth-last-of-type(2)")
            $("b:only-child")
            $("h3:only-of-type")
            $("div > p")
            $("div p")
            $("ul + p")
            $("ul ~ table")
            $("ul li:eq(0)")
            $("ul li:gt(0)")
            $("ul li:lt(2)")
            $(":header")
            $(":header:not(h1)")
            $(":animated")
            $(":focus")
            $(":contains(Duck)")
            $("div:has(p)")
            $(":empty")
            $(":parent")
            $("p:hidden")
            $("table:visible")
            $(":root")
            $("p:lang(it)")
            $("[id]")
            $("[id=my-Address]")
            $("p[id!=my-Address]")
            $("[id$=ess]")
            $("[id|=my]")
            $("[id^=L]")
            $("[title~=beautiful]")
            $("[id*=s]")
            $(":input")
            $(":text")
            $(":password")
            $(":radio")
            $(":checkbox")
            $(":submit")
            $(":reset")
            $(":button")
            $(":image")
            $(":file")
            $(":enabled")
            $(":disabled")
            $(":selected")
            $(":checked")
            $("*")
            $('[id^=partner]')
        }
    </script>

    <pre>
    | Selector             | Example                    | Selects                                                |
|----------------------|----------------------------|--------------------------------------------------------|
| *                    | $("*")                     | All elements                                           |
| #id                  | $("#lastname")             | The element with id="lastname"                         |
| .class               | $(".intro")                | All elements with class="intro"                        |
| .class, .class       | $(".intro, .demo")         | All elements with the class "intro" or "demo"          |
| element              | $("p")                     | All <p> elements                                       |
| el1, el2, el3        | $("h1, div, p")            | All <h1>, <div>, and <p> elements                      |
| :first               | $("p:first")               | The first <p> element                                  |
| :last                | $("p:last")                | The last <p> element                                   |
| :even                | $("tr:even")               | All even <tr> elements                                 |
| :odd                 | $("tr:odd")                | All odd <tr> elements                                  |
| :first-child         | $("p:first-child")         | All <p> elements that are the first child of their parent |
| :first-of-type       | $("p:first-of-type")       | All <p> elements that are the first <p> element of their parent |
| :last-child          | $("p:last-child")          | All <p> elements that are the last child of their parent |
| :last-of-type        | $("p:last-of-type")        | All <p> elements that are the last <p> element of their parent |
| :nth-child(n)        | $("p:nth-child(2)")        | All <p> elements that are the 2nd child of their parent |
| :nth-last-child(n)   | $("p:nth-last-child(2)")   | All <p> elements that are the 2nd child of their parent, counting from the last child |
| :nth-of-type(n)      | $("p:nth-of-type(2)")      | All <p> elements that are the 2nd <p> element of their parent |
| :nth-last-of-type(n) | $("p:nth-last-of-type(2)") | All <p> elements that are the 2nd <p> element of their parent, counting from the last child |
| :only-child          | $("p:only-child")          | All <p> elements that are the only child of their parent |
| :only-of-type        | $("p:only-of-type")        | All <p> elements that are the only child, of its type, of their parent |
| parent > child       | $("div > p")               | All <p> elements that are a direct child of a <div> element |
| parent descendant    | $("div p")                 | All <p> elements that are descendants of a <div> element |
| element + next       | $("div + p")               | The <p> element that are next to each <div> elements   |
| element ~ siblings   | $("div ~ p")               | All <p> elements that appear after the <div> element   |
| :eq(index)           | $("ul li:eq(3)")           | The fourth element in a list (index starts at 0)      |
| :gt(no)              | $("ul li:gt(3)")           | List elements with an index greater than 3            |
| :lt(no)              | $("ul li:lt(3)")           | List elements with an index less than 3               |
| :not(selector)       | $("input:not(:empty)")     | All input elements that are not empty                  |
| :header              | $(":header")               | All header elements <h1>, <h2>, ...                    |
| :animated            | $(":animated")             | All animated elements                                  |
| :focus               | $(":focus")                | The element that currently has focus                   |
| :contains(text)      | $(":contains('Hello')")    | All elements which contains the text "Hello"          |
| :has(selector)       | $("div:has(p)")            | All <div> elements that have a <p> element            |
| :empty               | $(":empty")                | All elements that are empty                            |
| :parent              | $(":parent")               | All elements that are a parent of another element      |
| :hidden              | $("p:hidden")              | All hidden <p> elements                                |
| :visible             | $("table:visible")         | All visible tables                                     |
| :root                | $(":root")                 | The document's root element                            |
| :lang(language)      | $("p:lang(de)")            | All <p> elements with a lang attribute value starting with "de" |
| [attribute]          | $("[href]")                | All elements with a href attribute                     |
| [attribute=value]    | $("[href='default.htm']")  | All elements with a href attribute value equal to "default.htm" |
| [attribute!=value]   | $("[href!='default.htm']") | All elements with a href attribute value not equal to "default.htm" |
| [attribute$=value]   | $("[href$='.jpg']")        | All elements with a href attribute value ending with ".jpg" |
| [attribute|=value]   | $("[title|='Tomorrow']")   | All elements with a title attribute value equal to 'Tomorrow', or starting with 'Tomorrow' followed by a hyphen |
| [attribute^=value]   | $("[title^='Tom']")        | All elements with a title attribute value starting with "Tom" |
| [attribute~=value]   | $("[title~='hello']")      | All elements with a title attribute value containing the specific word "hello" |
| [attribute*=value]   | $("[title*='hello']")      | All elements with a title attribute value containing the word "hello" |
| :input               | $(":input")                | All input elements                                     |
| :text                | $(":text")                 | All input elements with type="text"                    |
| :password            | $(":password")             | All input elements with type="password"                |
| :radio               | $(":radio")                | All input elements with type="radio"                   |
| :checkbox            | $(":checkbox")             | All input elements with type="checkbox"                |
| :submit              | $(":submit")               | All input elements with type="submit"                  |
| :reset               | $(":reset")                | All input elements with type="reset"                   |
| :button              | $(":button")               | All input elements with type="button"                  |
| :image               | $(":image")                | All input elements with type="image"                   |
| :file                | $(":file")                 | All input elements with type="file"                    |
| :enabled             | $(":enabled")              | All enabled input elements                             |
| :disabled            | $(":disabled")             | All disabled input elements
| :selected            | $(":selected")             | All selected input elements
| :checked             | $(":checked")              | All checked input elements
| like                 | $('[id^=partner]')         |  targets all elements whose id attribute starts with the string "partner".it would match elements like <div id="partner1">, <input id="partnerABC">, <select id="partner_xyz">, and so on.
</pre>


    {{-- * val function / insert value / regarding val function   --}}
    {{--  Start Hare  --}}
    <script>
        if (cid == 33) {
            //   alert(cid);
            var location = 'hi';
            document.getElementById("totalhours").value = location;
        }
        if (cid == 33) {
            alert(cid);
            var location = 'hi';
            $('#key').val(location);
        }
    </script>
    {{-- *  --}}

    <script>
        //   $(document).ready(function() {
        $("#timesheet-form").submit(function(e) {
            // Check if the "Client Name" dropdown is selected
            if ($("#client1").val() != "Select Client" && $("#client1").val() != "") {
                // If a client is selected, make the following fields required
                $("#assignment1").prop("required", true);
                $("#partner1").prop("required", true);
                $("#assignment2").prop("required", true);
            }
        });
    </script>
    {{--  Start Hare  --}}
    {{-- * add html dynamically / regarding dynamically html --}}
    {{--  Start Hare  --}}
    {{-- html --}}
    <div class="row row-sm">
        <div class="row row-sm">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Client Name</label>
                    <select class="language form-control refresh" name="client_id[]" id="client1"
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
                    <option value="{{ $clientData->id }}">
                        {{ $clientData->client_name }} ({{ $clientData->client_code }})</option>

                    @endforeach @endif
                        </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Assignment Name</label>
                    <select class="form-control key refreshoption" name="assignment_id[]" id="assignment1">
                        @if (!empty($timesheet->assignment_id))
                            <option value="{{ $timesheet->assignment_id }}">
                                {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                            </option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Partner *</label>
                    <select class="language form-control refreshoption" id="partner1" name="partner[]">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Work Item</label>
                    <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                        class="form-control key workItem1 refresh" rows="2"></textarea>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Location *</label>
                    <input type="text" name="location[]" id="key"
                        value="{{ $timesheet->location ?? '' }}" class="form-control key location1 refresh">
                </div>
            </div>

            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">Hour</label>
                    <input type="number" class="form-control hour1 refresh" id="hour2" min="0"
                        name="hour[]" oninput="calculateTotal(this)"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0"
                        step="1">

                </div>
            </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a href="javascript:void(0);" class="add_button" title="Add field"><img
                            src="{{ url('backEnd/image/add-icon.png') }}" /></a>
                </div>
            </div>
        </div>
        <div class="col-1">
            <div class="form-group" style="margin-top: 36px;">
                <a href="javascript:void(0);" class="add_button" title="Add field"><img
                        src="{{ url('backEnd/image/add-icon.png') }}" /></a>
            </div>
        </div>
    </div>

    {{-- ! ok done --}}
    <script>
        $(document).ready(function() {
            var maxField = 5; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var x = 2;

            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter

                    var fieldHTML = `<div class="row row-sm">
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600">Client Name *</label>
                        <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                            <option value="">Select Client</option>
                            @foreach ($client as $clientData)
                                <option value="{{ $clientData->id }}">
                                    {{ $clientData->client_name }} ({{ $clientData->client_code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600">Assignment Name *</label>
                        <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600">Partner *</label>
                        <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600" style="width:100px;">Work Item *</label>
                        <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label class="font-weight-600" style="width:100px;">Location *</label>
                        <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <label class="font-weight-600">Hour *</label>
                        <input required type="number" class="form-control refresh" id="hour${x}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                        <span style="font-size: 10px;margin-left: 10px;"></span>
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group" style="margin-top: 36px;">
                        <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                    </div>
                </div>
            </div>`;

                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var maxField = 4;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            var x = 1;

            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    var fieldHTML = `<div class="row row-sm">
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Client Name *</label>
                      <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                          <option value="">Select Client</option>
                          @foreach ($client as $clientData)
                              <option value="{{ $clientData->id }}">
                                  {{ $clientData->client_name }} ({{ $clientData->client_code }})
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Assignment Name *</label>
                      <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Partner *</label>
                      <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Work Item *</label>
                      <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Location *</label>
                      <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group">
                      <label class="font-weight-600">Hour *</label>
                      <input required type="number" class="form-control refresh" id="hour${x}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                      <span style="font-size: 10px;margin-left: 10px;"></span>
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group" style="margin-top: 36px;">
                      <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                  </div>
              </div>
          </div>`;

                    $(wrapper).append(fieldHTML);
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).closest('.row-sm').remove();
                x--;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to handle change event for client select
            function handleClientChange(clientId) {
                $('#' + clientId).on('change', function() {
                    var cid = $(this).val();
                    var datepickers = $('#datepickers').val();

                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(res) {
                            $('#' + clientId.replace('client', 'assignment')).html(res);
                        },
                        error: function() {},
                    });
                });
            }

            // Function to handle change event for assignment select
            function handleAssignmentChange(assignmentId) {
                $('#' + assignmentId).on('change', function() {
                    var assignment = $(this).val();

                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: "assignment=" + assignment,
                        success: function(res) {
                            $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                        },
                        error: function() {},
                    });
                });
            }

            // Dynamically add client fields
            var maxField = 4;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            var x = 1;

            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    var fieldHTML = `<div class="row row-sm">
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Client Name *</label>
                      <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                          <option value="">Select Client</option>
                          @foreach ($client as $clientData)
                              <option value="{{ $clientData->id }}">
                                  {{ $clientData->client_name }} ({{ $clientData->client_code }})
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Assignment Name *</label>
                      <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600">Partner *</label>
                      <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                      </select>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Work Item *</label>
                      <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                  </div>
              </div>
              <div class="col-2">
                  <div class="form-group">
                      <label class="font-weight-600" style="width:100px;">Location *</label>
                      <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group">
                      <label class="font-weight-600">Hour *</label>
                      <input required type="number" class="form-control refresh" id="hour${x}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                      <span style="font-size: 10px;margin-left: 10px;"></span>
                  </div>
              </div>
              <div class="col-1">
                  <div class="form-group" style="margin-top: 36px;">
                      <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                  </div>
              </div>
          </div>`;

                    $(wrapper).append(fieldHTML);

                    var clientId = 'client' + x;
                    var assignmentId = 'assignment' + x;

                    handleClientChange(clientId);
                    handleAssignmentChange(assignmentId);
                }
            });

            handleClientChange('client');
            handleClientChange('client1');
            handleAssignmentChange('assignment');
            handleAssignmentChange('assignment1');
        });
    </script>


    <script>
        $(document).ready(function() {
            // Function to handle change event for client select
            function handleClientChange(clientId) {
                $('#' + clientId).on('change', function() {
                    var cid = $(this).val();
                    var datepickers = $('#datepickers').val();

                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(res) {
                            $('#' + clientId.replace('client', 'assignment')).html(res);
                        },
                        error: function() {},
                    });
                });
            }

            // Function to handle change event for assignment select
            function handleAssignmentChange(assignmentId) {
                $('#' + assignmentId).on('change', function() {
                    var assignment = $(this).val();

                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: "assignment=" + assignment,
                        success: function(res) {
                            $('#' + assignmentId.replace('assignment', 'partner')).html(res);
                        },
                        error: function() {},
                    });
                });
            }

            // Dynamically add client fields
            var maxField = 4;
            var addButton = $('.add_button');
            var wrapper = $('.field_wrapper');
            var x = 1;
            var h = 2;

            $(addButton).click(function() {
                if (x < maxField) {
                    x++;
                    h++;
                    var fieldHTML = `<div class="row row-sm">
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Client Name *</label>
                    <select required class="language form-control refresh" name="client_id[]" id="client${x}">
                        <option value="">Select Client</option>
                        @foreach ($client as $clientData)
                            <option value="{{ $clientData->id }}">
                                {{ $clientData->client_name }} ({{ $clientData->client_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Assignment Name *</label>
                    <select class="form-control key refreshoption" name="assignment_id[]" id="assignment${x}">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600">Partner *</label>
                    <select required class="language form-control refreshoption" id="partner${x}" name="partner[]">
                    </select>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Work Item *</label>
                    <textarea required required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}" class="form-control key refresh" rows="2"></textarea>
                </div>
            </div>
            <div class="col-2">
                <div class="form-group">
                    <label class="font-weight-600" style="width:100px;">Location *</label>
                    <input required type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}" class="form-control key refresh">
                </div>
            </div>
            <div class="col-1">
                <div class="form-group">
                    <label class="font-weight-600">Hour *</label>
                    <input required type="number" class="form-control refresh" id="hour${h}" name="hour[]" min="0" oninput="calculateTotal(this)" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">
                    <span style="font-size: 10px;margin-left: 10px;"></span>
                </div>
            </div>
            <div class="col-1">
                <div class="form-group" style="margin-top: 36px;">
                    <a style="margin-top: 36px;" href="javascript:void(0);" class="remove_button"><img src="{{ url('backEnd/image/remove-icon.png') }}"/></a>
                </div>
            </div>
        </div>`;

                    $(wrapper).append(fieldHTML);

                    var clientId = 'client' + x;
                    var assignmentId = 'assignment' + x;

                    handleClientChange(clientId);
                    handleAssignmentChange(assignmentId);
                }
            });

            handleClientChange('client');
            handleClientChange('client1');
            handleAssignmentChange('assignment');
            handleAssignmentChange('assignment1');
        });

        function calculateTotal() {
            var totalSum = 0;
            $('input[name^="hour"]').each(function() {
                totalSum += parseInt($(this).val()) || 0;
            });

            document.getElementById("totalhours").value = totalSum;
        }
    </script>


    {{-- * Regarding date selection / regarding date blocked  --}}
    {{--  Start Hare  --}}
    <!-- End Date Filter -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="form-group">
            <strong><label for="enddate">End Date <span class="text-danger">*</span></label></strong>
            <input required type="date" class="form-control" id="enddate" name="enddate"
                value="{{ old('enddate') }}">
        </div>
    </div>

    <!-- JavaScript to set the max date for end date -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const endDateField = document.getElementById('enddate');
            const today = new Date().toISOString().split('T')[0];
            endDateField.setAttribute('max', today);
        });
    </script>


    <!-- JavaScript to set the max date for end date -->
    {{-- <script>
      document.addEventListener('DOMContentLoaded', function() {
          const endDateField = document.getElementById('enddate');
          const today = new Date().toISOString().split('T')[0];
          endDateField.setAttribute('max', today);
      });
  </script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0]; // Get today's date once

            // Set max date for the Start Date field
            const startdateField = document.getElementById('startdate');
            startdateField.setAttribute('max', today);

            // Set max date for the End Date field
            const endDateField = document.getElementById('enddate');
            endDateField.setAttribute('max', today);
        });
    </script>
    {{--  Start Hare  --}}
    <script>
        $('#client').on('change', function() {
            var cid = $(this).val();
            var date = new Date();
            var day = ("0" + date.getDate()).slice(-2);
            var month = ("0" + (date.getMonth() + 1)).slice(-2);
            var datepickers = day + "-" + month + "-" + date.getFullYear();
            // alert(datepickers);
            $.ajax({
                type: "get",
                url: "{{ url('timesheet/create') }}",
                // data: "cid=" + cid,
                data: {
                    cid: cid,
                    datepickers: datepickers
                },
                success: function(res) {
                    $('#assignment').html(res);
                },
                error: function() {},
            });
        });
    </script>
    {{--  Start Hare  --}}

    @if (Request::is('invoice/create') ||
            Request::is('invoice/*/edit') ||
            Request::is('timesheet/create') ||
            Request::is('attendance'))
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(function() {
                $('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepickers").datepicker({
                    maxDate: new Date,
                    dateFormat: 'dd-mm-yy'
                });
            });

            //     $(function() {
            //      $("#datepickers").datepicker({
            //          maxDate: new Date(), // Restrict future date selection
            //          dateFormat: 'dd-mm-yy' // Set the desired date format
            //      });
            //  });
        </script>
        <script>
            $(function() {
                $('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy'
                });
            });
            //  $(function() {
            //      $("#datepickers").datepicker({
            //          maxDate: new Date,
            //          dateFormat: 'dd-mm-yy'
            //      });
            //  });

            $(function() {
                var startDate = new Date();
                var endDate = new Date();

                $("#datepickers").datepicker({
                    minDate: startDate,
                    maxDate: endDate,
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>

        <script>
            $(function() {
                var startDate = new Date();
                var endDate = new Date();
                endDate.setDate(startDate.getDate() + 7); // Add 7 days to the current date

                $("#datepickers").datepicker({
                    minDate: startDate,
                    maxDate: endDate,
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>
    @endif


    <div class="col-md-5">
        <p style="float: right;color: white"><b>Select Date : </b> <input type="text" id="datepickers"
                name="date" value="{{ date('d-m-Y') }}" readonly></p>
    </div>


    <style>
        tr td:first-child a.ui-state-default {
            background-color: rgb(234, 0, 0) !important;
            color: white !important;
        }
    </style>

    <script>
        $(function() {
            var startDate = new Date();
            $("#datepickers").datepicker({
                maxDate: startDate,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    {{--  Start Hare  --}}

    @if (Request::is('invoice/create') ||
            Request::is('invoice/*/edit') ||
            Request::is('timesheet/create') ||
            Request::is('attendance'))
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(function() {
                $('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepickers").datepicker({
                    maxDate: new Date,
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>
    @endif
    <style>
        td a.ui-state-default {
            background-color: green !important;
            color: white !important;
        }

        td span.ui-state-default {
            background-color: red !important;
            color: white !important;
        }
    </style>

    <script>
        $(function() {
            var startDate = new Date();
            var endDate = new Date();
            endDate.setDate(startDate.getDate() + 6);

            $("#datepickersq").datepicker({
                minDate: startDate,
                maxDate: endDate,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    {{--  Start Hare  --}}
    <div class="col-md-5">
        <p style="float: right;color: white"><b>Select Date : </b> <input type="text" id="datepickersq"
                name="date" value="{{ date('d-m-Y') }}" readonly></p>
    </div>

    <script>
        $(function() {
            var startDate = new Date();
            var endDate = new Date();
            endDate.setDate(startDate.getDate() + 6);

            $("#datepickersq").datepicker({
                minDate: startDate,
                maxDate: endDate,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    {{--  Start Hare  --}}
    <script>
        $(function() {
            var startDate = new Date();
            var endDate = new Date();
            startDate.setDate(startDate.getDate() - 10);
            endDate.setDate(startDate.getDate() + 16);

            $("#datepickersq").datepicker({
                minDate: startDate,
                maxDate: endDate,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    {{--  Start Hare  --}}
    <script>
        // Get the input element by its ID
        const startDateInput = document.getElementById('startdate');

        // Add an event listener to listen for changes in the input value
        startDateInput.addEventListener('change', function() {
            // Get the selected date value
            const selectedDate = new Date(this.value);

            // Format the date to 'yyyy-mm-dd'
            const year = selectedDate.getFullYear();
            const month = ('0' + (selectedDate.getMonth() + 1)).slice(-2); // Add leading zero if needed
            const day = ('0' + selectedDate.getDate()).slice(-2); // Add leading zero if needed

            // Update the input value with the formatted date
            this.value = year + '-' + month + '-' + day;
        });
    </script>
    {{--  Start Hare  --}}
    <script>
        var datepickers = $('#datepickers').val();
        const d = new Date(datepickers);

        // Get the day of the week (0 for Sunday, 1 for Monday, and so on)
        const dayOfWeek = d.getDay();

        // Convert day of the week to a string representation
        let dayString;
        switch (dayOfWeek) {
            case 0:
                dayString = "Sunday";
                break;
            case 1:
                dayString = "Monday";
                break;
            case 2:
                dayString = "Tuesday";
                break;
            case 3:
                dayString = "Wednesday";
                break;
            case 4:
                dayString = "Thursday";
                break;
            case 5:
                dayString = "Friday";
                break;
            case 6:
                dayString = "Saturday";
                break;
            default:
                dayString = "Invalid Day";
        }

        alert("The selected date is on a " + dayString);
    </script>
    {{--  Start Hare  --}}
    <script>
        var datepickers = $('#datepickers').val();
        const d = new Date(datepickers);
        const dayOfWeek = d.getDay();
        const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday",
            "Saturday"
        ];
        const dayString = days[dayOfWeek];

        alert(dayString);
    </script>
    {{--  Start Hare  --}}
    {{--  Start Hare  --}}
    {{--  Start Hare  --}}
    {{-- regarding date formate  --}}
    @if (Request::is('invoice/create') ||
            Request::is('invoice/*/edit') ||
            Request::is('timesheet/create') ||
            Request::is('attendance'))
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(function() {
                $('#datepicker').datepicker({
                    dateFormat: 'dd-mm-yy'
                });
            });
            $(function() {
                $("#datepickers").datepicker({
                    maxDate: new Date,
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>
    @endif
    <script>
        $(function() {
            var startDate = new Date();
            $("#datepickers").datepicker({
                maxDate: startDate,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>

    {{-- resources\views\backEnd\layouts\includes\js.blade.php --}}
    {{-- <script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        });
    });
</script> --}}
    <script>
        $(function() {
            $('#datepicker').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
        $(function() {
            $("#datepickers").datepicker({
                maxDate: new Date,
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
    {{--  Start Hare  --}}
    <script>
        var datepickers = $('#datepickers').val();
        const d = new Date(datepickers);

        const year = d.getFullYear();
        const month = ('0' + (d.getMonth() + 1)).slice(-2); // Add 1 because getMonth() returns zero-based month index
        const day = ('0' + d.getDate()).slice(-2);

        const formattedDate = `${year}/${month}/${day}`;
        console.log(formattedDate); // Output: "2024/05/30"
    </script>


    {{--  Start Hare  --}}
    <script>
        var datepickers = $('#datepickers').val();
        const parts = datepickers.split('-'); // Split the date string into parts
        const formattedDate =
            `${parts[2]}-${parts[1]}-${parts[0]}`; // Rearrange parts to 'YYYY-MM-DD' format
        const d = new Date(formattedDate);
    </script>
    {{--  Start Hare  --}}



    {{-- * Remove extra space  --}}
    {{--  Start Hare  --}}
    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                "pageLength": 14,
                dom: 'Bfrtip',
                "order": [
                    // [2, "desc"]
                ],

                columnDefs: [{
                    targets: [0, 1, 3, 4, 5, 6, 7, 8, 9, 10],
                    orderable: false
                }],

                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Timesheet Save',
                        // remove extra date from column
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 1) {
                                        var cleanedText = $(data).text().trim();
                                        var dateParts = cleanedText.split(
                                            '-');
                                        // Assuming the date format is yyyy-mm-dd
                                        if (dateParts.length === 3) {
                                            return dateParts[2] + '-' + dateParts[1] + '-' +
                                                dateParts[0];
                                        }
                                    }
                                    if (column === 0 || column === 10) {
                                        var cleanedText = $(data).text().trim();
                                        return cleanedText;
                                    }
                                    return data;
                                }
                            }
                        },

                        //  Remove extra space 
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            // remove extra spaces
                            $('c', sheet).each(function() {
                                var originalText = $(this).find('is t').text();
                                var cleanedText = originalText.replace(/\s+/g, ' ')
                                    .trim();
                                $(this).find('is t').text(cleanedText);
                            });
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    {{-- * two table on one page then table implement / column modify / column modification --}}
    {{--  Start Hare  --}}


    <script>
        $(document).ready(function() {
            $('#myTimesheetTable').DataTable({
                dom: 'Bfrtip',
                "order": [
                    // [0, "desc"]
                ],
                columnDefs: [{
                    targets: [0, 2, 3, 4, 5, 6],
                    orderable: false
                }],

                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'My timesheet Request',
                        //   remove extra date from column
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 1) {
                                        var cleanedText = $(data).text().trim();
                                        var dateParts = cleanedText.split(
                                            '-');
                                        // Assuming the date format is yyyy-mm-dd
                                        if (dateParts.length === 3) {
                                            return dateParts[2] + '-' + dateParts[1] + '-' +
                                                dateParts[0];
                                        }
                                    }
                                    if (column === 0 || column === 3) {
                                        var cleanedText = $(data).text().trim();
                                        return cleanedText;
                                    }
                                    return data;
                                }
                            }
                        },
                    },
                    'colvis'
                ]
            });

            $('#teamTimesheetTable').DataTable({
                dom: 'Bfrtip',
                "order": [
                    // [0, "desc"]
                ],
                columnDefs: [{
                    targets: [0, 2, 3, 4, 5, 6],
                    orderable: false
                }],
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Team timesheet Request',

                        //   remove extra date from column
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 1) {
                                        var cleanedText = $(data).text().trim();
                                        var dateParts = cleanedText.split(
                                            '-');
                                        // Assuming the date format is yyyy-mm-dd
                                        if (dateParts.length === 3) {
                                            return dateParts[2] + '-' + dateParts[1] + '-' +
                                                dateParts[0];
                                        }
                                    }
                                    if (column === 0 || column === 3) {
                                        var cleanedText = $(data).text().trim();
                                        return cleanedText;
                                    }
                                    return data;
                                }
                            }
                        },

                    },
                    'colvis'
                ]
            });
        });
    </script>
    {{--  Start Hare  --}}
    <style>
        .dt-buttons {
            margin-bottom: -34px;
        }

        #teamTimesheetTable {
            width: 100% !important;

        }
    </style>
    <script>
        $(document).ready(function() {
            $('#myTimesheetTable').DataTable({
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],

                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Timesheet_Download',

                    },
                    'colvis'
                ]
            });

            $('#teamTimesheetTable').DataTable({
                dom: 'Bfrtip',
                "order": [
                    [0, "desc"]
                ],
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Timesheet_Download',

                    },
                    'colvis'
                ]
            });
        });
    </script>

    {{-- * hide button  --}}
    {{--  start hare --}}
    <style>
        .dt-buttons {
            margin-bottom: -34px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                // 'l' for the length menu
                dom: 'Bfrtip',
                // "order": [
                //     [0, "ASC"]
                // ],
                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                    buttons: [{
                            extend: 'excelHtml5',
                            filename: 'Team List',
                        },
                        'colvis'
                    ]
                @else
                    buttons: []
                @endif
            });
        });
    </script>

    {{--  start har --}}

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                "pageLength": 10,
                "dom": '1Bfrtip',
                "order": [
                    [1, "desc"]
                ],

                buttons: [{
                    extend: 'excelHtml5',
                    exportOptions: {
                        columns: ':visible'
                    },
                    text: 'Export to Excel',
                    className: 'btn-excel',
                }, ]
            });

            $('.btn-excel').hide();
        });
    </script>
    {{--  start har --}}
    <style>
        .dt-buttons {
            margin-bottom: -34px;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                    // 'l' for the length menu
                    dom: 'lBfrtip',
                    buttons: [{
                            extend: 'excelHtml5',
                            filename: 'Team List',
                        },
                        'colvis'
                    ]
                @else
                    buttons: []
                @endif
            });
        });
    </script>

    {{-- * accending order on date   --}}

    <td> <span style="display: none;">
            {{ date('Y-m-d', strtotime($timesheetDatas->date)) }}</span>{{ date('d-m-Y', strtotime($timesheetDatas->date)) }}
    </td>
    {{-- understanding code --}}
    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [],
                searching: false,
                @if (Auth::user()->role_id == 11 ||
                        Request::is('adminsearchtimesheet') ||
                        (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                    columnDefs: [{
                        targets: [1, 2, 4, 5, 6, 7, 8, 9],
                        orderable: false
                    }],
                @else
                    columnDefs: [{
                        targets: [1, 3, 4, 5, 6, 7, 8, 9],
                        orderable: false
                    }],
                @endif
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Timesheet_Download',
                        //   remove extra date from column
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    // If the data is a date, extract the date without HTML tags
                                    if (column === 2) {
                                        // data = <span style="display: none;"> 2024-02-26</span>26-02-2024
                                        var cleanedText = $(data).text().trim();
                                        //   2024-02-26
                                        var dateParts = cleanedText.split(
                                            '-');
                                        //   20240226
                                        //   2,02,40,226
                                        // Assuming the date format is yyyy-mm-dd
                                        //   dateParts.length = 3 hai 
                                        if (dateParts.length === 3) {
                                            //   return dateParts[2] + '-' + dateParts[1] + '-' +
                                            //       dateParts[0];
                                            //  for testing
                                            //   return dateParts[0];
                                            //   dateParts[2]= 26
                                            //   dateParts[1]= 02
                                            //   dateParts[0]= 2024
                                        }
                                    }
                                    return data;
                                }
                            }
                        },
                        //   set width in excell
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            // set column width
                            $('col', sheet).eq(0).attr('width', 15);
                            $('col', sheet).eq(1).attr('width', 15);
                            $('col', sheet).eq(3).attr('width', 30);
                            $('col', sheet).eq(4).attr('width', 30);
                            $('col', sheet).eq(5).attr('width', 30);
                            $('col', sheet).eq(6).attr('width', 30);
                            $('col', sheet).eq(7).attr('width', 30);

                            // remove extra spaces
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

    {{-- clean code  --}}

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [],
                searching: false,
                @if (Auth::user()->role_id == 11 ||
                        Request::is('adminsearchtimesheet') ||
                        (Auth::user()->role_id == 13 && Request::is('admintimesheetlist')))
                    columnDefs: [{
                        targets: [1, 2, 4, 5, 6, 7, 8, 9],
                        orderable: false
                    }],
                @else
                    columnDefs: [{
                        targets: [1, 3, 4, 5, 6, 7, 8, 9],
                        orderable: false
                    }],
                @endif
                buttons: [{
                        extend: 'excelHtml5',
                        filename: 'Timesheet_Download',

                        //   remove extra date from column
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    // If the data is a date, extract the date without HTML tags
                                    if (column === 2) {
                                        var cleanedText = $(data).text().trim();
                                        var dateParts = cleanedText.split(
                                            '-');
                                        // Assuming the date format is yyyy-mm-dd
                                        if (dateParts.length === 3) {
                                            return dateParts[2] + '-' + dateParts[1] + '-' +
                                                dateParts[0];
                                        }
                                    }
                                    return data;
                                }
                            }
                        },

                        //   set width in excell
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            // set column width
                            $('col', sheet).eq(0).attr('width', 15);
                            $('col', sheet).eq(1).attr('width', 15);
                            $('col', sheet).eq(3).attr('width', 30);
                            $('col', sheet).eq(4).attr('width', 30);
                            $('col', sheet).eq(5).attr('width', 30);
                            $('col', sheet).eq(6).attr('width', 30);
                            $('col', sheet).eq(7).attr('width', 30);

                            // remove extra spaces
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

    {{-- * on click button  --}}
    <div class="col-1">
        <div class="form-group" style="margin-top: 36px;">
            <a href="javascript:void(0);" class="add_button" title="Add field"><img
                    src="{{ url('backEnd/image/add-icon.png') }}" /></a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var x = 1;
            var fieldHTML = `
        <div class="row row-sm">
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Client Name</label>
              <select class="language form-control refresh" name="client_id[]" id="client4"
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
                  <option value="{{ $clientData->id }}">
                      {{ $clientData->client_name }} ({{ $clientData->client_code }})</option>

                  @endforeach @endif
                  </select>
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Assignment Name</label>
              <select class="form-control key refreshoption" name="assignment_id[]" id="assignment4">
                  @if (!empty($timesheet->assignment_id))
                      <option value="{{ $timesheet->assignment_id }}">
                          {{ App / Models / Assignment::where('id', $timesheet->assignment_id)->first()->assignment_name ?? '' }}
                      </option>
                  @endif
              </select>
              <!-- <select class="form-control key refreshoption" name="assignment_id[]" id="assignment">
           <option disabled style="display:block">Select
              Assignment
              </option>
              
          </select> -->



          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600">Partner *</label>
              <select class="language form-control refreshoption" id="partner4" name="partner[]">
              </select>
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600" style="width:100px;">Work Item</label>
              <textarea type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
                  class="form-control key workItem4 refresh" rows="2"></textarea>
          </div>
      </div>
      <div class="col-2">
          <div class="form-group">
              <label class="font-weight-600" style="width:100px;">Location *</label>
              <input type="text" name="location[]" id="key" value="{{ $timesheet->location ?? '' }}"
                  class="form-control key Location4 refresh">
          </div>
      </div>

      <div class="col-1">
          <div class="form-group">
              <label class="font-weight-600">Hour</label>
              <input type="number" class="form-control hour4 refresh" id="hour5" min="0"
                  name="hour[]" oninput="calculateTotal(this)"
                  onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="0" step="1">

          </div>
      </div>
      <div class="col-1">
          <div class="form-group" style="margin-top: 36px;">
              <a href="javascript:void(0);" class="add_button" title="Add field"><img
                      src="{{ url('backEnd/image/add-icon.png') }}" /></a>
          </div>
      </div>
  </div>
`;

            //Once add button is clicked
            $(addButton).click(function() {
                //Check maximum number of input fields
                if (x < maxField) {
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e) {
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
    </script>

    {{-- * regarding pure javascript / regarding javascript   --}}

    <script type="text/javascript">
        function sum() {

            var hour1 = document.getElementById('hour1').value;
            // alert(hour1);
            var hour2 = document.getElementById('hour2').value;
            var hour3 = document.getElementById('hour3').value;
            var hour4 = document.getElementById('hour4').value;
            var hour5 = document.getElementById('hour5').value;
            //  alert(hour2);
            var result = parseFloat(hour1) + parseFloat(hour2) + parseFloat(hour3) + parseFloat(hour4) + parseFloat(
                hour5);
            //alert(result);
            if (!isNaN(result)) {
                document.getElementById('totalhours').value = result;
            }
        }
    </script>
    {{-- * regarding option tag   --}}

    <script>
        $(function() {
            $('#datepickers').on('change', function() {
                var refreshpage = $('.refresh');
                refreshpage.val('');
                $('.refreshoption option').remove();
            });
        });
    </script>

    {{-- * navbar / regarding navbar/ regarding url  --}}

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const menuItems = document.querySelectorAll('nav.sidebar-nav li a');
            const currentUrl = document.URL;

            menuItems.forEach((link) => {
                const href = link.href;

                if (href === currentUrl) {
                    $(link).attr("aria-expanded", "true");

                    const parent = link.closest("li");
                    $(parent).addClass("mm-active").css({
                        "background-color": "#37a000",
                        "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                    });

                    const secondLevel = parent.querySelector("ul.nav-second-level");
                    const thirdLevel = parent.querySelector("ul.nav-third-level");

                    if (secondLevel) {
                        const parentMenu = secondLevel.closest("li");
                        $(parentMenu).addClass("mm-active").css({
                            "background-color": "#37a000",
                            "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                        });
                        secondLevel.classList.add("mm-show");
                    }

                    if (thirdLevel) {
                        $(thirdLevel).addClass("mm-show");

                        const secondLevel = thirdLevel.closest("ul.nav-second-level");
                        const parentMenu = secondLevel.closest("li");
                        $(parentMenu).addClass("mm-active").css({
                            "background-color": "#37a000",
                            "box-shadow": "0 0 10px 1px rgba(55, 160, 0, .7)"
                        });
                        secondLevel.classList.add("mm-show");
                    }
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function validateDateRange(startSelector, endSelector, errorMessage) {
                var startDateInput = $(startSelector);
                var endDateInput = $(endSelector);

                function compareDates() {
                    var startDate = new Date(startDateInput.val());
                    var endDate = new Date(endDateInput.val());

                    if (startDate > endDate) {
                        alert(errorMessage);
                        endDateInput.val('');
                    }
                }

                startDateInput.on('input', compareDates);
                endDateInput.on('blur', compareDates);
            }

            function validateYearInput(inputSelector) {
                $(inputSelector).on('change', function() {
                    var input = $(this);
                    var dateValue = new Date(input.val());
                    var year = dateValue.getFullYear();
                    if (year.toString().length > 4) {
                        alert('Enter four digits for the year');
                        input.val('');
                    }
                });
            }

            // Apply date range validation
            validateDateRange('#start1', '#end1',
                "'End Request Date' should be greater than or equal to the 'Start Request Date'");
            validateDateRange('#startperiod1', '#endperiod1',
                "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

            // Apply year validation
            validateYearInput('#start1');
            validateYearInput('#end1');
            validateYearInput('#startperiod1');
            validateYearInput('#endperiod1');


            // Validation on submit button click 
            $('form').submit(function(event) {
                var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                    '#endperiod1'
                ];

                var allEmpty = fields.every(function(selector) {
                    return $(selector).val() === "";
                });

                if (allEmpty) {
                    alert("Please select data for filter");
                    event.preventDefault(); // Prevent form submission if all fields are empty
                }

                // Validate date pairs
                var startDate = $('#start1').val();
                var endDate = $('#end1').val();
                var startPeriod = $('#startperiod1').val();
                var endPeriod = $('#endperiod1').val();

                function validateDatePair(start, end, asteriskId, message) {
                    if (start && !end) {
                        alert(message);
                        $(asteriskId).removeClass("d-none"); // Show the asterisk
                        event.preventDefault();
                        return false;
                    }
                    $(asteriskId).addClass("d-none"); // Hide the asterisk if validation passes
                    return true;
                }

                // Validate both date ranges and show the corresponding asterisk
                if (!validateDatePair(startDate, endDate, "#endDateAsterisk",
                        "Please select an 'End Request Date'.") ||
                    !validateDatePair(startPeriod, endPeriod, "#endPeriodAsterisk",
                        "Please select an 'End Leave Period'.")) {
                    return; // Stop if any validation fails
                }
                // Validate date pairs end hare 

            });
        });
    </script>


    {{-- <script>
    $(document).ready(function() {
        var currentUrl = window.location.href;

        $('.metismenu li a').each(function() {
            var $this = $(this);
            var href = $this.prop('href');

            if (href === currentUrl) {
                console.log('Match found! Adding mm-active2 class.');
                $this.addClass('mm-active2');
            }
        });
    });
</script> --}}


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const menuItems = document.querySelectorAll('nav.sidebar-nav li a');
            const currentUrl = document.URL;

            menuItems.forEach((link) => {
                const href = link.href;

                if (href === currentUrl) {
                    link.setAttribute("aria-expanded", "true");

                    const parent = link.closest("li");
                    parent.classList.add("mm-active");
                    parent.style.backgroundColor = "green";
                    parent.style.boxShadow = "0 0 10px 1px rgba(55, 160, 0, .7)";

                    const secondLevel = parent.querySelector("ul.nav-second-level");
                    const thirdLevel = parent.querySelector("ul.nav-third-level");

                    if (secondLevel) {
                        const parentMenu = secondLevel.closest("li");
                        parentMenu.classList.add("mm-active");
                        parentMenu.style.backgroundColor = "green";
                        parentMenu.style.boxShadow = "0 0 10px 1px rgba(55, 160, 0, .7)";
                        secondLevel.classList.add("mm-show");
                    }

                    if (thirdLevel) {
                        thirdLevel.classList.add("mm-show");

                        const secondLevel = thirdLevel.closest("ul.nav-second-level");
                        const parentMenu = secondLevel.closest("li");
                        parentMenu.classList.add("mm-active");
                        parentMenu.style.backgroundColor = "green";
                        parentMenu.style.boxShadow = "0 0 10px 1px rgba(55, 160, 0, .7)";
                        secondLevel.classList.add("mm-show");
                    }
                }
            });
        });
    </script>


    {{-- * php in javascript  / regarding php  --}}

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [
                    //   [0, "DESC"]
                    //   [2, "DESC"]
                ],
                searching: false,

                @if (Auth::user()->role_id == 11 || Auth::user()->role_id == 13)
                    columnDefs: [{
                        targets: [1, 2, 4, 5, 6, 7, 8, 9],
                        orderable: false
                    }],
                @else
                    columnDefs: [{
                        targets: [1, 3, 4, 5, 6, 7, 8, 9],
                        orderable: false
                    }],
                @endif

                buttons: [{
                        extend: 'excelHtml5',
                        //   enabled: false,
                        filename: 'Timesheet_Download',
                        exportOptions: {
                            columns: ':visible'
                        },

                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            //   set column width
                            $('col', sheet).eq(0).attr('width', 15);
                            $('col', sheet).eq(1).attr('width', 15);
                            $('col', sheet).eq(3).attr('width', 30);
                            $('col', sheet).eq(4).attr('width', 30);
                            $('col', sheet).eq(5).attr('width', 30);
                            $('col', sheet).eq(6).attr('width', 30);
                            $('col', sheet).eq(7).attr('width', 30);
                            //   remove extra spaces
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
            $('#category7').change(function() {
                var search7 = $(this).val();
                var search4 = $('#category4').val();
                var search1 = $('#category1').val();

                var filterUrl = '';
                @if (Auth::user()->role_id == 13 && Request::is('timesheet/teamlist'))
                    filterUrl = '/filter-patnerteam';
                @elseif (Auth::user()->role_id == 11)
                    filterUrl = '/filter-dataadmin';
                @endif

                // Send an AJAX request to fetch filtered data based on the selected partner
                $.ajax({
                    type: 'GET',
                    //   url: '/filter-dataadmin',
                    url: filterUrl,
                    data: {
                        teamname: search7,
                        partnersearch: search1,
                        totalhours: search4
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html(""); // Clear the table body
                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="5" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/weeklylist?id=' + item.id +
                                    '&teamid=' + item.teamid +
                                    '&partnerid=' + item.partnerid +
                                    '&startdate=' + item.startdate +
                                    '&enddate=' + item.enddate;

                                // Format created_at date
                                var formattedDate = moment(item.created_at).format(
                                    'DD-MM-YYYY');
                                var formattedTime = moment(item.created_at).format(
                                    'hh:mm A');

                                // Add the rows to the table
                                $('table tbody').append('<tr>' +
                                    '<td><a href="' + url + '">' + item
                                    .team_member +
                                    '</a></td>' +
                                    '<td>' + item.week + '</td>' +
                                    '<td>' + formattedDate + ' ' + formattedTime +
                                    '</td>' +
                                    '<td>' + item.totaldays + '</td>' +
                                    '<td>' + item.totaltime + '</td>' +
                                    //   '<td>' + item.partnername + '</td>' +
                                    '</tr>');
                            });
                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });
        });
    </script>
    {{-- * regarding datatable / regarding filter / regarding basic class / regarding button  --}}



    {{-- button name in text  --}}

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [
                    //   [0, "DESC"]
                    //   [2, "DESC"]
                ],
                layout: {
                    topStart: 'buttons'
                },
                buttons: [{
                    extend: 'copy',
                    text: 'Copy to clipboard'
                }]
            });
        });
    </script>


    {{-- print button  --}}
    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [
                    //   [0, "DESC"]
                    //   [2, "DESC"]
                ],
                layout: {
                    topStart: 'buttons'
                },
                buttons: [{
                    extend: 'print',
                    name: 'print'
                }]
            });
        });
    </script>

    {{--  no need to script code only need jquery like  --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script> --}}

    <script>
        // no need to script code only need jquery like 
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [
                    //   [0, "DESC"]
                    //   [2, "DESC"]
                ],
                searching: false,
                buttons: [
                    'colvis',
                    'excel',
                    'print'
                ]
            });
        });
    </script>




    {{-- remove basic class and add examplee id --}}
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                "order": [
                    //   [2, "desc"]
                ],
                //   searching: false,
                columnDefs: [{
                    targets: [0, 3, 4],
                    orderable: false
                }],
                buttons: []
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                //   dom: 'Bfrtip',
                //   dom: 'lrtip',
                //   dom: '<"wrapper"flipt>',
                dom: '<"top"i>rt<"bottom"flp><"clear">',
                //   dom: '<lf<t>ip>',
                //   dom: 'Blfrtip',
                "order": [
                    [0, "desc"]
                ],
                buttons: []
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [], // Disable initial sorting

                columnDefs: [{
                        targets: [4],
                        orderable: false
                    } // Disable sorting for the fifth column (Total Hour)
                ],

                //   buttons: [{
                //           extend: 'copyHtml5',
                //           exportOptions: {
                //               columns: [0, ':visible']
                //           }
                //       },
                //       {
                //           extend: 'excelHtml5',
                //   enabled: false,
                //           exportOptions: {
                //               columns: ':visible'
                //           }
                //       },
                //       {
                //           extend: 'pdfHtml5',
                //           exportOptions: {
                //               columns: [0, 1, 2, 5]
                //           }
                //       },
                //       'colvis'
                //   ]
            });
        });
    </script>
    {{-- *  --}}
    <script>
        $(function() {
            $('#client1').on('change', function() {
                var cid = $(this).val();
                // alert(category_id);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    data: "cid=" + cid,
                    success: function(res) {
                        $('#assignment1').html(res);
                    },
                    error: function() {},
                });
            });
        });
    </script>
    {{-- * form on submit / regarding submit   --}}
    <style>
        .dt-buttons {
            margin-bottom: -34px;
        }
    </style>
    {{-- ! 29-01-24 --}}
    {{-- <script>
    $(document).ready(function() {
        $('#examplee').DataTable({
            dom: 'Bfrtip',
            "order": [
                //   [0, "DESC"]
                //   [2, "DESC"]
            ],
            buttons: [{
                    extend: 'copyHtml5',
                    exportOptions: {
                        columns: [0, ':visible']
                    }
                },
                {
                    extend: 'excelHtml5',
                       //   enabled: false,
                    filename: 'Timesheet_Download',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    filename: 'Timesheet Download',
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                },
                'colvis'
            ]
        });
    });
</script> --}}


    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "order": [
                    //   [0, "DESC"]
                    //   [2, "DESC"]
                ],
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        //   enabled: false,
                        filename: 'Timesheet_Download',
                        exportOptions: {
                            columns: ':visible'
                        },

                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];

                            //   set column width
                            $('col', sheet).eq(0).attr('width', 15);
                            $('col', sheet).eq(1).attr('width', 15);
                            $('col', sheet).eq(3).attr('width', 30);
                            $('col', sheet).eq(4).attr('width', 30);
                            $('col', sheet).eq(5).attr('width', 30);
                            $('col', sheet).eq(6).attr('width', 30);
                            $('col', sheet).eq(7).attr('width', 30);
                            //   remove extra spaces
                            $('c', sheet).each(function() {
                                var originalText = $(this).find('is t').text();
                                var cleanedText = originalText.replace(/\s+/g, ' ').trim();
                                $(this).find('is t').text(cleanedText);
                            });
                        }
                    },

                    {
                        extend: 'pdfHtml5',
                        filename: 'Timesheet Download',
                        exportOptions: {
                            columns: [1, 2, 3, 4, 5]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>


    {{-- validation for comparision date and block year for 4 disit optimize this code --}}
    <form method="POST" action="{{ url('/filtering-applyleve') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <!-- Employee Dropdown -->
            <div class="col-3">
                <div class="form-group">
                    <strong><label for="employee">Employee</label></strong>
                    <select class="form-control" id="employee1" name="employee">
                        <option value="">Please Select One</option>
                        @php $displayedValues = []; @endphp
                        @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                            @if (!in_array($applyleaveDatas->emailid, $displayedValues))
                                <option value="{{ $applyleaveDatas->createdby }}"
                                    {{ old('employee') == $applyleaveDatas->createdby ? 'selected' : '' }}>
                                    {{ $applyleaveDatas->team_member }}
                                    ({{ $applyleaveDatas->newstaff_code ?? ($applyleaveDatas->staffcode ?? '') }})
                                </option>
                                @php $displayedValues[] = $applyleaveDatas->emailid; @endphp
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Leave Type Dropdown -->
            <div class="col-3">
                <div class="form-group">
                    <strong><label for="leave">Leave Type</label></strong>
                    <select class="form-control" id="leave1" name="leave">
                        <option value="">Please Select One</option>
                        @php $displayedValues = []; @endphp
                        @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                            @if (!in_array($applyleaveDatas->name, $displayedValues))
                                <option value="{{ $applyleaveDatas->leavetype }}"
                                    {{ old('leave') == $applyleaveDatas->leavetype ? 'selected' : '' }}>
                                    {{ $applyleaveDatas->name }}
                                </option>
                                @php $displayedValues[] = $applyleaveDatas->name; @endphp
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Status Dropdown -->
            <div class="col-3">
                <div class="form-group">
                    <strong><label for="status">Status</label></strong>
                    <select class="form-control" id="status1" name="status">
                        <option value="">Please Select One</option>
                        @php $displayedValues = []; @endphp
                        @foreach ($teamapplyleaveDatasfilter as $applyleaveDatas)
                            @if (!in_array($applyleaveDatas->status, $displayedValues))
                                <option value="{{ $applyleaveDatas->status }}">
                                    {{ $applyleaveDatas->status == 0 ? 'Created' : ($applyleaveDatas->status == 1 ? 'Approved' : 'Rejected') }}
                                </option>
                                @php $displayedValues[] = $applyleaveDatas->status; @endphp
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Request Date Range -->
            <div class="col-3">
                <div class="form-group">
                    <strong><label for="start">Start Request Date</label></strong>
                    <input type="date" class="form-control" id="start1" name="start"
                        value="{{ old('start') }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <strong><label for="end">End Request Date</label></strong>
                    <input type="date" class="form-control" id="end1" name="end"
                        value="{{ old('end') }}">
                </div>
            </div>

            <div class="col-3">
                <div class="form-group">
                    <strong><label for="startperiod">Start Leave Period</label></strong>
                    <input type="date" class="form-control" id="startperiod1" name="startperiod"
                        value="{{ old('startperiod') }}">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <strong><label for="endperiod">End Leave Period</label></strong>
                    <input type="date" class="form-control" id="endperiod1" name="endperiod"
                        value="{{ old('endperiod') }}">
                </div>
            </div>

            <!-- Search Button -->
            <div class="col-md-2 col-sm-6 mb-3">
                <div class="form-group">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-success btn-block">Search</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            function validateDateRange(startSelector, endSelector, errorMessage) {
                var startDateInput = $(startSelector);
                var endDateInput = $(endSelector);

                function compareDates() {
                    var startDate = new Date(startDateInput.val());
                    var endDate = new Date(endDateInput.val());

                    if (startDate > endDate) {
                        alert(errorMessage);
                        endDateInput.val('');
                    }
                }

                startDateInput.on('input', compareDates);
                endDateInput.on('blur', compareDates);
            }

            function validateYearInput(inputSelector) {
                $(inputSelector).on('change', function() {
                    var input = $(this);
                    var dateValue = new Date(input.val());
                    var year = dateValue.getFullYear();
                    if (year.toString().length > 4) {
                        alert('Enter four digits for the year');
                        input.val('');
                    }
                });
            }

            // Apply date range validation
            validateDateRange('#start1', '#end1',
                "'End Request Date' should be greater than or equal to the 'Start Request Date'");
            validateDateRange('#startperiod1', '#endperiod1',
                "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

            // Apply year validation
            validateYearInput('#start1');
            validateYearInput('#end1');
            validateYearInput('#startperiod1');
            validateYearInput('#endperiod1');

            $('form').submit(function(event) {
                var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                    '#endperiod1'
                ];
                var allEmpty = fields.every(function(selector) {
                    return $(selector).val() === "";
                });

                if (allEmpty) {
                    alert("Please select any input");
                    event.preventDefault(); // Prevent form submission if all fields are empty
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function validateDateRange(startSelector, endSelector, errorMessage) {
                var startDateInput = $(startSelector);
                var endDateInput = $(endSelector);

                function compareDates() {
                    var startDate = new Date(startDateInput.val());
                    var endDate = new Date(endDateInput.val());

                    if (startDate > endDate) {
                        alert(errorMessage);
                        endDateInput.val(''); // Clear the end date input
                    }
                }

                startDateInput.on('input', compareDates);
                endDateInput.on('blur', compareDates);
            }

            function validateYearInput(inputSelector) {
                $(inputSelector).on('change', function() {
                    var input = $(this);
                    var dateValue = new Date(input.val());
                    var year = dateValue.getFullYear();
                    if (year.toString().length > 4) {
                        alert('Enter four digits for the year');
                        input.val('');
                    }
                });
            }

            // Apply date range validation
            validateDateRange('#start1', '#end1',
                "'End Request Date' should be greater than or equal to the 'Start Request Date'");
            validateDateRange('#startperiod1', '#endperiod1',
                "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

            // Apply year validation
            validateYearInput('#start1');
            validateYearInput('#end1');
            validateYearInput('#startperiod1');
            validateYearInput('#endperiod1');
        });
    </script>
    <script>
        $(document).ready(function() {
            // Validation on submit button click
            $('form').submit(function(event) {
                var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                    '#endperiod1'
                ];

                // Check if all fields are empty
                var allEmpty = fields.every(selector => !$(selector).val());

                if (allEmpty) {
                    alert("Please select any input");
                    event.preventDefault(); // Prevent form submission if all fields are empty
                    return;
                }

                var startDate = $('#start1').val();
                var endDate = $('#end1').val();
                var startPeriod = $('#startperiod1').val();
                var endPeriod = $('#endperiod1').val();

                // Create a reusable function to validate date pairs
                function validateDatePair(start, end, message) {
                    if (start && !end) {
                        alert(message);
                        event.preventDefault();
                        return false;
                    }
                    return true;
                }

                // Validate both date ranges
                if (!validateDatePair(startDate, endDate, "Please select an 'End Request Date'.") ||
                    !validateDatePair(startPeriod, endPeriod, "Please select an 'End Leave Period'.")) {
                    return; // Stop if any validation fails
                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // Validation on submit button click
            // Validation on submit button click
            $('form').submit(function(event) {
                var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                    '#endperiod1'
                ];

                // Check if all fields are empty
                var allEmpty = fields.every(function(selector) {
                    return $(selector).val() === "";
                });

                if (allEmpty) {
                    alert("Please select any input");
                    event.preventDefault(); // Prevent form submission if all fields are empty
                    return;
                }

                var startDate = $('#start1').val();
                var endDate = $('#end1').val();

                var startPeriod = $('#startperiod1').val();
                var endPeriod = $('#endperiod1').val();

                // Validate if startDate is provided but endDate is missing
                if (startDate && !endDate) {
                    alert("Please select an 'End Request Date'.");
                    event.preventDefault();
                    return;
                }

                // Validate if startPeriod is provided but endPeriod is missing
                if (startPeriod && !endPeriod) {
                    alert("Please select an 'End Leave Period'.");
                    event.preventDefault();
                    return;
                }
            });


        });
    </script>


    <script>
        $(document).ready(function() {
            // Function to validate date range
            function validateDateRange(startSelector, endSelector, errorMessage) {
                var startDateInput = $(startSelector);
                var endDateInput = $(endSelector);

                function compareDates() {
                    var startDate = new Date(startDateInput.val());
                    var endDate = new Date(endDateInput.val());

                    if (startDate > endDate) {
                        alert(errorMessage);
                        endDateInput.val(''); // Clear the end date input
                    }
                }

                startDateInput.on('input', compareDates);
                endDateInput.on('blur', compareDates);
            }

            // Function to validate year input
            function validateYearInput(inputSelector) {
                $(inputSelector).on('change', function() {
                    var input = $(this);
                    var year = new Date(input.val()).getFullYear();
                    if (year.toString().length > 4) {
                        alert('Enter four digits for the year');
                        input.val(''); // Clear the invalid year input
                    }
                });
            }

            // Apply date range validation
            validateDateRange('#start1', '#end1',
                "'End Request Date' should be greater than or equal to the 'Start Request Date'");
            validateDateRange('#startperiod1', '#endperiod1',
                "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

            // Apply year validation for all date inputs
            ['#start1', '#end1', '#startperiod1', '#endperiod1'].forEach(validateYearInput);

            // Form submit validation
            $('form').submit(function(event) {
                var fields = ['#employee1', '#leave1', '#status1', '#start1', '#end1', '#startperiod1',
                    '#endperiod1'
                ];
                var allEmpty = fields.every(function(selector) {
                    return $(selector).val() === "";
                });

                if (allEmpty) {
                    alert("Please select any input");
                    event.preventDefault(); // Prevent form submission if all fields are empty
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                var employee = $('#employee1').val();
                var leave = $('#leave1').val();
                var status = $('#status1').val();
                var startDate = $('#start1').val();
                var endDate = $('#end1').val();
                var startPeriod = $('#startperiod1').val();
                var endPeriod = $('#endperiod1').val();

                if (employee === "" && leave === "" && status === "" && startDate === "" && endDate ===
                    "" &&
                    startPeriod === "" && endPeriod === "") {
                    alert("Please select Any input ");
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>




    <script>
        $(document).ready(function() {
            var startDateInput = $('#start1');
            var endDateInput = $('#end1');

            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert("'End Request Date' should be greater than or equal to the 'Start Request Date'");
                    endDateInput.val(''); // Clear the end date input
                }
            }

            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#start1').on('change', function() {
                var startclear = $('#start1');
                var startDateInput1 = $('#start1').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
            });
            $('#end1').on('change', function() {
                var endclear = $('#end1');
                var endDateInput1 = $('#end1').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
            });
        });
    </script>

    {{-- End leave period date and Start Leave Period date validation --}}
    <script>
        $(document).ready(function() {
            var startDateInput = $('#startperiod1');
            var endDateInput = $('#endperiod1');

            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert(
                        "'End leave period date' should be greater than or equal to the 'Start Leave Period date'"
                    );
                    endDateInput.val('');
                }
            }

            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#startperiod1').on('change', function() {
                var startclear = $('#startperiod1');
                var startDateInput1 = $('#startperiod1').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
            });
            $('#endperiod1').on('change', function() {
                var endclear = $('#endperiod1');
                var endDateInput1 = $('#endperiod1').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
            });
        });
    </script>
    {{-- Include jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            var startDateInput = $('#startdate');
            var endDateInput = $('#enddate');

            // Function to compare start and end dates
            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert('End date should be greater than or equal to the Start date');
                    endDateInput.val(''); // Clear the end date input
                }
            }

            // Function to validate the year length
            function validateYear(input) {
                var date = new Date(input.val());
                var year = date.getFullYear();

                if (year.toString().length > 4) {
                    alert('Enter four digits for the year');
                    input.val(''); // Clear the invalid date
                }
            }

            // Attach event listeners
            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);

            startDateInput.on('change', function() {
                validateYear(startDateInput);
            });

            endDateInput.on('change', function() {
                validateYear(endDateInput);
            });
        });
    </script>

    {{-- validation for comparision date and block year for 4 disit --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var startDateInput = $('#startdate');
            var endDateInput = $('#enddate');

            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert('End date should be greater than or equal to the Start date');
                    endDateInput.val(''); // Clear the end date input
                }
            }

            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);
        });
    </script>

    {{-- validation for block 4 digit to  year --}}

    <script>
        $(document).ready(function() {
            $('#startdate').on('change', function() {
                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
            });

            $('#enddate').on('change', function() {
                var endclear = $('#enddate');
                var endDateInput1 = $('#enddate').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
            });

            //   condition on submit
            $('form').submit(function(event) {
                var year = $('#year').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();

                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearvalue = $('#year').val();
                if (year && startdate) {
                    if (yearvalue != startyear) {
                        alert('Enter Start Date According Year');
                        startclear.val('');
                        // Prevent form submission
                        event.preventDefault();
                        // Exit the function
                        return;
                    }
                }

                var endclear = $('#enddate');
                var endDateInput1 = $('#enddate').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var yearvalue = $('#year').val();
                if (year && enddate) {
                    if (yearvalue != endyear) {
                        alert('Enter End Date According Year');
                        endclear.val('');
                        // Prevent form submission
                        event.preventDefault();
                        // Exit the function
                        return;
                    }
                }

                if (year === "" && startdate === "" && enddate === "") {
                    alert("Please select year.");
                    event.preventDefault();
                    return;
                }
                if (startdate !== "" && enddate === "") {
                    alert("Please select End date.");
                    event.preventDefault();
                    return;
                }
                //   if (year !== "" && startdate !== "" && enddate === "") {
                //       alert("Please select End date.");
                //       event.preventDefault();
                //       return;
                //   }
                //   if (startdate !== "" && enddate !== "" && year === "") {
                //       alert("Please select Year.");
                //       event.preventDefault();
                //       return;
                //   }
            });
        });
    </script>
    {{-- *regarding form submit --}}
    <script>
        $(document).ready(function() {
            $('#startdate').on('change', function() {
                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
            });

            $('#enddate').on('change', function() {
                var endclear = $('#enddate');
                var endDateInput1 = $('#enddate').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
            });

            // Add form submission handling
            $('form').submit(function(event) {
                var year = $('#year').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();

                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();

                var endclear = $('#enddate');
                var endDateInput1 = $('#enddate').val();
                var endDate = new Date(endDateInput1);
                var endyear = endDate.getFullYear();

                var yearvalue = $('#year').val();
                if (yearvalue != startyear || yearvalue != endyear) {
                    alert('Enter Start and End Date According to the selected Year');
                    startclear.val('');
                    endclear.val('');
                    event.preventDefault(); // Prevent form submission
                    return; // Exit the function
                }

                if (year !== "" && startdate !== "" && enddate === "") {
                    alert("Please select End date.");
                    event.preventDefault();
                    return;
                }

                if (year === "" || startdate === "" || enddate === "") {
                    alert("Please select filter data.");
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>

    {{-- * regarding ajax --}}
    {{-- * regarding ajax / table heading replace / regarding select box   --}}

    {{-- data dynamically get in select box using ajax  --}}
    <script>
        $(function() {

            $('#datepickers').on('change', function() {
                var timesheetdate = $(this).val();
                //   var datepickers = $('#datepickers').val();

                var refreshpage = $('.refresh');
                refreshpage.val('');
                $('.refreshoption option').remove();

                //   alert(datepickers);
                $.ajax({
                    type: "get",
                    url: "{{ url('timesheet/create') }}",
                    // url: '/timesheetrequest/reminder/list',
                    data: {
                        timesheetdate: timesheetdate
                    },
                    success: function(res) {
                        $('#client').html(res);
                        $('#client1').html(res);
                        $('#client2').html(res);
                        $('#client3').html(res);
                        $('#client4').html(res);
                    },
                    error: function() {},
                });
            });
        });
    </script>
    {{-- data dynamically get in select box using ajax  --}}
    <script>
        function handleClientChange(clientId) {
            $('#' + clientId).on('change', function() {
                var cid = $(this).val();
                var datepickers = $('#datepickers').val();
                var clientNumber = parseInt(clientId.replace('client', ''));

                if (cid == 33) {
                    // Perform an AJAX request to fetch the holiday name based on the selected date
                    $.ajax({
                        type: "get",
                        url: "{{ url('holidaysselect') }}", // Assuming this is the correct URL for fetching holiday name
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(response) {
                            // Assuming response contains the holiday name
                            var location = 'N/A';
                            var workitem = response.holidayName;
                            var time = 0;
                            //   console.log(response);

                            //   var assignmentSelect = $('.assignmentvalue');
                            //   assignmentSelect.empty();
                            //   assignmentSelect.append($('<option>', {
                            //       value: response.assignmentid,
                            //       text: response.assignmentname(response
                            //           .assignmentname / response
                            //           .assignmentgenerate_id)
                            //   }));





                            if (!isNaN(clientNumber)) {
                                var assignmentSelect = $('.assignmentvalue' + clientNumber);
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.assignmentgenerate_id,
                                    text: response.assignment_name + ' (' +
                                        response
                                        .assignmentname + '/' + response
                                        .assignmentgenerate_id + ')'
                                }));

                                var assignmentSelect = $('.partnervalue' + clientNumber);
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.team_memberid,
                                    text: response.team_member
                                }));

                                $('.workitemnvalue' + clientNumber).val(workitem).prop(
                                    'readonly', true);
                                $('.locationvalue' + clientNumber).val(location).prop(
                                    'readonly', true);
                                $('#totalhours').val(time);
                                $('#hour' + (clientNumber + 1)).prop('readonly', true);
                            } else {

                                var assignmentSelect = $('.assignmentvalue');
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.assignmentgenerate_id,
                                    text: response.assignment_name + ' (' +
                                        response
                                        .assignmentname + '/' + response
                                        .assignmentgenerate_id + ')'
                                }));

                                var assignmentSelect = $('.partnervalue');
                                assignmentSelect.empty();
                                assignmentSelect.append($('<option>', {
                                    value: response.team_memberid,
                                    text: response.team_member
                                }));


                                $('.workitemnvalue').val(workitem).prop('readonly', true);
                                $('.locationvalue').val(location).prop('readonly', true);
                                $('#totalhours').val(time);
                                $("#hour1").prop("readonly", true);
                            }
                        },
                        error: function() {
                            // Handle error if AJAX request fails
                        }
                    });
                } else {
                    // Continue with the rest of your logic
                    $.ajax({
                        type: "get",
                        url: "{{ url('timesheet/create') }}",
                        data: {
                            cid: cid,
                            datepickers: datepickers
                        },
                        success: function(res) {
                            // clear previous data 
                            if (!isNaN(clientNumber)) {
                                $('.assignmentvalue' + clientNumber).empty();
                                $('.partnervalue' + clientNumber).empty();
                                $('.workitemnvalue' + clientNumber).val('').prop('readonly',
                                    false);
                                $('.locationvalue' + clientNumber).val('').prop('readonly',
                                    false);
                                $("#hour" + (clientNumber + 1)).prop("readonly", false);

                            } else {
                                $('.assignmentvalue').empty();
                                $('.partnervalue').empty();
                                $('.workitemnvalue').val('').prop('readonly', false);
                                $('.locationvalue').val('').prop('readonly', false);
                                $("#hour1").prop("readonly", false);
                            }

                            $('#' + clientId.replace('client', 'assignment')).html(res);

                        },
                        error: function() {
                            // Handle error if AJAX request fails
                        },
                    });
                }
            });
        }
    </script>

    <script>
        //** status wise
        $('#status1').change(function() {
            var status1 = $(this).val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    //  $('table tbody').html("");
                    $('table thead, table tbody').html("");
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {

                        // Add existing table heading
                        $('table thead').append(
                            '<tr>' +
                            '<th style="display: none;">id</th>' +
                            '<th>Employee</th>' +
                            '<th>Date of Requestaaaaa</th>' +
                            '<th>Status</th>' +
                            '<th>Leave Type</th>' +
                            '<th>Leave Period</th>' +
                            '<th>Days</th>' +
                            '<th>Approver</th>' +
                            '<th>Reason for Leave</th>' +
                            '</tr>'
                        );

                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });



                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        // Change id aatribute dynamically in ajax
                        $('#examplee').attr('id', 'examplee1');
                        $('#examplee').removeAttr('id');
                    }
                }
            });
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script>
        $(function() {
            $('#category').on('change', function() {
                var category_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('tags/create') }}",
                    data: "category_id=" + category_id,
                    success: function(res) {

                        $('#subcategory_id').html(res);


                    },
                    error: function() {

                    },
                });
            });
            $('#subcategory_id').on('change', function() {
                var subcategory_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('tags/create') }}",
                    data: "subcategory_id=" + subcategory_id,
                    success: function(res) {

                        $('#step_id').html(res);


                    },
                    error: function() {

                    },
                });
            });
            $('#step_id').on('change', function() {
                var step_id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ url('tags/create') }}",
                    data: "step_id=" + step_id,
                    success: function(res) {

                        $('#audit_id').html(res);


                    },
                    error: function() {

                    },
                });
            });

        });
    </script>
    {{-- ! Old code 03-01-24  --}}
    {{-- <script>
     $(document).ready(function() {
         $('#examplee').DataTable({
             dom: 'Bfrtip',
             "pageLength": 25,
             "order": [
                 [3, "asc"]
             ],

             buttons: [

                 {
                     extend: 'copyHtml5',
                     exportOptions: {
                         columns: [0, ':visible']
                     }
                 },
                 {
                     extend: 'excelHtml5',
                     filename: 'Apply Report List',
                     exportOptions: {
                         columns: ':visible'
                     }
                 },
                 {
                     extend: 'pdfHtml5',
                     exportOptions: {
                         columns: [0, 1, 2, 5]
                     }
                 },
                 'colvis'
             ]
         });
     });
 </script> --}}

    <script>
        $(document).ready(function() {
            $('#examplee').DataTable({
                dom: 'Bfrtip',
                "pageLength": 25,
                "order": [
                    [3, "asc"]
                ],
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        filename: 'Apply Report List',
                        //  Change value Acreated to created and AApproved to Approved
                        customizeData: function(data) {
                            for (var i = 0; i < data.body.length; i++) {
                                for (var j = 0; j < data.body[i].length; j++) {
                                    if (data.body[i][j] === 'ACreated') {
                                        data.body[i][j] = 'Created';
                                    } else if (data.body[i][j] === 'BApproved') {
                                        data.body[i][j] = 'Approved';
                                    } else if (data.body[i][j] === 'Rejected') {
                                        data.body[i][j] = 'Rejected';
                                    }
                                }
                            }
                        },
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        filename: 'Apply Report List',
                        //  Change value Acreated to created and AApproved to Approved
                        customize: function(doc) {
                            // Assuming the status column is at index 3, adjust as needed
                            for (var i = 0; i < doc.content[1].table.body.length; i++) {
                                var originalValue = doc.content[1].table.body[i][3].text;
                                if (originalValue === 'ACreated') {
                                    doc.content[1].table.body[i][3].text = 'Created';
                                } else if (originalValue === 'BApproved') {
                                    doc.content[1].table.body[i][3].text = 'Approved';
                                } else if (originalValue === 'CRejected') {
                                    doc.content[1].table.body[i][3].text = 'Rejected';
                                }
                            }
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 5]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>

    {{-- add library for excell download after filter  --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>

    {{-- filter on apply leave --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- ! 11-01-2023 --}}
    {{-- 
<script>
    $(document).ready(function() {

        //** leave period end date wise
        $('#endperiod1').change(function() {
            var endperiod1 = $(this).val();
            var startperiod1 = $('#startperiod1').val();
            // var end1 = $('#end1').val();
            // var status1 = $('#status1').val();
            // var employee1 = $('#employee1').val();
            // var leave1 = $('#leave1').val();
            // alert(endperiod1);
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    startperiod: startperiod1,
                    endperiod: endperiod1,
                    // end: end1,
                    // start: start1,
                    // status: status1,
                    // employee: employee1,
                    // leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });


        //** status wise
        $('#status1').change(function() {
            var status1 = $(this).val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            $.ajax({

                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });



                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

        //** start date wise
        $('#start1').change(function() {
            var start1 = $(this).val();
            var end1 = $('#end1').val();
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();
            //  alert(start1);
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                    }
                }
            });
        });


        //  end Request Date end date wise
        $('#end1').change(function() {
            var end1 = $(this).val();
            var start1 = $('#start1').val();
            var status1 = $('#status1').val();
            var employee1 = $('#employee1').val();
            var leave1 = $('#leave1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    end: end1,
                    start: start1,
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

        //   leave type wise
        $('#leave1').change(function() {
            var leave1 = $(this).val();
            var employee1 = $('#employee1').val();
            var status1 = $('#status1').val();
            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');

                        });

                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });

        //   team name wise
        $('#employee1').change(function() {
            var employee1 = $(this).val();
            var leave1 = $('#leave1').val();
            var status1 = $('#status1').val();

            $.ajax({
                type: 'GET',
                url: '/filtering-applyleve',
                data: {
                    status: status1,
                    employee: employee1,
                    leave: leave1
                },
                success: function(data) {
                    // Replace the table body with the filtered data
                    $('table tbody').html("");
                    //  shoe save excell button 
                    $('#clickExcell').show();
                    // Clear the table body
                    if (data.length === 0) {
                        // If no data is found, display a "No data found" message
                        $('table tbody').append(
                            '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                        );
                    } else {
                        $.each(data, function(index, item) {

                            // Create the URL dynamically
                            var url = '/applyleave/' + item.id;

                            var createdAt = new Date(item.created_at)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var fromDate = new Date(item.from)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });
                            var toDate = new Date(item.to)
                                .toLocaleDateString('en-GB', {
                                    day: '2-digit',
                                    month: '2-digit',
                                    year: 'numeric'
                                });

                            var holidays = Math.floor((new Date(item.to) -
                                new Date(item.from)) / (24 * 60 * 60 *
                                1000)) + 1;

                            // Add the rows to the table
                            $('table tbody').append('<tr>' +
                                '<td><a href="' + url + '">' + item
                                .team_member +
                                '</a></td>' +
                                '<td>' + createdAt + '</td>' +
                                '<td>' + getStatusBadge(item.status) + '</td>' +
                                '<td>' + item.name + '</td>' +
                                '<td>' + fromDate + ' to ' + toDate +
                                '</td>' +
                                '<td>' + holidays + '</td>' +
                                '<td>' + item.approvernames + '</td>' +
                                '<td style="width: 7rem;text-wrap: wrap;">' +
                                item.reasonleave + '</td>' +
                                '</tr>');
                        });



                        // Function to handle the status badge
                        function getStatusBadge(status) {
                            if (status == 0) {
                                return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                            } else if (status == 1) {
                                return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                            } else if (status == 2) {
                                return '<span class="badge badge-danger">Rejected</span>';
                            } else {
                                return '';
                            }
                        }

                        //   remove pagination after filter
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();

                        // Check if data is available
                        if (data.length > 0) {
                            function exportToExcel() {
                                // Exclude unwanted columns (created_at and type)
                                const filteredData = data.map(item => {

                                    const holidays = Math.floor((new Date(item.to) -
                                        new Date(item.from)) / (24 * 60 *
                                        60 *
                                        1000)) + 1;

                                    const createdAt = new Date(item.created_at)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    const fromDate = new Date(item.from)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });
                                    const toDate = new Date(item.to)
                                        .toLocaleDateString('en-GB', {
                                            day: '2-digit',
                                            month: '2-digit',
                                            year: 'numeric'
                                        });

                                    // Create a copy of the item to avoid modifying the original data
                                    const newItem = {
                                        Employee: item.team_member,
                                        Date_of_Request: createdAt,
                                        status: item.status === 0 ? 'Created' :
                                            item.status === 1 ? 'Approved' :
                                            item.status === 2 ? 'Rejected' : '',
                                        Leave_Type: item.name,
                                        from: fromDate,
                                        to: toDate,
                                        Days: holidays,
                                        Approver: item.approvernames,
                                        Reason_for_Leave: item.reasonleave
                                    };
                                    return newItem;
                                });

                                const ws = XLSX.utils.json_to_sheet(filteredData);

                                // Add style to make header text bold
                                const headerCellStyle = {
                                    font: {
                                        bold: true
                                    }
                                };

                                ws['!cols'] = [{
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 15
                                    },
                                    {
                                        wch: 20
                                    },
                                    {
                                        wch: 30
                                    }
                                ];

                                // Apply style to header cells
                                Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                    key => {
                                        ws[key].s = headerCellStyle;
                                    });

                                const wb = XLSX.utils.book_new();
                                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                const excelBuffer = XLSX.write(wb, {
                                    bookType: "xlsx",
                                    type: "array"
                                });
                                const dataBlob = new Blob([excelBuffer], {
                                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                });
                                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                            }
                            //  // Call the function to export to Excel
                            //  exportToExcel();
                        }
                        $('#clickExcell').on('click', function() {
                            // Call the function to export to Excel
                            exportToExcel();
                        });
                    }
                }
            });
        });
    });
</script> --}}

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Common function to render table rows
            function renderTableRows(data) {
                $('table tbody').html("");
                $('#clickExcell').show();

                if (data.length === 0) {
                    $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
                } else {
                    $.each(data, function(index, item) {
                        var url = '/applyleave/' + item.id;
                        var createdAt = formatDate(item.created_at);
                        var fromDate = formatDate(item.from);
                        var toDate = formatDate(item.to);
                        var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                            60 * 1000)) + 1;

                        $('table tbody').append('<tr>' +
                            '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                            '<td>' + createdAt + '</td>' +
                            '<td>' + getStatusBadge(item.status) + '</td>' +
                            '<td>' + item.name + '</td>' +
                            '<td>' + fromDate + ' to ' + toDate + '</td>' +
                            '<td>' + holidays + '</td>' +
                            '<td>' + item.approvernames + '</td>' +
                            '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                            '</tr>');
                    });
                }
            }

            // Common function to export data to Excel
            function exportToExcel(data) {
                const filteredData = data.map(item => {
                    const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                        1000)) + 1;
                    const createdAt = formatDate(item.created_at);
                    const fromDate = formatDate(item.from);
                    const toDate = formatDate(item.to);

                    return {
                        Employee: item.team_member,
                        Date_of_Request: createdAt,
                        status: getStatusText(item.status),
                        Leave_Type: item.name,
                        from: fromDate,
                        to: toDate,
                        Days: holidays,
                        Approver: item.approvernames,
                        Reason_for_Leave: item.reasonleave
                    };
                });

                const ws = XLSX.utils.json_to_sheet(filteredData);
                const headerCellStyle = {
                    font: {
                        bold: true
                    }
                };

                ws['!cols'] = [{
                        wch: 15
                    },
                    {
                        wch: 20
                    },
                    {
                        wch: 15
                    },
                    {
                        wch: 20
                    },
                    {
                        wch: 15
                    },
                    {
                        wch: 15
                    },
                    {
                        wch: 20
                    },
                    {
                        wch: 30
                    }
                ];

                Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                    ws[key].s = headerCellStyle;
                });

                const wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                const excelBuffer = XLSX.write(wb, {
                    bookType: "xlsx",
                    type: "array"
                });
                const dataBlob = new Blob([excelBuffer], {
                    type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                });
                saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
            }

            // Common function to format date
            function formatDate(dateString) {
                return new Date(dateString).toLocaleDateString('en-GB', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                });
            }

            // Common function to get status text
            function getStatusText(status) {
                return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
            }

            // Common function to get status badge
            function getStatusBadge(status) {
                if (status === 0) {
                    return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                } else if (status === 1) {
                    return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                } else if (status === 2) {
                    return '<span class="badge badge-danger">Rejected</span>';
                } else {
                    return '';
                }
            }

            // Function to handle status change
            function handleStatusChange() {
                var status1 = $('#status1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                    }
                });
            }

            // Function to handle leave type change
            function handleLeaveTypeChange() {
                var leave1 = $('#leave1').val();
                var employee1 = $('#employee1').val();
                var status1 = $('#status1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                    }
                });
            }

            // Function to handle employee change
            function handleEmployeeChange() {
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                    }
                });
            }

            // Function to handle leave period end date change
            function handleleaveperiodendChange() {
                var endperiod1 = $('#endperiod1').val();
                var startperiod1 = $('#startperiod1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        startperiod: startperiod1,
                        endperiod: endperiod1,
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                    }
                });
            }

            //  end Request Date end date wise
            function handleEndRequestDateChange() {
                var end1 = $('#end1').val();
                var start1 = $('#start1').val();
                var status1 = $('#status1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        renderTableRows(data);
                        $('.paging_simple_numbers').remove();
                        $('.dataTables_info').remove();
                        if (data.length > 0) {
                            $('#clickExcell').on('click', function() {
                                exportToExcel(data);
                            });
                        }
                    }
                });
            }

            // Event handlers
            $('#status1').change(handleStatusChange);
            $('#leave1').change(handleLeaveTypeChange);
            $('#employee1').change(handleEmployeeChange);
            $('#endperiod1').change(handleleaveperiodendChange);
            $('#end1').change(handleEndRequestDateChange);

            //** start date wise
            $('#start1').change(function() {
                var start1 = $(this).val();
                var end1 = $('#end1').val();
                var status1 = $('#status1').val();
                var employee1 = $('#employee1').val();
                var leave1 = $('#leave1').val();
                //  alert(start1);
                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        end: end1,
                        start: start1,
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html("");
                        // Clear the table body
                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/applyleave/' + item.id;

                                var createdAt = new Date(item.created_at)
                                    .toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });
                                var fromDate = new Date(item.from)
                                    .toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });
                                var toDate = new Date(item.to)
                                    .toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });

                                var holidays = Math.floor((new Date(item.to) -
                                    new Date(item.from)) / (24 * 60 * 60 *
                                    1000)) + 1;

                                // Add the rows to the table
                                $('table tbody').append('<tr>' +
                                    '<td><a href="' + url + '">' + item
                                    .team_member +
                                    '</a></td>' +
                                    '<td>' + createdAt + '</td>' +
                                    '<td>' + getStatusBadge(item.status) + '</td>' +
                                    '<td>' + item.name + '</td>' +
                                    '<td>' + fromDate + ' to ' + toDate +
                                    '</td>' +
                                    '<td>' + holidays + '</td>' +
                                    '<td>' + item.approvernames + '</td>' +
                                    '<td style="width: 7rem;text-wrap: wrap;">' +
                                    item.reasonleave + '</td>' +
                                    '</tr>');
                            });

                            // Function to handle the status badge
                            function getStatusBadge(status) {
                                if (status == 0) {
                                    return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                                } else if (status == 1) {
                                    return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                                } else if (status == 2) {
                                    return '<span class="badge badge-danger">Rejected</span>';
                                } else {
                                    return '';
                                }
                            }

                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();
                        }
                    }
                });
            });

        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {

            //   team name wise
            $('#employee1').change(function() {
                var employee1 = $(this).val();
                var leave1 = $('#leave1').val();
                var status1 = $('#status1').val();

                $.ajax({
                    type: 'GET',
                    url: '/filtering-applyleve',
                    data: {
                        status: status1,
                        employee: employee1,
                        leave: leave1
                    },
                    success: function(data) {
                        // Replace the table body with the filtered data
                        $('table tbody').html("");
                        //  shoe save excell button 
                        $('#clickExcell').show();
                        // Clear the table body
                        if (data.length === 0) {
                            // If no data is found, display a "No data found" message
                            $('table tbody').append(
                                '<tr><td colspan="8" class="text-center">No data found</td></tr>'
                            );
                        } else {
                            $.each(data, function(index, item) {

                                // Create the URL dynamically
                                var url = '/applyleave/' + item.id;

                                var createdAt = new Date(item.created_at)
                                    .toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });
                                var fromDate = new Date(item.from)
                                    .toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });
                                var toDate = new Date(item.to)
                                    .toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    });

                                var holidays = Math.floor((new Date(item.to) -
                                    new Date(item.from)) / (24 * 60 * 60 *
                                    1000)) + 1;

                                // Add the rows to the table
                                $('table tbody').append('<tr>' +
                                    '<td><a href="' + url + '">' + item
                                    .team_member +
                                    '</a></td>' +
                                    '<td>' + createdAt + '</td>' +
                                    '<td>' + getStatusBadge(item.status) + '</td>' +
                                    '<td>' + item.name + '</td>' +
                                    '<td>' + fromDate + ' to ' + toDate +
                                    '</td>' +
                                    '<td>' + holidays + '</td>' +
                                    '<td>' + item.approvernames + '</td>' +
                                    '<td style="width: 7rem;text-wrap: wrap;">' +
                                    item.reasonleave + '</td>' +
                                    '</tr>');
                            });



                            // Function to handle the status badge
                            function getStatusBadge(status) {
                                if (status == 0) {
                                    return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
                                } else if (status == 1) {
                                    return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
                                } else if (status == 2) {
                                    return '<span class="badge badge-danger">Rejected</span>';
                                } else {
                                    return '';
                                }
                            }

                            //   remove pagination after filter
                            $('.paging_simple_numbers').remove();
                            $('.dataTables_info').remove();

                            // Check if data is available
                            if (data.length > 0) {
                                function exportToExcel() {
                                    // Exclude unwanted columns (created_at and type)
                                    const filteredData = data.map(item => {

                                        const holidays = Math.floor((new Date(item.to) -
                                            new Date(item.from)) / (24 * 60 *
                                            60 *
                                            1000)) + 1;

                                        const createdAt = new Date(item.created_at)
                                            .toLocaleDateString('en-GB', {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric'
                                            });

                                        const fromDate = new Date(item.from)
                                            .toLocaleDateString('en-GB', {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric'
                                            });
                                        const toDate = new Date(item.to)
                                            .toLocaleDateString('en-GB', {
                                                day: '2-digit',
                                                month: '2-digit',
                                                year: 'numeric'
                                            });

                                        // Create a copy of the item to avoid modifying the original data
                                        const newItem = {
                                            Employee: item.team_member,
                                            Date_of_Request: createdAt,
                                            status: item.status === 0 ? 'Created' :
                                                item.status === 1 ? 'Approved' :
                                                item.status === 2 ? 'Rejected' : '',
                                            Leave_Type: item.name,
                                            from: fromDate,
                                            to: toDate,
                                            Days: holidays,
                                            Approver: item.approvernames,
                                            Reason_for_Leave: item.reasonleave
                                        };
                                        return newItem;
                                    });

                                    const ws = XLSX.utils.json_to_sheet(filteredData);

                                    // Add style to make header text bold
                                    const headerCellStyle = {
                                        font: {
                                            bold: true
                                        }
                                    };

                                    ws['!cols'] = [{
                                            wch: 15
                                        },
                                        {
                                            wch: 20
                                        },
                                        {
                                            wch: 15
                                        },
                                        {
                                            wch: 20
                                        },
                                        {
                                            wch: 15
                                        },
                                        {
                                            wch: 15
                                        },
                                        {
                                            wch: 20
                                        },
                                        {
                                            wch: 30
                                        }
                                    ];

                                    // Apply style to header cells
                                    Object.keys(ws).filter(key => key.startsWith('A')).forEach(
                                        key => {
                                            ws[key].s = headerCellStyle;
                                        });

                                    const wb = XLSX.utils.book_new();
                                    XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
                                    const excelBuffer = XLSX.write(wb, {
                                        bookType: "xlsx",
                                        type: "array"
                                    });
                                    const dataBlob = new Blob([excelBuffer], {
                                        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                    });
                                    saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
                                }
                                //  // Call the function to export to Excel
                                //  exportToExcel();
                            }
                            $('#clickExcell').on('click', function() {
                                // Call the function to export to Excel
                                exportToExcel();
                            });
                        }
                    }
                });
            });

        });
    </script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            //   Create Zip Folder button click event
            $('#downloadButton').click(function(e) {
                e.preventDefault(); // Prevent the default form submission

                var assignmentgenerateid = {{ $assignmentgenerateid }}; // Use the variable from Blade

                $.ajax({
                    type: 'GET',
                    url: '/assignmentzipfolder',
                    data: {
                        assignmentgenerateid: assignmentgenerateid,
                    },
                    success: function(data) {
                        // Handle the success response here
                    },
                    error: function(error) {
                        // Handle any errors here
                    }
                });
            });
        });
    </script>



    {{-- validation for comparision date and block year for 4 disit --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var startDateInput = $('#startdate');
            var endDateInput = $('#enddate');

            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert('End date should be greater than or equal to the Start date');
                    endDateInput.val(''); // Clear the end date input
                }
            }

            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);
        });
    </script>

    {{-- validation for block 4 digit to  year --}}
    {{-- <script>
      $(document).ready(function() {
          $('#startdate').on('change', function() {
              var startclear = $('#startdate');
              var startDateInput1 = $('#startdate').val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();
              var yearLength = startyear.toString().length;
              if (yearLength > 4) {
                  alert('Enter four digits for the year');
                  startclear.val('');
              }
              //   //   validation for year match
              //   var yearvalue = $('#year').val();
              //   if (yearvalue != startyear) {
              //       alert('Enter Start Date According Year');
              //       startclear.val('');
              //   }
          });
          $('#enddate').on('change', function() {
              var endclear = $('#enddate');
              var endDateInput1 = $('#enddate').val();
              var endtDate = new Date(endDateInput1);
              var endyear = endtDate.getFullYear();
              var endyearLength = endyear.toString().length;
              if (endyearLength > 4) {
                  alert('Enter four digits for the year');
                  endclear.val('');
              }
              //   //   validation for year match
              //   var yearvalue = $('#year').val();
              //   if (yearvalue != endyear) {
              //       alert('Enter End Date According Year');
              //       endclear.val('');
              //   }
          });


          // Add form submission handling
          $('form').submit(function(event) {
              var year = $('#year').val();
              var startdate = $('#startdate').val();
              var enddate = $('#enddate').val();
              //   validation for year match
              var yearvalue = $('#year').val();
              if (yearvalue != startyear) {
                  alert('Enter Start Date According Year');
                  startclear.val('');
              }
              if (year === "" || startdate === "" || enddate === "") {
                  alert("Please select filter data.");
                  event.preventDefault(); // Prevent form submission
              }
          });
      });
  </script> --}}

    <script>
        $(document).ready(function() {
            $('#startdate').on('change', function() {
                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
            });

            $('#enddate').on('change', function() {
                var endclear = $('#enddate');
                var endDateInput1 = $('#enddate').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
            });

            // Add form submission handling
            $('form').submit(function(event) {
                var year = $('#year').val();
                var startdate = $('#startdate').val();
                var enddate = $('#enddate').val();

                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearvalue = $('#year').val();
                if (yearvalue != startyear) {
                    alert('Enter Start Date According Year');
                    startclear.val('');
                    event.preventDefault(); // Prevent form submission
                    return; // Exit the function
                }

                if (year === "" || startdate === "" || enddate === "") {
                    alert("Please select filter data.");
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>

    {{-- <script>
      $(document).ready(function() {
          $('#startdate').on('change', function() {
              var startclear = $('#startdate');
              var startDateInput1 = $('#startdate').val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();
              var yearLength = startyear.toString().length;
              if (yearLength > 4) {
                  alert('Enter four digits for the year');
                  startclear.val('');
              }
          });

          $('#enddate').on('change', function() {
              var endclear = $('#enddate');
              var endDateInput1 = $('#enddate').val();
              var endtDate = new Date(endDateInput1);
              var endyear = endtDate.getFullYear();
              var endyearLength = endyear.toString().length;
              if (endyearLength > 4) {
                  alert('Enter four digits for the year');
                  endclear.val('');
              }
          });

          // Add form submission handling
          $('form').submit(function(event) {
              var year = $('#year').val();
              var startdate = $('#startdate').val();
              var enddate = $('#enddate').val();

              var startclear = $('#startdate');
              var startDateInput1 = $('#startdate').val();
              var startDate = new Date(startDateInput1);
              var startyear = startDate.getFullYear();

              var endclear = $('#enddate');
              var endDateInput1 = $('#enddate').val();
              var endDate = new Date(endDateInput1);
              var endyear = endDate.getFullYear();

              var yearvalue = $('#year').val();
              if (yearvalue != startyear || yearvalue != endyear) {
                  alert('Enter Start and End Date According to the selected Year');
                  startclear.val('');
                  endclear.val('');
                  event.preventDefault(); // Prevent form submission
                  return; // Exit the function
              }

              if (year === "" || startdate === "" || enddate === "") {
                  alert("Please select filter data.");
                  event.preventDefault(); // Prevent form submission
              }
          });
      });
  </script> --}}

    {{-- * --}}
    {{-- * --}}
    {{-- * --}}
    {{-- * please wait / regarding second --}}
    {{-- @section('backEnd_content')
    <div class="content-header row align-items-center m-0">
        <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
            <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                <li style="margin-left: 13px;">
                    <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
                </li>
            </ol>
        </nav>
        <div class="col-sm-8 header-title p-0">
            <div class="media">
                <div class="header-icon text-success mr-3"><i class="typcn typcn-puzzle-outline"></i></div>
                <div class="media-body">
                    <h1 class="font-weight-bold">Home</h1>
                    <small>Assignment Folder</small>
                </div>
            </div>
        </div>
    </div>
    <div class="body-content">
        @component('backEnd.components.alert')
        @endcomponent

        <div class="row">
            <div id="loadingMessage" style="display:none;">
                Creating your zip file. Please wait... <span id="countdown">120</span> seconds remaining.
            </div>
            <div id="createdzipfile" style="display:none;">
            </div>
        </div>
        <div class="row">
            <div>
                <a href="{{ route('createdzip', ['assignmentgenerateid' => $assignmentgenerateid]) }}"
                    class="btn btn-secondary" style="color:white; display:none;" id="downloadzip">Download
                    your file</a>
            </div>
        </div>
    </div>
@endsection --}}
    {{-- <script>
    $(document).ready(function() {
        // Create Zip Folder button click event
        $('#downloadButton').click(function(e) {
            e.preventDefault();
            var assignmentgenerateid1 = '{{ $assignmentgenerateid }}';
            $('#loadingMessage').show();
            // var countdown = 20; // Initial countdown value

            // // Show loading message
            // $('#loadingMessage').show();

            // // Function to update countdown
            // function updateCountdown() {
            //     $('#countdown').text(countdown);
            //     countdown--;

            //     // If countdown reaches 0, stop updating and hide loading message
            //     if (countdown < 0) {
            //         clearInterval(countdownInterval);
            //         $('#loadingMessage').hide();
            //     }
            // }

            // // Start updating countdown every second
            // var countdownInterval = setInterval(updateCountdown, 1000);

            $.ajax({
                type: 'GET',
                url: '/assignmentzipfolder',
                data: {
                    assignmentgenerateid: assignmentgenerateid1,
                },
                success: function(data) {
                    // Hide loading message when the request is complete
                    $('#loadingMessage').hide();
                    // Display created zip file name
                    $('#createdzipfile').text('Created Zip File: ' + data).show();
                    $('#downloadzip').show();

                    // Handle the success response here
                    // alert(data);
                },
                error: function(error) {
                    // Hide loading message in case of an error
                    $('#loadingMessage').hide();

                    // Handle any errors here
                    console.error(error);
                }
            });
        });
    });
</script> --}}
    {{-- * regarding jquery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Download button click event
            $('#downloadzip').click(function() {
                // Disable the button to prevent multiple clicks
                $(this).prop('disabled', true);

                // You can also hide the button if needed
                // $(this).hide();
            });
        });
    </script>
    {{-- *regarding ajax --}}
    <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
        <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
            <li style="margin-left: 13px;">
                <button type="button" id="downloadButton" class="btn btn-outline-primary">Create Zip Folder</button>
            </li>
        </ol>
    </nav>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

    <script>
        $(document).ready(function() {
            // Create Zip Folder button click event
            $('#downloadButton').click(function(e) {
                e.preventDefault(); // Prevent the default link behavior

                // var assignmentgenerateid = {{ $assignmentgenerateid }};
                // console.log(assignmentgenerateid);
                alert('hi');
                $.ajax({
                    type: 'GET',
                    url: '/assignmentzipfolder',
                    data: {
                        assignmentgenerateid: assignmentgenerateid,
                    },
                    success: function(data) {
                        // Handle the success response here
                    },
                    error: function(error) {
                        // Handle any errors here
                    }
                });
            });
        });
    </script>
    balanceconfirmationreminder
    {{-- * --}}
    {{-- validation on date --}}
    <script>
        $(document).ready(function() {
            $('.leaveDate').on('change', function() {
                var leaveDate = $(this);
                var leaveDateValue = leaveDate.val();

                // Use a regular expression to match a four-digit year
                var yearPattern = /^\d{4}$/;

                if (!yearPattern.test(leaveDateValue)) {
                    alert('Please enter a valid four-digit year');
                    leaveDate.val('');
                }
            });
        });
    </script>


    {{-- multiple date ho ager ek hi page me tab --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.leaveDate').on('change', function() {
                var leaveDate = $(this);
                var leaveDateValue = leaveDate.val();
                var leaveDateGet = new Date(leaveDateValue);
                var leaveyear = leaveDateGet.getFullYear();
                // console.log(startyear);
                var leaveyearLength = leaveyear.toString().length;
                if (leaveyearLength > 4) {
                    alert('Enter four digits for the year');
                    leaveDate.val('');
                }
            });
        });
    </script>



    {{-- validation for comparision date and block year for 4 disit --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var startDateInput = $('#startDate');
            var endDateInput = $('#endDate');

            function compareDates() {
                var startDate = new Date(startDateInput.val());
                var endDate = new Date(endDateInput.val());

                if (startDate > endDate) {
                    alert('End date should be greater than or equal to the Start date');
                    endDateInput.val(''); // Clear the end date input
                }
            }

            startDateInput.on('input', compareDates);
            endDateInput.on('blur', compareDates);
        });
    </script>

    {{-- validation for block 4 digit to  year --}}
    <script>
        $(document).ready(function() {
            $('#startDate').on('change', function() {
                var startclear = $('#startDate');
                var startDateInput1 = $('#startDate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
            });
            $('#endDate').on('change', function() {
                var endclear = $('#endDate');
                var endDateInput1 = $('#endDate').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#startdate').on('change', function() {
                var startclear = $('#startdate');
                var startDateInput1 = $('#startdate').val();
                var startDate = new Date(startDateInput1);
                var startyear = startDate.getFullYear();
                var yearLength = startyear.toString().length;
                if (yearLength > 4) {
                    alert('Enter four digits for the year');
                    startclear.val('');
                }
                //   validation for year match
                var yearvalue = $('#year').val();
                if (yearvalue != startyear) {
                    alert('Enter Start Date According Year');
                    startclear.val('');
                }
            });
            $('#enddate').on('change', function() {
                var endclear = $('#enddate');
                var endDateInput1 = $('#enddate').val();
                var endtDate = new Date(endDateInput1);
                var endyear = endtDate.getFullYear();
                var endyearLength = endyear.toString().length;
                if (endyearLength > 4) {
                    alert('Enter four digits for the year');
                    endclear.val('');
                }
                //   validation for year match
                var yearvalue = $('#year').val();
                if (yearvalue != endyear) {
                    alert('Enter End Date According Year');
                    endclear.val('');
                }
            });
        });
    </script>


    <script>
        if ($teamname && $start || $end) {
            $query - > where(function($q) use($teamname, $start, $end) {
                $q - > where('timesheetreport.teamid', $teamname) -
                    >
                    whereBetween('timesheetreport.startdate', [$start, $end]) -
                    >
                    orWhereBetween('timesheetreport.enddate', [$start, $end]) -
                    >
                    orWhere(function($query) use($start, $end) {
                        $query - > where('timesheetreport.startdate', '<=', $start) -
                            >
                            where('timesheetreport.enddate', '>=', $end);
                    });
            });
        }
    </script>

    <script>
        //   remove pagination after filter
        $('.paging_simple_numbers').remove();
        $('.dataTables_info').remove();
    </script>

    {{-- * --}}
    {{-- * --}}
    <div id="profileCompletion" class="alert alert-info" role="alert">

    </div>
    <script>
        $(document).ready(function() {
            var profileCompletionPercentage = {{ $formattedProfileCompletion }};
            // alert(profileCompletionPercentage);
            $('#profileCompletion').text(profileCompletionPercentage + '%');
        });
    </script>
    {{-- * --}}

    {{-- <script>
        $(function() {
            $('body').on('click', '#editCompany', function(event) {
                //        debugger;
                var id = $(this).data('id');
                alert(id);
                // debugger;
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // console.log('data is:', error);
                        // console.log(response);
                        // debugger;
                        // $("#mailotp").val(response);
                        // $("#otpmessage").val(response);
                        // $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script> --}}
    {{-- <script>
        $(function() {
            $('body').on('click', '#editCompany2', function(event) {
                //        debugger;
                var id = $(this).data('id');
                // debugger;
                alert(id);
                $.ajax({
                    type: "GET",
                    url: "{{ url('confirmationauthotp2') }}",
                    data: "id=" + id,
                    success: function(response) {
                        // console.log('data is:', error);
                        // console.log(response);
                        // debugger;
                        // $("#mailotp").val(response);
                        // $("#otpmessage").val(response);
                        // $("#otpmessage").text(response.otpsuccessmessage);
                        $("#otpmessage").text(response.otpsuccessmessage);
                        $("#debitid").val(response.debitid);
                        $("#assignmentgenerate_id").val(response.assignmentgenerate_id);
                        $("#type").val(response.type);
                        $("#status").val(response.status);

                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    },
                });
            });
        });
    </script> --}}

    {{-- 222222222222222222222222222222222222222 --}}


    {{-- add library for excell download after filter  --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script> --}}

    {{-- filter on apply leave --}}
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

    {{-- <script>
     $(document).ready(function() {
         // Common function to render table rows
         function renderTableRows(data) {
             $('table tbody').html("");
             $('#clickExcell').show();

             if (data.length === 0) {
                 $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
             } else {
                 $.each(data, function(index, item) {
                     var url = '/applyleave/' + item.id;
                     var createdAt = formatDate(item.created_at);
                     var fromDate = formatDate(item.from);
                     var toDate = formatDate(item.to);
                     var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                         60 * 1000)) + 1;

                     $('table tbody').append('<tr>' +
                         '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                         //  '<td>' + item.staffcode + '</td>' +
                         '<td>' + (item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode) +
                         '</td>' +
                         '<td>' + createdAt + '</td>' +
                         '<td>' + getStatusBadge(item.status) + '</td>' +
                         '<td>' + item.name + '</td>' +
                         '<td>' + fromDate + ' to ' + toDate + '</td>' +
                         '<td>' + holidays + '</td>' +
                         '<td>' + item.approvernames + '</td>' +
                         //  '<td>' + item.approvernames + '</td>' +
                         '<td>' + (item.newstaff_code ? item.newstaff_code : item
                             .approverstaffcode) + '</td>' +
                         '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                         '</tr>');
                 });
             }
         }

         // Common function to export data to Excel
         function exportToExcel(data) {
             const filteredData = data.map(item => {
                 const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                     1000)) + 1;
                 const createdAt = formatDate(item.created_at);
                 const fromDate = formatDate(item.from);
                 const toDate = formatDate(item.to);

                 return {
                     Employee: item.team_member,
                     Staff_code: item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode,
                     Date_of_Request: createdAt,
                     status: getStatusText(item.status),
                     Leave_Type: item.name,
                     from: fromDate,
                     to: toDate,
                     Days: holidays,
                     Approver: item.approvernames,
                     Approver_Code: item.newstaff_code ? item.newstaff_code : item.approverstaffcode,
                     Reason_for_Leave: item.reasonleave
                 };
             });

             const ws = XLSX.utils.json_to_sheet(filteredData);
             const headerCellStyle = {
                 font: {
                     bold: true
                 }
             };

             ws['!cols'] = [{
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 30
                 }
             ];

             Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                 ws[key].s = headerCellStyle;
             });

             const wb = XLSX.utils.book_new();
             XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
             const excelBuffer = XLSX.write(wb, {
                 bookType: "xlsx",
                 type: "array"
             });
             const dataBlob = new Blob([excelBuffer], {
                 type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
             });
             saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
         }

         // Common function to format date
         function formatDate(dateString) {
             return new Date(dateString).toLocaleDateString('en-GB', {
                 day: '2-digit',
                 month: '2-digit',
                 year: 'numeric'
             });
         }

         // Common function to get status text
         function getStatusText(status) {
             return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
         }

         // Common function to get status badge
         function getStatusBadge(status) {
             if (status === 0) {
                 return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
             } else if (status === 1) {
                 return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
             } else if (status === 2) {
                 return '<span class="badge badge-danger">Rejected</span>';
             } else {
                 return '';
             }
         }

         // Function to handle status change
         function handleStatusChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();

                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');

                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave type change
         function handleLeaveTypeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle employee change
         function handleEmployeeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     console.log(data)
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave period end date change
         function handleleaveperiodendChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         //  end Request Date end date wise
         function handleEndRequestDateChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Event handlers
         $('#employee1').change(handleEmployeeChange);
         $('#leave1').change(handleLeaveTypeChange);
         $('#status1').change(handleStatusChange);
         $('#end1').change(handleEndRequestDateChange);
         $('#endperiod1').change(handleleaveperiodendChange);
     });
 </script> --}}

    {{-- 
 <script>
     $(document).ready(function() {
         function renderTableRows(data) {
             $('table tbody').html(""); // Clear the existing rows
             $('#clickExcell').show();

             if (data.length === 0) {
                 $('table tbody').append('<tr><td colspan="8" class="text-center">No data found</td></tr>');
             } else {
                 $.each(data, function(index, item) {
                     var url = '/applyleave/' + item.id;
                     var createdAt = formatDate(item.created_at);
                     var fromDate = formatDate(item.from);
                     var toDate = formatDate(item.to);
                     var holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 *
                         60 * 1000)) + 1;

                     var approverCode = item.newstaff_code ? item.newstaff_code : item.approverstaffcode;

                     // Append each row to the table
                     $('table tbody').append('<tr>' +
                         '<td><a href="' + url + '">' + item.team_member + '</a></td>' +
                         '<td>' + (item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode) +
                         '</td>' +
                         '<td>' + createdAt + '</td>' +
                         '<td>' + getStatusBadge(item.status) + '</td>' +
                         '<td>' + item.name + '</td>' +
                         '<td>' + fromDate + ' to ' + toDate + '</td>' +
                         '<td>' + holidays + '</td>' +
                         '<td>' + item.approvernames + '</td>' +
                         '<td>' + approverCode + '</td>' +
                         '<td style="width: 7rem;text-wrap: wrap;">' + item.reasonleave + '</td>' +
                         '<td>' +
                         '<button class="btn btn-success approve-btn" data-id="' + item.id +
                         '">Approve</button> ' +
                         '<button class="btn btn-danger reject-btn" data-id="' + item.id +
                         '">Reject</button>' +
                         '</td>' +
                         '</tr>');
                 });
             }
         }

         // Function to handle approve action
         function handleApprove(id) {
             $.ajax({
                 type: 'POST',
                 url: '/approve-leave/' + id,
                 success: function(response) {
                     alert('Leave approved successfully');
                     handleStatusChange(); // Re-filter the data to refresh the table
                 }
             });
         }

         // Function to handle reject action
         function handleReject(id) {
             $.ajax({
                 type: 'POST',
                 url: '/reject-leave/' + id,
                 success: function(response) {
                     alert('Leave rejected successfully');
                     handleStatusChange(); // Re-filter the data to refresh the table
                 }
             });
         }

         // Delegate event listeners to dynamically created buttons
         $('table tbody').on('click', '.approve-btn', function() {
             var id = $(this).data('id');
             handleApprove(id);
         });

         $('table tbody').on('click', '.reject-btn', function() {
             var id = $(this).data('id');
             handleReject(id);
         });

         // Common function to export data to Excel
         function exportToExcel(data) {
             const filteredData = data.map(item => {
                 const holidays = Math.floor((new Date(item.to) - new Date(item.from)) / (24 * 60 * 60 *
                     1000)) + 1;
                 const createdAt = formatDate(item.created_at);
                 const fromDate = formatDate(item.from);
                 const toDate = formatDate(item.to);

                 return {
                     Employee: item.team_member,
                     Staff_code: item.teamnewstaffcode ? item.teamnewstaffcode : item.staffcode,
                     Date_of_Request: createdAt,
                     status: getStatusText(item.status),
                     Leave_Type: item.name,
                     from: fromDate,
                     to: toDate,
                     Days: holidays,
                     Approver: item.approvernames,
                     Approver_Code: item.newstaff_code ? item.newstaff_code : item.approverstaffcode,
                     Reason_for_Leave: item.reasonleave
                 };
             });

             const ws = XLSX.utils.json_to_sheet(filteredData);
             const headerCellStyle = {
                 font: {
                     bold: true
                 }
             };

             ws['!cols'] = [{
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 15
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 20
                 },
                 {
                     wch: 30
                 }
             ];

             Object.keys(ws).filter(key => key.startsWith('A')).forEach(key => {
                 ws[key].s = headerCellStyle;
             });

             const wb = XLSX.utils.book_new();
             XLSX.utils.book_append_sheet(wb, ws, "FilteredData");
             const excelBuffer = XLSX.write(wb, {
                 bookType: "xlsx",
                 type: "array"
             });
             const dataBlob = new Blob([excelBuffer], {
                 type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
             });
             saveAs(dataBlob, "Apply_Report_Filter_List.xlsx");
         }

         // Common function to format date
         function formatDate(dateString) {
             return new Date(dateString).toLocaleDateString('en-GB', {
                 day: '2-digit',
                 month: '2-digit',
                 year: 'numeric'
             });
         }

         // Common function to get status text
         function getStatusText(status) {
             return status === 0 ? 'Created' : status === 1 ? 'Approved' : status === 2 ? 'Rejected' : '';
         }

         // Common function to get status badge
         function getStatusBadge(status) {
             if (status === 0) {
                 return '<span class="badge badge-pill badge-warning"><span style="display: none;">A</span>Created</span>';
             } else if (status === 1) {
                 return '<span class="badge badge-success"><span style="display: none;">B</span>Approved</span>';
             } else if (status === 2) {
                 return '<span class="badge badge-danger">Rejected</span>';
             } else {
                 return '';
             }
         }

         // Function to handle status change
         function handleStatusChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();

                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');

                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave type change
         function handleLeaveTypeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle employee change
         function handleEmployeeChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     console.log(data)
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Function to handle leave period end date change
         function handleleaveperiodendChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();

             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     // Remove previus attachment on download button 
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         //  end Request Date end date wise
         function handleEndRequestDateChange() {
             var endperiod1 = $('#endperiod1').val();
             var startperiod1 = $('#startperiod1').val();
             var employee1 = $('#employee1').val();
             var leave1 = $('#leave1').val();
             var status1 = $('#status1').val();
             var end1 = $('#end1').val();
             var start1 = $('#start1').val();
             $('#clickExcell').hide();


             $.ajax({
                 type: 'GET',
                 url: '/filtering-applyleve',
                 data: {
                     end: end1,
                     start: start1,
                     startperiod: startperiod1,
                     endperiod: endperiod1,
                     status: status1,
                     employee: employee1,
                     leave: leave1
                 },
                 success: function(data) {
                     renderTableRows(data);
                     $('.paging_simple_numbers').remove();
                     $('.dataTables_info').remove();
                     $('#clickExcell').off('click');
                     if (data.length > 0) {
                         $('#clickExcell').on('click', function() {
                             exportToExcel(data);
                         });
                     }
                     $('#clickExcell').show();
                 }
             });
         }

         // Event handlers
         $('#employee1').change(handleEmployeeChange);
         $('#leave1').change(handleLeaveTypeChange);
         $('#status1').change(handleStatusChange);
         $('#end1').change(handleEndRequestDateChange);
         $('#endperiod1').change(handleleaveperiodendChange);
     });
 </script> --}}

    {{-- Start Request Date and End Request Date validation --}}

    {{-- Date validation --}}
    {{-- <script>
     $(document).ready(function() {
         function validateDateRange(startSelector, endSelector, errorMessage) {
             var startDateInput = $(startSelector);
             var endDateInput = $(endSelector);

             function compareDates() {
                 var startDate = new Date(startDateInput.val());
                 var endDate = new Date(endDateInput.val());

                 if (startDate > endDate) {
                     alert(errorMessage);
                     endDateInput.val(''); // Clear the end date input
                 }
             }

             startDateInput.on('input', compareDates);
             endDateInput.on('blur', compareDates);
         }

         function validateYearInput(inputSelector) {
             $(inputSelector).on('change', function() {
                 var input = $(this);
                 var dateValue = new Date(input.val());
                 var year = dateValue.getFullYear();
                 if (year.toString().length > 4) {
                     alert('Enter four digits for the year');
                     input.val('');
                 }
             });
         }

         // Apply date range validation
         validateDateRange('#start1', '#end1',
             "'End Request Date' should be greater than or equal to the 'Start Request Date'");
         validateDateRange('#startperiod1', '#endperiod1',
             "'End Leave Period' should be greater than or equal to the 'Start Leave Period'");

         // Apply year validation
         validateYearInput('#start1');
         validateYearInput('#end1');
         validateYearInput('#startperiod1');
         validateYearInput('#endperiod1');
     });
 </script>
 <script>
     $(document).ready(function() {
         $('form').submit(function(event) {
             var employee = $('#employee1').val();
             var leave = $('#leave1').val();
             var status = $('#status1').val();
             var startDate = $('#start1').val();
             var endDate = $('#end1').val();
             var startPeriod = $('#startperiod1').val();
             var endPeriod = $('#endperiod1').val();

             if (employee === "" && leave === "" && status === "" && startDate === "" && endDate ===
                 "" &&
                 startPeriod === "" && endPeriod === "") {
                 alert("Please select Any input ");
                 event.preventDefault();
                 return;
             }
         });
     });
 </script> --}}




    {{-- ###################################################################### --}}
    {{--  --------------------- 29 sep 2023 joining date--------------- --}}

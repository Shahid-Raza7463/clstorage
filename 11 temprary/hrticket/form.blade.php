<div class="row row-sm">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Name of Employee *</label>
            <input required type="text" readonly name="createdby"
                value="{{ App\Models\Teammember::where('id', auth()->user()->teammember_id)->pluck('team_member')->first() ?? '' }}({{ auth()->user()->email }})"
                class="form-control" placeholder="Enter Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Query <span class="tx-danger">*</span></label>
            <input required type="text" name="taskname" value="{{ $task->taskname ?? '' }}" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Attachment </label>
            <input type="file" id="fileInput" onchange="validateFile()" name="file[]" multiple="" value=""
                class="form-control">
            <p id="error-message" class="text-danger"></p>

        </div>
    </div>
    {{-- <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Client </label>
            <select class="language form-control" id="exampleFormControlSelect1" name="client_id"
                @if (Request::is('assignmentbudgeting/*/edit'))> <option disabled style="display:block">Please Select One
                </option>

                @foreach ($client as $clientData)
                <option value="{{$clientData->id}}"
                    {{$task->client->id== $clientData->id??'' ?'selected="selected"' : ''}}>
                    {{$clientData->client_name }} (  {{$clientData->gstno }} )</option>
                @endforeach


                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($client as $clientData)
                <option value="{{$clientData->id}}">
                    {{ $clientData->client_name }} (  {{$clientData->gstno }} )</option>

                @endforeach
                @endif
            </select>
        </div>
    </div> --}}
    <div class="col-4" style="display:none;">
        <div class="form-group">
            <label class="font-weight-600">To *</label>
            <input required type="text" readonly name="too" value="secretarial@kgsomani.com" class="form-control"
                placeholder="Enter Name">
        </div>
    </div>

</div>
<div class="row row-sm">
    <input type="hidden" id="informPartnerInput" name="inform_partner" value="0">
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">HR Function <span class="tx-danger">*</span></label>
            <select required class="language form-control" name="hrfunction" id="hrfunctionSelect">
                <option value="">Select one</option>
                @foreach ($hrfunction as $hrfunctionData)
                    <option value="{{ $hrfunctionData->id }}">{{ $hrfunctionData->hrfunction }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-4" id="otherHrFunction" style="display: none">
        <div class="form-group">
            <label class="font-weight-600">Other Function <span class="tx-danger">*</span></label>
            <input type="text" class="form-control" name="other_hrfunction" placeholder="Enter Other HR Function">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">Partner *</label>
            <select required class="form-control" name="partner_id"
                @if (Request::is('task/*/edit')) > <option disabled style="display:block">Please Select </option>

                @foreach ($partner as $partnerData)
                <option value="{{ $partnerData->id }}" @if (Request::is('secretaryoftask/*/edit')) @foreach ($taskassign as $team) {{ $partnerData->id == $team->partner_id ? 'selected' : '' }} @endforeach @endif>
                {{ $partnerData->team_member }}
                ( {{ $partnerData->emailid ?? '' }} )</option>
                @endforeach
            @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($partner as $partnerData)
                    <option value="{{ $partnerData->id }}">
                        {{ $partnerData->team_member }} ( {{ $partnerData->emailid ?? '' }} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>



</div>
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Description of Query <span class="tx-danger">*</span></label>
            <textarea rows="14" name="description" value="" class="centered form-control" id="editor"
                placeholder="Enter Description">{!! $task->description ?? '' !!}</textarea>
        </div>
    </div>
</div>
{{-- <div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Additional Details </label>
            <textarea rows="3" name="addtional_details" value="" class="centered form-control"
                placeholder="Enter Text">{!! $task->addtional_details ??'' !!}</textarea>
        </div>
    </div>
</div> --}}

{{-- 
<div class="row row-sm">
 <div class="col-4">
        <div class="form-group">
            <label class="font-weight-600">CC To *</label>
            <select class="form-control basic-multiple" multiple="multiple" name="teammember_id[]"
                @if (Request::is('task/*/edit'))> <option disabled style="display:block">Please Select </option>

                @foreach ($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}" @if (Request::is('secretaryoftask/*/edit')) @foreach ($taskassign as $team) {{ $teammemberData->id == $team->teammember_id ? 'selected' : '' }} @endforeach @endif>
                    {{ $teammemberData->team_member }}
                    ( {{ $teammemberData->emailid ??''}} )</option>
                @endforeach

                @else
                <option></option>
                <option value="">Please Select One</option>
                @foreach ($teammember as $teammemberData)
                <option value="{{$teammemberData->id}}">
                    {{ $teammemberData->team_member }} ( {{ $teammemberData->emailid ??''}} ) </option>

                @endforeach
                @endif
            </select>
        </div>
    </div>
</div> --}}


<div class="form-group">
    <button type="submit" class="btn btn-success btn-submit" style="float:right"> Submit</button>
    <a class="btn btn-secondary" href="{{ url('hrticket') }}">
        Back</a>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="{{ url('backEnd/ckeditor/ckeditor.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#hrfunctionSelect').change(function() {
            if ($(this).val() === "13") {
                $('#otherHrFunction').show();
            } else {
                $('#otherHrFunction').hide();
            }
        });
    });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor1'), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    // Function to show SweetAlert2 confirmation dialog
    function showConfirmation() {
        Swal.fire({
            title: 'Inform Partner?',
            text: "Do You want to inform partner about the ticket?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, submit it!',
            cancelButtonColor: '#f39c12', // Use the color for 'Cancel' button
            cancelButtonText: 'Cancel',
            showDenyButton: true,
            denyButtonColor: '#d33', // Use the color for 'No, submit it!' button
            denyButtonText: 'No, submit it!',
            allowOutsideClick: false,
            buttons: ['cancel', 'deny', 'confirm'] // Specify the order of buttons
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicks 'Yes', set inform_partner to 1 and manually submit the form
                document.getElementById("informPartnerInput").value = "1";
                document.getElementById("ticketForm").submit();
            } else if (result.isDismissed && result.dismiss === Swal.DismissReason.cancel) {
                // Handle 'Cancel' button click (do nothing or provide specific action)
                Swal.update({
                    showDenyButton: true,
                    denyButtonText: 'Cancel',
                });
            } else {
                // If the user clicks 'No', set inform_partner to 0 and manually submit the form
                document.getElementById("informPartnerInput").value = "0";
                document.getElementById("ticketForm").submit();
            }
        });

        return false;
    }
</script>
<script>
    function validateFile() {
        // Get the file input element
        var fileInput = document.getElementById('fileInput');
        // Get the selected file
        var file = fileInput.files[0];

        // Set the maximum allowed file size (in bytes)
        var maxSize = 3145728; // 3 megabytes

        // Check if a file is selected
        if (file) {
            // Check the file size
            if (file.size > maxSize) {
                // console.log('in');
                // Display an error message
                document.getElementById('error-message').innerHTML =
                    'File size exceeds the maximum allowed limit (3MB).';
                // Clear the file input
                fileInput.value = '';
            } else {
                // Clear any previous error messages
                document.getElementById('error-message').innerHTML = '';
                // Display success message (you can replace this with your server response)
                displayMessage('Create Successfully');
            }
        }
    }

    function displayMessage(message) {
        // Create a new paragraph element
        var messageElement = document.createElement('p');
        // Set the message text
        messageElement.textContent = message;
        // Append the message to the body or any other container element
        document.body.appendChild(messageElement);
    }
</script>

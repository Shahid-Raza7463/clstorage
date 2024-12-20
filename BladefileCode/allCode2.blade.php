<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>



{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding  --}}
{{--  Start Hare --}}
<pre>
    
</pre>
{{--  Start Hare --}}

@php
    // $request->validate([
    //     'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg|max:4120',
    // ], [
    //     'attachment.max' => 'The file may not be greater than 5 MB.',
    // ]);
    $request->validate(
        [
            'attachment' => 'nullable|mimes:png,pdf,jpeg,jpg,xls,xlsx|max:5120',
        ],
        [
            'attachment.max' => 'The file may not be greater than 5 MB.',
            'attachment.mimes' => 'The file must be a type of: png, pdf, jpeg, jpg, xls, xlsx.',
        ],
    );
@endphp
{{-- ! End hare --}}
{{-- * regarding requared attribute --}}
{{--  Start Hare --}}
<div class="col-6">
    <div class="form-group">
        <label class="font-weight-600">Target *</label>

        <select required class="form-control basic-multiple" multiple="multiple" id="exampleFormControlSelect111"
            name="targettype[]">
            <option value="" disabled> Please Select One</option>
            <option value="1">Individual</option>
            <option value="2">All Member</option>
            <option value="3">Partner</option>
            <option value="4">Manager</option>
            <option value="5">Staff</option>
            <option value="6">IT Department</option>
            <option value="7">Accountant</option>
        </select>
    </div>
</div>

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
{{--  Start Hare --}}
{{-- ! End hare --}}
{{-- * regarding summernote  --}}
{{--  Start Hare --}}
{{--  Start Hare --}}
<div class="row row-sm">
    <div class="col-12">
        <div class="form-group">
            <label class="font-weight-600">Announcement Content *</label>
            <textarea rows="4" name="mail_content" class="centered form-control" id="summernote"
                placeholder="Enter Description" id="editors" style="height:500px;"></textarea>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
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
{{-- ! End hare --}}



{{-- ########################################################################### --}}
{{-- 17-12-2024 --}}




</html>

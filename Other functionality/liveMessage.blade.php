<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600" style="width:100px;">Work Item *</label>
        <input required type="text" name="workitem[]" id="key" value="{{ $timesheet->workitem ?? '' }}"
            class="form-control key">
        <span id="displayWorkItem"></span>
    </div>
</div>
<div class="col-2">
    <div class="form-group">
        <label class="font-weight-600">Work Item *</label>
        <input required type="text" name="workitem[]" id="workItemInput" class="form-control key">
        <span id="displayWorkItem"></span>
    </div>
</div>
<script>
    // Function to update the display when the user types in the input field
    document.getElementById('workItemInput').addEventListener('input', function() {
        document.getElementById('displayWorkItem').textContent = this.value;
    });
</script>

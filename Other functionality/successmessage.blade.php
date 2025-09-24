<!-- Modal for success message -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Display success message here -->
                <p id="successMessage"></p>
            </div>
        </div>
    </div>
</div>

<!-- Display success message for user -->
@if (session('message'))
    <script>
        // Set the success message to the modal content
        document.getElementById('successMessage').innerText = "{{ session('message') }}";
        
        // Show the modal
        $('#successModal').modal('show');
    </script>
@endif

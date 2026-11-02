{{-- reply functionality --}}
<form action="{{ url('/') }}/networkreply" method="post" enctype="multipart/form-data"
    id="replyform{{ $network->review_id }}">
    @csrf
    <div class="reply-section" style="display: none;">
        <img src="{{ asset('web/images/avatar3.webp') }}" alt="Avatar" class="avatar network-avatar">
        <div class="reply-input-wrapper">
            <div class="validationMassage mb-3">

            </div>
            <textarea type="text" class="reply-input form-control p-2 mb-2" name="review_text" placeholder="Post Your Reply"></textarea>
            <div class="d-flex gap-1 input-wrapper2">
                <input type="text" class="form-control p-2" name="name" id="" placeholder=" Name">
                <input type="text" class="form-control p-2" name="email" id="" placeholder=" Email">
                <input type="hidden" name="parent_review_id" value="{{ $network->review_id }}">
                <input type="hidden" name="network_id" value="{{ $network->network_id }}">
                <input type="hidden" name="user_id" value="{{ $network->user_id }}">
            </div>
            <div id="success"></div>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-2">
            <button type="submit" class="btn btn-sm bg-primary text-white">Send</button>
        </div>
    </div>
</form>


{{-- submit form using jquiry ajax --}}
<script>
    $(document).ready(function() {

        // hare  validation function
        function displayValidatorErrors(errors) {
            $('.validationMassage').empty(); // Clear existing error messages

            $.each(errors, function(field, messages) {
                $.each(messages, function(index, message) {
                    var errorItem = $('<div>').text(message);
                    var errorMessage = $('<div>').addClass('validation').append(errorItem);

                    $('.validationMassage').append(errorMessage);
                });
            });
        }


        // Submit form using jQuery AJAX
        $("#replyform{{ $network->review_id }}").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = "{{ url('/') }}/networkreply";

            $.ajax({
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $("#replyform{{ $network->review_id }}")[0].reset();
                        window.location = "{{ url('/') }}/thankyou";
                    } else {
                        // Handle errors
                    }
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.log(xhr);
                    console.log("Error: " + error);
                    displayValidatorErrors(xhr.responseJSON.errors);
                }
            });
        });
    });
</script>

<div class="col-md-7 col-sm-12">
    <div class="div-strip border pb-3">
        <div class="border rounded text-center" style="background-color: #f3f3f3;">
            <h5 class="mt-1 fw-bold">Contact</h5>
        </div>
        <div class="mx-3">
            <form class="row g-3" action="{{ url('/') }}/contact" name="myForm" onsubmit="return validateForm()"
                method="post" id="contact_form">
                <div class="col-md-12 mt-4">
                    <p>Have questions? Need help? Interested in advertising on our sites? We'd love to hear from you!
                        Please fill out the form below and we'll be in touch.</p>
                </div>

                <div class="warning mb-3">

                </div>
                <!--display error massage for user -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!--  Display success massage for user -->

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <div class="col-md-12">
                    <label for="inputName4" class="form-label">Name:<span id="required">*</span></label>
                    <input type="text" name="name" class="form-control" id="inputName4"
                        oninput="removeValidationError('inputName4')">
                    <p class="formerror" id="inputName4Error"></p>
                </div>
                <div class="col-md-12">
                    <label for="inputEmail4" class="form-label">Email:<span id="required">*</span></label>
                    <input type="email" name="email" class="form-control" id="inputEmail4"
                        oninput="removeValidationError('inputEmail4')">
                    <p class="formerror" id="inputEmail4Error"></p>
                </div>
                <div class="col-12">
                    <label for="inputSocialAdd" class="form-label">Skype / Telegram (separated using commas)</label>
                    <input type="text" name="skype" class="form-control" id="inputSocialAdd"
                        oninput="removeValidationError('inputSocialAdd')">
                    <p class="formerror" id="inputSocialAddError"></p>
                </div>
                <div class="col-12">
                    <label for="inputSubject" class="form-label">Subject:<span id="required">*</span></label>
                    <input type="text" name="subject" class="form-control" id="inputSubject"
                        oninput="removeValidationError('inputSubject')">
                    <p class="formerror" id="inputSubjectError"></p>
                </div>
                <div class="col-md-12">
                    <label for="exampleMessage" class="form-label">Message:<span id="required">*</span></label>
                    <textarea class="form-control" name="message" id="exampleMessage" rows="3"
                        oninput="removeValidationError('exampleMessage')"></textarea>
                    <p class="formerror" id="exampleMessageError"></p>
                </div>
                <div class="col-12">
                    <label>Captcha</label>
                    <div class="form-check border">
                        {{-- google recapcha --}}
                        <div class="g-recaptcha" data-sitekey="6LcfD40mAAAAAAogNxAJih1P9r7q7j9xQ_EwuIpp"
                            style="margin-right: 263px;
                            margin-bottom: 12px;"></div>
                    </div>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary" style="background-color: #2C1B47;">Submit</button>
                </div>
            </form>

            {{-- submit form using jquiry ajax --}}
            <script>
                $(document).ready(function() {
                    // validation form after click on submit
                    function displayValidatorErrors(errors) {
                        // Remove existing error messages
                        $('.validation').remove();
                        $.each(errors, function(field, messages) {
                            $.each(messages, function(index, message) {
                                var errorItem = $('<div>').text(message);
                                var errorMessage = $('<div>').addClass('validation').append(errorItem);
                                // console.log(field);
                                $('input[name="' + field + '"]').after(errorMessage);
                                $('textarea[name="' + field + '"]').after(errorMessage);
                            });
                        });
                    }

                    // remove validation message after enter data in field
                    $("input, textarea, select").on("change", function() {
                        $(this).next('.validation').remove();
                    });

                    // Submit form using jQuery AJAX
                    $("#contact_form").submit(function(e) {
                        e.preventDefault();
                        var formData = new FormData(this);
                        var url = "{{ url('/') }}/contact";

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
                                    $("#contact_form")[0].reset();
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
        </div>
    </div>

</div>

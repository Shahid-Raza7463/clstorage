        <!-- register form -->
        {{-- form-label --}}

        {{-- onsubmit="return validateModalForm()" --}}

        <div class="filter-container mx-2">
            <form action="{{ url('/') }}/networks" id="network_form" method="post" enctype="multipart/form-data"
                class="row g-3 form-cont">
                @csrf
                <div class="border mt-5 pb-2">
                    <div class="border text-center"
                        style="background-color: #f3f3f3; margin-bottom: 10px;margin-top: 20px;">
                        <h5 class="mt-1 form-head">Add Your Network</h5>
                    </div>


                    <!-- display error massage -->

                    {{-- @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                @endif --}}

                    {{-- 
                @if ($errors->any())
                    <span class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                        @error('network_name')
                            <li>{{ $message }}</li>
                        @enderror

                        @error('image')
                            <li>{{ $message }}</li>
                        @enderror
                    </span>
                @endif --}}

                    <!-- display error messages -->
                    {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><span>{{ $error }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                    <!--  Display success massage  -->
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif


                    <div class="row d-flex flex-row flex-wrap">
                        <div class="col-md-6">
                            <label for="name" class=" ">Affiliate Network Name <span
                                    id="required">*</span></label>
                            <input type="text" name="network_name" placeholder="Enter Affiliate Network Name"
                                class="form-control p-1 text-capitalize" value="{{ old('network_name') }}">
                            <span class="text-danger">
                                @error('network_name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-6">
                            <label for="type" class=" ">Choose your Network:<span
                                    id="required">*</span></label>
                            <select class="form-select choose" name="network_type" aria-label="Default select example">

                                <option value="0" {{ old('network_type') == '1' ? 'selected' : '' }}>
                                    Affiliate Network
                                </option>
                                <option value="1" {{ old('network_type') == '2' ? 'selected' : '' }}>
                                    Affiliate Program
                                </option>
                                <option value="2" {{ old('network_type') == '3' ? 'selected' : '' }}>
                                    Advertising
                                </option>
                            </select>
                            <span style="font-size: 12px;">Affiliate Program, Advertising</span>
                            <div class="multiplenetwork_type"></div>
                            <span class="text-danger">
                                @error('network_type')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="network" class=" ">Network URL:<span id="required">*</span></label>
                            <input type="text" name="network_url" class="form-control p-1"
                                value="{{ old('network_url') }}" placeholder="Enter Network URL">
                            <span style="font-size: 12px;">Such as: https://www.example.com</span>
                            <div class="text-danger">
                                @error('network_url')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-12">
                            <label for="inputAddress" class=" ">Network Description:<span
                                    id="required">*</span></label>
                            <textarea class="form-control text-capitalize" name="network_description" rows="3"
                                placeholder="Enter Network Description:">{{ old('network_description') }}</textarea>
                            <span class="text-danger">
                                @error('network_description')
                                    {{ $message }}
                                @enderror
                            </span>

                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class=" ">Offers Count:<span id="required">*</span></label>
                            <input type="text" name="offer_count" class="form-control p-1"
                                value="{{ old('offer_count') }}" placeholder="Enter Offers Count:">
                            <span style="font-size: 12px;">(How many offers in your network? (50, 100, etc))</span>
                            <div class="text-danger">
                                @error('offer_count')
                                    {{ $message }}
                                @enderror
                            </div>
                            {{-- <span class="error">error</span> --}}
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class=" ">Top verticals:<span id="required">*</span></label>
                            <select name="vertical_id[]" id="countries" class="form-select countries" value=""
                                multiple>

                                @foreach ($verticals as $key => $val)
                                    <option value="{{ $key }}"
                                        @if (old('vertical_id') != null && in_array($key, old('vertical_id'))) selected @endif>{{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="multiplevertical_id"></div>

                            <span style="font-size: 12px;">Featured Verticals</span>
                            <div class="text-danger">
                                @error('vertical_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="" class=" ">Commission Type:<span id="required">*</span></label>
                            <select name="commission_type[]" placeholder="Enter Commission Type:" id="commission"
                                multiple>
                                @foreach ($commission_type as $key => $val)
                                    <option value="{{ $key }}"
                                        @if (old('commission_type') != null && in_array($key, old('commission_type'))) selected @endif>{{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            <span style="font-size: 12px;">(Commission Type (CPA, CPL, CPI, CPS, RevShare,
                                etc))</span>
                            <div class="multiplecommission_type"></div>
                            <div class="text-danger">
                                @error('commission_type')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class=" ">Minimum Payout:<span id="required">*</span></label>
                            <input type="text" name="min_payout" placeholder="Enter Minimum Payout:"
                                class="form-control p-1" value="{{ old('min_payout') }}">
                            <span style="font-size: 12px;">(Minimum Payment ($50, $100, etc))</span>
                            <div class="text-danger">
                                @error('min_payout')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="name" class=" ">Payout Frequency:<span
                                    id="required">*</span></label>
                            <select name="payment_frequency[]" id="payment" multiple>
                                @foreach ($payment_frequency as $key => $val)
                                    <option value="{{ $key }}"
                                        @if (old('payment_frequency') != null && in_array($key, old('payment_frequency'))) selected @endif>{{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            <span style="font-size: 12px;">(Net-30, Net-15, Weekly, Upon Request, etc)</span>
                            <div class="multiplepayment_frequency"></div>
                            <div class="text-danger">
                                @error('payment_frequency')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="payment_method[]" class=" ">Payment Method:<span
                                    id="required">*</span></label>
                            <select name="payment_method[]" id="paymentmethod" multiple>
                                {{-- class="form-control p-1" --}}
                                @foreach ($payment_method as $key => $val)
                                    <option value="{{ $key }}"
                                        @if (old('payment_method') != null && in_array($key, old('payment_method'))) selected @endif>{{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            <span style="font-size: 12px;">(Check, PayPal, Wire, etc)</span>
                            <div class="multiplepayment_method"></div>
                            <div class="text-danger">
                                @error('payment_method')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-6 mb-3">
                            <label for="name" class=" ">Referral Commission:(optional)</label>
                            <input type="text" name="referral_commission"
                                placeholder="Enter Referral Commission:(optional):" class="form-control p-1"
                                value="{{ old('referral_commission') }}">
                            <span style="font-size: 12px;">(2%, 5%, etc)</span>
                            <span class="text-danger">
                                @error('referral_commission')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name" class=" ">Affiliate Tracking Software:<span
                                    id="required">*</span></label>
                            <select name="affiliate_tracking_software" id="affiliate_tracking_software"
                                class="form-control p-1">
                                @foreach ($network_softwares as $key => $val)
                                    <option value="{{ $val }}"
                                        @if (old('affiliate_tracking_software') == $val) selected @endif>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                            <span style="font-size: 12px;">Affiliate Tracking Software (HasOffers, Trakaff, Affise,
                                In-house, etc)</span>
                            <span class="text-danger">
                                @error('affiliate_tracking_software')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>

                        <!-- ######################## -->
                        <!-- create social site link dynamically -->

                        {{-- <div class="col-6">
                            <label for="name" class=" ">Select Site Name:<span
                                    id="required">*</span></label>
                        </div> --}}
                        {{-- <div class="col-6 ">
                            <label for="name" class="  gx-3">Enter Site Link<span
                                    id="required">*</span></label>
                        </div> --}}
                        <div class="container_social d-flex flex-row flex-wrap mb-2" id="social-main-container">
                            <div class="col-md-6" style="width: 502px;">
                                <label for="name" class=" ">Select Site Name:<span
                                        id="required">*</span></label>
                                <select name="social_site[]" class="form-control p-1 b_site multiple">
                                    <option value="Facebook"
                                        {{ old('social_site[]') == 'Facebook' ? 'selected' : '' }}>
                                        Facebook</option>
                                    <option value="Linkedin"
                                        {{ old('social_site[]') == 'Linkedin' ? 'selected' : '' }}>
                                        Linkedin</option>
                                    <option value="Twitter" {{ old('social_site[]') == 'Twitter' ? 'selected' : '' }}>
                                        Twitter</option>
                                </select>
                                <span style="font-size: 12px;">Facebook,Linkedin,Twitter,etc</span>
                                <span class="text-danger">
                                    @error('social_site')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </div>
                            <div class="col-md-6"
                                style="margin-left: 21px;
                            width: 497px;">
                                <label for="name" class="  gx-3">Enter Site Link<span
                                        id="required">*</span></label>
                                <div class="d-flex" style="width: 498px;">
                                    <input type="text" name="social_link[]" placeholder="Enter Social Link:"
                                        class="form-control p-1 b_link link1" value="{{ old('social_link[]') }}"
                                        style="width: 454px;">
                                    <button type="button" onclick="deleteLink(this)"
                                        class="mx-1 btn btn-sm btn-danger ">Del</button>
                                </div>
                                <div class="multiplesocial_link"></div>
                            </div>
                        </div>


                        <!-- create social site link dynamically inside span tag  -->
                        <span id="repeatSocial"></span>

                        <div class="col mt-2">
                            <input type="button" value="&#10010;" name="" class="form-control p-1"
                                onclick="addLink()" id="copyButton">
                        </div>

                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

                        <!-- functionality of add button and delete button -->
                        <script>
                            //remove extra added social link container container
                            function deleteLink(button) {
                                var numItems = $('.container_social').length;
                                if (numItems > 1) {
                                    var container = button.closest('.container_social');
                                    container.remove();
                                } else {
                                    // Handle case when there is only one container left
                                }
                            }

                            function addLink() {
                                //for adding 
                                var socialContainer = document.getElementById('social-main-container');
                                var repeatSocialContainer = document.getElementById('repeatSocial');
                                var clone = socialContainer.cloneNode(true);

                                // Clear input values before appending the clone
                                var inputFields = clone.getElementsByTagName('input');
                                for (var i = 0; i < inputFields.length; i++) {
                                    inputFields[i].value = "";
                                }

                                // Reset select box field
                                var selectFields = clone.getElementsByTagName('select');
                                for (var j = 0; j < selectFields.length; j++) {
                                    selectFields[j].selectedIndex = 0;
                                }

                                repeatSocialContainer.appendChild(clone);
                            }
                        </script>
                    </div>


                    <div class="border mt-4 pb-2">
                        <div class="border text-center" style="background-color: #f3f3f3;">
                            <h5 class="mt-1 form-head">Contact information</h5>
                        </div>
                        <div class="mx-2 mt-3">
                            <div class="mx-2 mt-3 d-flex flex-row flex-wrap">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class=" ">Name:<span id="required">*</span></label>
                                    <input type="text" name="name"
                                        class="form-control p-1 b_contact text-capitalize"
                                        value="{{ old('name') }}" placeholder="Enter Name:">
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-md-6 px-2 mb-3">
                                    <label for="email" class=" ">Email:<span id="required">*</span></label>
                                    <input type="email" name="email" placeholder="Enter Email"
                                        class="form-control p-1 b_contact" value="{{ old('email') }}">
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="name" class=" ">Skype/Telegram:</label>
                                    <input type="text" name="skype" placeholder="Ex: live:skype-ID"
                                        class="form-control p-1 b_contact" value="{{ old('skype') }}">
                                    <span style="font-size: 12px;">[Skype / Telegram / Phone (separated using
                                        commas)]</span>

                                </div>

                                <div class="col-md-6 px-2 mb-3">
                                    <label for="phone number" class=" ">Phone number:<span
                                            id="required">*</span></label>
                                    <input type="text" name="phone_number" placeholder="+918563254785"
                                        class="form-control p-1 b_contact" value="{{ old('phone_number') }}">
                                    <span class="text-danger">
                                        @error('phone_number')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="col-12">
                                    <label for="inputAddress" class=" ">Please let us know if you have any
                                        other
                                        questions:(optional)</label>
                                    <textarea class="form-control b_contact" name="other_question" rows="3" placeholder="Write Hare:"
                                        value="{{ old('other_question') }}">{{ old('other_question') }}</textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="border mt-4 pb-2">
                        <div class="border text-center" style="background-color: #f3f3f3;">
                            <h5 class="mt-1 form-head">Add Network Logo (220*220 Pixels)<span id="required">*</span>
                            </h5>
                        </div>
                        <div class="row mt-4 mx-3 drag-drop">
                            <div class="col-md-6">
                                <div class="border border-dark rounded bg-light p-3 text-center">
                                    <div class="lh-1" id="dropzone" style="border: 1px rgb(245, 234, 234) solid">
                                        <p><i class="fa-solid fa-cloud-arrow-down fa-lg"></i></p>
                                        <p>Drag & Drop</p>
                                        <p>or</p>
                                        <label for="file-upload" class="btn btn-secondary">Upload File (220*220
                                            Pixels,
                                            JPG/PNG)</label>
                                        <input type="file" name="image" id="file-upload" class="fileInput"
                                            style="display: none;">
                                        {{-- display file name after drag or drop --}}
                                        <div id="file_name"></div>
                                    </div>

                                    {{-- script for drag or drop file --}}
                                    <script>
                                        var dropzone = document.getElementById('dropzone');
                                        // var fileInput = document.getElementById('fileInput');
                                        var fileInput = document.getElementsByClassName('fileInput')[0];
                                        var file_name = document.getElementById('file_name');


                                        // Prevent default drag behaviors
                                        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                                            dropzone.addEventListener(eventName, preventDefaults, false);
                                        });

                                        // Highlight the drop zone when dragging over it
                                        ['dragenter', 'dragover'].forEach(eventName => {
                                            dropzone.addEventListener(eventName, highlight, false);
                                        });

                                        // Unhighlight the drop zone when dragging out of it
                                        ['dragleave', 'drop'].forEach(eventName => {
                                            dropzone.addEventListener(eventName, unhighlight, false);
                                        });

                                        // Handle dropped files
                                        dropzone.addEventListener('drop', handleDrop, false);

                                        function preventDefaults(event) {
                                            event.preventDefault();
                                            event.stopPropagation();
                                        }

                                        function highlight() {
                                            dropzone.style.backgroundColor = '#e1e7f0';
                                        }

                                        function unhighlight() {
                                            dropzone.style.backgroundColor = '';
                                        }

                                        function handleDrop(event) {
                                            var files = event.dataTransfer.files;
                                            if (files.length > 0) {
                                                fileInput.files = files;
                                                // Trigger an event to indicate the file has been set
                                                fileInput.dispatchEvent(new Event('change'));
                                            }
                                        }

                                        // Optional: Show the file name when selected in the file input
                                        fileInput.addEventListener('change', function(event) {
                                            if (fileInput.files.length > 0) {
                                                var file_name = document.getElementById('file_name');
                                                file_name.innerHTML = fileInput.files[0].name;
                                            } else {
                                                file_name.innerHTML = 'Drag and drop files here';
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <ul>
                                        <li>Maximum allowed size per file is 153.00 KB</li>
                                        <li>Maximum total allowed file size is 02.00 MB</li>
                                        <li>Minimum 1 file is required</li>
                                        <li>Maximum 1 file is allowed</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    {{-- google recapcha --}}
                    {{-- <div class="g-recaptcha" data-sitekey="6LcfD40mAAAAAAogNxAJih1P9r7q7j9xQ_EwuIpp"></div> --}}

                    <div class="border mt-4 mb-3" style="background-color: #f3f3f3;">
                        <div class="text-center d-flex justify-content-center">
                            <div class="lh-lg email-sub" style="width: 50%;">
                                <button type="submit" class="btn btn-sm text-light mt-3 mb-3"
                                    style="background-color: #2C1B47;">Save & Preview</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        {{-- network register form --}}
        <script>
            $(document).ready(function() {
                // validation form after click on submit
                function displayValidatorErrors(errors) {

                    // hare use validation class for css style
                    $('.validation').remove(); // Remove existing error messages

                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            var errorItem = $('<div>').text(message);
                            var errorMessage = $('<div>').addClass('validation').append(errorItem);
                            // console.log(field);
                            $('input[name="' + field + '"]').after(errorMessage);
                            $('textarea[name="' + field + '"]').after(errorMessage);
                            //for multiple selection
                            $(".multiple" + field).html(errorMessage);
                            //for social link 
                            if (field.search('social_link') > -1) {
                                //
                                $(".multiplesocial_link").html(errorMessage);
                            }
                        });
                    });
                }

                // remove validation message after enter data in field
                $("input, textarea, select").on("change", function() {
                    $(this).next('.validation').remove();
                });

                // submit form using ajax with jquery
                $("#network_form").submit(function(e) {
                    e.preventDefault();

                    var form = $("#network_form")[0];

                    var formData = new FormData(form);
                    var url = "{{ url('/') }}/networks";

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
                        success: function(data, textStatus, jqXHR) {
                            if (data['success']) {
                                $("#network_form")[0].reset();
                                window.location = "{{ url('/') }}/thankyou";
                            } else {
                                // .errors = data['errors']
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

        <script>
            $(document).ready(function() {
                // Bind a click event to the custom-select-wrapper
                $(".custom-select-wrapper").click(function() {
                    // Trigger a click event on the select element to open its options
                    $(".btn-container").click();
                });
            });
        </script>

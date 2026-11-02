{{-- Affiliate Network --}}
<div class="border px-2 net-div">
    <div class="d-flex mt-2 border-bottom mob-net">
        <p>Affiliate Network</p>
        @foreach ($network_verticals as $verticals)
            <div class="mx-1">
                <span class="badge net-badge mx-1" style="margin-top: 5px;"><i class="{{ $verticals->icon }}"></i>
                    {{ $verticals->title }}</span>
            </div>
        @endforeach
    </div>
    <div class="d-flex mt-3">
        <img src="{{ asset($network->logo) }}" alt="" class="net-img">
        <div class="d-flex mx-2 mt-1">
            <div class="tab-net-nm" style="width: 80px;">
                <h6 class="fw-bold text-capitalize">{{ $network->network_name }}</h6>
                <p><small class="text-muted">Reviews ({{ $network->review_count }})</small></p>
            </div>
            <div class="mx-2 mt-1">
                {{-- Get Ratings --}}
                @php
                    $ratings = $network->rating; // Replace with your rating value
                    $maxRating = 5; // Maximum rating value
                    
                    $filledStars = floor($ratings);
                    $hasHalfStar = $ratings - $filledStars >= 0.5;
                    $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
                @endphp
                <div class="net-rating d-flex">
                    {{-- filled star  --}}
                    @for ($i = 0; $i < $filledStars; $i++)
                        <i class="fas fa-3x fa-star"></i>
                    @endfor
                    {{-- half star --}}
                    @if ($hasHalfStar)
                        <i class="fas fa-3x fa-star-half-alt"></i>
                    @endif
                    {{-- empty star --}}
                    @for ($i = 0; $i < $emptyStars; $i++)
                        <i class="fas fa-3x fa-star icon-color"></i>
                    @endfor
                </div>
                {{-- social link --}}
                {{-- ########################################################## --}}
                @foreach ($sociallink as $social)
                    <div class="mt-2 mob-net-icon d-inline">
                        @php
                            $parsedUrl = parse_url($social->social_link);
                            $path = isset($parsedUrl['path']) ? ltrim($parsedUrl['path'], '/') : '';
                        @endphp

                        @if (strpos($path, 'facebook') !== false)
                            <a href="//{{ $path }}" target="_blank" style="color: black">
                                <i class="fa-brands fa-facebook"></i>
                            </a>
                        @elseif (strpos($path, 'twitter') !== false)
                            <a href="//{{ $path }}" target="_blank" style="color: black">
                                <i class="fa-brands fa-twitter"></i>
                            </a>
                        @elseif (strpos($path, 'linkedin') !== false)
                            <a href="//{{ $path }}" target="_blank" style="color: black">
                                <i class="fa-brands fa-linkedin"></i>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>`
        {{-- review form --}}
        <div class="net-buttons">
            <button type="button" class="btn btn-sm btn-primary btn-fnt" data-bs-toggle="modal"
                data-bs-target="#exampleModal">Write A Review</button>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content" style="width: 108%">
                        <div class="modal-header">
                            <h6 class="modal-title text-capitalize" id="exampleModalLabel">{{ $network->network_name }}
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-body">
                                <form action="{{ url('/') }}/review" id="review_form" method="post"
                                    enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="inputName" class="form-label modal-lbl">Name:<span
                                                id="required">*</span></label>
                                        <input type="text" name="name" placeholder="Name" class="form-control"
                                            id="" oninput="removeValidationModalError('inputName')"
                                            autocomplete="on">
                                        <p class="formerror" id="inputNameError"></p>
                                    </div>
                                    <div class="col-md-6"></div>
                                    <div class="col-md-6">
                                        <label for="inputEmail" class="form-label modal-lbl">Email:<span
                                                id="required">*</span></label>
                                        <input type="email" name="email" placeholder="Email" class="form-control"
                                            id="inputEmail" oninput="removeValidationModalError('inputEmail')"
                                            style="font-size: 1rem">
                                        <p class="formerror" id="inputEmailError"></p>
                                    </div>
                                    <div class="col-md-6">

                                        <input type="hidden" name="network_id" class="form-control" id="inputEmail"
                                            value="{{ $network->network_id }}"
                                            oninput="removeValidationModalError('inputEmail')">
                                        <p class="formerror" id="inputEmailError"></p>
                                    </div>
                                    <div class="col-md-6"></div>
                                    {{-- 22222222222222222222222222222 --}}

                                    <div class="col-md-12">
                                        <label for="rating" class="form-label modal-lbl">Your overall
                                            rating
                                            of
                                            this network:</label>
                                        <div id="full-stars-example">
                                            <div class="rating-group">
                                                <input class="rating__input rating__input--none" name="all_rating"
                                                    id="rating-none" value="0" type="radio" checked>
                                                <label aria-label="No rating" class="rating__label"
                                                    for="rating-none"></label>
                                                <label aria-label="1 star" class="rating__label" for="rating-1"><i
                                                        class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                <input class="rating__input" name="all_rating" id="rating-1"
                                                    value="1" type="radio">
                                                <label aria-label="2 stars" class="rating__label" for="rating-2"><i
                                                        class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                <input class="rating__input" name="all_rating" id="rating-2"
                                                    value="2" type="radio">
                                                <label aria-label="3 stars" class="rating__label" for="rating-3"><i
                                                        class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                <input class="rating__input" name="all_rating" id="rating-3"
                                                    value="3" type="radio">
                                                <label aria-label="4 stars" class="rating__label" for="rating-4"><i
                                                        class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                <input class="rating__input" name="all_rating" id="rating-4"
                                                    value="4" type="radio">
                                                <label aria-label="5 stars" class="rating__label" for="rating-5"><i
                                                        class="rating__icon rating__icon--star fa fa-star"></i></label>
                                                <input class="rating__input" name="all_rating" id="rating-5"
                                                    value="5" type="radio">
                                            </div>
                                        </div><span class="formerror" id="ratingError"></span>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="rating" class="form-label modal-lbl">Could you say a
                                            little
                                            more about it?:</label>
                                        <div class="row">
                                            <label for="rating" class="col-md-2 form-label modal-lbl">Offer
                                                Rating</label>
                                            <div class="col-md-4 col-sm-6 rating-system1">
                                                <input type="radio" name='offer_rating' value="5"
                                                    id="star5" />
                                                <label for="star5"></label>

                                                <input type="radio" name='offer_rating' value="4"
                                                    id="star4" />
                                                <label for="star4"></label>

                                                <input type="radio" name='offer_rating' value="3"
                                                    id="star3" />
                                                <label for="star3"></label>

                                                <input type="radio" name='offer_rating' value="2"
                                                    id="star2" />
                                                <label for="star2"></label>

                                                <input type="radio" name='offer_rating' value="1"
                                                    id="star1" />
                                                <label for="star1"></label>
                                            </div>

                                            <label for="rating" class="col-md-2 form-label modal-lbl">Payout
                                                Rating</label>
                                            <div class="col-md-4 rating-system2">
                                                <input type="radio" name='payout_rating' value="5"
                                                    id="star10" />
                                                <label for="star10"></label>

                                                <input type="radio" name='payout_rating' value="4"
                                                    id="star9" />
                                                <label for="star9"></label>

                                                <input type="radio" name='payout_rating' value="3"
                                                    id="star8" />
                                                <label for="star8"></label>

                                                <input type="radio" name='payout_rating' value="2"
                                                    id="star7" />
                                                <label for="star7"></label>

                                                <input type="radio" name='payout_rating' value="1"
                                                    id="star6" />
                                                <label for="star6"></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="rating" class="col-md-2 form-label modal-lbl">Tracking
                                                Rating</label>
                                            <div class="col-md-4 rating-system3">
                                                <input type="radio" name='tracking_rating' value="5"
                                                    id="star15" />
                                                <label for="star15"></label>

                                                <input type="radio" name='tracking_rating' value="4"
                                                    id="star14" />
                                                <label for="star14"></label>

                                                <input type="radio" name='tracking_rating' value="3"
                                                    id="star13" />
                                                <label for="star13"></label>

                                                <input type="radio" name='tracking_rating' value="2"
                                                    id="star12" />
                                                <label for="star12"></label>

                                                <input type="radio" name='tracking_rating' value="1"
                                                    id="star11" />
                                                <label for="star11"></label>
                                            </div>

                                            <label for="rating" class="col-md-2 form-label modal-lbl">Support
                                                Rating</label>
                                            <div class="col-md-4 rating-system4">
                                                <input type="radio" name='support_rating' value="5"
                                                    id="star20" />
                                                <label for="star20"></label>

                                                <input type="radio" name='support_rating' value="4"
                                                    id="star19" />
                                                <label for="star19"></label>

                                                <input type="radio" name='support_rating' value="3"
                                                    id="star18" />
                                                <label for="star18"></label>

                                                <input type="radio" name='support_rating' value="2"
                                                    id="star17" />
                                                <label for="star17"></label>

                                                <input type="radio" name='support_rating' value="1"
                                                    id="star16" />
                                                <label for="star16"></label>
                                            </div>
                                        </div>
                                        <p class="formerror" id="ratingDetailsError"></p>
                                    </div>


                                    <p class="formerror" id="ratingDetailsError"></p>
                                    <div class="col-md-12">
                                        <label for="Textarea1" class="form-label modal-lbl">Your
                                            Review:<span id="required">*</span></label>
                                        <textarea class="form-control" name="review_text" id="Textarea1" rows="3"></textarea>
                                        <p class="formerror" id="reviewError"></p>
                                    </div>
                                    <div class="col-md-8">
                                        <label for="image-input" class="form-label modal-lbl">Upload
                                            Your
                                            Payment Screenshot (optional)</label>
                                        <label for="image-input" class="upload-button">
                                            <span class="custom-icon"><i class="fas fa-upload"></i></span>
                                            <span class="custom-text">Select Image</span>
                                            <input type="file" name="review_img" id="image-input"
                                                accept="image/*">
                                        </label>
                                        <div id="selected-file-name"></div>
                                        <div id="image-preview"></div>

                                    </div>
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-sm btn-primary">Submit
                                            Review</button>
                                    </div>
                                </form>
                            </div>
                            {{-- submit write review form --}}
                            <script>
                                $(document).ready(function() {

                                    // hare  validation function
                                    function displayValidatorErrors(errors) {

                                        // hare use validation class for css style
                                        $('.validation').remove(); // Remove existing error messages

                                        $.each(errors, function(field, messages) {
                                            $.each(messages, function(index, message) {
                                                var errorItem = $('<div>').text(message);
                                                var errorMessage = $('<div>').addClass('validation').append(errorItem);

                                                $('input[name="' + field + '"]').after(errorMessage);
                                                $('textarea[name="' + field + '"]').after(errorMessage);

                                            });
                                        });
                                    }

                                    // submit form using with jquery ajax
                                    $("#review_form").submit(function(e) {
                                        e.preventDefault();

                                        var form = $("#review_form")[0];

                                        var formData = new FormData(form);
                                        var url = "{{ url('/') }}/review";

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
                                                console.log('Form submitted successfully!');
                                                if (data['success']) {
                                                    $("#review_form")[0].reset();
                                                    window.location = "{{ url('/') }}/thankyou";
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
            </div>
            <a href="{{ $network->network_url }}" target="_blank">
                <button class="btn btn-sm text-light btn-fnt" style="background-color: #2C1B47;">Join
                    Now</button>
            </a>
        </div>
        {{-- ** side rating --}}
        {{-- 
        <div class="rating-badge fw-bold lh-1 mt-2">
            <p><span class="badge join-badge">{{ $network_review[0]->offer_rating }}</span> Offer Rating</p>
            <p><span class="badge join-badge">{{ $network_review[0]->payout_rating }}</span> Payout Rating</p>
            <p><span class="badge join-badge">{{ $network_review[0]->tracking_rating }}</span> Tracking Rating</p>
            <p><span class="badge join-badge">{{ $network_review[0]->support_rating }}</span> Support
                Rating</p>
        </div> --}}
    </div>
    <div class="mt-2 mob-net-desc">
        <p class="read-text text-capitalize" id="networkDescription" style="margin-bottom: 0rem;">
            {{ $network->network_description }}
        </p>
        @if (strlen($network->network_description) > 200)
            <p class="net-read-more text-primary mb-3" onclick="toggleReadMore()" id="myBtn">
                Read more
            </p>
        @endif
    </div>
</div>

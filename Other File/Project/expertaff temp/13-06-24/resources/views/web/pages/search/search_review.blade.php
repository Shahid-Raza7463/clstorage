<div class="col-md-7 col-sm-12 border" style="background-color:#f9f9f9;" id="reviews">
    <div class="d-flex justify-content-between mt-2 mobile-featured-net">
        <h6 class="fw-bold">Search Reviews Results</h6>
    </div>
    @foreach ($networks_review as $network)
        <div class="border mt-3 bg-light rounded feature-rvm">
            <div class="d-flex mt-2">
                <a href="/affiliate-network/{{ $network->network_slug }}">
                    <img src="{{ asset($network->logo) }}" class="img-fluid rounded-circle reviews-img mx-3">
                </a>
                <div class="m-review-title">
                    @php
                        $ratings = $network->rating; // Replace with your rating value
                        $maxRating = 5; // Maximum rating value
                        
                        $filledStars = floor($ratings);
                        $hasHalfStar = $ratings - $filledStars >= 0.5;
                        $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
                    @endphp
                    <div class="reviews-rating d-flex">
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
                        <a href="/affiliate-network/{{ $network->network_slug }}">
                            <h6 class="text-dark mx-2">{{ $network->network_name }}</h6>
                        </a>
                    </div>
                </div>
                <div class="mobile-post" style="margin-left: 254px;">
                    {{-- for posted x days/hours --}}
                    @php
                        $createdTime = \Carbon\Carbon::parse($network->created_at);
                        $timeAgo = $createdTime->diffForHumans(null, true);
                    @endphp
                    <p class="text-secondary px-2 reviews-post-tym">Posted {{ $timeAgo }} ago</p>
                </div>
            </div>

            <div class="d-flex mx-3 mt-2 lh-sm mobile-tags">
                <div class="review-card mt-3">
                    <p>Offers <span class="badge bg-secondary rvm-badge"
                            style="margin-left: 18px;">{{ $network->offer_rating }}</span>
                    </p>
                    <p style="margin-top: -10px;">Tracking <span
                            class="badge bg-secondary mx-1">{{ $network->tracking_rating }}</span></p>
                </div>
                <div class="review-card mt-3 mx-1">
                    <p>Payout <span class="badge bg-secondary rvm-badge2"
                            style="margin-left: 11px;">{{ $network->payout_rating }}</span>
                    </p>
                    <p style="margin-top: -10px;">Support <span
                            class="badge bg-secondary mx-1">{{ $network->support_rating }}</span></p>
                </div>
            </div>

            <div class="reviews-desc-2">
                <p style="height: 4rem">{{ $network->review_text }}</p>
            </div>


            <div class="d-flex justify-content-between mx-3 mb-1 mobile-rv" style="margin-top: -13px;">
                <div class="d-flex functionality">
                    <a href="#" class="text-secondary like-btn"><i class="fa-solid fa-thumbs-up"></i>
                        <span class="like-count">10</span></a>
                    <a href="#" class="text-secondary mx-3 dislike-btn"><i class="fa-solid fa-thumbs-down"></i>
                        <span class="dislike-count">5</span></a>
                    <a href="#" class="text-secondary share-btn"><i class="fa-solid fa-share-nodes"></i>
                        Share</a>
                </div>
                <div>
                    <a href="#" class="text-primary"><i class="fa-solid fa-reply"></i> Reply</a>
                </div>
            </div>
            <div>
                {{-- implementation of lightbox --}}
                @if ($network->review_img)
                    <div>
                        <a href="{{ asset($network->review_img) }}"
                            data-lightbox="review-images{{ $network->review_id }}">
                            <img src="{{ asset($network->review_img) }}" alt=""
                                style="height: 3rem; width: 36rem;">
                        </a>
                    </div>
                @endif
                <script>
                    lightbox.option({
                        'resizeDuration': 200,
                        'wrapAround': true
                    })
                </script>
            </div>



        </div>
    @endforeach
    {{-- get like and dislike functionality --}}
    <script>
        $(document).ready(function() {
            $('.functionality').each(function() {
                var network = $(this);
                var likeBtn = network.find('.like-btn');
                var dislikeBtn = network.find('.dislike-btn');
                var likeCountElement = network.find('.like-count');
                var dislikeCountElement = network.find('.dislike-count');
                var isLiked = false;
                var isDisliked = false;

                likeBtn.click(function(e) {
                    e.preventDefault();
                    if (!isLiked && !isDisliked) {
                        var likeCount = parseInt(likeCountElement.text());
                        likeCount += 1;
                        likeCountElement.text(likeCount);
                        $(this).find('i').addClass('clicked');
                        isLiked = true;
                        dislikeBtn.addClass('disabled');
                    } else if (isLiked && !isDisliked) {
                        var likeCount = parseInt(likeCountElement.text());
                        likeCount -= 1;
                        likeCountElement.text(likeCount);
                        $(this).find('i').removeClass('clicked');
                        isLiked = false;
                        dislikeBtn.removeClass('disabled');
                    }
                });

                dislikeBtn.click(function(e) {
                    e.preventDefault();
                    if (!isLiked && !isDisliked) {
                        var dislikeCount = parseInt(dislikeCountElement.text());
                        dislikeCount += 1;
                        dislikeCountElement.text(dislikeCount);
                        $(this).find('i').addClass('clicked');
                        isDisliked = true;
                        likeBtn.addClass('disabled');
                    } else if (!isLiked && isDisliked) {
                        var dislikeCount = parseInt(dislikeCountElement.text());
                        dislikeCount -= 1;
                        dislikeCountElement.text(dislikeCount);
                        $(this).find('i').removeClass('clicked');
                        isDisliked = false;
                        likeBtn.removeClass('disabled');
                    }
                });
            });
        });
    </script>

    <!--pagination-->
    <div class="pagination ">
        {{ $networks_review->links('vendor.pagination.default') }}
    </div>

</div>

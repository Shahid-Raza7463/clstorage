<!--reviews-->
<div class="border px-2 net-div mt-3">
    <div class="border text-center pt-1 net-rv">
        <h6 class="fw-bold">Reviews</h6>
    </div>
    @if (count($network_review) > 0)
        @foreach ($network_review as $review)
            <div class="border mt-3 bg-light rounded feature-rvm target-p">
                <div class="d-flex mt-2">
                    <img src="{{ asset($review->logo) }}" class="img-fluid rounded-circle reviews-img mx-3">
                    <div class="m-review-title">
                        @php
                            $ratings = $review->all_rating; // Replace with your rating value
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

                            <h6 class="mx-2 text-capitalize" style="color: #3d4852; font-weight:bold">
                                {{ $review->name }}</h6>
                        </div>
                    </div>

                    {{-- Get time in this formate posted x days ago --}}
                    <div class="mobile-post" style="margin-left: 254px;">
                        @php
                            // omly change hare
                            $createdTime = \Carbon\Carbon::parse($review->created_at);
                            $timeAgo = $createdTime->diffForHumans(null, true);
                        @endphp
                        <p class="text-secondary px-2 reviews-post-tym">Posted {{ $timeAgo }} ago</p>
                    </div>
                </div>

                <div class="d-flex mx-3 mt-2 lh-sm mobile-tags">
                    <div class="review-card mt-3">
                        <p>Offers <span class="badge bg-secondary rvm-badge"
                                style="margin-left: 18px;">{{ $review->offer_rating }}</span>
                        </p>
                        <p style="margin-top: -10px;">Tracking <span
                                class="badge bg-secondary mx-1">{{ $review->tracking_rating }}</span>
                        </p>
                    </div>
                    <div class="review-card mt-3 mx-1">
                        <p>Payout <span class="badge bg-secondary rvm-badge2"
                                style="margin-left: 11px;">{{ $review->payout_rating }}</span>
                        </p>
                        <p style="margin-top: -10px;">Support <span
                                class="badge bg-secondary mx-1">{{ $review->support_rating }}</span>
                        </p>
                    </div>
                </div>

                <div class="reviews-desc-2">
                    <p style="height: 4rem" class="text-capitalize">{{ $review->review_text }}</p>
                </div>


                <div class="d-flex justify-content-between mx-3 mb-1 mobile-rv" style="margin-top: -13px;">
                    {{-- like and dislike functionality  --}}
                    <div class="d-flex functionality rv-tab">
                        {{-- rv-tab --}}
                        <a href="#" class="text-secondary like-btn"><i class="fa-solid fa-thumbs-up"></i>
                            <span class="like-count">15</span></a>
                        <a href="#" class="text-secondary mx-3 dislike-btn"><i
                                class="fa-solid fa-thumbs-down"></i>
                            <span class="dislike-count">5</span></a>
                        <a href="#" class="text-secondary share-btn"><i class="fa-solid fa-share-nodes"></i>
                            Share</a>
                    </div>
                </div>
                {{-- reply functionality --}}
                <button class="reply-btn text-primary network-reply-btn"><i class="fa-solid fa-reply"
                        style="margin-right: 6px"></i>Reply</button>
                <div class="message">
                    @include('web.pages.network.replyform')
                </div>

                {{-- implementation of lightbox --}}
                @if ($review->review_img)
                    <div>
                        <a href="{{ asset($review->review_img) }}"
                            data-lightbox="review-images{{ $review->review_id }}">
                            <img src="{{ asset($review->review_img) }}" alt=""
                                style="height: 6rem; width: 36rem;">
                        </a>
                    </div>
                @endif
                <script>
                    lightbox.option({
                        'resizeDuration': 200,
                        'wrapAround': true
                    })
                </script>
                {{-- implementation of lightbox end --}}

                {{-- show all reply hare  --}}
                <div>
                    @include('web.pages.network.showreplyreview')
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-danger mt-3" role="alert">
            Data Not Available.
        </div>
    @endif
    {{-- get like and dislike functionality --}}
    <script>
        $(document).ready(function() {
            $('.rv-tab').each(function() {
                var review = $(this);
                var likeBtn = review.find('.like-btn');
                var dislikeBtn = review.find('.dislike-btn');
                var likeCountElement = review.find('.like-count');
                var dislikeCountElement = review.find('.dislike-count');
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
        {{ $network_review->links('vendor.pagination.default') }}
    </div>
</div>

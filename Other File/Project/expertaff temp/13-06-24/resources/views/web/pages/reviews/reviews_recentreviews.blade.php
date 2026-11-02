<!-- Filter Table -->
<div class="filter-container mx-1">
    <div class="container mt-3 d-flex justify-content-between gap-3 p-3 mobile-review">
        {{-- Stop displaying reviews after the first two reviews --}}
        @php
            $reviewCount = 0;
        @endphp
        @foreach ($networks_review as $network)
            @php
                $reviewCount++;
                if ($reviewCount > 2) {
                    // Stop displaying reviews after the first two
                    break;
                }
            @endphp
            <div class="border  bg-light rounded">
                <div class="d-flex mt-2">
                    <img src="{{ asset($network->logo) }}" class="img-fluid rounded-circle reviews-img mx-3">
                    <div class="reviews-rating d-flex">
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

                            <h6 class="text-dark text-capitalize" style="color: #3d4852; font-weight: 600;">
                                {{ $network->name }}</h6>
                            <h6 class="text-dark mx-2"><span style="color:#3490dc;font-weight: 600;">@</span><span
                                    style="color:#3490dc;font-weight: 600;">{{ $network->network_name }}</span>
                            </h6>
                        </div>
                    </div>
                    <div class="mobile-post" style="margin-left: 172px;">
                        {{-- for posted x days/hours --}}
                        @php
                            $createdTime = \Carbon\Carbon::parse($network->created_at);
                            $timeAgo = $createdTime->diffForHumans(null, true);
                        @endphp
                        <p class="text-secondary px-2 reviews-post-tym">Posted {{ $timeAgo }} ago</p>
                    </div>
                </div>
                <div class="d-flex mx-3 mt-2 lh-sm mobile-tags" style="    width: 191px;">
                    <div class="review-card mt-3" style="width: 108px;">
                        <p>Offers <span class="badge bg-secondary rvm-badge"
                                style="margin-left: 20px;">{{ $network->offer_rating }}</span>
                        </p>
                        <p style="margin-top: -10px;">Tracking <span
                                class="badge bg-secondary mx-1">{{ $network->tracking_rating }}</span></p>
                    </div>
                    <div class="review-card mt-3 mx-1" style="width: 108px;">
                        <p>Payout <span class="badge bg-secondary rvm-badge2"
                                style="margin-left: 10px;">{{ $network->payout_rating }}</span>
                        </p>
                        <p style="margin-top: -10px;">Support <span
                                class="badge bg-secondary mx-1">{{ $network->support_rating }}</span></p>
                    </div>
                </div>
                <div class="reviews-desc">
                    <p class="text-justify" style="margin-left: 23px;">{{ $network->review_text }}</p>
                </div>

                <div class="d-flex justify-content-between mx-3 mb-1 mobile-rv" style="margin-top: -13px;">
                    <div class="d-flex functionality" style="margin-top: 10px">
                        <a href="#" class="text-secondary like-btn"><i class="fa-solid fa-thumbs-up"></i>
                            <span class="like-count">10</span></a>
                        <a href="#" class="text-secondary mx-3 dislike-btn"><i
                                class="fa-solid fa-thumbs-down"></i>
                            <span class="dislike-count">5</span></a>
                        <a href="#" class="text-secondary share-btn"><i class="fa-solid fa-share-nodes"></i>
                            Share</a>
                    </div>
                </div>

                {{-- reply functionality --}}
                <button class="reply-btn text-primary review-reply-btn"><i class="fa-solid fa-reply"
                        style="margin-right: 6px"></i>Reply</button>
                <div class="message">
                    @include('web.pages.reviews.recentreplyform')
                </div>
                <div>
                    @include('web.pages.reviews.showreplyreview')
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="col-md-7 col-sm-12 border" id="network">

    <div class="d-flex justify-content-between mt-2 mobile-featured-net" style="border-bottom: 3px #f3f3f3 solid">
        <h6 class="fw-bold">Search Results</h6>
    </div>
    <div class="div-strip mt-3">
        <div class="table-div2">
            <div class="table-secondary d-flex justify-content-between head-div">
                <h6 class="net-head mx-2">Networks</h6>
                <h6 class="join-head">Join</h6>
            </div>
            @if (count($networks) > 0)
                @foreach ($networks as $network)
                    <div class="d-flex justify-content-between mt-2 mt-4">
                        <div class="d-flex mobile-td mx-2">
                            <a href="/affiliate-network/{{ $network->network_slug }}">
                                <img src="{{ asset($network->logo) }}" class="img-fluid network-list-img rounded">
                            </a>

                            <div class="mx-5 prm-mobile-cont" style="    margin-top: -5px;">
                                <h6 class="net-h6 d-flex"><a href="/affiliate-network/{{ $network->network_slug }}"
                                        class="  text-dark">{{ $network->network_name }}</a>
                                    <div class="network-icon mx-2">
                                        @foreach (explode(',', $network->verticals_titles) as $vt)
                                            <i class="{{ explode(':', $vt)[1] }}"
                                                title="{{ explode(':', $vt)[0] }}"></i>
                                        @endforeach
                                    </div>
                                </h6>
                                <div class="prm-desc text-secondary" style="width: 20rem;">
                                    <p>{{ $network->network_description }}</p>
                                </div>
                                <div class="net-text" style="width: 20rem;  margin-bottom:-2px">
                                    <span style="margin-right: 7px;">
                                        {{ $network->review_count }} Reviews
                                    </span>
                                    <span> / </span>
                                    <span style="margin-right: 7px;">
                                        {{ $network->offer_count }} Offers
                                    </span>
                                    <span> / </span>
                                    <span style="margin-right: 7px;">
                                        {{ $network->affiliate_tracking_software }}
                                    </span>
                                    <span> / </span>
                                    <span style="margin-right: 7px;">
                                        {{ $network->name }}
                                    </span>
                                </div>
                                {{-- {{ $network->review_count }} --}}
                            </div>
                        </div>
                        <div class="mt-2 prm-mobile-btn">
                            <a href="{{ $network->network_url }}" target="_blank">
                                <button type="button" class="network-list-btn" fdprocessedid="zl9h6l">Join
                                    Now</button>
                            </a>
                            <span class="badge network-join-badge">{{ $network->rating }}</span>

                            @php
                                $ratings = $network->rating; // Replace with your rating value
                                $maxRating = 5; // Maximum rating value
                                
                                $filledStars = floor($ratings);
                                $hasHalfStar = $ratings - $filledStars >= 0.5;
                                $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            <div class="network-rating d-flex">
                                {{-- Empty stars --}}
                                @for ($i = 0; $i < $emptyStars; $i++)
                                    <i class="fas fa-3x fa-star icon-color"></i>
                                @endfor
                                {{-- Half-star --}}
                                @if ($hasHalfStar)
                                    <i class="fas fa-3x fa-star-half-alt"></i>
                                @endif

                                {{-- Filled stars --}}
                                @for ($i = 0; $i < $filledStars; $i++)
                                    <i class="fas fa-3x fa-star"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="alert alert-danger m-4" role="alert">
                    Data Not Available.
                </div>
            @endif
        </div>
    </div>
    <div class="pagination ">
        {{-- call default blade from resource/vender/pagination --}}
        {{ $networks->links('vendor.pagination.default') }}
    </div>
</div>

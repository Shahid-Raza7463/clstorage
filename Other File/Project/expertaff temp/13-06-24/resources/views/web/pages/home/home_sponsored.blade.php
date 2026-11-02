<!-- sponsored Network -->
<div class="container mt-4">
    <div class="table-div">
        <div class="d-flex justify-content-between head-div">
            <h6 class="head-1">Sponsored Network</h6>
            <h6 class="head-2">Description</h6>
            <h6 class="head-3">Offers</h6>
            <h6 class="head-4">Join</h6>
        </div>
        @foreach ($sponsored_networks as $network)
            <div class="d-flex justify-content-between">
                <div class="d-flex mb-4">
                    <a href="/affiliate-network/{{ $network->network_slug }}">
                        <img src="{{ asset($network->logo) }}" class="img-fluid network-img rounded">
                    </a>
                    <div class="mx-4 mobile-div"style="width: 11rem;">

                        <h6 class="prm-net"><a href="/affiliate-network/{{ $network->network_slug }}"
                                class="  text-dark text-capitalize">{{ $network->network_name }}</a>
                            @if ($network->is_sponsored == 1)
                                <span class="badge spon-badge mx-1">
                                    Sponsored
                                </span>
                            @endif
                        </h6>
                        <div class="table-icon">
                            {{-- for icon grouping --}}
                            @foreach (explode(',', $network->verticals_titles) as $vt)
                                <i class="{{ explode(':', $vt)[1] }}" title="{{ explode(':', $vt)[0] }}"></i>
                            @endforeach
                        </div>

                        <div class="table-text mt-1" style="margin-bottom:7px; width: 212px;">
                            {{-- <p>{{ $network->review_count }} Reviews / {{ $network->affiliate_tracking_software }}/
                                {{ $network->name }}
                            </p> --}}

                            <span style="margin-right: 7px;">Reviews ({{ $network->review_count }})</span>
                            <span>/</span>
                            <span style="margin-right: 7px;">
                                {{ $network->affiliate_tracking_software }}
                            </span>
                            <span>/</span>
                            <span style="margin-right: 7px;">
                                {{ $network->name }}
                            </span>
                        </div>

                    </div>
                </div>
                <div class="desc-td" style="margin-left: -48px;">
                    <p class="description mt-2">{{ $network->network_description }}</p>
                </div>

                <div class="m-offer">
                    <p class="fw-bold off-text">{{ $network->offer_count }}</p>
                </div>

                <div class="m-td">
                    <a href="{{ $network->network_url }}" target="_blank">
                        <button type="button" class="btn table-btn mx-3" fdprocessedid="6sljwl">Join Now</button>
                    </a>
                    <div class="mt-2 mx-3">
                        <span class="badge join-badge">{{ $network->rating }}</span>

                        {{-- get rating (star) --}}
                        @php
                            $ratings = $network->rating; // Replace with your rating value
                            $maxRating = 5; // Maximum rating value
                            
                            $filledStars = floor($ratings);
                            // return true or false in $hashalfstar
                            $hasHalfStar = $ratings - $filledStars >= 0.5;
                            $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
                        @endphp
                        <div class="table-rating d-flex">
                            {{-- Empty stars --}}
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="fas fa-3x fa-star icon-color "></i>
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
            </div>
        @endforeach
    </div>
</div>

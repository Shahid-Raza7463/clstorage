<!-- top network -->
<div class="border side-compnt">
    <div class="mx-3 mt-2 side-tbl">
        <div>
            <h6 class="fw-bold">Top 10 Networks</h6>
        </div>
        @foreach ($top_networks as $top_network)
            <div class="d-flex justify-content-between">
                <div class="d-flex mobile-side mt-2">
                    <a href="/affiliate-network/{{ $top_network->network_slug }}">
                        <img src="{{ asset($top_network->logo) }}" class="img-fluid top-net-img rounded-circle ">
                    </a>
                    <div class="mx-3 mobile-side-compnt">
                        <a href="/affiliate-network/{{ $top_network->network_slug }}" class="  text-dark">
                            <p class="net text-capitalize">{{ $top_network->network_name }}</p>
                        </a>
                        <div class="mb-2">
                            @foreach (explode(',', $top_network->verticals_titles) as $vt)
                                <i class="{{ explode(':', $vt)[1] }}" title="{{ explode(':', $vt)[0] }}"></i>
                            @endforeach
                        </div>
                        <div class="d-flex m-badge" style="height: 18%;width: 162px;">
                            <span class="badge top-join-badge">{{ $top_network->rating }}</span>

                            @php
                                $ratings = $top_network->rating; // Replace with your rating value
                                $maxRating = 5; // Maximum rating value
                                
                                $filledStars = floor($ratings);
                                $hasHalfStar = $ratings - $filledStars >= 0.5;
                                $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
                            @endphp
                            <div class="top-rating d-flex">
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
                            <p class="top-text mx-1">Reviews ({{ $top_network->review_count }})</p>
                        </div>
                    </div>
                    <div class="mt-3 top-arrow">
                        <a href="/affiliate-network/{{ $top_network->network_slug }}"><i
                                class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

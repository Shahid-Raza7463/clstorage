<div class="border mt-4 side-compnt">
    <div class="mx-3 mt-2 side-tbl">
        <div>
            <h6 class="fw-bold">Featured Networks</h6>
        </div>
        <!---->
        @php
            $loopCount = 0;
        @endphp
        @foreach ($featured_networks as $featured_network)
            @php
                $loopCount++;
            @endphp
            <!-- featured network -->
            <div class="d-flex justify-content-between">
                <div class="d-flex mobile-side mt-2">
                    <a href="/affiliate-network/{{ $featured_network->network_slug }}
                    ">
                        <img src="{{ asset($featured_network->logo) }}" class="img-fluid top-net-img rounded-circle ">
                    </a>
                    <div class="mx-3 mobile-side-compnt">
                        <a href="/affiliate-network/{{ $featured_network->network_slug }}" class="  text-dark">
                            <p class="net text-capitalize">{{ $featured_network->network_name }}</p>
                        </a>
                        <div class=" mb-2">
                            @foreach (explode(',', $featured_network->verticals_titles) as $vt)
                                <i class="{{ explode(':', $vt)[1] }}" title="{{ explode(':', $vt)[0] }}"></i>
                            @endforeach
                        </div>
                        <div class="d-flex m-badge" style="height: 18%; width: 162px;">
                            <span class="badge top-join-badge">{{ $featured_network->rating }}</span>
                            {{-- rating star --}}
                            @php
                                $ratings = $featured_network->rating; // Replace with your rating value
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
                            <p class="top-text mx-1">Reviews ({{ $featured_network->review_count }})
                            </p>
                        </div>
                    </div>
                    <div class="mt-3 top-arrow">
                        <a href="/affiliate-network/{{ $featured_network->network_slug }}"><i
                                class="fa-solid fa-angles-right"></i></a>
                    </div>
                </div>
            </div>
            <!-- top adspace 5-->
            @if ($loopCount % 7 === 0)
                @include('web.pages.adspaces.top_adspace_5')
            @endif
        @endforeach
    </div>
</div>

{{-- top_offers --}}
<div class="border side-compnt">
    <div class="mb-1">
        <div class="border d-flex justify-content-between px-3 pt-1" style="background-color: #f3f3f3;">
            <h6 class="offer-heading">Top 10 Offers</h6>
            <h6 class="offer-heading">Networks</h6>
        </div>

        @php
            $count = 0;
        @endphp
        @foreach ($top_offers as $top_offer)
            @php
                $count++;
                if ($count > 10) {
                    // Stop displaying reviews after the first two
                    break;
                }
            @endphp
            <div class="d-flex justify-content-between mx-3 mt-3">
                <div class="d-flex">
                    <a href="/affiliate-network/{{ $top_offer->network_slug }}">
                        <img src="{{ asset('web/images/network img.jpg') }}"
                            class="img-fluid top-net-img rounded-circle ">
                    </a>
                    <div class="mx-3 mt-1 mb-4">
                        <a href="/affiliate-network/{{ $top_offer->network_slug }}" class="  text-dark">
                            <p class="offr"style="width: 160px;overflow:hidden;height: 30px; margin:0px">
                                {{ $top_offer->title }}
                            </p>
                        </a>
                        <span class="featured-offer-text text-secondary">{{ $top_offer->category }}</span>
                    </div>
                </div>
                <div>
                    <p class="mt-2 Approach-2"><a
                            href="/affiliate-network/{{ $top_offer->network_slug }}">{{ $top_offer->network_name }}</a>
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

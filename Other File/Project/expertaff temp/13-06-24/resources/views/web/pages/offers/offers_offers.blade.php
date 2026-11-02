{{-- offers --}}
<div class="col-md-7 col-sm-12 border" id="network">
    <div class="div-strip">
        <div class="border d-flex justify-content-between px-2 pt-1" style="background-color: #f3f3f3;">
            <h6 class="offer-heading" style="width: 57%">Offers</h6>
            <h6 class="offer-heading">Payout</h6>
            <h6 class="offer-heading">Networks</h6>
        </div>


        @foreach ($offers as $offer)
            <div class="d-flex justify-content-between mt-3 mx-2 mt-4">
                <div class="d-flex">
                    {{-- <a href="/affiliate-network/{{ $offer->network_slug }}">
                        <img src="{{ asset('web/images/square.jpg') }}" class="img-fluid offers-feature-img rounded">
                    </a> --}}
                    <a href="/affiliate-network/{{ $offer->network_slug }}">
                        <img src="{{ asset('web/images/square.jpg') }}" class="img-fluid network-img rounded">
                    </a>

                    <div class="mx-4 prm-title">
                        <h6 class="prm-net mt-1"
                            style="
                        width: 176px;
                        overflow: hidden;">
                            <a href="/affiliate-network/{{ $offer->network_slug }}"
                                class="  text-dark">{{ $offer->title }}</a>
                        </h6>
                        <span class="featured-offer-text text-secondary">{{ $offer->category }}</span>
                    </div>
                </div>
                <div class="mobile-pay">
                    <p class="mt-3 Approach mx-2">
                        <span>{{ $offer->currency }}</span>
                        {{-- <span>
                            @if ($offer->currency === 'United States, Dollars')
                                USD
                            @else
                                {{ $offer->currency }}
                            @endif
                        </span> --}}
                        <span class="mx-2">{{ $offer->payout }}</span>
                    </p>
                </div>
                <div>
                    <p class="mt-3 Approach"><a
                            href="/affiliate-network/{{ $offer->network_slug }}">{{ $offer->network_name }}</a></p>
                </div>
            </div>
        @endforeach
    </div>

    <!-- pagination -->
    {{-- @if ($offers->count() > 0) --}}
    <div class="pagination mb-4 ">
        {{-- call default blade from resource/vender/pagination --}}
        {{ $offers->links('vendor.pagination.default') }}
    </div>
    {{-- @endif --}}
</div>

{{-- Featured Offers --}}
<div class="mb-1">
    <div class="border d-flex justify-content-between px-3 pt-1" style="background-color: #f3f3f3;">
        <h6 class="offer-heading">Featured Offers</h6>
        <h6 class="offer-heading">Networks</h6>
    </div>

    @foreach ($featured_offers as $featured_offer)
        <div class="d-flex justify-content-between mx-3 mt-3">
            <div class="d-flex">
                <a href="/affiliate-network/{{ $featured_offer->network_slug }}">
                    <img src="{{ asset('web/images/network img.jpg') }}" class="img-fluid top-net-img rounded-circle ">
                </a>
                <div class="mx-3 mt-1">
                    <a href="/affiliate-network/{{ $featured_offer->network_slug }}" class="text-dark">
                        <p class="offr">{{ $featured_offer->title }}</p>
                    </a>
                    {{-- <p class="top-offer-text text-secondary">#Olavivo #Crypto</p> --}}
                    <span class="featured-offer-text text-secondary">{{ $featured_offer->category }}</span>
                </div>
            </div>
            <div>
                <p class="mt-2 Approach-2"><a
                        href="/affiliate-network/{{ $featured_offer->network_slug }}">{{ $featured_offer->network_name }}</a>
                </p>
            </div>
        </div>
    @endforeach
</div>

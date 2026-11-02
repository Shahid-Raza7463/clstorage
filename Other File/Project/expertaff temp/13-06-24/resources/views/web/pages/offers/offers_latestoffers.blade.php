<div class="mx-1 mb-1">
    <div class="container filter-table mt-3 p-3">
        <div class="border rounded">
            <div class="mb-2">
                <div class="border d-flex justify-content-between px-2 pt-1" style="background-color: #f3f3f3;">
                    <div class="col-md-6" style="display: contents;">
                        <h6 class="offer-heading">Latest Offers</h6>
                    </div>
                    {{-- <div class="col-md-6" style="display: contents;">
                        <h6 class="offer-heading" style="margin-left: 29px;">Latest Offers</h6>
                        <h6 class="offer-heading" style="margin-left: 293px;">Networks</h6>
                    </div> --}}
                </div>
                <div class="row">
                    @php
                        $count = 0;
                    @endphp
                    @foreach ($latest_offers as $latest_offer)
                        @php
                            $count++;
                            if ($count > 10) {
                                // display first 5 items
                                break;
                            }
                        @endphp
                        <!-- First Column -->
                        <div class="col-md-6">
                            <div class="d-flex justify-content-between px-2 mt-2 mb-4">
                                <div class="d-flex">
                                    <a href="/affiliate-network/{{ $latest_offer->network_slug }}">
                                        <img src="{{ asset('web/images/olavivo.jpg') }}"
                                            class="img-fluid network-img rounded">
                                    </a>

                                    <div class="mx-4 mt-1 filter-title">
                                        <h6 class="prm-net"
                                            style="width: 285px;
                                        overflow: hidden;">
                                            <a href="/affiliate-network/{{ $latest_offer->network_slug }}"
                                                class="fw-bold text-dark">{{ $latest_offer->title }}</a>
                                        </h6>
                                        <span
                                            class="featured-offer-text text-secondary">{{ $latest_offer->category }}</span>
                                    </div>
                                </div>
                                <div class="apr-tab">
                                    <p class="mt-2 Approach-2"><a
                                            href="/affiliate-network/{{ $latest_offer->network_slug }}">{{ $latest_offer->network_name }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- advertising Network details --}}
<div class="border net-div px-2 mt-3">
    <div class="border text-center pt-1 net-rv">
        <h6 class="fw-bold">Advertising Network details</h6>
    </div>
    <div class="text-center text-primary mt-2">
        <h6>Rating Distribution</h6>
    </div>
    <div class="programming-stats">
        <div class="details">
            <ul>
                <!--daigram rating display hare dynamicaly using javascript  -->
            </ul>
        </div>
        <div class="chart-container mt-3">
            <canvas class="my-chart">
                <div class="chart-label">
                    <span id="ratioLabel"></span>
                </div>
            </canvas>
        </div>
    </div>
    <div class="lh-1 mb-3 ad-net-tiles">
        {{-- Offer Rating --}}
        <div class="" style="display: flex;height: 27px;">
            <p style="font-size: 13px;margin-top: 8px;">Offer Rating</p>

            <style>
                .half-icon {
                    width: 17px;
                    overflow: hidden;
                }

                .half-icon i {
                    font-size: 34px;
                    color: #ffc107;
                }

                .half-icon2 {
                    width: 17px;
                    overflow: hidden;
                }

                .half-icon2 i {
                    font-size: 34px;
                    color: #d1d1d1;
                    margin-left: -6px;
                }
            </style>
            @php
                // Replace with your rating value
                $ratings = $network->offer_ratings;
                // Maximum rating value
                $maxRating = 5;
                
                $filledStars = floor($ratings);
                $hasHalfStar = $ratings - $filledStars >= 0.5;
                $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
            @endphp
            <div class="net-rating d-flex" style="margin-left: 23px;">
                {{-- filled star  --}}
                @for ($i = 0; $i < $filledStars; $i++)
                    <i class="fa-solid fa-minus" style="font-size: 34px;"></i>
                @endfor
                {{-- half star --}}
                @if ($hasHalfStar)
                    <div class="half-icon1">
                        <i class="fa-solid fa-minus"></i>
                    </div>
                @endif
                {{-- empty star --}}
                @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="fa-solid fa-minus icon-color" style="font-size: 34px;"></i>
                @endfor
            </div>
        </div>

        {{-- payout_ratings --}}
        <div class="" style="display: flex;height: 27px;">
            <p style="font-size: 13px;margin-top: 8px;">Payout Rating</p>
            @php
                // Replace with your rating value
                $ratings = $network->payout_ratings;
                // Maximum rating value
                $maxRating = 5;
                
                $filledStars = floor($ratings);
                $hasHalfStar = $ratings - $filledStars >= 0.5;
                $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
            @endphp
            <div class="net-rating d-flex" style="margin-left: 12px;">
                {{-- filled star  --}}
                @for ($i = 0; $i < $filledStars; $i++)
                    <i class="fa-solid fa-minus" style="font-size: 34px;"></i>
                @endfor
                {{-- half star --}}
                @if ($hasHalfStar)
                    <div class="half-icon">
                        <i class="fa-solid fa-minus"></i>
                    </div>
                @endif
                {{-- empty star --}}
                @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="fa-solid fa-minus icon-color" style="font-size: 34px;"></i>
                @endfor
            </div>
        </div>


        {{-- Tracking Rating --}}
        <div class="" style="display: flex;height: 27px;">
            <p style="font-size: 13px;margin-top: 8px;">Tracking Rating</p>
            @php
                // Replace with your rating value
                $ratings = $network->tracking_ratings;
                // Maximum rating value
                $maxRating = 5;
                
                $filledStars = floor($ratings);
                $hasHalfStar = $ratings - $filledStars >= 0.5;
                $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
            @endphp
            <div class="net-rating d-flex" style="margin-left: 2px;">
                {{-- filled star  --}}
                @for ($i = 0; $i < $filledStars; $i++)
                    <i class="fa-solid fa-minus" style="font-size: 34px;"></i>
                @endfor
                {{-- half star --}}
                @if ($hasHalfStar)
                    <div class="half-icon">
                        <i class="fa-solid fa-minus"></i>
                    </div>
                @endif
                {{-- empty star --}}
                @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="fa-solid fa-minus icon-color" style="font-size: 34px;"></i>
                @endfor
            </div>
        </div>


        {{-- Support Rating --}}
        <div class="" style="display: flex;height: 27px;">
            <p style="font-size: 13px;margin-top: 8px;">Support Rating</p>
            @php
                // Replace with your rating value
                $ratings = $network->support_ratings;
                // Maximum rating value
                $maxRating = 5;
                
                $filledStars = floor($ratings);
                $hasHalfStar = $ratings - $filledStars >= 0.5;
                $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
            @endphp
            <div class="net-rating d-flex" style="margin-left: 6px;">
                {{-- filled star  --}}
                @for ($i = 0; $i < $filledStars; $i++)
                    <i class="fa-solid fa-minus" style="font-size: 34px;"></i>
                @endfor
                {{-- half star --}}
                @if ($hasHalfStar)
                    <div class="half-icon">
                        <i class="fa-solid fa-minus"></i>
                    </div>
                    <div class="half-icon2">
                        <i class="fa-solid fa-minus"></i>
                    </div>
                @endif
                {{-- empty star --}}
                @for ($i = 0; $i < $emptyStars; $i++)
                    <i class="fa-solid fa-minus icon-color" style="font-size: 34px;"></i>
                @endfor
            </div>
        </div>
    </div>
    <hr>

    <div class="mx-2">
        <button class="btn btn-sm border border-dark" disabled>For Publisher</button>
    </div>

    <div class="mx-3 mt-3">
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Commission Type</p>
            </div>


            <div class="col-md-8 col-6">
                @php
                    $commissionTypes = [];
                    foreach ($network_commission as $commission) {
                        $commissionTypes[] = $commission->name;
                    }
                    $commissionTypes = implode(', ', $commissionTypes);
                @endphp
                <p class="text-secondary d-inline">
                    {{ $commissionTypes }}
                </p>
            </div>
            {{-- <div class="col-md-8 col-6">
                @foreach ($network_commission as $commission)
                    <p class="text-secondary d-inline">
                        {{ $commission->name }}
                    </p>
                @endforeach
            </div> --}}
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Minimum Payment</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">
                    {{ $network->min_payout }}
                </p>
            </div>
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Payment Frequency</p>
            </div>
            <div class="col-md-8 col-6">
                @foreach ($network_frequency as $frequency)
                    <p class="text-secondary d-inline">
                        {{ $frequency->name }},
                    </p>
                @endforeach
            </div>
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Payment Method</p>
            </div>
            <div class="col-md-8 col-6">
                @foreach ($network_payment as $payment)
                    <p class="text-secondary d-inline">
                        {{ $payment->name }},
                    </p>
                @endforeach
            </div>
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Referral Commission</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">
                    {{ $network->referral_commission }}
                </p>
            </div>
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Publishers Contact</p>
            </div>
            <div class="col-md-8 col-6">
                @foreach ($contacts as $contact)
                    <a href="{{ $contact->email }}" class="text-secondary" target="_blank">{{ $contact->email }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- <div class="mx-2 mt-3">
        <button class="btn btn-sm border border-dark" disabled>For Advertiser</button>
    </div> --}}

    <div class="mx-3 mt-3">
        {{-- <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Ad Format</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">Popunder, Native, Interstitial, Push Notification, On-Page
                    Notification, Mobile Push-up</p>
            </div>
        </div> --}}
        {{-- <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Cost Model</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">CPC, CPM, CPA</p>
            </div>
        </div> --}}
        {{-- <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Minimum Deposit</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">$50</p>
            </div>
        </div> --}}
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Payment Method</p>
            </div>
            <div class="col-md-8 col-6">
                @foreach ($network_payment as $payment)
                    <p class="text-secondary d-inline">
                        {{ $payment->name }},
                    </p>
                @endforeach
            </div>
        </div>
        {{-- <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Daily Impression</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">1 Billion</p>
            </div>
        </div> --}}
        {{-- <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Top GEO</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">Worldwide</p>
            </div>
        </div> --}}
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Top Vertical</p>
            </div>
            <div class="col-md-8 col-6">
                @foreach ($network_verticals as $vertical)
                    <p class="text-secondary d-inline">
                        {{ $vertical->title }}
                    </p>,
                @endforeach
            </div>
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Referral Commission</p>
            </div>
            <div class="col-md-8 col-6">
                <p class="text-secondary">{{ $network->referral_commission }}</p>
            </div>
        </div>
        <div class="row ad-net-tbl">
            <div class="col-md-4 col-6">
                <p class="">Advertisers Contact</p>
            </div>
            <div class="col-md-8 col-6">
                @foreach ($contacts as $contact)
                    <a href="#" class="text-secondary">{{ $contact->email }} </a>
                @endforeach
            </div>
        </div>
    </div>



</div>

<!--optimization-->
{{-- <div class="border net-div px-2 mt-3">
    <div class="row py-3">
        <div class="col-md-6 text-center ">
            <p class="mt-4">Targeting & Optimization</p>
        </div>
        <div class="col-md-6">
            <div class="border rounded p-2">
                <div class="d-flex justify-content-center rounded net-rv2 mx-1">
                    <p class="self-serve"><i class="fa-regular fa-circle-check fs-5 mx-1"></i>Self-Serve
                        Platform
                    </p>
                </div>
                <div class="mt-1 text-center">
                    <a href="#" class="show-more" data-bs-toggle="modal" data-bs-target="#exampleModal2">Show
                        More <i class="fa-solid fa-angle-down"></i></a>
                </div>
                <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Targeting &
                                    Optimization List</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Self-Serve
                                                Platform</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>GEO
                                                Targeting</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Device
                                                Targeting</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>OS
                                                Targeting</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>ISP/Carrier
                                                Targeting</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Browser
                                                Targeting</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>IP
                                                Targeting</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Website
                                                Targeting</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Language
                                                Targeting</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Time
                                                Targeting</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Category
                                                Targeting</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Demographic
                                                Targeting</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Retargeting
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Black/White
                                                List</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Frequency
                                                Capping</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Token
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Anti-Fraud
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-reguxmarklar fa-circle-xmark fs-5 mx-1"></i>Adult
                                                Ads</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mt-1">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Gambling
                                                Ads</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-start rounded net-rv2 mx-1">
                                            <p class="self-serve"><i
                                                    class="fa-regular fa-circle-check fs-5 mx-1"></i>Personal
                                                Account Manager</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}

<!--offers-->
<div class="border px-2 net-div mt-3">
    <div class="border text-center pt-1 net-rv">
        <h6 class="fw-bold">Affiliate Offers</h6>
    </div>
    {{-- only take 3 offers hare using take() --}}

    @if (count($offers) > 0)
        @foreach ($offers->take(3) as $offer)
            <div class="border rounded p-1 mt-3">
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <img src="{{ asset('web/images/square.jpg') }}" class="img-fluid offers-feature-img rounded">
                        <div class="mx-4 prm-title" style="width: 244px;">
                            <h6 class="prm-net mt-1"><a href="/affiliate-network/{{ $network->network_slug }}"
                                    class="  text-dark">{{ $offer->title }}</a>
                            </h6>

                            <span class="featured-offer-text text-secondary"> {{ $offer->category }}</span>
                            {{-- @foreach ($offers_verticals as $vertical)
                                <span class="featured-offer-text text-secondary">#{{ $vertical->title }}</span>
                            @endforeach --}}
                        </div>
                    </div>
                    <div class="mobile-pay">
                        <p class="mt-3 Approach mx-2">
                            <span>{{ $offer->currency }}</span><span class="mx-2">{{ $offer->payout }}</span>
                        </p>
                    </div>
                    <div>
                        <p class="mt-3 Approach text-capitalize"><a
                                href="/affiliate-network/{{ $network->network_slug }}">{{ $offer->network_name }}</a>
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
        @if (count($offers) > 3)
            <!-- Show More link -->
            <div class="mt-3 p-2 text-center">
                <a href="#" class="show-more" id="showMoreLink">Show More <i
                        class="fa-solid fa-angle-down"></i></a>
            </div>
        @endif
    @else
        <div class="alert alert-danger m-4" role="alert">
            No Any Offers
        </div>
    @endif
</div>


{{-- show more functionality --}}
{{-- 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        var currentPage = 1;
        var perPage = 10;
        var totalOffers = {{ $offers->count() }};

        // Function to load and append more offers
        function loadMoreOffers() {
            var start = currentPage * perPage;
            var end = (currentPage + 1) * perPage;

            // Check if there are more offers to load
            if (start < totalOffers) {
                $.ajax({
                    url: '{{ route('load-more-offers') }}', // Replace with your Laravel route
                    type: 'GET',
                    data: {
                        start: start,
                        end: end
                    },
                    success: function(data) {
                        // Append the loaded offers to the container
                        $('.net-div').append(data);
                        currentPage++;
                    }
                });
            } else {
                // Hide the "Show More" link if no more offers are available
                $('#showMoreLink').hide();
            }
        }

        // Attach click event to the "Show More" link
        $('#showMoreLink').click(function(e) {
            e.preventDefault();
            loadMoreOffers();
        });
    });
</script> --}}

<!--donut chart / rating in diagram-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Donut chart data
    var data = @json($presentation_rating);
    // console.log(data);
    // Donut chart data
    const chartData = {
        labels: ["Excellent", "Very Good", "Average", "Poor", "Terrible"],
        data: [
            data.excellent,
            data.very_good,
            data.average,
            data.poor,
            data.triable
        ],
        backgroundColor: ["#006BBB", "#7DBAFB", "#FFA800", "#533582", "#000000"],
    };

    const myChart = document.querySelector(".my-chart");
    const ul = document.querySelector(".programming-stats .details ul");

    new Chart(myChart, {
        type: "doughnut",
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.data,
                backgroundColor: chartData.backgroundColor,
                borderWidth: 0,
            }, ],
        },
        options: {
            cutout: "80%",
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
            },
            tooltips: {
                enabled: false,
            },


        },
    });

    const populateUl = () => {
        chartData.labels.forEach((label, index) => {
            const li = document.createElement("li");
            const colorBox = document.createElement("span");
            colorBox.classList.add("color-box");
            colorBox.style.backgroundColor = chartData.backgroundColor[index];
            const percentageSpan = document.createElement("p");
            percentageSpan.classList.add("percentage");
            percentageSpan.textContent = `${chartData.data[index]}%`;

            li.appendChild(colorBox);
            li.appendChild(document.createTextNode(label + ": "));
            li.appendChild(percentageSpan);
            ul.appendChild(li);
        });
    };

    populateUl();
</script>

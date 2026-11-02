 <!-- premium  Network -->
 <div class="col-md-7 col-sm-12 border" id="network">
     <div class="d-flex justify-content-between mt-2 mobile-featured-net ">
         <h6 class="fw-bold">All Networks</h6>
         <div class="toggle-div">
             <div class="button-box">
                 <div id="btn"></div>
                 {{-- get latest network --}}
                 @if ($order_by == 'latest')
                     <a type="button" href="/?order_by=latest#network"> <button type="button" class="toggle-btn"
                             onclick="leftClick()">Latest</button></a>
                     <a type="button" href="/?order_by=reviews#network"> <button type="button" class="toggle-btn-2"
                             onclick="rightClick()">Most Reviewed</button></a>
                 @endif
                 {{-- get most reviewed networks --}}
                 @if ($order_by == 'reviews')
                     <a type="button" href="/?order_by=latest#network"><button type="button" class="toggle-btn"
                             onclick="leftClick()">Latest</button></a>
                     <a type="button"href="/?order_by=reviews#network"> <button
                             type="button"class="toggle-btn-2"onclick="rightClick()">Most Reviewed</button>
                     </a>
                 @endif
             </div>
         </div>
     </div>
     <div class="div-strip mt-3">
         <div class="table-div2">
             <div class="table-secondary d-flex justify-content-between head-div">
                 <h6 class="net-head mx-2">Networks</h6>
                 <h6 class="join-head">Join</h6>
             </div>
             @foreach ($premium_networks as $premium_network)
                 <div class="d-flex justify-content-between mt-2 mb-4">
                     <div class="d-flex mobile-td mx-2">
                         <a href="/affiliate-network/{{ $premium_network->network_slug }}">
                             <img src="{{ asset($premium_network->logo) }}" class="img-fluid network-list-img rounded">
                         </a>
                         <div class="mx-5 prm-mobile-cont" style="    margin-top: -5px;">
                             <h6 class="net-h6 d-flex"><a href="/affiliate-network/{{ $premium_network->network_slug }}"
                                     class="text-dark text-capitalize">{{ $premium_network->network_name }}</a>
                                 {{-- verticals icons --}}
                                 <div class="network-icon mx-2">
                                     @foreach (explode(',', $premium_network->verticals_titles) as $vt)
                                         <i class="{{ explode(':', $vt)[1] }}" title="{{ explode(':', $vt)[0] }}"></i>
                                     @endforeach
                                 </div>
                             </h6>
                             <div class="prm-desc text-secondary" style="width: 20rem;">
                                 <p>{{ $premium_network->network_description }}</p>
                             </div>
                             {{-- <div class="net-text" style="width: 20rem;">
                                 <p>{{ $premium_network->review_count }} Reviews /
                                     {{ $premium_network->offer_count }} Offers
                                     /{{ $premium_network->affiliate_tracking_software }} /
                                     {{ $premium_network->name }}</p>
                             </div> --}}

                             <div class="net-text" style="width: 20rem;  margin-bottom:-2px">
                                 <span style="margin-right: 7px;">
                                     Reviews ({{ $premium_network->review_count }})
                                 </span>
                                 <span> / </span>
                                 <span style="margin-right: 7px;">Offers ({{ $premium_network->offer_count }})
                                 </span>
                                 <span> / </span>
                                 <span style="margin-right: 7px;">
                                     {{ $premium_network->affiliate_tracking_software }}
                                 </span>
                                 <span> / </span>
                                 <span style="margin-right: 7px;">
                                     {{ $premium_network->name }}
                                 </span>
                             </div>

                         </div>
                     </div>
                     <div class="mt-2 prm-mobile-btn">
                         <a href="{{ $premium_network->network_url }}" target="_blank">
                             <button type="button" class="network-list-btn" fdprocessedid="zl9h6l">Join
                                 Now</button>
                         </a>
                         <span class="badge network-join-badge">{{ $premium_network->rating }}</span>

                         @php
                             $ratings = $premium_network->rating; // Replace with your rating value
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
         </div>
     </div>
     {{-- pagination --}}
     <div class="pagination ">
         {{-- call default blade from resource/vender/pagination --}}
         {{ $premium_networks->links('vendor.pagination.default') }}
     </div>
 </div>

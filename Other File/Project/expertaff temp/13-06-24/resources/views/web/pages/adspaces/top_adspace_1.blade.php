 <!-- top adspace 1-->
 <div class="row row-cols-1 row-cols-md-2 g-3 mx-1 pt-2">
     <div class="col">
         <div class="card">
             <div class="mx-4 mt-1">
                 <h5 class="net-mnth">Network of the Month</h5>
             </div>
             <a href="{{ $adspace_image['adspace'][0]->link }}" target="_blank"><img
                     src="{{ asset($adspace_image['adspace'][0]->image_url) }}" class="card-img-top img-fluid img1 px-4"
                     alt="..."></a>
             {{-- <a href="#"><img src="{{ asset($adspace_image['all_ad'][0]['image_url']) }}"
                class="card-img-top img-fluid img1 px-4" alt="..."></a> --}}
             <div class="mt-1 mx-4">
                 <a href="#" class="text-dark">
                     <h5 class="net-title text-capitalize">{{ $adspace_image['adspace'][0]->network_name }}</h5>
                 </a>
                 @php
                     // Replace with your rating value
                     $ratings = $adspace_image['adspace'][0]->rating;
                     $maxRating = 5; // Maximum rating value
                     
                     $filledStars = floor($ratings);
                     $hasHalfStar = $ratings - $filledStars >= 0.5;
                     $emptyStars = $maxRating - $filledStars - ($hasHalfStar ? 1 : 0);
                 @endphp
                 <div class="rating">
                     {{-- empty star --}}
                     @for ($i = 0; $i < $emptyStars; $i++)
                         <i class="fas fa-3x fa-star icon-color"></i>
                     @endfor
                     {{-- half star --}}
                     @if ($hasHalfStar)
                         <i class="fas fa-3x fa-star-half-alt"></i>
                     @endif
                     {{-- filled star  --}}
                     @for ($i = 0; $i < $filledStars; $i++)
                         <i class="fas fa-3x fa-star"></i>
                     @endfor
                 </div>
                 <p class="net-desc mt-1">
                     {{ substr($adspace_image['adspace'][0]->network_description, 0, 118) . '...' }}
                 </p>
             </div>
         </div>
     </div>
     {{-- crausel adspaces --}}
     <div class="col">
         <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
             <div class="carousel-indicators">
                 <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                     aria-current="true" aria-label="Slide 1"></button>
                 <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                     aria-label="Slide 2"></button>
                 <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                     aria-label="Slide 3"></button>
             </div>

             @if (isset($offers_adspaces['offers_top_right']))
                 <div class="carousel-inner">
                     @foreach ($offers_adspaces['offers_top_right'] as $key => $slider)
                         <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                             <a href="{{ $slider->link }}" target="_blank"><img src="{{ asset($slider->image_url) }}"
                                     target="_blank" class="d-block w-100 rounded" alt="..."></a>
                         </div>
                     @endforeach
                 </div>
             @elseif (isset($reviews_adspaces['reviews_top_right']))
                 <div class="carousel-inner">
                     @foreach ($reviews_adspaces['reviews_top_right'] as $key => $slider)
                         <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                             <a href="{{ $slider->link }}" target="_blank"><img src="{{ asset($slider->image_url) }}"
                                     target="_blank" class="d-block w-100 rounded" alt="..."></a>
                         </div>
                     @endforeach
                 </div>
             @else
                 <div class="carousel-inner">
                     @foreach ($adspace_image['top_right'] as $key => $slider)
                         <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                             <a href="{{ $slider->link }}" target="_blank"><img src="{{ asset($slider->image_url) }}"
                                     target="_blank" class="d-block w-100 rounded" alt="..."></a>
                         </div>
                     @endforeach
                 </div>
             @endif
         </div>
     </div>

 </div>

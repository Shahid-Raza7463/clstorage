 <!-- Filter Table -->
 <div class="mx-1">
     <div class="mt-3">
         <div class="border rounded pb-3 mb-3">
             {{-- Stop displaying title  after the first one title  --}}
             @php
                 $reviewCount = 0;
             @endphp
             @foreach ($resources as $title)
                 @php
                     $reviewCount++;
                     if ($reviewCount > 1) {
                         // Stop displaying title after the first one
                         break;
                     }
                 @endphp
                 @if (count($title['child']) > 0)
                     <div class="border rounded text-center text-light" style="background-color: #533582;">
                         <h6 class="mt-1">{{ $title['categories_title'] }}</h6>
                     </div>
                     {{-- @if (count($title['child']) > 0) --}}
                     @foreach ($title['child'] as $subChild)
                         @if (count($subChild['child']) > 0)
                             <div class="border rounded mt-3 mx-3 pb-3 mobile-resource">
                                 <div class="border" style="background-color: #f3f3f3;">
                                     <h6 class="resource-head fw-bold m-2">{{ $subChild['categories_title'] }}</h6>
                                 </div>

                                 <div class="d-flex  mt-1 mx-4 lh-basic mobile-grid"
                                     style="margin-bottom: -29px; flex-wrap: wrap;">
                                     @foreach ($subChild['child'] as $child)
                                         <div class="list-unstyled" style=" margin-right: 46px;">
                                             <p class="text-capitalize"><a href="{{ $child['link'] }}" target="_blank"
                                                     title="Mobads">{{ $child['categories_title'] }}</a>
                                             </p>
                                         </div>
                                     @endforeach
                                 </div>

                             </div>
                         @endif
                     @endforeach
                     {{-- @else
                     <div class="alert mt-3" role="alert">
                         Data Not Available.
                     </div>
                 @endif --}}
                 @endif
             @endforeach
         </div>
     </div>
 </div>

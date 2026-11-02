 <!-- sponsored ads -->
 <div class="row">
     <div class="col-12">
         <div class="grid-img mt-4 py-2 px-2">
             <div class="d-flex">
                 <a href="{{ $adspace_image['all_ad'][5]->link }}" target="_blank"><img
                         src="{{ asset($adspace_image['all_ad'][5]->image_url) }}" class="img-fluid"></a>
             </div>
             <!-- sponsored small ads -->
             <div class="d-flex gap-2 mt-2"style="width: 392px; flex-wrap: wrap; margin-left: 3px;">
                 @foreach ($adspace_image['right_side_2'] as $key => $image)
                     <a href="{{ $image->link }}" target="_blank"><img src="{{ asset($image->image_url) }}"
                             class="img-fluid"></a>
                 @endforeach
             </div>
             <div class="d-flex mt-2">
                 <a href="{{ $adspace_image['all_ad'][5]->link }}" target="_blank"><img
                         src="{{ asset($adspace_image['all_ad'][5]->image_url) }}" class="img-fluid"></a>
             </div>
         </div>
     </div>
 </div>

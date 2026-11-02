{{-- market software --}}
<div class="col-md-7 col-sm-12">
    <div class="div-strip border">

        {{-- Skip the first  one title becouse 1  one title display above section --}}
        @php
            $reviewCount = 0;
        @endphp
        @foreach ($resources as $title)
            @php
                $reviewCount++;
                if ($reviewCount < 2) {
                    // Skip the first one title
                    continue;
                }
            @endphp
            @if (count($title['child']) > 0)
                <div class="border rounded text-center text-light" style="background-color: #533582;">
                    <h6 class="mt-1">{{ $title['categories_title'] }}</h6>
                </div>
                {{-- @if (count($title['child']) > 0) --}}
                @foreach ($title['child'] as $subChild)
                    @if (count($subChild['child']) > 0)
                        <div class="border rounded mt-3 mx-2 pb-3 mb-3">
                            <div class="border" style="background-color: #f3f3f3;     margin-bottom: 1rem;">
                                <h6 class="resource-head fw-bold m-2">{{ $subChild['categories_title'] }}</h6>
                            </div>
                            <div class="parent-wrapper">
                                <div class="d-flex mx-3 lh-basic mobile-grid"
                                    style="margin-bottom: -29px; flex-wrap: wrap;">
                                    @foreach ($subChild['child'] as $child)
                                        <div class="list-unstyled" style="margin-right: 47px;">
                                            <p class="text-capitalize"><a
                                                    href="{{ $child['link'] }}">{{ $child['categories_title'] }}</a></p>
                                        </div>
                                    @endforeach
                                </div>
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

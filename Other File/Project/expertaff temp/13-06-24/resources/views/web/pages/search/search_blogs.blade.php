<div class="col-md-7 col-sm-12 border" id="blogs">
    <div class="d-flex justify-content-between mt-2 mobile-featured-net" style="border-bottom: 3px #f3f3f3 solid">
        <h6 class="fw-bold">Search Blogs Results</h6>
    </div>
    @foreach ($blogs_search as $blog)
        <div class="border bg-light rounded mt-3">
            <div class="mx-3 mt-2">
                <div class="d-flex justify-content-between">
                    <div class="blog-text2">
                        @if ($blog->network_name)
                            <p class="blog-title text-capitalize">{{ $blog->network_name }}</p>
                        @else
                            <p class="blog-title">Null</p>
                        @endif
                        <a href="/blogsview/{{ $blog->slug }}">
                            <p class="card-text text-dark text-capitalize" style="margin-top: -4px;">{{ $blog->title }}
                            </p>
                        </a>

                        @php
                            // omly change hare
                            $createdTime = \Carbon\Carbon::parse($blog->updated_at);
                            $timeAgo = $createdTime->diffForHumans(null, true);
                        @endphp
                        <p class="blog-tym2" style="margin-top: 14px;"><small class="text-muted">Last updated
                                {{ $timeAgo }} ago</small></p>
                    </div>
                    <div class="blog2-img">
                        <a href="/blogsview/{{ $blog->slug }}">
                            <img src="{{ asset($blog->preview_image) }}"class="img-fluid " alt="..."></a>
                    </div>
                </div>

                <div class="blog2-desc" style="text-align: justify;">
                    <p>{{ substr($blog->description, 0, 310) . '...' }}</p>
                    {{-- <p>{!! substr($blog->description, 0, 310) . '...' !!}</p> --}}
                </div>
                {{-- width: 531px; --}}
                <div class=" mx-1 d-flex justify-content-end read-more">
                    <a href="/blogsview/{{ $blog->slug }}">
                        <button class="btn read-more-btn2 btn-sm" type="button">Read More</button>
                    </a>
                </div>
            </div>

        </div>
    @endforeach

    <!--pagination-->
    <div class="pagination ">
        {{ $blogs_search->links('vendor.pagination.default') }}
    </div>
</div>

<div class="col-md-7 col-sm-12 border" style="background-color: #f3f3f3;">
    @php
        $count = 0;
    @endphp
    @foreach ($blogs as $blog)
        @php
            $count++;
            // Stop displaying blogs after the first two
            if ($count < 3) {
                continue;
            }
        @endphp
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
        {{ $blogs->links('vendor.pagination.default') }}
    </div>
</div>

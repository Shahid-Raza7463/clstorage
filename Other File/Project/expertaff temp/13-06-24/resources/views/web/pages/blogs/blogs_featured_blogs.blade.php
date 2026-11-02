<!-- Filter Table -->
<div class="filter-container mx-1">
    <div class="container mt-3 d-flex justify-content-between gap-3 p-3 mobile-featured-blog">


        @php
            $count = 0;
        @endphp
        @foreach ($blogs as $blog)
            @php
                $count++;
                // Stop displaying blogs after the first two
                if ($count > 2) {
                    break;
                }
            @endphp
            <div class="border bg-light rounded">
                <div class="mx-3 mt-3">
                    <div class="d-flex justify-content-between">
                        <div class="blog-img">
                            <a href="/blogsview/{{ $blog->slug }}">
                                <img src="{{ asset($blog->preview_image) }}" class="img-fluid">
                            </a>
                        </div>
                        <div class="blog-text" style="margin-right: 91px;">
                            @if ($blog->network_name)
                                <p class="blog-title text-capitalize">{{ $blog->network_name }}</p>
                            @else
                                <p class="blog-title">Null</p>
                            @endif
                            <a href="/blogsview/{{ $blog->slug }}">
                                <p class="blog-title2 text-dark text-capitalize"> {{ $blog->title }}</p>
                            </a>
                            {{-- Get time in this formate posted x days ago --}}
                            @php
                                // omly change hare
                                $createdTime = \Carbon\Carbon::parse($blog->updated_at);
                                $timeAgo = $createdTime->diffForHumans(null, true);
                            @endphp
                            <p class="blog-tym"><small class="text-muted">Last updated {{ $timeAgo }}
                                    ago</small>
                            </p>
                        </div>
                    </div>
                    <div class="blog-desc">
                        <p>{!! substr($blog->description, 0, 310) . '...' !!}</p>
                    </div>
                    <div class="d-flex justify-content-end read-more">
                        <a href="/blogsview/{{ $blog->slug }}"><button
                                class="btn read-more-btn btn-sm"type="button">Read More</button></a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

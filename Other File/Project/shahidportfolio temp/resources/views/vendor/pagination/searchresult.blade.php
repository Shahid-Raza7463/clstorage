{{-- @if ($paginator->hasPages())
    <nav aria-label="Page navigation example" class="mt-4">
        <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item">
                <a class="page-link pg-btn text-light" href="{{ $paginator->url(1) }}" aria-label="First">
                    First
                </a>
            </li>
            @foreach ($elements as $element)
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span
                                    class="page-link">{{ $page }}</span>
                            <li>
                            @else
                            <li class="page-item"><a class="page-link text-dark"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            <li class="page-item">
                <a class="page-link pg-btn text-light" href="{{ $paginator->url($paginator->lastPage()) }}"
                    aria-label="Last">
                    Last
                </a>
            </li>
        </ul>
    </nav>
@endif --}}



@php
    $filters = isset($paginator->filters) ? $paginator->filters : [];
@endphp
<a class="page-link pg-btn text-light" href="{{ $paginator->appends($filters)->url(1) . '#network' }}" aria-label="First">
    First
</a>
@foreach ($paginator->appends($filters)->getUrlRange(1, $paginator->lastPage()) as $page => $url)
    @if ($page == $paginator->currentPage())
        <li class="page-item active" aria-current="page">
            <span class="page-link">{{ $page }}</span>
        </li>
    @else
        <li class="page-item">
            <a class="page-link text-dark" href="{{ $url . '#' . 'network' }}">{{ $page }}</a>
        </li>
    @endif
@endforeach
<a class="page-link pg-btn text-light"
    href="{{ $paginator->appends($filters)->url($paginator->lastPage()) . '#network' }}" aria-label="Last">
    Last
</a>

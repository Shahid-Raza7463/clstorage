{{-- formate  first 1 2 3 4 5 6 7 8 ... 27 28 last --}}
@if ($paginator->hasPages())
    <nav aria-label="Page navigation example" class="mt-4">
        <ul class="pagination pagination-sm justify-content-center">
            <li class="page-item">
                <a class="page-link pg-btn text-light" href="{{ $paginator->url(1) }}#network" aria-label="First">
                    First
                </a>
            </li>

            @php
                $maxPagesToShow = 7; // Adjust the number of page links to show
                $halfMaxPages = floor($maxPagesToShow / 2);
                //start page number from 1
                $startPage = max($paginator->currentPage() - $halfMaxPages, 1);
                $endPage = min($startPage + $maxPagesToShow - 1, $paginator->lastPage());
            @endphp

            @if ($startPage > 1)
                {{-- start ... after 1 2 --}}
                <li class="page-item"><a class="page-link text-dark" href="{{ $paginator->url(1) . '#network' }}">1</a>
                </li>
                <li class="page-item"><a class="page-link text-dark" href="{{ $paginator->url(2) . '#network' }}">2</a>
                </li>
                @if ($startPage > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page == $paginator->currentPage())
                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    {{-- text insert 1 2 3 4 --}}
                    <li class="page-item">
                        {{-- <a class="page-link text-dark" href="{{ $paginator->url($page) }}">{{ $page }}
                        </a> --}}
                        {{-- pass id hare to scrolling --}}
                        <a class="page-link text-dark"
                            href="{{ $paginator->url($page) . '#network' }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            @if ($endPage < $paginator->lastPage())
                @if ($endPage < $paginator->lastPage() - 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                {{-- for 26 page --}}
                {{-- <li class="page-item"><a class="page-link text-dark"
                        href="{{ $paginator->url($paginator->lastPage() - 2) }}">{{ $paginator->lastPage() - 2 }}</a>
                </li> --}}
                {{-- for 27 page --}}
                <li class="page-item"><a class="page-link text-dark"
                        href="{{ $paginator->url($paginator->lastPage() - 1) }}#network">{{ $paginator->lastPage() - 1 }}</a>
                </li>
                {{-- for 28 page --}}
                <li class="page-item"><a class="page-link text-dark"
                        href="{{ $paginator->url($paginator->lastPage()) }}#network">{{ $paginator->lastPage() }}</a>
                </li>
            @endif

            <li class="page-item">
                <a class="page-link pg-btn text-light" href="{{ $paginator->url($paginator->lastPage()) }}#network"
                    aria-label="Last">
                    Last
                </a>
            </li>
        </ul>
    </nav>
@endif


{{-- ################################################################  i have used --}}
{{-- formate  first 1 2 3 4 5 6 7 8 9 10 11 12 last --}}

{{--  
@php
    $filters = isset($paginator->filters) ? $paginator->filters : [];
    $hasDataToPaginate = $paginator->lastPage() > 1;
@endphp

@if ($hasDataToPaginate)
    <a class="page-link pg-btn text-light" href="{{ $paginator->appends($filters)->url(1) . '#network' }}"
        aria-label="First">
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
@endif --}}

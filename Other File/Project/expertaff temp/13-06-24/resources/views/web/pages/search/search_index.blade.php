@extends('web.pages.template')

@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')
    <!-- Nav menu -->
    @include('web.pages.common.nav_menu')
    <!-- Search filter -->
    <div class="filter-container border mx-3 mb-4">
        @include('web.pages.common.search_filters')
        <!-- top adspace 2-->
        <div class="mb-4">
            @include('web.pages.adspaces.top_adspace_2')
        </div>
    </div>
    <!-- Featured Network -->
    <div class="container mt-4">
        <div class="mx-3">
            <div class="row row-cols-auto">
                {{-- Get Searching on networks from search input --}}
                @if (isset($filters['search']))
                    @include('web.pages.search.search_result')
                @endif
                {{-- Get Searching on networks from middle nav --}}
                @if (isset($filters['vertical']) or
                        isset($filters['software']) or
                        isset($filters['payment_frequency']) or
                        isset($filters['payment_method']))
                    @include('web.pages.search.search_result')
                @endif
                {{-- Get Searching on Reviews from search input --}}
                @if (isset($filters['searchReviews']))
                    @include('web.pages.search.search_review')
                @endif
                {{-- Get Searching on blogs from middle nav --}}
                @if (isset($filters['search_by']))
                    @include('web.pages.search.search_blogs')
                @endif
                <!-- ###################  side component  ############# -->
                <div class="col-md-5 col-sm-12">
                    <!-- top network -->
                    @include('web.pages.common.top_network')
                    <!-- top adspace 4-->
                    @include('web.pages.adspaces.top_adspace_4')
                    <!-- featured network -->
                    @include('web.pages.common.featured_network')
                </div>
            </div>
        </div>
    </div>
    @include('web.pages.adspaces.top_adspace_3')

    {{-- Seo Tag adding --}}
@section('seo')
    <title>{{ $seo_meta[9]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[9]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[9]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[9]['meta_keywords'] }}">
@endsection
@endsection

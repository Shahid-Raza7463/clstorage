@extends('web.pages.template')

@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')
    <!-- Nav menu -->
    @include('web.pages.common.nav_menu')

    <div class="filter-container border mx-3">
        <!-- top adspace 2-->
        @include('web.pages.adspaces.top_adspace_2')
        @include('web.pages.offers.offers_latestoffers')
    </div>
    @include('web.pages.adspaces.top_adspace_3')


    <!-- Featured Network -->
    <div class="container mt-4">
        <div class="mx-3">
            <div class="row">
                @include('web.pages.offers.offers_offers')
                <div class="col-md-5 col-sm-12">
                    @include('web.pages.offers.offers_topoffers')
                    <!-- top adspace 4-->
                    @include('web.pages.adspaces.top_adspace_4')

                    <div class="border side-compnt mt-4">
                        @include('web.pages.offers.offers_featuredoffers')
                        @include('web.pages.adspaces.top_adspace_5')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('web.pages.adspaces.top_adspace_3')
    {{-- Seo Tag adding --}}
@section('seo')
    <title>{{ $seo_meta[2]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[2]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[2]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[2]['meta_keywords'] }}">
@endsection
@endsection

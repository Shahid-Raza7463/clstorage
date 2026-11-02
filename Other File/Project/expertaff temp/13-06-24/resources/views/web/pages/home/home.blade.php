@extends('web.pages.template')
@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')
    <!-- Nav menu -->
    @include('web.pages.common.nav_menu')
    <!-- Search filter -->
    <div class="filter-container border mx-3">
        @include('web.pages.common.search_filters')
        <!-- top adspace 2-->
        @include('web.pages.adspaces.top_adspace_2')
        @include('web.pages.home.home_sponsored')
    </div>
    <!-- top adspace 3-->
    @include('web.pages.adspaces.top_adspace_3')


    <!-- premium Network -->
    <div class="container mt-4">
        <div class="mx-3">
            <div class="row row-cols-auto">
                @include('web.pages.home.home_premium')

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
    <title>{{ $seo_meta[0]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[0]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[0]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[0]['meta_keywords'] }}">
@endsection

@endsection

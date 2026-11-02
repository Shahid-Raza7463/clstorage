@extends('web.pages.template')

@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')
    <!-- Filter -->
    <div class="filter-container border mx-3 mt-4">
        <!-- Banner -->
        @include('web.pages.adspaces.top_adspace_2')
        @include('web.pages.resources.resources_trafficsources')
    </div>
    <!-- top adspace 2-->
    @include('web.pages.adspaces.top_adspace_2')


    <!-- Featured Network -->
    <div class="mt-4 mx-2">
        <div class="mx-3">
            <div class="row">
                @include('web.pages.resources.resourcess_marketsoftware')

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
    <title>{{ $seo_meta[3]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[3]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[3]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[3]['meta_keywords'] }}">
@endsection
@endsection

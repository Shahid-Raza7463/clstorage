@extends('web.pages.template')
@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')
    @include('web.pages.adspaces.top_adspace_3')

    <!-- Featured Network -->
    <div class="container feat-tab mt-4">
        <div class="mx-3 ft-div">
            <div class="row row-cols-auto">
                <div class="col-md-7 col-sm-12">
                    @include('web.pages.network.affiliatenetwork')
                    @include('web.pages.network.advertisingnetwork')
                    @include('web.pages.network.reviews')
                </div>
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
    <title>{{ $seo_meta[1]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[1]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[1]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[1]['meta_keywords'] }}">
@endsection
@endsection

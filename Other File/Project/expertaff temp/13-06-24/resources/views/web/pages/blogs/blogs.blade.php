@extends('web.pages.template')

@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')
    <!-- Filter -->
    <div class="filter-container border mx-3 mt-4" style="background-color: #f3f3f3;">
        <div class="border rounded text-center text-light" style="background-color: #533582;">
            <h6 class="mt-1">Featured Blog</h6>
        </div>
        <!-- top adspace 2-->
        @include('web.pages.adspaces.top_adspace_2')
        @include('web.pages.blogs.blogs_featured_blogs')
    </div>
    <!-- top adspace 3-->
    @include('web.pages.adspaces.top_adspace_3')
    @include('web.pages.blogs.blogs_nav_menu')
    <!-- Featured Network -->
    <div class="container mt-4">
        <div class="mx-3">
            <div class="row">
                @include('web.pages.blogs.blogs_affiliatenetworks')

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
    <title>{{ $seo_meta[5]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[5]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[5]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[5]['meta_keywords'] }}">
@endsection
@endsection

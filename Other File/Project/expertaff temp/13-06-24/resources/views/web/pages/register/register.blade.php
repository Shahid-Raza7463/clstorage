@extends('web.pages.template')
@section('content')
    <!-- Image Cards -->
    @include('web.pages.adspaces.top_adspace_1')
    <!-- Filter -->
    <div class="filter-container border mx-3 mt-4 mb-2  ">
        <!-- Banner -->
        @include('web.pages.adspaces.top_adspace_2')
        <!-- register form -->
        @include('web.pages.register.registerform')
    </div>
    <!-- Banner -->
    @include('web.pages.adspaces.top_adspace_3')

    {{-- Seo Tag adding --}}
@section('seo')
    <title>{{ $seo_meta[7]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[7]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[7]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[7]['meta_keywords'] }}">
@endsection
@endsection

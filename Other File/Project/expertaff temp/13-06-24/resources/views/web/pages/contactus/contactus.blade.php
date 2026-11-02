@extends('web.pages.template')
@section('content')
    <!-- top adspace 1-->
    @include('web.pages.adspaces.top_adspace_1')

    <!-- Featured Network -->
    <div class="mt-4 mx-2">
        <div class="mx-3">
            <div class="row">
                @include('web.pages.contactus.contactus_form')
                <!-- ###################  side component  ############# -->
                <div class="col-md-5 col-sm-12" style="margin-top: -35px;">
                    @include('web.pages.adspaces.top_adspace_4')
                </div>
            </div>
        </div>
        @include('web.pages.adspaces.top_adspace_3')
    </div>
    {{-- Seo Tag adding --}}
@section('seo')
    <title>{{ $seo_meta[6]['name'] }}</title>
    <meta name="title" content="{{ $seo_meta[6]['meta_title'] }}">
    <meta name="description" content="{{ $seo_meta[6]['meta_description'] }}">
    <meta name="keywords" content="{{ $seo_meta[6]['meta_keywords'] }}">
@endsection

@endsection

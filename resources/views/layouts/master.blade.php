<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@include('layouts.partials.header')

@if(isset($toolbar) && $toolbar)
<body class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed" style="--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px">
@else
<body class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed">
@endif
    <div id="loader">
        <div class="spinner-border text-loader" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-row flex-column-fluid">
            @include('layouts.partials.sidebar')
            <div class="wrapper d-flex flex-column flex-row-fluid">
                @include('layouts.partials.navbar', ['title' => $title, 'breadcrumbs' => $breadcrumbs] )
                <div class="content d-flex flex-column flex-column-fluid pb-0">
                    @if(isset($toolbar) && $toolbar)
                        @include('layouts.partials.toolbar')
                    @endif
                    <div class="post d-flex flex-column-fluid">
                        @yield('content')
                    </div>
                </div>
                <div class="footer py-4 d-flex flex-lg-column">
                    @include('layouts.partials.footer')
                </div>
            </div>
        </div>
    </div>
    @include('layouts.partials.scripts')
    @yield('scripts')
</body>

</html>

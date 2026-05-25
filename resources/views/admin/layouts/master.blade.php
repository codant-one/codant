<!doctype html >
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - Panel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ URL::asset('build/images/favicon.ico')}}">
    @include('admin.layouts.partials.head-css')
    @livewireStyles
</head>

@section('body')
    @include('admin.layouts.partials.body')
@show
    <div id="loader">
        <div class="spinner-border text-loader" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <div id="layout-wrapper">
        @include('admin.layouts.partials.topbar')
        @include('admin.layouts.partials.sidebar')
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © {{ config('app.name') }}.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Diseño y desarrollo por 
                                <a href="{{ env('URL_CODANT') }}" target="_blank" class="text-decoration-none">
                                    {{ env('NAME_CODANT') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('admin.layouts.partials.customizer')
    @include('admin.layouts.partials.vendor-scripts')
    @include('admin.layouts.partials.session-checker')
    @livewireScripts
</body>

</html>
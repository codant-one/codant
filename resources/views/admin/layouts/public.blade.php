<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-topbar="light" data-sidebar-image="none">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name') }} - Panel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ URL::asset('build/images/codant.svg')}}">
        @include('admin.layouts.partials.head-css')
  </head>

    @yield('body')

    @yield('content')

    @include('admin.layouts.partials.vendor-scripts')
    </body>
</html>

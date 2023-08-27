<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.partials.header')

<body>
    <div class="app-admin-wrap layout-sidebar-large clearfix">
        @include('layouts.partials.navbar')
        <!-- ============ Body content start ============= -->
        <div class="main-content-wrap sidenav-open d-flex flex-column">
            @include('layouts.partials.sidebar')
            <div class="main-content">
                @yield('content')
            </div>
        </div>
        <!-- ============ Body content End ============= -->

    </div>
    <!--=============== End app-admin-wrap ================-->   
    @include('layouts.partials.footer')
    @include('layouts.partials.scripts')
    @yield('scripts')
</body>

</html>
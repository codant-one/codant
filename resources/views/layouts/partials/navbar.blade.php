<div class="row g-0 menu-desktop px-24 pt-6">
    <div class="col-md-11 d-flex flex-stack align-items-center header">
        <img src="{{ asset(env('DOMAIN_LOGO_SVG')) }}" alt="Codant-logo">
            <nav id ="main-menu"class="navbar navbar-expand-lg navbar-light w-100">
                <div class="collapse navbar-collapse justify-content-center w-100" id="navbarNavDropdown">
                    <ul class="navbar-nav w-75 d-flex flex-stack px-24">
                        <li class="nav-item active">
                            <a class="nav-link" href="#about_us"> @lang('navbar.about_us') </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#believe"> @lang('navbar.believe') </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#do"> @lang('navbar.do') </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <button class="button-contact" onclick="window.location.href='#contact'">@lang('navbar.contact')</button>
    </div>
    <div class="col-md-1 button-lang">
        @php $locale = session()->get('locale'); @endphp
        @switch($locale)
            @case('es')
                <a class="button-language" href="{{ route('translate.index',['locale' => 'en']) }}">ES</a>
            @break
            @case('en')
                <a class="button-language" href="{{ route('translate.index',['locale' => 'es']) }}">EN</a>
            @break
            @default
                <a class="button-language" href="{{ route('translate.index',['locale' => 'en']) }}">ES</a>
            @break
        @endswitch
    </div>
</div>

<div class="container menu-mobile">
    <div class="row g-0">
        <div class="col-12 superimpose">
            <div class="row g-0 header-mobile">
                <div class="col-11 text-left m-auto">
                    <img width="68px" src="{{ asset(env('DOMAIN_LOGO_SVG')) }}" alt="Codant-logo">
                </div>
                <div class="col-1 m-auto">
                    <div class="btn btn-icon btn-active-light-info w-100" id="kt_aside_mobile_toggle">
                        <span class="d-flex align-center">
                            <i class="fas fa-bars fs-2qx"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
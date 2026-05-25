<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header p-0">
            <div class="d-flex">
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{ route('admin.dashboard.index') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset(env('DOMAIN_LOGO_URL_WHITE_SERVICES')) }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset(env('DOMAIN_LOGO_URL_WHITE_SERVICES')) }}" alt="" height="17">
                        </span>
                    </a>
                    <a href="{{ route('admin.dashboard.index') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset(env('DOMAIN_LOGO_URL_WHITE_SERVICES')) }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset(env('DOMAIN_LOGO_URL_WHITE_SERVICES')) }}" alt="" height="17">
                        </span>
                    </a>
                </div>
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>
                <livewire:navbar />
            </div>
        </div>
    </div>
</header>


<div class="row g-0 menu-desktop px-24 pt-6">
    <div class="col-md-11 d-flex flex-stack align-items-center header">
        <img src="{{ asset(env('DOMAIN_LOGO_SVG')) }}" alt="Codant-logo">
            <nav id ="main-menu"class="navbar navbar-expand-lg navbar-light w-100">
                <div class="collapse navbar-collapse justify-content-center w-100" id="navbarNavDropdown">
                    <ul class="navbar-nav w-75 d-flex flex-stack px-24">
                        <li class="nav-item active">
                            <a class="nav-link" href="#about_us">¿Quiénes somos? <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#believe">¿En que creemos?</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#do">¿Que hacemos?</a>
                        </li>
                    </ul>
                </div>
            </nav>
            <button class="button-contact" onclick="window.location.href='#contact'">Contacto</button>
    </div>
    <div class="col-md-1 button-lang">
        <button class="button-language">ES</button>
    </div>
</div>

<div class="container menu-mobile">
    <div class="row g-0">
        <div class="col-12 superimpose">
            <div class="row g-0 header-mobile">
                <div class="col-1 m-auto">
                    <div class="btn btn-icon btn-active-light-info w-100" id="kt_aside_mobile_toggle">
                        <span class="d-flex align-center">
                            <i class="fas fa-bars fs-2qx"></i>
                        </span>
                    </div>
                </div>
                <div class="col-11 text-right m-auto">
                    <img width="68px" src="{{ asset(env('DOMAIN_LOGO_SVG')) }}" alt="Codant-logo">
                </div>
            </div>
        </div>
    </div>
</div>
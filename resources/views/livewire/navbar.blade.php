<div class="dropdown ms-sm-3 header-item topbar-user">
    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="d-flex align-items-center">
            @if(is_null(auth()->user()->avatar))
                <img class="rounded-circle header-profile-user" alt="Header Avatar" src="{{ URL::asset('build/images/users/avatar-1.jpg') }}"/>
            @else
                <img class="rounded-circle header-profile-user" alt="Header Avatar"  src="{{ asset('storage/'.auth()->user()->avatar) }}"/>
            @endif
        </span>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <h6 class="dropdown-header">
            <span class="d-flex align-items-center">
                @if(is_null(auth()->user()->avatar))
                    <img class="rounded-circle header-profile-user" alt="Header Avatar" src="{{ URL::asset('build/images/users/avatar-1.jpg') }}"/>
                @else
                    <img class="rounded-circle header-profile-user" alt="Header Avatar"  src="{{ asset('storage/'.auth()->user()->avatar) }}"/>
                @endif
                <span class="text-start ms-xl-2">
                    <span class="d-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}</span>
                    <span class="d-block ms-1 fs-12 user-name-sub-text">{{ auth()->user()->email }}</span>
                </span>
            </span>
        </h6>
        <a class="dropdown-item" href="{{ route('profile') }}">
            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> 
            <span class="align-middle">Perfil</span>
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('auth.logout') }}">
            <i class="bx bx-power-off font-size-16 align-middle me-1"></i> 
            <span>Cerrar Sesión</span>
        </a>
    </div>
</div>
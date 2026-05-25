<div class="app-menu navbar-menu">
    <div class="navbar-brand-box">
        <a href="{{ route('template.root') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <a href="{{ route('template.root') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>Inicio</span></li>
                
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">
                        <i class="ri-dashboard-2-line"></i> <span>Inicio</span>
                    </a>
                </li>

                <!-- ADMINISTRACIÓN SECTION -->
                <li class="menu-title"><span>ADMINISTRACIÓN</span></li>

                <!-- USUARIOS -->
                @can('user_view')
                <li class="nav-item">
                    <a class="nav-link menu-link {{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}" href="{{ route('users.index') }}">
                        <i class="ri-user-line"></i> <span>Usuarios</span>
                    </a>
                </li>
                @endcan

                <!-- ROLES Y PERMISOS -->
                @canany(['rol_view', 'permission_view'])
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarRolesPermisos" data-bs-toggle="collapse" role="button"
                        aria-expanded="{{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'true' : 'false' }}" 
                        aria-controls="sidebarRolesPermisos">
                        <i class="ri-settings-3-line"></i> <span>Roles y permisos</span>
                    </a>
                    <div class="collapse menu-dropdown {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'show' : '' }}" id="sidebarRolesPermisos">
                        <ul class="nav nav-sm flex-column">
                            @can('rol_view')
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.index') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'active' : '' }}">
                                    <i class="ri-user-settings-line"></i> Roles
                                </a>
                            </li>
                            @endcan

                            @can('permission_view')
                            <li class="nav-item">
                                <a href="{{ route('permissions.index') }}" class="nav-link {{ request()->routeIs('permissions.index') || request()->routeIs('permissions.create') || request()->routeIs('permissions.edit') ? 'active' : '' }}">
                                    <i class="ri-shield-check-line"></i> Permisos
                                </a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                @endcanany

                <!-- MÓDULOS SECTION -->
                <li class="menu-title d-none"><span>MÓDULOS</span></li>

            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
<div class="vertical-overlay"></div>


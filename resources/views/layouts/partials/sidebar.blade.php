<div id="kt_aside" class="aside aside-dark aside-hoverable" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">
	<div class="aside-logo flex-column-auto" id="kt_aside_logo">
		<a href="{{ route('admin.dashboard.index') }}">
			<img alt="Logo"  src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" class="logo" style="height: 35px" />
		</a>
		<div id="kt_aside_toggle" class="btn btn-icon w-auto px-0 btn-active-color-info aside-toggle" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
			 <span class="svg-icon svg-icon-1 rotate-180">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-double-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8.354 1.646a.5.5 0 0 1 0 .708L2.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                    <path fill-rule="evenodd" d="M12.354 1.646a.5.5 0 0 1 0 .708L6.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
                </svg>
			</span>
		</div>
	</div>


	<div class="aside-menu flex-column-fluid">
		<div class="hover-scroll-overlay-y mt-5 mt-lg-5" id="kt_aside_menu_wrapper" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_aside_logo, #kt_aside_footer" data-kt-scroll-wrappers="#kt_aside_menu" data-kt-scroll-offset="0">
			<div class="menu menu-column menu-title-gray-800 menu-state-title-info menu-state-icon-info menu-state-bullet-info menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
				<div class="menu-item">
					<div class="menu-content pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">Inicio</span>
					</div>
				</div>

                <div class="menu-item">
					<a class="menu-link {{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}" href="{{ route('admin.dashboard.index') }}">
                        <span class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 18V15" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M10.07 2.81985L3.14002 8.36985C2.36002 8.98985 1.86002 10.2998 2.03002 11.2798L3.36002 19.2398C3.60002 20.6598 4.96002 21.8098 6.40002 21.8098H17.6C19.03 21.8098 20.4 20.6498 20.64 19.2398L21.97 11.2798C22.13 10.2998 21.63 8.98985 20.86 8.36985L13.93 2.82985C12.86 1.96985 11.13 1.96985 10.07 2.81985Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
                        </span>
                        <span class="menu-title">Inicio</span>
					</a>
				</div>

				<!-- ADMINISTRACIÓN -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">ADMINISTRACIÓN</span>
					</div>
				</div>

				<!-- USUARIOS -->
				@can('user_view')
				<div class="menu-item">
					<a class="menu-link 
					{{ request()->routeIs('users.index') || request()->routeIs('users.create') || request()->routeIs('users.edit') ? 'active' : '' }}" 
					 href="{{ route('users.index') }}">
                        <span class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18.1401 21.6207C17.2601 21.8807 16.2201 22.0007 15.0001 22.0007H9.00011C7.78011 22.0007 6.74011 21.8807 5.86011 21.6207C6.08011 19.0207 8.75011 16.9707 12.0001 16.9707C15.2501 16.9707 17.9201 19.0207 18.1401 21.6207Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M15 2H9C4 2 2 4 2 9V15C2 18.78 3.14 20.85 5.86 21.62C6.08 19.02 8.75 16.97 12 16.97C15.25 16.97 17.92 19.02 18.14 21.62C20.86 20.85 22 18.78 22 15V9C22 4 20 2 15 2ZM12 14.17C10.02 14.17 8.42 12.56 8.42 10.58C8.42 8.60002 10.02 7 12 7C13.98 7 15.58 8.60002 15.58 10.58C15.58 12.56 13.98 14.17 12 14.17Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M15.5799 10.58C15.5799 12.56 13.9799 14.17 11.9999 14.17C10.0199 14.17 8.41992 12.56 8.41992 10.58C8.41992 8.60002 10.0199 7 11.9999 7C13.9799 7 15.5799 8.60002 15.5799 10.58Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
                        </span>
                        <span class="menu-title">Usuarios</span>
					</a>
				</div>
				@endcan

				<!-- ROLES Y PERMISOS -->
				@canany(['rol_view', 'permission_view'])
				<div data-kt-menu-trigger="click" 
					class="menu-item menu-accordion mt-1
					{{ 
						request()->routeIs('roles.create') || request()->routeIs('roles.index') || request()->routeIs('roles.edit') ||
						request()->routeIs('permissions.create') || request()->routeIs('permissions.index') || request()->routeIs('permissions.edit')
					 
						? 'hover show' : '' 
					}}">	
					<span class="menu-link">
						<span class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M2 12.8794V11.1194C2 10.0794 2.85 9.21945 3.9 9.21945C5.71 9.21945 6.45 7.93945 5.54 6.36945C5.02 5.46945 5.33 4.29945 6.24 3.77945L7.97 2.78945C8.76 2.31945 9.78 2.59945 10.25 3.38945L10.36 3.57945C11.26 5.14945 12.74 5.14945 13.65 3.57945L13.76 3.38945C14.23 2.59945 15.25 2.31945 16.04 2.78945L17.77 3.77945C18.68 4.29945 18.99 5.46945 18.47 6.36945C17.56 7.93945 18.3 9.21945 20.11 9.21945C21.15 9.21945 22.01 10.0694 22.01 11.1194V12.8794C22.01 13.9194 21.16 14.7794 20.11 14.7794C18.3 14.7794 17.56 16.0594 18.47 17.6294C18.99 18.5394 18.68 19.6994 17.77 20.2194L16.04 21.2094C15.25 21.6794 14.23 21.3994 13.76 20.6094L13.65 20.4194C12.75 18.8494 11.27 18.8494 10.36 20.4194L10.25 20.6094C9.78 21.3994 8.76 21.6794 7.97 21.2094L6.24 20.2194C5.33 19.6994 5.02 18.5294 5.54 17.6294C6.45 16.0594 5.71 14.7794 3.9 14.7794C2.85 14.7794 2 13.9194 2 12.8794Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
						</span>
						<span class="menu-title">Roles y permisos</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion menu-active-bg mt-1">
						<!-- ROLES -->
						@can('rol_view')
						<div class="menu-item">
							<a class="menu-link {{ request()->routeIs('roles.index') || request()->routeIs('roles.create') || request()->routeIs('roles.edit') ? 'active' : '' }}" href="{{ route('roles.index') }}">
								<span class="menu-icon">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M19.2101 15.741L15.67 19.281C15.53 19.421 15.4 19.681 15.37 19.871L15.18 21.221C15.11 21.711 15.45 22.051 15.94 21.981L17.29 21.791C17.48 21.761 17.75 21.631 17.88 21.491L21.42 17.951C22.03 17.341 22.32 16.631 21.42 15.731C20.53 14.841 19.8201 15.131 19.2101 15.741Z" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M18.7002 16.25C19.0002 17.33 19.8402 18.17 20.9202 18.47" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M3.40991 22C3.40991 18.13 7.25994 15 11.9999 15C13.0399 15 14.0399 15.15 14.9699 15.43" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>
								</span>
								<span class="menu-title">Roles</span>
							</a>
						</div>
						@endcan

						<!-- PERMISOS -->
						@can('permission_view')
						<div class="menu-item mt-1">
							<a class="menu-link {{ request()->routeIs('permissions.index') || request()->routeIs('permissions.create') || request()->routeIs('permissions.edit') ? 'active' : '' }}" href="{{ route('permissions.index') }}">
								<span class="menu-icon">
									<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M11 19.5H21" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M11 12.5H21" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M11 5.5H21" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M3 5.5L4 6.5L7 3.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M3 12.5L4 13.5L7 10.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										<path d="M3 19.5L4 20.5L7 17.5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
									</svg>

								</span>
								<span class="menu-title">Permisos</span>
							</a>
						</div>
						@endcan
					</div>
				</div>
				@endcanany

				<!-- MÓDULOS -->
				<div class="menu-item">
					<div class="menu-content pt-8 pb-2">
						<span class="menu-section text-muted text-uppercase fs-8 ls-1">MÓDULOS</span>
					</div>
				</div>

				<!-- CLIENTES -->
				@can('client_view')
				<div class="menu-item">
					<a class="menu-link 
					{{ request()->routeIs('clients.index') || request()->routeIs('clients.create') || request()->routeIs('clients.edit') ? 'active' : '' }}" 
					 href="{{ route('clients.index') }}">
                        <span class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M18 18.86H17.24C16.44 18.86 15.68 19.17 15.12 19.73L13.41 21.42C12.63 22.19 11.36 22.19 10.58 21.42L8.87 19.73C8.31 19.17 7.54 18.86 6.75 18.86H6C4.34 18.86 3 17.53 3 15.89V4.97C3 3.33 4.34 2 6 2H18C19.66 2 21 3.33 21 4.97V15.88C21 17.52 19.66 18.86 18 18.86Z" stroke="#ffffffff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M12.0699 8.95078C12.0299 8.95078 11.9699 8.95078 11.9199 8.95078C10.8699 8.91078 10.0399 8.06078 10.0399 7.00078C10.0399 5.92078 10.9099 5.05078 11.9899 5.05078C13.0699 5.05078 13.9399 5.93078 13.9399 7.00078C13.9499 8.06078 13.1199 8.92078 12.0699 8.95078Z" stroke="#ffffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M9.24994 11.9609C7.91994 12.8509 7.91994 14.3009 9.24994 15.1909C10.7599 16.2009 13.2399 16.2009 14.7499 15.1909C16.0799 14.3009 16.0799 12.8509 14.7499 11.9609C13.2399 10.9609 10.7699 10.9609 9.24994 11.9609Z" stroke="#ffffffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

                        </span>
                        <span class="menu-title">Clientes</span>
					</a>
				</div>
				@endcan

				<!-- SKILLS -->
				@can('skill_view')
				<div class="menu-item mt-1">
					<a class="menu-link 
					{{ request()->routeIs('skills.index') || request()->routeIs('skills.create') || request()->routeIs('skills.edit') ? 'active' : '' }}" 
					 href="{{ route('skills.index') }}">
                        <span class="menu-icon">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M20 9.6C20 5.6 18.4 4 14.4 4H9.6C5.6 4 4 5.6 4 9.6V14.4C4 18.4 5.6 20 9.6 20" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M16.35 8C15.8 7.3 14.88 7 13.5 7H10.5C8 7 7 8 7 10.5V13.5C7 14.88 7.3 15.8 7.99 16.35" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M8.01001 4V2" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M12 4V2" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M16 4V2" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M20 8H22" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M8.01001 20V22" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M2 8H4" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M2 12H4" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M2 16H4" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M16.71 18.5902C17.5881 18.5902 18.3 17.8783 18.3 17.0002C18.3 16.122 17.5881 15.4102 16.71 15.4102C15.8319 15.4102 15.12 16.122 15.12 17.0002C15.12 17.8783 15.8319 18.5902 16.71 18.5902Z" stroke="#FFFFFF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
								<path d="M11.41 17.4615V16.5315C11.41 15.9815 11.86 15.5315 12.41 15.5315C13.37 15.5315 13.76 14.8515 13.28 14.0215C13 13.5415 13.17 12.9215 13.65 12.6515L14.56 12.1215C14.98 11.8715 15.52 12.0215 15.77 12.4415L15.83 12.5415C16.31 13.3715 17.09 13.3715 17.57 12.5415L17.63 12.4415C17.88 12.0215 18.42 11.8815 18.84 12.1215L19.75 12.6515C20.23 12.9315 20.4 13.5415 20.12 14.0215C19.64 14.8515 20.03 15.5315 20.99 15.5315C21.54 15.5315 21.99 15.9815 21.99 16.5315V17.4615C21.99 18.0115 21.54 18.4615 20.99 18.4615C20.03 18.4615 19.64 19.1415 20.12 19.9715C20.4 20.4515 20.23 21.0715 19.75 21.3415L18.84 21.8715C18.42 22.1215 17.88 21.9715 17.63 21.5515L17.57 21.4515C17.09 20.6215 16.31 20.6215 15.83 21.4515L15.77 21.5515C15.52 21.9715 14.98 22.1115 14.56 21.8715L13.65 21.3415C13.17 21.0615 13 20.4515 13.28 19.9715C13.76 19.1415 13.37 18.4615 12.41 18.4615C11.86 18.4715 11.41 18.0215 11.41 17.4615Z" stroke="#FFFFFF" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>

                        </span>
                        <span class="menu-title">Skills</span>
					</a>
				</div>
				@endcan
		
			</div>
		</div>
	</div>

</div>

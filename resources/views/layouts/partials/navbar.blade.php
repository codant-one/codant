<div id="kt_header" class="header align-items-stretch">
    <div class="container-fluid d-flex align-items-stretch justify-content-between">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1" title="Show aside menu">
			<div class="btn btn-icon btn-active-light-primary w-30px h-30px w-md-40px h-md-40px" id="kt_aside_mobile_toggle">
                <span>
                    <i class="fas fa-bars"></i>
                </span>
			</div>
		</div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<a href="{{ route('admin.dashboard.index') }}" class="d-lg-none">
		        <img alt="Logo" src="{{ asset(env('DOMAIN_LOGO_SVG')) }}" style="width: 50px" />
			</a>
		</div>
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
            @include('shared.breadcrumbs',['title' => $title, 'breadcrumbs' => $breadcrumbs] )
            <div class="d-flex align-items-stretch flex-shrink-0">
                <div class="d-flex align-items-stretch flex-shrink-0">                    
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                        <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end" data-kt-menu-flip="bottom">
                            @if(is_null(auth()->user()->avatar))
                                <img alt="image" src="{{ asset('/img/placeholders/user.png') }}"/>
                            @else
                                <img alt="image" src="{{ asset('storage/'.auth()->user()->avatar) }}"/>
                            @endif
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-auto" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px symbol-circle me-5">
                                        @if(is_null(auth()->user()->avatar))
                                            <img alt="image" src="{{ asset('/img/placeholders/user.png') }}"/>
                                        @else
                                            <img alt="image" src="{{ asset('storage/'.auth()->user()->avatar) }}"/>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bolder d-flex align-items-center fs-5">
                                            {{ auth()->user()->firstname }}  {{ auth()->user()->lastname }}
                                        </div>
                                        <span class="fw-bold text-muted fs-7" style="word-break: break-all;"> {{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
								<a href="{{ route('profile') }}" class="menu-link px-5">Mi perfil</a>
							</div>
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
                                <a href="{{ route('auth.logout') }}" class="menu-link px-5">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
	</div>
</div>

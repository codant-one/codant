@extends('layouts.master', [
    'title' => 'Mi perfil',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Dashboard',
        route('profile') => 'Mi perfil',
    ]
])

@section('content')

    <div class="post d-flex flex-column-fluid" id="kt_post">
		<div class="container">
            @include('auth.partials.account')
            <div class="tab-content" id="myTabContent">
                @if ($errors->any())
                <div class="alert alert-dismissible d-flex flex-column flex-sm-row p-6 my-3" id="error-input">
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-bold">
                            <h4 class="mb-2 text-light">Error</h4>
                            <div class="fs-6 text-light">{{ $errors->first() }}</div>
                        </div>
                    </div>
                    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto" data-bs-dismiss="alert">
                        <i class="bi bi-x fs-1 text-light"></i>
                    </button>
                </div>
                @endif

                @include('auth.partials.overview')
                @include('auth.partials.settings')
                @include('auth.partials.security')	
            </div>	
		</div>
    </div>

    @include('auth.partials.modal-update-password')
    @include('auth.partials.modal-update-2fa')
@endsection

@section('scripts')
    <script src="{{ asset('custom/js/customGoogleMaps.js') }}"></script>
    
    @include('auth.scripts.settings')
    @include('auth.scripts.security')
    @include('auth.scripts.2fa')

    <script>
         @if (\Session::has('register_error'))

            const tabElement = document.querySelector('[data-target="security"]'); 

            if (tabElement) {
                const tab = new bootstrap.Tab(tabElement);
                tab.show();
            }

            Swal.fire({
                title: 'Algo ha ido mal',
                html: `
                    <div class="d-flex flex-column">
                        <span class="swal2-subtitle-error">{!! \Session::get('register_error') !!}</span>
                            <span class="swal2-html-container d-flex mt-0 align-center">
                            <span class="ms-2">{!! \Session::get('text') !!}</span>
                        </span>
                    </div>
                    `,
                confirmButtonText: "Entendido",
                focusConfirm: false,
                focusCancel: false,
                showCloseButton: true,
                imageUrl: "{{ url('img/icon_error.png') }}",
                imageAlt: "Error",
                closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                customClass: {
                    image: 'mt-10 mb-0 mx-auto w-25',
                    confirmButton: "btn btn-standar",
                    closeButton: 'custom-swal-close-button',
                    htmlContainer: 'swal2-html-container', 
                }
            })
            @endif
    </script>
@endsection
@extends('admin.layouts.master')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/choices.js/public/assets/styles/choices.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('build/libs/flatpickr/flatpickr.min.css') }}">
    <style>
        /* Hide Bootstrap validation checkmark/X icons on password fields in security tab */
        #update_password_form .password-input.is-valid,
        #update_password_form .password-input.is-invalid,
        #update_password_form .password-input:valid,
        #update_password_form .password-input:invalid {
            background-image: none !important;
            padding-right: 2.5rem !important;
        }
        
        #update_password_form .auth-pass-inputgroup .password-addon {
            z-index: 10;
        }
    </style>
@endsection

@section('content')
<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="{{ URL::asset('build/images/profile-bg.jpg') }}" alt="" class="profile-wid-img" />
    </div>
</div>
<div class="pt-4 mb-4 mb-lg-3 pb-lg-5 profile-wrapper">
    <div class="row g-4">
        <div class="col-12 col-md-auto">
            @include('commons.profile-avatar', [
                'avatar' => auth()->user()->avatar,
                'updateRoute' => 'updateAvatar',
                'size' => 'avatar-xl',
                'inputId' => 'profile-img-file-input'
            ])
        </div>
        <div class="col mt-0 mt-md-4">
            <div class="p-2">
                <h3 class="text-white mb-1">{{ auth()->user()->firstname }} {{ auth()->user()->secondname }} {{ auth()->user()->lastname }} {{ auth()->user()->secondsurname }}</h3>
                <p class="text-white text-opacity-75">{{ auth()->user()->getRoleNames()[0] }}</p>
                <div class="d-flex flex-column flex-md-row text-white-50 gap-1">
                    <div class="me-2">
                        <i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>
                        @if(isset(auth()->user()->userDetail->address->city))
                            {{ auth()->user()->userDetail->address->city->name }},  {{ auth()->user()->userDetail->address->address }}
                        @else
                            ---
                        @endif
                    </div>
                    <div>
                        <i class="ri-building-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>
                        {{ env('APP_NAME') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xxl-4">
        @include('admin.auth.partials.overview')
    </div>
    <div class="col-xxl-8">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link px-2 active" data-bs-toggle="tab" href="#settings" role="tab">
                            <i class="fas fa-home"></i>
                            Datos personales
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2" data-bs-toggle="tab" href="#security" role="tab">
                            <i class="far fa-user"></i>
                            Contraseña
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-2" data-bs-toggle="tab" href="#privacy" role="tab">
                            <i class="far fa-envelope"></i>
                            Privacidad
                        </a>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content">
                    @include('admin.auth.partials.settings')
                    @include('admin.auth.partials.security')
                    @include('admin.auth.partials.privacy')
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.auth.partials.modal-update-2fa')

@endsection
@section('script')
    <script>
        window.googleMapsApiKey = @json(config('services.google.maps_api_key'));
    </script>
    <script src="{{ asset('custom/js/customGoogleMaps.js') }}"></script>
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/libs/flatpickr/l10n/es.js') }}"></script>

    <script src="{{ URL::asset('build/js/pages/profile.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    @include('admin.auth.scripts.settings')
    @include('admin.auth.scripts.security')
    @include('admin.auth.scripts.2fa')

    @stack('scripts')

    <script>
        @if (Session::has('register_success_2fa'))
            Swal.fire({
                html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                            <div class="fs-15">
                            <h4>{!! Session::get('register_success_2fa') !!}</h4>
                            @if (Session::has('text_2fa'))
                            <p class="text-muted mx-4 mb-0">{!! Session::get('text_2fa') !!}</p>
                            @endif
                        </div>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: 'btn btn-primary w-xs mb-1',
                },
                cancelButtonText: 'Entendido',
                buttonsStyling: false,
                showCloseButton: true
            });
        @endif
        
        @if (\Session::has('register_error'))
            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                        <h4>{!! \Session::get('register_error') !!}</h4>
                        <p class="text-muted mx-4 mb-0">
                            {!! \Session::get('text') !!}
                        </p>
                    </div>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: 'btn btn-primary w-xs mb-1',
                },
                cancelButtonText: 'Entendido',
                buttonsStyling: false,
                showCloseButton: true
            });
        @endif

        @if (\Session::has('register_success'))
            Swal.fire({
                html: `
                        <div class="mt-3">
                            <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                            <div class="fs-15">
                            <h4>{!! \Session::get('register_success') !!}</h4>
                            @if (\Session::has('text'))
                            <p class="text-muted mx-4 mb-0">{!! \Session::get('text') !!}</p>
                            @endif
                        </div>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: 'btn btn-primary w-xs mb-1',
                },
                cancelButtonText: 'Entendido',
                buttonsStyling: false,
                showCloseButton: true
            });
        @endif

        @if (\Session::has('delete_account_error'))
            const tabElement = document.querySelector('[data-target="privacy"]');
            if (tabElement) {
                const tab = new bootstrap.Tab(tabElement);
                tab.show();
            }

            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>Error de validación</h4>
                            <p class="text-muted mx-4 mb-0">{!! \Session::get('delete_account_error') !!}</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                showConfirmButton: false,
                customClass: {
                    cancelButton: 'btn btn-primary w-xs mb-1',
                },
                cancelButtonText: 'Entendido',
                buttonsStyling: false,
                showCloseButton: true
            });
        @endif

        // Delete Account Confirmation
        document.addEventListener('DOMContentLoaded', function() {
            const deleteBtn = document.getElementById('deleteAccountBtn');
            const deleteForm = document.getElementById('deleteAccountForm');
            const passwordInput = document.getElementById('passwordInput');

            if (deleteBtn) {
                deleteBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const password = passwordInput.value;
                    
                    if (!password) {
                        Swal.fire({
                            html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                        <h4>Campo requerido</h4>
                                        <p class="text-muted mx-4 mb-0">Por favor, ingresa tu contraseña para eliminar la cuenta.</p>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: 'btn btn-primary w-xs mb-1',
                            },
                            cancelButtonText: 'Entendido',
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                        return;
                    }

                    Swal.fire({
                        html: `
                            <div class="mt-3">
                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#AA83FF,secondary:#f06548" style="width:120px;height:120px"></lord-icon>
                                <div class="fs-15">
                                    <h4>¿Estás seguro?</h4>
                                    <p class="text-muted mx-4 mb-0">Esta acción no se puede deshacer. Tu cuenta será eliminada permanentemente.</p>
                                </div>
                            </div>
                        `,
                        showCancelButton: true,
                        showConfirmButton: true,
                        confirmButtonText: 'Sí, eliminar cuenta',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                            confirmButton: 'btn btn-danger w-xs mb-1 me-2',
                            cancelButton: 'btn btn-light w-xs mb-1',
                        },
                        buttonsStyling: false,
                        showCloseButton: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Mostrar alerta de información mientras se procesa
                            Swal.fire({
                                html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                                        <div class="fs-15">
                                            <h4>Tu cuenta ha sido eliminada</h4>
                                            <p class="text-muted mx-4 mb-0">Se cerrarán todas las sesiones y tu cuenta será eliminada.</p>
                                        </div>
                                    </div>
                                `,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showConfirmButton: false,
                                didOpen: () => {
                                    // Enviar formulario después de mostrar el mensaje
                                    setTimeout(() => {
                                        deleteForm.submit();
                                    }, 2000);
                                }
                            });
                        }
                    });
                });
            }
        });
    </script>
@endsection



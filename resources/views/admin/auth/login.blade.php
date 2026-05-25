@extends('admin.layouts.public')

@section('content')

<style>
    .indicator-progress {
        display: none;
    }
</style>

<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <div class="auth-page-content overflow-hidden pb-0 pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6">
                                @include('admin.layouts.partials.sliders')
                            </div>
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <div class="d-none d-md-flex flex-column">
                                        <h5 class="text-primary">¡Bienvenido de nuevo!</h5>
                                        <p class="text-muted">Inicia sesión para continuar.</p>
                                    </div>
                                    <form action="{{ route('auth.authenticate') }}" method="POST" id="kt_sign_in_form">
                                        @csrf
                                        <div class="mb-3 fv-row">
                                            <label for="email" class="form-label">Usuario</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Ingrese su usuario" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div id="error-input">
                                                    <span class="invalid-feedback d-block">{{ $message }}</span>
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3 fv-row">
                                            <div class="float-end">
                                                <a href="{{route('password.admin.forgot.password')}}" class="text-muted">¿Olvidó su contraseña?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Contraseña</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input"
                                                    placeholder="Ingrese su contraseña" id="password-input" name="password" required>
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                            @error('password')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="remember-admin">
                                            <label class="form-check-label" for="remember-admin">Recuérdame</label>
                                        </div>
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit" id="kt_sign_up_submit">
                                                <span class="indicator-label">Ingresar</span>
                                                <span class="indicator-progress">
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.partials.footer')
</div>

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const errorInput = document.getElementById('error-input');
            const inputEmail = document.getElementById('email');
            const inputPassword = document.getElementById('password-input');

            if(inputEmail && errorInput) {
                inputEmail.addEventListener('input', function() { 
                    @if ($errors->any())
                        errorInput.style.display = 'none';
                    @endif
                });
            }

            if(inputPassword && errorInput) {
                inputPassword.addEventListener('input', function() { 
                    @if ($errors->any())
                        errorInput.style.display = 'none';
                    @endif
                });
            }

        });

        $(document).ready(function(){

            $('#remember-admin').prop('checked', (localStorage.getItem('remember-admin') === 'true') ? true : false);
            $('#email').val(localStorage.getItem('email_admin') ?? null)
            $('#password-input').val(localStorage.getItem('password_admin') ?? null)

            $('#remember-admin').on('change', function(){

                if( $(this).is(':checked') ){
                    localStorage.setItem('email_admin', $('#email').val());
                    localStorage.setItem('password_admin', $('#password-input').val());
                    localStorage.setItem('remember-admin', ($('#remember-admin').val() === 'on') ? true : false);

                } else {
                    localStorage.setItem('email_admin', '');
                    localStorage.setItem('password_admin', '');
                    localStorage.setItem('remember-admin', false);
                }
            });
        });

        
        // Manejo del formulario de login
        $(document).ready(function() {
            const form = $('#kt_sign_in_form');
            const submitBtn = $('#kt_sign_up_submit');
            
            form.on('submit', function(e) {
                e.preventDefault();
                
                const email = $('#email').val().trim();
                const password = $('#password-input').val();
                
                // Validación básica
                if (!email || !password) {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Algo ha ido mal</h4>
                                    <p class="text-muted mx-4 mb-0">
                                       Por favor complete todos los campos
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
                    return false;
                }
                
                // Validar formato de email
                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                if (!emailRegex.test(email)) {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Algo ha ido mal</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        El formato del correo electrónico no es válido
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
                    return false;
                }
                
                // Mostrar loading
                submitBtn.prop('disabled', true);
                submitBtn.find('.indicator-label').hide();
                submitBtn.find('.indicator-progress').css('display', 'inline-block');
                
                // Guardar en localStorage si está marcado remember
                if ($('#remember-admin').is(':checked')) {
                    localStorage.setItem('email_admin', email);
                    localStorage.setItem('password_admin', password);
                    localStorage.setItem('remember-admin', true);
                } else {
                    localStorage.setItem('email_admin', '');
                    localStorage.setItem('password_admin', '');
                    localStorage.setItem('remember-admin', false);
                }
                
                // Enviar formulario
                setTimeout(function() {
                    form[0].submit();
                }, 500);
            });
        });

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
            }).then((function(t) {
                    window.location.replace("{{env('APP_URL')}}/admin");
                    return true;
            }));
        @endif

        @if (\Session::has('session_expired'))
            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>Sesión cerrada</h4>
                            <p class="text-muted mx-4 mb-0">{!! \Session::get('session_expired') !!}</p>
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

        @if (\Session::has('account_deleted_success'))
            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>¡Cuenta eliminada!</h4>
                            <p class="text-muted mx-4 mb-0">Tu cuenta ha sido eliminada exitosamente.</p>
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

        @if (\Session::has('account_deleted'))
            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>Cuenta eliminada</h4>
                            <p class="text-muted mx-4 mb-0">Tu cuenta ha sido eliminada y no puedes iniciar sesión.</p>
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
    </script>
@endsection

@extends('admin.layouts.public')

@section('content')

<div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="bg-overlay"></div>
    <div class="auth-page-content overflow-hidden pb-0 pt-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card overflow-hidden">
                        <div class="row justify-content-center g-0">
                            <div class="col-lg-6">
                                @include('admin.layouts.partials.sliders')
                            </div>
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <h5 class="text-primary">Crear nueva contraseña</h5>
                                    <p class="text-muted">Su nueva contraseña debe ser diferente de la contraseña utilizada anteriormente.</p>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        {{ $errors->first() }}
                                    </div>
                                    @endif
                                    <form action="{{ route('password.admin.change') }}" method="POST" id="formCreate">
                                        @csrf
                                        <div class="mb-3 fv-row">
                                            <label class="form-label" for="password-input">Contraseña</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false"
                                                    placeholder="Ingrese su contraseña" id="password-input" name="password" aria-describedby="passwordInput"
                                                    autocomplete="off" required disabled>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div class="mb-3 fv-row">
                                            <label class="form-label" for="confirm-password-input">Confirmar contraseña</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" onpaste="return false"
                                                    placeholder="Confirme su contraseña" id="confirm-password-input" name="password2"
                                                    autocomplete="off" required disabled>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="confirm-password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>
                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded" style="display: block !important;">
                                            <h5 class="fs-13">La contraseña debe contener:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Mínimo <b>8 caracteres</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">Al menos una letra <b>minúscula</b> (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">Al menos una letra <b>mayúscula</b> (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-2">Al menos un <b>número</b> (0-9)</p>
                                            <p id="pass-symbol" class="invalid fs-12 mb-0">Al menos un <b>símbolo</b> (!@#$%^&*)</p>
                                        </div>
                                        <input type="hidden" id="token" name="token">
                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit" id="kt_sign_up_submit">
                                                <span class="indicator-label">Restablecer contraseña</span>
                                                <span class="indicator-progress" style="display: none;">
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
        var token = @json($token);

        $.ajax({
            url: `{{ route("password.admin.find", ['token' => $token]) }}`,
            type: 'GET',
            success: function (response) {
                $("#password-input").prop("disabled", false);
                $("#confirm-password-input").prop("disabled", false);
                $("#token").val(token);
            },
            error: function (response) {
                Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Token inválido</h4>
                                    <p class="text-muted mx-4 mb-0">
                                       Tu token no es válido o ha expirado. Solicita un nuevo cambio de contraseña.
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
                }).then((function(t) {
                    window.location.href = "{{route('password.admin.forgot.password')}}";
                }));
            }
        });

        $(document).ready(function() {
            const form = $('#formCreate');
            const submitBtn = $('#kt_sign_up_submit');
            const passwordInput = $('#password-input');
            const confirmPasswordInput = $('#confirm-password-input');

            form.on('submit', function(e) {
                e.preventDefault();
                
                const password = passwordInput.val();
                const password2 = confirmPasswordInput.val();
                
                // Validación de contraseña vacía
                if (!password || !password2) {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Algo ha ido mal</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        Por favor complete todos los campos.
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
                
                // Validación de longitud mínima
                if (password.length < 8) {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Algo ha ido mal</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        La contraseña debe tener al menos 8 caracteres.
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
                
                // Validación de patrón (mayúsculas, minúsculas, números y símbolos)
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/;
                if (!passwordRegex.test(password)) {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Algo ha ido mal</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        Usa una combinación de mayúsculas, minúsculas, números y símbolos.
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
                
                // Validación de coincidencia
                if (password !== password2) {
                    Swal.fire({
                        html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                    <h4>Algo ha ido mal</h4>
                                    <p class="text-muted mx-4 mb-0">
                                        Las contraseñas no son iguales.
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
                submitBtn.find('.indicator-progress').show();
                
                // Enviar formulario
                setTimeout(function() {
                    form[0].submit();
                }, 500);
            });

            // Validación en tiempo real
            passwordInput.on('input', function() {
                const password = $(this).val();
                
                // Validar longitud
                if (password.length >= 8) {
                    $('#pass-length').removeClass('invalid').addClass('valid');
                } else {
                    $('#pass-length').removeClass('valid').addClass('invalid');
                }
                
                // Validar minúscula
                if (/[a-z]/.test(password)) {
                    $('#pass-lower').removeClass('invalid').addClass('valid');
                } else {
                    $('#pass-lower').removeClass('valid').addClass('invalid');
                }
                
                // Validar mayúscula
                if (/[A-Z]/.test(password)) {
                    $('#pass-upper').removeClass('invalid').addClass('valid');
                } else {
                    $('#pass-upper').removeClass('valid').addClass('invalid');
                }
                
                // Validar número
                if (/\d/.test(password)) {
                    $('#pass-number').removeClass('invalid').addClass('valid');
                } else {
                    $('#pass-number').removeClass('valid').addClass('invalid');
                }
                
                // Validar símbolo
                if (/[\W_]/.test(password)) {
                    $('#pass-symbol').removeClass('invalid').addClass('valid');
                } else {
                    $('#pass-symbol').removeClass('valid').addClass('invalid');
                }
            });
        });
    </script>
    <style>
        .invalid {
            color: #dc3545;
        }
        .valid {
            color: #198754;
        }
        .indicator-progress {
            display: none;
        }
    </style>
@endsection
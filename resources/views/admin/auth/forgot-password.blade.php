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
                        <div class="row justify-content-center g-0">
                            <div class="col-lg-6">
                                @include('admin.layouts.partials.sliders')
                            </div>
                            <div class="col-lg-6">
                                <div class="p-lg-5 p-4">
                                    <h5 class="text-primary mb-0 mb-md-1">¿Olvidó su contraseña?</h5>
                                    <p class="text-muted d-none d-md-flex">Restablezca su contraseña</p>
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                            colors="primary:#0ab39c" class="avatar-md d-lg-none">
                                        </lord-icon>
                                        <lord-icon src="https://cdn.lordicon.com/rhvddzym.json" trigger="loop"
                                            colors="primary:#0ab39c" class="avatar-xl d-none d-lg-flex mx-auto">
                                        </lord-icon>
                                    </div>
                                    <div class="alert alert-borderless alert-warning text-center mb-2 d-none d-md-flex"
                                        role="alert">
                                        ¡Ingrese su correo electrónico y le enviaremos las instrucciones!
                                    </div>
                                    <form action="{{ route('password.admin.confirm') }}" method="POST" id="formSubmit">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="form-label">Correo electrónico</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="Ingrese su correo electrónico" value="{{ old('email') }}" required>
                                            <div id="error-message" style="display: none;">
                                                <span class="invalid-feedback d-block mt-2">Por favor, ingrese un correo electrónico válido.</span>
                                            </div>
                                            @if ($errors->any())
                                                <div id="error-input">
                                                    <span class="invalid-feedback d-block mt-2">{{ $errors->first() }}</span>
                                                </div>
                                            @endif
                                            @error('email')
                                                <span class="invalid-feedback d-block mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <input type="hidden" name="route" id="hidden-route" value="password.admin.forgot.password">
                                        <div class="text-center mt-4">
                                            <button class="btn btn-success w-100" type="submit" id="submit-btn">
                                                <span class="indicator-label">Enviar enlace de restablecimiento</span>
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
    <script>    
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const submitBtn = document.getElementById('submit-btn');
            const formSubmit = document.getElementById('formSubmit');
            const errorMessage = document.getElementById('error-message');
            const errorInput = document.getElementById('error-input');

            // Ocultar mensajes de error cuando el usuario escribe
            emailInput.addEventListener('input', function() {
                errorMessage.style.display = 'none';
                @if ($errors->any())
                    if(errorInput) {
                        errorInput.style.display = 'none';
                    }
                @endif
            });

            // Manejar el envío del formulario
            formSubmit.addEventListener('submit', function(event) {
                event.preventDefault();
                
                // Validar email
                if (!emailInput.checkValidity()) {
                    errorMessage.style.display = 'block';
                    return false;
                }

                // Mostrar loading
                submitBtn.disabled = true;
                submitBtn.querySelector('.indicator-label').style.display = 'none';
                submitBtn.querySelector('.indicator-progress').style.display = 'inline-block';

                // Enviar formulario después de un breve delay
                setTimeout(function() {
                    formSubmit.submit();
                }, 500);
            });
        });
    </script>
@endsection

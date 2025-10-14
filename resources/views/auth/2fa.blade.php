@extends('layouts.public')

@section('page-content')
<style>
	@media (max-width: 991px) {
		#columnare {
			display: none!important;
		}
	}
</style>
<div class="d-flex flex-column flex-root">
	<div class="d-flex flex-column flex-md-row flex-column-fluid">
		<div class="bg-dark d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed py-10">
			<div class="d-flex flex-center flex-column flex-column-fluid p-0">
				<div class="w-100 w-lg-500px p-10 p-lg-20 bg-body-public section-believe-img">
					{!! Form::open(['route' => 'auth.2fa.validate', 'id' => 'formSubmit', 'class' => 'w-100', 'method' => 'POST']) !!}
                    <div class="text-center my-12">
                        <a href="{{route('index')}}">
							<img src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="" width="77%">
						</a>
                        <h1 class="text-white mb-1">Authenticator</h1>
                        <div class="text-muted fw-bold fs-5 mb-5">
                            Verificación de Doble Factor. <br>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="fv-row col-md-12">
                        <div class="fw-bolder text-center text-white fs-5 mb-1 ms-1">Escriba su código de seguridad de 6 dígitos</div>
                        <div id="error-message" style="display: none;">
                            <span class="invalid-feedback d-block text-center mb-10">Por favor, complete el campo de código.</span>
                        </div>
                        @if ($errors->any())
                            <div id="error-input">
                                <span class="invalid-feedback d-block text-center mb-10">{{ $errors->first() }}</span>
                            </div>
                        @endif
                        <div class="d-flex justify-content-center align-center">
                            <input type="tel" 
                                class="form-control-custom mx-0 my-2 bg-white w-100" 
                                maxlength="7"
                                id="token_2fa" 
                                name="token_2fa"
                                name="___-___"
                                required />
                            <input type="hidden" name="route" id="hidden-route" value="auth.2fa">
                        </div>
                        </div>
                    </div>
                    <div class="d-flex flex-center">
                        <button type="submit" class="btn btn-lg btn-primary w-100 mb-5" id="submit-btn">
                            <span class="indicator-label">Enviar</span>
                            <span class="indicator-progress">
                                <span class="spinner-border spinner-border-md align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>  
		</div>
	</div>
</div>

@endsection

@section('page-js')
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

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('token_2fa');
        const submitBtn = document.getElementById('submit-btn');
        const errorMessage = document.getElementById('error-message');
        const errorInput = document.getElementById('error-input');
        const formSubmit = document.getElementById('formSubmit');

        input.addEventListener('focus', function() {
            // Cuando el input está enfocado, manten la máscara de inputmask
            Inputmask({
                "mask": "999-999",
                "placeholder": "___-___",  // Placeholder vacío para que no interfiera con el inputmask
                "showMaskOnHover": false,   // No mostrar la máscara al pasar el mouse
                "showMaskOnFocus": true     // Mostrar la máscara solo al enfocar
            }).mask(input);
        });

        input.addEventListener('blur', function() {
            // Cuando el input pierde el foco, si está vacío, muestra el placeholder manual
            if (input.value === '') {
                input.placeholder = '___-___';
            }
        });

        input.addEventListener('input', function() {
            errorMessage.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif
        });

        // Iniciar con placeholder manual
        input.placeholder = '___-___';

        // Validación al hacer clic en el botón de enviar
        submitBtn.addEventListener('click', function(event) {
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif

            // Prevenir el envío del formulario si el campo no está completo
            if (input.value.includes('_') || input.value === '') {
                event.preventDefault(); // Detener el envío del formulario
                errorMessage.style.display = 'block'; // Mostrar mensaje de error

            } else {
                submitBtn.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click 
                submitBtn.disabled = true;

                errorMessage.style.display = 'none'; // Ocultar mensaje de error
                 // Simulate ajax request
                 setTimeout(function() {
                    // Hide loading indication
                    submitBtn.removeAttribute('data-kt-indicator');

                    // Enable button
                    submitBtn.disabled = false;
                    formSubmit.submit();
                }, 1000);
            }
        });
    });
</script>
@endsection
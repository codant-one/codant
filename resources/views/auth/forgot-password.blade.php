@extends('layouts.public')

@section('page-content')
<div class="d-flex flex-column flex-root">
	<div class="d-flex flex-column flex-md-row flex-column-fluid">
		<div class="bg-dark d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed py-10">
			<div class="d-flex flex-center flex-column flex-column-fluid p-0">
				<div class="w-lg-500px p-10 p-lg-20 mx-auto bg-body-public section-believe-img">
					{!! Form::open(['route' => 'password.admin.confirm', 'id'=>'formSubmit', 'class' => 'w-100', 'method' => 'POST']) !!}
                    <div class="text-center mb-5 mb-md-10">
                        <a href="{{route('index')}}">
							<img src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="" width="77%">
						</a>
                        <div class="text-gray-400 fw-bold fs-4">
                            Restablecer Contraseña
                        </div>
                    </div>
                    <div class="fv-row mb-5">
                        <label class="form-label input-label text-white required">Correo Electrónico</label>
                        <input class="form-control" type="email" placeholder="admin@codant.one" name="email" id="email" autocomplete="off" required/>
                        <div id="error-message" style="display: none;">
                            <span class="invalid-feedback d-block mb-3">Por favor, ingrese un correo electrónico válido.</span>
                        </div>
                        @if ($errors->any())
                            <div id="error-input">
                                <span class="invalid-feedback d-block mb-3">{{ $errors->first() }}</span>
                            </div>
                        @endif
                        @error('email')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                        <small>Ingrese su correo electrónico y enviaremos un link para reiniciar su contraseña</small>
                    </div>
                    <input type="hidden" name="route" id="hidden-route" value="password.admin.forgot.password">
                    <div class="d-flex justify-content-center pb-10 mb-7">
                        <div class="col-12 mb-10">
                            <button type="submit" id="submit-btn" class="btn btn-primary w-100 mb-10">
                                <span class="indicator-label">Enviar</span>
                                <span class="indicator-progress">
								<span class="spinner-border spinner-border-md align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        const emailInput = document.getElementById('email');
        const submitBtn = document.getElementById('submit-btn');
        const formSubmit = document.getElementById('formSubmit');
        const errorMessage = document.getElementById('error-message');
        const errorInput = document.getElementById('error-input');

        emailInput.addEventListener('input', function() {
            errorMessage.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif
        });

        formSubmit.addEventListener('submit', function(event) {
            if (!emailInput.checkValidity()) {
                event.preventDefault();
                errorMessage.style.display = 'block';
                return;
            }

            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            // Dejar que el navegador envíe el formulario; el indicador permanece visible hasta la navegación
        });
    });
</script>
@endsection
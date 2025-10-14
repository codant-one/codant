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
				<div class="w-lg-500px p-10 p-lg-20 mx-auto bg-body-public section-believe-img">
					{!! Form::open(['route' => 'auth.authenticate','id'=>'kt_sign_in_form', 'class' => 'w-100', 'method' => 'POST']) !!}
					<div class="text-center mb-5">
						<a href="{{route('index')}}">
							<img src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="" width="77%">
						</a>
						<div class="text-gray-400 fw-bold fs-4">
							Ingresar al panel administrativo
						</div>
					</div>
					<div class="row">
						<div class="fv-row col-md-12">
							<label class="form-label input-label text-white required">Correo electrónico</label>
							<input class="form-control form-control-lg" type="email" name="email" id="email" placeholder="admin@codant.one" autocomplete="off" required />

							@error('email')
								<div id="error-input">
									<span class="invalid-feedback d-block">{{ $message }}</span>
								</div>
							@enderror
						</div>
						<div class="fv-row" data-kt-password-meter="true">
							<div class="mb-1">
								<label class="form-label input-label text-white required">Contraseña</label>
								<div class="position-relative">
									<input class="form-control" type="password" name="password" id="password" placeholder="Ingrese su contraseña" autocomplete="off" />
									<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
										<i class="bi bi-eye-slash fs-2"></i>
										<i class="bi bi-eye fs-2 d-none"></i>
									</span>
								</div>
								@error('password')
									<span class="invalid-feedback d-block">{{ $message }}</span>
								@enderror							
							</div>
							<div class="d-none align-items-center" data-kt-password-meter-control="highlight">
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
								<div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
							</div>
						</div>

					</div>
					<!--remember me-->
					<div class="row fw-bolder-auth mb-7">
						<span class="fv-row col-md-6 col-7 text-start">
							<a href="{{route('password.admin.forgot.password')}}" class="text-link">¿Olvidó su contraseña?</a>
						</span>
						<span class="fv-row col-md-2" id="columnare"></span>
						<span class="fv-row col-md-4 col-5 text-end p-0">
							<label class="form-check form-check-custom form-check-solid justify-end">
								<span class="form-check-label fw-bolder-auth auth-text text-link me-auto">Recuérdeme</span>
								<input class="form-check-input h-20px w-20px me-2" type="checkbox" id="remember-admin"/>
							</label>
						</span>
					</div>
					
					<!--Fin remember me-->
					<div class="text-center">
						<button type="submit" id="kt_sign_up_submit" class="btn btn-primary w-100 mb-5" open-on-click>
							<span class="indicator-label">Ingresar</span>
								<span class="indicator-progress">
								<span class="spinner-border spinner-border-md align-middle ms-2"></span>
							</span>
						</button>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="d-none flex-center flex-wrap pb-0">
				<div class="d-flex flex-center fw-bold">
					<a href="{{ env('URL_TERMINOS_Y_CONDICIONES') }}" target="_blank" class="text-link-public px-2">Términos y condiciones</a>
					<a href="{{ env('URL_POLITICA_DE_PRIVACIDAD') }}" target="_blank" class="text-link-public px-2">Política y privacidad</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page-js')
<script>

	document.addEventListener('DOMContentLoaded', function() {
		const errorInput = document.getElementById('error-input');
		const inputEmail = document.getElementById('email');
		const inputPassword = document.getElementById('password');

		inputEmail.addEventListener('input', function() { 
            @if ($errors->any())
                errorInput.style.display = 'none';
            @endif
        });

		inputPassword.addEventListener('input', function() { 
            @if ($errors->any())
                errorInput.style.display = 'none';
            @endif
        });

	});

	$(document).ready(function(){

		$('#remember-admin').prop('checked', (localStorage.getItem('remember-admin') === 'true') ? true : false);
		$('#email').val(localStorage.getItem('email_admin') ?? null)
		$('#password').val(localStorage.getItem('password_admin') ?? null)

		$('#remember-admin').on('change', function(){

			if( $(this).is(':checked') ){
				localStorage.setItem('email_admin', $('#email').val());
        		localStorage.setItem('password_admin', $('#password').val());
				localStorage.setItem('remember-admin', ($('#remember-admin').val() === 'on') ? true : false);

			} else {
				localStorage.setItem('email_admin', '');
        		localStorage.setItem('password_admin', '');
				localStorage.setItem('remember-admin', false);
			}
		});
	});

	
    "use strict";
	
	var KTSignupGeneral = function() {
	    var e, t, a, s = function() {
	        return 100 === s.getScore()
	    };
		
	    return {
	        init: function() {
	            e = document.querySelector("#kt_sign_in_form"),
	            t = document.querySelector("#kt_sign_up_submit"),
	            s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')),
	            a = FormValidation.formValidation(e, {
	                fields: {
	                    "email": {
	                        validators: {
	                            notEmpty: {
	                                message: "Correo electrónico es requerido"
	                            },
								regexp: {
									regexp: /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,
									message: "El formato del correo electrónico no es válido"
								}
	                        }
	                    },
	                    "password": {
	                        validators: {
	                            notEmpty: {
	                                message: "Contraseña requerida"
	                            },
	                            callback: {
	                                message: "Por favor ingrese una contraseña valida"
	                            }
	                        }
	                    }
	                },
	                plugins: {
	                    trigger: new FormValidation.plugins.Trigger({
	                        event: {
	                            password: !1
	                        }
	                    }),
	                    bootstrap: new FormValidation.plugins.Bootstrap5({
	                        rowSelector: ".fv-row",
	                        eleInvalidClass: "",
	                        eleValidClass: ""
	                    })
	                }
	            }),
	            t.addEventListener("click", (function(r) {
	                r.preventDefault(),
					a.revalidateField("password"),
	                a.validate().then((function(status) {
	                    "Valid" == status && $('#password').val() !== '' ? (t.setAttribute("data-kt-indicator", "on"),
	                    t.disabled = !0,
	                    setTimeout((function() {
	                        t.removeAttribute("data-kt-indicator"),
	                        t.disabled = !1,

	                        $("#kt_sign_in_form").submit();

							if( $('#remember-admin').is(':checked') ){
								localStorage.setItem('email_admin', $('#email').val());
								localStorage.setItem('password_admin', $('#password').val());
								localStorage.setItem('remember-admin', ($('#remember-admin').val() === 'on') ? true : false);

							} else {
								localStorage.setItem('email_admin', '');
								localStorage.setItem('password_admin', '');
								localStorage.setItem('remember-admin', false);
							}
	                    }
	                    ), 1500)) : 

							Swal.fire({
								title: 'Algo ha ido mal',
								html: `
									<div class="d-flex flex-column">
										<span class="swal2-subtitle-error">Lo sentimos, algunos datos son errados. </span>
										<span class="swal2-html-container d-flex mt-0 align-center">
											<img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
											<span class="ms-2">Revise la información e intente de nuevo.</span>
										</span>
									</div>
								`,
								confirmButtonText: "Entendido",
								focusConfirm: false,
								focusCancel: false,
								showCloseButton: true,
								imageUrl: "{{ asset('img/icon_error.png') }}",
								imageAlt: "Error",
								closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
								customClass: {
									image: 'mt-10 mb-0 mx-auto w-25',
									confirmButton: "btn btn-standar",
									closeButton: 'custom-swal-close-button',
									htmlContainer: 'swal2-html-container', 
								}
							})
	                }
	                ))
	            }
	            )),
	            e.querySelector('input[name="password"]').addEventListener("input", (function() {
	                this.value.length > 0 && a.updateFieldStatus("password", "NotValidated")
	            }
	            ))
	        }
	    }
	}();

	KTUtil.onDOMContentLoaded((function() {
	    KTSignupGeneral.init()
	}
	));

	@if (\Session::has('register_success'))

        Swal.fire({
			title: "{{ \Session::get('success') ? '¡Enhorabuena!' : 'Algo ha ido mal' }}",
			html: `
					<div class="d-flex flex-column">
						<span class="swal2-subtitle-success">{!! \Session::get('register_success') !!}</span>
						<span class="swal2-html-container d-flex mt-0 align-center">
							@if (\Session::has('text'))
							<span class="ms-2">{!! \Session::get('text') !!}</span>
							@endif
						</span>
					</div>
			`,
			confirmButtonText: "{{ \Session::get('button') ?? '¡Entendido!' }}",
			focusConfirm: false,
			focusCancel: false,
			showCloseButton: true,
			imageUrl: "{{ \Session::get('success') ? asset('img/icon_success.png') : asset('img/icon_error.png') }}",
			imageAlt: "Maintenance",
			closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
            customClass: {
				image: 'mt-10 mb-0 mx-auto w-25',
				confirmButton: "btn btn-standar",
				closeButton: 'custom-swal-close-button',
				htmlContainer: 'swal2-html-container', 
            }
        }).then((function(t) {
            window.location.replace("{{env('APP_URL')}}/admin");
            return true;
        }
        ));
    @endif
</script>
@endsection

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
					{!! Form::open(['route' => 'password.admin.change','id'=>'formCreate', 'class' => 'w-100', 'method' => 'POST']) !!}
                    <div class="text-center mb-5 mb-md-10">
                        <a href="{{route('index')}}">
							<img src="{{ asset(env('DOMAIN_LOGO_REVERSE_SVG')) }}" alt="" width="77%">
						</a>
                        <div class="text-gray-400 fw-bold fs-4">
                            Restablecer Contraseña
                        </div>
                    </div>

                    <div class="text-center mb-md-10 mb-5">                        
                        @if ($errors->any())
                        <div class="mt-6 mb-6">
                            <span class="alert alert-danger">
                                {{ $errors->first() }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="fv-row col-md-12" data-kt-password-meter="true">
                        <div class="mb-1">
                            <label class="form-label input-label text-white required" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Use 8 o más caracteres con una combinación de letras (al menos una mayúscula), números y símbolos.">
                                Contraseña
                                <i class="fa fa-info-circle fs-5"></i>
                            </label>
                            <div class="position-relative mb-2">
                                <input class="form-control" type="password" placeholder="Nueva contraseña" name="password" id="password" autocomplete="off" required disabled/>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>      
                            <div class="d-flex align-items-center mb-1" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5 fv-row col-md-12" data-kt-password-meter="true">
                        <label class="form-label input-label text-white required">Confirmar Contraseña</label>
                        <div class="position-relative mb-2">
                            <input class="form-control" type="password" placeholder="Confirmar Contraseña" id="password2" name="password2" autocomplete="off" required disabled/>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>     
                        <div class="" data-kt-password-meter-control="highlight" style="display: none;">
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                        </div>
                    </div>
                    </div>
                    <input type="hidden" id="token" name="token">
                    <div class="d-flex justify-content-center pb-5">
                        <div class="col-12">
                            <button type="submit" id="kt_sign_up_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                <span class="indicator-label">Enviar</span>
                                <span class="indicator-progress">
                                <span class="spinner-border spinner-border-md align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </div>   
                    {!! Form::close() !!}\
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page-js')
<script>

    var token = @json($token);

    $.ajax({
        url: `{{ route("password.admin.find", ['token' => $token]) }}`,
        type: 'GET',
        success: function (response) {
            $("#password").prop("disabled",false);
            $("#password2").prop("disabled",false);
            $("#token").val(token);
        },
        error: function (response) {
            Swal.fire({
                title: "Token inválido",
                html: `
					<div class="d-flex flex-column">
						<span class="swal2-subtitle-error">Tu token no es válido o ha expirado.</span>
						<span class="swal2-html-container d-flex mt-0 align-center">
							<img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
							<span class="ms-2">Solicita un nuevo cambio de contraseña.</span>
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
            }).then((function(t) {
                window.location.href = "{{route('password.admin.forgot.password')}}";
            }
            ));
        }
    });

    "use strict";

    var KTSignupGeneral = function() {
        var e, t, a, s, r = function() {
            return 100 === s.getScore()
        };

        return {
            init: function() {
                e = document.querySelector("#formCreate"),
                t = document.querySelector("#kt_sign_up_submit"),
                s = KTPasswordMeter.getInstance(e.querySelector('[data-kt-password-meter="true"]')),
                a = FormValidation.formValidation(e, {
                    fields: {
                        "password": {
                            validators: {
                                notEmpty: {
                                    message: "Contraseña requerida"
                                },
                                stringLength: {
                                    min: 8,
                                    message: 'La contraseña debe tener al menos 8 caracteres'
                                },
                                regexp: {
                                    regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/,
                                    message: "Usa una combinación de mayúsculas, minúsculas, números y símbolos"
                                }
                            }
                        },
                        "password2": {
                            validators: {
                                notEmpty: {
                                    message: "Confirmación de contraseña requerida"
                                },
                                identical: {
                                    compare: function() {
                                        return e.querySelector('[name="password"]').value
                                    },
                                    message: "Las contraseñas no son iguales"
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
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
                    a.validate().then((function(a) {
                        "Valid" == a ? (t.setAttribute("data-kt-indicator", "on"),
                        t.disabled = !0,
                        setTimeout((function() {
                            t.removeAttribute("data-kt-indicator"),
                            t.disabled = !1,
                            $("#formCreate").submit();
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
                    a.revalidateField("password")
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
</script>
@endsection
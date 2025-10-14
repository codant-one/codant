<div class="modal fade" id="update_2fa" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-600px">
		<div class="modal-content">
			<div class="modal-header p-3 mx-5">
				<span class="text-">Factor doble autenticación (2FA)</span>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
					<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close">
				</div>
			</div>
			{!!  Form::open(['route' => ['auth.2fa.validate'], 'method' => 'POST', 'files' => true, 'id' => 'kt_modal_update_2fa_form']) !!}
            <div class="modal-body scroll-y mx-3 mx-xl-5 my-0 pb-0">
                <h2 class="text-center">Authenticator apps</h2>
                <div class="text-muted fw-bold fs-5">
                    Utilizando una aplicación de autenticación como <strong>Google Authenticator, Microsoft Authenticator, Authy, etc.</strong>, 
                    escanee el código QR. Generará un código de 6 dígitos para que lo ingrese a continuación.
                </div>
                <div class="text-center"> {!! $qr !!} </div>

                <div class="notice d-flex bg-light-danger rounded border p-6 mb-3">
                    <div class="d-flex flex-stack flex-grow-1">
                        <div class="fw-bold">
                            <h3 class="text-gray-900 fw-bolder">{{ $token }}</h3>
                            <div class="fs-6 text-gray-700">Si no puede escanear el código QR, puede ingresar manualmente la clave secreta a continuación.</div>
                        </div>
                    </div>
                </div>

                <h4 class="fs-5 ml-2">Escriba su código de seguridad de 6 dígitos</h4>
                <div id="error-message" style="display: none;">
                    <span class="invalid-feedback d-block mb-10">Por favor, complete el campo de código.</span>
                </div>
                <div class="d-flex justify-content-start align-center mb-3">
                    <input type="tel" 
                        class="form-control-custom mx-0 my-2 bg-white w-100 text-start" 
                        maxlength="7"
                        id="token_2fa" 
                        name="token_2fa"
                        name="___-___"
                        required />
                    <input type="hidden" name="route" id="hidden-route" value="profile">
                    <input type="hidden" name="panel" id="panel" value="true">
                </div>
			</div>
            <div class="modal-footer p-3 mx-5">
				<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Descartar</button>
				<button type="submit" id="kt_modal_2fa_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
					<span class="indicator-label">{{auth()->user()->is_2fa === 0 ? 'Habilitar' : 'Deshabilitar'}}</span>
					<span class="indicator-progress">
					<span class="spinner-border spinner-border-md align-middle"></span></span>
				</button>
			</div> 
			{!! Form::close() !!}
		</div>
	</div>
</div>
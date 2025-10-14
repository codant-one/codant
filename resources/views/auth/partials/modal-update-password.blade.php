<div class="modal fade" id="update_password" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-550px">
		<div class="modal-content">
			<div class="modal-header p-3 mx-5">
				<span class="text ">Actualizar Contraseña</span>
				<div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
					<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close">
				</div>
			</div>
			{!!  Form::open(['route' => ['updatePassword'], 'method' => 'POST', 'files' => true, 'id' => 'kt_modal_update_password_form']) !!}
            <div class="modal-body scroll-y mx-3 mx-xl-5 my-0 pb-0">
				<div class="fv-row mb-1" data-kt-password-meter="true">
					<label class="required form-label fs-6 mb-2">Contraseña actual</label>
					<div class="position-relative">
						<input class="form-control form-control-lg" type="password" placeholder="" name="current_password" autocomplete="off" required/>
						<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
							<i class="bi bi-eye-slash fs-2"></i>
							<i class="bi bi-eye fs-2 d-none"></i>
						</span>
					</div>
				</div>
				<div class="mb-1 fv-row" data-kt-password-meter="true">
					<div class="mb-1">
						<label class="form-label fw-bold fs-6 mb-2 required" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Use 8 o más caracteres con una combinación de letras (al menos una mayúscula), números y símbolos.">
							Nueva contraseña
							<i class="fa fa-info-circle fs-5"></i>
						</label>
						<div class="position-relative mb-3">
							<input class="form-control form-control-lg" type="password" placeholder="" name="new_password" autocomplete="off" />
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
				<div class="fv-row mb-1" data-kt-password-meter="true">
					<label class="form-label fw-bold fs-6 mb-2 required">Confirmar nueva contraseña</label>
					<div class="position-relative">
						<input class="form-control form-control-lg" type="password" placeholder="" name="confirm_password" autocomplete="off" />
						<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
							<i class="bi bi-eye-slash fs-2"></i>
							<i class="bi bi-eye fs-2 d-none"></i>
						</span>
					</div>
				</div>
			</div>
            <div class="modal-footer p-3 mx-5">
				<button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Descartar</button>
				<button type="submit" id="kt_modal_submit" class="btn btn-primary" data-kt-users-modal-action="submit">
					<span class="indicator-label">Registrar</span>
					<span class="indicator-progress">
					<span class="spinner-border spinner-border-md align-middle"></span></span>
				</button>
			</div> 
			{!! Form::close() !!}
		</div>
	</div>
</div>
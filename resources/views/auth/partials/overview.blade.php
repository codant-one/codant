<div class="tab-pane fade show active" id="overview" role="tabpanel">
	<div class="card mb-xl-10">
		<div class="card-header cursor-pointer">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">Detalles del Perfil</h3>
			</div>
			<button onclick="return editProfile();" class="btn btn-primary align-self-center">Editar Perfil</button>
		</div>
		<div class="card-body p-9">
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Nombre Completo</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800">{{ auth()->user()->firstname }} {{ auth()->user()->secondname }} {{ auth()->user()->lastname }} {{ auth()->user()->secondsurname }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Correo</label>
				<div class="col-lg-8 fv-row d-flex">
					<span class="fw-bolder text-gray-800 fs-6 me-2">{{ auth()->user()->email }}</span>
					<div class="text-badge">
						<span class="text-status badge-status-enabled">Verificado</span>
					</div>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Fecha de nacimiento</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800">{{ auth()->user()->userDetail->birthday ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Documento</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800">{{ auth()->user()->userDetail->document ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">País
					<i class="fas fa-exclamation-circle ms-1 fs-7" data-bs-toggle="tooltip" title="País de origen"></i>
				</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800">{{ auth()->user()->userDetail->address->city->province->country->name ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Estado</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800">{{ auth()->user()->userDetail->address->city->province->name ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Ciudad</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800">{{ auth()->user()->userDetail->address->city->name ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Teléfono de contacto</label>
				<div class="col-lg-8 d-flex align-items-center">
					<span class="fw-bolder fs-6 text-gray-800 me-2">{{ auth()->user()->userDetail->phone ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">Dirección</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800 me-2">{{ auth()->user()->userDetail->address->address ?? '---' }}</span>
				</div>
			</div>
			<div class="row mb-7">
				<label class="col-lg-4 fw-bold text-muted">C&oacute;digo postal</label>
				<div class="col-lg-8">
					<span class="fw-bolder fs-6 text-gray-800 me-2">{{ auth()->user()->userDetail->address->postal_code ?? '---' }}</span>
				</div>
			</div>

			@if($profileCompletenessPercentage < 100)
			<div class="notice d-flex bg-light-warning rounded border-warning border border-dashed p-6">
				<span class="svg-icon svg-icon-2tx svg-icon-warning me-4">
					<svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
						<rect fill="#000000" x="11" y="7" width="2" height="8" rx="1" />
						<rect fill="#000000" x="11" y="16" width="2" height="2" rx="1" />
					</svg>
				</span>
				<div class="d-flex flex-stack flex-grow-1">
					<div class="fw-bold">
						<h4 class="text-gray-900 fw-bolder">¡Necesitamos su atención!!</h4>
						<div class="fs-6 text-gray-700">Para más seguridad complete su perfil</div>
					</div>
				</div>
			</div>
			@endif
		</div>
	</div>
</div>
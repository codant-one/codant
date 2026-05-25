<div class="tab-pane" id="security" role="tabpanel">
	<form action="{{ route('updatePassword') }}" method="POST" enctype="multipart/form-data" id="update_password_form" class="needs-validation" novalidate>
		@csrf
		<div class="row g-2">
			<div class="col-lg-4">
				<label for="current_password_input" class="form-label"> Contraseña actual*</label>
				<div class="position-relative auth-pass-inputgroup">
					<input 
						type="password" 
						class="form-control pe-5 password-input" 
						id="current_password"
						name="current_password"
						placeholder=""
						required
					>
					<button
						class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
						type="button"
						data-target="current_password">
						<i class="ri-eye-fill align-middle"></i>
					</button>
					<div class="invalid-feedback">
						La contraseña actual es requerida
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<label for="new_password_input" class="form-label">Nueva contraseña*</label>
				<div class="position-relative auth-pass-inputgroup">
					<input 
						type="password" 
						class="form-control pe-5 password-input" 
						id="new_password"
						name="new_password"
						placeholder=""
						minlength="8"
						required
					>
					<button
						class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
						type="button"
						data-target="new_password">
						<i class="ri-eye-fill align-middle"></i>
					</button>
					<div class="invalid-feedback">
						La nueva contraseña es requerida
					</div>
				</div>
			</div>
			<div class="col-lg-4">
					<label for="confirm_password_input" class="form-label"> Confirmar contraseña*</label>
					<div class="position-relative auth-pass-inputgroup">
						<input 
							type="password" 
							class="form-control pe-5 password-input" 
							id="confirm_password"
							name="confirm_password"
							placeholder=""
							required
						>
						<button
							class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
							type="button"
							data-target="confirm_password">
							<i class="ri-eye-fill align-middle"></i>
						</button>
						<div class="invalid-feedback">
							La confirmación de contraseña es requerida
						</div>
					</div>
			</div>
			<div class="col-lg-12">
				<div class="mb-3">
					<a href="{{route('password.admin.forgot.password')}}" class="link-primary text-decoration-underline">
						¿Olvidó su contraseña?
					</a>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="text-end">
					<button type="submit" id="update_password_form_submit" class="btn btn-success">
						<span class="indicator-label">Cambiar contraseña</span>
						<span class="indicator-progress d-none">
							<span class="spinner-border spinner-border-sm align-middle"></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</form>
	<div class="mt-4 mb-3 border-bottom pb-2">
		<div class="float-end">
			<a href="javascript:void(0);" 
			   class="link-primary" 
			   id="logout-all-sessions"
			   data-url="{{ route('logoutAllSessions') }}">
				Cerrar todas
			</a>
		</div>
		<h5 class="card-title">Historial de inicio de sesión</h5>
	</div>

	@php
		// Función para obtener el ícono según el tipo de dispositivo
		function getDeviceIcon($device) {
			$deviceLower = strtolower($device);
			if (str_contains($deviceLower, 'phone') || str_contains($deviceLower, 'mobile')) {
				return 'ri-smartphone-line';
			} elseif (str_contains($deviceLower, 'tablet') || str_contains($deviceLower, 'ipad')) {
				return 'ri-tablet-line';
			} elseif (str_contains($deviceLower, 'desktop') || str_contains($deviceLower, 'macbook') || str_contains($deviceLower, 'laptop')) {
				return 'ri-macbook-line';
			} else {
				return 'ri-computer-line';
			}
		}
		$currentSessionId = trim(session()->getId());
	@endphp

	@forelse($userLogins as $index => $login)
		<div class="d-flex align-items-center {{ $index < count($userLogins) - 1 ? 'mb-3' : '' }}">
			<div class="flex-shrink-0 avatar-sm">
				<div class="avatar-title bg-light text-primary rounded-3 fs-18">
					<i class="{{ getDeviceIcon($login->device) }}"></i>
				</div>
			</div>
			<div class="flex-grow-1 ms-3">
				<h6>
					{{ $login->device }}
					@if(trim($login->session_id) === $currentSessionId)
						<span class="badge bg-success ms-2">Sesión actual</span>
					@endif
					@if(!$login->is_active)
						<span class="badge bg-secondary ms-2">Inactiva</span>
					@endif
				</h6>
				<p class="text-muted mb-0">
					{{ $login->location }} - {{ \Carbon\Carbon::parse($login->created_at)->format('d M g:ia') }}
				</p>
				<small class="text-muted">
					<i class="ri-window-line"></i> {{ $login->plataform }} | 
					<i class="ri-global-line"></i> {{ $login->browser }} | 
					<i class="ri-ip-line"></i> {{ $login->ip }}
				</small>
			</div>
			<div>
				@if($login->is_active && $login->session_id)
					<a href="javascript:void(0);" 
					   class="text-danger logout-session d-flex" 
					   data-session-id="{{ $login->session_id }}"
					   data-url="{{ route('logoutSession', $login->session_id) }}"
					   data-is-current="{{ trim($login->session_id) === $currentSessionId ? 'true' : 'false' }}">
						<i class="ri-logout-circle-line"></i> 
						<span class="d-none d-md-block ms-2">Cerrar sesión</span>
					</a>
				@else
					<span class="text-muted">
						<i class="ri-check-line"></i> Cerrada
					</span>
				@endif
			</div>
		</div>
	@empty
		<div class="text-center py-4">
			<p class="text-muted mb-0">No hay registros de inicio de sesión</p>
		</div>
	@endforelse
</div>
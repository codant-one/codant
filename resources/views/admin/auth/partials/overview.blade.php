<div class="card">
	<div class="card-body">
		<h5 class="card-title mb-5">Completitud del perfil</h5>
		<div class="progress animated-progress custom-progress progress-label">
			<div 
				class="progress-bar bg-{{ $profileCompletenessPercentage >= 80 ? 'success' : ($profileCompletenessPercentage >= 50 ? 'warning' : 'danger') }}" role="progressbar" style="width: {{ $profileCompletenessPercentage }}%"
				aria-valuenow="{{ $profileCompletenessPercentage }}" 
				aria-valuemin="0" 
				aria-valuemax="100">
				<div class="label">
					{{ $profileCompletenessPercentage }}%
				</div>
			</div>
		</div>
	</div>
</div>
<div class="card">
	<div class="card-body">
		<h5 class="card-title mb-3">Información</h5>
		<div class="table-responsive">
			<table class="table table-borderless mb-0">
				<tbody>
					<tr>
						<th class="ps-0" scope="row">Nombre completo:</th>
						<td class="text-muted">{{ auth()->user()->firstname }} {{ auth()->user()->secondname }} {{ auth()->user()->lastname }} {{ auth()->user()->secondsurname }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Teléfono:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->phone ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Correo:</th>
						<td class="text-muted">{{ auth()->user()->email }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Fecha de nacimiento:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->birthday ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Documento:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->document ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">País:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->address->city->province->country->name ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Estado:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->address->city->province->name ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Ciudad:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->address->city->name ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Dirección:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->address->address ?? '---' }}</td>
					</tr>
					<tr>
						<th class="ps-0" scope="row">Código postal:</th>
						<td class="text-muted">{{ auth()->user()->userDetail->address->postal_code ?? '---' }}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
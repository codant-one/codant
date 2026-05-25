<div class="tab-pane active" id="settings" role="tabpanel">
	<form action="{{ route('profileStore') }}" method="POST" enctype="multipart/form-data" id="profileForm" class="needs-validation" novalidate>
		@csrf
		<input type="hidden" id="map-lat" name="mapLat"/>
		<input type="hidden" id="map-lon" name="mapLon"/>
		<input type="hidden" id="map-address" name="mapDesc"/>
		<input type="hidden" id="map-image" name="mapImage"/>
		
		<div class="row">
			<!-- First Name -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="firstname" class="form-label">Primer nombre</label>
					<input type="text" name="firstname" id="firstname" 
						value="{{ auth()->user()->firstname ?? old('firstname') }}" 
						class="form-control" placeholder="Ingrese su primer nombre" required>
					<div class="invalid-feedback">
						El primer nombre es requerido
					</div>
				</div>
			</div>

			<!-- Second Name -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="secondname" class="form-label">Segundo nombre</label>
					<input type="text" name="secondname" id="secondname" 
						value="{{ auth()->user()->secondname ?? old('secondname') }}" 
						class="form-control" placeholder="Ingrese su segundo nombre">
				</div>
			</div>

			<!-- Last Name -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="lastname" class="form-label">Primer apellido</label>
					<input type="text" name="lastname" id="lastname" 
						value="{{ auth()->user()->lastname ?? old('lastname') }}" 
						class="form-control" placeholder="Ingrese su primer apellido" required>
					<div class="invalid-feedback">
						El primer apellido es requerido
					</div>
				</div>
			</div>

			<!-- Second Surname -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="secondsurname" class="form-label">Segundo apellido</label>
					<input type="text" name="secondsurname" id="secondsurname" 
						value="{{ auth()->user()->secondsurname ?? old('secondsurname') }}" 
						class="form-control" placeholder="Ingrese su segundo apellido">
				</div>
			</div>

			<!-- Email Address -->
			<div class="col-lg-12">
				<div class="mb-3">
					<label for="email" class="form-label">Correo electrónico</label>
					<input type="email" name="email" id="email" 
						value="{{ auth()->user()->email }}" 
						class="form-control" placeholder="Correo electrónico" disabled>
				</div>
			</div>

			<!-- Phone Number -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="phone" class="form-label">Teléfono de contacto</label>
					<div class="input-group has-validation">
						<span class="input-group-text" id="phonecode"></span>
						<input type="text" name="phone" id="phone" 
							value="{{ auth()->user()->userDetail->phone ?? null }}" 
							class="form-control" placeholder="Teléfono de contacto" readonly required>
						<div class="invalid-feedback">
							El teléfono es requerido
						</div>
					</div>
				</div>
			</div>

			<!-- Birth Date -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="birthday" class="form-label">Fecha de nacimiento</label>
					<input type="text" name="birthday" id="birthday" 
						value="{{ auth()->user()->userDetail->birthday ?? null }}" 
						class="birthday form-control" data-provider="flatpickr"
						data-date-format="Y-m-d" placeholder="yyyy-mm-dd" readonly required>
					<div class="invalid-feedback">
						La fecha de nacimiento es requerida
					</div>
				</div>
			</div>

			<!-- Tax ID (Documento) -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="document" class="form-label">Documento</label>
					<input type="tel" name="document" id="document" 
						value="{{ auth()->user()->userDetail->document ?? null }}" 
						class="form-control" placeholder="Documento" required>
					<div class="invalid-feedback">
						El documento es requerido
					</div>
				</div>
			</div>

			<!-- Gender -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="gender_id" class="form-label">Género</label>
						<select class="form-select genders" name="gender_id" id="gender_id" required>
							<option value="">Seleccione</option>
						@foreach ($gendersActives as $key => $gender)
							<option value="{{ $key }}"
								{{ isset(auth()->user()->userDetail) ? (($key === auth()->user()->userDetail->gender_id) ? 'selected' : '') : '' }}>
								{{ $gender }}
							</option>
						@endforeach
					</select>
					<div class="invalid-feedback">
						El género es requerido
					</div>
				</div>
			</div>		
		
			<!-- Country -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="country_id" class="form-label">País de residencia</label>
					<select class="form-select countries" name="country_id" id="country_id" disabled required>
						<option value="" selected="selected">Seleccione</option>
						@foreach ($countries as $key => $country)
							<option value="{{ $key }}"
								{{ isset(auth()->user()->userDetail->address->city->province->country) ? 
									(($key === auth()->user()->userDetail->address->city->province->country->id) ? 'selected' : '') : 
									($key == env('COUNTRY_ID') ? 'selected' : '') }}>
								{{ $country }}
							</option>
						@endforeach
					</select>
					<div class="invalid-feedback">
						El país es requerido
					</div>
				</div>
			</div>			
			<!-- Province -->
			<div class="col-lg-6">
					<div class="mb-3">
						<label for="province_id" class="form-label">Estado</label>
						<select class="form-select provinces" name="province_id" id="province_id" required>
							<option value="">Seleccione</option>
							@isset(auth()->user()->userDetail->address->city->province->id)
								<option value="{{ auth()->user()->userDetail->address->city->province->id }}" selected>
									{{ auth()->user()->userDetail->address->city->province->name }}
								</option>
							@endisset
						</select>
						<div class="invalid-feedback">
							El estado es requerido
						</div>
				</div>
			</div>		

			<!-- City -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="city_id" class="form-label">Ciudad</label>
					<select class="form-select cities" name="city_id" id="city_id" required>
						<option value="">Seleccione</option>
						@isset(auth()->user()->userDetail->address->city->id)
							<option value="{{ auth()->user()->userDetail->address->city->id }}" selected>
								{{ auth()->user()->userDetail->address->city->name }}
							</option>
						@endisset
					</select>
					<div class="invalid-feedback">
						La ciudad es requerida
					</div>
				</div>
			</div>		
				
			<!-- Postal Code -->
			<div class="col-lg-6">
				<div class="mb-3">
					<label for="postal_code" class="form-label">Código postal</label>
					<input type="text" name="postal_code" id="postal_code" 
						value="{{ auth()->user()->userDetail->address->postal_code ?? null }}" 
						class="form-control" placeholder="Código postal" required>
					<div class="invalid-feedback" id="invalid-postal-code">
						El código postal es requerido
					</div>
				</div>
			</div>

			<!-- Address with Map -->
			<div class="col-lg-12">
				<div class="mb-3">
					<label class="form-label">Dirección</label>
					<div id="map" style="width: 100%; height: 300px;" class="mb-3"></div>
					<input type="text" name="details-address" id="details-address" 
						value="{{ auth()->user()->userDetail->address->address ?? null }}" 
						class="form-control" placeholder="Dirección" required>
					<div class="invalid-feedback">
						La dirección es requerida
					</div>
				</div>
			</div>

			<!-- Action Buttons -->
			<div class="col-lg-12">
				<div class="hstack gap-2 justify-content-end">
					<button type="submit" class="btn btn-primary" id="form_submit">
						<span class="indicator-label">Actualizar</span>
						<span class="indicator-progress d-none">
							<span class="spinner-border spinner-border-sm align-middle"></span>
						</span>
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
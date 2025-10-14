<div class="tab-pane fade" id="settings" role="tabpanel">
	<div class="card mb-xl-10">
		<div class="card-header cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">Ajustes</h3>
			</div>
		</div>
		<div class="card-body p-9">
			{!!  Form::open(['route' => ['profileStore'], 'method' => 'POST', 'files' => true, 'id' => 'profileForm']) !!}
			<input type="hidden" id="map-lat" name="mapLat"/>
			<input type="hidden" id="map-lon" name="mapLon"/>
			<input type="hidden" id="map-address" name="mapDesc"/>
			<input type="hidden" id="map-image" name="mapImage"/>
			<div class="row mb-7">
                <label class="col-lg-2 fw-bold text-muted">Avatar</label>
                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    @include('commons.image-field', [
                        'name' => 'image',
						'type' => 'circle',
						'classImage' => '',
                        'default' => !is_null(auth()->user()->avatar) ? asset('storage/'.auth()->user()->avatar) : asset('img/placeholders/user.png')
                    ])
                </div>
            </div>
            <div class="row mb-7">
                <label class="col-lg-2 fw-bold text-muted">Nombre Completo</label>
                <div class="col-10 row">
	                <div class="col-lg-3 fv-row fv-plugins-icon-container">
	                    {!! Form::text('firstname', auth()->user()->firstname ?? old('firstname'),
	                        ['id' => 'firstname',
	                         'class' => 'form-control mb-3 mb-lg-0',
	                         'placeholder' => 'Primer nombre'])
	                    !!}
	                </div>
					<div class="col-lg-3 fv-row fv-plugins-icon-container">
	                    {!! Form::text('secondname', auth()->user()->secondname ?? old('secondname'),
	                        ['id' => 'secondname',
	                         'class' => 'form-control mb-3 mb-lg-0',
	                         'placeholder' => 'Segundo nombre'])
	                    !!}
	                </div>
					<div class="col-lg-3 fv-row fv-plugins-icon-container">
	                    {!! Form::text('lastname', auth()->user()->lastname ?? old('lastname'),
	                        ['id' => 'lastname',
	                         'class' => 'form-control mb-3 mb-lg-0',
	                         'placeholder' => 'Primer apellido'])
	                    !!}
	                </div>
					<div class="col-lg-3 fv-row fv-plugins-icon-container">
	                    {!! Form::text('secondsurname', auth()->user()->secondsurname ?? old('secondsurname'),
	                        ['id' => 'secondsurname',
	                         'class' => 'form-control mb-3 mb-lg-0',
	                         'placeholder' => 'Segundo apellido'])
	                    !!}
	                </div>
                </div>
            </div>
            <div class="row mb-7">
				<label class="col-lg-2 fw-bold text-muted">Correo</label>
                <div class="col-lg-10 fv-row fv-plugins-icon-container">
                    {!! Form::text('email', auth()->user()->email,
                        ['id' => 'email',
						 'disabled' => 'disabled',
                         'class' => 'form-control mb-3 mb-lg-0',
                         'placeholder' => 'Correo'])
                    !!}
                </div>
            </div> 
			<div class="row mb-7">
				<label class="col-lg-2 fw-bold text-muted">Fecha de nacimiento</label>
                <div class="col-lg-4 fv-row fv-plugins-icon-container">
					<div class="position-relative d-flex align-items-center">
						<div class="symbol symbol-20px me-4 position-absolute ms-4">
							<span class="symbol-label bg-secondary">
								<span class="svg-icon">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<rect x="0" y="0" width="24" height="24" />
											<rect fill="#000000" opacity="0.3" x="4" y="4" width="4" height="4" rx="1" />
											<path d="M5,10 L7,10 C7.55228475,10 8,10.4477153 8,11 L8,13 C8,13.5522847 7.55228475,14 7,14 L5,14 C4.44771525,14 4,13.5522847 4,13 L4,11 C4,10.4477153 4.44771525,10 5,10 Z M11,4 L13,4 C13.5522847,4 14,4.44771525 14,5 L14,7 C14,7.55228475 13.5522847,8 13,8 L11,8 C10.4477153,8 10,7.55228475 10,7 L10,5 C10,4.44771525 10.4477153,4 11,4 Z M11,10 L13,10 C13.5522847,10 14,10.4477153 14,11 L14,13 C14,13.5522847 13.5522847,14 13,14 L11,14 C10.4477153,14 10,13.5522847 10,13 L10,11 C10,10.4477153 10.4477153,10 11,10 Z M17,4 L19,4 C19.5522847,4 20,4.44771525 20,5 L20,7 C20,7.55228475 19.5522847,8 19,8 L17,8 C16.4477153,8 16,7.55228475 16,7 L16,5 C16,4.44771525 16.4477153,4 17,4 Z M17,10 L19,10 C19.5522847,10 20,10.4477153 20,11 L20,13 C20,13.5522847 19.5522847,14 19,14 L17,14 C16.4477153,14 16,13.5522847 16,13 L16,11 C16,10.4477153 16.4477153,10 17,10 Z M5,16 L7,16 C7.55228475,16 8,16.4477153 8,17 L8,19 C8,19.5522847 7.55228475,20 7,20 L5,20 C4.44771525,20 4,19.5522847 4,19 L4,17 C4,16.4477153 4.44771525,16 5,16 Z M11,16 L13,16 C13.5522847,16 14,16.4477153 14,17 L14,19 C14,19.5522847 13.5522847,20 13,20 L11,20 C10.4477153,20 10,19.5522847 10,19 L10,17 C10,16.4477153 10.4477153,16 11,16 Z M17,16 L19,16 C19.5522847,16 20,16.4477153 20,17 L20,19 C20,19.5522847 19.5522847,20 19,20 L17,20 C16.4477153,20 16,19.5522847 16,19 L16,17 C16,16.4477153 16.4477153,16 17,16 Z" fill="#000000" />
										</g>
									</svg>
								</span>
							</span>
						</div>
						{!! Form::text('birthday', auth()->user()->userDetail->birthday ?? null, 
							['readonly', 
							 'id' => 'birthday', 
							 'class' => 'birthday form-control ps-12', 
							 'placeholder' => 'yyyy-mm-dd'])
						!!}
					</div>
                </div>
				<label class="col-lg-2 fw-bold text-muted ps-10">Documento</label>
				<div class="col-lg-4 fv-row fv-plugins-icon-container">
					{!! Form::tel('document', auth()->user()->userDetail->document ?? null,
                        ['required',
						 'id' => 'document',
                         'class' => 'form-control mb-3 mb-lg-0',
                         'placeholder' => 'Documento'])
                    !!}
                </div>
            </div>
			<div class="row mb-7">
				<label class="col-lg-2 fw-bold text-muted">G&eacute;nero</label>
				<div class="col-lg-4 fv-row fv-plugins-icon-container">
					<select class="form-select form-select-solid genders"
						name="gender_id"
						id="gender_id"
						required>
						<option value="" selected="selected">Seleccione</option>
						@foreach ($gendersActives as $key => $gender)
							<option value="{{ $key }}"
							{{ isset(auth()->user()->userDetail)? (($key ===  auth()->user()->userDetail->gender_id) ? 'selected' : '') : '' }}>{{ $gender }}</option>
						@endforeach
					</select>
                </div>
				<label class="col-lg-2 fw-bold text-muted ps-10">Pa&iacute;s de residencia</label>
                <div class="col-lg-4 fv-row fv-plugins-icon-container">
					<select class="form-select form-select-solid countries"
						name="country_id"
						id="country_id"
						required>
						<option value="" selected="selected">Seleccione</option>
						@foreach ($countries as $key => $country)
							<option value="{{ $key }}"
							{{ isset(auth()->user()->userDetail->address->city->province->country) ? 
							   (($key === auth()->user()->userDetail->address->city->province->country->id) ? 'selected' : '') : '' }}>{{ $country }}</option>
						@endforeach
					</select>
                </div>
            </div>
			<div class="row mb-7">
				<label class="col-lg-2 fw-bold text-muted">Estado</label>
                <div class="col-lg-4 fv-row fv-plugins-icon-container">
					<select class="form-select form-select-solid provinces"
						name="province_id"
						id="province_id"
						data-control="select2"
						required> 
						<option value="">Seleccione</option>
						@isset(auth()->user()->userDetail->address->city->province->id)
							<option value="{{ auth()->user()->userDetail->address->city->province->id }}" selected>{{ auth()->user()->userDetail->address->city->province->name }}</option>
						@endisset
					</select>
                </div>
				<label class="col-lg-2 fw-bold text-muted ps-10">Ciudad</label>
				<div class="col-lg-4 fv-row fv-plugins-icon-container">
					<select class="form-select form-select-solid cities"
						name="city_id"
						id="city_id"
						data-control="select2"
						required> 
						<option value="">Seleccione</option>
						@isset(auth()->user()->userDetail->address->city->id)
							<option value="{{ auth()->user()->userDetail->address->city->id }}" selected>{{ auth()->user()->userDetail->address->city->name }}</option>
						@endisset
					</select>
                </div>
            </div> 
			<div class="row mb-7">
				<label class="col-lg-2 fw-bold text-muted">C&oacute;digo postal</label>
                <div class="col-lg-4 fv-row fv-plugins-icon-container">
                    {!! Form::text('postal_code', auth()->user()->userDetail->address->postal_code ?? null,
                        ['id' => 'postal_code',
                         'class' => 'form-control mb-3 mb-lg-0',
                         'placeholder' => 'C&oacute;digo postal'])
                    !!}
					<span id="invalid-postal-code" class="invalid-feedback d-block email-login"></span>
                </div>
				<label class="col-lg-2 fw-bold text-muted ps-10">Teléfono de contacto</label>
                <div class="col-lg-4 fv-row fv-plugins-icon-container">
					<div class="input-group">
						<span class="input-group-text pe-3" id="phonecode" style="background-color: #f5f8fa;border-color: #d9d9d9;color: #5e6278;transition: color .2s ease,background-color .2s ease;"></span>
						{!! Form::text('phone', auth()->user()->userDetail->phone ?? null,
							['required',
							'id' => 'phone',
							'class' => 'form-control mb-3 mb-lg-0',
							'aria-describedby' => 'phonecode',
							'readonly' => 'readonly',
							'placeholder' => 'Tel&eacute;fono'])
						!!}
					</div>
                </div>
            </div>
			<div class="row mb-7">
				<label class="col-lg-2 fw-bold text-muted">Dirección</label>
				<div class="col-lg-10 fv-row fv-plugins-icon-container">
					<div class="rows">
						<div id="map" style="width: 100%; height: 300px;"></div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
				<div class="col-lg-2 fw-bold text-muted"></div>
                <div class="col-lg-10 fv-row fv-plugins-icon-container">
					{!!
						Form::text('details-address', auth()->user()->userDetail->address->address ?? null,
						['id' => 'details-address',
						 'class' => 'form-control mb-3 mb-lg-0',
						'placeholder' => 'Dirección detallada'
						])
					!!}
                </div>
            </div>
		</div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="submit" class="btn btn-primary" id="form_submit">
                <span class="indicator-label">Actualizar</span>
				<span class="indicator-progress">
					<span class="spinner-border spinner-border-md align-middle"></span>
                </span>
            </button>
        </div>
		{!! Form::close() !!}
	</div>
</div>
@extends('layouts.master', [
    'title' => 'Aliados',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('allies.index') => 'Aliados',
        'Editar'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15">
        {!! Form::open(['route' => ['allies.update', $ally], 'method' => 'PUT', 'files' => true, 'id' => 'ally-form']) !!}
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bolder">Editar</div>
            </div>
            <div class="card-body border-top px-10 py-7">
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">País</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::select('country_id', $countries, old('country_id', $ally->country_id), [
                            'required',
                            'id' => 'country_id',
                            'class' => 'form-control mb-3 mb-lg-0',
                        ]) !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre completo</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('fullname', old('fullname', $ally->fullname),
                            ['required',
                            'id' => 'fullname',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Nombre completo del aliado'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::email('email', old('email', $ally->email),
                            ['required',
                            'id' => 'email',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Email del aliado'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Teléfono</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        <div class="input-group">
                            <span class="input-group-text pe-3" id="phonecode" style="background-color: #f5f8fa;border-color: #d9d9d9;color: #5e6278;transition: color .2s ease,background-color .2s ease;">+</span>
                            {!! Form::text('phone', old('phone', $ally->phone),
                                ['id' => 'phone',
                                'class' => 'form-control mb-3 mb-lg-0',
                                'aria-describedby' => 'phonecode',
                                'readonly' => 'readonly',
                                'placeholder' => 'Número de teléfono'])
                            !!}
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Documento</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('document', old('document', $ally->document),
                            ['id' => 'document',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Número de documento'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Año</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::number('year', old('year', $ally->year),
                            ['required',
                            'id' => 'year',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Año',
                            'min' => '1900',
                            'max' => date('Y')])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Empresa</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('company', old('company', $ally->company),
                            ['required',
                            'id' => 'company',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Nombre de la empresa'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">URL</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('url', old('url', $ally->url),
                            ['id' => 'url',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'https://ejemplo.com'])
                        !!}
                    </div>
                </div>

                <!-- Avatar actual -->
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Avatar actual</label>
                    <div class="col-lg-8">
                        @if($ally->avatar)
                            <div class="symbol symbol-100px symbol-circle mb-3">
                                <img src="{{ asset('storage/' . $ally->avatar) }}" alt="Avatar" class="symbol-label">
                            </div>
                        @else
                            <div class="symbol symbol-100px symbol-circle mb-3">
                                <div class="symbol-label bg-light-primary text-primary fw-bolder fs-2">
                                    {{ substr($ally->fullname, 0, 1) }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Nuevo avatar</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::file('avatar', 
                            ['id' => 'avatar',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'accept' => 'image/*'])
                        !!}
                    </div>
                </div>

                <!-- Logo actual -->
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Logo actual</label>
                    <div class="col-lg-8">
                        @if($ally->logo)
                            <div class="symbol symbol-100px symbol-square mb-3">
                                <img src="{{ asset('storage/' . $ally->logo) }}" alt="Logo" class="symbol-label">
                            </div>
                        @else
                            <div class="symbol symbol-100px symbol-square mb-3">
                                <div class="symbol-label bg-light-success text-success fw-bolder fs-6">
                                    Sin Logo
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label fw-bold fs-6">Nuevo logo</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::file('logo', 
                            ['id' => 'logo',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'accept' => 'image/*'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('allies.index') }}" class="d-flex align-center justify-content-center btn btn-light me-2">Regresar</a>
                <button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Actualizar</span>
                    <span class="indicator-progress">
                        <span class="spinner-border spinner-border-md align-middle ms-2"></span>
                    </span>
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        let countriesDetails = @json($countriesDetails);
        let countriesPhoneCodes = @json($countriesPhoneCodes);
        
        $('#country_id').select2();
        $('#country_id').on('change', function() {
            var country_id = this.value;
            $("#phone").val("");
            $("#phonecode").html("+");
            $("#phone").prop("readonly", true);

            if(country_id != '') {
                drawPhone(country_id);
            }
        });

        // Si estamos en edit, cargar el formato del país actual
        @if(isset($ally) && $ally->country_id)
            drawPhone({{ $ally->country_id }});
            
            // Si hay teléfono guardado, extraer solo el número (sin código)
            @if($ally->phone)
                var country = countriesDetails.find(function(element) {
                    return element.id == {{ $ally->country_id }};
                });
                if(country) {
                    var phonePrefix = '+' + country.phonecode;
                    $("#phone").val("{{ $ally->phone }}".replace(phonePrefix, ''));
                }
            @endif
        @endif

        function drawPhone(country_id) {
            var element = false;

            if (countriesDetails.length > 0){
                element = countriesDetails.find(function(element) {
                    return element.id == country_id;
                });

                if (element){
                    $("#phone").prop("minLength", 0);
                    $("#phone").prop("maxLength", 0);
                    $("#phone").prop("maxLength", element.phone_digits);
                    $("#phone").prop("minLength", element.phone_digits);
                    var phonePrefix = '+' + element.phonecode;
                    $("#phonecode").html(phonePrefix);
                    $("#phone").prop("readonly", false);

                    var mask = ""

                    for(var i = 0; i < element.phone_digits; i++)
                        mask = mask + '9'

                    if(typeof Inputmask !== 'undefined') {
                        Inputmask({
                            "mask" : mask
                        }).mask("#phone");   
                    }
                }
            }
        }
    });
</script>
@endsection
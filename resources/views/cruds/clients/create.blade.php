@extends('layouts.master', [
    'title' => 'Clientes',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('clients.index') => 'Clientes',
        route('clients.create') => 'Agregar nuevo'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15">
        {!! Form::open(['route' => ['clients.store'], 'method' => 'POST', 'files' => true, 'id' => 'client-form']) !!}
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Agregar nuevo</div>
            </div>
            <div class="card-body px-10 py-7">  
                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Nombre completo</label>
                        {!! Form::text('fullname', old('fullname'),
                            ['required',
                            'id' => 'fullname',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Nombre completo del cliente'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Email</label>
                        {!! Form::email('email', old('email'),
                            ['required',
                            'id' => 'email',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Email del cliente'])
                        !!}
                    </div>                    
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">País</label>
                        <select class="form-select form-select-solid countries"
                            name="country_id"
                            id="country_id"
                            required>
                            <option value="" selected="selected">Seleccione</option>
                            @foreach ($countries as $key => $country)
                                <option value="{{ $key }}">{{ $country }}</option>
                            @endforeach
					    </select>
                    </div>
                     <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text pe-3" id="phonecode" style="background-color: #f5f8fa;border-color: #d9d9d9;color: #5e6278;transition: color .2s ease,background-color .2s ease;"></span>
                            {!! Form::text('phone', old('phone'),
                                ['id' => 'phone',
                                'class' => 'form-control mb-3 mb-lg-0',
                                'aria-describedby' => 'phonecode',
                                'readonly' => 'readonly',
                                'placeholder' => 'Número de teléfono'])
                            !!}
                        </div>
                    </div>
                </div>
                
                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Empresa</label>
                        {!! Form::text('company', old('company'),
                            ['required',
                            'id' => 'company',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Nombre de la empresa'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">URL</label>
                        {!! Form::text('url', old('url'),
                            ['id' => 'url',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'https://ejemplo.com'])
                        !!}
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">Documento</label>
                        {!! Form::text('document', old('document'),
                            ['id' => 'document',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Número de documento'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Año</label>
                        {!! Form::number('year', old('year'),
                            ['required',
                            'id' => 'year',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Año',
                            'min' => '1900',
                            'max' => date('Y')])
                        !!}
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">Avatar</label>
                        {!! Form::file('avatar', 
                            ['id' => 'avatar',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'accept' => 'image/*'])
                        !!}
                        <div class="text-muted fs-7 mt-1">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">Logo de empresa</label>
                        {!! Form::file('logo', 
                            ['id' => 'logo',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'accept' => 'image/*'])
                        !!}
                        <div class="text-muted fs-7 mt-1">Formatos: JPG, PNG, GIF. Tamaño máximo: 2MB</div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <button type="reset" class="btn btn-light me-3 form-modal-dismiss w-300px dismiss-create">Descartar</button>
                <button type="submit" id="kt_modal_create_client_submit" class="btn btn-primary w-300px">
                    <span class="indicator-label">Registrar cliente</span>
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
        
        $('.countries').select2();
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
        @if(isset($client) && $client->country_id)
            drawPhone({{ $client->country_id }});
            
            // Si hay teléfono guardado, extraer solo el número (sin código)
            @if($client->phone)
                var country = countriesDetails.find(function(element) {
                    return element.id == {{ $client->country_id }};
                });
                if(country) {
                    var phonePrefix = '+' + country.phonecode;
                    $("#phone").val("{{ $client->phone }}".replace(phonePrefix, ''));
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
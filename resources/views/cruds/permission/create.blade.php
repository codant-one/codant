@extends('layouts.master', [
    'title' => 'Permisos',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('permissions.index') => 'Permisos',
        route('permissions.create') => 'Agregar Nuevo'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        {!! Form::open(['route' => ['permissions.store'], 'method' => 'POST', 'files' => true]) !!} 
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Agregar Nuevo</div>
            </div>
            <div class="card-body px-10 py-7">
                <div class="fv-row mb-7">
                    <label class="required fw-bold fs-6 mb-2">Descripción</label>
                    <input type="text" class="form-control permission-description" autocomplete="off" name="description" placeholder="Ejemplo: Validar usuario" required/>
                    <small class="fw-bolder required">Colocar la entidad correspondiente a la acción (Por ejemplo: usuarios)</small>
                    <p class="text-danger d-none"></p>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <button type="reset" class="btn btn-light me-3 form-modal-dismiss w-300px dismiss-create">Descartar</button>
                <button type="submit" id="kt_modal_create_api_key_submit" class="btn btn-primary w-300px">
                    <span class="indicator-label">Registrar</span>
                    <span class="indicator-progress">Cargando...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('scripts')
<script>
</script>

@endsection
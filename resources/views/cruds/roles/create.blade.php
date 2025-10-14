@extends('layouts.master', [
    'title' => 'Roles',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('roles.index') => 'Roles',
        route('roles.create') => 'Agregar nuevo',
    ]
])

@section('content')

<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        {!! Form::open(['route' => ['roles.store'], 'method' => 'POST']) !!}
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Agregar Nuevo</div>
			</div>
            <div class="card-body d-flex flex-center flex-column pt-12 p-9 px-0">
                <div class="d-flex flex-column w-80">
                    <div class="form-group row px-0 py-5">
                        <label class="col-6 col-form-label required">Nombre</label>
                        <div class="col-6">
                            <input class="form-control" type="text" id="name" name="name" placeholder="Nombre del ROL" autocomplete="off" required>
                        </div>
                        <p class="text-danger">{{ $errors->first('name') }}</p>
                    </div>
                    <div class="accordion accordion-flush" id="accordionPermissionRol">
                        <div class="accordion-item">
                            <h2 class="accordion-header" class="headingUser">
                                <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#itemUser" aria-expanded="false" aria-controls="itemUser">
                                    <span>Ver permisos</span>
                                </button>
                            </h2>
                            <div id="itemUser" class="accordion-collapse collapse" aria-labelledby="headingUser" data-bs-parent="#accordionPermissionRol">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-5">
                                            <div class="form-group">
                                                    <label class="checkbox">
                                                    <input type="checkbox" class="form-check-input h-20px w-20px" id="check-all">
                                                    <span></span>Seleccionar todos</label>
                                            </div>
                                        </div>
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-group">
                                                    <label class="checkbox">
                                                    <input type="checkbox" class="form-check-input h-20px w-20px checkbox-permission" id="permissions[]" name="permissions[]" value="{{ $permission->id }}">
                                                    <span></span>{{ $permission->description }}</label>
                                                </div>
                                            </div> 
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-danger px-5 py-0 mb-0">{{ $errors->first('permissions') }}</p>
                </div>
            </div>
            <div class="card-footer py-3 px-md-20">
                <div class="row text-center py-3 px-md-20">
                    <div class="col-12 col-md-6">
                        <button type="reset" class="d-flex align-center justify-content-center btn btn-light me-3 w-100 form-modal-dismiss dismiss-create">Descartar</button>
                    </div>
                    <div class="col-12 col-md-6">
                        <button type="submit" class="btn btn-primary w-100">
                            <span class="indicator-label">Registrar</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function(){

        $('#check-all').on('change', function(){

            if( $(this).is(':checked') ){

                $('.checkbox-permission').prop('checked', true);

            } else {

                $('.checkbox-permission').prop('checked', false);

            }
        });
    });

</script>
    
@endsection
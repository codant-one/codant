@extends('layouts.master', [
    'title' => 'Permisos',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('permissions.index') => 'Permisos',
        route('permissions.create') => 'Editar',
    ]
])

@section('content')

<div class="container-fluid">
    <div class="mx-5 mx-xl-15 my-7">
        {!!  Form::open(['route' => ['permissions.update', ['permission' => $permission->id]], 'method' => 'PUT']) !!}     
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Editar</div>
			</div>
            <div class="card-body border-top px-10 py-7">
                <div class="form-group row px-6 py-5">
                    <label class="col-2 col-form-label required fw-bold fs-6">Descripción</label>
                    <div class="col-10">
                        <input class="form-control" type="text" name="description" value="{{ $permission->description }}" placeholder="Descripción" autocomplete="off">
                    </div>
                    <p class="text-danger">{{ $errors->first('name') }}</p>
                </div>
			</div>
			<div class="card-footer d-flex justify-content-end py-6 px-9">
                <a class="btn btn-light me-2 d-flex align-center justify-content-center" href="{{ route('permissions.index') }}">Regresar</a>
				<button type="submit" class="btn btn-primary">
                    <span class="indicator-label">Actualizar</span>
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
@extends('layouts.master', [
'title' => 'Usuarios',
'breadcrumbs' => [
route('admin.dashboard.index') => 'Inicio',
route('users.index') => 'Usuarios',
route('users.create') => 'Editar',
]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15">
        {!!  Form::open(['route' => ['users.update', ['user' => $user->id]], 'method' => 'PUT']) !!}
        <div class="card">
            <div class="card-header">
				<div class="card-title fs-3 fw-bolder">Editar</div>
			</div>
            <div class="card-body border-top px-10 py-7">
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Primer nombre</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('firstname', old('firstname', $user->firstname),
                            ['required',
                            'id' => 'firstname',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Primer nombre'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Segundo nombre</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('secondname', old('secondname', $user->secondname),
                            ['id' => 'secondname',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Segundo nombre'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Primer apellido</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('lastname', old('lastname', $user->lastname),
                            ['required',
                            'id' => 'lastname',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Primer apellido'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Segundo apellido</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('secondsurname', old('secondsurname', $user->secondsurname),
                            ['id' => 'secondsurname',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Segundo apellido'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Email</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::email('email', old('email', $user->email),
                            ['required',
                            'id' => 'email',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'readonly' => 'readonly',
                            'placeholder' => 'Email'])
                        !!}
                    </div>
                </div> 
                <div class="row">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Rol</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        @foreach ($roles as $role )
                            @if($role['name'] !== 'SuperAdmin')
                            <div class="d-flex fv-row">
                                <div class="form-check form-check-custom mb-1">
                                    {{ Form::radio('role', $role['id'], $role['name'] == $user->getRoleNames()[0] ? true : false,
                                        ['class'=>'form-check-input me-3'])
                                    }}
                                    <label class="form-check-label">
                                        <div class="fw-bolder text-gray-800">{{ $role['name']}}</div>
                                    </label>
                                </div>
                            </div>
                            <!-- <div class='separator separator-dashed my-2'></div> -->
                            @endif
                        @endforeach
                    </div>
                </div>
			</div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('users.index') }}" class="d-flex align-center justify-content-center btn btn-light me-2">Regresar</a>
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
@endsection
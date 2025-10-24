@extends('layouts.master', [
    'title' => 'Skills',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('skills.index') => 'Skills',
        'Editar Skill'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15">
        {!! Form::open(['route' => ['skills.update', $skill->id], 'method' => 'PUT']) !!}
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bolder">Editar Skill</div>
            </div>
            <div class="card-body border-top px-10 py-7">
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre (Español)</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('name_es', old('name_es', $skill->name_es),
                            ['required',
                            'id' => 'name_es',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en español'])
                        !!}
                    </div>
                </div>
                <div class="row mb-4">
                    <label class="col-lg-4 col-form-label required fw-bold fs-6">Nombre (Inglés)</label>
                    <div class="col-lg-8 fv-row fv-plugins-icon-container">
                        {!! Form::text('name_en', old('name_en', $skill->name_en),
                            ['required',
                            'id' => 'name_en',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Nombre en inglés'])
                        !!}
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ route('skills.index') }}" class="d-flex align-center justify-content-center btn btn-light me-2">Regresar</a>
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
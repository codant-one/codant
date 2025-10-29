@extends('layouts.master', [
    'title' => 'Blogs',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('blogs.index') => 'Blogs',
        'Crear'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15">
        {!! Form::open(['route' => ['blogs.store'], 'method' => 'POST', 'files' => true, 'id' => 'blog-form']) !!}
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bolder">Crear Blog</div>
            </div>
            <div class="card-body px-10 py-7">
                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Categoría</label>
                        <select class="form-select form-select-solid"
                            name="category_id"
                            id="category_id"
                            required>
                            <option value="" selected="selected">Seleccione</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name_es }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Usuario</label>
                        <select class="form-select form-select-solid"
                            name="user_id"
                            id="user_id"
                            required>
                            <option value="" selected="selected">Seleccione</option>
                            @foreach ($users as $user)
                                @php
                                    $fullName = trim($user->firstname . ' ' . 
                                                ($user->secondname ? $user->secondname . ' ' : '') . 
                                                $user->lastname . ' ' . 
                                                ($user->secondsurname ? $user->secondsurname : ''));
                                @endphp
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $fullName }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Título (Español)</label>
                        {!! Form::text('title_es', old('title_es'),
                            ['required',
                            'id' => 'title_es',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Título en español'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Título (Inglés)</label>
                        {!! Form::text('title_en', old('title_en'),
                            ['required',
                            'id' => 'title_en',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Título en inglés'])
                        !!}
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Descripción (Español)</label>
                        {!! Form::textarea('description_es', old('description_es'),
                            ['required',
                            'id' => 'description_es',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'rows' => 4,
                            'placeholder' => 'Descripción en español'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Descripción (Inglés)</label>
                        {!! Form::textarea('description_en', old('description_en'),
                            ['required',
                            'id' => 'description_en',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'rows' => 4,
                            'placeholder' => 'Descripción en inglés'])
                        !!}
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Año</label>
                        {!! Form::number('year', old('year', date('Y')),
                            ['required',
                            'id' => 'year',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'min' => '2000',
                            'max' => date('Y') + 1,
                            'placeholder' => 'Año de publicación'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Slug</label>
                        {!! Form::text('slug', old('slug'),
                            ['required',
                            'id' => 'slug',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'slug-del-blog'])
                        !!}
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">Blog Popular</label>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="is_popular_blog" value="1" id="is_popular_blog" 
                                {{ old('is_popular_blog') == '1' ? 'checked' : '' }}/>
                            <label class="form-check-label" for="is_popular_blog">
                                Marcar como blog popular
                            </label>
                        </div>
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="fw-bold fs-6 mb-2">Imagen</label>
                        {!! Form::file('image', 
                            ['id' => 'image',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'accept' => 'image/*'])
                        !!}
                        <div class="text-muted fs-7 mt-1">Formatos: JPEG, PNG, JPG, GIF. Máx: 2MB</div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <button type="reset" class="btn btn-light me-3 form-modal-dismiss w-300px dismiss-create">Descartar</button>
                <button type="submit" id="kt_modal_create_blog_submit" class="btn btn-primary w-300px">
                    <span class="indicator-label">Registrar blog</span>
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
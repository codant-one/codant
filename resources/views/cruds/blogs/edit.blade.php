@extends('layouts.master', [
    'title' => 'Blogs',
    'breadcrumbs' => [
        route('admin.dashboard.index') => 'Inicio',
        route('blogs.index') => 'Blogs',
        'Editar'
    ]
])

@section('content')
<div class="container-fluid">
    <div class="mx-5 mx-xl-15">
        {!! Form::open(['route' => ['blogs.update', $blog->id], 'method' => 'PUT', 'files' => true, 'id' => 'blog-form']) !!}
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bolder">Editar Blog</div>
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
                                <option value="{{ $category->id }}" {{ old('category_id', $blog->category_id) == $category->id ? 'selected' : '' }}>
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
                                <option value="{{ $user->id }}" {{ old('user_id', $blog->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $fullName }} - {{ $user->email }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Título (Español)</label>
                        {!! Form::text('title_es', old('title_es', $blog->title_es),
                            ['required',
                            'id' => 'title_es',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'placeholder' => 'Título en español'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Título (Inglés)</label>
                        {!! Form::text('title_en', old('title_en', $blog->title_en),
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
                        {!! Form::textarea('description_es', old('description_es', $blog->description_es),
                            ['required',
                            'id' => 'description_es',
                            'class' => 'form-control mb-3 mb-lg-0',
                            'rows' => 4,
                            'placeholder' => 'Descripción en español'])
                        !!}
                    </div>
                    <div class="fv-row col-md-6">
                        <label class="required fw-bold fs-6 mb-2">Descripción (Inglés)</label>
                        {!! Form::textarea('description_en', old('description_en', $blog->description_en),
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
                        {!! Form::number('year', old('year', $blog->year),
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
                        {!! Form::text('slug', old('slug', $blog->slug),
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
                                {{ old('is_popular_blog', $blog->is_popular_blog) ? 'checked' : '' }}/>
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
                        @if($blog->image)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $blog->image) }}" alt="Imagen actual" class="img-thumbnail" style="max-width: 200px;">
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" name="remove_image" value="1" id="remove_image">
                                    <label class="form-check-label" for="remove_image">
                                        Eliminar imagen actual
                                    </label>
                                </div>
                            </div>
                        @endif
                        <div class="text-muted fs-7 mt-1">Formatos: JPEG, PNG, JPG, GIF. Máx: 2MB</div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-center">
                <a href="{{ route('blogs.index') }}" class="btn btn-light me-3 w-300px">Regresar</a>
                <button type="submit" id="kt_modal_edit_blog_submit" class="btn btn-primary w-300px">
                    <span class="indicator-label">Actualizar blog</span>
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
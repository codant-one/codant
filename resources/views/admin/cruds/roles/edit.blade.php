@extends('admin.layouts.master')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Roles @endslot
    @slot('title') Editar rol @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('roles.update', ['role' => $rol->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <h5 class="card-title mb-0">Editar Rol</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <div>
                                <label for="name" class="form-label">Nombre <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $rol->name) }}"
                                       placeholder="Nombre del ROL" 
                                       autocomplete="off" 
                                       required />
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div>
                                <label class="form-label">Permisos <span class="text-danger">*</span></label>
                                <div class="accordion custom-accordion-border accordion-secondary" id="accordionPermissionRol">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingPermissions">
                                            <button class="accordion-button" type="button" 
                                                    data-bs-toggle="collapse" 
                                                    data-bs-target="#itemPermissions" 
                                                    aria-expanded="true" 
                                                    aria-controls="itemPermissions">
                                                <span>Ver permisos</span>
                                            </button>
                                        </h2>
                                        <div id="itemPermissions" 
                                             class="accordion-collapse collapse show" 
                                             aria-labelledby="headingPermissions" 
                                             data-bs-parent="#accordionPermissionRol">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-12 mb-4">
                                                        <div class="form-check">
                                                            <input type="checkbox" 
                                                                   class="form-check-input" 
                                                                   id="check-all"
                                                                   @if(auth()->user()->getRoleNames()[0] === 'Administrador' && ($rol->name === 'Administrador' || $rol->name === 'SuperAdmin')) disabled @endif>
                                                            <label class="form-check-label" for="check-all">
                                                                Seleccionar todos
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @foreach ($permissions as $permission)
                                                        @php $id_permission = $permission->id; @endphp
                                                        <div class="col-md-3 mb-3">
                                                            <div class="form-check">
                                                                <input type="checkbox" 
                                                                       class="form-check-input checkbox-permission" 
                                                                       id="permission_{{ $permission->id }}" 
                                                                       name="permissions[]" 
                                                                       value="{{ $permission->id }}"
                                                                       @if(in_array($id_permission, $current_permissions)) checked @endif
                                                                       @if(auth()->user()->getRoleNames()[0] === 'Administrador' && ($rol->name === 'Administrador' || $rol->name === 'SuperAdmin')) disabled @endif>
                                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                    {{ $permission->description }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('permissions')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-lg-12 @if(auth()->user()->getRoleNames()[0] === 'Administrador' && ($rol->name === 'Administrador' || $rol->name === 'SuperAdmin')) d-none @endif">
                            <div class="hstack justify-content-end gap-2">
                                <a href="{{ route('roles.index') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line align-bottom"></i> Regresar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ri-save-line align-bottom me-1"></i> Actualizar
                                    <span class="spinner-border spinner-border-sm ms-1 d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                        
                        @if(auth()->user()->getRoleNames()[0] === 'Administrador' && ($rol->name === 'Administrador' || $rol->name === 'SuperAdmin'))
                        <div class="col-lg-12">
                            <div class="alert alert-warning alert-border-left alert-dismissible fade show material-shadow" role="alert">
                                <i class="ri-alert-line me-1 align-middle"></i> 
                                <strong>Warning</strong> - No tienes permisos para editar este rol
                            </div>
                            <div class="hstack justify-content-end">
                                <a href="{{ route('roles.index') }}" class="btn btn-light">
                                    <i class="ri-arrow-left-line align-bottom"></i> Regresar
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('#check-all').on('change', function(){
            if( $(this).is(':checked') ){
                $('.checkbox-permission:not(:disabled)').prop('checked', true);
            } else {
                $('.checkbox-permission:not(:disabled)').prop('checked', false);
            }
        });
    });
</script>
@endsection
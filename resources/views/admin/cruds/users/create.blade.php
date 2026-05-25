<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Crear usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="firstname">Primer nombre <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" class="form-control" placeholder="Primer nombre" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="secondname">Segundo nombre</label>
                            <input type="text" name="secondname" id="secondname" value="{{ old('secondname') }}" class="form-control" placeholder="Segundo nombre" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="lastname">Primer apellido <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" class="form-control" placeholder="Primer apellido" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="secondsurname">Segundo apellido</label>
                            <input type="text" name="secondsurname" id="secondsurname" value="{{ old('secondsurname') }}" class="form-control" placeholder="Segundo apellido" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol <span class="text-danger">*</span></label>
                        @foreach ($roles_ ?? [] as $role)
                            @if($role['name'] !== 'SuperAdmin')
                            <div class="form-check mb-2">
                                <input type="radio" name="role" value="{{ $role['id'] }}" {{ $role['id'] == 2 ? 'checked' : '' }} class="form-check-input" id="role{{ $role['id'] }}" required />
                                <label class="form-check-label" for="role{{ $role['id'] }}">
                                    {{ $role['name'] }}
                                </label>
                            </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-save-line align-bottom me-1"></i> Registrar
                        <span class="spinner-border spinner-border-sm ms-1 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
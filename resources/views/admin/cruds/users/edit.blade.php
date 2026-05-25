<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editModalLabel">Editar usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUserForm" action="{{ route('users.update', ['user' => 'USER_ID_PLACEHOLDER']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="edit_firstname">Primer nombre <span class="text-danger">*</span></label>
                            <input type="text" name="firstname" id="edit_firstname" class="form-control" placeholder="Primer nombre" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="edit_secondname">Segundo nombre</label>
                            <input type="text" name="secondname" id="edit_secondname" class="form-control" placeholder="Segundo nombre" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label" for="edit_lastname">Primer apellido <span class="text-danger">*</span></label>
                            <input type="text" name="lastname" id="edit_lastname" class="form-control" placeholder="Primer apellido" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="edit_secondsurname">Segundo apellido</label>
                            <input type="text" name="secondsurname" id="edit_secondsurname" class="form-control" placeholder="Segundo apellido" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="edit_email">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="edit_email" class="form-control" placeholder="Email" disabled />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rol <span class="text-danger">*</span></label>
                        <div id="edit_roles_container">
                            @foreach ($roles_ ?? [] as $role)
                                @if($role['name'] !== 'SuperAdmin')
                                <div class="form-check mb-2">
                                    <input type="radio" name="role" value="{{ $role['id'] }}" class="form-check-input edit-role-radio" id="edit_role{{ $role['id'] }}" required />
                                    <label class="form-check-label" for="edit_role{{ $role['id'] }}">
                                        {{ $role['name'] }}
                                    </label>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-save-line align-bottom me-1"></i> Actualizar
                        <span class="spinner-border spinner-border-sm ms-1 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
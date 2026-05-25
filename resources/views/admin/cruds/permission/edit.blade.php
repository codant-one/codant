<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="editModalLabel">Editar permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPermissionForm" action="{{ route('permissions.update', ['permission' => 'PERMISSION_ID_PLACEHOLDER']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_permission_id" name="permission_id">
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label" for="edit_description">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="description" 
                                id="edit_description" 
                                class="form-control" 
                                placeholder="Ejemplo: Validar usuario" 
                                required 
                            />
                            <small class="fw-medium required">Colocar la entidad correspondiente a la acción (Por ejemplo: usuarios)</small>
                            <span class="text-danger">*</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line align-bottom me-1"></i> Actualizar
                        <span class="spinner-border spinner-border-sm ms-1 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
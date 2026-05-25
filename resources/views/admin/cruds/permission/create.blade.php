<div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light p-3">
                <h5 class="modal-title" id="exampleModalLabel">Crear permiso</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('permissions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label" for="description">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="description" 
                                id="description" 
                                value="{{ old('description') }}" 
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
                    <button type="submit" class="btn btn-success">
                        <i class="ri-save-line align-bottom me-1"></i> Registrar
                        <span class="spinner-border spinner-border-sm ms-1 d-none" role="status" aria-hidden="true"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
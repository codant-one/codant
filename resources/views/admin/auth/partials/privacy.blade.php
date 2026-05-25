<div class="tab-pane" id="privacy" role="tabpanel">
    <div class="mb-4 pb-2">
        <h5 class="card-title text-decoration-underline mb-3">Seguridad:</h5>
        <div class="d-flex flex-column flex-sm-row mb-4 mb-sm-0">
            <div class="flex-grow-1">
                <h6 class="fs-14 mb-1">Autenticación de dos factores</h6>
                <p class="text-muted">
                    La autenticación de dos factores es una medida
                    de seguridad mejorada. Una vez habilitada, se te pedirá que proporciones
                    dos tipos de identificación cuando inicies sesión. Google
                    Authentication y SMS son compatibles.
                </p>
            </div>
            <div class="flex-shrink-0 ms-sm-3">
                <a href="javascript:void(0);" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal_update_2fa">
                    {{auth()->user()->is_2fa === 0 ? 'Habilitar' : 'Deshabilitar'}} autenticación de dos factores
                </a>
            </div>
        </div>
    </div>
    <div>
        <h5 class="card-title text-decoration-underline mb-3">
            Eliminar esta cuenta:
        </h5>
        <p class="text-muted">
            Ve a la sección de Datos y Privacidad de tu perfil
            de cuenta. Desplázate hasta "Tus opciones de datos y privacidad". Elimina tu
            cuenta de perfil. Sigue las instrucciones para eliminar tu cuenta:
        </p>
        <form action="{{ route('deleteAccount') }}" method="POST" id="deleteAccountForm">
            @csrf
            <div>
                <input 
                    type="password" 
                    name="password"
                    class="form-control" id="passwordInput"
                    placeholder="Ingresa tu contraseña" 
                    required
                    style="max-width: 265px;"
                >
            </div>
            <div class="hstack gap-2 mt-3">
                <button type="button" class="btn btn-soft-danger" id="deleteAccountBtn">
                    Cerrar y eliminar esta cuenta
                </button>
            </div>
        </form>
    </div>
</div>


 <div class="modal fade" id="modal_update_2fa" tabindex="-1" aria-labelledby="modal_update_2fa_label" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_update_2fa_label">Factor doble autenticación (2FA)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('auth.2fa.validate') }}" method="POST" id="form_update_2fa">
                @csrf
                <div class="modal-body">
                    <h6 class="text-center mb-3">Authenticator apps</h6>
                    <p class="text-muted">
                        Utilizando una aplicación de autenticación como <strong>Google Authenticator, Microsoft Authenticator, Authy, etc.</strong>, 
                        escanee el código QR. Generará un código de 6 dígitos para que lo ingrese a continuación.
                    </p>
                    <div class="text-center mb-3">
                        <div id="qr-code-container"></div>
                    </div>

                    <div class="alert alert-danger mb-3">
                        <h6 id="secret-token" class="mb-2"></h6>
                        <small>Si no puede escanear el código QR, puede ingresar manualmente la clave secreta.</small>
                    </div>

                    <h6 class="mb-2">Escriba su código de seguridad de 6 dígitos</h6>
                    <div id="error-message-2fa" class="invalid-feedback d-block mb-2" style="display: none;">
                        Por favor, complete el campo de código.
                    </div>
                    <div class="mb-3">
                        <input type="tel" 
                            class="form-control" 
                            maxlength="7"
                            id="token_2fa_input" 
                            name="token_2fa"
                            placeholder="___-___"
                            required />
                        <input type="hidden" name="route" value="profile">
                        <input type="hidden" name="panel" value="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Descartar</button>
                    <button type="submit" id="btn_submit_2fa" class="btn btn-primary">
                        <span class="indicator-label">{{auth()->user()->is_2fa === 0 ? 'Habilitar' : 'Deshabilitar'}}</span>
                        <span class="indicator-progress d-none">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Verificador de sesión activa - se ejecuta cada 30 segundos
    (function() {
        let checkSessionInterval = null;
        
        function startSessionCheck() {
            // Solo ejecutar si el usuario está autenticado
            @auth
                checkSessionInterval = setInterval(function() {
                    $.ajax({
                        url: '{{ route("profile") }}',
                        method: 'GET',
                        silent: true, // No mostrar errores automáticamente
                        statusCode: {
                            401: function() {
                                // Sesión inválida o cerrada
                                clearInterval(checkSessionInterval);
                                
                                Swal.fire({
                                    html: `
                                        <div class="mt-3">
                                            <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                            <div class="fs-15">
                                                <h4>Sesión cerrada</h4>
                                                <p class="text-muted mx-4 mb-0">
                                                    Tu sesión ha sido cerrada desde otro dispositivo. Por favor, inicia sesión nuevamente.
                                                </p>
                                            </div>
                                        </div>
                                    `,
                                    showCancelButton: false,
                                    customClass: {
                                        confirmButton: 'btn btn-primary w-xs me-2 mb-1',
                                        cancelButton: 'btn btn-danger w-xs mb-1',
                                    },
                                    confirmButtonText: 'Ir al login',
                                    buttonsStyling: false,
                                    showCloseButton: true
                                }).then((result) => {
                                    window.location.href = '{{env('APP_URL')}}/admin';
                                });
                            }
                        },
                        error: function(xhr) {
                            // Si es un error 401, ya se manejó en statusCode
                            if (xhr.status === 401) {
                                return;
                            }
                            // Otros errores se ignoran en la verificación silenciosa
                        }
                    });
                }, 30000); // Verificar cada 30 segundos
            @endauth
        }
        
        // Iniciar verificación al cargar la página
        $(document).ready(function() {
            startSessionCheck();
        });
        
        // Detener verificación al cerrar/recargar página
        $(window).on('beforeunload', function() {
            if (checkSessionInterval) {
                clearInterval(checkSessionInterval);
            }
        });
    })();
</script>

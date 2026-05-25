<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('modal_update_2fa');
        
        if (!modalElement) return;

        const input = document.getElementById('token_2fa_input');
        const formSubmit = document.getElementById('form_update_2fa');
        const errorMessage = document.getElementById('error-message-2fa');
        const submitBtn = document.getElementById('btn_submit_2fa');
        const qrContainer = document.getElementById('qr-code-container');
        const secretToken = document.getElementById('secret-token');
        const modalInstance = new bootstrap.Modal(modalElement);
        
        // Cargar datos del QR y token cuando se abre el modal
        modalElement.addEventListener('show.bs.modal', function () {
            // Hacer petición AJAX para obtener el QR y token
            fetch('{{ route("auth.2fa.generate") }}', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.qr && data.token) {
                    qrContainer.innerHTML = data.qr;
                    secretToken.textContent = data.token;
                }
            })
            .catch(error => {
                console.error('Error al cargar 2FA:', error);
            });
        });

        // Limpiar el modal cuando se cierra completamente
        modalElement.addEventListener('hidden.bs.modal', function () {
            input.value = '';
            input.placeholder = '___-___';
            errorMessage.style.display = 'none';
            input.classList.remove('is-invalid');
            qrContainer.innerHTML = '';
            secretToken.textContent = '';
            
            // Resetear el botón de submit
            const indicatorLabel = submitBtn.querySelector('.indicator-label');
            const indicatorProgress = submitBtn.querySelector('.indicator-progress');
            
            if (indicatorLabel) indicatorLabel.classList.remove('d-none');
            if (indicatorProgress) indicatorProgress.classList.add('d-none');
            submitBtn.disabled = false;
        });

        // Manejar el cierre del modal correctamente
        modalElement.addEventListener('hide.bs.modal', function (event) {
            // Remover el foco del elemento activo antes de cerrar
            if (document.activeElement && document.activeElement.blur) {
                document.activeElement.blur();
            }
        });

        input.addEventListener('focus', function() {
            // Aplicar máscara cuando el input está enfocado
            if (typeof Inputmask !== 'undefined') {
                Inputmask({
                    "mask": "999-999",
                    "placeholder": "___-___",
                    "showMaskOnHover": false,
                    "showMaskOnFocus": true
                }).mask(input);
            }
        });

        input.addEventListener('blur', function() {
            // Mostrar placeholder manual cuando está vacío
            if (input.value === '') {
                input.placeholder = '___-___';
            }
        });

        // Ocultar error al escribir (usando keyup para mejor compatibilidad con Inputmask)
        input.addEventListener('keyup', function() {
            if (!errorMessage.classList.contains('d-none')) {
                errorMessage.style.display = 'none';
                errorMessage.classList.add('d-none');
                errorMessage.classList.remove('d-block');
                input.classList.remove('is-invalid');
            }
        });

        input.addEventListener('input', function() {
            if (!errorMessage.classList.contains('d-none')) {
                errorMessage.style.display = 'none';
                errorMessage.classList.add('d-none');
                errorMessage.classList.remove('d-block');
                input.classList.remove('is-invalid');
            }
        });

        // Iniciar con placeholder manual
        input.placeholder = '___-___';

        // Validación al hacer submit
        formSubmit.addEventListener('submit', function(event) {
            event.preventDefault();

            // Prevenir el envío si el campo no está completo
            if (input.value.includes('_') || input.value === '' || input.value.length < 7) {
                errorMessage.style.display = 'block';
                errorMessage.classList.remove('d-none');
                errorMessage.classList.add('d-block');
                input.classList.add('is-invalid');
                return false;
            }

            // Mostrar loading
            const indicatorLabel = submitBtn.querySelector('.indicator-label');
            const indicatorProgress = submitBtn.querySelector('.indicator-progress');
            
            if (indicatorLabel) indicatorLabel.classList.add('d-none');
            if (indicatorProgress) indicatorProgress.classList.remove('d-none');
            submitBtn.disabled = true;

            errorMessage.style.display = 'none';

            // Simular delay y enviar
            setTimeout(function() {
                formSubmit.submit();
            }, 1000);
        });
    });
</script>
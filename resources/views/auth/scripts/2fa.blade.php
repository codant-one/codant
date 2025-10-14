<script>

    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('token_2fa');
        const element = document.getElementById('update_2fa');
        const formSubmit = element.querySelector('#kt_modal_update_2fa_form');
        const modal = new bootstrap.Modal(element);
        const errorMessage = document.getElementById('error-message');
        const errorInput = document.getElementById('error-input');
        const submitBtn = element.querySelector('[data-kt-users-modal-action="submit"]');
        
        input.addEventListener('focus', function() {
            // Cuando el input está enfocado, manten la máscara de inputmask
            Inputmask({
                "mask": "999-999",
                "placeholder": "___-___",  // Placeholder vacío para que no interfiera con el inputmask
                "showMaskOnHover": false,   // No mostrar la máscara al pasar el mouse
                "showMaskOnFocus": true     // Mostrar la máscara solo al enfocar
            }).mask(input);
        });

        input.addEventListener('blur', function() {
            // Cuando el input pierde el foco, si está vacío, muestra el placeholder manual
            if (input.value === '') {
                input.placeholder = '___-___';
            }
        });

        input.addEventListener('input', function() {
            errorMessage.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif
        });

        // Iniciar con placeholder manual
        input.placeholder = '___-___';

        // Validación al hacer clic en el botón de enviar
        submitBtn.addEventListener('click', function(event) {
            @if ($errors->any())
                errorInput.style.display = 'none'; // Ocultar mensaje de error si el input está completo
            @endif

            // Prevenir el envío del formulario si el campo no está completo
            if (input.value.includes('_') || input.value === '') {
                event.preventDefault(); // Detener el envío del formulario
                errorMessage.style.display = 'block'; // Mostrar mensaje de error

            } else {
                submitBtn.setAttribute('data-kt-indicator', 'on');

                // Disable button to avoid multiple click 
                submitBtn.disabled = true;

                errorMessage.style.display = 'none'; // Ocultar mensaje de error
                 // Simulate ajax request
                 setTimeout(function() {
                    // Hide loading indication
                    submitBtn.removeAttribute('data-kt-indicator');

                    // Enable button
                    submitBtn.disabled = false;
                    formSubmit.submit();
                }, 1000);
            }
        });
    });

</script>
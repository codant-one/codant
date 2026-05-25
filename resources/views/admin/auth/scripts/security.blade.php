<script>
    $(document).ready(function () {
        const form = document.getElementById('update_password_form');
        if (!form) return;

        // Password visibility toggle
        document.querySelectorAll('.password-addon').forEach(function(button) {
            button.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('ri-eye-fill');
                    icon.classList.add('ri-eye-off-fill');
                } else {
                    input.type = 'password';
                    icon.classList.remove('ri-eye-off-fill');
                    icon.classList.add('ri-eye-fill');
                }
            });
        });

        // Get form inputs
        const currentPasswordInput = document.getElementById('current_password');
        const newPasswordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        // Custom validation function for new password
        function validateNewPassword(password) {
            const errors = [];
            
            if (password.length < 8) {
                errors.push('La contraseña debe tener al menos 8 caracteres');
            }
            
            if (!/[a-z]/.test(password)) {
                errors.push('Debe contener al menos una letra minúscula');
            }
            
            if (!/[A-Z]/.test(password)) {
                errors.push('Debe contener al menos una letra mayúscula');
            }
            
            if (!/\d/.test(password)) {
                errors.push('Debe contener al menos un número');
            }
            
            if (!/[\W_]/.test(password)) {
                errors.push('Debe contener al menos un símbolo');
            }
            
            return errors;
        }

        // Real-time validation for new password
        if (newPasswordInput) {
            newPasswordInput.addEventListener('input', function() {
                const password = this.value;
                const errors = validateNewPassword(password);
                
                if (errors.length > 0) {
                    this.setCustomValidity(errors.join('. '));
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    
                    const feedbackElement = this.parentElement.querySelector('.invalid-feedback');
                    if (feedbackElement) {
                        feedbackElement.textContent = errors.join('. ');
                    }
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    
                    const feedbackElement = this.parentElement.querySelector('.invalid-feedback');
                    if (feedbackElement) {
                        feedbackElement.textContent = 'La nueva contraseña es requerida (mínimo 8 caracteres)';
                    }
                }
                
                // Re-validate confirm password if it has a value
                if (confirmPasswordInput && confirmPasswordInput.value) {
                    confirmPasswordInput.dispatchEvent(new Event('input'));
                }
            });
        }

        // Real-time validation for confirm password
        if (confirmPasswordInput && newPasswordInput) {
            confirmPasswordInput.addEventListener('input', function() {
                if (newPasswordInput.value !== confirmPasswordInput.value) {
                    this.setCustomValidity('Las contraseñas no coinciden');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                    
                    const feedbackElement = this.parentElement.querySelector('.invalid-feedback');
                    if (feedbackElement) {
                        feedbackElement.textContent = 'Las contraseñas no coinciden';
                    }
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    
                    const feedbackElement = this.parentElement.querySelector('.invalid-feedback');
                    if (feedbackElement) {
                        feedbackElement.textContent = 'La confirmación de contraseña es requerida';
                    }
                }
            });
        }

        // Real-time validation for current password
        if (currentPasswordInput) {
            currentPasswordInput.addEventListener('input', function() {
                if (this.value.trim() === '') {
                    this.setCustomValidity('La contraseña actual es requerida');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
        }

        // Form submission with Bootstrap 5 validation
        const submitButton = document.getElementById('update_password_form_submit');
        if (submitButton) {
            // Handle button click instead of form submit
            submitButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Validate all fields before submission
                let isValid = true;

                // Validate current password
                if (currentPasswordInput && currentPasswordInput.value.trim() === '') {
                    currentPasswordInput.setCustomValidity('La contraseña actual es requerida');
                    isValid = false;
                } else if (currentPasswordInput) {
                    currentPasswordInput.setCustomValidity('');
                }

                // Validate new password
                if (newPasswordInput) {
                    const errors = validateNewPassword(newPasswordInput.value);
                    if (errors.length > 0) {
                        newPasswordInput.setCustomValidity(errors.join('. '));
                        isValid = false;
                    } else {
                        newPasswordInput.setCustomValidity('');
                    }
                }

                // Validate confirm password
                if (confirmPasswordInput && newPasswordInput) {
                    if (newPasswordInput.value !== confirmPasswordInput.value) {
                        confirmPasswordInput.setCustomValidity('Las contraseñas no coinciden');
                        isValid = false;
                    } else {
                        confirmPasswordInput.setCustomValidity('');
                    }
                }

                // Check Bootstrap 5 validation
                if (!form.checkValidity() || !isValid) {
                    form.classList.add('was-validated');
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                        <h4>Algo ha ido mal</h4>
                                        <p class="text-muted mx-4 mb-0">
                                            Por favor, complete todos los campos requeridos correctamente.
                                        </p>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: 'btn btn-primary w-xs mb-1',
                            },
                            cancelButtonText: 'Entendido',
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                    }
                    return false;
                }

                // Show loading
                const indicatorLabel = submitButton.querySelector('.indicator-label');
                const indicatorProgress = submitButton.querySelector('.indicator-progress');
                
                if (indicatorLabel) indicatorLabel.classList.add('d-none');
                if (indicatorProgress) indicatorProgress.classList.remove('d-none');
                submitButton.disabled = true;

                // Remove was-validated class
                form.classList.remove('was-validated');

                // Submit form directly
                form.submit();
            });
        }
    });

    // Session management - Logout single session
    $(document).on('click', '.logout-session', function(e) {
        e.preventDefault();
        
        const url = $(this).data('url');
        const sessionId = $(this).data('session-id');
        const isCurrent = $(this).data('is-current') === true;
        const $element = $(this);

        Swal.fire({
            html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#AA83FF,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>¿Está seguro?</h4>
                        <p class="text-muted mx-4 mb-0">
                            ${isCurrent ? 'Esto cerrará su sesión actual y será redirigido al login.' : 'Esta acción cerrará la sesión en el otro dispositivo.'}
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mb-1',
                cancelButton: 'btn btn-danger w-xs mb-1',
            },
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar',
            buttonsStyling: false,
            showCloseButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $element.html('<i class="ri-loader-4-line"></i> Cerrando...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                                        <div class="fs-15">
                                            <h4>¡Enhorabuena!</h4>
                                            <p class="text-muted mx-4 mb-0">${response.message}</p>
                                        </div>
                                    </div>
                                `,
                                showConfirmButton: false,
                                timer: 2000,
                                buttonsStyling: false,
                                showCloseButton: false
                            }).then(() => {
                                if (response.redirect) {
                                    window.location.href = response.redirect;
                                } else {
                                    location.reload();
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Error al cerrar la sesión';
                        Swal.fire({
                            html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                        <h4>Error</h4>
                                        <p class="text-muted mx-4 mb-0">${message}</p>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: 'btn btn-primary w-xs mb-1',
                            },
                            cancelButtonText: 'Entendido',
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                        $element.html('<i class="ri-logout-circle-line"></i> Cerrar Sesión');
                    }
                });
            }
        });
    });

    // Session management - Logout all sessions
    $(document).on('click', '#logout-all-sessions', function(e) {
        e.preventDefault();
        
        const url = $(this).data('url');
        const $element = $(this);
        
        Swal.fire({
            html: `
                <div class="mt-3">
                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#AA83FF,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                        <h4>¿Cerrar todas las sesiones?</h4>
                        <p class="text-muted mx-4 mb-0">
                            Esto cerrará todas las sesiones activas excepto la actual. Los dispositivos necesitarán iniciar sesión nuevamente.
                        </p>
                    </div>
                </div>
            `,
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mb-1',
                cancelButton: 'btn btn-danger w-xs mb-1',
            },
            confirmButtonText: 'Sí, cerrar todas',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $element.html('<i class="ri-loader-4-line"></i> Cerrando...');
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                html: `
                                    <div class="mt-3">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#151426" style="width:120px;height:120px"></lord-icon>
                                        <div class="fs-15">
                                            <h4>¡Enhorabuena!</h4>
                                            <p class="text-muted mx-4 mb-0">${response.message}</p>
                                        </div>
                                    </div>
                                `,
                                showConfirmButton: false,
                                timer: 2000,
                                buttonsStyling: false,
                                showCloseButton: false
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        const message = xhr.responseJSON?.message || 'Error al cerrar las sesiones';
                        Swal.fire({
                            html: `
                                <div class="mt-3">
                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#AA83FF" style="width:120px;height:120px"></lord-icon>
                                    <div class="fs-15">
                                        <h4>Error</h4>
                                        <p class="text-muted mx-4 mb-0">${message}</p>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            showConfirmButton: false,
                            customClass: {
                                cancelButton: 'btn btn-primary w-xs mb-1',
                            },
                            cancelButtonText: 'Entendido',
                            buttonsStyling: false,
                            showCloseButton: true
                        });
                        $element.html('Cerrar Todas las Sesiones');
                    }
                });
            }
        });
    });
</script>
<script>
    "use strict";

    var KTUsersUpdatePassword = function () {
        const element = document.getElementById('update_password');
        const form = element.querySelector('#kt_modal_update_password_form');
        const modal = new bootstrap.Modal(element);

        var initUpdatePassword = () => {

            var validator = FormValidation.formValidation(
                form,
                {
                    fields: {
                        'current_password': {
                            validators: {
                                notEmpty: {
                                    message: 'La contraseña actual es requerida'
                                }
                            }
                        },
                        'new_password': {
                            validators: {
                                notEmpty: {
                                    message: 'La contraseña es requerida'
                                },
                                stringLength: {
                                    min: 8,
                                    message: 'La contraseña debe tener al menos 8 caracteres'
                                },
                                regexp: {
                                    regexp: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/,
                                    message: "Usa una combinación de mayúsculas, minúsculas, números y símbolos"
                                }
                            }
                        },
                        'confirm_password': {
                            validators: {
                                notEmpty: {
                                    message: 'La confirmacion de contraseña es requerida'
                                },
                                identical: {
                                    compare: function () {
                                        return form.querySelector('[name="new_password"]').value;
                                    },
                                    message: 'La contraseña y su confirmación no son iguales'
                                }
                            }
                        },
                    },

                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                }
            );

            // Submit button handler
            const submitButton = element.querySelector('[data-kt-users-modal-action="submit"]');
            submitButton.addEventListener('click', function (e) {
                e.preventDefault();
                if (validator) {
                    validator.validate().then(function (status) {

                        if (status == 'Valid') {
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            submitButton.disabled = true;

                            setTimeout(function () {
                                submitButton.removeAttribute('data-kt-indicator');
                                submitButton.disabled = false;

                                var myModalEl = document.querySelector('#update_password');
                                var modal = bootstrap.Modal.getOrCreateInstance(myModalEl);

                                modal.hide();

                                Swal.fire({
                                    title: '¡Enhorabuena!',
                                    html: `
                                            <div class="d-flex flex-column">
                                                <span class="swal2-subtitle-success">¡Los datos han sido guardados con éxito!</span>
                                            </div>
                                    `,
                                    confirmButtonText: "¡Entendido!",
                                    focusConfirm: false,
                                    focusCancel: false,
                                    showCloseButton: true,
                                    imageUrl: "{{ asset('img/icon_success_2.png') }}",
                                    imageAlt: "Maintenance",
                                    closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                    customClass: {
                                        image: 'mt-10 mb-0 mx-auto w-25',
                                        confirmButton: "btn btn-standar",
                                        closeButton: 'custom-swal-close-button',
                                        htmlContainer: 'swal2-html-container', 
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        form.submit();
                                    }
                                });
                                
                            }, 2000);
                        }
                    });
                }
            });
        }

        return {
            // Public functions
            init: function () {
                initUpdatePassword();
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function () {
        KTUsersUpdatePassword.init();
    });
</script>
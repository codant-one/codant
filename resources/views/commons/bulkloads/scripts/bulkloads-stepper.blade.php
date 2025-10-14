<script>

    "use strict";

    var KTCreateRegister = function () {
        var stepper;
        var form;
        var formSubmitButton;
        var stepperObj;
        var validations = [];
        var validationsIndex = 0;

        var initStepper = function () {

            stepperObj = new KTStepper(stepper);

            stepperObj.on('kt.stepper.next', function (stepper) {

                var validator = validations[stepper.getCurrentStepIndex() - 1];

                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            stepper.goNext(); 
                            KTUtil.scrollTop();
                        } else {
                            Swal.fire({
                                title: 'Algo ha ido mal',
                                html: `
                                    <div class="d-flex flex-column">
                                        <span class="swal2-subtitle-error">Lo sentimos, algunos datos son errados. </span>
                                        <span class="swal2-html-container d-flex mt-0 align-center">
                                            <img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
                                            <span class="ms-2">Revise la información e intente de nuevo.</span>
                                        </span>
                                    </div>
                                `,
                                confirmButtonText: "Entendido",
                                focusConfirm: false,
                                focusCancel: false,
                                showCloseButton: true,
                                imageUrl: "{{ asset('img/icon_error.png') }}",
                                imageAlt: "Error",
                                closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                customClass: {
                                    image: 'mt-10 mb-0 mx-auto w-25',
                                    confirmButton: "btn btn-standar",
                                    closeButton: 'custom-swal-close-button',
                                    htmlContainer: 'swal2-html-container', 
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
                        }
                    });
                } else {
                    stepper.goNext();
                    KTUtil.scrollTop();
                }

            });

            stepperObj.on('kt.stepper.previous', function (stepper) {
                stepper.goPrevious();
                KTUtil.scrollTop();
            });

            stepperObj.on("kt.stepper.click", function (stepper, clickedStepIndex) {
                var validator = validations[stepper.getCurrentStepIndex() - 1];

                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            stepper.goTo(clickedStepIndex);
                            KTUtil.scrollTop();
                        } else {
                            if(clickedStepIndex < stepper.getCurrentStepIndex()){
                                KTCreateRegister.getValidations()[1].revalidateField('elements');
                                stepper.goTo(clickedStepIndex);
                                KTUtil.scrollTop();
                            } else {
                                Swal.fire({
                                    title: 'Algo ha ido mal',
                                    html: `
                                        <div class="d-flex flex-column">
                                            <span class="swal2-subtitle-error">Lo sentimos, algunos datos son errados. </span>
                                            <span class="swal2-html-container d-flex mt-0 align-center">
                                                <img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
                                                <span class="ms-2">Revise la información e intente de nuevo.</span>
                                            </span>
                                        </div>
                                    `,
                                    confirmButtonText: "Entendido",
                                    focusConfirm: false,
                                    focusCancel: false,
                                    showCloseButton: true,
                                    imageUrl: "{{ asset('img/icon_error.png') }}",
                                    imageAlt: "Error",
                                    closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                    customClass: {
                                        image: 'mt-10 mb-0 mx-auto w-25',
                                        confirmButton: "btn btn-standar",
                                        closeButton: 'custom-swal-close-button',
                                        htmlContainer: 'swal2-html-container', 
                                    }
                                }).then(function () {
                                    KTUtil.scrollTop();
                                });
                            }
                        }
                    });
                } else {
                    stepper.goTo(clickedStepIndex);
                    KTUtil.scrollTop();
                }
            });
        }

        var handleForm = function() {
            formSubmitButton.addEventListener('click', function (e) {

                e.preventDefault();

                var validator = validations[1]; // get validator for current step
    
                if (validator) {
                    validator.validate().then(function (status) {
                        if (!form.checkValidity() || status != 'Valid'){
                            Swal.fire({
                                title: 'Algo ha ido mal',
                                html: `
                                    <div class="d-flex flex-column">
                                        <span class="swal2-subtitle-error">Lo sentimos, algunos datos son errados. </span>
                                        <span class="swal2-html-container d-flex mt-0 align-center">
                                            <img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
                                            <span class="ms-2">Revise la información e intente de nuevo.</span>
                                        </span>
                                    </div>
                                `,
                                confirmButtonText: "Entendido",
                                focusConfirm: false,
                                focusCancel: false,
                                showCloseButton: true,
                                imageUrl: "{{ asset('img/icon_error.png') }}",
                                imageAlt: "Error",
                                closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                customClass: {
                                    image: 'mt-10 mb-0 mx-auto w-25',
                                    confirmButton: "btn btn-standar",
                                    closeButton: 'custom-swal-close-button',
                                    htmlContainer: 'swal2-html-container', 
                                }
                            }).then(function () {
                                KTUtil.scrollTop();
                            });
          
                        } else {

                            formSubmitButton.setAttribute('data-kt-indicator', 'on');
                            formSubmitButton.disabled = true;

                            const formData = new FormData(form);
                            @isset($beforeSubmit) 
                                // Crea una función temporal que evalúa el texto
                                beforeSubmit(formData)
                            @endisset

                            form.action = '{{ $action }}';

                            fetch(form.action, {
                                method: form.method,
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                formSubmitButton.removeAttribute('data-kt-indicator');
                                formSubmitButton.disabled = false;

                                Swal.fire({
                                    title: '¡Enhorabuena!',
                                    html: `
                                            <div class="d-flex flex-column">
                                                <span class="swal2-subtitle-success">{{ $alert_success_subtitle }}</span>
                                                <span class="swal2-html-container d-flex mt-0 align-center">
                                                    <span class="mt-4">{{ $alert_success_text }}
                                                    </span>
                                                </span>
                                            </div>
                                    `,
                                    confirmButtonText: "Continuar",
                                    focusConfirm: false,
                                    focusCancel: false,
                                    showCloseButton: true,
                                    imageUrl: "{{ asset('img/icon_success.png') }}",
                                    imageAlt: "Maintenance",
                                    closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                    customClass: {
                                        image: 'mt-10 mb-0 mx-auto w-25',
                                        confirmButton: "btn btn-standar",
                                        closeButton: 'custom-swal-close-button',
                                        htmlContainer: 'swal2-html-container', 
                                    }
                                }).then((function(t) {
                                    window.location.href = "{{ $newLocation }}";
                                    return true;
                                }));
                            
                            })
                            .catch(error => {
                                console.log('Error en la solicitud:', error);
                            });
                    
                        }    
                    });
                }            
            });

        }

        var initValidation = function () {
            // Step 1
            validations.push(FormValidation.formValidation(
                form,
                {
                    fields: {
                        'file_upload': {
                            validators: {
                                callback: {
                                    message: 'El archivo es requerido',
                                    callback: function(input) {
                                        return file_upload_dropzone.getAcceptedFiles().length > 0;
                                    }
                                }
                            }
                        }
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
            ));

            // Step 2
            validations.push(FormValidation.formValidation(
                form,
                {
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        }),
                        submitButton: new FormValidation.plugins.SubmitButton()
                    }
                }
            ));
        }

        var getValiodations = function(){
            return validations;
        }

        return {
            init: function () {
                stepper = document.querySelector('#register_stepper');

                if (!stepper) { return; }

                form = stepper.querySelector('#formUploadFile');
                formSubmitButton = stepper.querySelector('#upload_submit');

                initStepper();
                initValidation();

                handleForm();
            },
            getValidations: function(){
                return validations;
            }
        };
    }();

    KTUtil.onDOMContentLoaded(function() {
        KTCreateRegister.init();
    });

    function showDataTable(data) {
        table.clear();
        var headerLength = table.columns()[0].length;
        var nextColumns = ( (headerLength-2) <= 0) ? 0: headerLength-2;
        var fileValid = false;

        $.each(data, function(index, value){
            var checkColumnName = '{{ $checkColumnName }}';
            
            if ( Object.hasOwn(value, checkColumnName) ){
                fileValid = true;
                for (let i = 0; i < nextColumns; i++) {
                    value[`${i + 2}`] = null;
                }
                table.row.add(value).draw();
            }
        });

        if (!fileValid){
            Swal.fire({
                title: 'Algo ha ido mal',
                html: `
                    <div class="d-flex flex-column">
                        <span class="swal2-subtitle-error">Formato del archivo inválido. </span>
                        <span class="swal2-html-container d-flex mt-0 align-center">
                            <img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
                            <span class="ms-2">Revise la información e intente de nuevo.</span>
                        </span>
                    </div>
                `,
                confirmButtonText: "Entendido",
                focusConfirm: false,
                focusCancel: false,
                showCloseButton: true,
                imageUrl: "{{ asset('img/icon_error.png') }}",
                imageAlt: "Error",
                closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                customClass: {
                    image: 'mt-10 mb-0 mx-auto w-25',
                    confirmButton: "btn btn-standar",
                    closeButton: 'custom-swal-close-button',
                    htmlContainer: 'swal2-html-container', 
                }
            }).then(function () {
                KTUtil.scrollTop();
                window.file_upload_dropzone.removeAllFiles(true);
            });
        }
        




        const selectedElements = [];
        $('input[name="uploadElements[]"]:checked').each(function () {
            selectedElements.push($(this).val());
        });
        $("#elements").val(JSON.stringify(selectedElements));

        var form = document.querySelector('#formUploadFile');

        //Agrega Validacion a los elementos de la tabla.
        KTCreateRegister.getValidations()[1].addField(
            'elements',
            {
                validators: {
                    notEmpty: {
                        message: 'Al menos un elemento debe ser seleccionado',
                    }
                }
            }                     
        );

        @isset($checkAllInputChange) 
            // Crea una función temporal que evalúa el texto
            eval({{ $checkAllInputChange }})(true, KTCreateRegister.getValidations()[1]); 
        @endisset

        //si activo el padre
        $('input[data-kt-check="true"]').on('change', function () {
            const isChecked = $(this).is(':checked');
            const selectedElements = [];
            
            if (isChecked) {//todos fill
                $('input[name="uploadElements[]"]:checked').each(function () {
                    selectedElements.push($(this).val());
                });
                $("#elements").val(JSON.stringify(selectedElements));
            } else //vacios
                $("#elements").val('');

            KTCreateRegister.getValidations()[1].revalidateField('elements');

            @isset($checkAllInputChange) 
                // Crea una función temporal que evalúa el texto
                eval({{ $checkAllInputChange }})(isChecked, KTCreateRegister.getValidations()[1]); 
            @endisset
        });

        //si se activo un hijo
        $('input[name="uploadElements[]"]').on('change', function() {
            const hasChecked = $('input[name="uploadElements[]"]:checked').length > 0;
            const selectedElements = [];
            const index = this.id;
            var isChecked = false;

            if (hasChecked) {
                $('input[name="uploadElements[]"]:checked').each(function () {
                    selectedElements.push($(this).val());
                    if (index === this.id)
                        isChecked = true;
                });
                $("#elements").val(JSON.stringify(selectedElements));
                
            } else
                $("#elements").val('');

            KTCreateRegister.getValidations()[1].revalidateField('elements');

            @isset($checkInputChange) 
                // Crea una función temporal que evalúa el texto
                eval({{ $checkInputChange }})(isChecked, KTCreateRegister.getValidations()[1], this.id); 
            @endisset
        });


        @isset($initCompleteTable) 
            // Crea una función temporal que evalúa el texto
            eval({{ $initCompleteTable }})(KTCreateRegister.getValidations()[1]); 
        @endisset
    }
</script>


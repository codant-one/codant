<script>
    // validator = null

    window.file_upload_dropzone = new Dropzone("#file_upload_dropzone", {
        url: "/profile/complete",
        autoProcessQueue: false,
        addRemoveLinks: true,
        acceptedFiles: ".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        maxFiles: 1,
        maxFilesize: 0.5,
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles();
                this.addFile(file);
            });
            this.on("addedfile", function(file) {
                const previewElement = file.previewElement;

                previewElement.classList.add("dz-file-excel");

                document.getElementById("file_upload").value = "file_added";
                KTCreateRegister.getValidations()[0].revalidateField('file_upload');
                var validator = KTCreateRegister.getValidations()[0];

                if (validator) {
                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            $('#loader').show()
                            $('#progress').show()

                            var form = document.querySelector('#formUploadFile');
                            
                            const formData = new FormData(form);
                    
                            window.file_upload_dropzone.getAcceptedFiles().forEach((file, index) => {
                                formData.append(`file`, file);
                            });

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
                                $('#loader').hide();
                                $('#progress').hide();
                                showDataTable(data);
                            })
                            .catch(error => {
                                console.log('Error en la solicitud:', error);
                            });
                        

                        } else {
                            //Sleep de 2.5 segundos para que se logre apreciar el Alert del evento error.
                            setTimeout(function(){
                                window.file_upload_dropzone.removeFile(file);
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
                                    showCloseButton: false,
                                    imageUrl: "{{ asset('img/icon_error.png') }}",
                                    imageAlt: "Error",
                                    closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                                    customClass: {
                                        image: 'mt-10 mb-0 mx-auto w-25',
                                        confirmButton: "btn btn-standar",
                                        closeButton: 'custom-swal-close-button',
                                        htmlContainer: 'swal2-html-container', 
                                    }
                                });
                            }, 2500);
                        }
                    });
                }
            });
            this.on("removedfile", function(file) {
                if (this.files.length === 0) {
                    document.getElementById("file_upload").value = ""; 
                    KTCreateRegister.getValidations()[0].revalidateField('file_upload');
                }
            });
            this.on("error", function(file, message) {
                var validator = KTCreateRegister.getValidations()[0];
                if (file.size > 0.5 * 1024 * 1024) {
                    
                    Swal.fire({
                        title: 'Algo ha ido mal',
                        html: `
                            <div class="d-flex flex-column">
                                <span class="swal2-subtitle-error">El archivo supera el tamaño máximo permitido de 3MB.</span>
                                <span class="swal2-html-container d-flex mt-0 align-center">
                                    <img src="{{ url('/svg/info-warning.svg') }}" alt="warning">
                                    <span class="ms-2">Revise la información e intente de nuevo.</span>
                                </span>
                            </div>
                        `,
                        confirmButtonText: "Entendido",
                        focusConfirm: false,
                        focusCancel: false,
                        showCloseButton: false,
                        imageUrl: "{{ asset('img/icon_error.png') }}",
                        imageAlt: "Error",
                        closeButtonHtml: `<img src="{{ url('/svg/close-circle-gray.svg') }}" alt="close" style="transform: scale(0.7);">`,
                        customClass: {
                            image: 'mt-10 mb-0 mx-auto w-25',
                            confirmButton: "btn btn-standar",
                            closeButton: 'custom-swal-close-button',
                            htmlContainer: 'swal2-html-container',
                        }
                    });
                    
                    window.file_upload_dropzone.removeFile(file);
                    validator.revalidateField('file_upload');
                    
                    
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        const progressBar = document.getElementById("progress-bar");
        const animationDuration = 3000;
        const updateInterval = 30;
        
        function animateProgressBar() {
            let startTime = null;
            
            function update(currentTime) {
                if (!startTime) startTime = currentTime;
                
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / animationDuration, 1);
                const width = progress * 100;

                progressBar.style.width = `${width}%`;
                progressBar.setAttribute("aria-valuenow", Math.round(width));
                
                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    setTimeout(() => {
                        progressBar.style.width = "0%";
                        progressBar.setAttribute("aria-valuenow", "0");
                        setTimeout(animateProgressBar, 500);
                    }, 500);
                }
            }
            
            requestAnimationFrame(update);
        }
        
        animateProgressBar();
    });
</script>
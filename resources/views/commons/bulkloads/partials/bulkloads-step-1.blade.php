<div class="flex-column current" data-kt-stepper-element="content">
    <div class="mt-5 card-admin-upload d-flex flex-column">
        <span class="title-upload">
            1. {{ $title_1 }}
        </span>
        <span class="text-upload mt-2">
            {{ $text_1 }}
        </span>
        <a href="{{ $referenceFile }}" download class="btn btn-standar d-flex align-center mt-2 w-300px px-4">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 11V17L11 15" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M9 17L7 15" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 10V15C22 20 20 22 15 22H9C4 22 2 20 2 15V9C2 4 4 2 9 2H14" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 10H18C15 10 14 9 14 6V2L22 10Z" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="ms-2">Descargar documento de referencia</span>
        </a>
    </div>
    <div class="mt-5 card-admin-upload d-flex flex-column">
        <span class="title-upload">
            2. {{ $title_2 }}
        </span>
        <span class="text-upload mt-2 fv-row">
            {{ $text_2 }}
            <input type="hidden" name="file_upload" id="file_upload">
            <div class="dropzone dropzone-dashed dropzone-register mt-2" id="file_upload_dropzone">
                <div class="dz-message needsclick">
                    <div class="ms-4">
                        <span class="fs-7 fw-bold text-gray-400 text-center">
                            Arrastre o haga clic en esta zona <br>
                            para subir las imágenes y/o documentos.
                        </span>
                    </div>
                </div>
            </div>
        </span>
    </div>
    <div class="mt-5 card-admin-upload d-flex flex-column">
        <span class="title-upload">
            3. {{ $title_3 }}
        </span>
        <span class="text-upload mt-2">
            {{ $text_3 }}
            <div class="progress" id="progress" style="display: none;">
                <div id="progress-bar" 
                    class="progress-bar progress-bar-striped progress-bar-animated" 
                    role="progressbar" 
                    style="width: 0%;" 
                    aria-valuenow="0" 
                    aria-valuemin="0" 
                    aria-valuemax="100">
                </div>
            </div>
        </span>
    </div>
</div>

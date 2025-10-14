
    <div class="stepper stepper-pills" id="register_stepper">
        @include('commons.bulkloads.partials.bulkloads-stepper')
    
        <!--  tenant.admin.clients.uploadFile -->
        {!! Form::open(['route' => 'tenant.excelimport.uploadFile', 'id'=>'formUploadFile', 'class' => 'w-100', 'method' => 'POST']) !!}
        <div class="w-100 p-0 m-0">
              
            @include('commons.bulkloads.partials.bulkloads-step-1')
            @include('commons.bulkloads.partials.bulkloads-step-2')
            @isset($partial_step_3)  @include($partial_step_3) @endisset
            
        </div>
        <div class="container-buttons-actions mt-5 d-flex justify-content-end">
            <div class="d-flex justify-content-end">
                <div>
                    <button type="button" class="btn btn-outline btn-tertiary button-return-detail w-200px me-4" data-kt-stepper-action="previous">
                        Regresar
                    </button>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary w-200px" id="upload_submit" data-kt-stepper-action="submit">
                        <span class="indicator-label">Finalizar</span>
                        <span class="indicator-progress">
                            <span class="spinner-border spinner-border-md align-middle"></span>
                        </span>
                    </button>
                    <button type="button" class="btn btn-secondary button-return-detail w-200px" data-kt-stepper-action="next">
                        Continuar
                    </button>
                </div>
                
            </div> 
        </div>
        {!! Form::close() !!}
    </div>
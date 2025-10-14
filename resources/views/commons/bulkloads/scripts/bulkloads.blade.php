    
    @include('commons.bulkloads.scripts.bulkloads-stepper')
    @include('commons.bulkloads.scripts.bulkloads-step-1')
    @include('commons.bulkloads.scripts.bulkloads-step-2')

    @isset($script_step_3)  
        @include($script_step_3) 
    @endisset
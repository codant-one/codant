<div class="flex-column" data-kt-stepper-element="content">
    <div class="fv-row">
        {!! Form::hidden('elements', old('elements'), [
            'id' => 'elements',
            'class' => 'form-control mb-3 mb-lg-0'
        ]) !!}
        {!! Form::hidden('elementsDataTable', old('elementsDataTable'), [
            'id' => 'elementsDataTable',
            'class' => 'form-control mb-3 mb-lg-0'
        ]) !!}
    </div>
    <div class="pt-0 table-responsive w-100">
        <table id="kt_datatable_example_1" class="table align-middle table-row-bordered fs-6" style="width:100%">
            <thead class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                <tr>
                    <th class="w-10px table-status">
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" checked/>
                        </div>
                    </th>
                    @isset($partial_step_2_columns)  @include($partial_step_2_columns) @endisset
                </tr>
            </thead>
            <tbody class="text-gray-600 fw-bold bg-white"></tbody>
        </table>
    </div>
</div>
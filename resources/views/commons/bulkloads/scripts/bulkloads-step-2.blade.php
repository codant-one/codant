@isset($script_step_2_columns)  
    @include($script_step_2_columns) 
@endisset
<script>
    
    var data = [];

    var blTableColumns = [ { data: '{{$checkColumnName}}', orderable: false} ];
    var userColumns = columns ?? [];
    blTableColumns = blTableColumns.concat(userColumns);

    var blTableColumnDefs = [
            {
                targets: 0,
                orderable: false,
                render: function (data, type, row, meta) {
                    return  `<div class="form-check form-check-sm form-check-custom form-check-solid justify-content-center">
                                <input class="form-check-input" type="checkbox" id="uploadElements_${meta.row}" name="uploadElements[]" value="${data}" checked/>
                            </div>`;
                }
                
            }
        ];
    var userColumnDefs = columnDefs ?? [];
    blTableColumnDefs = blTableColumnDefs.concat(userColumnDefs);

    const table = $('#kt_datatable_example_1').DataTable({
        paging: false,
        info: false,
        searching: false,
        orderCellsTop: true,
        drawCallback: function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        },
        initComplete: function() {
            $('#kt_datatable_example_1_wrapper .datatable-list-text').removeClass('mt-5');
        },
        columns: blTableColumns,
        data: data,
        columnDefs: blTableColumnDefs,
        order: [[ 1, "asc" ]]
    });
</script>
$(document).ready(function () {
    // Activar spinner en submit
    $('form').on('submit', function(){
        const $form = $(this);
        const $submitBtn = $form.find('button[type="submit"]');
        const $spinner = $submitBtn.find('.spinner-border');
        const $icon = $submitBtn.find('i');
        
        // Deshabilitar botón y mostrar spinner
        $submitBtn.prop('disabled', true);
        $icon.addClass('d-none');
        $spinner.removeClass('d-none');
    });

    $(document).on('click', '.delete-item', function(e) {
            let form = $(this).closest('form');

            Swal.fire({
                html: `
                    <div class="mt-3">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#AA83FF,secondary:#f06548" style="width:120px;height:120px"></lord-icon>
                        <div class="fs-15">
                            <h4>¿Estás seguro?</h4>
                            <p class="text-muted mx-4 mb-0">
                                ¡No podrás revertir esta acción!
                            </p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                showConfirmButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                customClass: {
                    confirmButton: 'btn btn-danger w-xs mb-1 me-2',
                    cancelButton: 'btn btn-light w-xs mb-1',
                },
                buttonsStyling: false,
                showCloseButton: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }   
            });
    });
});
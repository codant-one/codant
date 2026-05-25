@extends('admin.layouts.master')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Permisos @endslot
    @slot('title') Lista de permisos @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card" id="roleList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Lista de permisos</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            @can('permission_create')
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Crear permiso
                            </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
		    <div class="card-body">
                <div class="table-responsive table-card mb-1">
                    <table id="kt_datatable_example_1" class="table align-middle table-nowrap" style="width:100%">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                            <th class="sort">ID</th>
                            <th class="sort">DESCRIPCIÓN</th>
                            <th class="sort">CREADO</th>
                            @canany(['permission_edit', 'permission_delete'])
                            <th class="text-center w-50px"></th>
                            @endcanany
                        </tr>
                     </thead>
                        <tbody class="list form-check-all"></tbody>
                    </table>
                    <div class="noresult" style="display: none">
                        <div class="text-center">
                            <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" 
                                colors="primary:#151426,secondary:#0ab39c" style="width:75px;height:75px">
                            </lord-icon>
                            <h5 class="mt-2">Lo sentimos! No se encontraron resultados</h5>
                            <p class="text-muted">No se encontraron roles para tu búsqueda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.cruds.permission.create')
@include('admin.cruds.permission.edit')

@endsection

@section('script')
<script>
    $(document).ready(function () {

        $.fn.dataTable.ext.errMode = 'none';
        
        var can = "{!!  auth()->user()->canany(['permission_edit','permission_edit']) !!}";
         
        var columns;

        if(can) {
            columns = [
                { data: 'id' }, //Return ID in the ROW
                { data: 'description' },
                { data: 'created_at', render: function(data){
                    const date = new Date(data);
                    const months = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                    return date.getDate() + ' de ' + months[date.getMonth()] + ' ' + date.getFullYear();
                } },
                { data: 'actions', name: 'actions', orderable: false, searchable: false },
            ];
        } else {
            columns = [
                { data: 'id' }, //Return ID in the ROW
                { data: 'description' },
                { data: 'created_at', render: function(data){
                    const date = new Date(data);
                    const months = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                    return date.getDate() + ' de ' + months[date.getMonth()] + ' ' + date.getFullYear();
                } },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, visible: false }
            ];
        }
        
		const table = $('#kt_datatable_example_1').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            ajax: {
                url: "{{ route('permissions.index') }}",
                data: function(d){
                    
                    // Agregar el número de página
                    d.page = Math.floor(d.start / d.length) + 1;
                    
                    // Transformar el formato de order para el backend
                    if (d.order && d.order.length > 0) {
                        d.order = d.order.map(function(item) {
                            return {
                                column_name: d.columns[item.column].data,
                                dir: item.dir
                            };
                        });
                    } else {
                        d.order = [{
                            column_name: 'id',
                            dir: 'desc'
                        }];
                    }

                    // Asegurar que columns existe
                    if (!d.columns) {
                        d.columns = columns.map(col => ({
                            data: col.data,
                            name: col.name || col.data,
                            searchable: col.searchable !== false,
                            orderable: col.orderable !== false,
                            search: { value: '', regex: false }
                        }));
                    }

                    return d;
                },
                dataFilter: function(data) {
                    
                    var json = JSON.parse(data);
                    
                    // Transformar la respuesta de Laravel a formato DataTables
                    json.recordsTotal = json.total;
                    json.recordsFiltered = json.total;
                    json.data = json.data;
                    
                    return JSON.stringify(json);
                },
                error: function(xhr, error, thrown) {
                    // Mostrar toast de error
                    Toastify({
                        text: "Error al cargar los roles. Por favor, recarga la página.",
                        duration: 3000,
                        gravity: "top",
                        position: "right",
                        stopOnFocus: true,
                        close: true,
                        style: {
                            background: "linear-gradient(to right, #f46a6a, #dc3545)",
                        },
                    }).showToast();
                }
            },
            columns: columns,
            columnDefs: [
                    {
                        targets: -1,
                        data: null,
                        orderable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            actionsHtml = `<div class="dropdown">
                                                <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ri-more-fill align-middle"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    @can('permission_edit')
                                                    <li>
                                                        <a href="#editModal" 
                                                            data-permission-id="${row.id}" 
                                                            data-description="${row.description}"
                                                            data-custom="${row.custom}"
                                                            class="dropdown-item edit-item-btn">
                                                            <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Editar
                                                        </a>
                                                    </li>
                                                    @endcan
                                                    @can('permission_delete')
                                                    <li>
                                                        <form class="delete-form" method="POST" action="{{ route('permissions.destroy', ['permission' => 'id-here']) }}">
                                                            @csrf
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <a href="#" class="dropdown-item remove-item-btn delete-item" data-permission-id="${row.id}">
                                                                <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> Eliminar
                                                            </a>
                                                        </form>
                                                    </li>
                                                    @endcan
                                                </ul>
                                            </div>`;

                            let actions = actionsHtml.replaceAll('id-here', row.id);

                            return `${actions}`
                        },
                    }
                ],
            order: [[ 0, "desc" ]]
        });

        // Limpiar modal de creación al cerrar
        $('#showModal').on('hidden.bs.modal', function () {
            const $form = $(this).find('form');
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.spinner-border');
            const $icon = $submitBtn.find('i');
            
            // Resetear formulario
            $form[0].reset();
            $(this).find('.is-invalid').removeClass('is-invalid');
            $(this).find('.invalid-feedback').remove();
            
            // Resetear spinner
            $submitBtn.prop('disabled', false);
            $icon.removeClass('d-none');
            $spinner.addClass('d-none');
        });
        
        // Manejar submit del formulario de creación
        $('#showModal form').on('submit', function(e) {
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.spinner-border');
            const $icon = $submitBtn.find('i');
            
            // Deshabilitar botón y mostrar spinner
            $submitBtn.prop('disabled', true);
            $icon.addClass('d-none');
            $spinner.removeClass('d-none');
        });

        // Limpiar modal de edición al cerrar
        $('#editModal').on('hidden.bs.modal', function () {
            // Desenfocar cualquier botón de editar que pueda tener foco
            $('.edit-item-btn').blur();
        });

        // Cargar datos del permiso en el modal de edición
        $(document).on('click', '.edit-item-btn', function(e) {
            e.preventDefault();
            const $clickedBtn = $(this);
            
            // Desenfocar inmediatamente el botón para evitar warning
            $clickedBtn.blur();
            
            // Obtener datos del permiso desde los atributos data-*
            const permissionId = $clickedBtn.data('permission-id');
            const description = $clickedBtn.data('description');
            const custom = $clickedBtn.data('custom');
            
            // Validar si el permiso puede ser editado
            if (custom == 0) {
                Toastify({
                    text: "No tiene permiso para esta acción.",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    close: true,
                    escapeMarkup: false,
                    style: {
                        background: "linear-gradient(to right, #f46a6a, #dc3545)",
                    },
                }).showToast();
                return false; // Detener la ejecución y NO abrir modal
            }
            
            // Guardar referencia del botón que abrió el modal
            $('#editModal').data('triggerButton', $clickedBtn);
            
            // Llenar el formulario con los datos del permiso
            $('#edit_permission_id').val(permissionId);
            $('#edit_description').val(description);
            
            // Actualizar la acción del formulario reemplazando el placeholder
            const currentAction = $('#editPermissionForm').attr('action');
            const newAction = currentAction.replace('PERMISSION_ID_PLACEHOLDER', permissionId);
            $('#editPermissionForm').attr('action', newAction);
            
            // Abrir el modal manualmente solo si pasa la validación
            $('#editModal').modal('show');
        });

        // Manejar submit del formulario de edición
        $('#editPermissionForm').on('submit', function(e) {
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $spinner = $submitBtn.find('.spinner-border');
            const $icon = $submitBtn.find('i');
            
            // Deshabilitar botón y mostrar spinner
            $submitBtn.prop('disabled', true);
            $icon.addClass('d-none');
            $spinner.removeClass('d-none');
            
            // El formulario se enviará normalmente (sin preventDefault)
        });
	});
</script>
@endsection
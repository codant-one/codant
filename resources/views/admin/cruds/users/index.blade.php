@extends('admin.layouts.master')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Usuarios @endslot
    @slot('title') Lista de usuarios @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="userList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Lista de usuarios</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            @can('user_create')
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Crear usuario
                            </button>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body border border-dashed border-end-0 border-start-0">
                <form>
                    <div class="row g-3">
                        <div class="col-xxl-6 col-sm-6">
                            <div class="search-box">
                                <input type="text" class="form-control search" placeholder="Buscar por ID, nombre, email...">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <select name="token" id="token" class="form-control token" data-placeholder="Token2FA">
                                <option value="">Token 2FA</option>
                                @foreach(['No' => 'No Habilitado', 'Si' => 'Habilitado'] as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <select name="roles" id="roles" class="form-control roles" data-placeholder="ROL">
                                <option value="">ROL</option>
                                @foreach($roles as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xxl-2 col-sm-4">
                            <button type="button" class="btn btn-soft-secondary w-100 btn-reset">
                                <i class="ri-refresh-line me-1 align-bottom"></i>
                                Limpiar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-1">
                    <table id="kt_datatable_example_1" class="table align-middle table-nowrap" style="width:100%">
                        <thead class="text-muted table-light">
                            <tr class="text-uppercase">
                                <th class="sort" data-sort="id">ID</th>
                                <th class="sort" data-sort="nombre">NOMBRE</th>
                                <th class="sort" data-sort="email">EMAIL</th>
                                <th class="sort" data-sort="two-step">TWO-STEP</th>
                                <th class="sort" data-sort="rol">ROL</th>
                                @canany(['user_edit', 'user_delete'])
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
                            <p class="text-muted">No se encontraron usuarios para tu búsqueda.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.cruds.users.create')
@include('admin.cruds.users.edit')

@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Deshabilitar el alert de error por defecto de DataTables
        $.fn.dataTable.ext.errMode = 'none';

        //Initializate select2
        $('.roles').select2();
        $('.token').select2();
     
        var can = "{!!  auth()->user()->canany(['user_edit','user_delete']) !!}";
         
        var columns;
        if(can) {
            columns = [
                { data: 'id', name: 'id' },
                { data: 'firstname', name: 'firstname' },
                { data: 'email', name: 'email' },
                { data: 'is_2fa', name: 'is_2fa', orderable: false, searchable: false },
                { data: 'roles', name: 'roles', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ];
        } else {
            columns = [
                { data: 'id', name: 'id' },
                { data: 'firstname', name: 'firstname' },
                { data: 'email', name: 'email' },
                { data: 'is_2fa', name: 'is_2fa', orderable: false, searchable: false },
                { data: 'roles', name: 'roles', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, visible: false }
            ];
        }

        const table = $('#kt_datatable_example_1').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            ajax: {
                url: "{{ route('users.index') }}",
                type: 'GET',
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

                    // Filtro de búsqueda general
                    if ($('.search').val()) {
                        d.columns[1].search.value = $('.search').val();
                    }

                    // Filtro de 2FA
                    if ($('.token').val()) {
                        d.columns[3].search.value = $('.token').val();
                    }

                    // Filtro de Roles
                    if ($('.roles').val()) {
                        d.columns[4].search.value = $('.roles').val();
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
                        text: "Error al cargar los usuarios. Por favor, recarga la página.",
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
                    targets: 1,
                    render: function (data, type, row) {
                        const fullname = data + ' ' + row.lastname;
                        const title = fullname.length > 25 ? `${fullname.slice(0, 25).replace(/\s+$/, '')}...` : fullname;
                        const roleId = row.roles && row.roles.length > 0 ? row.roles[0].id : '';

                        return `<a href="#editModal" 
                                   data-bs-toggle="modal" 
                                   data-user-id="${row.id}" 
                                   data-firstname="${row.firstname}" 
                                   data-secondname="${row.secondname || ''}" 
                                   data-lastname="${row.lastname}" 
                                   data-secondsurname="${row.secondsurname || ''}" 
                                   data-email="${row.email}"
                                   data-role-id="${roleId}"
                                   class="text-dark fw-bolder text-hover-primary fs-6 edit-item-btn">
                                    ${title}
                                </a>`;
                    }
                },
                {
                    targets: 3,
                    render: function (data, type, row) {
                        return (
                            row.is_2fa ?
                            '<span class="badge rounded-pill bg-success-subtle text-success text-uppercase">Habilitado</span>' :
                            '<span class="badge rounded-pill bg-danger-subtle text-danger text-uppercase">No habilitado</span>'
                        )
                    }
                },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        let badges = {
                            'SuperAdmin': '<span class="badge rounded-pill bg-primary-subtle text-primary fw-bolder">Super Admin</span>',
                            'Administrador': '<span class="badge rounded-pill bg-info-subtle text-info fw-bolder">Administrador</span>',
                            'Operador': '<span class="badge rounded-pill bg-warning-subtle text-warning fw-bolder">Operador</span>',
                            'Cliente': '<span class="badge rounded-pill bg-success-subtle text-success fw-bolder">Cliente</span>'
                        }
                        return badges[data[0].name] 
                    }
                },
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
                                                @can('user_edit')
                                                <li>
                                                    <a href="#editModal" 
                                                       data-bs-toggle="modal" 
                                                       data-user-id="${row.id}" 
                                                       data-firstname="${row.firstname}" 
                                                       data-secondname="${row.secondname || ''}" 
                                                       data-lastname="${row.lastname}" 
                                                       data-secondsurname="${row.secondsurname || ''}" 
                                                       data-email="${row.email}"
                                                       data-role-id="${row.roles && row.roles.length > 0 ? row.roles[0].id : ''}"
                                                       class="dropdown-item edit-item-btn">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Editar
                                                    </a>
                                                </li>
                                                @endcan
                                                @can('user_delete')
                                                <li>
                                                    <form class="delete-form" method="POST" action="{{ route('users.destroy', ['user' => 'id-here']) }}">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <a href="#" class="dropdown-item remove-item-btn delete-item" data-role-id="${row.id}">
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

        // Filtros en tiempo real
        $('.search').on('keyup', function() {
            table.draw();
        });

        $('#filter-id').on('keyup', function() {
            table.draw();
        });

        $('.token').on('change', function() {
            table.draw();
        });

        $('.roles').on('change', function() {
            table.draw();
        });

        // Limpiar filtros
        $('.btn-reset').on('click', function() {
            $('#filter-id').val('');
            $('.token').val('').trigger('change');
            $('.roles').val('').trigger('change');
            $('.search').val('');
            table.draw();
        });

        // Limpiar modal al cerrar (ya manejado globalmente, pero podemos agregar lógica específica)
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

        // Cargar datos del usuario en el modal de edición
        $(document).on('click', '.edit-item-btn', function(e) {
            e.preventDefault();
            const $clickedBtn = $(this);
            
            // Desenfocar inmediatamente el botón para evitar warning
            $clickedBtn.blur();
            
            // Guardar referencia del botón que abrió el modal
            $('#editModal').data('triggerButton', $clickedBtn);
            
            // Obtener datos del usuario desde los atributos data-*
            const userId = $clickedBtn.data('user-id');
            const firstname = $clickedBtn.data('firstname');
            const secondname = $clickedBtn.data('secondname');
            const lastname = $clickedBtn.data('lastname');
            const secondsurname = $clickedBtn.data('secondsurname');
            const email = $clickedBtn.data('email');
            const roleId = $clickedBtn.data('role-id');
            
            // Llenar el formulario con los datos del usuario
            $('#edit_user_id').val(userId);
            $('#edit_firstname').val(firstname);
            $('#edit_secondname').val(secondname || '');
            $('#edit_lastname').val(lastname);
            $('#edit_secondsurname').val(secondsurname || '');
            $('#edit_email').val(email);
            
            // Limpiar selección de roles
            $('.edit-role-radio').prop('checked', false);
            
            // Seleccionar el rol del usuario
            if (roleId) {
                $(`#edit_role${roleId}`).prop('checked', true);
            }
            
            // Actualizar la acción del formulario reemplazando el placeholder
            const currentAction = $('#editUserForm').attr('action');
            const newAction = currentAction.replace('USER_ID_PLACEHOLDER', userId);
            $('#editUserForm').attr('action', newAction);
        });

        // Manejar el submit del formulario de edición
        // Manejar submit del formulario de edición
        $('#editUserForm').on('submit', function(e) {
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
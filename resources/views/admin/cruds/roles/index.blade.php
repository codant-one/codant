@extends('admin.layouts.master')

@section('content')
@component('components.breadcrumb')
    @slot('li_1') Roles @endslot
    @slot('title') Lista de roles @endslot
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="roleList">
            <div class="card-header border-0">
                <div class="row align-items-center gy-3">
                    <div class="col-sm">
                        <h5 class="card-title mb-0">Lista de roles</h5>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex gap-1 flex-wrap">
                            @can('rol_create')
                            <a href="{{ route('roles.create') }}" class="btn btn-success add-btn">
                                <i class="ri-add-line align-bottom me-1"></i> Crear rol
                            </a>
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
                                <th class="sort" data-sort="id">ID</th>
                                <th class="sort" data-sort="rol">ROL</th>
                                <th class="sort" data-sort="creado">CREADO</th>
                                @canany(['rol_edit', 'rol_delete'])
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

@endsection

@section('script')
<script>
    $(document).ready(function () {
        // Deshabilitar el alert de error por defecto de DataTables
        $.fn.dataTable.ext.errMode = 'none';

        var can = "{!!  auth()->user()->canany(['rol_edit','rol_delete']) !!}";
         
        var columns;
        if(can) {
            columns = [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ];
        } else {
            columns = [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false, visible: false }
            ];
        }

        const table = $('#kt_datatable_example_1').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthChange: false,
            ajax: {
                url: "{{ route('roles.index') }}",
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
                    targets: 2,
                    render: function (data, type, row) {
                        if (!data) return '';
                        const date = new Date(data);
                        const months = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
                        return `${date.getDate()} de ${months[date.getMonth()]} ${date.getFullYear()}`;
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
                                                @can('rol_edit')
                                                <li>
                                                    <a href="{{ route('roles.edit', ['role' => 'id-here']) }}" class="dropdown-item">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Editar
                                                    </a>
                                                </li>
                                                @endcan
                                                @can('rol_delete')
                                                <li>
                                                    <form class="delete-form" method="POST" action="{{ route('roles.destroy', ['role' => 'id-here']) }}">
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
    });
</script>
@endsection
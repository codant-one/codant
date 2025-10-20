@extends('layouts.master', [
'title' => 'Clientes',
'breadcrumbs' => [
route('admin.dashboard.index') => 'Inicio',
route('clients.index') => 'Clientes',
]
])

@section('content')

<div class="container pb-8">
    <div class="card">
        <div class="card-body border-0 pt-2 pb-7">
            <div class="pt-0 table-responsive w-100">
                @can('client_create')
                <a href="{{ route('clients.create') }}" class='btn btn-primary w-25 d-flex align-center mb-5 svg-buttons float-end'>
                    <span class="mr-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 12H16" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12 16V8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    </span>
                    Agregar Nuevo
                </a>
                @endcan
                <table id="clients" class="table align-middle table-row-bordered fs-6" style="width:100%">
                    <thead class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <tr>
                            <th class="w-60px">ID</th>
                            <th class="w-300px">AVATAR</th>
                            <th class="w-300px">NOMBRE</th>
                            <th class="w-300px">EMAIL</th>
                            <th class="w-300px">TELÉFONO</th>
                            <th class="w-300px">DOCUMENTO</th>
                            <th class="w-300px">AÑO</th>
                            <th class="w-300px">EMPRESA</th>
                            <th class="w-300px">LOGO</th>
                            @canany(['client_edit', 'client_delete'])
                            <th class="text-center w-100px">ACCIONES</th>
                            @endcanany
                        </tr>
                        <tr class="bg-white">
                            <th class="px-0">
                                <input type="number" min="1" class="form-control form-control-sm d-block" placeholder="ID">
                            </th>
                            <th class="filters">
                                <!-- Avatar no necesita filtro -->
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm" placeholder="NOMBRE">
                            </th>
                            <th>
                                <input type="email" class="form-control form-control-sm" placeholder="EMAIL"/>
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm" placeholder="TELÉFONO"/>
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm" placeholder="DOCUMENTO"/>
                            </th>
                            <th>
                                <input type="number" class="form-control form-control-sm" placeholder="AÑO"/>
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm" placeholder="EMPRESA"/>
                            </th>
                            <th class="filters">
                                <!-- Logo no necesita filtro -->
                            </th>
                            @canany(['client_edit', 'client_delete'])
                            <th class="text-center w-100px filters">
                                <button class="btn btn-outline btn-tertiary btn-reset btn-sm">Limpiar</button>
                            </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-bold"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

@php
    $edit_route = route("clients.edit", ["client" => 'id-here']);
    $delete_route = route("clients.destroy", ["client" => 'id-here']);
@endphp

<script>
    $(document).ready(function () {
     
        var can = "{!!  auth()->user()->canany(['client_edit','client_delete']) !!}";
         
        var columns;
        if(can) {
            columns = [
                { data: 'id' },
                { data: 'avatar', orderable: false, searchable: false },
                { data: 'fullname' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'document' },
                { data: 'year' },
                { data: 'company' },
                { data: 'logo', orderable: false, searchable: false },
                { data: 'actions', defaultContent: '', orderable: false }
            ];
        } else {
            columns = [
                { data: 'id' },
                { data: 'avatar', orderable: false, searchable: false },
                { data: 'fullname' },
                { data: 'email' },
                { data: 'phone' },
                { data: 'document' },
                { data: 'year' },
                { data: 'company' },
                { data: 'logo', orderable: false, searchable: false },
                { data: 'actions', defaultContent: '', visible: false }
            ];
        }

		const table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            ajax: {
                url: "{{ route('clients.index') }}",
                dataFilter: function(data){
                    console.log(data);
                    var json = JSON.parse( data );
                    json.recordsTotal = json.last_page;
                    json.recordsFiltered = json.total;
        
                    return JSON.stringify( json );
                },
                data: function(data, settings){
                    const page = $('.table').DataTable().page.info().page;

                    for(let key in data.order){
                        const column = data.order[key].column;

                        data.order[key].column_name = settings.aoColumns[column].data;
                    }

                    data.page = page + 1;
                }
            },
            drawCallback: function() {
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            },
            columns: columns,
            columnDefs: [
                {
                    targets: 1,
                    render: function (data, type, row) {
                        if (data) {
                            return `<img src="${data}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%;">`;
                        }
                        return '<span class="text-muted">Sin avatar</span>';
                    }
                },
                {
                    targets: 2,
                    render: function (data, type, row) {
                        const title = data && data.length > 25 ? `${data.slice(0, 25).replace(/\s+$/, '')}...` : data;

                        return `<a href="${ `{{ route("clients.edit", ["client" => 'here']) }}`.replace('here', row.id) }" class="text-dark fw-bolder text-hover-primary fs-6">
                                    ${title}
                                </a>`;
                    }
                },
                {
                    targets: 3,
                    render: function (data, type, row) {
                        return data ? `<a href="mailto:${data}" class="text-dark text-hover-primary">${data}</a>` : '<span class="text-muted">No disponible</span>';
                    }
                },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        return data ? `<a href="tel:${data}" class="text-dark text-hover-primary">${data}</a>` : '<span class="text-muted">No disponible</span>';
                    }
                },
                {
                    targets: 6,
                    render: function (data, type, row) {
                        return data || '<span class="text-muted">No especificado</span>';
                    }
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        return data || '<span class="text-muted">Sin empresa</span>';
                    }
                },
                {
                    targets: 8,
                    render: function (data, type, row) {
                        if (data) {
                            return `<img src="${data}" alt="Logo" style="width: 40px; height: 40px;">`;
                        }
                        return '<span class="text-muted">Sin logo</span>';
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'table-actions',
                    render: function (data, type, row) {

                        let actionsHtml = ` <div class="d-flex align-center justify-content-center">
                                                @can('client_edit')
                                                <a href="{{ $edit_route }}" class="ml-2 svg-icons" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                                    <span class="mx-1">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M16.0418 3.01976L8.16183 10.8998C7.86183 11.1998 7.56183 11.7898 7.50183 12.2198L7.07183 15.2298C6.91183 16.3198 7.68183 17.0798 8.77183 16.9298L11.7818 16.4998C12.2018 16.4398 12.7918 16.1398 13.1018 15.8398L20.9818 7.95976C22.3418 6.59976 22.9818 5.01976 20.9818 3.01976C18.9818 1.01976 17.4018 1.65976 16.0418 3.01976Z" stroke="#4F4F4F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899" stroke="#4F4F4F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                                @endcan
                                                @can('client_delete')
                                                <form class="delete-form d-inline" method="POST" action="{{ $delete_route }}">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="#" class="delete-item svg-icons" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                                        <span class="mx-1">
                                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M21 5.97998C17.67 5.64998 14.32 5.47998 10.98 5.47998C9 5.47998 7.02 5.57998 5.04 5.77998L3 5.97998" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M8.5 4.97L8.72 3.66C8.88 2.71 9 2 10.69 2H13.31C15 2 15.13 2.75 15.28 3.67L15.5 4.97" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M18.8484 9.14014L18.1984 19.2101C18.0884 20.7801 17.9984 22.0001 15.2084 22.0001H8.78844C5.99844 22.0001 5.90844 20.7801 5.79844 19.2101L5.14844 9.14014" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M10.3281 16.5H13.6581" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M9.5 12.5H14.5" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </form>
                                                @endcan
                                            </div>`;

                        let actions = actionsHtml.replaceAll('id-here', row.id).replaceAll('id-user', row.id);

                        return `${actions}`;
                    },
                }
            ],
            order: [[ 0, "desc" ]]
        });

        // Filtros individuales por columna
        table.columns().every(function () {
            var that = this;
            $('input', this.header()).on('keyup change', function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        });

        // Botón limpiar filtros
        $('.btn-reset').on('click', function () {
            $('input', table.columns().header()).val('');
            table.search('').columns().search('').draw();
        });
    });
</script>
@endsection
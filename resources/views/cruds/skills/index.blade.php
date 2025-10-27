@extends('layouts.master', [
'title' => 'Skills',
'breadcrumbs' => [
    route('admin.dashboard.index') => 'Inicio',
    route('skills.index') => 'Skills',
]
])

@section('content')

<div class="container pb-8">
    <div class="card">
        <div class="card-body border-0 pt-2 pb-7">
            <div class="pt-0 table-responsive w-100">
                <table id="kt_datatable_example_1" class="table align-middle table-row-bordered fs-6" style="width:100%">
                    <thead class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                        <tr>
                            <th class="w-60px">ID</th>
                            <th class="w-300px">NOMBRE (ES)</th>
                            <th class="w-300px">NOMBRE (EN)</th>
                            @canany(['skill_edit', 'skill_delete'])
                            <th class="text-center w-100px">ACCIONES</th>
                            @endcanany
                        </tr>
                        <tr class="bg-white">
                            <th class="px-0">
                                <input type="number" min="1" class="form-control form-control-sm d-block" placeholder="ID">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm" placeholder="NOMBRE ESPAÑOL">
                            </th>
                            <th>
                                <input type="text" class="form-control form-control-sm" placeholder="NOMBRE INGLÉS"/>
                            </th>
                            @canany(['skill_edit', 'skill_delete'])
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
    $edit_route = route("skills.edit", ["skill" => 'id-here']);
    $delete_route = route("skills.destroy", ["skill" => 'id-here']);
@endphp

<script>
    $(document).ready(function () {
     
        var can = "{!!  auth()->user()->canany(['skill_edit','skill_delete']) !!}";
         
        var columns;
        if(can) {
            columns = [
                { data: 'id' },
                { data: 'name_es' },
                { data: 'name_en' },
                { data: 'actions', defaultContent: '', orderable: false }
            ];
        } else {
            columns = [
                { data: 'id' },
                { data: 'name_es' },
                { data: 'name_en' },
                { data: 'actions', defaultContent: '', visible: false }
            ];
        }

		const table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            orderCellsTop: true,
            ajax: {
                url: "{{ route('skills.index') }}",
                dataFilter: function(data){
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
                        const title = data && data.length > 25 ? `${data.slice(0, 25).replace(/\s+$/, '')}...` : data;

                        return `<a href="${ `{{ route("skills.edit", ["skill" => 'here']) }}`.replace('here', row.id) }" class="text-dark fw-bolder text-hover-primary fs-6">
                                    ${title}
                                </a>`;
                    }
                },
                {
                    targets: 2,
                    render: function (data, type, row) {
                        const title = data && data.length > 25 ? `${data.slice(0, 25).replace(/\s+$/, '')}...` : data;
                        return `<span class="text-dark fw-bolder">${title}</span>`;
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'table-actions',
                    render: function (data, type, row) {

                        let actionsHtml = ` <div class="d-flex align-center justify-content-center">
                                                @can('skill_edit')
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
                                                @can('skill_delete')
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

                        let actions = actionsHtml.replaceAll('id-here', row.id);

                        return `${actions}`;
                    },
                }
            ],
            order: [[ 0, "desc" ]],
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
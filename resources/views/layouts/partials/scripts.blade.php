{{-- Global --}}
<script src="/js/lang.js"></script>
<script src="{{ asset('/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('/js/scripts.bundle.js') }}"></script>
<script>

  // toastr.options = {
  //   "showDuration": "300000000"
  // };

  @if(session()->has('feedback'))
    @php $feedback = session()->get('feedback'); @endphp

    @if(session()->get('feedback.type') == 'toastr')
      toastr.{{ $feedback['action'] }}('{{ $feedback["message"] }}')
    @else
      swal(
            '{{ $feedback["message"] }}',
            '{{ $feedback["action"] }}'
      )
    @endif
  @endif
</script>

{{-- Quill --}}
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

{{-- Custom --}}
<script src="{{ asset('/js/custom/widgets.js') }}"></script>
<script src="{{ asset('/js/custom/modals.js') }}"></script>
<script src="{{ asset('/js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('/js/custom/modals/create-app.js') }}"></script>

{{-- File Input --}}
<script src="{{ asset('/js/vendor/piexif.min.js') }}"></script>
<script src="{{ asset('/js/vendor/sortable.min.js') }}"></script>
<script src="{{ asset('/js/vendor/fileinput.min.js') }}"></script>
<script src="{{ asset('/js/vendor/theme.min.js') }}"></script>
<script src="{{ asset('/js/vendor/fileinput.es.js') }}"></script>

{{-- Dual Listbox --}}
<script src="{{ asset('/js/vendor/jquery.bootstrap-duallistbox.min.js?v=') . env('APP_VERSION') }}"></script>

{{-- DataTables --}}
<script src="{{ asset('/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script src="{{ asset('/js/pages/crud/datatables/extensions/index.js') }}"></script>
<script>
  $.extend( true, $.fn.dataTable.defaults, {
    responsive: true,
    dom:  $(location).attr("href").indexOf('dashboard') > -1 
            ? 'Brtip'
            : '<"toolbar p-0"><"mt-5" l>rt<"d-md-flex justify-content-between align-items-end"ip>',
    lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "Todos"] ],
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords:"Cargando...",
      processing:"Procesando...",
      search:"Buscar:",
      paginate:{
        next: '<i class="fas fa-chevron-right"></i>',
        previous: '<i class="fas fa-chevron-left"></i>'
      },
      zeroRecords: "No se encontraron registros",
      emptyTable:"No hay datos por mostrar",
      info:"Mostrando _START_ a _END_ de _TOTAL_",
      infoEmpty:"Mostrando 0 a 0 de 0",
      infoFiltered:"(filtrado de _TOTAL_ resultados)"
    },
    buttons: [
			{ 
        extend: 'excelHtml5',
        className: 'export_excel btn-bg-light btn-color-muted',
        init: function(api, node, config) {
          $(node).removeClass('btn-standar')
        }
      },
      { 
        extend: 'csvHtml5',
        className: 'export_csv btn-bg-light btn-color-muted',
        init: function(api, node, config) {
          $(node).removeClass('btn-standar')
        }
      },
      { 
        extend: 'pdfHtml5',
        className: 'export_pdf btn-bg-light btn-color-muted',
        init: function(api, node, config) {
          $(node).removeClass('btn-standar')
        }
      }
		],
    fnInitComplete: function(){
      const currentPath = window.location.pathname;
      const routePermissions = {
        '/admin/roles': @json(auth()->user()->can('rol_create')),
        '/admin/users': @json(auth()->user()->can('user_create')),
        '/admin/permissions': @json(auth()->user()->can('permission_create')),
        '/admin/clients': @json(auth()->user()->can('client_create')),
        '/admin/skills': @json(auth()->user()->can('skill_create')),
        '/admin/allies': @json(auth()->user()->can('ally_create')),
      };

      const hasPermission = routePermissions[currentPath];
        
      if (hasPermission) {
        const params = new URLSearchParams(window.location.search);
        const toRoute = params.get("route");

        let route = '';
        route = window.location.pathname + '/create';

        if ($(location).attr("href").indexOf('dashboard') == -1) {
          $('#kt_datatable_example_1_wrapper > div.toolbar').html(`
            <a href='${route}' class='btn btn-primary d-flex align-center mb-5 svg-buttons'>
              <span class="mr-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 12H16" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M12 16V8" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </span>
              Agregar Nuevo
            </a>`);
        }
      }
    }
  });

  $('#export_excel').on('click', function(e) {
		e.preventDefault();
        $('.export_excel').click();
	});

	$('#export_csv').on('click', function(e) {
		e.preventDefault();
		$('.export_csv').click();
	});

	$('#export_pdf').on('click', function(e) {
		e.preventDefault();
		$('.export_pdf').click();
	});

</script>

{{-- Custom Scripts --}}
<script src="{{ asset('custom/js/main.js') }}"></script>
<script src="{{ asset('custom/js/fakit.js') }}"></script>

<!-- LOADER -->
<script>
  window.addEventListener('load', function () {
      // Ocultar el loader una vez que la página haya cargado completamente
      document.getElementById('loader').style.display = 'none';
  });
</script>

<!-- GOOGLE MAPS -->
<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "{{env('API_KEY_GOOGLE_MAPS')}}",
        v: "weekly"
    });
</script>

<script src="{{ URL::asset('build/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ URL::asset('build/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/toastify-js/src/toastify.js') }}"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

<script>
  // ========================================
  // CONFIGURACIÓN GLOBAL DE DATATABLES
  // ========================================
  
  // Manejo de errores silencioso
  $.fn.dataTable.ext.errMode = 'none';

  // Utilidad: debounce para entradas de filtros/búsquedas
  window.dtDebounce = function(fn, wait) {
    let t;
    return function() {
      const ctx = this, args = arguments;
      clearTimeout(t);
      t = setTimeout(function() {
        fn.apply(ctx, args);
      }, wait);
    }
  };

  // Configuración global de DataTables
  $.extend(true, $.fn.dataTable.defaults, {
    responsive: true,
    processing: true,
    deferRender: true,
    searchDelay: 300,
    destroy: true,
    autoWidth: false,
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
    language: {
      emptyTable: "No hay datos disponibles en la tabla",
      info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando 0 a 0 de 0 registros",
      infoFiltered: "(filtrado de _MAX_ registros totales)",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: "Cargando...",
      processing: "Procesando...",
      search: "Buscar:",
      zeroRecords: "No se encontraron registros coincidentes",
      paginate: {
        first: "Primero",
        last: "Último",
        next: "Siguiente",
        previous: "Anterior"
      }
    }
  });

  // ========================================
  // EVENTOS GLOBALES DE DATATABLES
  // ========================================

  // Agregar clase pagination-separated a todas las tablas
  $(document).on('draw.dt', function(e, settings) {
    $('.dataTables_wrapper .pagination').addClass('pagination-separated');
  });

  // Inicializar tooltips después de cada draw
  $(document).on('draw.dt', function(e, settings) {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl);
    });
  });

  // Manejo visual de "procesando"
  $(document)
    .on('preXhr.dt', function(e, settings, data) {
      $(settings.nTableWrapper).addClass('dt-loading');
    })
    .on('xhr.dt error.dt', function(e, settings, json, xhr) {
      $(settings.nTableWrapper).removeClass('dt-loading');
      if (e.type === 'error') {
        console.error('Error al cargar la tabla:', xhr?.status || 'Unknown');
      }
    });

  // Reforzar al volver del historial (bfcache)
  window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
      $('table.dataTable').each(function() {
        try {
          $(this).DataTable().draw(false);
        } catch(_) {}
      });
    }
  });

  // ========================================
  // HELPERS GLOBALES PARA MODALES
  // ========================================

  // Prevenir warnings de aria-hidden en modales
  window.preventModalFocusWarning = function(modalSelector) {
    const $modal = $(modalSelector);
    
    // Al ocultar el modal
    $modal.on('hide.bs.modal', function() {
      $(this).find(':focus').blur();
      $(':focus').blur();
    });
    
    // Al cerrar el modal completamente
    $modal.on('hidden.bs.modal', function() {
      $(this).find('form')[0]?.reset();
      $(this).find('.is-invalid').removeClass('is-invalid');
      $(this).find('.invalid-feedback').remove();
      
      if (document.activeElement && document.activeElement !== document.body) {
        document.activeElement.blur();
      }
    });
  };

  // Inicializar modales comunes
  $(document).ready(function() {
    // Aplicar prevención de warnings a modales comunes
    if ($('#showModal').length) preventModalFocusWarning('#showModal');
    if ($('#editModal').length) preventModalFocusWarning('#editModal');
  });

  // ========================================
  // SISTEMA GLOBAL DE NOTIFICACIONES TOASTIFY
  // ========================================

  // Función global para mostrar notificaciones Toastify
  window.showToast = function(message, type = 'success') {
    const styles = {
      success: {
        background: "linear-gradient(to right, #0ab39c, #0e9f6e)",
      },
      error: {
        background: "linear-gradient(to right, #f46a6a, #dc3545)",
      },
      warning: {
        background: "linear-gradient(to right, #f1b44c, #f59e0b)",
      },
      info: {
        background: "linear-gradient(to right, #299cdb, #3b82f6)",
      }
    };

    Toastify({
      text: message,
      duration: 3000,
      gravity: "top",
      position: "right",
      stopOnFocus: true,
      close: true,
      escapeMarkup: false,
      style: styles[type] || styles.success
    }).showToast();
  };

  // Manejar mensajes de feedback desde el servidor (Laravel session)
  @if(session()->has('feedback'))
    @php $feedback = session()->get('feedback'); @endphp
    
    @if(isset($feedback['type']) && $feedback['type'] == 'toastify')
      $(document).ready(function() {
        showToast('{!! $feedback["message"] !!}', '{{ $feedback["action"] ?? "success" }}');
      });
    @elseif(isset($feedback['type']) && $feedback['type'] == 'swal')
      $(document).ready(function() {
        Swal.fire({
          icon: '{{ $feedback["action"] ?? "success" }}',
          title: '{{ $feedback["title"] ?? "Notificación" }}',
          text: '{{ $feedback["message"] }}',
          timer: {{ $feedback["timer"] ?? 3000 }},
          showConfirmButton: {{ $feedback["showConfirmButton"] ?? "false" }}
        });
      });
    @endif
  @endif

  // Manejar mensajes simples de success/error
  @if(session('success'))
    $(document).ready(function() {
      showToast('{{ session("success") }}', 'success');
    });
  @endif

  @if(session('error'))
    $(document).ready(function() {
      showToast('{{ session("error") }}', 'error');
    });
  @endif

  @if(session('warning'))
    $(document).ready(function() {
      showToast('{{ session("warning") }}', 'warning');
    });
  @endif

  @if(session('info'))
    $(document).ready(function() {
      showToast('{{ session("info") }}', 'info');
    });
  @endif

  // ========================================
  // EXPORTACIÓN DE DATATABLES (LEGACY)
  // ========================================

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

<script src="{{ URL::asset('build/js/plugins.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<!-- GOOGLE MAPS -->
<script>
    (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})({
        key: "{{env('API_KEY_GOOGLE_MAPS')}}",
        v: "weekly"
    });
</script>

<!-- LOADER -->
<script>
  window.addEventListener('load', function () {
    const loader = document.getElementById('loader');
    if (loader) {
      loader.style.display = 'none';
    }
  });

  // Esperar a que Livewire esté disponible
  document.addEventListener('livewire:init', () => {
    Livewire.on('redirectTo', route => {
      window.location.href = route;
    });
  });
</script>

<!-- Custom Scripts -->
<script src="{{ asset('custom/js/main.js') }}"></script>
@yield('script')
@yield('script-bottom')

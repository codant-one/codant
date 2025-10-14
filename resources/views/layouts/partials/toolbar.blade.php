<div class="toolbar" id="kt_toolbar">
	<div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
		<div class="d-flex align-items-center py-1">			
			<a href="{{ route('admin.dashboard.index') }}" id="today" class="btn btn-ghost btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Día
            </a>
			<a href="{{ route('admin.dashboard.index', ['filter' => 'current_month']) }}" id="current_month" class="btn btn-ghost btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
				 Mes
            </a>
			<a href="{{ route('admin.dashboard.index', ['filter' => 'current_year']) }}" id="current_year" class="btn btn-ghost btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Año
            </a>
            <a href="#" id="reportrange" class="btn btn-ghost btn-sm font-weight-bold font-size-base mr-1" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <i class="fa fa-caret-down"></i>
            </a>
		</div>
	</div>
</div>


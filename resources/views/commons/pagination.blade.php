<div class="container-pagination mt-auto {{ $classes ?? '' }}">
    <ul class="pagination bg-white">
        @if ($paginator->onFirstPage())
        <li class="dt-paging-button page-item previous disabled">
            <a href="#" class="page-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        @else
        <li class="dt-paging-button page-item previous cursor-pointer">
            <a wire:click="previousPage('{{ $pageName ?? 'page' }}')" class="page-link">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li>
        @endif

        <li class="dt-paging-button page-item {{ $paginator->currentPage() == 1 ? 'active' : 'cursor-pointer' }}">
            <a wire:click="gotoPage(1, '{{ $pageName ?? 'page' }}')" class="page-link">1</a>
        </li>

        @if ($paginator->currentPage() > 4)
        <li class="dt-paging-button page-item disabled"><span class="page-link">...</span></li>
        @endif

        @for ($i = max(2, $paginator->currentPage() - 2); $i <= min($paginator->lastPage() - 1, $paginator->currentPage() + 2); $i++)
        <li class="dt-paging-button page-item {{ $paginator->currentPage() == $i ? 'active' : 'cursor-pointer' }}">
            <a wire:click="gotoPage({{$i}}, '{{ $pageName ?? 'page' }}')" class="page-link">{{ $i }}</a>
        </li>
        @endfor

        @if ($paginator->currentPage() < $paginator->lastPage() - 3)
        <li class="dt-paging-button page-item disabled"><span class="page-link">...</span></li>
         @endif

        @if ($paginator->lastPage() > 1)
        <li class="dt-paging-button page-item {{ $paginator->currentPage() == $paginator->lastPage() ? 'active' : 'cursor-pointer' }}">
            <a wire:click="gotoPage({{$paginator->lastPage()}}, '{{ $pageName ?? 'page' }}')" class="page-link">{{ $paginator->lastPage() }}</a>
        </li>
        @endif

        @if ($paginator->hasMorePages())
        <li class="dt-paging-button page-item next cursor-pointer">
            <a wire:click="nextPage('{{ $pageName ?? 'page' }}')" class="page-link">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
        @else
        <li class="dt-paging-button page-item next disabled">
            <a href="#" class="page-link">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li>
        @endif
    </ul>
</div>
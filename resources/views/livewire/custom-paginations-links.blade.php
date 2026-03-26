@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav class="d-flex justify-items-center justify-content-between">
            <div class="d-flex justify-content-end flex-fill d-sm-none">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link"><i class="icon-base ti ti-chevron-left icon-sm"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <button type="button" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"><i class="icon-base ti ti-chevron-left icon-sm"></i></button>
                        </li>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <button type="button" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled"><i class="icon-base ti ti-chevron-right icon-sm"></i></button>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true">
                            <span class="page-link" aria-hidden="true"><i class="icon-base ti ti-chevron-right icon-sm"></i></span>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
                <div>
                    <p class="small text-muted">
                        {!! __('pagination.showing') !!}
                        <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                        {!! __('pagination.to') !!}
                        <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                        {!! __('pagination.of') !!}
                        <span class="fw-semibold">{{ $paginator->total() }}</span>
                        {!! __('pagination.results') !!}
                    </p>
                </div>

                <div>
                    <ul class="pagination float-end">
                        {{-- Botón "Primero" --}}
                        {{-- <li class="page-item first {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link waves-effect" href="javascript:void(0);" 
                                wire:click="gotoPage(1, '{{$paginator->getPageName()}}')" 
                                aria-label="Primera página">
                                <i class="icon-base ti ti-chevrons-left icon-sm"></i>
                            </a>
                        </li>--}}
                
                        {{-- Botón "Anterior" --}}
                        <li class="page-item prev {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link waves-effect" href="javascript:void(0);" 
                                wire:click="previousPage('{{ $paginator->getPageName() }}')" 
                                aria-label="Página anterior">
                                <i class="icon-base ti ti-chevron-left icon-sm"></i>
                            </a>
                        </li>
                
                        {{-- Links de paginación --}}
                        @php
                            $start = max($paginator->currentPage() - 1, 1);
                            $end = min($paginator->currentPage(), $paginator->lastPage());
                        @endphp
                
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link waves-effect" href="javascript:void(0);" wire:click="gotoPage(1, '{{$paginator->getPageName()}}')">1</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif
                
                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $paginator->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link waves-effect" href="javascript:void(0);" wire:click="gotoPage({{ $i }}, '{{$paginator->getPageName()}}')">{{ $i }}</a>
                            </li>
                        @endfor
                
                        @if ($end < $paginator->lastPage())
                            @if ($end < $paginator->lastPage() - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link waves-effect" href="javascript:void(0);" wire:click="gotoPage({{ $paginator->lastPage() }}, '{{$paginator->getPageName()}}')">{{ $paginator->lastPage() }}</a>
                            </li>
                        @endif
                
                        {{-- Botón "Siguiente" --}}
                        <li class="page-item next {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link waves-effect" href="javascript:void(0);" 
                                wire:click="nextPage('{{ $paginator->getPageName() }}')" 
                                aria-label="Página siguiente">
                                <i class="icon-base ti ti-chevron-right icon-sm"></i>
                            </a>
                        </li>
                
                        {{-- Botón "Último" --}}
                        {{-- <li class="page-item last {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
                            <a class="page-link waves-effect" href="javascript:void(0);" 
                                wire:click="gotoPage({{ $paginator->lastPage() }}, '{{$paginator->getPageName()}}')" 
                                aria-label="Última página">
                                <i class="icon-base ti ti-chevrons-right icon-sm"></i>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </div>
        </nav>
    @endif
</div>
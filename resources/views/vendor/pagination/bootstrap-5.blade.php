@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center" aria-label="Pagination">
        <ul class="pagination pagination-rounded">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">&rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

<style>
    .pagination-rounded .page-item:first-child .page-link {
        border-top-left-radius: 50px;
        border-bottom-left-radius: 50px;
    }
    
    .pagination-rounded .page-item:last-child .page-link {
        border-top-right-radius: 50px;
        border-bottom-right-radius: 50px;
    }

    .pagination-rounded .page-link {
        margin: 0 3px;
        font-weight: 500;
        border-radius: 30px;
        min-width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border: none;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .page-item.active .page-link {
        background-color: #262248;
        border-color: #262248;
    }
    
    .page-link {
        color: #262248;
    }
    
    .page-link:hover {
        color: #262248;
        background-color: #eeeeee;
    }
</style> 
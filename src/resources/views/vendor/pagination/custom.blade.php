@if ($paginator->hasPages())
<nav class="pagination">
    <ul class="pagination__list">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
        <li class="pagination__item pagination__item--prev pagination__item--disabled" aria-disabled="true">
            <span class="pagination__link">◀</span>
        </li>
        @else
        <li class="pagination__item pagination__item--prev">
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination__link" rel="prev">◀</a>
        </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
        <li class="pagination__item pagination__item--dots" aria-disabled="true"><span class="pagination__link">{{ $element }}</span></li>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
        @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
        <li class="pagination__item pagination__item--number pagination__item--active"><span class="pagination__link">{{ $page }}</span></li>
        @else
        <li class="pagination__item pagination__item--number"><a href="{{ $url }}" class="pagination__link">{{ $page }}</a></li>
        @endif
        @endforeach
        @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
        <li class="pagination__item pagination__item--next">
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination__link" rel="next">▶</a>
        </li>
        @else
        <li class="pagination__item pagination__item--next pagination__item--disabled" aria-disabled="true">
            <span class="pagination__link">▶</span>
        </li>
        @endif
    </ul>
</nav>
@endif
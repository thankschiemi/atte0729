@if ($paginator->hasPages())
    <nav class="pagination">
        <ul class="pagination__list">
            {{-- 前のページのリンク --}}
            @if (!empty($prevDate))
                <li class="pagination__item">
                    <a href="{{ route('attendance.date', ['date' => $prevDate]) }}" class="pagination__link date-list__nav-button">＜</a>
                </li>
            @else
                <li class="pagination__item pagination__item--disabled">
                    <span class="pagination__link date-list__nav-button">＜</span>
                </li>
            @endif

            {{-- ページ番号のリンク --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="pagination__item pagination__item--disabled">{{ $element }}</li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="pagination__item pagination__item--active"><span class="pagination__link">{{ $page }}</span></li>
                        @else
                            <li class="pagination__item"><a href="{{ $url }}" class="pagination__link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- 次のページのリンク --}}
            @if (!empty($nextDate))
                <li class="pagination__item">
                    <a href="{{ route('attendance.date', ['date' => $nextDate]) }}" class="pagination__link date-list__nav-button">＞</a>
                </li>
            @else
                <li class="pagination__item pagination__item--disabled">
                    <span class="pagination__link date-list__nav-button">＞</span>
                </li>
            @endif
        </ul>
    </nav>
@endif


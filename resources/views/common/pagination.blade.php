<div class="event-pagination">
    {{-- Previous Page Link --}}
    <div class="pagination-left arrow">
        @if ($paginator->onFirstPage())
            <a href="#" class="disabled"><i class="fa-solid fa-chevron-left"></i></a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fa-solid fa-chevron-left"></i></a>
        @endif
    </div>

    <ul class="pagination-list">
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li><button class="disabled">{{ $element }}</button></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><button>{{ $page }}</button></li>
                    @else
                        <li><button onclick="window.location.href='{{ $url }}'">{{ $page }}</button></li>
                    @endif
                @endforeach
            @endif
        @endforeach
    </ul>

    {{-- Next Page Link --}}
    <div class="pagination-right arrow">
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fa-solid fa-chevron-right"></i></a>
        @else
            <a href="#" class="disabled"><i class="fa-solid fa-chevron-right"></i></a>
        @endif
    </div>
</div>

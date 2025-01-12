{{--
    Accessibility Improvements:
    - Added `aria-hidden="true"` to decorative elements, such as icons, ensuring they are ignored by assistive technologies.
    - Used `aria-label` on pagination controls, including page links and prev/next buttons, to provide clear and meaningful descriptions for screen readers.
    - Added `aria-disabled="true"` on elements that cannot be interacted with, improving usability for assistive technology users.
    - Added `aria-current="page"` to indicate the currently active page in the pagination structure, providing better navigation context.
--}}
@if ($paginator->hasPages())
    <ul class="pagination" aria-label="Pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true"><span class="page-link" aria-hidden="true">&laquo;</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">&laquo;</a>
            </li>
        @endif

        @if($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link" aria-hidden="true">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}" aria-label="Go to page {{ $page }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true"><span class="page-link" aria-hidden="true">&raquo;</span></li>
        @endif
    </ul>
@endif

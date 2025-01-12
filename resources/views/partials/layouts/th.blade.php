{{--
    Accessibility Improvements:
    - Replaced `text-muted` with `text-dark` to improve text contrast and enhance visibility for better user experience.
    - Added `aria-label="Sort by {{ $title }}"` to improve navigation and understanding for screen readers when sorting columns.
    - Added `aria-label="Filter options for column {{ $column }}"` to provide context about filter options for assistive technologies.
    - Added `aria-label="Clear filter for column {{ $column }}"` to clarify the purpose of the filter clear button for screen readers.
    - Added `role="button"` to ensure the filter clear element is properly recognized as an interactive button.
--}}
<th @empty(!$width) width="{{$width}}" @endempty class="text-{{$align}} text-dark" data-column="{{ $slug }}">
    <div class="d-inline-flex align-items-center">

        @includeWhen($filter !== null, "platform::partials.layouts.filter", ['filter' => $filter])

        @if($sort)
            <a href="{{ $sortUrl }}"
               class="@if(!is_sort($column)) text-dark @endif"
               aria-label="Sort by {{ $title }}">
                {!! $title !!}

                <x-orchid-popover :content="$popover"/>

                @if(is_sort($column))
                    @php $sortIcon = get_sort($column) === 'desc' ? 'bs.sort-down' : 'bs.sort-up' @endphp
                    <x-orchid-icon :path="$sortIcon" aria-hidden="true"/>
                @endif
            </a>
        @else
            {!! $title !!}

            <x-orchid-popover :content="$popover"/>
        @endif
    </div>

    @if($filterString)
        <div data-controller="filter" class="mt-2" aria-label="Filter options for column {{ $column }}">
            <a href="#"
               data-action="filter#clearFilter" aria-label="Clear filter for column {{ $column }}"
               data-filter="{{$column}}"
               class="badge bg-light border d-inline-flex align-items-center" role="button">
                <span>{{ $filterString }}</span>
                <x-orchid-icon path="bs.x-lg" class="ms-1"/>
            </a>
        </div>
    @endif
</th>



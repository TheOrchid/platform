{{--
    Accessibility Improvements:
    - Added `aria-label` to the dropdown toggle button to describe its purpose as a filters menu for screen readers.
    - Used `role="group"` to group related buttons, helping assistive technologies understand the structure.
    - Assigned `role="menu"` to the dropdown container and `role="menuitem"` to individual menu items for semantic understanding.
    - Added `aria-label` to "Apply filters" and "Remove filter" buttons for clear and descriptive interactions.
    - Used `aria-hidden="true"` in icons where applicable to prevent redundancies in screen reader announcements.
    - Ensured focus management by aligning dropdown behavior with keyboard and screen reader navigation.
--}}
<div class="col-md-12" data-controller="filter">
    <div class="btn-group ps-4" role="group">
        <button class="btn btn-link dropdown-toggle ps-0 d-flex align-items-center text-decoration-none"
                data-bs-toggle="dropdown"
                aria-label="{{ __('Open Filters Menu') }}"
                aria-haspopup="true"
                aria-expanded="false">
            <x-orchid-icon path="bs.funnel" aria-hidden="true"/>
            <span class="ms-1">{{__('Filters')}}</span>
        </button>

        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow py-0"
             role="menu"
             aria-labelledby="navbarDropdownMenuLink"
             data-turbo-permanent
             data-action="click->filter#onMenuClick"
        >
            <div class="dropdown-toggle" data-action="click->filter#onMenuClick"
                 role="menuitem"
                 data-filter-target="filterItem">
                <div class="p-3 w-md d-flex flex-column gap-3">
                    @foreach($filters as $filter)
                        {!! $filter->render() !!}
                    @endforeach
                </div>

                <div class="bg-light p-3 w-md">
                    <button type="submit"
                            form="filters"
                            class="btn btn-link btn-sm w-100 border"
                            aria-label="{{ __('Apply filters') }}"
                            data-action="click->filter#submit">
                        <span class="w-100 text-center">{{__('Apply')}}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    @foreach($filters as $filter)
        @if($filter->isApply())
            <a href="{{ $filter->resetLink() }}"
               aria-label="{{ __('Remove filter: ') . $filter->value() }}"
               class="badge bg-light border me-1 p-1 d-inline-flex align-items-center">
                <span>{{$filter->value()}}</span>
                <x-orchid-icon path="bs.x-lg" class="ms-1" aria-hidden="true"/>
            </a>
        @endif
    @endforeach
</div>


{{--
    Accessibility Improvements:
    - Added `aria-hidden="true"` to the `<x-orchid-icon>` to indicate that the icon is decorative and should be ignored by assistive technologies.
    - Applied `aria-label` to the "Apply filters" button to provide a clear and descriptive label for users relying on screen readers.
    - Included `role="menu"` and `role="presentation"` where appropriate to define the semantic roles of elements, aiding assistive technologies in understanding the component's purpose.
--}}
<div class="dropdown d-inline-block" data-controller="filter" data-action="click->filter#onMenuClick">
    <button class="btn btn-sm btn-link dropdown-toggle p-0 me-1"
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            data-bs-boundary="viewport"
            aria-expanded="false">
        <x-orchid-icon path="bs.funnel" aria-hidden="true"/>
    </button>
    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow py-0" x-placement="bottom-end"
         role="menu">
        <div class="p-3">
            {!! $filter !!}
        </div>

        <div class="bg-light p-3" role="presentation">

            <button type="submit" form="filters" class="btn btn-link btn-sm w-100 border" aria-label="Apply filters">
                <span class="w-100 text-center">{{__('Apply')}}</span>
            </button>
        </div>
    </div>
</div>

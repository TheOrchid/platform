{{--
    Accessibility Improvements:
    - Added `role="region"` and `aria-labelledby` attributes to the filter section for improved navigation and context for screen readers.
    - Provided a visually hidden label (`id="filter-section-label"`) to describe the filter section meaningfully for assistive technologies.
    - Added `role="group"` and `aria-label` to the filter actions section to group related controls and enhance clarity for screen readers.
--}}
<div class="g-0 bg-white rounded mb-3">
    <div class="row align-items-center p-4" data-controller="filter" role="region" aria-labelledby="filter-section-label">
    <span id="filter-section-label" class="visually-hidden">{{ __('Filter options') }}</span>
        @foreach ($filters as $filter)
            <div class="col-sm-auto col-md mb-3 align-self-start" style="min-width: 200px;">
                {!! $filter->render() !!}
            </div>
        @endforeach
        <div class="col-sm-auto ms-auto text-end" role="group" aria-label="{{ __('Filter actions') }}">
            <div class="btn-group" role="group">
                <button data-action="filter#clear" class="btn btn-default" aria-label="{{ __('Reset all filters') }}">
                    <x-orchid-icon class="me-1" path="bs.arrow-repeat" aria-hidden="true"/> {{ __('Reset') }}
                </button>
                <button type="submit" form="filters" class="btn btn-default" aria-label="{{ __('Apply selected filters') }}">
                    <x-orchid-icon class="me-1" path="bs.funnel" aria-hidden="true"/> {{ __('Apply') }}
                </button>
            </div>
        </div>
    </div>
</div>


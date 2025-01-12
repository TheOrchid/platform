{{--
    Accessibility Improvements:
    - Added `aria-hidden="true"` to purely decorative elements, such as icons, ensuring they are ignored by assistive technologies.
    - Added `role="alert"` to the alert container, ensuring critical information is announced immediately to assistive technologies.
--}}
@if(!\Orchid\Platform\Dashboard::assetsAreCurrent())
    <div class="alert alert-warning rounded shadow-sm mb-3 p-4" data-turbo-temporary role="alert">
        <div class="d-flex align-items-center mb-2 text-body-emphasis">
            <x-orchid-icon path="bs.exclamation-triangle" width="2em" height="2em" class="me-2" aria-hidden="true"/>
            <h4 class="mb-0 fw-light">{{ __("Complete the update.") }}</h4>
        </div>

        <p>{{ __("The published Orchid assets are not up-to-date with the installed version. To update, run:") }}</p>
        <code class="user-select-all">php artisan orchid:publish</code>
    </div>
@endif

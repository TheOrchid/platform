{{--
    Accessibility improvements:
    - Added `aria-label` to the password input field to make its purpose clear to screen readers.
    - Added `aria-label` to the toggle button to describe its function (toggle password visibility).
    - Included `aria-hidden="true"` on decorative icons to ensure they are ignored by screen readers.
--}}
@component($typeForm, get_defined_vars())

    <div data-controller="password"
         class="input-icon"
    >
        <input {{ $attributes }} data-password-target="password" aria-label="{{ __('Password input field') }}">
        <div class="input-icon-addon cursor" data-action="click->password#change" role="button" aria-label="{{ __('Toggle password visibility') }}">

            <span data-password-target="iconShow">
                <x-orchid-icon path="bs.eye" class="small me-2" aria-hidden="true"/>
            </span>

            <span data-password-target="iconLock" class="none">
                <x-orchid-icon path="bs.eye-slash" class="small me-2" aria-hidden="true"/>
            </span>
        </div>
    </div>

@endcomponent

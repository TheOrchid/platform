{{--
    Accessibility Improvements:
    - Added `role="menuitem"` to signify that the checkbox is part of a dropdown menu structure, improving navigation for screen readers.
    - Added `role="checkbox"` to define the element as a checkbox for assistive technologies.
    - Added `aria-checked="true"` to indicate the checkbox's current state to screen readers.
--}}
<div class="dropdown-item" role="menuitem">
    <div class="form-check h-auto w-100 d-flex align-items-center ps-0">
        <input type="checkbox"
               role="checkbox"
               aria-checked="true"
               checked
               class="custom-control-input"
               id="{{ $slug }}"
               form="table-columns-select"
               data-action="table#toggleColumn"
               data-default-hidden="{{ $defaultHidden }}"
               data-column="{{ $slug }}"
        >
        <label class="form-check-label d-block w-100 cursor ms-2 user-select-none" for="{{ $slug }}">
            {{ $title }}
        </label>
    </div>
</div>

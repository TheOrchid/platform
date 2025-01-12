{{--
    Accessibility Improvements:
     - Added aria-describedby to reference the description of the popover.
     - Added aria-hidden on the orchid icon to hide it from screen readers since it is decorative.
--}}
<sup class="text-body-emphasis"
     role="button"
     data-controller="popover"
     data-bs-container="body"
     data-bs-toggle="popover"
     tabindex="0"
     data-bs-trigger="hover focus"
     data-bs-placement="{{ $placement }}"
     data-bs-delay-show="300"
     data-bs-delay-hide="200"
     data-bs-content="{{ $content }}"
     aria-label="{{ __('More information') }}"
     aria-describedby="popover-description">
    <x-orchid-icon path="bs.question-lg" width="1em" height="1em" aria-hidden="true"/>
</sup>
<span id="popover-description" class="visually-hidden">
    {{ __('This button provides additional information in a popover.') }}
</span>

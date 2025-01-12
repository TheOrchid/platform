{{--
    Accessibility Improvements:
     - Added aria-label to provide a descriptive name for the link.
     - Added aria-hidden to the icon to hide it from screen readers, as it is decorative and does not convey meaningful content.
 --}}
@component($typeForm, get_defined_vars())
    <a
        data-turbo="{{ var_export($turbo) }}"
        aria-label="{{ $name ? __('Navigate to: ' . $name) : __('Navigate') }}"
        {{ $attributes }}
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible" aria-hidden="true"/>
        @endisset

        {{ $name ?? '' }}
    </a>
@endcomponent

{{--
    Accessibility Improvements:
     - Added aria-label to provide a descriptive name for the button.
     - Added aria-hidden to the icon to hide it from screen readers, as it is decorative and does not convey meaningful content.
 --}}
@component($typeForm, get_defined_vars())
    <button
            data-controller="button"
            data-turbo="{{ var_export($turbo) }}"
            @empty(!$confirm)
                data-action="button#confirm"
                data-button-confirm="{{ $confirm }}"
            @endempty
            aria-label="{{ $name ? __('Button: ' . $name) : __('Button') }}"
            {{ $attributes }}>

        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible" aria-hidden="true"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent

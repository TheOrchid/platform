{{--
    Accessibility Improvements:
     - Added aria-label to provide descriptive names for interactive elements, ensuring better screen reader compatibility.
     - Added aria-hidden to icons to hide decorative elements from screen readers since they do not convey meaningful content.
--}}
@component($typeForm, get_defined_vars())
    <button type="button"
            {{ $attributes }}
            data-controller="modal-toggle"
            data-action="click->modal-toggle#targetModal"
            data-modal-toggle-open-value="{{ var_export($open) }}"
            data-modal-toggle-title-value="{{ $modalTitle ?? $title ??  '' }}"
            data-modal-toggle-key-value="{{ $modal ?? '' }}"
            data-modal-toggle-action-value="{{ $action }}"

            @if(!empty($parameters))
                data-modal-toggle-parameters-value='@json($parameters)'
            @endif
            aria-label="{{ $name ?? $modalTitle ?? $title ?? __('Open modal') }}"
    >

        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible" aria-hidden="true"/>
        @endisset

        {{ $name ?? '' }}
    </button>
@endcomponent

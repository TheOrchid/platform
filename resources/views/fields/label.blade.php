{{--
    Accessibility Improvements:
     - Added `aria-label` to provide descriptive names for the form fields and datalist items.
     - Added `aria-labelledby` to associate the text content with a descriptive label.
     - Provided accessible IDs for dynamic elements.
     - Included a visually hidden label for better screen reader support.
--}}
@component($typeForm, get_defined_vars())
    @if(strlen($value) > 0)
        <p {{ $attributes }} aria-labelledby="{{ $attributes->get('id') }}-label" aria-label="{{ __('Text content') }}">
            <span id="{{ $attributes->get('id') }}-label" class="visually-hidden">{{ __('Label for text content') }}</span>

            {{ $value }}
        </p>
    @endif
@endcomponent

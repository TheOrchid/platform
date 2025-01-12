{{--
    Accessibility improvements:
     - Added `role="application"` to the outer container to describe it as a functional widget for assistive technologies.
     - Included `aria-labelledby` to associate the `role="region"` div with a hidden label for better navigation.
     - Updated `aria-label` with more descriptive instructions for screen reader users.
     - Added a `visually-hidden` label for enhanced clarity for assistive technologies.
--}}
@component($typeForm, get_defined_vars())
    <div
        id="code-editor" data-controller="code"
        data-code-language="{{$language}}"
        data-code-line-numbers="{{$lineNumbers}}"
        data-code-default-Theme="{{$defaultTheme}}"
        aria-label="{{ __('Code editor. Use arrow keys for navigation. Esc to exit.') }}"
        tabindex="0" role="application" >

        <div class="code border position-relative w-100" style="min-height: {{ $attributes['height'] }}" role="region" aria-labelledby="code-editor-label"></div>
        <input type="hidden" {{ $attributes }}>
    </div>
    <span id="code-editor-label" class="visually-hidden">{{ __('Code editor container') }}</span>
@endcomponent

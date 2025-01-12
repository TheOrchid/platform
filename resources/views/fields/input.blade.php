{{--
    Accessibility Improvements:
     - Added `aria-label` to provide descriptive names for the form fields and datalist items.
     - Added `aria-describedby` to link the input field to a description for better context.
     - Provided accessible IDs for the input and datalist elements.
     - Included a visually hidden description (`aria-describedby`) for accessibility enhancements.
     - Associated `<input>` and `<datalist>` with `list`, ensuring a direct link between the field and the suggestions.
--}}

@component($typeForm, get_defined_vars())
    <div data-controller="input"
         data-input-mask="{{$mask ?? ''}}"
         aria-label="{{ __('Input field with suggestions') }}"
         aria-describedby="datalist-description-{{ $name }}"
    >
        <input
                id="input-{{ $name }}"
                {{ $attributes }}
                @isset($datalist) list="datalist-{{ $name }}" @endisset
        >
    </div>

    @empty(!$datalist)
        <datalist id="datalist-{{$name}}">
            @foreach($datalist as $item)
                <option value="{{ $item }}" aria-label="{{ $item }}"></option>
            @endforeach
        </datalist>
    @endempty
    <span id="datalist-description-{{ $name }}" class="visually-hidden">
        {{ __('Suggestions available for input field') }}
    </span>
@endcomponent

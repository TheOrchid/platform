{{--
    Accessibility improvements:
    - Added `role="switch"` to the `<input>` element to indicate that it behaves as a toggle switch, improving clarity for assistive technologies.
    - Used `aria-checked` attribute to explicitly define the state of the switch (`true` or `false`) for screen readers.
    - Ensured each `<input>` has an associated `<label>` to provide a clear description and context for users, improving usability and accessibility.
    - Added `aria-label="{{$placeholder ?? ''}}"` to provide a concise, accessible name for the toggle switch.
    - Added `aria-describedby="description-{{$id}}"` to ensure additional context or information is conveyed by referencing an accessible description.
--}}
@component($typeForm, get_defined_vars())
    @isset($sendTrueOrFalse)
        <input hidden name="{{$attributes['name']}}" value="{{$attributes['novalue']}}" aria-hidden="true">
        <div class="form-check form-switch">
            <input value="{{$attributes['yesvalue']}}" aria-label="{{$placeholder ?? ''}}" aria-describedby="description-{{$id}}"
                   {{ $attributes }}
                   role="switch"
                   aria-checked="{{ isset($attributes['value']) && $attributes['value'] ? 'true' : 'false' }}"
                   @if(isset($attributes['value']) && $attributes['value']) checked @endif
                   id="{{$id}}"
            >
            <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
            <span id="description-{{$id}}" class="sr-only">{{$description ?? ''}}</span>
        </div>
    @else
        <div class="form-check form-switch">
            <input {{ $attributes }} aria-label="{{$placeholder ?? ''}}" aria-describedby="description-{{$id}}"
                   role="switch"
                   aria-checked="{{ isset($attributes['value']) && $attributes['value'] ? 'true' : 'false' }}"
                   @if(isset($attributes['value']) && $attributes['value']) checked @endif
            id="{{$id}}"
            >
            <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
            <span id="description-{{$id}}" class="sr-only">{{$description ?? ''}}</span>
        </div>
    @endisset
@endcomponent

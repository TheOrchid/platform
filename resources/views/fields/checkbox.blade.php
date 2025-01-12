{{--
    Accessibility improvements:
     - Added `role="group"` to the container div to ensure assistive technologies correctly identify the group of related checkboxes.
     - Utilized `aria-labelledby` to associate the input fields with their respective labels, improving clarity for screen readers.
--}}
@component($typeForm, get_defined_vars())
    <div data-controller="checkbox" role="group"
         data-checkbox-indeterminate="{{$indeterminate}}">
        @isset($sendTrueOrFalse)
            <input hidden name="{{$attributes['name']}}" value="{{$attributes['novalue']}}">
            <div class="form-check">
                <input value="{{$attributes['yesvalue']}}"
                       {{ $attributes }}
                       aria-labelledby="label-{{$id}}"
                       @if(isset($attributes['value']) && $attributes['value']) checked @endif
                >
                <label class="form-check-label" for="{{$id}}" id="label-{{$id}}">{{$placeholder ?? ''}}</label>
            </div>
        @else
            <div class="form-check">
                <input {{ $attributes }}
                       aria-labelledby="label-{{$id}}"
                       @if(isset($attributes['value']) && $attributes['value'] && (!isset($attributes['checked']) || $attributes['checked'] !== false)) checked @endif
                >
                <label class="form-check-label" for="{{$id}}">{{$placeholder ?? ''}}</label>
            </div>
        @endisset
    </div>
@endcomponent

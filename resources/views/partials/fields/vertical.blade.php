{{--
    Accessibility Improvements:
    - Added `role="group"` to the `<div>` container for grouping related form elements to enhance assistive technology navigation.
    - Applied `aria-labelledby` to associate the group with the corresponding `<label>` text for context.
    - Added `aria-live="assertive"` to error messages (`invalid-feedback`) to ensure dynamic error handling is announced by screen readers.
    - Included `aria-label="Additional information"` for the popover to help assistive technologies interpret its purpose.
    - Added `role="alert"` to error message containers to ensure critical feedback is communicated immediately to assistive technologies.
--}}
<div class="form-group" role="group" aria-labelledby="{{$id}}">
    @isset($title)
        <label for="{{$id}}" class="form-label" id="{{$id}}">{{$title}}
            @if(isset($attributes['required']) && $attributes['required'])
                <sup class="text-danger">*</sup>
            @endif

            <x-orchid-popover :content="$popover ?? ''" aria-label="Additional information"/>
        </label>
    @endisset

    {{$slot}}

    @php
        // Backport for consistent error handling behavior between Laravel 10 and 11.
        // This implementation will be modified in a future major version.

        // Retrieve all errors from the $errors object and convert them into a collection
        $allErrors = collect($errors->all());

        // Check if there is a 'default' error key in the collection of errors
        if ($allErrors->has('default')) {
            // If a 'default' error exists, assign it to the $errors variable
            $errors = $allErrors->get('default');
        }
    @endphp

    @if($errors->has($oldName))
        <div class="invalid-feedback d-block" role="alert" aria-live="assertive">
            <small role="alert">{{$errors->first($oldName)}}</small>
        </div>
    @elseif(isset($help))
        <small class="form-text text-muted">{!!$help!!}</small>
    @endif
</div>

@isset($hr)
    <div class="line line-dashed border-bottom my-3"></div>
@endisset

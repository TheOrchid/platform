{{--
    Accessibility Improvements:
    - Added `aria-label` to the `<label>` elements to provide descriptive labels for screen readers.
    - Added `role="alert"` to error messages to ensure immediate recognition by assistive technologies.
    - Added `role="note"` to descriptive help text to effectively distinguish guidance content.
--}}
<div class="form-group row row-cols-sm-2 align-items-stretch">
    @isset($title)
        <label for="{{$id}}" class="col-sm-3 text-wrap form-label" aria-label="{{$title}}">
            {{$title}}

            <x-orchid-popover :content="$popover ?? ''"/>

            @if(isset($attributes['required']) && $attributes['required'])
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endisset

    <div class="col col-md-8">
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
            <div class="invalid-feedback d-block" role="alert">
                <small>{{$errors->first($oldName)}}</small>
            </div>
        @elseif(isset($help))
            <small class="form-text text-muted" role="note">{!!$help!!}</small>
        @endif
    </div>
</div>

@isset($hr)
    <div class="line line-dashed border-bottom my-3"></div>
@endisset

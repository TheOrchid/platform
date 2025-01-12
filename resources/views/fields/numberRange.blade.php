{{--
    Accessibility improvements:
    - Added `<label>` elements with the `visually-hidden` class to associate the input fields with labels.
    - Added `aria-describedby` attributes to provide better context for screen reader users.
    - Added `<span>` elements with hidden descriptions to give more detailed information about the fields to screen readers.
--}}
@component($typeForm, get_defined_vars())
    <div class="row">
        <div class="col-md-6 pe-1">
            <div class="form-group">
                <label for="min_{{ \Illuminate\Support\Str::slug($attributes['name']) }}" class="visually-hidden">
                    {{ __('Minimum') }}
                </label>
                <input type="{{ $attributes['type'] }}"
                       name="{{ $attributes['name'] }}[min]"
                       id='min_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['min'] ?? null }}"
                       placeholder="{{ __('Minimum') }}"
                       aria-describedby="min-description"
                       {{ $attributes }}
                       >
                <span id="min-description" class="visually-hidden">{{ __('Enter the minimum value') }}</span>
            </div>
        </div>

        <div class="col-md-6 ps-1">
            <div class="form-group">
                <label for="max_{{ \Illuminate\Support\Str::slug($attributes['name']) }}" class="visually-hidden">
                    {{ __('Maximum') }}
                </label>
                <input type="{{ $attributes['type'] }}"
                       name="{{ $attributes['name'] }}[max]"
                       id='max_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['max'] ?? null }}"
                       placeholder="{{ __('Maximum') }}"
                       aria-describedby="max-description"
                       {{ $attributes }}
                       >
                <span id="max-description" class="visually-hidden">{{ __('Enter the maximum value') }}</span>
            </div>
        </div>
    </div>
@endcomponent

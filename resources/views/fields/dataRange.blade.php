{{--
    Accessibility Improvements:
    - Added `aria-labelledby` and `aria-describedby` for better screen reader navigation and context.
    - Added visually hidden labels to associate inputs with their purposes for accessibility.
    - Added `aria-label` to provide clear names for inputs for assistive technologies.
--}}
@component($typeForm, get_defined_vars())
    <div class="row" data-controller="datetime"
         data-datetime-allow-input="true"
         data-datetime-range="#end_{{ $attributes['id'] }}"
         {{ $dataAttributes }}>
        <div class="col-md-6 pe-auto pe-md-1">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[start]"
                       id='start_{{ $attributes['id'] }}'
                       data-datetime-target="instance"
                       value="{{ $value['start'] ?? null }}"
                       class="form-control"
                       aria-labelledby="start_label_{{ $attributes['id'] }}"
                       aria-describedby="start_description_{{ $attributes['id'] }}">

                       id="start_{{ $attributes['id'] }}"
                <label id="start_label_{{ $attributes['id'] }}"
                       class="visually-hidden">
                    {{ __('Start Date and Time') }}
                </label>
                <span id="start_description_{{ $attributes['id'] }}"
                      class="visually-hidden">
                    {{ __('Enter the start date and time for the event') }}
                </span>
                       value="{{ $value['start'] ?? null }}"
                       class="form-control"
                       aria-label="{{ __('Start date and time') }}">
            </div>
        </div>

        <div class="col-md-6 ps-auto ps-md-1">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[end]"
                       data-datetime-target="instance"
                       id="end_{{ $attributes['id'] }}"
                       value="{{ $value['end'] ?? null }}"
                       class="form-control"
                       aria-labelledby="end_label_{{ $attributes['id'] }}"
                       aria-describedby="end_description_{{ $attributes['id'] }}">

                       id="end_{{ $attributes['id'] }}"
                <label id="end_label_{{ $attributes['id'] }}"
                       class="visually-hidden">
                    {{ __('End Date and Time') }}
                </label>
                <span id="end_description_{{ $attributes['id'] }}"
                      class="visually-hidden">
                    {{ __('Enter the end date and time for the event') }}
                </span>
                       value="{{ $value['end'] ?? null }}"
                       class="form-control"
                       aria-label="{{ __('End date and time') }}">
            </div>
        </div>
    </div>
@endcomponent

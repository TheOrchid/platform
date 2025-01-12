{{--
    Accessibility Improvements:
     - Added `aria-describedby` to describe the input and provide contextual information for screen readers.
     - Improved hidden elements using `visually-hidden-focusable` to make them accessible when focused, enhancing keyboard navigation.
     - Added `aria-label` to provide clear names for inputs for assistive technologies.
     - Used `aria-hidden="true"` to hide decorative icons from assistive technologies.
--}}
@component($typeForm, get_defined_vars())
    <div
        data-controller="datetime"
         class="input-group"
        {{ $dataAttributes }}
        aria-label="{{ __('Date and time input') }}">
        <input type="text"
               placeholder="{{$placeholder ?? ''}}"
               aria-describedby="datetime-description"
               {{ $attributes }}
               autocomplete="off"
               data-datetime-target="instance"
               aria-label="{{ __('Date and time picker') }}"
        >
        <div id="datetime-description" class="visually-hidden">
            {{ __('Use this field to enter or pick a date and time. Clear or preset options are available.') }}
        </div>
        @if(true === $allowEmpty)
            <div class="input-group-append bg-white">
                <a class="input-group-text h-100 text-muted visually-hidden-focusable"
                   title="clear"
                   data-action="click->datetime#clear"
                   aria-label="{{ __('Clear selected date and time') }}">
                        <x-orchid-icon path="bs.x-lg" class="m-0 p-0" aria-hidden="true"/>
                    </a>
                </div>
            @endif

        @foreach($quickDates as $name => $value)
            <label class="btn btn-default visually-hidden-focusable"
                   data-action="click->datetime#setValue"
                   data-value="{{ $value }}"
                   aria-label="{{ __('Quick select date: ') . $name }}">
                {{ $name }}
            </label>
        @endforeach
        </div>
@endcomponent





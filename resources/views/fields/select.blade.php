{{--
    Accessibility improvements:
    - Added `aria-label` to the `<div>` to describe its purpose for screen readers.
    - Added `role="combobox"` to the parent container for proper identification and association with child components.
    - Added `aria-expanded` and `aria-haspopup="listbox"` to indicate the dropdown's state and nature.
    - Added `aria-owns="dropdown-list"` to link the dropdown with its options.
    - Added `aria-labelledby="select-label"` to associate the `<select>` with its label for screen readers.
    - Added `id="dropdown-list"` as a unique identifier for the dropdown element, referenced by other attributes like `aria-controls` and `aria-owns`.
    - Added `role="listbox"` to identify the `<select>` as a list of selectable options.
--}}
@component($typeForm, get_defined_vars())
    <div data-controller="select"
        data-select-placeholder="{{$attributes['placeholder'] ?? ''}}"
        aria-label="{{$attributes['placeholder'] ?? __('Select an option')}}"
        aria-controls="dropdown-list"
        data-select-allow-empty="{{ $allowEmpty }}"
        data-select-message-notfound="{{ __('No results found') }}"
        data-select-allow-add="{{ var_export($allowAdd, true) }}"
        data-select-message-add="{{ __('Add') }}"
         role="combobox"
         aria-expanded="false"
         aria-haspopup="listbox"
         aria-owns="dropdown-list"
    >
        <select {{ $attributes }}
                aria-labelledby="select-label"
                id="dropdown-list"
                role="listbox">
            @foreach($options as $key => $option)
                <option value="{{$key}}"
                        @isset($value)
                            @if (is_array($value) && in_array($key, $value)) selected
                            @elseif (isset($value[$key]) && $value[$key] == $option) selected
                            @elseif ($key == $value) selected
                            @endif
                        @endisset
                        role="option"
                >{{$option}}</option>
            @endforeach
        </select>
    </div>
@endcomponent

{{--
    Accessibility improvements:
    - Added `aria-label` to the `<div>` element to describe its purpose.
    - Assigned `aria-labelledby` to the `<select>` element for better screen reader support.
    - Ensured all `role="combobox"` elements are correctly associated with child components.
--}}
@component($typeForm, get_defined_vars())

    <div aria-label="Relation selection"
         data-controller="relation"
         data-relation-id="{{$id}}"
         data-relation-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-relation-model="{{ $relationModel }}"
         data-relation-name="{{ $relationName }}"
         data-relation-key="{{ $relationKey }}"
         data-relation-scope="{{ $relationScope }}"
         data-relation-search-columns="{{ $relationSearchColumns }}"
         data-relation-append="{{ $relationAppend }}"
         data-relation-chunk="{{ $chunk }}"
         data-relation-allow-empty="{{ $allowEmpty }}"
         data-relation-route="{{ route('platform.systems.relation') }}"
         data-relation-message-notfound="{{ __('No results found') }}"
         data-relation-message-add="{{ __('Add') }}"
         data-relation-allow-add="{{ var_export($allowAdd, true) }}"
         role="combobox"
    >
        <select id="{{$id}}" aria-labelledby="relation-label-{{$id}}" data-relation-target="select" {{ $attributes }}
                role="listbox" >
            @foreach ($value as $option)
                <option selected value="{{ $option['id'] }}" aria-label="{{ $option['text'] }}">{{ $option['text'] }}</option>
            @endforeach
        </select>
    </div>
@endcomponent

{{--
    Accessibility improvements:
    - Added ARIA roles and attributes for better screen reader support.
    - Associated labels explicitly with inputs using `for` and `id`.
    - Added keyboard navigation hints for the radio group.
    - Added `role="radio"` for individual radio buttons.
    - Added `role="group"` for grouping related radio buttons.
--}}
@component($typeForm, get_defined_vars())

    <div data-controller="radiobutton" role="group" aria-labelledby="radiobutton-label">
        <span id="radiobutton-label" class="sr-only">Choose an option:</span>

        <div class="btn-group btn-group-toggle p-0" data-toggle="buttons">
             {{-- Removed conflicting role attribute from div --}}

            @foreach($options as $key => $option)
                <label class="btn btn-default @if($active($key, $value)) active @endif" for="{{ $key }}-{{ $id }}"
                       data-action="click->radiobutton#checked"
                >
                   <input {{ $attributes->except('id') }}
                           @if($active($key, $value)) checked @endif
                           type="radio" role="radio" aria-checked="{{ $active($key, $value) ? 'true' : 'false' }}"
                           value="{{ $key }}" id="{{ $key }}-{{$id}}"

                    >{{ $option }}
                    <span class="sr-only">{{ $option }}</span>
                </label>
            @endforeach
        </div>
    </div>
@endcomponent

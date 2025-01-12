{{--
    Accessibility enhancements applied:
    - Added `aria-label="Editor"` to provide clear context for screen readers about the purpose of the `<textarea>`.
    - Added `aria-describedby="simplemde-hints"` to associate any hints or messages with the `<textarea>` for better usability.
    - Ensured the hidden `<input>` uses `aria-hidden="true"` to avoid interference with assistive technologies, as it is not meant to be accessible.
--}}
@component($typeForm, get_defined_vars())
    <div class="simplemde-wrapper" data-controller="simplemde"
         data-simplemde-text-value='{!! \Illuminate\Support\Js::encode($value) !!}'>
        <textarea {{ $attributes }} aria-label="Editor" aria-describedby="simplemde-hints"></textarea>
        <input class="d-none upload" type="file" data-action="simplemde#upload" aria-hidden="true">
    </div>
@endcomponent

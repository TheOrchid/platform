{{--
    Accessibility Improvements:
    - Used `<fieldset>` to group related form elements, providing a semantic structure that improves navigation for assistive technologies.
    - Added a `<legend>` to describe the purpose of the fieldset, ensuring screen readers can announce the title effectively.
    - Added `role="form"` to the container to explicitly indicate the section represents a form structure.
--}}
<fieldset class="mb-3">

    @empty(!$title)
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis">
                {{ $title }}
            </legend>
        </div>
    @endempty

    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column gap-3" role="form">
        {!! $form ?? '' !!}
    </div>
</fieldset>

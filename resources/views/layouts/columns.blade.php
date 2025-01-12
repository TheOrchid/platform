{{--
    Accessibility Improvements:
    - Used `role="group"` with appropriate `aria-label` attributes to define logical grouping of form elements, enhancing navigation for assistive technologies.
    - Applied `role="presentation"` to decorative containers, ensuring they are ignored by screen readers.
--}}
<div class="row g-3" role="group" aria-label="Form Group">
    @foreach($manyForms as $key => $column)
        <div class="col-md" role="group" aria-label="Column Group">
            @foreach($column as $item)
                <div role="presentation">{!! $item ?? '' !!}</div>
            @endforeach
        </div>
    @endforeach
</div>

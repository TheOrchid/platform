{{--
    Accessibility Improvements:
    - Defined `role="list"` on the `<dl>` element to communicate its structure as a list to screen readers.
    - Added `role="term"` to `<dt>` elements for explicitly defining terms within the list, improving screen reader usability.
--}}
<fieldset class="mb-3">

    @empty(!$title)
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis mt-2 mx-2">
                {{ $title }}
            </legend>
        </div>
    @endempty

    <dl class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column" role="list">
        @foreach($columns as $column)
            <div class="d2-grid py-3 {{ $loop->first ? '' : 'border-top' }}">
                <dt class="text-muted fw-normal me-3" role="term">
                    {!! $column->buildDt($repository) !!}
                </dt>
                <dd class="text-body-emphasis">
                    {!! $column->buildDd($repository) !!}
                </dd>
            </div>
        @endforeach
    </dl>
</fieldset>

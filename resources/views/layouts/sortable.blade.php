{{--
    Accessibility Improvements:
    - Used `<fieldset>` and `<legend>` for grouping and describing the content when `$title` is present, ensuring semantic meaning for assistive technologies.
    - Assigned `role="list"` to the ordered list (`<ol>`) to explicitly define its purpose for screen readers and other assistive devices.
    - Each list item is marked with `role="listitem"`, ensuring each entry is recognized as part of the list structure.
    - Used `aria-hidden="true"` for icons purely used for visual decoration to prevent unnecessary announcements by screen readers.
    - Added `aria-live="polite"` for dynamic content like block headers to be announced in a non-intrusive manner if updated.
    - Added `role="heading"` to ensure assistive technologies recognize this as a heading.
    - Set `aria-level="3"` for proper hierarchical navigation, improving screen reader accessibility, especially for important messages like "not found.
--}}
@empty(!$title)
    <fieldset>
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis mt-2 mx-2">
                {{ $title }}
            </legend>
        </div>
    </fieldset>
@endempty

<div class="mb-3 rounded shadow-sm overflow-hidden">
    @if($rows->isNotEmpty())
        <ol
                role="list"
                data-controller="sortable"
                data-sortable-selector-value=".reorder-handle"
                data-sortable-model-value="{{ get_class($rows->first()) }}"
                data-sortable-action-value="{{ route('platform.systems.sorting') }}"
                data-sortable-success-message-value="{{ $successSortMessage }}"
                data-sortable-failure-message-value="{{ $failureSortMessage }}"
                class="list-group">

            @foreach($rows as $model)
                <li
                        data-model-id="{{ $model->getKey() }}"
                        class="reorder-handle list-group-item d-flex justify-content-between align-items-center px-4 py-3 list-group-item-action"
                        role="listitem">
                    <div class="me-4" aria-hidden="true">
                        <x-orchid-icon path="bs.arrow-down-up" class="cursor-move" aria-hidden="true"/>
                    </div>

                    @foreach($columns as $column)
                        <div class="{{ $loop->first ? 'me-auto' : 'ms-3' }}">
                            @if($showBlockHeaders)
                                <div class="text-muted fw-normal" aria-live="polite">
                                    {!! $column->buildDt($model) !!}
                                </div>
                            @endif

                            {!! $column->buildDd($model) !!}
                        </div>
                    @endforeach
                </li>
            @endforeach
        </ol>
    @else
        <div class="d-md-flex align-items-center px-md-0 px-2 pt-4 pb-5 w-100 text-md-start text-center">
            @isset($iconNotFound)
                <div class="col-auto mx-md-4 mb-3 mb-md-0" aria-hidden="true">
                    <x-orchid-icon :path="$iconNotFound" class="block h1" aria-hidden="true"/>
                </div>
            @endisset

            <div>
                <h3 class="fw-light" role="heading" aria-level="3">
                    {!!  $textNotFound !!}
                </h3>

                {!! $subNotFound !!}
            </div>
        </div>
    @endif
</div>

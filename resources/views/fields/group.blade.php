{{--
    Accessibility Improvements:
     - Added `aria-label` to provide descriptive names for the form fields group.
     - Added `role="group"` to the container div to help assistive technologies interpret it as a group of related form elements.
--}}

<div class="d-flex flex-column grid d-md-grid form-group {{ $align }}"
    @style([
        '--bs-columns: '.count($group),
        'grid-template-columns: '. $widthColumns => $widthColumns !== null,
    ])
     role="group"
     aria-label="{{ __('Form fields group') }}">
    @foreach($group as $field)
        <div class="{{ $class }}
                    {{ $loop->first && $itemToEnd ? 'ms-auto': '' }}
            "
             aria-label="{{ __('Grouped field') }}">
            {!! $field !!}
        </div>
    @endforeach
</div>

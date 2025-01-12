{{--
    Accessibility Improvements:
    - The `role="group"` and `aria-label="Many forms"` on the parent container provide semantic meaning, grouping related elements together for assistive technologies.
    - Added `aria-label` to interactive elements, such as links, to provide clear and meaningful descriptions for assistive technologies.
--}}
<div class="row g-3" role="group" aria-label="Many forms">
    @foreach($manyForms as $key => $column)
        <div @class([
            'col-md',
            $columnClass[0] .' order-md-first' => $loop->index % 2 == 0,
            $columnClass[1] . ' order-md-last' => $loop->index % 2 != 0,
            'order-first' => $reverseOnPhone && $loop->index % 2 != 0
        ])>
            @foreach($column as $item)
                {!! $item ?? '' !!}
            @endforeach
        </div>
    @endforeach
</div>

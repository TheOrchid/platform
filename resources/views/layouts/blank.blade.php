{{--
    Accessibility Improvements:
    - Added `role="region"` to define landmarks for better navigation and context for assistive technologies.
--}}
@foreach($manyForms as $key => $column)
    @foreach(\Illuminate\Support\Arr::wrap($column) as $item)
        <div role="region">
            {!! $item ?? '' !!}
        </div>
    @endforeach
@endforeach

{{--
    Accessibility Improvements:
    - Added `aria-label` and `aria-labelledby` attributes to interactive and dynamic elements, such as links and table components, for better assistive technologies support.
    - Added a 'Skip to main content' interactive link to facilitate quick navigation for screen readers and keyboard users.
    - Added `aria-hidden="true"` to purely decorative elements, such as icons, ensuring they are ignored by assistive technologies.
    - Added `role="region"` to define the main container element as a landmark region, providing better navigation landmarks for screen readers.
    - Added `role="rowgroup"` to the table `<thead>` and `<tbody>` elements to explicitly define their roles in the table structure for assistive technologies.
    - Added `role="columnheader"` to `<th>` elements to indicate they are headers for columns, improving understanding and navigation in data tables.
    - Added `role="cell"` to `<td>` elements to indicate these are individual table data cells, enhancing table accessibility context.
--}}
<a href="#main" class="skip" aria-label="Skip to main content">Skip to main content</a>
@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-body-emphasis mt-2 mx-2">
                    {{ $title }}
                </legend>
            </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3 overflow-hidden"
     data-controller="table"
     data-table-slug="{{$slug}}"
     role="region" aria-labelledby="table-title">

    <div class="table-responsive">
        <table @class([
                    'table',
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>

            @if($showHeader)
                <thead role="rowgroup">
                <tr>
                    @foreach($columns as $column)
                        <th scope="col" role="columnheader">
                            {!! $column->buildTh() !!}
                        </th>
                    @endforeach
                </tr>
                </thead>
            @endif

            <tbody role="rowgroup">

            @foreach($rows as $source)
                <tr>
                    @foreach($columns as $column)
                        <td role="cell">
                            {!! $column->buildTd($source, $loop->parent) !!}
                        </td>
                    @endforeach
                </tr>
            @endforeach

            @if($total->isNotEmpty() && $rows->isNotEmpty())
                <tr>
                    @foreach($total as $column)
                        <td role="cell">
                            {!! $column->buildTd($repository, $loop) !!}
                        </td>
                    @endforeach
                </tr>
            @endif

            </tbody>
        </table>
    </div>

    @if($rows->isEmpty())
        <div class="d-md-flex align-items-center px-md-0 px-2 pt-4 pb-5 w-100 text-md-start text-center">

            @isset($iconNotFound)
                <div class="col-auto mx-md-4 mb-3 mb-md-0">
                    <x-orchid-icon :path="$iconNotFound" class="block h1" aria-hidden="true"/>
                </div>
            @endisset

            <div>
                <h3 class="fw-light">
                    {!!  $textNotFound !!}
                </h3>

                 {!! $subNotFound !!}
            </div>
        </div>
    @else

        @include('platform::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns,
                'onEachSide' => $onEachSide,
        ])

    @endif
</div>



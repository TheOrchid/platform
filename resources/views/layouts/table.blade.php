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
>

    <div class="table-responsive">
        <table @class([
                    'table',
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>

            @if($showHeader)
                <thead>
                    <tr>
                        @foreach($columns as $column)
                            {!! $column->buildTh() !!}
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody>

            @foreach($rows as $source)
                <tr @class($contextual($source)->contextualClass())>
                    @foreach($columns as $column)
                        {!! $column->buildTd($source, $loop->parent) !!}
                    @endforeach
                </tr>
            @endforeach

            @if($total->isNotEmpty() && $rows->isNotEmpty())
                <tr>
                    @foreach($total as $column)
                        {!! $column->buildTd($repository, $loop) !!}
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
                    <x-orchid-icon :path="$iconNotFound" class="block h1"/>
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



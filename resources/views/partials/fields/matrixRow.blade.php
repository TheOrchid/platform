<tr>
    @foreach($columns as $column)

        <th class="p-0 align-middle">
            @php
                $columnsArray = explode('.', $column);
                $value= $row;
                foreach($columnsArray as $curr) {
                $value = $value[$curr] ?? "";
                    if ($value == "") break;
                }
            @endphp
            {!!
               $fields[$column]
                    ->value($value)
                    ->prefix($name)
                    ->id("$idPrefix-$key-$column")
                    ->name($keyValue ? $column : "[$key][$column]")
            !!}
        </th>

        @if ($loop->last && $removableRows)
            <th class="no-border text-center align-middle">
                <a href="#"
                   data-action="matrix#deleteRow"
                   class="small text-muted"
                   title="{{ __('Remove row') }}">
                    <x-orchid-icon path="bs.trash3"/>
                </a>
            </th>
        @endif
    @endforeach
</tr>

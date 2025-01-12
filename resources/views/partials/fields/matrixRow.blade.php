{{--
    Accessibility Improvements:
    - Added `scope` attribute to the `<th>` elements for better association with data cells.
    - Included `aria-hidden="true"` in icons to hide them from assistive technologies as they are decorative.
    - Added `aria-label` to interactive elements to provide proper descriptions for screen readers.
--}}
<tr>
    @foreach($columns as $column)

        <th scope="col" class="p-0 align-middle">
            {!!
               $fields[$column]
                    ->value($row[$column] ?? '')
                    ->prefix($name)
                    ->id("$idPrefix-$key-$column")
                    ->name($keyValue ? $column : "[$key][$column]")
            !!}
        </th>

        @if ($loop->last && $removableRows)
            <th class="no-border text-center align-middle">
                <a href="#"
                   data-action="matrix#deleteRow" aria-label="{{ __('Remove row') }}"
                   class="small text-muted"
                   title="{{ __('Remove row') }}">
                    <x-orchid-icon path="bs.trash3" aria-hidden="true"/>
                </a>
            </th>
        @endif
    @endforeach
</tr>

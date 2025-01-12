{{--
    Accessibility Improvements:
     - Added `aria-label` to interactive buttons for better screen reader support.
     - Used `aria-hidden` for purely decorative icons, making them invisible to assistive technologies.
     - Ensured that dynamic content such as row templates is clearly labeled and accessible.
     - Included `role="button"` to the interactive links so they are identified by screen readers as buttons.
--}}
@component($typeForm, get_defined_vars())
    <table class="matrix table table-bordered border-right-0 overflow-y-auto"
           data-controller="matrix"
           data-matrix-index="{{ $index }}"
           data-matrix-rows="{{ $maxRows }}"
           data-matrix-key-value="{{ var_export($keyValue) }}"
    >
        <thead>
        <tr>
            @foreach($columns as $key => $column)
                <th scope="col" class="text-capitalize">
                    {{ is_int($key) ? $column : $key }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @foreach($value as $key => $row)
            @include('platform::partials.fields.matrixRow',['row' => $row, 'key' => $key])
        @endforeach

        <tr class="add-row">
            <th colspan="{{ count($columns) }}" class="text-center p-0">
                <a href="#" data-action="matrix#addRow" class="btn btn-block small text-muted" aria-label="{{ __('Add a new row to the matrix') }}" role="button">

                    <x-orchid-icon path="bs.plus-circle" class="me-2" aria-hidden="true" />

                    <span>{{ __($addRowLabel) }}</span>
                </a>
            </th>
        </tr>

        <template class="matrix-template" aria-label="{{ __('Dynamic row template') }}" role="region">
            @include('platform::partials.fields.matrixRow',['row' => [], 'key' => '{index}'])
        </template>
        </tbody>
    </table>
@endcomponent

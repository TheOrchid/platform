<td class="text-{{$align}} @if(!$width) text-truncate @endif"
    data-column="{{ $slug }}" colspan="{{ $colspan }}"
    @empty(!$width)style="min-width:{{ is_numeric($width) ? $width . 'px' : $width }};"@endempty
>
    <div class="reorder-handle"
          data-controller="reorder"
          data-reorder-sortable-selector-value="tbody"
          data-reorder-handle-selector-value=".reorder-handle"
          data-key="{{ $value }}"
          data-action="{{ $action }}"
          data-success-message="{{ $success }}"
          data-failure-message="{{ $failure }}"
    >
        <x-orchid-icon :path="$icon" />
    </div>
</td>

@pushonce('stylesheets')
    <style>
        .reorder-drag {
            opacity: 0;
        }
        .reorder-handle {
            cursor: move;
        }
    </style>
@endpushonce

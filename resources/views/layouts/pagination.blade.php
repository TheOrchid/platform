{{--
    Accessibility Improvements:
    - Used `aria-label` on the dropdown button and menus to clearly describe their purpose and available options for screen readers.
    - Ensured the dropdown menu is properly labeled with `role="menu"` and its items with `role="menuitem"` to convey semantic groupings.
    - Added `aria-live="polite"` to dynamically update the displayed records announcement without disrupting the user experience.
    - Included `aria-label` for navigation elements to describe the pagination system to assistive technologies effectively.
--}}
<footer class="pb-3 w-100 v-md-center px-4 d-flex flex-wrap">
        <div class="col-auto me-auto">
            @if(isset($columns) && \Orchid\Screen\TD::isShowVisibleColumns($columns))
                <div class="btn-group dropup d-inline-block">
                    <button type="button"
                            class="btn btn-sm btn-link dropdown-toggle p-0 m-0"
                            aria-label="{{ __('Configure columns dropdown') }}"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            data-bs-boundary="viewport"
                            data-bs-popper-config='{"strategy": "fixed"}'
                            aria-expanded="false">
                        {{ __('Configure columns') }}
                    </button>
                    <div class="dropdown-menu" role="menu" aria-label="{{ __('Column configuration options') }}">
                        @foreach($columns as $column)
                            <div role="menuitem">{!! $column->buildItemMenu() !!}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <small class="text-muted d-block" aria-live="polite">
                    {{ __('Displayed records: :from-:to of :total',[
                        'from' => ($paginator->currentPage() -1 ) * $paginator->perPage() + 1,
                        'to' => ($paginator->currentPage() -1 ) * $paginator->perPage() + count($paginator->items()),
                        'total' => $paginator->total(),
                    ]) }}
                </small>
            @endif

        </div>
        <div class="col-auto overflow-auto flex-shrink-1 mt-3 mt-sm-0">
            @if($paginator instanceof \Illuminate\Contracts\Pagination\CursorPaginator)
                <nav aria-label="{{ __('Pagination Navigation') }}">{!!
                    $paginator->appends(request()
                        ->except(['page','_token']))
                        ->links('platform::partials.pagination')
                !!}</nav>
            @elseif($paginator instanceof \Illuminate\Contracts\Pagination\Paginator)
                <nav aria-label="{{ __('Pagination Navigation') }}">{!!
                    $paginator->appends(request()
                        ->except(['page','_token']))
                        ->onEachSide($onEachSide ?? 3)
                        ->links('platform::partials.pagination')
                !!}</nav>
            @endif
        </div>
</footer>

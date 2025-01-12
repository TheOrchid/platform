{{--
    Accessibility Improvements:
    - Used `aria-live="polite"` for dynamic content, such as empty state messages, ensuring updates are announced to screen reader users without causing disruption.
    - Added `aria-label` to interactive elements, such as links, to provide clear and meaningful descriptions for assistive technologies.
--}}
@forelse($results as $group)

@empty(!$group['label'])
    <div class="hidden-folded padder m-t-xs mb-1 text-muted small">{{$group['label']}}</div>
@endempty

@foreach($group['result'] as $item)
    <a href="{{$item->url()}}" class="block py-2 px-3 dropdown-item" style="font-size: 0.85em;" aria-label="{{$item->title()}}">

        @empty(!$item->image())
            <span class="pull-left thumb-xs rounded me-3">
                  <img src="{{$item->image()}}" alt="{{$item->title()}}">
                </span>
        @endempty

        <span class="clear">
                <span class="text-ellipsis">{{$item->title()}}</span>
                <small class="text-muted clear text-ellipsis">
                    {{$item->subTitle()}}
                </small>
            </span>
    </a>
@endforeach

@empty

    <p class="ms-3 me-3 mb-0 text-center" aria-live="polite">
        {{ __('There are no records in this view.') }}
    </p>

@endforelse


@if($total >= 5)

    <a href="{{ route('platform.search', $query) }}" class="block py-2 px-3 dropdown-item border-top pb-1" aria-label="{{ __('See more results for ') . $query }}">
        <span class="small ps-1">
            {{ __('See more results.') }}
            <span class="text-muted">({{ $total }})</span>
        </span>
    </a>

@endif

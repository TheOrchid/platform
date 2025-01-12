{{--
    Accessibility Improvements:
    - Added `aria-hidden="true"` to purely decorative elements, such as icons, ensuring they are ignored by assistive technologies.
    - Used `aria-live="polite"` for dynamic content, such as the empty state message, to announce updates to screen reader users without causing disruption.
    - Added `role="list"` to the container element for lists of items to better define the semantic structure for assistive technologies.
--}}
@section('search', $query)

@empty(!$radios)

        {!! $radios !!}

@endempty

<div class="bg-white shadow-sm rounded mb-3" role="list">
    @forelse($results as $item)

        <a href="{{$item->url()}}" class="block py-2 px-3 dropdown-item" style="font-size: 0.85em;">

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
    @empty

        <div class="text-center pt-5 pb-5 w-100" aria-live="polite">
            <h3 class="fw-light">
                <x-orchid-icon path="bs.funnel" class="block mb-3 center" aria-hidden="true"/>

                {{ __('Nothing found.') }}
            </h3>

            {{ __('Try changing the query or type.') }}
        </div>
    @endforelse

    <div class="mt-2">
        @includeWhen($results instanceof \Illuminate\Contracts\Pagination\Paginator && $results->isNotEmpty(),
            'platform::layouts.pagination',
            ['paginator' => $results]
          )
    </div>
</div>



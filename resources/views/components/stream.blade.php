{{--
    Accessibility Improvements:
    - Used aria-live="polite" to notify assistive technologies about content updates without interrupting the user.
    - Added role="region" to define a landmark region for better navigation by assistive technologies.
--}}

@props(['target', 'action', 'push', 'rule' => \Orchid\Support\Facades\Dashboard::isPartialRequest()])


@if(filter_var($rule, FILTER_VALIDATE_BOOLEAN))
    @fragment($target)
        <turbo-stream target="{{ $target }}" action="{{ $action ?? 'replace' }}" aria-live="polite" role="region">
            <template>
                {!! $slot !!}
            </template>
        </turbo-stream>
    @endfragment
@elseif(!empty($push))
    @push($push)
        {!! $slot !!}
    @endpush
@else
    {!! $slot !!}
@endif

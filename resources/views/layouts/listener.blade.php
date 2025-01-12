{{--
    Accessibility Improvements:
    - Added `aria-label="Stream content"` to describe the purpose of the streamed content for assistive technologies.
    - Used `role="region"` along with `aria-live="polite"` to alert screen readers about changes in content without interrupting the user.
    - Included `role="group"` and `tabindex="0"` to define logical groupings and ensure keyboard focus accessibility for each layout section.
--}}
<x-orchid-stream :target="$templateSlug" :rule="\request()->routeIs('platform.async.listener')"
                 aria-label="Stream content">

    <div role="region" aria-live="polite" data-controller="listener"
         data-listener-watched-value="{{$targets}}"
         data-listener-url-value="{{$asyncRoute}}"
         data-listener-loading-class="pe-none cursor-wait"
         id="{{$templateSlug}}"
    >
        @foreach($manyForms as $layouts)
            @foreach($layouts as $layout)
                <div role="group" tabindex="0">
                    {!! $layout ?? '' !!}
                </div>
            @endforeach
        @endforeach
    </div>
</x-orchid-stream>

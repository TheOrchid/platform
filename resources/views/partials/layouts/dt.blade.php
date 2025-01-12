{{--
    Accessibility Improvements:
    - Wrapped the `$title` in a heading tag (e.g., `<h1>`) to improve document structure and ensure assistive technologies can navigate the content easily.
    - Added an `aria-label` to the `<x-orchid-popover>` component to provide additional descriptive context for users relying on assistive technologies.
--}}
<h1>{{$title}}</h1>

<x-orchid-popover :content="$popover" aria-label="More information about {{$title}}"/>



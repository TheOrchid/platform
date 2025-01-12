{{--
    Accessibility Improvements:
    - Added a `title` attribute to the iframe to describe its content, ensuring better understanding for screen readers.
    - Added `aria-live="polite"` to iframe to indicate dynamic content updates without causing intrusive notifications.
--}}
<div data-controller="browsing" class="mb-3">
    <iframe @foreach($attributes as $key => $value) {{ $key }}='{{$value}}' @endforeach
            title="Embedded content" aria-live="polite"></iframe>
</div>

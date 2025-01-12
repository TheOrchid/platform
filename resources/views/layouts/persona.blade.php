{{--
    Accessibility Improvements:
    - Added `aria-label` to the `<a>` link to provide a descriptive label for assistive technologies, ensuring clear navigation context.
    - Used `alt="{{ $title }}"` for the `<img>` tag, making the image meaningful and accessible for screen readers.
    - Included `role="group"` for the text container to logically group related textual elements (`title` and `subtitle`).
--}}
<a href="{{ $url }}" class="d-flex align-items-center gap-md-3" aria-label="{{ $title }}">
    @empty(!$image)
    <span class="thumb-sm avatar d-none d-md-inline-block">
        <img src="{{ $image }}" class="bg-light" alt="{{ $title }}" role="img" aria-hidden="false">
    </span>
    @endempty
    <div class="text-balance" role="group">

        <p class="mb-0">{{ $title }}</p>
        <small class="text-muted">{{ $subTitle }}</small>
    </div>
</a>

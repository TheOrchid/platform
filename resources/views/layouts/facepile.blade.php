{{--
    Accessibility Improvements:
    - Added `aria-label` to the anchor elements to provide descriptive labels for screen readers, improving navigation for visually impaired users.
    - Included `title` attributes for tooltips to offer additional context for sighted users and assistive tools.
    - Ensured `alt` attributes on avatar images are meaningful and provide accurate descriptions.
--}}
<div class="avatar-group d-flex">
    @foreach($users as $user)
        <a href="{{ $user->url() }}" class="avatar thumb-xs"
           data-controller="tooltip"
           data-action="mouseover->tooltip#mouseOver"
           data-toggle="tooltip"
           data-placement="top"
           aria-label="{{ $user->title() }}"
           title="{{ $user->title() }}">
            <img src="{{ $user->image() }}"
                 class="avatar-img rounded-circle b bg-light"
                 alt="{{ $user->title() }}">
        </a>
    @endforeach
</div>


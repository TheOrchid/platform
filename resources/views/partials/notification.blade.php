{{--
    Accessibility Improvements:
    - Added `aria-hidden="true"` to the `<x-orchid-icon>` to ensure the icon is decorative and not perceived by assistive technologies, improving screen reader focus on meaningful content.
    - Applied `aria-label` to the "Mark notification as read" button so users relying on screen readers receive a descriptive label about the button's action and purpose.
    - Added `aria-label="Notification timestamp"` to the timestamp element to explicitly clarify its meaning for assistive technologies.
--}}
<button formaction="{{ url()->current() }}/{{ $notification->id }}/maskNotification"
        type="submit"
        class="btn btn-link text-start p-4 d-flex align-items-baseline"
        aria-label="Mark notification as read">

    <small class="align-self-start me-2 text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif">
        <x-orchid-icon path="bs.circle-fill" aria-hidden="true"/>
    </small>

    <span class="ps-3 text-wrap text-break">
        <span class="w-100">{{$notification->data['title'] ?? ''}}</span>
        <small class="text-muted ps-1 d-inline d-md-none">/ {{ $notification->created_at->diffForHumans() }}</small>
        <br>
        <small class="text-muted w-100">
            {!! $notification->data['message'] ?? '' !!}
        </small>
    </span>

    <small class="text-muted col-3 ms-auto d-none d-md-block text-end" aria-label="Notification timestamp">
        {{ $notification->created_at->diffForHumans() }}
    </small>
</button>

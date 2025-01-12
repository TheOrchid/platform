{{--
    Accessibility Improvements:
     - Added the "button" role to ensure screen readers support links with interactive behavior.
     - Added aria-label for better screen reader descriptions.
     - Added aria-describedBy to connect hidden descriptive text to the button.
     - Added aria-hidden attribute to empty <span> elements used for badges to improve accessibility.
--}}
<a href="{{ route('platform.notifications') }}"
   class="m-auto d-flex align-items-center btn btn-link position-relative px-1 py-0 h-100"
   data-controller="notification"
   data-notification-count="{{ count($notifications) }}"
   data-notification-url="{{ route('platform.api.notifications') }}"
   data-notification-method="post"
   data-notification-interval="{{ config('platform.notifications.interval') }}"
   aria-label="{{ __('View Notifications') }}"
   aria-describedBy="notification-desc"
   role="button"
>
    <x-orchid-icon path="bs.bell" width="1.1em" height="1.1em" aria-hidden="true"/>

    <template id="notification-circle">
        <x-orchid-icon path="bs.circle-fill" width="0.4em" height="0.4em" aria-hidden="true"/>
    </template>

    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            data-notification-target="badge"
            aria-hidden="true">
    </span>
</a>
<span id="notification-desc" class="visually-hidden">{{ __('This button opens your notifications panel.') }}</span>


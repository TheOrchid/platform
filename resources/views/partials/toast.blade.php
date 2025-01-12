{{--
    Accessibility Improvements:
    - Added `aria-label` to interactive elements, such as input fields and links, to provide clear and meaningful descriptions for assistive technologies.
    - Added `aria-hidden="true"` to purely decorative elements, such as icons, ensuring they are ignored by assistive technologies.
--}}
<div class="toast-wrapper" data-controller="toast">
    <template id="toast">
        <div class="toast rounded shadow-sm bg-white mb-3"
             role="alert"
             aria-label="Notification {type}"
             aria-live="assertive"
             aria-atomic="true"
             data-bs-delay="5000"
             data-bs-autohide="true">
            <div class="toast-body p-3 d-flex">
                <p class="mb-0">
                    <span class="text-{type}">
                        <x-orchid-icon path="bs.circle-fill" class="me-2" aria-hidden="true"/>
                    </span>
                    {message}
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </template>


    @if (session()->has(\Orchid\Alert\Toast::SESSION_MESSAGE))
        <div class="toast rounded shadow-sm bg-white mb-3"
             role="alert"
             aria-label="Notification {{ session(\Orchid\Alert\Toast::SESSION_LEVEL) }}"
             aria-live="assertive"
             aria-atomic="true"
             data-bs-delay="{{ session(\Orchid\Alert\Toast::SESSION_DELAY) }}"
             data-bs-autohide="{{ session(\Orchid\Alert\Toast::SESSION_AUTO_HIDE) }}"
             data-turbo-temporary
        >
            <div class="toast-body p-3 d-flex">
                <p class="mb-0 me-1">
                    <span class="text-{{ session(\Orchid\Alert\Toast::SESSION_LEVEL) }}">
                        <x-orchid-icon path="bs.circle-fill" class="me-2" aria-hidden="true"/>
                    </span>

                    {!! session(\Orchid\Alert\Toast::SESSION_MESSAGE) !!}
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

</div>



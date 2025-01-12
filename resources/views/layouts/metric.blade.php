{{--
    Accessibility Improvements:
    - Assigned `role="group"` to the container to clearly define related metrics as a group, improving navigation for screen readers.
    - Added `aria-labelledby="metrics-title"` to connect the group with a descriptive title for better understanding.
    - Enhanced individual metric cards with `role="article"` and `aria-label` to provide a clear label for each metric's content.
    - Used `aria-live="polite"` for dynamic percentage changes, ensuring updates are announced without being disruptive.
    - Added `aria-hidden="true"` to prevent redundant announcements of static text elements (e.g., keys).
--}}
<div class="mb-3" role="group" aria-labelledby="metrics-title">
    @isset($title)
        <legend id="metrics-title" class="text-body-emphasis px-4 mb-0">
            {{ __($title) }}
        </legend>
    @endisset
    <div class="row mb-2 g-3 g-mb-4">
        @foreach($metrics as $key => $metric)
            <div class="col" role="presentation">

                <div class="p-4 bg-white rounded shadow-sm h-100 d-flex flex-column" role="article"
                     aria-label="{{ __($key) }}">

                    <small class="text-muted d-block mb-1" aria-hidden="true">{{ __($key) }}</small>
                    <p class="h3 text-body-emphasis fw-light mt-auto">
                        {{ is_array($metric) ? $metric['value'] : $metric }}

                        @if(isset($metric['diff']) && (float)$metric['diff'] !== 0.0)
                            <small class="small {{ (float)$metric['diff'] < 0 ? 'text-danger': 'text-success' }}"
                                   aria-live="polite">
                                {{ round($metric['diff'], 2) }} %
                            </small>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>

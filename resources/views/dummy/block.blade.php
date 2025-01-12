{{--
    Accessibility improvements:
     - Added role="region" to define a landmark region for assistive technology.
     - Added aria-label="Dummy Section" to provide a meaningful label for the region.
     - Added tabindex="0" to make the heading focusable via keyboard navigation, enhancing usability.
--}}
<div class="rounded bg-white mb-3 p-3">
    <div class="border-dashed d-flex align-items-center w-100 rounded overflow-hidden" style="min-height: 250px;" role="region" aria-label="Dummy Section">
        <h2 class="text-muted center fw-light" tabindex="0">Dummy <small class="d-block text-center">{{ Str::random(8) }}</small></h2>
    </div>
</div>

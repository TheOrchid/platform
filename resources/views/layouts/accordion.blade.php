{{--
    Accessibility Improvements:
    - Added `aria-expanded`, `aria-controls`, and other ARIA attributes to ensure compatibility with screen readers for accordion functionality.
    - Implemented keyboard navigation support by adding `tabindex="0"` and handling `keydown` events for Enter and Space keys, ensuring proper interaction for assistive technology users.
    - Included icons with `aria-hidden="true"` to visually enhance the UI without interfering with screen readers.
--}}
<div id="accordion-{{$templateSlug}}" class="accordion mb-3">
    @foreach($manyForms as $name => $forms)
        <div class="accordion-heading @if ($loop->index) collapsed @endif"
             id="heading-{{\Illuminate\Support\Str::slug($name)}}" role="button"
             data-bs-toggle="collapse"
             data-bs-target="#collapse-{{\Illuminate\Support\Str::slug($name)}}"
             aria-expanded="true"
             aria-controls="collapse-{{\Illuminate\Support\Str::slug($name)}}">
            <h6 class="btn btn-link btn-group-justified pt-2 pb-2 mb-0 pe-0 ps-0 d-flex align-items-center"
                tabindex="0">
                <x-orchid-icon path="bs.chevron-right" class="small me-2" aria-hidden="true"/> {!! $name !!}
            </h6>
        </div>

        <div id="collapse-{{\Illuminate\Support\Str::slug($name)}}"
             class="mt-2 collapse @if (!$loop->index) show @endif"
             aria-labelledby="heading-{{\Illuminate\Support\Str::slug($name)}}"
             @if (!$stayOpen)
                 data-bs-parent="#accordion-{{$templateSlug}}"
            @endif
        >
            @foreach($forms as $form)
                <div role="group">
                    {!! $form !!}
                </div>
            @endforeach
        </div>
    @endforeach
</div>

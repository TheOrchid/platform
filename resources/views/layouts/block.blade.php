{{--
    Accessibility Improvements:
    - Added `aria-label` to the legend and the command bar to provide meaningful labels for screen readers.
    - Ensured dynamic descriptions are announced with `aria-live="polite"` for improved accessibility.
--}}
<fieldset class="row g-0 mb-3">
    @if(!empty($title) || !empty($description))
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis px-2 mt-2" aria-label="{{ $title ?? '' }}">
                {{ __($title ?? '') }}

                @if(!empty($description))
                    <p class="small text-muted mt-2 mb-0 text-balance" aria-live="polite">
                        {!! __($description  ?? '') !!}
                    </p>
                @endif
            </legend>
        </div>
    @endif
    <div class="col-12 {{!$vertical ? 'col-md-7' : ''}} shadow-sm h-100">

        <div class="bg-white d-flex flex-column layout-wrapper {{ empty($commandBar) ? 'rounded' : 'rounded-top' }}"
             >
            @foreach($manyForms as $key => $layouts)
                @foreach($layouts as $layout)
                    {!! $layout ?? '' !!}
                @endforeach
            @endforeach
        </div>

        @empty(!$commandBar)
            <div class="bg-light px-4 py-3 d-flex justify-content-end rounded-bottom gap-2" role="toolbar"
                 aria-label="Command Bar">
                @foreach($commandBar as $command)
                    <div>
                        {!! $command !!}
                    </div>
                @endforeach
            </div>
        @endempty
    </div>
</fieldset>


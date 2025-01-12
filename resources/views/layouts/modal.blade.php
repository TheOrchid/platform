{{--
    Accessibility Improvements:
    - Added `role="dialog"` to the modal container with appropriate `aria-labelledby` to ensure the modal is properly announced by screen readers.
    - Used `aria-label` attributes on close buttons to provide clear and meaningful actions for assistive technologies.
    - Added `aria-live="polite"` to apply button to announce content updates in a non-disruptive manner.
--}}
@push('modals-container')
    <div class="modal fade center-scale {{$type}}"
         id="screen-modal-{{$key}}"
         role="dialog"
         aria-labelledby="screen-modal-{{$key}}"
         data-controller="modal"
         data-modal-slug-value="{{ $templateSlug }}"
         data-modal-url-value="{{ $deferredRoute }}"
         @if(!empty($deferrerParams))
            data-modal-parameters-value='@json($deferrerParams)'
         @endif
         data-modal-open-value="{{ var_export($open) }}"
        {{$staticBackdrop ? "data-bs-backdrop=static" : ''}}
    >
        <div class="modal-dialog modal-fullscreen-md-down {{$size}}"
             role="document"
             id="screen-modal-type-{{$key}}"
        >
            <form class="modal-content"
                  action="{{ $method }}"
                  id="screen-modal-form-{{$key}}"
                  method="post"
                  enctype="multipart/form-data"
                  data-controller="form"
                  data-action="form#submit"
            >
                <div class="p-4 modal-placeholder">
                    <div class="placeholder-glow mb-3 mt-1 d-flex align-items-center">
                        <span class="placeholder col-6 h5 me-auto rounded-1"></span>
                        <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <p class="placeholder-glow">
                        <span class="placeholder col-7 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                        <span class="placeholder col-6 rounded-1"></span>
                        <span class="placeholder col-8 rounded-1"></span>
                        <span class="placeholder col-7 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                        <span class="placeholder col-6 rounded-1"></span>
                        <span class="placeholder col-8 rounded-1"></span>
                        <span class="placeholder col-3 rounded-1"></span>
                        <span class="placeholder col-7 rounded-1"></span>
                    </p>

                    <p class="placeholder-glow mb-0">
                        <span class="placeholder col-3 rounded-1"></span>
                        <span class="placeholder col-7 rounded-1"></span>
                        <span class="placeholder col-7 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                        <span class="placeholder col-6 rounded-1"></span>
                        <span class="placeholder col-8 rounded-1"></span>
                        <span class="placeholder col-4 rounded-1"></span>
                    </p>
                </div>
                <div class="modal-header align-items-baseline gap-3">
                    <h4 class="modal-title text-body-emphasis fw-light text-balance text-break" data-modal-target="title">{{$title}}</h4>
                    <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>
                </div>
                <div class="modal-body layout-wrapper">
                    <x-orchid-stream target="{{$templateSlug}}">
                        <div id="{{ $templateSlug }}">
                            @if(!empty($deferrerParams) == \Orchid\Support\Facades\Dashboard::isPartialRequest())
                                @foreach($manyForms as $formKey => $modal)
                                    @foreach($modal as $item)
                                        {!! $item ?? '' !!}
                                    @endforeach
                                @endforeach
                            @endif
                            @csrf
                        </div>
                    </x-orchid-stream>
                </div>
                <div class="modal-footer">
                    @if(!$withoutCloseButton)
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                aria-label="Close without applying changes">
                            {{ $close }}
                        </button>
                    @endif

                    @empty($commandBar)
                        @if(!$withoutApplyButton)
                            <button type="submit" aria-live="polite"
                                    id="submit-modal-{{$key}}"
                                    data-turbo="{{ var_export($turbo) }}"
                                    class="btn btn-default">
                                {{ $apply }}
                            </button>
                        @endif
                    @else
                        {!! $commandBar !!}
                    @endempty
                </div>
            </form>
        </div>
    </div>
@endpush

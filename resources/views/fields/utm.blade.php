{{--
    Accessibility Improvements:
    - Added ARIA attributes such as `aria-label`, `aria-labelledby`, `aria-describedby`, and `aria-hidden` for enhanced screen reader support.
    - Implemented semantic roles, such as `role="dialog"` for modals, ensuring proper focus management and navigation for assistive technologies.
    - Incorporated screen reader-only (`sr-only`) descriptions to supplement visible text with additional context.
--}}
@component($typeForm, get_defined_vars())

    <div data-controller="utm">
        <div class="input-group mb-3">
            <input {{ $attributes }} data-utm-target="url" aria-label="{{ __('URL input field') }}">
            <div class="input-group-append">
                <button type="button" class="btn btn-default" aria-label="{{ __('Open UTM Generator Modal') }}" data-bs-toggle="modal"
                        data-bs-target="#utm-{{$id}}">{{__('Generate UTM')}}</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="utm-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="utm-modal-title-{{$id}}" aria-hidden="true">
            <div class="modal-dialog modal-fullscreen-md-down modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-body-emphasis fw-light"
                            id="utm-modal-title-{{$id}}">{{__('UTM Generator')}}</h4>

                        <button type="button" class="btn-close" aria-label="{{ __('Close UTM Generator Modal') }}" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="row px-2">

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="utm-source-{{$id}}">{{__('Campaign Source')}} - <span class="font-weight-bold">utm_source</span></label>
                                    <input type="text" data-utm-target="source" placeholder="google"
                                           id="utm-source-{{$id}}" class="form-control" aria-describedby="utm-source-description-{{$id}}">
                                   <span id="utm-source-description-{{$id}}" class="sr-only">{{__('Original referrer: (e.g. google, newsletter)')}}</span>
                                    <small
                                        class="form-text text-muted w-b-k">{{__('Original referrer: (e.g. google, newsletter)')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label for="utm-medium-{{$id}}">{{__('Campaign medium')}} - <span class="font-weight-bold">utm_medium</span></label>
                                    <input type="text" data-utm-target="medium" placeholder="cpc"
                                           id="utm-medium-{{$id}}" class="form-control" aria-describedby="utm-medium-description-{{$id}}">
                                   <span id="utm-medium-description-{{$id}}" class="sr-only">{{__('Marketing medium: (e.g. cpc, ppc, banner, email)')}}</span>
                                    <small class="form-text text-muted w-b-k">{{__('Marketing medium: (e.g. cpc, ppc, banner, email)')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label>{{__('Campaign name')}} - <span class="font-weight-bold">utm_campaign</span></label>
                                    <input type="text" id="utm-campaign-{{$id}}" data-utm-target="campaign" pattern="[a-zA-Z0-9]+"
                                           placeholder="sleeping_beds" class="form-control" aria-describedby="utm-campaign-description-{{$id}}">
                                   <span id="utm-campaign-description-{{$id}}" class="sr-only">{{__('Product, promo code, or slogan (e.g. spring_sale)')}}</span>
                                    <small class="form-text text-muted w-b-k">{{__('Product, promo code, or slogan (e.g. spring_sale)')}}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="utm-term-{{$id}}">{{__('Campaign term')}} - <span class="font-weight-bold">utm_term</span></label>

                                    <input type="text" id="utm-term-{{$id}}" data-utm-target="term" placeholder="Golf ball"
                                           class="form-control" aria-describedby="utm-term-description-{{$id}}">
                                   <span id="utm-term-description-{{$id}}" class="sr-only">{{__('Paid keywords: (e.g. running+shoes)')}}</span>
                                    <small class="form-text text-muted w-b-k">{{__('Paid keywords: (e.g. running+shoes)')}}</small>
                                </div>

                                <div class="mb-3">
                                    <label for="utm-content-{{$id}}">{{__('Campaign content')}} - <span
                                                class="font-weight-bold">utm_content</span></label>

                                    <input type="text" id="utm-content-{{$id}}" data-utm-target="content" placeholder="cpc"
                                           class="form-control" aria-describedby="utm-content-description-{{$id}}">
                                   <span id="utm-content-description-{{$id}}" class="sr-only">{{__('Ad-specific content used to differentiate ads')}}</span>
                                    <small class="form-text text-muted w-b-k">{{__('Ad-specific content used to differentiate ads')}}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="button" aria-label="{{ __('Generate URL') }}" data-action="utm#generate" data-bs-dismiss="modal"
                                class="btn btn-default">{{__('Generate URL')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endcomponent


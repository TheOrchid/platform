{{--
    Accessibility Improvements:
    - Added role="dialog" to indicate this element is a modal dialog, enabling assistive technologies
      to treat it as a separate interactive component, improving navigation and focus for users.
    - Added role="document" to define this element as a container for content, providing a clear structure for screen readers and improving accessibility.
    - Added role="contentinfo" to designate this element as a landmark for footer or closing content,
      helping assistive technologies quickly identify and navigate to important information about the page.
--}}
<div class="modal fade"
     id="confirm-dialog"
     data-controller="confirm"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-body-emphasis fw-light">
                    {{ __('Are you sure?') }}
                </h4>
                <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body" role="document">
                <div class="p-4" data-confirm-target="message">

                </div>
            </div>
            <div class="modal-footer" role="contentinfo">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                    {{__('Cancel')}}
                </button>

                <div data-confirm-target="button">

                </div>
            </div>
        </div>
    </div>
</div>


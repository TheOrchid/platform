{{--
    Accessibility Improvements:
     - Added `role="application"` and `aria-label` to describe the cropper as an interactive widget and provide usage instructions.
     - Used `aria-labelledby` with hidden labels (`visually-hidden`) for better screen reader navigation and clarity.
     - Added meaningful `alt` attributes to images and set `aria-hidden="true"` on decorative icons to avoid confusion.
     - Ensured keyboard accessibility with `tabindex="0"` on focusable elements and modal components, and proper use of roles like `dialog` and `region`.
--}}
@component($typeForm, get_defined_vars())
    <div data-controller="cropper"
         role="application"
         data-cropper-value="{{ $attributes['value'] }}"
         data-cropper-storage="{{ $storage ?? config('platform.attachment.disk', 'public') }}"
         data-cropper-width="{{ $width }}"
         data-cropper-height="{{ $height }}"
         data-cropper-min-width="{{ $minWidth }}"
         data-cropper-min-height="{{ $minHeight }}"
         data-cropper-max-width="{{ $maxWidth }}"
         data-cropper-max-height="{{ $maxHeight }}"
         data-cropper-target="{{ $target }}"
         data-cropper-url="{{ $url }}"
         data-cropper-accepted-files="{{ $acceptedFiles }}"
         data-cropper-max-file-size="{{ $maxFileSize }}"
         data-cropper-groups="{{ $attributes['groups'] }}"
         data-cropper-path="{{ $attributes['path'] ?? '' }}"
         data-cropper-keep-original-type-value="{{ $keepOriginalType }}"
         data-cropper-max-size-message-value="{{ __($maxSizeValidateMessage) }}"
         aria-label="{{ __('Image cropper. Use tab to navigate, upload, and crop the image. Spacebar to interact and buttons to finalize actions.') }}"
    >
        <div class="border-dashed text-end p-3 cropper-actions" role="region" aria-labelledby="cropper-hidden-label">
            <span id="cropper-hidden-label" class="visually-hidden">{{ __('Image cropping functionality') }}</span>

            <div class="fields-cropper-container">
                <img src="#" class="cropper-preview img-fluid img-full mb-2 border" alt="{{ __('Image preview showing the dimensions of cropped image') }}" style="--cropper-width: {{ $width }}; --cropper-height: {{ $height }};">
            </div>

            <span class="mt-1 float-start">{{ __('Upload image from your computer:') }}</span>

            <div class="btn-group">
                <label class="btn btn-default m-0">
                    <x-orchid-icon path="bs.cloud-arrow-up" class="me-2" aria-hidden="true"/>

                    {{ __('Browse') }}
                    <input type="file"
                           accept="image/*"
                           aria-labelledby="img-upload-description"
                           data-cropper-target="upload"
                           data-action="change->cropper#upload click->cropper#openModal"
                           tabindex="0"
                           class="d-none"
                           aria-label="{{ __('Browse for an image to upload and crop') }}">
                </label>

                <button type="button" class="btn btn-outline-danger cropper-remove"
                        data-action="cropper#clear" aria-label="{{ __('Remove the selected image') }}" tabindex="0">{{ __('Remove') }}</button>
            </div>

            <input type="file"
                   accept="{{ $acceptedFiles }}"
                   class="d-none">
        </div>

        <input class="cropper-path d-none"
               type="text"
               data-cropper-target="source"
            {{ $attributes }}
        >

        <div class="modal" role="dialog" aria-labelledby="modal-title" aria-describedby="modal-description" {{$staticBackdrop ? "data-bs-backdrop=static" : ''}}>

            <div class="modal-dialog modal-fullscreen-md-down modal-lg" role="document">

                <div class="modal-content-wrapper" tabindex="0" role="main">
                    <div class="modal-content">
                        <div class="position-relative">
                            <img class="upload-panel" alt="{{ __('Upload preview panel showing cropped section of the image') }}" tabindex="0">
                        </div>

                        <div class="modal-footer">

                            <button type="button"
                                    class="btn btn-link"
                                    data-bs-dismiss="modal" aria-label="{{ __('Close the cropping modal') }}">
                                {{ __('Close') }}
                            </button>

                            <button type="button"
                                    class="btn btn-default"
                                    data-action="cropper#crop">
                                {{ __('Crop') }}
                            </button>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endcomponent

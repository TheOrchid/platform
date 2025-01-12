{{--
    Accessibility improvements:
     - Added aria-label to the file input container to provide a descriptive label for screen readers.
     - Added aria-describedby linking to a description (id="{{$id}}-description") for additional context about the placeholder text.
     - Included aria-hidden="true" on the icon to prevent it from being announced by assistive technologies as it is decorative.
     - Enhanced the alt attribute for the image to provide a meaningful description, like "Preview of {original_name}".
     - Added a unique id="{{$id}}-loading" for the visually-hidden spinner description to indicate loading status to assistive technologies.
--}}
@component($typeForm, get_defined_vars())
    <div data-controller="attach"
         class="attach"
         data-attach-name-value="{{ $name }}"
         data-attach-size-value="{{ $maxSize }}"
         data-attach-count-value="{{ $maxCount }}"
         data-attach-loading-value="0"
         data-attach-attachment-value='@json($value ?? [])'

         data-attach-storage-value="{{ $storage ?? 'public' }}"
         data-attach-path-value="{{ $path }}"
         data-attach-group-value="{{ $group }}"

         data-attach-upload-url-value="{{ $uploadUrl ?? route('platform.systems.files.upload') }}"
         data-attach-sort-url-value="{{ $sortUrl ?? route('platform.systems.files.sort') }}"

         data-attach-error-size-value="{{ $errorMaxSizeMessage }}"
         data-attach-error-type-value="{{ $errorTypeMessage }}"

         data-action="
             drop->attach#dropFiles:prevent
             dragenter->attach#preventDefaults
             dragover->attach#preventDefaults
             dragleave->attach#preventDefaults
         "
    >
        <div data-target="attach.preview" class="row row-cols-4 row-cols-lg-6 gy-3 sortable-dropzone">
            <div class="col order-last attach-file-uploader" data-attach-target="container">
                <label for="{{$id}}" class="border rounded bg-light attach-image-placeholder pointer-event h-100" aria-label="{{ __($placeholder) }}" aria-describedby="{{$id}}-description">
                    <input class="form-control d-none"
                           type="file"
                           data-attach-target="files"
                           data-action="change->attach#selectFiles"
                           disabled
                        {{ $attributes }}
                    >

                    <span class="d-block text-center fw-normal small text-muted p-3 mx-auto">
                    <span class="choose d-flex flex-column gap-2 align-items-center text-balance text-wrap">
                            <x-orchid-icon path="bs.cloud-arrow-up" class="h3" aria-hidden="true"/>
                            <small id="{{$id}}-description" class="text-muted d-block">{{ __($placeholder) }}</small>
                    </span>

                    <span class="spinner-border" role="status">
                        <span id="{{$id}}-loading" class="visually-hidden">{{ __('Loading...') }}</span>
                    </span>
                </span>
                </label>
                <input type="hidden" name="{{ $name }}" data-attach-target="nullable" value="0">
            </div>
        </div>


        <template data-attach-target="template">
            <div class="pip col position-relative">
                <input type="hidden" name="{name}" value="{id}">


                <img class="attach-image rounded border user-select-none overflow-hidden" src="{url}" title="{original_name}" alt="{{ __('Preview of {original_name}') }}"/>

                {{--
                    <object class="attach-image rounded border user-select-none" border="0" data="{url}" type="{mime}" title="test"  load="lazy" controls allowfullscreen autoplay="false">
                    </object>
                --}}

                <button class="btn-close rounded-circle bg-white border shadow position-absolute end-0 top-0"
                        type="button" data-action="click->attach#remove" data-index="{id}"></button>
            </div>
        </template>

    </div>
@endcomponent

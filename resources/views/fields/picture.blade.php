{{--
    Accessibility improvements:
    - Added `aria-label` to various elements (e.g., file input, buttons) to help screen readers describe their purpose.
    - Ensured all icons used purely for decoration or functionality have `aria-hidden="true"` to be ignored by assistive technologies.
    - Included `alt` text for the image element used for the preview to properly describe the image to screen readers.
    - Ensured hidden inputs have `aria-hidden="true"` to prevent them from interfering with screen readers.
--}}
@component($typeForm, get_defined_vars())
    <div data-controller="picture"
         data-picture-value="{{ $attributes['value'] }}"
         data-picture-storage="{{ $storage ?? config('platform.attachment.disk', 'public') }}"
         data-picture-target="{{ $target }}"
         data-picture-url="{{ $url }}"
         data-picture-max-file-size="{{ $maxFileSize }}"
         data-picture-accepted-files="{{ $acceptedFiles }}"
         data-picture-groups="{{$attributes['groups'] ?? ''}}"
         data-picture-path="{{ $attributes['path'] ?? '' }}"
    >
        <div class="border-dashed text-end p-3 picture-actions">

            <div class="fields-picture-container">
                <img src="#" class="picture-preview img-fluid img-full mb-2 border" alt="{{ __('Image preview') }}">
            </div>

            <span class="mt-1 float-start">{{ __('Upload image from your computer:') }}</span>

            <div class="btn-group">
                <label class="btn btn-default m-0" for="picture-upload-input" aria-label="{{ __('Browse and upload image') }}">
                    <x-orchid-icon path="bs.cloud-arrow-up" class="me-2" aria-hidden="true"/>

                    {{ __('Browse') }}
                    <input id="picture-upload-input"
                            type="file"
                           accept="{{ $acceptedFiles }}"
                           data-picture-target="upload"
                           data-action="change->picture#upload"
                           class="picture-input d-none">
                </label>

                <button type="button" class="btn btn-outline-danger picture-remove"
                        data-action="picture#clear" aria-label="{{ __('Remove uploaded image') }}">{{ __('Remove') }}</button>
            </div>

            <input type="file"
                   accept="image/*"
                   class="d-none">
        </div>

        <input class="picture-path d-none"
               type="text"
               data-picture-target="source"
               aria-hidden="true"
               {{ $attributes }}
        >
    </div>
@endcomponent

{{--
    Accessibility Improvements:
    - Added `alt` text to the image to provide meaningful descriptions for users relying on screen readers.
    - Added `aria-label` attributes to dropdown menus and card descriptions to enhance clarity and usability.
--}}
<div class="d-block bg-white rounded shadow-sm mb-3">
    <div class="row g-0">

            @empty(!$image)
                <div class="col-md-4">
                    <div class="h-100" style="display: contents">
                        <img src="{{ $image }}" class="img-fluid img-card" alt="{{ $title ?? __('Image preview') }}">
                    </div>
                </div>
            @endempty

            <div class="col">
                <div class="card-body h-full p-4">
                    <div class="row d-flex align-items-center">
                        <div class="col-auto">
                            <h5 class="card-title">
                                @empty(!$color)<i class="text-{{ $color }}">●</i>@endempty
                                {{ $title ?? '' }}
                            </h5>
                        </div>

                        @if(count($commandBar) > 0)
                            <div class="col-auto ms-auto text-end">
                                <div class="btn-group command-bar">
                                    <button class="btn btn-link btn-sm dropdown-toggle dropdown-item p-2" type="button"
                                            aria-label="{{ __('Open command menu') }}"
                                            data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <x-orchid-icon path="options-vertical" aria-hidden="true"/>

                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-white"
                                         x-placement="bottom-end" role="menu">
                                        @foreach ($commandBar as $command)
                                            {!! $command !!}
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-text layout-wrapper layout-wrapper-no-padder" aria-label="{{ __('Card description') }}">{!! $description ?? '' !!}</div>
                </div>
            </div>

        </div>
</div>

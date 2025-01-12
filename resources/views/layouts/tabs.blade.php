{{--
    Accessibility Improvements:
    - Added `role="main"` to the outer container `<div>` to designate the primary content area of the page, enabling assistive technologies to skip directly to it.
    - Added `aria-label` to navigation controls (`<ul>`, `<a>`) to provide clear descriptions of their purpose and usage.
    - Added `aria-controls` to link tabs with their corresponding content panels, ensuring a clearer association for assistive technologies.
    - Dynamically set the `aria-selected` attribute to indicate the active tab, improving navigation for screen readers.
--}}
<div role="main"
    data-controller="tabs"
    data-tabs-slug="{{$templateSlug}}"
    data-tabs-active-tab="{{$activeTab}}"
>
    <div class="nav-tabs-alt">
        <ul class="nav nav-tabs nav-tabs-scroll-bar" role="tablist" aria-label="Tab navigation">
            @foreach($manyForms as $name => $tab)
                <li class="nav-item" role="presentation">
                    <a aria-label="Tab {{ $name }}" class="nav-link
                        @if ($activeTab === $name)
                            active
                        @elseif($loop->first && is_null($activeTab))
                            active
                        @endif"
                       data-action="tabs#setActiveTab"
                       data-bs-target="#tab-{{\Illuminate\Support\Str::slug($name)}}"
                       id="button-tab-{{\Illuminate\Support\Str::slug($name)}}"
                       aria-selected="{{ ($activeTab === $name) || ($loop->first && is_null($activeTab)) ? 'true' : 'false' }}"
                       aria-controls="tab-{{\Illuminate\Support\Str::slug($name)}}"
                       role="tab"
                       data-bs-toggle="tab"
                       tabindex="0">
                        {!! $name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- main content -->
    <section class="mb-3">
        <div class="no-border-xs">
            <div class="tab-content">
                @foreach($manyForms as $name => $forms)
                    <div role="tabpanel" aria-label="Content for {{ $name }}"
                         tabindex="0"
                         class="tab-pane
                        @if ($activeTab === $name)
                            active
                        @elseif($loop->first && is_null($activeTab))
                            active
                        @endif"
                         aria-labelledby="button-tab-{{\Illuminate\Support\Str::slug($name)}}"
                         id="tab-{{\Illuminate\Support\Str::slug($name)}}">
                            @foreach($forms as $form)
                                {!! $form !!}
                            @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- / main content -->
</div>

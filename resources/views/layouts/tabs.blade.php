<div
    data-controller="tabs"
    data-tabs-slug="{{$templateSlug}}"
    data-tabs-active-tab="{{$activeTab}}"
>
    <div class="nav-tabs-alt">
        <ul class="nav nav-tabs nav-tabs-scroll-bar" role="tablist">
            @foreach($manyForms as $name => $tab)
                <li class="nav-item" role="presentation">
                    <a class="nav-link
                        @if ($activeTab === $name)
                            active
                        @elseif($loop->first && is_null($activeTab))
                            active
                        @endif"
                       data-action="tabs#setActiveTab"
                       data-bs-target="#tab-{{\Illuminate\Support\Str::slug($name)}}"
                       id="button-tab-{{\Illuminate\Support\Str::slug($name)}}"
                       aria-selected="false"
                       role="tab"
                       data-bs-toggle="tab">
                        {!! $labels[$name] ?? $name !!}
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
                    <div role="tabpanel" class="tab-pane
                        @if ($activeTab === $name)
                            active
                        @elseif($loop->first && is_null($activeTab))
                            active
                        @endif"
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

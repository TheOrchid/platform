{{--
    Accessibility Improvements:
    - Added `aria-label` to interactive elements, such as input fields and links, to provide clear and meaningful descriptions for assistive technologies.
    - Added `aria-hidden="true"` to purely decorative elements, such as icons, ensuring they are ignored by assistive technologies.
    - Added `role="listbox"` to define the semantic role of the dropdown container, improving navigation and context for assistive technologies.
--}}
@empty(!Dashboard::getSearch()->all())
    <div class="p-3">
        <div class="dropdown position-relative" data-controller="search">
            <div class="input-icon">
                <input aria-label="{{ __('Search') }}"
                    data-action="keyup->search#query blur->search#blur focus->search#focus"
                    data-search-target="query"
                    type="text"
                    value="@yield('search')"
                       class="form-control input-sm padder bg-dark text-white"
                       placeholder="{{ __('What to search...') }}"
                >
                <div class="input-icon-addon">
                    <x-orchid-icon path="bs.search" aria-hidden="true"/>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-white w-100"
                 x-placement="start-left" id="search-result" role="listbox">
            </div>
        </div>
    </div>

@else
    <div class="divider my-2"></div>
@endempty

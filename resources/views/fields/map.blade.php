{{--
    Accessibility Improvements:
     - Added `aria-label` attributes to provide descriptive names for interactive elements.
     - Added `aria-labelledby` attributes to associate dynamic content with textual descriptions.
     - Introduced IDs to link labels and descriptions for better screen reader compatibility.
     - Included visually hidden elements (`sr-only`) to offer additional descriptions for screen readers.
     - Ensured dynamic content updates (e.g., search results) are announced with `aria-live` attributes.
--}}
@component($typeForm, get_defined_vars())

    <div data-controller="map"
         data-map-id="{{$id}}"
         data-map-zoom="{{$zoom}}"
         aria-labelledby="map-section-description"
    <span id="map-section-description" class="sr-only">{{ __('Interactive Map Section Description: Use the inputs below the map to interact with or search for objects.') }}</span>
    >
        <div id="{{$id}}" class="osmap-map border mb-2 w-100" style="min-height: {{ $attributes['height'] }}" aria-labelledby="map-description">
        <span id="map-description" class="sr-only">{{ __('This is an interactive map. Zoom and click on the map to select coordinates.') }}</span>

        </div>
        <div class="row mt-3">
            <div class="col-md">
                <label for="marker__latitude" id="latitude-label">{{ __('Latitude') }}</label>
                <span class="sr-only" id="latitude-description">{{ __('Enter latitude value for the map marker.') }}</span>
                <input class="form-control"
                       id="marker__latitude"
                       data-map-target="lat"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lat]"
                       value="{{ $value['lat'] ?? '' }}"
                       aria-labelledby="latitude-label latitude-description"/>
            </div>
            <div class="col-md">
                <label for="marker__longitude" id="longitude-label">{{ __('Longitude') }}</label>
                <span class="sr-only" id="longitude-description">{{ __('Enter longitude value for the map marker.') }}</span>
                <input class="form-control"
                       id="marker__longitude"
                       data-map-target="lng"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lng]"
                       value="{{ $value['lng'] ?? '' }}"
                       aria-labelledby="longitude-label longitude-description"/>
            </div>
            <div class="col-md">
                <label for="marker__search" id="object-search-label">{{ __('Object search') }}</label>
                <span class="sr-only" id="object-search-description">{{ __('Enter the name of an object to search on the map.') }}</span>
                <input class="form-control" type="text"
                       id="marker__search"
                       value="{{$valuename ?? ''}}"
                       data-map-target="search"
                       aria-labelledby="object-search-label object-search-description"
                       data-action="keyup->map#search"
                       aria-label="{{ __('Search for objects') }}"/>
            </div>
        </div>

        <div class="marker-results" id="search-results" aria-live="polite" aria-labelledby="search-results-label">
        <span id="search-results-label" class="sr-only">{{ __('Search results for objects: Updates dynamically as you type.') }}</span>
        </div>

    </div>
@endcomponent

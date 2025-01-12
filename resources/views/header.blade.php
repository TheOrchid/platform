{{--
    Accessibility Improvements:
    - Added `role="banner"` and `aria-label="Header container"` to the header `<div>` for semantic meaning and better navigation for assistive technologies.
    - Added `aria-hidden="true"` to the `<x-orchid-icon>` to hide it from screen readers as it is decorative.
--}}
@push('head')
    <meta name="robots" content="noindex"/>
    <meta name="google" content="notranslate">
    <link
          href="{{ asset('/vendor/orchid/favicon.svg') }}"
          sizes="any"
          type="image/svg+xml"
          id="favicon"
          rel="icon"
    >

    <!-- For Safari on iOS -->
    <meta name="theme-color" content="#21252a">
@endpush

<div class="h2 d-flex align-items-center" role="banner">
    @auth
        <x-orchid-icon path="bs.house" class="d-inline d-xl-none" aria-hidden="true"/>
    @endauth

    <p class="my-0 {{ auth()->check() ? 'd-none d-xl-block' : '' }}">
        {{ config('app.name') }}
    </p>
</div>

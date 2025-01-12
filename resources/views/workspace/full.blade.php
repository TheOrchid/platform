{{--
    Accessibility Improvements:
    - Added `role="main"` to the outer container `<div>` to designate the primary content area of the page, enabling assistive technologies to skip directly to it.
    - Added `role="region"` to the workspace `<div>` to define a recognizable landmark, helping users navigate structured regions within the page.
--}}
@extends('platform::app')

@section('body')

    <div class="p-0 h-100"  role="main">
        <div class="workspace pt-3 pt-md-4 mb-4 mb-md-0 d-flex flex-column h-100" role="region">
            @yield('workspace')

            @includeFirst([config('platform.template.footer'), 'platform::footer'])
        </div>
    </div>

@endsection

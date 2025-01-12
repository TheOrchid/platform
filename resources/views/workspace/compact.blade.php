{{--
    Accessibility Improvements:
    - Added `role="main"` to identify the primary content area, helping assistive technologies skip directly to the main content.
--}}
@extends('platform::app')

@section('body')

    <div class="container-xl p-0 h-100" role="main">
        <div class="workspace workspace-limit pt-3 pt-md-4 mb-4 mb-md-0 d-flex flex-column h-100">
            @yield('workspace')

            @includeFirst([config('platform.template.footer'), 'platform::footer'])
        </div>
    </div>

@endsection

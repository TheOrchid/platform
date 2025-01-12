{{--
    Accessibility Improvements:
    - Added `role="main"` to the outer container `<div>` to designate the primary content area of the page, enabling assistive technologies to skip directly to it.
    - Added `aria-label` to interactive elements, such as input fields and links, to provide clear and meaningful descriptions for assistive technologies.
--}}
@extends('platform::app')

@section('body')

    <div class="container-md" role="main">
        <div class="form-signin h-full min-vh-100 d-flex flex-column justify-content-center" aria-label="Sign-in form">

            <a class="d-flex justify-content-center mb-4 p-0 px-sm-5" href="{{Dashboard::prefix()}}" aria-label="Dashboard Home">
                @includeFirst([config('platform.template.header'), 'platform::header'])
            </a>

            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xxl-5 px-md-5">

                    <div class="bg-white p-4 p-sm-5 rounded shadow-sm" role="region" aria-label="Content Area">
                        @yield('content')
                    </div>
                </div>
            </div>


            <footer>
                @includeFirst([config('platform.template.footer'), 'platform::footer'])
            </footer>
        </div>
    </div>

@endsection

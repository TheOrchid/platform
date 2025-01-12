{{--
    Accessibility improvements:
     - Added role="main" to the container to define the primary content area of the page for assistive technologies.
     - Added tabindex="-1" to the container to allow programmatic focus, useful for skip-to-content links.
     - Added aria-live="polite" to the heading for assistive technologies to announce it dynamically.
     - Associated the paragraph element with id="description" as a label for the list using aria-labelledby, providing better context to screen reader users.
     - Defined role="listitem" for each list item to explicitly convey the list structure to assistive technologies.
     - Added aria-live="assertive" to the final paragraph to dynamically inform assistive technologies of important updates in its content.
--}}
@extends('platform::dashboard')

@section('title', '404')
@section('description', __("You requested a page that doesn't exist."))

@section('content')

    <div class="container py-md-4" role="main" tabindex="-1">

            <h1 class="h2 mb-3" aria-live="polite">
                {{ __("Sorry, we don't have anything to show you on this page") }}
            </h1>


            <p id="description">{{ __("This could be because:") }}</p>
            <ul aria-labelledby="description">
                <li role="listitem">{{ __("The item you're looking for has been deleted") }}</li>
                <li role="listitem">{{ __("You don't have access to it") }}</li>
                <li role="listitem">{{ __("You clicked a broken link") }}</li>
            </ul>

            <p class="mb-0" aria-live="assertive">{{ __("If you think you should have access to this page, ask the person who manages the project (or the account) to add you to it.") }}</p>
    </div>

@endsection

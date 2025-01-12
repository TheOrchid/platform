{{--
    Accessibility Improvements:
    - Added ARIA roles such as `role="dialog"` and attributes like `aria-live="polite"` and `aria-live="assertive"` to improve screen reader behavior for dynamic content.
    - Used `role="menuitem"` to enhance how assistive technologies announce command bar items.
    - Included `novalidate` in the form to customize validation feedback and prevent default browser behaviors while keeping it accessible.
--}}
@extends('platform::dashboard')

@section('title', (string) __($name))
@section('description', (string) __($description))
@section('controller', $controller)

@section('navbar')
    @foreach($commandBar as $command)
        <li role="menuitem">
            {!! $command !!}

        </li>
    @endforeach
@endsection

@section('content')
    <div id="modals-container" role="dialog" aria-live="polite">
        @stack('modals-container')
    </div>

    <form id="post-form"
          class="mb-md-4 h-100"
          method="post"
          enctype="multipart/form-data"
          data-controller="form"
          aria-live="assertive"
          data-form-need-prevents-form-abandonment-value="{{ var_export($needPreventsAbandonment) }}"
          data-form-failed-validation-message-value="{{ $formValidateMessage }}"
          data-action="keypress->form#disableKey
                      turbo:before-fetch-request@document->form#confirmCancel
                      beforeunload@window->form#confirmCancel
                      change->form#changed
                      form#submit"
          novalidate
    >
        {!! $layouts !!}
        @csrf
        @include('platform::partials.confirm')
    </form>

    <div data-controller="filter">
        <form id="filters" autocomplete="off"
              data-action="filter#submit"
              data-form-need-prevents-form-abandonment-value="false"
        ></form>
    </div>

    @includeWhen(isset($state), 'platform::partials.state')
@endsection

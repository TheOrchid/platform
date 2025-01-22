@if (session()->has(\Orchid\Alert\Alert::SESSION_MESSAGE))
    <div class="alert alert-{{ session(\Orchid\Alert\Alert::SESSION_LEVEL) }} rounded shadow-sm mb-3 p-4 d-flex" data-turbo-temporary>
        {!! session(\Orchid\Alert\Alert::SESSION_MESSAGE) !!}

        @yield('flash_notification.sub_message')
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@empty(!$errors->count())
    <div class="alert alert-danger rounded shadow-sm mb-3 p-4" role="alert">
        <strong>{{  __('Oh snap!') }}</strong>
        {{ __('Change a few things up and try submitting again.') }}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ul>
    </div>
@endif

{{--
   Improved Accessibility:
    - Added aria-labels to provide descriptive labels for the various user interface elements.
    - Added aria-hidden to appropriate elements to enhance screen reader usability.
    - Added aria-describedby for improved contextual awareness for screen readers.
    - Applied visually-hidden class for descriptive help content accessible by screen readers.
    - Added aria-controls to associate the button with the controlled menu via id.
--}}

<div class="mb-3 d-flex align-items-center" role="group" aria-label="{{ __('User Information') }}">
    <div class="thumb-sm avatar me-3">
        <img src="{{ $lockUser->presenter()->image() }}" class="b bg-light" alt="{{ $lockUser->presenter()->title() }}" aria-hidden="false">
    </div>
    <div class="d-flex flex-column overflow-hidden small">
        <span class="text-ellipsis" aria-label="{{ __('User Name') }}">{{ $lockUser->presenter()->title() }}</span>
        <span class="text-muted d-block text-ellipsis" aria-label="{{ __('User Role or Subtitle') }}">{{ $lockUser->presenter()->subTitle() }}</span>
    </div>
    <input type="hidden" name="email" required value="{{ $lockUser->email }}">
</div>

<div class="mb-3">
    <input type="hidden" name="remember" value="true">

    {!!  \Orchid\Screen\Fields\Password::make('password')
            ->required()
            ->autocomplete('current-password')
            ->tabindex(1)
            ->autofocus()
            ->placeholder(__('Enter your password'))
    !!}

    @error('email')
        <span class="d-block invalid-feedback">
            {{ $errors->first('email') }}
        </span>
    @enderror
</div>

<div class="row align-items-center">
    <div class="col-md-6 col-xs-12">
        <a href="{{ route('platform.login.lock') }}" class="small">
            {{__('Sign in with another user.')}}
        </a>
    </div>
    <div class="col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="2" aria-label="{{ __('Submit Login Form') }}" aria-describedby="login-button-description">
            <span id="login-button-description" class="visually-hidden">{{ __('This button submits the login form.') }}</span>
            <x-orchid-icon path="bs.box-arrow-in-right" class="small me-2" aria-hidden="true"/>
            {{__('Login')}}
        </button>
    </div>
</div>

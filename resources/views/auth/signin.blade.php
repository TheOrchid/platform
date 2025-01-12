{{--
    Accessibility Improvements:
     - Added aria-label to the Remember Me checkbox for describing its function to screen readers.
     - Added aria-describedby to associate ARIA help text with interactive elements.
     - Used aria-hidden on icons that are decorative for screen readers.
 --}}
<div class="mb-3">

    <label class="form-label">
        {{__('Email address')}}
    </label>

    {!!  \Orchid\Screen\Fields\Input::make('email')
        ->type('email')
        ->required()
        ->tabindex(1)
        ->autofocus()
        ->autocomplete('email')
        ->inputmode('email')
        ->placeholder(__('Enter your email'))
    !!}
</div>


<div class="mb-3">
    <label class="form-label w-100">
        {{__('Password')}}
    </label>

    {!!  \Orchid\Screen\Fields\Password::make('password')
        ->required()
        ->autocomplete('current-password')
        ->tabindex(2)
        ->placeholder(__('Enter your password'))
    !!}
</div>

<div class="row align-items-center">
    <div class="col-md-6 col-xs-12">
        <label class="form-check">
            <input type="hidden" name="remember">
            <input type="checkbox" name="remember" value="true" aria-label="{{ __('Remember Me') }}" aria-describedby="remember-help"
                   class="form-check-input" {{ !old('remember') || old('remember') === 'true'  ? 'checked' : '' }}>
            <span id="remember-help" class="form-check-label"> {{__('Remember Me')}}</span>
        </label>
    </div>
    <div class="col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block" tabindex="3"  aria-label="{{ __('Login') }}" aria-describedby="button-login-help">
            <x-orchid-icon path="bs.box-arrow-in-right" class="small me-2" aria-hidden="true"/>
            {{__('Login')}}<span id="button-login-help" class="visually-hidden"> {{ __('Press to log in to your account') }}</span>
        </button>
    </div>
</div>

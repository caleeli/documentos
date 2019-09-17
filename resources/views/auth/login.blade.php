@extends('layouts.base')

@section('content')
<body class="login-page">
    <div class="login-container">
        <div class="login-content animation bounceInDown">
            <div class="login-header m-b-30">
                <a class="logo" href="components.html" title="SUBCEP">
                    <img src="/images/logo-banner.svg" alt="SUBCEP" title="SUBCEP" style="height:40px">
                </a>
            </div>

            <div class="login-form">
                <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Ingreso') }}">
                    @csrf
                    <fieldset>
                        <div class="form-group">
                            <input name="username" id="username" value="" class="form-control input-lg" placeholder="Usuario">
                            @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input name="password" id="password" class="form-control input-lg" placeholder="Contraseña" type="password">
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group clearfix">
                            <div class="checkbox checkbox-primary checkbox-replace pull-left">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                       <label class="form-check-label" for="remember">Recuérdame</label>
                            </div>

                            <div class="m-t-10 pull-right">
                                <a class="text-primary" href="{{ route('password.request') }}" title="Recuperar contraseña">{{ __('¿Olvidaste tu contraseña?') }}</a>
                            </div>
                        </div>
                        @if(config('auth.catpcha_site_key'))
                        {!! app('captcha')->display(); !!}
                        @endif
                        <button type="submit" class="btn btn-primary btn-rounded">
                            {{ __('Ingresar') }}
                        </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.localStorage.clear();
    </script>
    @if(config('auth.catpcha_site_key'))
    <script src='https://www.google.com/recaptcha/api.js'></script>
    @endif
</body>
@endsection

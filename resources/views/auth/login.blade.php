@extends('layouts.base')

@section('content')
<!-- panel name="Ingreso" style="background: white;">
  <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Ingreso') }}">
    @csrf

    <div class="form-group text-center">
      <img class="login-logo" v-bind:src="logo" />
    </div>
    <div class="form-group row">
      <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('Nombre de Usuario') }}</label>

      <div class="col-md-6">
        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
        <span class="invalid-feedback" role="alert">
          <strong>{{ $errors->first('email') }}</strong>
        </span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

      <div class="col-md-6">
        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
        <span class="invalid-feedback" role="alert">
          <strong>{{ $errors->first('password') }}</strong>
        </span>
        @endif
      </div>
    </div>

    <div class="form-group row">
      <div class="col-md-6 offset-md-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                 <label class="form-check-label" for="remember">
            {{ __('Recuerdame') }}
          </label>
        </div>
      </div>
    </div>

    <div class="form-group row mb-0">
      <div class="col-md-8 offset-md-4">
        <button type="submit" class="btn btn-primary">
          {{ __('Sign in') }}
        </button>

        <a class="btn btn-link" href="{{ route('password.request') }}">
          {{ __('¿Olvidaste tu contraseña?') }}
        </a>
      </div>
    </div>
  </form>
</panel -->
<body class="login-page">
    <div class="login-container">
        <div class="login-content animation bounceInDown">
            <div class="login-header m-b-30">
                <a class="logo" href="components.html" title="SUBCEP">
                    <img src="/images/logo128.png" alt="SUBCEP" title="SUBCEP" style="height:40px">
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
</body>
@endsection

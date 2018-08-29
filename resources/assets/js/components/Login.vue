<template>
  <form method="POST" :action="action">
    @csrf

    <div class="form-group row">
      <img class="" src="http://subcep.com/images/logo2.png" />
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
</template>

<script>
  export default {
      props: {
          action: Object
      },
      methods: {
          click() {
              if (this.action.active !== undefined) {
                  this.action.active = !this.action.active;
              }
              this.$emit('click');
          }
      }
  }
</script>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SUBCEP') }}</title>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @if(Auth::user())
    <meta name="user-uid" content="{{ Auth::user()->uid }}">
    <meta name="broadcaster-host" content="{{env('BROADCASTER_HOST')}}">
    <meta name="broadcaster-key" content="{{env('BROADCASTER_KEY')}}">
    @endif
  </head>
  <body>
    <div id="app">
      <div class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="w-100 d-flex">
          <ul class="nav navbar-nav">
            <li class="nav-item">
              <img v-bind:src="logo128" class="navbar-logo">
            </li>
          </ul>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item">
                <a class="nav-link" href="https://www.google.com/" target="_blank">Ayuda</a>
              </li>
              <notification icon="fa fa-bell" v-bind:count-class="topbar.notification.countClass" v-bind:notifications="topbar.notification.notificaciones">
              </notification>
              <li class="nav-item dropdown">
                <a class="nav-link " data-toggle="dropdown" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fa fa-power-off"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
      </form>

      @yield('content')
    </div>
  </body>
</html>

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
    <meta name="user-uid" content="{{ Auth::user()->getKey() }}">
    <meta name="api-token" content="{{Auth::user()->api_token}}">
    <meta name="broadcaster-host" content="{{env('BROADCASTER_HOST')}}">
    <meta name="broadcaster-key" content="{{env('BROADCASTER_KEY')}}">
    @endif
  </head>
  <body>
    <div id="app">
      <!-- div class="navbar navbar-expand-lg navbar-light bg-light">
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
                <a class="nav-link text-primary" href="https://www.google.com/" target="_blank">Ayuda</a>
              </li>
              <notification text-class="text-primary" icon="fa fa-bell" v-bind:count-class="topbar.notification.countClass" v-bind:notifications="topbar.notification.notificaciones">
              </notification>
              <li class="nav-item dropdown">
                <a class="nav-link text-primary" data-toggle="dropdown" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fa fa-power-off"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div -->

      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#/"><img v-bind:src="logo128" class="navbar-logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse bg-light" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Hoja de Ruta Externa
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <router-link class="dropdown-item" to="/HojaRutaExterna/externa">Registrar</router-link>
                <router-link class="dropdown-item" to="/HojaRutaExterna/1">Registrar</router-link>
                <router-link class="dropdown-item" to="/HojaRutaExternaBusqueda">Búsqueda</router-link>
                <router-link class="dropdown-item" to="/HojaRutaExternaReporte">Reporte</router-link>
              </div>
            </li>
            
            <li class="nav-item active">
              <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
              <a class="nav-link disabled" href="#">Disabled</a>
            </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          {{ csrf_field() }}
        </form>
      </nav>

      @yield('content')
    </div>
  </body>
</html>

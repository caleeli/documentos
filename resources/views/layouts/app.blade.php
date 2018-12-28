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
                                <router-link class="dropdown-item" to="/HojaRuta/externa">Registrar</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaBusqueda/externa">Búsqueda</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaReporte/externa">Reporte</router-link>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Hoja de Ruta Interna
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" to="/HojaRuta/interna">Registrar</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaBusqueda/interna">Búsqueda</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaReporte/interna">Reporte</router-link>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Solicitudes y denuncia
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" to="/HojaRuta/solicitud">Registrar</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaBusqueda/solicitud">Búsqueda</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaReporte/solicitud">Reporte</router-link>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Notas oficio
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" to="/NotaOficio/notas">Registrar</router-link>
                                <router-link class="dropdown-item" to="/NotaOficioBusqueda/notas">Búsqueda</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaReporte/notas">Reporte</router-link>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Informes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" to="/ComunicacionesInternas/informes">Registrar</router-link>
                                <router-link class="dropdown-item" to="/NotaOficioBusqueda/informes">Búsqueda</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaReporte/informes">Reporte</router-link>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Comunicación interna
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <router-link class="dropdown-item" to="/ComunicacionesInternas/comunicacion">Registrar</router-link>
                                <router-link class="dropdown-item" to="/NotaOficioBusqueda/comunicacion">Búsqueda</router-link>
                                <router-link class="dropdown-item" to="/HojaRutaReporte/comunicacion">Reporte</router-link>
                            </div>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Salir</button>
                    </form>
                </div>
            </nav>
            <div v-for="notification in notifications" class="alert alert-dismissible" ;class="notification.class">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @{{notification.text}}
            </div>
            @yield('content')
        </div>
        <div class="footer"><div><strong>Copyright</strong> subcep.com © 2017-2019. Site designed by <a href="mailto:angelitacc27@gmail.com">Angela Choque</a> <a href="https://wa.me/59173241591?text=Estoy%20interesado%20en%20el%20sistema%20subcep.com" target="_blank">(+591 73241591)</a></div></div>
        <script>
            window.tasks = @json(isset($tasks) ? $tasks : []);
        </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SUBCEP') }}</title>

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
        @foreach(JDD::getModules() as $module)
        @foreach($module->scripts as $script)<script src="{{$script}}?{{filemtime(public_path($script))}}"></script>@endforeach
        @endforeach

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @foreach(JDD::getModules() as $module)
        @foreach($module->stylesheets as $stylesheet)<link rel="stylesheet" href="{{$stylesheet}}?{{filemtime(public_path($stylesheet))}}">@endforeach
        @endforeach

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
                        @foreach(\App\Menu::where('parent', 0)->get() as $menu)
                            @if ($menu->route==='#')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$menu->name}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach(\App\Menu::where('parent', $menu->id)->get() as $submenu)
                                    <router-link class="dropdown-item" to="{{$submenu->route}}">{{$submenu->name}}</router-link>
                                    @endforeach
                                </div>
                            </li>
                            @else
                            <li class="nav-item">
                                <router-link class="nav-link " to="{{$menu->route}}">{{$menu->name}}</router-link>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Salir</button>
                    </form>
                </div>
            </nav>
            <!-- loader que se muestra mientras arranca la aplicacion vue -->
            <div v-if="false">
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="lds-ellipsis" style="height: 2em;">
                <circle cx="84" cy="50" r="0" fill="#71c2cc">
                <animate attributeName="r" values="10;0;0;0;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">
                </animate>
                <animate attributeName="cx" values="84;84;84;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">
                </animate>
                </circle>
                <circle cx="84" cy="50" r="4.51498" fill="#d8ebf9">
                <animate attributeName="r" values="0;10;10;10;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.5s">
                </animate>
                <animate attributeName="cx" values="16;16;50;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.5s">
                </animate>
                </circle>
                <circle cx="68.6491" cy="50" r="10" fill="#5699d2">
                <animate attributeName="r" values="0;10;10;10;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.25s">
                </animate>
                <animate attributeName="cx" values="16;16;50;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="-0.25s">
                </animate>
                </circle>
                <circle cx="34.6491" cy="50" r="10" fill="#1d3f72">
                <animate attributeName="r" values="0;10;10;10;0" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">
                </animate>
                <animate attributeName="cx" values="16;16;50;84;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">
                </animate>
                </circle>
                <circle cx="16" cy="50" r="5.48502" fill="#71c2cc">
                <animate attributeName="r" values="0;0;10;10;10" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">
                </animate>
                <animate attributeName="cx" values="16;16;16;50;84" keyTimes="0;0.25;0.5;0.75;1" keySplines="0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1;0 0.5 0.5 1" calcMode="spline" dur="1s" repeatCount="indefinite" begin="0s">
                </animate>
                </circle>
                </svg>
            </div>
            <div v-for="notification in notifications" class="alert alert-dismissible" ;class="notification.class">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @{{notification.text}}
            </div>
            @yield('content')
        </div>
        @if (config('app.footer'))
        <div class="footer"><div>{!! config('app.footer') !!}</div></div>
        @endif
        <script>
            window.links = @json(isset($links) ? $links : []);
        </script>
    </body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="minimal-ui, width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SCSL') }}</title>

        <!-- Scripts -->
        <script src="js/tinymce/tinymce.min.js" defer></script>
        <script src="{{ mix('js/manifest.js') }}" defer></script>
        <script src="{{ mix('js/vendor.js') }}" defer></script>
        <script src="{{ mix('js/app.js') }}" defer></script>
        <script src="js/jq-ajax-progress/src/jq-ajax-progress.min.js" defer></script>
        @foreach(JDD::getModules() as $module)
        @foreach($module->scripts as $script)<script src="{{$script}}?{{filemtime(public_path($script))}}" defer></script>@endforeach
        @endforeach

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        @foreach(JDD::getModules() as $module)
        @foreach($module->stylesheets as $stylesheet)<link rel="stylesheet" href="{{$stylesheet}}?{{filemtime(public_path($stylesheet))}}">@endforeach
        @endforeach

        @if(Auth::user())
        <meta name="user-id" content="{{ Auth::user()->getKey() }}">
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
                        @foreach(\App\Menu::whereIsRoot()->get() as $menu)
                            @if ($menu->route==='#')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{$menu->name}}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    @foreach(\App\Menu::whereIsChildren($menu->id)->get() as $submenu)
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
                    @if (Auth::user()->role_id == 1)
                    <router-link class="btn btn-light my-2 my-sm-0" to="/Seguimiento?estado=Completado"><i class="fas fa-bell"></i> <span class="badge badge-warning">{{App\Tarea::whereTarEstado('Completado')->whereUserOwner()->count()}}</span></router-link>
                    @endif
                    <form class="form-inline my-2 my-lg-0" action="{{ route('logout') }}" method="POST">
                        {{ csrf_field() }}
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Salir <avatar v-model="user"></avatar></button>
                    </form>
                </div>
            </nav>
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

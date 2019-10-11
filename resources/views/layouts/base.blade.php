<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SUBCEP') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @if(Auth::user())
    <meta name="user-id" content="{{ Auth::user()->getKey() }}">
    <meta name="api-token" content="{{Auth::user()->api_token}}">
    <meta name="broadcaster-host" content="{{env('BROADCASTER_HOST')}}">
    <meta name="broadcaster-key" content="{{env('BROADCASTER_KEY')}}">
    @endif
  </head>
    @yield('content')
</html>

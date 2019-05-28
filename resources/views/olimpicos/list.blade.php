@extends('olimpicos.base')

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<form action="amistades/post" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">Todos:</h5>
                @foreach($list as $olimpico)
                <div class="form-group">
                    <a href="{{$olimpico->url}}" class="btn btn-outline-secondary">
                        <img src="{{$olimpico->avatar}}" width="40" height="40">
                        <label>{{$olimpico->name}}</label>
                    </a>
                </div>
                @endforeach
            </div>
</form>
@endsection

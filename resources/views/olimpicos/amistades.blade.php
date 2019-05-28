@extends('olimpicos.base')

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<form action="amistades/post" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">Amistades/Relaciones:</h5>
                @foreach($user->amistades as $amistad)
                <div class="form-group">
                        <a href="{{$amistad->url}}">
                            <img src="{{$amistad->avatar}}" width="40" height="40">
                            {{$amistad->name}}
                        </a>
                        <label>({{$amistad->pivot->type}})</label>
                        <input type="hidden" name="id[]" value="{{$amistad->id}}">
                        <input type="hidden" name="type[]" value="{{$amistad->pivot->type}}"><button class="btn btn-sm btn-warning" onclick="this.previousSibling.value=''">x</button>
                    </div>
                @endforeach
            </div>
            <div class="card-body">
                    <h5 class="card-title">Personas que quisas conozcas:</h5>
                    @foreach($user->noamistades() as $amistad)
                    <div class="form-group">
                            <a href="{{$amistad->url}}">
                                <img src="{{$amistad->avatar}}" width="40" height="40">
                                {{$amistad->name}}
                            </a>
                            <input type="hidden" name="id[]" value="{{$amistad->id}}">
                            <select name="type[]" onchange="this.form.submit()">
                                <option value=""></option>
                                <option value="padre">Padre</option>
                                <option value="madre">Madre</option>
                                <option value="esposo(a)">Esposo(a)</option>
                                <option value="hijo(a)">Hijo(a)</option>
                                <option value="amigo(a)">Amigo(a)</option>
                            </select>
                    </div>
                    @endforeach
                </div>
            </div>
</form>
@endsection

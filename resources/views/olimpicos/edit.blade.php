@extends('olimpicos.base')

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<form action="save" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card" style="width: 100%;">
        <img src="{{$user->avatar}}" alt="Avatar" width="40" height="40">
        <div class="card-body">
            <h5 class="card-title">Editar datos personales de {{$user->name}}</h5>
            <div class="input-group mb-3">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    </div>
                <input name="name" value="{{$user->name}}" type="text" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Avatar</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="avatar">
                    <label class="custom-file-label" for="avatar">Subir archivo</label>
                </div>
            </div>
            <button class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>
@endsection

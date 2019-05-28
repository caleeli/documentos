@extends('olimpicos.base')

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<form action="post" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <h5 class="card-title">En que estas pensado:</h5>
            <div class="form-group">
                <label for="comment">Comentario:</label>
                <textarea class="form-control" rows="5" name="text"></textarea>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">Imagen</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image">
                    <label class="custom-file-label" for="avatar">Subir imagen</label>
                </div>
            </div>
            <button class="btn btn-primary">Publicar</button>
        </div>
    </div>
</form>
@endsection

@extends('olimpicos.base')

@section('content')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<form action="{{$post->id}}/post" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="form-group">
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">👍</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">👎</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">😁</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">🤣</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">🤗</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">😡</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">😱</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">🙈</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">💓</button>
                <button class="btn btn-primary" onclick="document.getElementById('type').value=this.innerText">😪</button>
            </div>
            <div class="form-group">
                <label>{{$post->text}}</label>
            </div>
            @if($post->image)<img src="{{$post->image}}">@endif
            <input type="hidden" id="type" name="type">
        </div>
    </div>
</form>
@endsection

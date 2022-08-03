@extends('default')

@section('title')
    Картинки
@endsection

@section('content')
    <div class="container">
        <div class="panel panel-primary">
            <h1 class="mt-5">Картинки</h1>
            @php($i = 1)
            @foreach($user->images as $image)
                @if($i % 3 == 1)
                    <div class="card-group">
                        @endif
                        <div class="card col-sm-4 p-3" style="background-color: #ecebeb">
                            <img src="{{$image->url}}" id="{{$image->id}}" class="card-img-top" alt="card-img-top" height="250px" style="object-fit: cover;">
                            <div class="card-body">
                                @php($name = preg_replace('|/images/|isU', '', $image->url))
                                <h5 class="card-title"><a href="{{$image->url}}">{{$name}}</a><a href="/delete/image/{{$image->id}}" style="text-decoration: none"> 🗑️</a></h5>
                            </div>
                        </div>
                        @if($i % 3 == 0)
                    </div>
                @endif
                @php($i += 1)
            @endforeach
        </div>
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(Auth::id() == $user->id)
            <form action="/adding/image" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <input type="file" name="image" class="form-control mt-3">
                    </div>
                    <div class="col-md-5 mb-5">
                        <button type="submit" class="btn btn-success mt-3">Загрузить</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
@endsection

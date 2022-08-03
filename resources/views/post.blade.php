@extends('default')
@section('title', 'Пост')

@section('content')
    <div class="container">
        <div class="col-1 col-sm-12 card-body p-3" style="word-wrap: break-word; border-bottom: 1px solid">
            <h1 class="mt-5">{{$post->head}} @if((intdiv(Auth::user()->role,8) % 2) || Auth::user()->id == $post->user_id)<a href="/update/post/{{$post->id}}" style="text-decoration: none; font-size: 20px">✏</a> <a href="/delete/post/{{$post->id}}" style="text-decoration: none; font-size: 20px">🗑️</a>@endif</h1>
            <p class="card-text">{!! $text !!}</p>
            <div>
                <a href="/like/post/{{$post->id}}/{{Auth::id()}}/0"><button type="button" class="btn btn-outline-success ms-2"
                                                                            @if($post->likes->where('dislike', 0)->where('user_id', Auth::id())->first())
                                                                                style="background-color: #198754; color: #ffffff"
                        @endif
                    >👍 {{$post->likes->where('dislike', 0)->count()}}</button></a>
                <a href="/like/post/{{$post->id}}/{{Auth::id()}}/1"><button type="button" class="btn btn-outline-danger ms-2"
                                                                            @if($post->likes->where('dislike', 1)->where('user_id', Auth::id())->first())
                                                                                style="background-color: #dc3545; color: #ffffff"
                        @endif
                    >👎 {{$post->likes->where('dislike', 1)->count()}}</button></a>
                <a href="{{$post->id}}"><button type="button" class="btn btn-outline-info ms-2">&#128172; {{$post->comments->count()}}</button></a>
                <small class="text-muted ms-auto" style="float: right">{{$post->created_at->format('d M H:i')}} <img src="{{$post->user->image->url}}" style="height: 30px; width: 30px; border-radius: 15px; margin-left: 10px"> <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a></small>
            </div>
        </div>
        @include('comments')
    </div>
@endsection

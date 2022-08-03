@extends('default')
@section('title', 'Посты')

@section('content')
    <div class="container">
        <form method="GET" action="/posts">
            <div class="card mt-5 p-2" style="align-self: center">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter" value="popular" @if(isset($_GET['filter']) && $_GET['filter'] == 'popular') checked @endif>
                    <label class="form-check-label">Самые популярные</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="filter" value="new" @if(isset($_GET['filter']) && $_GET['filter'] != 'popular') checked @endif>
                    <label class="form-check-label">Самые новые</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="showDeletes" @if(isset($_GET['showDeletes']) && $_GET['showDeletes'] == 'on') checked @endif>
                    <label class="form-check-label" for="flexSwitchCheckDefault">Показывать удалённые</label>
                </div>
            </div>
            <input type="submit" value="Фильтровать" class="btn btn-success mt-3">
        </form>
        <div id=""
        @if(!$page < 1)
            @foreach($posts as $post)
                <div class="card mt-5">
                    <div class="row g-0">
                        <div class="col-1 col-sm-3">
                            <a href="/post/{{$post->id}}">
                                <img src="/images/{{$post->image_url}}" class="img-fluid w-100" alt="card-horizontal-image">
                            </a>
                        </div>
                        <div class="col-1 col-sm-9 card-body">
                            <a href="/delete/post/{{$post->id}}" style="position: absolute; top: 5px; right: 5px"><button type="button" class="btn-close" aria-label="Close"></button></a>
                            <h5 class="card-title">{{$post->head}}
                                @if(Auth::check() && ((intdiv(Auth::user()->role,8) % 2) || Auth::user()->id == $post->user_id))
                                    @if($post->deleted_at == true)
                                        <a href="/restore/post/{{$post->id}}" style="text-decoration: none; font-size: 15px">Восстановить пост</a>
                                    @else
                                        <a href="/update/post/{{$post->id}}" style="text-decoration: none; font-size: 15px">✏</a>
                                    @endif
                                @endif
                            </h5>
                            <p class="card-text">
                                @php($name = strip_tags($post->body))
                                @php($name = preg_replace('|{.*}|isU', '<i> *изображение* </i>', $name))
                                {!! mb_substr($name, 0, 300) !!}
                                @if(mb_strlen($name) > 500)
                                    ...читать далее
                                @endif
                            </p>
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
                                <a href="/post/{{$post->id}}"><button type="button" class="btn btn-outline-info ms-2">&#128172; {{$post->comments->count()}}</button></a>
                                <small class="text-muted ms-auto" style="float: right;">{{$post->created_at->format('d M H:i')}} <img src="{{$post->user->image->url}}" style="margin-left:10px; height: 20px; width: 20px; border-radius: 10px"> <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if((count($posts) == 0) || $page < 1)
            <h1 style="text-align: center">Страница пуста</h1>
        @else
            <div class="mt-4" style="display: flex; justify-content: center">
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$page - 1}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif"><</a></li>
                        @if(isset($_GET['page']) && $page != 1)
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{1}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">1</a></li>
                        @endif
                        @if(($page - 2) > 1)
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$page - 2}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">{{$page - 2}}</a></li>
                        @endif
                        @if(($page - 1) > 1)
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$page - 1}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">{{$page - 1}}</a></li>
                        @endif
                        <li class="page-item active"><a class="page-link" href="">{{$page}}</a></li>
                        @if(($page + 1) < $maxPage)
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$page + 1}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">{{$page + 1}}</a></li>
                        @endif
                        @if(($page + 2) < $maxPage)
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$page + 2}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">{{$page + 2}}</a></li>
                        @endif
                        @if(($page != $maxPage) and ($maxPage != 0))
                            <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$maxPage}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">{{$maxPage}}</a></li>
                        @endif
                        <li class="page-item"><a class="page-link" href="{{url()->current()}}?page={{$page + 1}}@if(isset($_GET['filter']))&filter={{$_GET['filter']}}@endif">></a></li>
                    </ul>
                </nav>
            </div>
        @endif
    </div>
@endsection

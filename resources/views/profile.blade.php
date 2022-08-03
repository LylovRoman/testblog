@extends('default')
@section('title', 'Профиль')

@section('content')
    <div class="container">
        <div class="card-body mb-5" style="word-wrap: break-word; width: 222px">
            <h1 class="mt-5">{{$user->name}}</h1>
            <div class="card bg-dark text-dark">

                <img src="<?= !empty($user->image->url) ? $user->image->url : '/images/1.png' ?>" class="card-img" alt="card-img-overlay" style="height: 220px; width: 220px; object-fit: cover;">
                <div class="card-img-overlay" style="text-align: right">
                    @if(Auth::id() == $user->id)
                        <p class="card-title"><a style="text-decoration: none" href="/add/avatar/">✏</a> <a href="/delete/avatar" style="text-decoration: none">🗑</a></p>
                    @endif
                </div>
            </div><br>
            <p>Зарегистрирован: {{$user->created_at->format('d M')}}</p>
            @php
                $likes = 0;
                $dislikes = 0;
                foreach ($user->posts as $post){
                    $likes += $post->likes()->where('dislike', 0)->count();
                    $dislikes += $post->likes()->where('dislike', 1)->count();
                }
            @endphp
            <p>Рейтинг постов: +{{$likes}} / -{{$dislikes}}</p>
            <p>Оставлено комментариев: {{$user->comments()->count()}}</p>
            <h4>Все посты ({{$user->posts->count()}})</h4>
            <ul>
                @php
                    $i = 0;
                @endphp
                @foreach($user->posts->sortDesc() as $post)
                    <li><a href="/post/{{$post->id}}">{{$post->head}}</a></li>
                    @php($i = $i + 1)
                    @if($i == 10)
                        <a href="/posts?autor={{$user->id}}">Показать все посты</a>
                        @break
                    @endif
                @endforeach
            </ul>
            <h4>Права</h4>
            <span>@if(intdiv($user->role,16) % 2) ✔ @else ❌ @endif Выдавать роли</span><br>
            <span>@if(intdiv($user->role,8) % 2) ✔ @else ❌ @endif Редактировать посты</span><br>
            <span>@if(intdiv($user->role,4) % 2) ✔ @else ❌ @endif Удалять комментарии</span><br>
            <span>@if(intdiv($user->role,2) % 2) ✔ @else ❌ @endif Писать посты</span><br>
            <span>@if($user->role % 2) ✔ @else ❌ @endif Комментировать</span>
        </div>
    </div>
@endsection

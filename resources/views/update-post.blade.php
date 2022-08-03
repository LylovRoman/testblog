@extends('default')
@section('title', 'Редактирование поста')

@section('content')
    <div class="container d-flex flex-column align-items-center">
        <h1 class="mt-5">Изменить пост</h1>
        <div class="mb-5 p-3 border d-flex mt-3 justify-content-center">
            <form method="POST" action="/updating/post">
                @csrf
                <input type="hidden" name="id" value="{{$post->id}}">
                <input type="text" name="head" placeholder="Заголовок" class="mt-3 w-100 p-2" value="{{$post->head}}">
                <textarea name="body" placeholder="Текст" class="mt-3 w-100 p-2" style="min-height: 300px">{{$post->body}}</textarea>
                <input type="text" name="image" placeholder="Ссылка на картинку для поста" class="mt-3 w-100 p-2" value="{{$post->image_url}}">
                <input type="submit" value="Сохранить" class="btn btn-success mt-3">
            </form>
        </div>
    </div>
@endsection

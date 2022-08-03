@extends('default')

@section('title')
    Написать пост
@endsection

@section('content')
    <div class="container d-flex flex-column align-items-center">
        <h1 class="mt-5">Создать пост</h1>
        <div class="mb-5 p-3 border d-flex mt-3 justify-content-center">
            <form method="POST" action="/adding/post">
                @csrf
                <input type="text" name="head" placeholder="Заголовок" class="mt-3 w-100 p-2">
                <textarea name="body" placeholder="Текст" class="mt-3 w-100 p-2" style="min-height: 300px"></textarea>
                <input type="text" name="image" placeholder="Ссылка на картинку для поста" class="mt-3 w-100 p-2">
                <input type="submit" value="Опубликовать" class="btn btn-success mt-3">
            </form>
        </div>
    </div>
@endsection

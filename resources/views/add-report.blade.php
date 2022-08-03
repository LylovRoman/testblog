@extends('default')

@section('title')
    Репорт
@endsection

@section('content')
    <div class="container d-flex flex-column align-items-center">
        <h1 class="mt-5">Пожаловаться на {{$name}}</h1>
        <div class="mb-5 p-3 border d-flex mt-3 justify-content-center">
            <form method="POST" action="/adding/report">
                @csrf
                <input type="hidden" name="link" value="{{$link}}">
                <textarea name="text" placeholder="Текст жалобы" class="mt-3 w-100 p-2" style="min-height: 300px"></textarea>
                <input type="submit" value="Отправить" class="btn btn-success mt-3">
            </form>
        </div>
    </div>
@endsection

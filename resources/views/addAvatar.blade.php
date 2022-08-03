@extends('default')

@section('title')
    Добавление картинки профиля
@endsection

@section('content')
    <div class="container d-flex flex-column align-items-center">
        <h1 class="mt-5">Добавить картинку</h1>
        <div class="mb-5 p-3 border d-flex mt-3 justify-content-center">
            <form method="POST" action="/adding/avatar">
                @csrf
                <input type="text" name="url" placeholder="Код картинки" class="mt-3 w-100 p-2">
                <input type="submit" value="Добавить" class="btn btn-success mt-3">
            </form>
        </div>
        <h3 style="color: red">
            @error('refused')
            {{ $message }}
            @enderror
        </h3>
    </div>
@endsection

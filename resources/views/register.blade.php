@extends('default')
@section('title', 'Регистрация')

@section('content')
    <style>
        .wrapper {
            width: 80%;
            margin: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        form#register {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
    </style>
    <div class="wrapper container mt-5">
        <form action="/register" method="post" id="register" class="mb-3">
            @csrf
            <input type="text" placeholder="Имя" name="name" required>
            <input type="password" placeholder="Пароль" name="password" required>
            <button type="send">Зарегистрироваться</button>
        </form>
        @error('register')
        {{ $message }}
        @enderror
    </div>
@endsection

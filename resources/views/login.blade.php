@extends('default')
@section('title', 'Авторизация')

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

        form#login {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
    </style>
    <div class="wrapper container mt-5">
        <form action="/login" method="post" id="login" class="mb-3">
            @csrf
            <input type="text" placeholder="Имя" name="name" required>
            <input type="password" placeholder="Пароль" name="password" required>
            <button type="send">Войти</button>
        </form>
        @error('login')
        {{ $message }}
        @enderror
    </div>
@endsection

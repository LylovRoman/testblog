@extends('default')
@section('title', 'Настройка роли')

@section('content')
    <div class="container d-flex flex-column align-items-center">
        <h1 class="mt-5">Установить права</h1>
        <div class="mb-5 p-3 border d-flex mt-3 justify-content-center">
            <form method="POST" action="/updating/user">
                @csrf
                <input type="hidden" name="id" value="{{$user->id}}">
                <input type="text" name="name" class="mt-3 w-100 p-2" value="{{$user->name}}" disabled>
                <div class="form-check mt-3">
                    <input class="form-check-input" type="checkbox" name="Admin" value="Admin"
                           @if(intdiv($user->role,16) % 2)
                               checked
                        @endif
                    >
                    <label class="form-check-label" for="flexCheckDefault">Выдавать роли</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="Editor" value="Editor"
                           @if(intdiv($user->role,8) % 2)
                               checked
                        @endif
                    >
                    <label class="form-check-label" for="flexCheckDefault">Редактировать посты</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="Moderator" value="Moderator"
                           @if(intdiv($user->role,4) % 2)
                               checked
                        @endif
                    >
                    <label class="form-check-label" for="flexCheckDefault">Удалять комментарии</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="Autor" value="Autor"
                           @if(intdiv($user->role,2) % 2)
                               checked
                        @endif
                    >
                    <label class="form-check-label" for="flexCheckDefault">Писать посты</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="User" value="User"
                           @if($user->role % 2)
                               checked
                        @endif
                    >
                    <label class="form-check-label" for="flexCheckDefault">Писать комментарии</label>
                </div>
                <input type="submit" value="Сохранить" class="btn btn-success mt-3">
            </form>
        </div>
    </div>
@endsection

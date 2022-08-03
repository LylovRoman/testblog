@extends('default')
@section('title', 'Пользователи')

@section('content')
    <div class="container">
        <div class="card mt-5" style="text-align: center">
            <div class="row g-1">
                <div class="col-sm-1 card-body">
                    id
                </div>
                <div class="col-sm-1 card-body">
                    Имя
                </div>
                <div class="col-sm-1 card-body">
                    Выдавать роли
                </div>
                <div class="col-sm-1 card-body">
                    Редактировать посты
                </div>
                <div class="col-sm-1 card-body">
                    Удалять комментарии
                </div>
                <div class="col-sm-1 card-body">
                    Писать посты
                </div>
                <div class="col-sm-1 card-body">
                    Комментировать
                </div>
                <div class="col-sm-1 card-body">
                    Изменить
                </div>
            </div>
            @foreach($users as $user)
                <div class="row g-1" style="border-top: 1px solid">
                    <div class="col-sm-1 card-body">
                        {{$user->id}}
                    </div>
                    <div class="col-sm-1 card-body">
                        {{$user->name}}
                    </div>
                    <div class="col-sm-1 card-body">
                        @if(intdiv($user->role,16) % 2) ✔ @else ❌ @endif
                    </div>
                    <div class="col-sm-1 card-body">
                        @if(intdiv($user->role,8) % 2) ✔ @else ❌ @endif
                    </div>
                    <div class="col-sm-1 card-body">
                        @if(intdiv($user->role,4) % 2) ✔ @else ❌ @endif
                    </div>
                    <div class="col-sm-1 card-body">
                        @if(intdiv($user->role,2) % 2) ✔ @else ❌ @endif
                    </div>
                    <div class="col-sm-1 card-body">
                        @if($user->role % 2) ✔ @else ❌ @endif
                    </div>
                    <div class="col-sm-1 card-body">
                        <a href="/update/user/{{$user->id}}">Изменить</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-5" style="display: flex; justify-content: center">{{$users->links()}}</div>
    </div>
@endsection

<header class="p-3 bg-dark text-white">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"/></svg>
            </a>
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li><a href="/posts" class="nav-link px-2
                @if($_SERVER['REQUEST_URI'] !== '/posts')
                text-white
                @else
                text-secondary
                @endif
                ">Посты</a></li>
                @if(Auth::check() && (intdiv(Auth::user()->role,2) % 2))
                <li><a href="/addpost" class="nav-link px-2
                @if($_SERVER['REQUEST_URI'] !== '/addpost')
                text-white
                @else
                text-secondary
                @endif
                ">Написать пост</a></li>
                @endif
                @if(Auth::check() && (intdiv(Auth::user()->role,16) % 2))
                    <li><a href="/users" class="nav-link px-2
                    @if($_SERVER['REQUEST_URI'] !== '/users')
                    text-white
                    @else
                    text-secondary
                    @endif
                    ">Пользователи</a></li>
                @endif
                @if(Auth::check())
                    <li><a href="/images/{{Auth::user()->id}}" class="nav-link px-2
                @php($id = Auth::user()->id)
                @if($_SERVER['REQUEST_URI'] != "/images/$id")
                text-white
                @else
                text-secondary
                @endif
                ">Картинки</a></li>
                @endif
                @if(Auth::check() && (intdiv(Auth::user()->role, 4) % 2))
                    <li><a href="/reports" class="nav-link px-2
                    @if($_SERVER['REQUEST_URI'] !== '/reports')
                    text-white
                    @else
                    text-secondary
                    @endif
                    ">Модерирование@if(\App\Models\Report::all()->count() > 0) {{\App\Models\Report::all()->count()}}@endif</a></li>
                @endif
            </ul>

            <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3">
                <input type="search" class="form-control form-control-dark" placeholder="Поиск..." aria-label="Search">
            </form>

            <div class="text-end">
                @if(Auth::check())
                    <a href="/user/{{Auth::user()->id}}"><button type="button" class="btn btn-outline-light me-2"><img src="{{Auth::user()->image->url}}" width="40px" style="border-radius: 20px; margin-right: 10px">{{Auth::user()->name}}</button></a>
                    <button onclick="window.location.href='/logout'" type="button" class="btn btn-warning">Выход</button>
                @else
                    <button onclick="window.location.href='/login'" type="button" class="btn btn-outline-light me-2">Войти</button>
                    <button onclick="window.location.href='/register'" type="button" class="btn btn-warning">Регистрация</button>
                @endif
            </div>
        </div>
    </div>
</header>


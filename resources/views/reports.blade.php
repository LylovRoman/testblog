@extends('default')
@section('title', 'Репорты')

@section('content')
    <div class="container">
        @foreach($reports as $report)
            <div class="card mt-5">
                <div class="row g-0">
                    <div class="col-1 col-sm-9 card-body">
                        <a href="/delete/report/{{$report->id}}" style="position: absolute; top: 5px; right: 5px"><button type="button" class="btn-close" aria-label="Close"></button></a>
                        <h5 class="card-title">Жалоба на <a href="{{$report->link}}" target="_blank">
                                @if(strpos($report->link, 'answer'))
                                    комментарий
                                @elseif(strpos($report->link, 'images'))
                                    картинку
                                @else
                                    пост
                                @endif
                            </a>
                        </h5>
                        <p class="card-text">{{$report->comment}}</p>
                        <div>
                            <small class="text-muted ms-auto" style="float: right;">{{$report->created_at->format('d M H:i')}} <img src="{{$report->user->image->url}}" style="height: 20px; width: 20px; border-radius: 10px"> <a href="/user/{{$report->user->id}}">{{$report->user->name}}</a></small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="mt-4" style="display: flex; justify-content: center">
            {{$reports->links()}}
        </div>
    </div>
@endsection

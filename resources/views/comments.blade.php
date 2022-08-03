<h3 style="color: red" class="mt-3">
    @error('refused_1')
    {{ $message }}
    @enderror
</h3>
<h3 style="color: red" class="mt-3">
    @error('refused_2')
    {{ $message }}
    @enderror
</h3>
<h3 style="color: red" class="mt-3">
    @error('refused_3')
    {{ $message }}
    @enderror
</h3>

@if(!isset($answer_id))
    <h3 class="mt-5">Комментарии</h3>
    @include('formComment')
    @foreach($post->comments->where('commentable_type', 'App\Models\Post') as $comment)
        <div class="col-1 col-sm-12 card-body mt-3 p-3" style="border-bottom: 1px solid; position: relative;">
            <a href="/delete/comment/{{$comment->id}}" style="position: absolute; top: 20px; right: 5px"><button type="button" class="btn-close" aria-label="Close"></button></a>
            <a href="/user/{{$comment->user->id}}" style="text-decoration: none"><h5 class="card-title"><img src="{{$comment->user->image->url}}" width="22px" style="border-radius: 11px; margin-right: 5px">{{$comment->user->name}}</h5></a>
            <p class="card-text">
                {{$comment->text}}
            </p>
            <div>
                <a href="/like/comment/{{$comment->id}}/{{Auth::id()}}/0"><button type="button" class="btn btn-outline-success ms-2"
                    @if($comment->likes->where('dislike', 0)->where('user_id', Auth::id())->first())
                         style="background-color: #198754; color: #ffffff"
                    @endif
                >👍 {{$comment->likes->where('dislike', 0)->count()}}</button></a>
                <a href="/like/comment/{{$comment->id}}/{{Auth::id()}}/1"><button type="button" class="btn btn-outline-danger ms-2"
                    @if($comment->likes->where('dislike', 1)->where('user_id', Auth::id())->first())
                        style="background-color: #dc3545; color: #ffffff"
                    @endif
                >👎 {{$comment->likes->where('dislike', 1)->count()}}</button></a>
                <a href="/post/{{$post->id}}?answer_id={{$comment->id}}"><button type="button" class="btn btn-outline-info ms-2">&#128172; {{$comment->comments()->count()}}</button></a>
                <small class="text-muted ms-auto" style="float: right">{{$comment->created_at->format('d M H:i')}} </small>
            </div>
        </div>
    @endforeach
@else
    @foreach($post->comments->where('id', $answer_id) as $comment)
        <div class="col-1 col-sm-12 card-body mt-3 p-3" style="border-bottom: 1px solid; position: relative;">
            <a href="/delete/comment/{{$comment->id}}" style="position: absolute; top: 20px; right: 5px"><button type="button" class="btn-close" aria-label="Close"></button></a>
            <a href="/user/{{$comment->user->id}}" style="text-decoration: none"><h4 class="card-title"><img src="{{$comment->user->image->url}}" width="30px" style="border-radius: 15px; margin-right: 5px">{{$comment->user->name}}</h4></a>
            <h6 class="card-text">
                {{$comment->text}}
            </h6>
            <div>
                <a href="/like/comment/{{$comment->id}}/{{Auth::id()}}/0"><button type="button" class="btn btn-outline-success ms-2"
                    @if($comment->likes->where('dislike', 0)->where('user_id', Auth::id())->first())
                        style="background-color: #198754; color: #ffffff"
                    @endif
                    >👍 {{$comment->likes->where('dislike', 0)->count()}}</button></a>
                <a href="/like/comment/{{$comment->id}}/{{Auth::id()}}/1"><button type="button" class="btn btn-outline-danger ms-2"
                    @if($comment->likes->where('dislike', 1)->where('user_id', Auth::id())->first())
                        style="background-color: #dc3545; color: #ffffff"
                    @endif
                    >👎 {{$comment->likes->where('dislike', 1)->count()}}</button></a>
                <a href=""><button type="button" class="btn btn-outline-info ms-2">&#128172; {{$comment->comments()->count()}}</button></a>
                <small class="text-muted ms-auto" style="float: right">{{$comment->created_at->format('d M H:i')}} </small>
            </div>
        </div>
        @php($mainComment = $comment)
    @endforeach
    @if(isset($mainComment))
    @foreach($mainComment->comments->where('commentable_id', $answer_id) as $comment)
        <div style="display: grid; grid-template-columns: 20% 80%">
            <div></div>
            <div class="col-sm-12 card-body mt-3 p-3" style="border-bottom: 1px solid; position: relative;">
                <a href="/delete/comment/{{$comment->id}}" style="position: absolute; top: 20px; right: 5px"><button type="button" class="btn-close" aria-label="Close"></button></a>
                <a href="/user/{{$comment->user->id}}" style="text-decoration: none"><h5 id="{{$comment->id}}" class="card-title"><img src="{{$comment->user->image->url}}" width="22px" style="border-radius: 11px; margin-right: 5px">{{$comment->user->name}}</h5></a>
                    <p class="card-text">
                        {{$comment->text}}
                    </p>
                    <div>
                        <a href="/like/comment/{{$comment->id}}/{{Auth::id()}}/0"><button type="button" class="btn btn-outline-success ms-2"
                        @if($comment->likes->where('dislike', 0)->where('user_id', Auth::id())->first())
                            style="background-color: #198754; color: #ffffff"
                        @endif
                    >👍 {{$comment->likes->where('dislike', 0)->count()}}</button></a>
                    <a href="/like/comment/{{$comment->id}}/{{Auth::id()}}/1"><button type="button" class="btn btn-outline-danger ms-2"
                        @if($comment->likes->where('dislike', 1)->where('user_id', Auth::id())->first())
                            style="background-color: #dc3545; color: #ffffff"
                        @endif
                    >👎 {{$comment->likes->where('dislike', 1)->count()}}</button></a>
                    <small class="text-muted ms-auto" style="float: right">{{$comment->created_at->format('d M H:i')}} </small>
                </div>
            </div>
        </div>
    @endforeach
    @include('formComment')
    @endif
@endif

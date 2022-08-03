<div class="mb-5 p-3 border mt-3">
    <form method="POST" action="/adding/comment" style="flex: 1; text-align: center;">
        @csrf
        <textarea name="text" placeholder="Комментировать" class="p-2 w-100" style="max-height: 150px; min-height: 150px"></textarea>
        @if(isset($answer_id))
            <input type="hidden" name="commentable_type" value="App\Models\Comment">
            <input type="hidden" name="commentable_id" value="{{$answer_id}}">
        @else
            <input type="hidden" name="commentable_type" value="App\Models\Post">
            <input type="hidden" name="commentable_id" value="{{$post->id}}">
        @endif
        <br>
        <input type="submit" value="Отправить" class="btn btn-success mt-2" @if((Auth::user()->role % 2) != 1) disabled @endif>
    </form>
</div>

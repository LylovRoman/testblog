<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $timestamps = true;

    public function user()
    {
        return $this->BelongsTo(User::class);
    }
    /*
    public function post()
    {
        return $this->BelongsTo(Post::class);
    }
    */
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeble');
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
    public function commentable()
    {
        return $this->morphTo();
    }
}

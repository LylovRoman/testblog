<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    public $timestamps = true;

    protected $fillable = ['name'];

    public function image()
    {
        return $this->BelongsTo(Image::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

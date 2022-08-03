<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user()
    {
        return $this->BelongsTo(User::class);
    }

    public function likeble()
    {
        return $this->morphTo();
    }
}

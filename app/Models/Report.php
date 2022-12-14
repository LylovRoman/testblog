<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}

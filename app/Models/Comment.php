<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    function users()
    {
        return $this->belongsTo(User::class);
    }

    function posts()
    {
        return $this->belongsTo(Post::class);
    }
}

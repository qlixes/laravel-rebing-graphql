<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    function users()
    {
        return $this->belongsTo(User::class);
    }

    function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

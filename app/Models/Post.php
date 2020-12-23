<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        "title",
        "user_id",
        "content",
        "status",
        "author",
        "intro",
        "cover",
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

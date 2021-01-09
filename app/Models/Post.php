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
        'conclusion',
        'views',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withCount('posts','users');
    }


    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class)->with("user:id,avatar,name")->orderBy("created_at","desc");
    }

    public function views(){
        return $this->hasMany(View::class);
    }
}

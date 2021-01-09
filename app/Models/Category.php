<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
    ];
    protected $hidden = [
        'pivot',
    ];

    public function posts(){
        return $this->belongsToMany(Post::class)->with('user')->with('categories')->orderByDesc('created_at');
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }
}

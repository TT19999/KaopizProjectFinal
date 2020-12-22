<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;

class Post_view extends Model
{
    use HasFactory;
    public static function createView($post){
        $SetView = new Post_view();
        $SetView->set_id=$post->id;
        $SetView->session_id=session()->getId();
        $SetView->url=URL::current();
        $SetView->user_id=null;
        $SetView->ip=request()->ip();
        $SetView->save();
    }
}

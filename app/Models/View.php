<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class View extends Model
{
    use HasFactory;

    public static function createView($post,$user){
        $SetView = new View();
        $SetView->post_id=$post->id;
        $SetView->sesion_id=session()->getId();
        $SetView->url=URL::current();
        $SetView->user_id=$user->id;
        $SetView->ip=request()->ip();
        $SetView->save();
    }

    public function user(){
        return $this
            ->belongsTo(User::Class);
    }

    public function post(){
        return $this->belongsTo(Post::class);
    }
}

<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public static function check(Post $post, User  $user){
        $check= DB::table('views')->where([
            ['post_id',$post->id],
            ['user_id',$user->id],
            ['ip',request()->ip()],
        ])->whereBetween('created_at',[Carbon::now()->subMinutes(30),Carbon::now()])->exists();
        return $check;
    }

    public static function create(Post $post, User $user){
        View::createView($post,$user);
        return true;
    }
}

<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    public function index(){
        $post = Post::with("user")->get();
        return response()->json([
            "post" => $post,
        ],200);
    }

    public function show($id){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::find($id);
        if($post){
            if($user->can('view', $post)){
                return response()->json([
                    "post"=>$post,
                    "user"=>$post->user,
                    "avatar"=>$post->user->profile->only("avatar"),
                ],200);
            }
            else response()->json([
                "errors"=>"bai viet không công khai",
            ],500);
        }
        else return response()->json([
            "errors" => "Bài viết không tồn"
        ],400);
    }
}

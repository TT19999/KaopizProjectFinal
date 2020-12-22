<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $post = Post::with("user")->get();
        return response()->json([
            "post" => $post,
        ],200);
    }

    public function show($id){
        $post= Post::with("user")->find($id);
        if($post){
            return response()->json([
                "post"=>$post,
            ],200);
        }
        else return response()->json([
            "errors" => "Bài viết không tồn"
        ],400);
    }
}

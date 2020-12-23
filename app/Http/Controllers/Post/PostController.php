<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    public function index(){
        $post = Post::with("user")->with("categories")->get();
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
            "errors" => "Bài viết không tồn tai"
        ],400);
    }

    public function create(Request $request){
        $validator = Validator::make($request ->json()->all() ,[
            'title'=>'required|bail|max:255',
            'content'=>'required|bail',
            'author' => 'required|string|max:255|bail',
            'cover'=>'required|string|bail',
            'intro'=>'required|bail',
            'conclusion'=>'required|bail',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "Thong tin chua chinh xac",
            ],400);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $post = $user->post()->create($request->all());
        $post->categories()->sync($request->category);
        return response()->json([
            "post" => $post,
            "message" => "Bai viet da duoc tao thanh cong",
        ],201);
    }   

    public function update(Request $request, $id){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::find($id);
        if($post){
            if($user->can('update', $post)){
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
            "errors" => "Bài viết không tồn tai"
        ],400);
    }

    public function updateStatus(){

    }
}

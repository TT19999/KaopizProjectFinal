<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\View\ViewController;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use mysql_xdevapi\Table;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostController extends Controller
{
    public function index(){
        $post = Post::with("user")->with("categories")->withCount('comments')->orderByDesc('updated_at')->get();
        $user=JWTAuth::parseToken()->authenticate();
        $currnetUser = User::query()->withCount('post','follower','comments')->find($user->id);
        $categories = Category::query()->withCount('posts')->whereKeyNot('7')->orderByDesc('posts_count')->limit('5')->get();
        return response()->json([
            "post" => $post,
            "user" => $currnetUser,
            "categories" => $categories
        ],200);
    }

    public function show(Request  $request){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::with("categories")->with('comments')->withCount("comments")->find($request->post_id);
        if($post){
            if($user->can('view', $post)){
                $owner= User::query()->with('post')->withCount('post')->withCount('follower')->with('profile:user_id,avatar,first_name,last_name,subject,created_at')->where('id','=',$post->user_id)->first();
                if(!ViewController::check($post, $user)) {
                    $post->increment('views');
                    ViewController::create($post, $user);
                }
                return response()->json([
                    "post"=>$post,
                    "owner" =>$owner,
                    "is_follower" => $user->hasFollower($owner->id),
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
            'intro'=> 'required|string|bail'
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "Thong tin chua chinh xac",
            ],400);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $post = $user->post()->create($request->all());
        $post = CategoryController::addCategory($post, $request);
        $job = (new \App\Jobs\sendNotification($post,$user));
        dispatch($job);
        return response()->json([
            "post" => $post,
            "message" => "Bai viet da duoc tao thanh cong",
        ],201);
    }

    public function edit($id){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::query()->with('categories')->find($id);
        if($post != null){
            if($user->can('update', $post)){
                return response()->json([
                    "post"=>$post,
                ],200);
            }
            else return response()->json([
                "errors"=>"Ban khong the sua bai viet nay",
            ],403);
        }
        else return response()->json([
            "errors" => "Bài viết không tồn tai"
        ],400);
    }

    public function update(Request $request, $id){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::find($id);
        if($post){
            if($user->can('update', $post)){
                $post->update($request->except("status"));
//                if($user->can('restore', $post)){
//                    $post->update($request->only("status"));
//                }
                $post = CategoryController::addCategory($post, $request);
                return response()->json([
                    "post"=>$post,
                    "user"=>$post->user,
                    "avatar"=>$post->user->profile->only("avatar"),
                ],200);
            }
            else return response()->json([
                "errors"=>"bai viet không công khai",
            ],500);
        }
        else return response()->json([
            "errors" => "Bài viết không tồn tai"
        ],400);
    }

    public function delete($id){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::find($id);
        if($post){
            if($user->can('update', $post)){
               $post->delete();
                return response()->json([
                    "message"=>"done"
                ],200);
            }
            else return response()->json([
                "errors"=>"ban khong the xoa bai viet",
            ],500);
        }
        else return response()->json([
            "errors" => "Bài viết không tồn tai"
        ],400);
    }


//    public function  updateCover(Request $request){
//        if($request->hasFile('cover')){
//            $fileName = time().'_'.Str::random(10);
//            $path = Storage::putFileAs('post', $request->cover,$fileName);
//            return \response()->json([
//                'message' => 'them anh thanh cong',
//                'cover' => "https://kaopiz-final.s3-ap-southeast-1.amazonaws.com/".$path,
//            ],201);
//        }else {
//            return response()->json([
//                "errors" => "file anh khong dung",
//            ],400);
//        }
//    }

    public function userPost(){
        $user = JWTAuth::parseToken()->authenticate();
        $post= Post::with("categories")->where("user_id",'=',$user->id)->get();
        return response()->json([
            "post" => $post,
        ],200);
    }

//    public function updateStatus(){
//
//    }
}

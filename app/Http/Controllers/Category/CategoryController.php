<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Jobs\DeleteCategoryJob;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::query()->withCount('posts')->orderByDesc('posts_count')->get();
        return response()->json([
            "categories" => $categories,
        ],200);
    }

    public function getCategory(){
        $user = JWTAuth::parseToken()->authenticate();
        $categories = Category::with('posts')->withCount('posts','users')->orderByDesc('posts_count')->get();
        $categoriesUser = $user->categories;
        $categoriesUser= array_column($categoriesUser->toArray(),'id');
        foreach ($categories as $category){
            if(in_array($category->id, $categoriesUser)){
                $category->is_follow = true;
            }
            else {
                $category->is_follow = false;
            }
        }
        return response()->json([
            "categories" => $categories,
        ],200);
    }

    public function show($id){
        $user = JWTAuth::parseToken()->authenticate();
        $category=Category::with('posts')->find($id);

        return response()->json([
            'category' => $category,
        ]);
    }

    public static function addCategory(Post $post, Request $request){
        $json_toArray = $request->categories;
        foreach ($request->categories as $category){
            if(array_key_exists('__isNew__',$category)){
                Category::query()->updateOrInsert([
                    'name'=>$category['value'],
                    'name'=>$category['value']
                ]);
            }
        }
        $array = array_column($json_toArray,'value');
        $result = Category::query()->whereIn('name', $array)->select('id')->get();
        $post->categories()->sync(array_column($result->toArray(),'id'));
        return $post;
    }


    public function create(Request $request) {
        $user = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request ->json()->all() ,[
            'name'=>'required|bail|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "Thong tin chua chinh xac",
            ],400);
        }
        $check = Category::query()->where('name','=',$request->name)->exists();
        if($user->can('create',Category::class)){
            if(!$check){
                $category = new Category();
                $category->name=$request->name;
                $category->timestamps = false;
                $category->save();
                return response()->json([
                    'message' =>'done',
                    'category'=>$category,
                ],201);
            }
            else return response()->json([
                "errors"=>"Category da ton tai",
            ],500);
        }

        else return response()->json([
            "errors"=>"ban khong the xoa bai viet",
        ],500);
    }

    public function edit(Request $request){
        $validator = Validator::make($request ->json()->all() ,[
            'name'=>'required|bail|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "Thong tin chua chinh xac",
            ],400);
        }
        $user = JWTAuth::parseToken()->authenticate();
        $category=Category::query()->find($request->id);
        if($user->can('update',$category)){
            $category->name = $request->name;
            $category->timestamps = false;
            $category->save();
            return response()->json([
                'message' =>'done',
                'category'=>$category,
            ],203);
        }
        else return response()->json([
            "errors"=>"ban khong the xoa bai viet",
        ],500);
    }

    public function delete(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $category=Category::query()->find($request->id);
        if($user->can('delete',$category)){
            $category->delete();
            $job = (new DeleteCategoryJob($category));
            dispatch($job);
            return response()->json([
                'message' =>'done'
            ],203);
        }
        else return response()->json([
            "errors"=>"ban khong the xoa bai viet",
        ],500);
    }
}

<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::get();
        return response()->json([
            "categories" => $categories,
        ],200);
    }

    public function show(){

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
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class TestApiControler extends Controller
{
    public function create(Request $request){
        $categories = Category::query()->get();
//        dd($categories->toArray());
        $json_toArray = $request->categories;
        foreach ($request->categories as $category){
            if(array_key_exists('__isNew__',$category)){
                Category::query()->updateOrInsert([
                        'name'=>$category['value'],
                        'name'=>$category['value']
                ]);
            }
        }
        $post=Post::query()->find(1);
        $array = array_column($json_toArray,'value');
        $result = Category::query()->whereIn('name', $array)->select('id')->get();
        $post->categories()->sync(array_column($result->toArray(),'id'));
        return response()->json([
            'data' => $post,
        ],200);
    }
}

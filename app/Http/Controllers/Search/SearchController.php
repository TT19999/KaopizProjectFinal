<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class SearchController extends Controller
{
    public function show(Request $request){
        $user = JWTAuth::parseToken() ->authenticate();
        $post = Post::with("user","categories")->where('title','like','%'.$request->key_word.'%')
                ->orWhere('intro','like','%'.$request->key_word.'%')->orderByDesc('created_at')->get();
        return response()->json([
            "post" => $post,
        ],200);
    }
}

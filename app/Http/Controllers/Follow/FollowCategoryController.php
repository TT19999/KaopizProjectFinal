<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class FollowCategoryController extends Controller
{
    public function create(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request ->json()->all() ,[
            'id'=>'unique:categories'
        ]);
        if($validator->fails()){
            $user->categories()->attach($request->id);

            return  response()->json([
                'message' => "da follow",
                'id' => $request->id,
            ],201);
        }
        return response()->json([
            'errors' => "Khong ton tai",
        ],400);
    }

    public function delete(Request $request){
        $user = JWTAuth::parseToken()->authenticate();
        $validator = Validator::make($request ->json()->all() ,[
            'id'=>'unique:categories'
        ]);
        if($validator->fails()){
            $user->categories()->detach($request->id);
            return  response()->json([
                'message' => "da huy follow",
                'id' => $request->id,
            ],204);
        }
        return response()->json([
            'errors' => "Khong ton tai",
        ],404);
    }
}

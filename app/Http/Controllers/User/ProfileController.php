<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProfileController extends Controller
{
    public function index(){

        $user = JWTAuth :: parseToken() ->authenticate();
        return response()->json([
            "user"=>$user->only("name","email"),
            "profile"=> $user->profile,
            "action"=>"edit",
        ],200);
    }


    public function show(Request $request){
        $user = JWTAuth :: parseToken() ->authenticate();
        $validator = Validator::make($request->all() ,[
            'user_id'=>'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "người dùng không tồn tại",
            ],400);
        }
        $userShow = User::find($request->user_id);
        
        if($userShow != null ){
            $profile = $userShow->profile;
            if($user->can('view', $profile)){
                return response()->json([
                    "user"=>$userShow->only("name","email"),
                    "profile"=>$profile,
                    "action"=>"show",
                    "status"=>"public",
                ],200);
            }
            return response()->json([
                "status"=>"private",
            ],200);
        }
        else {
            return response()->json([
                'errors' => "người dùng không tồn tại",
            ],400);
        }
    }
}

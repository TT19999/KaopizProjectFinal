<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Helper\Helper;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function index(){
        $user = JWTAuth::parseToken() ->authenticate();
        if($user->can("viewAny",Profile::class)){
            $users=User::with("profile")->withTrashed()->get();
            return response()->json([
                "users" => $users,
            ],200);
        }
        else return response()->json([
             "errors" => "You can do this action",
        ],403);
    }

    public function show($id){
        return ProfileController::show($id);
    }

    public function restore($id){

    }
    
    public function delete(Request $request,$id){
        $validator = Validator::make( $id,[
            'id'=>'numeric|unique:users',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "Thong tin chua chinh xac",
            ],400);
        }
        $user= User::find($id);
        dd($id);
        // $user->delete();
    }

}

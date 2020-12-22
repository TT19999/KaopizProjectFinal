<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request ->json()->all() ,[
            'email'=>'required|email|bail',
            'password'=>'required|min:6|bail',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => "Email hoặc mật khẩu không chính xác",
            ],400);
        }
        $creadentials = $request ->json()->all();
        try{
            if(! $token = JWTAuth::attempt($creadentials)){
                return  response()->json([
                    "errors" => "thông tin đăng nhập không chính xác",
                ],400);
            }
        }catch(JWTException $e){
            return response([
                "message" => "token is valid",
            ],500);
        }
        $user = JWTAuth::user();
        $role = $user->roles->first();

        return response()->json([
            "user"=>$user->only("name","id","email"),
            "role"=>$role->name,
            "token"=>$token,
        ],200);
    }


    public function register(Request $request){
        $validator = Validator::make($request ->json()->all() ,[
            'first_name'=>'required|string|bail',
            'last_name'=>'required|string|bail',
            'email'=>'required|email|unique:users|bail',
            'password'=>'required|min:6|confirmed|bail',
            'subject'=>'required|bail',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->getMessageBag()->first(),
            ],400);
        }
        $user = User::create([
            'name'=> $request->input('first_name') . $request->input('last_name'),
            'email'=> $request->input('email'),
            'password'=> Hash::make($request->input('password')),
        ]);
        $user->profile()->create([
            'first_name' => $request->input('first_name'),
            'last_name' =>$request->input('last_name'),
            'subject' => $request->input('subject'),
        ]);
        DB::table('role_user')->insert([
            'user_id'=>$user->id,
            'role_id'=>2,
        ]);

        return response()->json([
            "user" =>$user,
            "role"=> "user",
        ],201);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request ->json()->all() ,[
            'old_password'=>'required|min:6|bail',
            'new_password'=>'required|min:6|confirmed|bail',
        ]);
        if($validator->fails()){
            return response()->json([
                'errors' => $validator->errors()->getMessageBag()->first(),
            ],400);
        }
        $user = JWTAuth::user();
        if(Hash::check($request->input("old_password"), $user->password)){
            $user->password= Hash::make($request->input("new_password"));
            $user->save();
            return response()->json([
                "message"=>"Thay đổi mật khẩu thành công"
            ],201);
        }
        else{
            return response()->json([
                "errors" => "Old Password is not true",
            ],400);
        }
    }
}

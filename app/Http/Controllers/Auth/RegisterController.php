<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use mysql_xdevapi\Exception;

class RegisterController extends Controller
{
    public function index(){
        return view('Auth.register');
    }

    public function register(RegisterRequest $request){
        try {
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
        }catch (Exception $error){
            return back()->withErrors($error);
        }
        return redirect('/login');

    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function  index(){
        return view('auth.login');
    }
    public function login(LoginRequest $request){
        if(Auth::attempt($request->only('email','password'))){
            return redirect('/');
        }
        return back();
    }
    public function logout(){
        Auth::logout();
        return redirect('/');
    }
}

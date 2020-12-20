<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(){
        $user=Auth::user();
        $profile=$user->profile;

        return view("user.profile.profile",["user" => $user, "profile" => $profile]);
    }
}

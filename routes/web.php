<?php

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use App\Mail\VerifyEmail;
use App\Notifications\VerifyEmailNotifycation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // $user = \App\Models\User::find('3');
    // $user->notify(new \App\Notifications\VerifyEmailNotifycation("abs"));
    // Notification::route('mail','tunghust99@gmail.com')->notify(new VerifyEmailNotifycation("1234"));
    Mail::to("tunghust99@gmail.com")->send(new VerifyEmail("12345"));
});

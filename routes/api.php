<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Models\Profile;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\User\UserController;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login',[AuthController::class, 'login'])->middleware('auth.verify'); //use
Route::post('/verify',[AuthController::class,'verifyEmail']);
Route::post('/register', [AuthController::class, 'register']); //use
Route::post('/admin/login',[AuthController::class , 'adminLogin'])->middleware("auth.admin.login");//use

Route::group(['middleware' => 'auth.jwt'], function () {

    //resser password
    Route::post('/user/resetPassword', [AuthController::class,'resetPassword']);//use

    //profile
    Route::post('/user/profile', [ProfileController::class,'update']);//use
    Route::get('/user/profile',[ProfileController::class,'index']);//use
    Route::post('/user/profile/avatar', [ProfileController::class,'updateAvatar']);//use
    Route::get('/user/profile/show',[ProfileController::class,'show']);//use

    //post
    Route::post('/post',[PostController::class,'create']);//use
    Route::post('/post/edit',[PostController::class,'update']);//use
    Route::post('/post/cover/update', [PostController::class,'updateCover']);//use
    Route::get('/post/user',[PostController::class,'userPost']);//use
    Route::get('/post/show',[PostController::class,'show']);//use
    Route::delete('/post/{id}',[PostController::class,'delete']);
    Route::delete('/post/{id}/force',[PostController::class,'forceDelete']);

    //admin
    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('/admin/user', [UserController::class, 'index']);//use
        Route::get('/admin/user/show',[UserController::class,'show']);//use
        Route::delete('admin/user/delete',[UserController::class,'delete']);
        Route::post('/admin/user/restore',[UserController::class,'restore']);
    });
});
Route::get('/post',[PostController::class,'index']);//use
Route::post('/forgotEmail',[AuthController::class ,'forgotEmail']);//use
Route::get('/category',[CategoryController::class,'index']);//use
//abcs


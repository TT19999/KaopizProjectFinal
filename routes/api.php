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

Route::post('/login',[AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/admin/login',[AuthController::class , 'adminLogin'])->middleware("auth.admin.login");

Route::group(['middleware' => 'auth.jwt'], function () {

    //resser password
    Route::post('/user/resetPassword', [AuthController::class,'resetPassword']);

    //profile
    Route::post('/user/profile', [ProfileController::class,'update']);
    Route::get('/user/profile',[ProfileController::class,'index']);
    Route::post('/user/profile/avatar', [ProfileController::class,'updateAvatar']);
    Route::get('/user/profile/show',[ProfileController::class,'show']);

    //post
    Route::post('/post',[PostController::class,'create']);
    Route::post('/post/edit',[PostController::class,'update']);
    Route::post('/post/cover/update', [PostController::class,'updateCover']);
    Route::get('/post/user',[PostController::class,'userPost']);
    Route::get('/post/show',[PostController::class,'show']);
    Route::delete('/post/{id}',[PostController::class,'delete'])->where(['id' => '[0-9]+']);
    Route::delete('/post/{id}/force',[PostController::class,'forceDelete'])->where(['id' => '[0-9]+']);

    //admin
    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('/admin/user', [UserController::class, 'index']);
        Route::get('/admin/user/show',[UserController::class,'show']);
        Route::delete('admin/user/delete',[UserController::class,'delete']);
        Route::post('/admin/user/restore',[UserController::class,'restore']);

    });
});
Route::get('/post',[PostController::class,'index']);
Route::post('/forgotEmail',[AuthController::class ,'forgotEmail']);
Route::get('/category',[CategoryController::class,'index']);
//abcs


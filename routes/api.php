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
use \App\Http\Controllers\Comment\CommentController;
use \App\Http\Controllers\Follow\FollowController;
use \App\Http\Controllers\Notification\NotificationController;
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
Route::get('/verify',[AuthController::class,'verify'])->name("verify")->middleware('auth.signer');
Route::post('/register', [AuthController::class, 'register']); //use
Route::post('/admin/login',[AuthController::class , 'adminLogin'])->middleware("auth.admin.login");//use
Route::post('/verify/email',[AuthController::class,'verifyEmail']);

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
//    Route::post('/post/cover/update', [PostController::class,'updateCover']);//use
    Route::get('/post/user',[PostController::class,'userPost']);//use
    Route::get('/post/show',[PostController::class,'show']);//use
    Route::delete('/post/{id}',[PostController::class,'delete']);
    Route::get('/post/{id}/edit',[PostController::class,'edit']);//use
    Route::put('/post/{id}',[PostController::class,'update']);//use
    Route::delete('/post/{id}/force',[PostController::class,'forceDelete']);

    //comment
    Route::post('/post/{id}/comment',[CommentController::class,'create']);//use
    Route::post('/comment/edit',[CommentController::class,'update']);//use
    Route::delete('/comment/delete',[CommentController::class,'delete']);//use

    //follower
    Route::post('/follow',[FollowController::class,'create']);
    Route::delete('/follow',[FollowController::class,'delete']);
    Route::post('/follow/category',[\App\Http\Controllers\Follow\FollowCategoryController::class,'create']);
    Route::delete('/follow/category',[\App\Http\Controllers\Follow\FollowCategoryController::class,'delete']);

    //admin
    Route::group(['middleware' => 'auth.admin'], function () {
        Route::get('/admin/user', [UserController::class, 'index']);//use
        Route::get('/admin/user/show',[UserController::class,'show']);//use
        Route::delete('admin/user/delete',[UserController::class,'delete']);
        Route::post('/admin/user/restore',[UserController::class,'restore']);

        //category

        Route::post('/categories',[CategoryController::class,'create']);
        Route::post('/categories/update',[CategoryController::class,'edit']);
        Route::delete('/categories/delete',[CategoryController::class,'delete']);
    });

    //category
    Route::get('/category/{id}', [CategoryController::class,'show']);
    Route::get('/categories',[CategoryController::class,'getCategory']);

    //image
    Route::post('/image/create',[\App\Http\Controllers\Image\ImageController::class,'create']);

    //search
    Route::get('/search',[\App\Http\Controllers\Search\SearchController::class,'show']);

    //notification
    Route::get('/notifications',[NotificationController::class,'index']);
    Route::post('/notifications/update',[NotificationController::class,'update']);
    Route::post('/notifications/update/all',[NotificationController::class,'updateAll']);

});
Route::get('/post',[PostController::class,'index']);//use
Route::post('/forgotEmail',[AuthController::class ,'forgotEmail']);//use
Route::get('/post/comments',[CommentController::class,'index']);

Route::get('/category',[CategoryController::class,'index']);//use








//test cac thu cac thu

Route::post('/test/category',[\App\Http\Controllers\TestApiControler::class, 'create']);



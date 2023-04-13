<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;

Route::post('/register', [AuthController::class , 'register']);
Route::post('/login', [AuthController::class , 'login']);

Route::group(["middleware" => ["api.auth"]], function(){

    Route::get('/profile', [UserController::class , 'getUserProfile']);
    Route::post('/profile/update', [UserController::class , 'updateUserProfile']);
    Route::post('/profile/password/update', [UserController::class , 'updateUserPassword']);
    Route::delete('/profile/delete', [UserController::class ,'deleteAccount']);

    Route::post('/post/create', [PostController::class , 'create']);
    Route::post('/post/update', [PostController::class , 'updatePost']);
    Route::get('/post/{postId}', [PostController::class , 'getPostById']);
    Route::delete('/post/{postId}', [PostController::class , 'deletePostById']);
    Route::post('/post/tag/add', [PostController::class , 'addTagToPost']);
    Route::delete('post/tag/remove/{tagId}', [PostController::class , 'removeTag']);

    Route::post('/comment/create', [CommentController::class , 'create']);
    Route::post('/comment/update', [CommentController::class , 'updateComment']);
    Route::get('/comment/{commentId}', [CommentController::class , 'getCommentById']);
    Route::delete('/comment/{commentId}', [CommentController::class , 'deleteCommentById']);

    Route::post('/tag/search', [TagController::class , 'searchByName']);

    Route::middleware('api.admin')->group(function(){
        Route::get('users/posts/count', [DashboardController::class , 'getNumPostsEachUser']);
        Route::get('users/comments/count', [DashboardController::class , 'getNumCommentsEachUser']);
        Route::get('users/comments/topFive', [DashboardController::class , 'top5CommentedUsers']);
        Route::get('posts/topFiveCommented', [DashboardController::class , 'top5commentedPosts']);
        Route::get('tags/commonTags', [DashboardController::class , 'commonTags']);
        Route::get('posts/mostTags', [DashboardController::class , 'postsWithMostTags']);
        Route::get('users/comments/zero', [DashboardController::class , 'userZeroComments']);
    });



});

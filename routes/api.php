<?php

// use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;


Route::middleware('auth:api')->group(function () {

    // CATEGORYS
    Route::post('/category/store', [CategoryController::class, 'storeCategory']);
    Route::post('/category/get', [CategoryController::class, 'getCategory']);

    // TAGS
    Route::post('/tag/store', [TagController::class, 'storetag']);
    Route::post('/tag/get', [TagController::class, 'getTag']);

    // COMMENTS
    Route::post('/comment/store', [CommentController::class, 'storeComment']);
    Route::post('/comment/get', [CommentController::class, 'getComment']);

    // POST
    Route::post('/post/store', [PostController::class, 'PostStore']);
    Route::get('/posts/get/{id}', [PostController::class, 'getPost']);
    Route::get('/posts/getall', [PostController::class, 'getallPost']);
    Route::post('/posts/update/{id}', [PostController::class, 'updatePost']);
    Route::delete('/posts/{id}', [PostController::class, 'DeletePost']);
    Route::post('/logout', [UserController::class, 'logout']);
});


// AUTHENICATION
Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);

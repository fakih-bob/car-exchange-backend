<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

Route::get('/posts',[PostController::class,'index']);
Route::middleware('auth:sanctum')->post('/StorePost', [PostController::class, 'StoreFullPost']);

Route::middleware('auth:sanctum')->post('/{postId}/FavoriteList', [LikeController::class, 'StoreFavorite']);
Route::middleware('auth:sanctum')->delete('/{postId}/deleteFavorite', [LikeController::class, 'DeleteFavorite']);
Route::middleware('auth:sanctum')->get('/addFavorite', [LikeController::class, 'ListFavorites']);

Route::middleware('auth:sanctum')->get('/ListMyPosts', [PostController::class, 'ListMyPosts']);
Route::middleware('auth:sanctum')->delete('/{postId}/deletePost', [PostController::class, 'DeletePost']);

Route::middleware('auth:sanctum')->get('/user', [UserController::class, 'UserData']);
Route::middleware('auth:sanctum')->put('/UserUpdate', [UserController::class, 'UserUpdate']);


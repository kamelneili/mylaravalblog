<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::apiResource('/posts','PostController');

Route::apiResource('/categories','CategoryController');
Route::get('/posts/category/{slug}','PostController@category');
Route::apiResource('/comments', 'CommentController');
Route::post('/users/register', 'UsersController@register');
Route::post('/users/login', 'UsersController@login');

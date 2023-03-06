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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
Route::get('refresh', 'App\Http\Controllers\Api\Auth\LoginController@refresh');
Route::post('userRegistration', 'App\Http\Controllers\Api\User\UserController@userRegistration');
Route::post('messageSave', 'App\Http\Controllers\Api\Messages\MessagesController@messageSave');

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('allUsers', 'App\Http\Controllers\Api\User\UserController@allUsers');
    Route::put('updatePassword', 'App\Http\Controllers\Api\User\UserController@updatePassword');
    Route::put('updateUserInfo', 'App\Http\Controllers\Api\User\UserController@updateUserInfo');
    Route::get('user', 'App\Http\Controllers\Api\User\UserController@userData');

    Route::get('posts', 'App\Http\Controllers\Api\Posts\PostsController@posts');
    Route::post('postSave', 'App\Http\Controllers\Api\Posts\PostsController@postSave');
    Route::get('posts/{id}', 'App\Http\Controllers\Api\Posts\PostsController@postById');
    Route::put('posts/{post}', 'App\Http\Controllers\Api\Posts\PostsController@postEdit');
    Route::delete('posts/{post}', 'App\Http\Controllers\Api\Posts\PostsController@postRemove');

    Route::get('products', 'App\Http\Controllers\Api\Products\ProductsController@products');
    Route::post('productSave', 'App\Http\Controllers\Api\Products\ProductsController@productSave');
    Route::get('products/{id}', 'App\Http\Controllers\Api\Products\ProductsController@productById');
    Route::put('products/{post}', 'App\Http\Controllers\Api\Products\ProductsController@productEdit');

    Route::get('messages', 'App\Http\Controllers\Api\Messages\MessagesController@messages');
});

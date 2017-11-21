<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => 'auth:api'], function () {

    Route::post('logout', 'Auth\LoginController@logout');
    Route::resource('products', 'ProductController', ['except' => ['index', 'show']]);
    Route::resource('users', 'UserController', ['only' => ['update', 'destroy']]);

//    Route::get('users/{user}', 'UserController@show');
    Route::get('favorites', 'FavoriteController@index');
    Route::post('favorites', 'FavoriteController@store');
    Route::delete('favorites/{id}', 'FavoriteController@destroy');

});

Route::get('favorites/users/{user_id}', 'FavoriteController@show');
Route::get('products/users/{user_id}', 'ProductController@show');
Route::get('users/{user}', 'UserController@show');
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::get('products', 'ProductController@index');
Route::resource('categories', 'CategoryController');



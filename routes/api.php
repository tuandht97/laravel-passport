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

Route::middleware('auth:api')->group(function () {
    Route::post('logout', 'Api\Auth\LoginController@logout');
    Route::post('posts', 'Api\PostController@index');
});

Route::post('social_auth', 'Api\Auth\SocialAuthController@socialAuth');
Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('login', 'Api\Auth\LoginController@login');
Route::post('refresh', 'Api\Auth\LoginController@refresh');
Route::get('login/facebook', 'Api\Auth\LoginController@redirectToProvider');
Route::get('login/facebook/callback', 'Api\Auth\LoginController@handleProviderCallback');
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function(){
    Route::get('v1/users/{user_id}', 'UsersController@getUser')->name('get_user')->where(['user_id' => '[0-9]+']);
});

Route::group(['namespace' => 'Api'], function () {
    Route::middleware('auth:api')->group(function(){
        Route::get('v1/users/getting', 'GetUserController@getUser')->name('getting_user');
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('v1/register', 'RegisterController');
    });
});

// Route::post('register', 'Api\Auth\RegisterController');

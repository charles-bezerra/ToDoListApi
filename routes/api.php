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

Route::group(
    [
        'middleware' => 'api',
        'prefix' => 'auth'
    ],
    function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('user', 'AuthController@user');
    }
);


Route::get('task', 'TaskController@index');
Route::post('task', 'TaskController@store');
Route::put('task/{id}', 'TaskController@update');
Route::delete('task/{id}', 'TaskController@destroy');

Route::post('user/task/{id}', 'UserController@tasks');

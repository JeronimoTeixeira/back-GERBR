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

Route::post('auth/login', 'App\\Http\\Controllers\\Api\\AuthController@login');


Route::group(['middleware' =>['apiUsers']],function(){
    // Route::post('auth/registerTeste', 'App\\Http\\Controllers\\Api\\RegisterController@create');    
});

Route::group(['middleware' =>['apiAdms']], function(){
    Route::post('auth/register', 'App\\Http\\Controllers\\Api\\RegisterController@create');
});


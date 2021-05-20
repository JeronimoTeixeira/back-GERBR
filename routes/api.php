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
    Route::post('auth/measures/insert', 'App\\Http\\Controllers\\Api\\MeasuresController@create');
    Route::post('auth/measurer', 'App\\Http\\Controllers\\Api\\MeasurersController@index');
    Route::post('auth/measurer/measures', 'App\\Http\\Controllers\\Api\\MeasuresController@getDay');
    Route::post('auth/measurer/measures-month', 'App\\Http\\Controllers\\Api\\MeasuresController@getMonth');
    Route::post('auth/measurer/measures-week', 'App\\Http\\Controllers\\Api\\MeasuresController@getWeek');
    Route::post('auth/measurer/measures-records', 'App\\Http\\Controllers\\Api\\MeasuresController@records');
});

Route::group(['middleware' =>['apiAdms']], function(){
    Route::post('auth/register', 'App\\Http\\Controllers\\Api\\RegisterController@create');
    Route::post('auth/users', 'App\\Http\\Controllers\\Api\\RegisterController@show');
    Route::post('auth/measurer/insert', 'App\\Http\\Controllers\\Api\\MeasurersController@create');
});


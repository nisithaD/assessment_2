<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('admin')->group(function () {
    //public routes
    Route::post('login',  'AdminController@adminlogin');
    Route::post('password/token', 'ForgotPasswordController@forgot');
    Route::post('password/reset', 'ForgotPasswordController@reset');


    //protected routes
    Route::middleware('auth:sanctum')->group(function () {
        //admin management
        Route::post('update_name','AdminController@admin_name_update');
        Route::post('update_pw','AdminController@admin_pw_update');
        //end admin management

        //bus management
        Route::post('add_bus','AdminController@add_bus');
        Route::post('update_bus/{id}','AdminController@update_bus');
        Route::post('delete_bus/{id}','AdminController@delete_bus');
        //end bus management

        //route management
        Route::post('add_route','AdminController@add_route');
        Route::post('update_route/{id}','AdminController@update_route');
        Route::post('delete_route/{id}','AdminController@delete_route');
        //end route management

        //bus route mapping
        Route::post('create_mapping','AdminController@create_mapping');
    });
});

Route::prefix('user')->group(function () {
    Route::post('register','UserController@userRegister');
    Route::post('login',  'UserController@userlogin');
    Route::post('password/token', 'ForgotPasswordController@forgot');
    Route::post('password/reset', 'ForgotPasswordController@reset');
});

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
        Route::get('get_buses','AdminController@get_buses');
        Route::post('update_bus/{id}','AdminController@update_bus');
        Route::post('delete_bus/{id}','AdminController@delete_bus');
        //end bus management

        //route management
        Route::post('add_route','AdminController@add_route');
        Route::get('get_routes','AdminController@get_routes');
        Route::post('update_route/{id}','AdminController@update_route');
        Route::post('delete_route/{id}','AdminController@delete_route');
        //end route management

        //bus route mapping
        Route::post('create_mapping','AdminController@create_mapping');
        Route::get('get_mappings','AdminController@get_mappings');
        Route::post('update_mappings/{id}','AdminController@update_mappings');
        Route::post('delete_mapping/{id}','AdminController@delete_mapping');
        //end bus route mapping

        //seat management
        Route::post('add_seat','AdminController@add_seat');
        Route::get('get_seat_data','AdminController@get_seat_data');
        Route::post('update_seat/{id}','AdminController@update_seat');
        Route::post('delete_seat/{id}','AdminController@delete_seat');
        //end seat management

        //schedule management
        Route::post('create_schedule','AdminController@create_schedule');
        Route::post('get_schedules','AdminController@get_schedules');
        Route::post('update_schedule/{id}','AdminController@update_schedule');
        Route::post('delete_schedule/{id}','AdminController@delete_schedule');
        //end schedule management

    });
});

Route::prefix('user')->group(function () {
    //public routes
    Route::post('register','UserController@userRegister');
    Route::post('login',  'UserController@userlogin');
    Route::post('password/token', 'ForgotPasswordController@forgot');
    Route::post('password/reset', 'ForgotPasswordController@reset');

    //protected routes
    Route::middleware('auth:sanctum')->group(function () {

        //get schedule list
        Route::get('bus_schedule_list','UserController@bus_schedule_list');

        //book schedule
        Route::post('book_schedule','UserController@book_schedule');

        //user_bookings
        Route::get('user_bookings','UserController@user_bookings');

        //cancel bookings
        Route::post('cancel_bookings/{id}','Usercontroller@cancel_bookings');
    });
});

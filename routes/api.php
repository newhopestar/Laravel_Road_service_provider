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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function() {
    Route::post('login', 'API\AuthController@login');
    Route::post('register', 'API\AuthController@register');
    Route::group(['middleware' => 'auth:api'], function(){
        Route::get('get_user', 'API\AuthController@getUser');
        //Only Admin
        Route::group(['middleware'=>'can:isAdmin'], function(){
            //packages
            Route::get('package','API\PackageController@index');
            Route::get('package/{id}', 'API\PackageController@show');
            Route::post('package','API\PackageController@store');
            Route::put('package/{id}', 'API\PackageController@update');
            Route::delete('package/{id}', 'API\PackageController@destroy');
            //services
            Route::apiResource('service', 'API\ServiceController');
        });

        //Only Customer
        Route::group(['middleware'=>'can:isCustomer'], function(){
            Route::apiResource('vehicle', 'API\VehicleController');
        });
        
    });










});
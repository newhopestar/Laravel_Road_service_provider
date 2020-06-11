<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

    Route::get('/', function () {
        return redirect('/users');
    });
    Route::resource('/users','UserController');
    Route::get('/myaccount','UserController@getMyaccount');
    Route::post('/myaccount/getdata', 'UserController@getData');
    Route::resource('/packages', 'PackageController');
    Route::resource('/services', 'ServiceController');
    Route::resource('/orders', 'OrderController');
    Route::resource('/requests', 'RequestsController');
    Route::post('/requests/get_vehicle', 'RequestsController@getVehicle');



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

Route::post('/receive_stations', 'ReceiveStationController@store');
Route::put('/receive_stations/{receive_station}', 'ReceiveStationController@proposal');
Route::get('/receive_stations', 'ReceiveStationController@index');

Route::post('/launch_sites', 'LaunchSiteController@store');
Route::put('/launch_sites/{launch_site}', 'LaunchSiteController@proposal');
Route::get('/launch_sites', 'LaunchSiteController@index');

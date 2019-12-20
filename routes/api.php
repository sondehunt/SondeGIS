<?php

use Illuminate\Support\Facades\Route;

Route::post('/receive_stations', 'ReceiveStationController@store');
Route::put('/receive_stations/{receive_station}', 'ReceiveStationController@proposal');
Route::get('/receive_stations', 'ReceiveStationController@index');

Route::post('/launch_sites', 'LaunchSiteController@store');
Route::put('/launch_sites/{launch_site}', 'LaunchSiteController@proposal');
Route::get('/launch_sites', 'LaunchSiteController@index');

Route::post('/hunters', 'HunterController@store');
Route::put('/hunters/{hunter}', 'HunterController@proposal');
Route::get('/hunters', 'HunterController@index');

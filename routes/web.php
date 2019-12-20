<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index');
Route::get('/approve/launch-site/{launchSite}/{token}', 'HomeController@approveLaunchSite');
Route::get('/approve/receive-station/{receiveStation}/{token}', 'HomeController@approveReceiveStation');
Route::get('/approve/hunter/{hunter}/{token}', 'HomeController@approveHunter');

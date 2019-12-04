<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('install', 'InstallController@index')->name('install');
Route::post('install', 'InstallController@install');

Route::get('admin/update/finish', 'Admin\UpdateController@finish');

Route::group(['middleware' => 'check-installation'], function () {
    Auth::routes([
        'verify' => false,
        'register' => false
    ]);

    Route::get('/', function () {
        return 'Welcome';
    });

    Route::any('pg/callback/payir', 'PaymentController@callbackPayir')->name('pg.callback.payir');
    Route::get('pg/pay/{id}', 'PaymentController@pay')->name('pg.pay');

    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
        Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
        Route::get('live', 'Admin\DashboardController@live')->name('admin.dashboard.live');
        Route::get('live/toggle', 'Admin\DashboardController@toggleLive')->name('admin.dashboard.live.toggle');
    });
});

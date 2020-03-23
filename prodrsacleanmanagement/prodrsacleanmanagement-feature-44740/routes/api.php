<?php

use Illuminate\Routing\Router;

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
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    phpinfo();
});

Route::group(['namespace' => 'api', 'prefix' => 'v1'], function (Router $router) {

    // 認証
    Route::namespace('auth')->group(function (Router $router) {
        Route::post('/login', 'LoginAccountController@login');
    });

    // マスタ
    Route::namespace('master')->prefix('master')->group(function (Router $router) {

        // シフト関連
        Route::group(['prefix' => 'shifts'], function (Router $router) {
            Route::get('/', 'ShiftMasterController@list');
            Route::get('/{id}', 'ShiftMasterController@show');
            Route::post('/', 'ShiftMasterController@store');
            Route::put('/{id}', 'ShiftMasterController@update');
            Route::delete('/', 'ShiftMasterController@delete');
        });

        // 清掃関連
        Route::group(['prefix' => 'clean'], function (Router $router) {

            // 清掃ステータス
            Route::group(['prefix' => 'statuses'], function (Router $router) {
                Route::get('/', 'CleanStatusMasterController@list');
                Route::get('/{id}', 'CleanStatusMasterController@show');
                // Route::post('/', 'CleanStatusMasterController@store');
                Route::put('/{id}', 'CleanStatusMasterController@update');
                Route::delete('/', 'CleanStatusMasterController@delete');
            });
        });
    });
});

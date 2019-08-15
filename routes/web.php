<?php

use Blok\Mock\Mock;

if (Mock::meetEnvCondition()) {
    Route::group(["namespace" => "Blok\\Mock\\Http\\Controllers"], function () {
        Route::post(config("mock.route") . '/{table}', 'MockController@store');
        Route::any(config("mock.route") . '/{table}/create', 'MockController@store');
        Route::get(config("mock.route") . '/{table}', 'MockController@index');
        Route::any(config("mock.route") . '/{table}/{id}/update', 'MockController@update');
        Route::put(config("mock.route") . '/{table}/{id}', 'MockController@update');
        Route::get(config("mock.route") . '/{table}/{id}', 'MockController@view');
    });
}
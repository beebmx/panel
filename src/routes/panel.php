<?php

Route::group(['middleware' => 'web', 'namespace' => 'Beebmx\Panel\Http\Controllers', 'prefix' => config('panel.prefix')], function () {
    Route::get('login', 'PanelLoginController@showLoginForm')->name('panel.login');
    Route::post('login', 'PanelLoginController@login');
    Route::post('logout', 'PanelLoginController@logout')->name('panel.logout');

    Route::group(['middleware' => ['auth', 'panel'], 'as' => 'panel.'], function () {
        Route::group(['prefix' => 'api'], function () {
            Route::get('/', 'ApiController@index')->name('api.index');

            Route::get('model/{model}', 'PanelModelController@index')->name('model.index');
            Route::get('model/{model}/data', 'PanelModelController@data')->name('model.data');
            Route::get('model/{model}/{id}', 'PanelModelController@show')->name('model.show');
            Route::post('model/{model}', 'PanelModelController@store')->name('model.store');
            Route::put('model/{model}/{id}', 'PanelModelController@update')->name('model.update');
            Route::delete('model/{model}/{id}', 'PanelModelController@destroy')->name('model.destroy');
            Route::post('model/{model}/parent', 'PanelModelController@parent')->name('model.parent');

            Route::get('files/{model}/{id}', 'FilesController@all')->name('files.all');
            Route::post('files/{model}/{id}/process', 'FilesController@process')->name('files.process');
            Route::post('files/{model}/{id}/reverse', 'FilesController@reverse')->name('files.reverse');
            Route::post('files/{model}/{id?}', 'FilesController@upload')->where('id', '[0-9]+')->name('files.upload');
        });
        Route::get('/{view?}', 'PanelController@index')->where('view', '(.*)')->name('views');
    });
});

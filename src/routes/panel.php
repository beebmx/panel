<?php

Route::group(['middleware' => 'web', 'namespace' => 'Beebmx\Panel\Http\Controllers', 'prefix' => config('panel.prefix')], function () {
    Route::get('login', 'PanelLoginController@showLoginForm')->name('panel.login');
    Route::post('login', 'PanelLoginController@login');
    Route::post('logout', 'PanelLoginController@logout')->name('panel.logout');

    Route::group(['middleware' => ['auth', 'panel'], 'as' => 'panel.'], function () {
        Route::group(['prefix' => 'api'], function () {
            Route::get('/', 'ApiController@index')->name('api.index');

            Route::get('/model/{model}', 'PanelModelController@index')->name('model.index');
            Route::get('/model/{model}/data', 'PanelModelController@data')->name('model.data');
            Route::get('/model/{model}/{id}', 'PanelModelController@show')->name('model.show');

            Route::post('model/{model}', 'PanelModelController@store')->name('model.store');
            Route::put('model/{model}/{id}', 'PanelModelController@update')->name('model.update');
        });

        Route::get('/{view?}', 'PanelController@index')->where('view', '(.*)')->name('views');

        // Route::get('', 'PanelController@dashboard')->name('dashboard');

        // Route::get('model/{model}', 'PanelModelController@index')->name('model.index');
        // Route::get('model/{model}/create', 'PanelModelController@create')->name('model.create');
        // Route::post('model/{model}/{id}', 'PanelModelController@store')->name('model.store');
        // Route::get('model/{model}/{id}/edit', 'PanelModelController@edit')->name('model.edit');
        // Route::put('model/{model}/{id}', 'PanelModelController@update')->name('model.update');
        // Route::delete('model/{model}/{id}', 'PanelModelController@destroy')->name('model.delete');

        // Route::get('page/{model}', 'PanelPageController@index')->name('page.index');
    });

    /*
    Route::group(['middleware' => ['auth', 'panel'], 'as' => 'panel.'], function () {
        Route::get('', 'Beebmx\Panel\PanelController@dashboard')->name('dashboard');
        Route::get('page/{model}', 'Beebmx\Panel\PanelController@index')->name('index');
        Route::get('page/{model}/create', 'Beebmx\Panel\PanelController@create')->name('create');
        Route::post('page/{model}', 'Beebmx\Panel\PanelController@store')->name('store');
        Route::get('page/{model}/{id}', 'Beebmx\Panel\PanelController@show')->name('show');
        Route::get('page/{model}/{id}/edit', 'Beebmx\Panel\PanelController@edit')->name('edit');
        Route::put('page/{model}/{id}', 'Beebmx\Panel\PanelController@update')->name('update');
        Route::delete('page/{model}/{id}', 'Beebmx\Panel\PanelController@destroy')->name('delete');

        Route::get('page/{model}/{parent_id}/{children}', 'Beebmx\Panel\PanelController@index')->name('children.index');
        Route::get('page/{model}/{parent_id}/{children}/create', 'Beebmx\Panel\PanelController@create')->name('children.create');
        Route::post('page/{model}/{parent_id}/{children}', 'Beebmx\Panel\PanelController@store')->name('children.store');
        Route::get('page/{model}/{parent_id}/{children}/{id}', 'Beebmx\Panel\PanelController@show')->name('children.show');
        Route::get('page/{model}/{parent_id}/{children}/{id}/edit', 'Beebmx\Panel\PanelController@edit')->name('children.edit');
        Route::put('page/{model}/{parent_id}/{children}/{id}', 'Beebmx\Panel\PanelController@update')->name('children.update');
        Route::delete('page/{model}/{parent_id}/{children}/{id}', 'Beebmx\Panel\PanelController@destroy')->name('children.delete');

        Route::post('file/upload', 'Beebmx\Panel\FileController@upload')->name('upload');
    });
    */
});

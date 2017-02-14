<?php

Route::group(['middleware' => 'web', 'prefix' => config('panel.prefix')], function() {
    Route::get('login', 'Beebmx\Panel\LoginController@showLoginForm')->name('panel.login');
    Route::post('login', 'Beebmx\Panel\LoginController@login')->name('panel.login');
    Route::post('logout', 'Beebmx\Panel\LoginController@logout')->name('panel.logout');
        
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
});
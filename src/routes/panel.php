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
    
    /*
    OLD PANEL ROUTES
    Route::group(['middleware' => ['auth']], function () {
		Route::get('', 'Panel\PanelController@dashboard')->name('dashboard');
		
		Route::get('cms/{model}', 'Panel\CmsController@index')->name('cms.index');
		Route::get('cms/{model}/create', 'Panel\CmsController@create')->name('cms.new');
		Route::post('cms/{model}', 'Panel\CmsController@store')->name('cms.store');
		Route::get('cms/{model}/{id}', 'Panel\CmsController@show')->name('cms.show');
		Route::get('cms/{model}/{id}/edit', 'Panel\CmsController@edit')->name('cms.edit');
		Route::put('cms/{model}/{id}', 'Panel\CmsController@update')->name('cms.update');
		Route::delete('cms/{model}/{id}', 'Panel\CmsController@destroy')->name('cms.delete');
		
		Route::post('cms/upload/{model}/{storage}/{id}', 'Panel\FileController@upload')->name('cms.upload');
	});
	*/
    
    /*
    DEFAULT LARAVEL ROUTES
    
    // Authentication Routes...
    //$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    //$this->post('login', 'Auth\LoginController@login');
    //$this->post('logout', 'Auth\LoginController@logout');

    // Registration Routes...
    //$this->get('register', 'Auth\RegisterController@showRegistrationForm');
    //$this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    //$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    //$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    //$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    //$this->post('password/reset', 'Auth\ResetPasswordController@reset');
    */
    
});
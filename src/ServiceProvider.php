<?php

namespace Beebmx\Panel;

use View;
use Auth;
use Beebmx\Panel\Blueprint;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
class ServiceProvider extends BaseServiceProvider{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/panel.php' => config_path('panel.php'),
            __DIR__.'/middleware/' => app_path('Http/Middleware/'),
            __DIR__.'/assets/css/login.min.css' => public_path('panel_assets/css/login.min.css'),
            __DIR__.'/assets/css/panel.min.css' => public_path('panel_assets/css/panel.min.css'),
            __DIR__.'/assets/js/login.min.js' => public_path('panel_assets/js/login.min.js'),
            __DIR__.'/assets/js/panel.min.js' => public_path('panel_assets/js/panel.min.js'),
            __DIR__.'/assets/js/panel/tinymce_es_MX.min.js' => public_path('panel_assets/js/tinymce_es_MX.min.js'),
            __DIR__.'/assets/js/fields/moment-with-locales.js' => public_path('panel_assets/js/moment-with-locales.js'),
            __DIR__.'/assets/js/fields/bootstrap-datetimepicker.min.js' => public_path('panel_assets/js/bootstrap-datetimepicker.min.js'),
            __DIR__.'/models/' => app_path(),
            __DIR__.'/blueprint/' => app_path('Panel/Blueprints/'),
            __DIR__.'/seeds/' => database_path('seeds'),
            __DIR__.'/assets/images/' => public_path('panel_assets/images/'),
            __DIR__.'/assets/fonts/' => public_path('panel_assets/fonts/'),
        ], 'config');
        
        $this->publishes([
            __DIR__.'/assets/fonts/' => resource_path('assets/fonts/'),
            __DIR__.'/assets/scss/' => resource_path('assets/sass/panel/'),
        ], 'source');
        
        $this->loadMigrationsFrom(__DIR__ . '/migrations');
        $this->loadViewsFrom(__DIR__ . '/views', 'panel');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'panel');
        
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes/panel.php';
        }
        
        View::composer(['panel::layouts.panel'], function ($view) {
            $profile = $profile = Auth::user()->profile;
            $admin = (int)$profile->is_admin ? true : false;
            if (config('panel.sidebarOrder')){
                View::share('models', collect(Blueprint::getAllModels($admin))->sortBy('sidebarOrder'));
            }else{
                View::share('models', collect(Blueprint::getAllModels($admin))->sortBy('name'));
            }
        });
        
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CreateBlueprint::class,
                Commands\CreateField::class,
                Commands\LoadFiles::class,
                Commands\ShowVersion::class,
            ]);
        }
    }
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/panel.php', 'panel'
        );
    }
}
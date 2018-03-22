<?php

namespace Beebmx\Panel;

use View;
use Auth;
use Beebmx\Panel\Blueprint;
use Beebmx\Panel\Middleware\PanelMiddleware;
use Illuminate\Support\ServiceProvider;

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
class PanelServiceProvider extends ServiceProvider{
    public function boot()
    {
        $this->registerMiddleware();
        $this->registerRoutes();
        $this->registerResources();
        //$this->registerViewShare();
    }
    
    public function register()
    {
        $this->configure();
        $this->offerPublishing();
        $this->registerCommands();
        
    }

    protected function registerMiddleware()
    {
        $this->app['router']->aliasMiddleware('panel', Http\Middleware\Panel::class);
        $this->app['router']->aliasMiddleware('guest.panel', Http\Middleware\RedirectIfAuthenticated::class);
    }

    protected function registerRoutes()
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes/panel.php';
        }
    }

    protected function registerResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'panel');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'panel');
    }

    protected function registerViewShare()
    {
        View::composer(['panel::layouts.panel'], function ($view) {
            $profile = $profile = Auth::user()->profile;
            $admin = (int)$profile->is_admin ? true : false;
            if (config('panel.sidebarOrder')){
                View::share('models', Blueprint::getListModels($admin)->groupBy('type')->sortBy('sidebarOrder'));
                //View::share('models', collect(Blueprint::getAllModels($admin))->groupBy('type')->sortBy('sidebarOrder'));
            }else{
                View::share('models', Blueprint::getListModels($admin)->groupBy('type')->sortBy('name'));
                //View::share('models', collect(Blueprint::getAllModels($admin))->groupBy('type')->sortBy('name'));
            }
        });
    }

    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/panel.php', 'panel'
        );
    }

    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__.'/config/panel.php' => config_path('panel.php'),
            __DIR__.'/panel/Profile.php' => app_path('Profile.php'),
            __DIR__.'/blueprint/' => app_path('Panel/Blueprints/'),
            __DIR__.'/database/seeds/' => database_path('seeds'),
            __DIR__.'/resources/dist/css/' => public_path('css/'),
            __DIR__.'/resources/dist/js/' => public_path('js/'),
            __DIR__.'/resources/assets/images/' => public_path('images/'),
        ], 'config');

        /*
        $this->publishes([
            __DIR__.'/assets/fonts/' => resource_path('assets/fonts/'),
            __DIR__.'/assets/scss/' => resource_path('assets/sass/panel/'),
        ], 'source');
        */
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\PanelMake::class,
                Console\CreateBlueprint::class,
                Console\CreateField::class,
                Console\LoadFiles::class,
                Console\ShowVersion::class,
            ]);
        }
    }
}
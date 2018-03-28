<?php

namespace Partymeister\Frontend\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Partymeister\Slides\Console\Commands\PartymeisterSlidesGenerateCompetitionCommand;
use Partymeister\Slides\Console\Commands\PartymeisterSlidesGenerateEntryCommand;

class PartymeisterServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->config();
        $this->routes();
        $this->routeModelBindings();
        $this->translations();
        $this->views();
        $this->navigationItems();
        $this->permissions();
        $this->registerCommands();
        $this->migrations();
        $this->publishResourceAssets();
    }


    public function config()
    {
        //$this->mergeConfigFrom(__DIR__ . '/../../config/partymeister-slides-fonts.php', 'partymeister-slides-fonts');
    }


    public function publishResourceAssets()
    {
        //$assets = [
        //    __DIR__ . '/../../resources/assets/images' => public_path('images'),
        //    __DIR__ . '/../../resources/assets/css' => resource_path('assets/css'),
        //    __DIR__ . '/../../resources/assets/js'  => resource_path('assets/js'),
        //];
        //
        //$this->publishes($assets, 'partymeister-frontend-install');
    }


    public function registerCommands()
    {
    }


    public function migrations()
    {
        //$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }


    public function permissions()
    {
    }


    public function routes()
    {
        if ( ! $this->app->routesAreCached()) {
            require __DIR__ . '/../../routes/web.php';
            //require __DIR__ . '/../../routes/api.php';
        }
    }


    public function translations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'partymeister-frontend');

        $this->publishes([
            __DIR__ . '/../../resources/lang' => resource_path('lang/vendor/partymeister-frontend'),
        ], 'partymeister-frontend-translations');
    }


    public function views()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'partymeister-frontend');

        $this->publishes([
            __DIR__ . '/../../resources/views' => resource_path('views/vendor/partymeister-frontend'),
        ], 'partymeister-frontend-views');
    }


    public function routeModelBindings()
    {
    }


    public function navigationItems()
    {
    }
}

<?php

namespace Christoxz\InfiniteflightLive;

use Illuminate\Support\ServiceProvider;

class InfiniteflightLiveServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'christoxz');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'christoxz');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/infiniteflight-live.php', 'infiniteflight-live');

        // Register the service the package provides.
        $this->app->singleton('infiniteflight-live', function ($app) {
            return new InfiniteflightLive;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['infiniteflight-live'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole(): void
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/infiniteflight-live.php' => config_path('infiniteflight-live.php'),
        ], 'infiniteflight-live.config');

        // Publishing the views.
        /*$this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/christoxz'),
        ], 'infiniteflight-live.views');*/

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/christoxz'),
        ], 'infiniteflight-live.assets');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/christoxz'),
        ], 'infiniteflight-live.lang');*/

        // Registering package commands.
        // $this->commands([]);
    }
}

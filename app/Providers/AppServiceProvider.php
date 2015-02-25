<?php

namespace Tinyissue\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * This service provider is a great spot to register your various container
     * bindings with the application. As you can see, we are registering our
     * "Registrar" implementation here. You can add your own bindings too!
     */
    public function register()
    {
        $this->app->bind(
                'Illuminate\Contracts\Auth\Registrar', 'Tinyissue\Services\Registrar'
        );

        $this->app['artisan.tinyissue.install'] = $this->app->share(function ($app) {
            return new \Tinyissue\Console\Commands\Install();
        });

        $this->commands('artisan.tinyissue.install');
    }
}
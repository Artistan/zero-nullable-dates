<?php
namespace Artistan\ZeroNullDates;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/path/to/migrations');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Service::class, function () {
            return new Service;
        });
    }
}
<?php

namespace Artistan\ZeroNullDates\Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__.'/../vendor/laravel/laravel/bootstrap/app.php';
        $app->useEnvironmentPath(realpath(__DIR__));
        $app->useDatabasePath(realpath(__DIR__.'/Database'));

        $app->make(Kernel::class)->bootstrap();

        $app['config']->set('database.connections.mysql.strict', false);

        return $app;
    }
}

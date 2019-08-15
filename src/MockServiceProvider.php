<?php

namespace Blok\Mock;

use Illuminate\Support\ServiceProvider;

class MockServiceProvider extends ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/mock.php';

    public function boot()
    {
        $this->publishes([
            self::CONFIG_PATH => config_path('mock.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'mock'
        );

        $this->app->bind('mock', function() {
            return new Mock();
        });

        $this->loadRoutesFrom(__DIR__ . "/../routes/web.php");
    }
}

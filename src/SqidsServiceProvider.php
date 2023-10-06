<?php

namespace ErikSulymosi\EloquentSqids;

use Illuminate\Support\ServiceProvider;

class SqidsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/sqids.php' => config_path('sqids.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/sqids.php', 'sqids');

        $this->app->singleton('sqids', function ($app) {
            return new SqidsManager($app);
        });
    }
}
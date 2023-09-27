<?php

namespace ErikSulymosi\EloquentSqids\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Sqids\Laravel\SqidsServiceProvider;

class TestCase extends Orchestra 
{
	protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->app['config']->set('sqids', require 'config/sqids.php');
    }

    protected function getPackageProviders($app)
    {
        return [
            SqidsServiceProvider::class,
        ];
    }
}

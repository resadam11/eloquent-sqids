<?php

namespace ErikSulymosi\EloquentSqids\Tests;

use ErikSulymosi\EloquentSqids\SqidsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra 
{
	protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            SqidsServiceProvider::class,
        ];
    }
}

<?php

namespace ErikSulymosi\EloquentSqids\Facades;

use Illuminate\Support\Facades\Facade;

class Sqids extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'sqids';
    }
}
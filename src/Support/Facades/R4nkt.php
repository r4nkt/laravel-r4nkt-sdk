<?php

namespace R4nkt\LaravelR4nkt\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \R4nkt\LaravelR4nkt\LaravelR4nkt
 */
class R4nkt extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-r4nkt-sdk';
    }
}

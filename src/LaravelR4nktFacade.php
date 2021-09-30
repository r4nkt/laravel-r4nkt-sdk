<?php

namespace R4nkt\\LaravelR4nkt\LaravelR4nkt;

use Illuminate\Support\Facades\Facade;

/**
 * @see \R4nkt\\LaravelR4nkt\LaravelR4nkt\LaravelR4nkt
 */
class LaravelR4nktFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-r4nkt-sdk';
    }
}

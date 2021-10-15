<?php

namespace Meetjet\LaravelCentrifugo;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Meetjet\LaravelCentrifugo\LaravelCentrifugo
 */
class LaravelCentrifugoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-centrifugo';
    }
}

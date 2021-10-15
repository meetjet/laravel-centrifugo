<?php

declare(strict_types=1);

namespace Meetjet\LaravelCentrifugo;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Meetjet\LaravelCentrifugo\LaravelCentrifugo
 */
class LaravelCentrifugoFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'centrifugo';
    }
}

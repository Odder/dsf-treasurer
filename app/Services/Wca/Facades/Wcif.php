<?php

namespace App\Services\Wca\Facades;

use Illuminate\Support\Facades\Facade;

class Wcif extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'wcif-service';
    }
}

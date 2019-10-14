<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JDD Facade
 *
 *
 * @method \App\JDD\Module[] getModules() Get active modules
 */
class JDD extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'JDD';
    }
}

<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * JDD Facade
 *
 * @author David Callizaya <davidcallizaya@gmail.com>
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

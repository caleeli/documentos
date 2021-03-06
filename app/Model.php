<?php

namespace App;

use App\Traits\StandardDateTimeTrait;
use Illuminate\Database\Eloquent\Model as ModelBase;

/**
 * Clase Model Base
 *
 */
class Model extends ModelBase
{
    use StandardDateTimeTrait;
}

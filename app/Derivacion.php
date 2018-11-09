<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Derivacion
 *
 */
class Derivacion extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'derivacion';

}

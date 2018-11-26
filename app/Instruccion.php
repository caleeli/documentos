<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Instrucciones de derivacion
 *
 */
class Instruccion extends Model
{

    use AutoTableTrait;

    public $timestamps = false;
    protected $connection = 'hr';
    protected $table = 'instrucciones';

}

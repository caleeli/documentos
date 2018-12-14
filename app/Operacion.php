<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 */
class Operacion extends Model
{

    use AutoTableTrait;

    protected $primaryKey = 'id';
    public $incrementing = true;

    public $timestamps = false;
    protected $connection = 'hr';
    protected $table = 'operaciones';

}

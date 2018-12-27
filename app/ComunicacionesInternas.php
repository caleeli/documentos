<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Comunicaciones Internas
 *
 */
class ComunicacionesInternas extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'comunicaciones_internas';
    protected $fillable = ["*"];
    protected $appends = [
    ];
    protected $dispatchesEvents = [
        //'creating' => [self::class, 'creatingNota'],
    ];

}

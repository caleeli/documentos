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

    public $timestamps = false;
    protected $connection = 'hr';
    protected $table = 'derivacion';
    protected $fillable = [
        "fecha",
        "comentarios",
        "destinatario",
        "instruccion",
        "dias_plazo",
        "hoja_ruta_id",
        "firma",
    ];
    protected $casts = [
        'fecha' => 'date',
    ];

}

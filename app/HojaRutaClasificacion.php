<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Clasificacion de Hojas de Ruta
 *
 */
class HojaRutaClasificacion extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'hoja_ruta_clasificacion';

}

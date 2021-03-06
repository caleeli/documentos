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

    protected $table = 'hoja_ruta_clasificacion';
    protected $guarded = [];
    public $timestamps = false;

    public function subclases()
    {
        return $this->hasMany(HojaRutaSubClases::class, 'clasificacion_id');
    }
}

<?php

namespace App;

use App\Rules\UntilToday;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of Derivacion
 *
 */
class Derivacion extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $table = 'derivacion';
    protected $fillable = [
        "fecha",
        "comentarios",
        "destinatario",
        "destinatarios",
        "instruccion",
        "dias_plazo",
        "hoja_ruta_id",
        "firma",
    ];
    protected $casts = [
        'fecha' => 'date',
    ];

    /**
     * Reglas de validacion para la derivacion.
     *
     * @return array
     */
    protected function getRules()
    {
        $rules = parent::getRules();
        $rules['fecha'][] = new UntilToday();
        return $rules;
    }
    
    public function hoja_ruta()
    {
        return $this->belongsTo(HojaRuta::class, 'hoja_ruta_id', 'hr_id');
    }
}

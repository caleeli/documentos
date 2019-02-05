<?php

namespace App;

use App\Rules\UntilToday;

/**
 * Description of Derivacion
 *
 */
class Derivacion extends Model
{

    public $timestamps = false;
    protected $connection = 'hr';
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
}

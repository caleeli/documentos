<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Description of Reporte
 *
 */
class Reporte extends Model
{

    use AutoTableTrait;

    protected $connection = 'hr';
    protected $table = 'reportes';
    protected $fillable = [
        'tipo',
        'recepcion_desde',
        'recepcion_hasta',
        'referencia',
        'procedencia',
        'nro_de_control',
        'conclusion_desde',
        'conclusion_hasta',
        'gestion_desde',
        'gestion_hasta',
        'destinatario',
        'tipo_tarea',
        'tipo_reporte',
    ];
    protected $casts = [
        'recepcion_desde' => 'date',
        'recepcion_hasta' => 'date',
        'conclusion_desde' => 'date',
        'conclusion_hasta' => 'date',
    ];

}

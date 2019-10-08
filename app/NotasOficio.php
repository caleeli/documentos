<?php

namespace App;

use App\Traits\AutoTableTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Notas oficio
 *
 */
class NotasOficio extends Model
{

    protected $table = 'notas_oficio';
    public $timestamps = false;
    protected $fillable = [
        'hoja_de_ruta',
        'fecha_emision',
        'nro_nota',
        'reiterativa',
        'fecha_entrega',
        'entidad_empresa',
        'nombre_apellidos',
        'cargo',
        'referencia',
        'dias',
        'retraso',
        'observaciones',
        'hoja_de_ruta_recepcion',
        'fecha_recepcion',
        'nro_nota_recepcion',
        'remitente_recepcion',
        'referencia_recepcion',
        'fojas_recepcion',
        'gestion',
    ];
    protected $appends = [
    ];
    protected $dispatchesEvents = [
        //'creating' => [self::class, 'creatingNota'],
    ];

}

<?php

namespace App;

use App\Traits\CorrelativoTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Notas oficio
 *
 */
class NotasOficio extends Model
{
    use CorrelativoTrait;

    protected $table = 'notas_oficio';
    protected $correlativos = [
        'nro_nota' => [],
    ];

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

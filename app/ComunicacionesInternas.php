<?php

namespace App;

use App\Traits\CorrelativoTrait;
use App\Traits\SaveUserTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comunicaciones Internas
 *
 */
class ComunicacionesInternas extends Model
{
    use CorrelativoTrait;
    use SaveUserTrait;
    use SoftDeletes;

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_modificacion';
    const DELETED_AT = 'fecha_baja';

    protected $primaryKey = 'id';
    protected $table = 'comunicaciones_internas';
    protected $correlativos = [
        'nro_nota' => [],
    ];
    protected $fillable = [
        'hoja_de_ruta',
        'fecha_emision',
        'nro_nota',
        'reiterativa',
        'fecha_entrega',
        'gerencia_subcontraloria',
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

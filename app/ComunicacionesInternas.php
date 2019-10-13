<?php

namespace App;

use App\Traits\CorrelativoTrait;
use App\Traits\SaveUserTrait;
use App\Traits\ValidatedModelTrait;
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
    use ValidatedModelTrait;

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
    protected $attributes = [
        'hoja_de_ruta' => null,
        'fecha_emision' => '',
        'nro_nota' => '',
        'reiterativa' => '',
        'fecha_entrega' => '',
        'gerencia_subcontraloria' => '',
        'nombre_apellidos' => '',
        'cargo' => '',
        'referencia' => '',
        'dias' => '',
        'retraso' => '',
        'observaciones' => '',
        'hoja_de_ruta_recepcion' => '',
        'fecha_recepcion' => '',
        'nro_nota_recepcion' => '',
        'remitente_recepcion' => '',
        'referencia_recepcion' => '',
        'fojas_recepcion' => '',
        'gestion' => '',
    ];
    protected $appends = [
    ];
    protected $dispatchesEvents = [
        //'creating' => [self::class, 'creatingNota'],
    ];

    public function getRules()
    {
        return [
            'hoja_de_ruta' => ['required'],
            'fecha_emision' => ['required'],
            //'nro_nota' => ['required'],
            'reiterativa' => ['required'],
            'fecha_entrega' => ['required'],
            'gerencia_subcontraloria' => ['required'],
            'nombre_apellidos' => ['required'],
            'cargo' => ['required'],
            'referencia' => ['required'],
            //'fecha_recepcion' => ['required'],
            //'nro_nota_recepcion' => ['required'],
        ];
    }
}
